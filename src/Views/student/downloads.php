<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "download";
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloads</title>
    <link rel="stylesheet" href="/css/student/downloads.css">
    <link rel="stylesheet" href="/css/student/nav.css">
    <link rel="stylesheet" href="/css/student/sidebar.css">
</head>
<body>
    
    <?php include '../src/Views/student/sidebar.php'; ?>
    
    <div class="download-bodyform">
        <div id="download-content">
            <h1>Download Study Materials</h1><br>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']); ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <div class="selection">
                <label for="tutor">Tutor:</label>
                <select id="tutor">
                    <option value="">All Tutors</option>
                    <?php foreach ($completedTutors as $tutor): ?>
                        <option value="<?= htmlspecialchars($tutor['tutor_id']) ?>">
                            <?= htmlspecialchars($tutor['first_name'] . ' ' . $tutor['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <br><br>
                <label for="subject">Subject:</label>
                <select id="subject">
                    <option value="">All Subjects</option>
                    <?php foreach ($completedSubjects as $subject): ?>
                        <option value="<?= htmlspecialchars($subject['subject_id']) ?>">
                            <?= htmlspecialchars($subject['subject_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <br><br>
                <button class="btn" onclick="loadMaterials()">Show Materials</button>
            </div>

            <div id="materialContainer" class="materials-container">
                
            
            </div>
        </div>
    </div>

    <script src="/js/student/downloads.js"></script>
</body>
</html>