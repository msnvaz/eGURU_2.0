<?php
require 'TutorFilterModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filters = [
        'grade' => $_POST['grade'] ?? '',
        'subject' => $_POST['subject'] ?? '',
        'experience' => $_POST['experience'] ?? '',
        'rating' => $_POST['rating'] ?? '',
        'session_count' => $_POST['session_count'] ?? '',
        'availability' => $_POST['availability'] ?? ''
    ];

    $model = new TutorFilterModel();
    $tutors = $model->getTutors($filters);
    
    echo json_encode($tutors);
}
?>
