<?php

namespace App\Models;

class StudentReviewModel
{
    public function getTopTestimonials()
    {
        $conn = new \mysqli("localhost", "root", "", "eguru");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT sf.student_feedback, st.student_first_name, st.student_last_name, st.student_profile_photo
                FROM session_feedback sf
                JOIN session s ON sf.session_id = s.session_id
                JOIN student st ON s.student_id = st.student_id
                WHERE sf.session_rating >= 3
                LIMIT 10";

        $result = $conn->query($sql);
        $data = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $conn->close();
        return $data;
    }
}
