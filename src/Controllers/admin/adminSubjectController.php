<?php

namespace App\Controllers\admin;

use App\Models\admin\adminSubjectModel;

class adminSubjectController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); // Redirect to login page if not logged in
            exit();
        } 
        $this->model = new adminSubjectModel();
    }

    // Show all subjects
    public function showAllSubjects() {
        // Fetch all subjects
        $subjects = $this->model->getAllSubjects();

        // Include the view and pass the data
        require_once __DIR__ . '/../../Views/admin/AdminSubjects.php';
    }

    private function redirectWithSuccess() {
        header("Location: /admin-subjects");
        exit();
    }

    private function handleError($message) {
        echo "<script>
                alert('" . addslashes($message) . "');
                window.location.href = '../../dashboard.php#add-subject';
              </script>";
        exit();
    }

    // Handle adding a new subject
    public function addSubject()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form inputs
            $subjectName = $_POST['subject_name'] ?? '';
            $file = $_FILES['subjectIcon'] ?? null;

            // Check if the subject already exists
            if ($this->model->subjectExists($subjectName)) {
                echo "<script>alert('Subject already exists.')
                window.location.href = '/admin-subjects';
                </script>";                
                exit;
            }

            if (empty($subjectName)) {
                echo "<script>alert('Subject name is required.')</script>";
                return;
            }

            if ($file && $file['error'] === 0) {
                $uploadDir = 'uploads/';
                $fileName = basename($file['name']);
                $targetFilePath = $uploadDir . $fileName;

                // Move uploaded file
                if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    // Prepare data for the database
                    $subjectData = [
                        'subject_name' => $subjectName,
                        'subject_display_pic' => $fileName,
                    ];

                    // Save data via the model
                    $this->model->insertSubject($subjectData);
                    echo "<script>alert('Subject added successfully.')</script>";
                    header("Location: /admin-subjects");
                } else {
                    echo "<script>alert('Failed to upload file.')</script>";
                    return;
                }
            } else {
                echo "<script>alert('File upload is required.')</script>";
            }
        } else {
            echo "<script>alert('Invalid request.')</script>";
        }
    }

    public function updateSubject()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form inputs
            $subjectId = $_POST['subject_id'] ?? null;
            $subjectName = $_POST['subject_name'] ?? '';
            $file = $_FILES['subjectIcon'] ?? null;

            // Validate inputs
            if (empty($subjectId)) {
                echo "<script>alert('Invalid subject ID.')</script>";
                return;
            }

            if (empty($subjectName)) {
                echo "<script>alert('Subject name is required.')</script>";
                return;
            }

            // Prepare data for update
            $updateData = [
                'subject_id' => $subjectId,
                'subject_name' => $subjectName
            ];

            // Handle file upload if present
            if ($file && $file['error'] === 0) {
                $uploadDir = 'uploads/';
                $fileName = basename($file['name']);
                $targetFilePath = $uploadDir . $fileName;

                // Move the uploaded file
                if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    $updateData['subject_display_pic'] = $fileName;
                } else {
                    echo "<script>alert('Failed to upload file.')</script>";
                    return;
                }
            }

            // Attempt to update the subject
            if ($this->model->updateSubject($updateData)) {
                echo "<script>
                    alert('Subject updated successfully.');
                    window.location.href = '/admin-subjects';
                </script>";
            } else {
                echo "<script>
                    alert('Failed to update subject. Please try again.');
                    window.location.href = '/admin-subjects';
                </script>";
            }
        } else {
            echo "<script>alert('Invalid request.')</script>";
        }
    }

    //delete subject
    public function deleteSubject() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Parse JSON input
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $subjectId = $data['subject_id'] ?? null;
    
            header('Content-Type: application/json');
            
            if ($subjectId && $this->model->unsetSubject($subjectId)) {
                echo json_encode(['success' => true, 'message' => 'Subject status updated to unset.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update subject status.']);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }
    
    //get deleted subjects
    public function getDeletedSubjects() {
        $deletedSubjects = $this->model->getUnsetSubjects();
        require_once __DIR__ . '/../../Views/admin/AdminSubjects.php';
    }

    //restore subject
    public function restoreSubject() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Parse JSON input
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $subjectId = $data['subject_id'] ?? null;
    
            header('Content-Type: application/json');
    
            if (!$subjectId) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Subject ID is required.'
                ]);
                return;
            }
    
            try {
                // Call model method to restore the subject
                if ($this->model->setSubject($subjectId)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Subject restored successfully.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to restore subject.'
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'An error occurred while restoring the subject: ' . $e->getMessage()
                ]);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
    }
}