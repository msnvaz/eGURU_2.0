<?php

namespace App\Models\student;

use App\Config\Database;
use Exception;
use PDOException;
use PDO;

$GLOBALS['env'] = require __DIR__ . '/../../Config/env.php';

class StudentTutorRequestFormModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    //available time slots filtered with upcoming sessions
    public function getAvailableTimeSlots($tutor_id,$student_id) {
        $query ="
       SELECT
            ta.tutor_id,
            t.tutor_first_name,
            t.tutor_last_name,
            sa.student_id,
            s.student_first_name,
            s.student_last_name,
            ta.day,
            CONCAT(ts.starting_time, ':00') as starting_time,
            CONCAT(ts.ending_time, ':00') as ending_time,
            ta.time_slot_id
        FROM
            tutor_availability ta
        INNER JOIN
            student_availability sa ON sa.time_slot_id = ta.time_slot_id AND sa.day = ta.day
        INNER JOIN
            tutor t ON t.tutor_id = ta.tutor_id
        INNER JOIN
            student s ON s.student_id = sa.student_id
        INNER JOIN
            time_slot ts ON ts.time_slot_id = ta.time_slot_id
        WHERE
            ta.tutor_id = :tutor_id AND
            sa.student_id = :student_id AND
            NOT EXISTS (
                SELECT 1
                FROM session sess
                WHERE
                    sess.tutor_id = ta.tutor_id AND
                    sess.student_id = sa.student_id AND
                    sess.session_status IN ('scheduled', 'requested') AND
                    DATE_FORMAT(sess.scheduled_date, '%W') = ta.day AND
                    (
                        (HOUR(sess.schedule_time) >= ts.starting_time AND HOUR(sess.schedule_time) < ts.ending_time) OR
                        (HOUR(sess.schedule_time) < ts.starting_time AND (HOUR(sess.schedule_time) + 2) > ts.starting_time)
                    )
            )
        ORDER BY
            FIELD(ta.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
            ts.starting_time";
        $params = [
            ':tutor_id' => $tutor_id,
            ':student_id' => $student_id
        ];
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //get tutor subjects from tutor_subject table and subject table
    //get tutor level id from tutor table and get the tutor level (name),tutor_pay_per_hour from level table
    public function getTutorSubjects($tutor_id) {
        $query = "
        SELECT 
            ts.tutor_id,
            t.tutor_first_name,
            t.tutor_last_name,
            s.subject_name,
            s.subject_id,
            l.tutor_level,
            l.tutor_pay_per_hour
        FROM 
            tutor_subject ts
        INNER JOIN 
            subject s ON ts.subject_id = s.subject_id
        INNER JOIN 
            tutor t ON ts.tutor_id = t.tutor_id
        INNER JOIN 
            tutor_level l ON t.tutor_level_id = l.tutor_level_id
        WHERE 
            ts.tutor_id = :tutor_id
        GROUP BY 
            ts.tutor_id, s.subject_name, l.tutor_level, l.tutor_pay_per_hour
        ORDER BY 
            s.subject_name, l.tutor_level";
        $params = [
            ':tutor_id' => $tutor_id
        ];
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //get the next possible session day and time slot for a given time slot id and day within the next 7 days
    public function getNextSessionDate($time_slot_id, $day) {
        $query = "
        SELECT 
            ts.starting_time,
            ts.ending_time,
            DATE_ADD(CURDATE(), INTERVAL (7 + (7 - WEEKDAY(CURDATE()) + :day)) % 7 DAY) AS next_session_date
        FROM 
            time_slot ts
        WHERE 
            ts.time_slot_id = :time_slot_id";
        $params = [
            ':time_slot_id' => $time_slot_id,
            ':day' => $day
        ];
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Replace the existing getZoomAccessToken function with this improved version
    private function getZoomAccessToken() {
        try {
            // Ensure the path is correct for your project structure
            $envPath = __DIR__ . '/../../Config/env.php';
            
            if (!file_exists($envPath)) {
                error_log("Environment file not found at: " . $envPath);
                return null;
            }
            
            $env = require $envPath;
            
            // Debug what credentials are available
            error_log("Checking Zoom credentials - client_id exists: " . (isset($env['zoom_client_id']) ? 'yes' : 'no'));
            error_log("Checking Zoom credentials - client_secret exists: " . (isset($env['zoom_client_secret']) ? 'yes' : 'no'));
            error_log("Checking Zoom credentials - account_id exists: " . (isset($env['zoom_account_id']) ? 'yes' : 'no'));
            
            if (!isset($env['zoom_client_id']) || !isset($env['zoom_client_secret']) || !isset($env['zoom_account_id'])) {
                error_log("Zoom credentials are missing in the environment configuration");
                return null;
            }
            
            $clientId = $env['zoom_client_id'];
            $clientSecret = $env['zoom_client_secret'];
            $accountId = $env['zoom_account_id'];
            
            // For server-to-server OAuth, we need to use the OAuth token endpoint
            $url = 'https://zoom.us/oauth/token';
            $credentials = base64_encode($clientId . ':' . $clientSecret);
            
            $postFields = http_build_query([
                'grant_type' => 'account_credentials',
                'account_id' => $accountId
            ]);
            
            // Initialize cURL session
            $ch = curl_init($url);
            
            // Set cURL options
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Basic ' . $credentials,
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            
            // Enable verbose debugging
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
            
            // Execute the request
            $response = curl_exec($ch);
            
            // Check for cURL errors
            if (curl_errno($ch)) {
                $curlError = curl_error($ch);
                error_log("cURL Error: " . $curlError);
                
                // Log verbose information for debugging
                rewind($verbose);
                $verboseLog = stream_get_contents($verbose);
                error_log("Verbose cURL log: " . $verboseLog);
                
                curl_close($ch);
                return null;
            }
            
            // Get HTTP status code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            // Decode the response
            $responseData = json_decode($response, true);
            
            if ($httpCode !== 200 || !isset($responseData['access_token'])) {
                error_log("Failed to get Zoom access token. HTTP Code: " . $httpCode);
                error_log("Response: " . $response);
                return null;
            }
            
            error_log("Successfully obtained Zoom access token");
            return $responseData['access_token'];
        } catch (Exception $e) {
            error_log("Exception in getZoomAccessToken: " . $e->getMessage());
            return null;
        }
    }

    // Update the createZoomMeeting function to properly use the class method
    private function createZoomMeeting($scheduled_date, $schedule_time) {
        try {
            $accessToken = $this->getZoomAccessToken();  // Properly call the class method

            if (!$accessToken) {
                error_log("Failed to get Zoom access token, using placeholder meeting link");
                return "https://zoom.us/meeting/placeholder";
            }

            // Format the date and time
            $start_time = date('Y-m-d\TH:i:s\Z', strtotime("$scheduled_date $schedule_time"));

            $data = [
                'topic' => 'Tutor Session',
                'type' => 2, // Scheduled meeting
                'start_time' => $start_time,
                'duration' => 120, // 2 hours
                'timezone' => 'Asia/Colombo',
                'agenda' => 'Tutoring session',
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false,
                    'mute_upon_entry' => true,
                    'approval_type' => 0,
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.zoom.us/v2/users/me/meetings');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                error_log("cURL error in createZoomMeeting: " . curl_error($ch));
                curl_close($ch);
                return "https://zoom.us/meeting/placeholder";
            }
            
            curl_close($ch);

            $responseData = json_decode($response, true);

            if (isset($responseData['join_url'])) {
                return $responseData['join_url']; // Zoom Meeting Link
            } else {
                error_log("Failed to create Zoom meeting: " . json_encode($responseData));
                return "https://zoom.us/meeting/placeholder";
            }
        } catch (Exception $e) {
            error_log("Exception in createZoomMeeting: " . $e->getMessage());
            return "https://zoom.us/meeting/placeholder";
        }
    }

    //insert student_id,tutor_id,scheduled_date,schedule_time,session_status,subject_id to session table
    public function insertSession($student_id, $tutor_id, $scheduled_date, $schedule_time, $session_status, $subject_id) {
        try {
            // Format the time properly if needed
            if (strpos($schedule_time, ' - ') !== false) {
                $schedule_time = trim(explode(' - ', $schedule_time)[0]);
            }
            
            // Make sure time is in proper format (HH:MM:SS)
            if (strpos($schedule_time, ':') !== false && substr_count($schedule_time, ':') === 1) {
                $schedule_time .= ':00';  // Add seconds if missing
            }
    
            try {
                // Try to create a Zoom meeting link
                $zoom_link = $this->createZoomMeeting($scheduled_date, $schedule_time);
                error_log("Created Zoom link: " . $zoom_link);
            } catch (Exception $e) {
                // Use a fallback if Zoom API fails
                error_log("Error creating Zoom meeting: " . $e->getMessage());
                $zoom_link = "https://zoom.us/meeting/placeholder";
            }
            
            $query = "
            INSERT INTO session (student_id, tutor_id, scheduled_date, schedule_time, session_status, subject_id, meeting_link)
            VALUES (:student_id, :tutor_id, :scheduled_date, :schedule_time, :session_status, :subject_id, :zoom_link)";
            $params = [
                ':student_id' => $student_id,
                ':tutor_id' => $tutor_id,
                ':scheduled_date' => $scheduled_date,
                ':schedule_time' => $schedule_time,
                ':session_status' => $session_status,
                ':subject_id' => $subject_id,
                ':zoom_link' => $zoom_link
            ];
            
            // For debugging
            error_log("Inserting session with data: " . json_encode($params));
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database error in insertSession: " . $e->getMessage());
            return false;
        }
    }
}