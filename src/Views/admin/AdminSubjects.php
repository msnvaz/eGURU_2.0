<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="admin-dashboard">
            <br>
            <div class="profile-tabs">
                <a href="#active-subjects" class="tab-link active">Active Subjects</a>
                <a href="#deleted-subjects" class="tab-link">Deleted Subjects</a>
            </div>
            <br>

            <div id="active-subjects" class="tab-content">
                <table style="margin-top:0;">
                    <thead>
                        <tr>
                            <th colspan="4" style="text-align: center; border-radius: 20px 20px 0 0;">Subject Overview</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th>Subject ID</th>
                            <th>Subject Name</th>
                            <th>Display Picture</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                    if (!empty($subjects)) {
                        foreach ($subjects as $row) {
                            if ($row['subject_status'] !== 'set') {
                                continue;
                            }
                            $subjectId = htmlspecialchars($row["subject_id"]);
                            $subjectName = htmlspecialchars($row["subject_name"]);
                            $imageSrc = !empty($row["subject_display_pic"]) ? '../uploads/Subjects/' . htmlspecialchars($row["subject_display_pic"]) : '';
                    ?>
                            <tr>
                                <td><?= $subjectId ?></td>
                                <td><?= $subjectName ?></td>
                                <td><?= $imageSrc ? "<img src='$imageSrc' alt='Subject Image' style='width:50px;'>" : "No Image" ?></td>
                                <td>
                                    <a href="#" 
                                    class="btn btn-primary btn-sm edit-subject-btn" 
                                    data-subject-id="<?= $subjectId ?>"
                                    data-subject-name="<?= $subjectName ?>"
                                    data-subject-image="<?= $imageSrc ?>">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div id="deleted-subjects" class="tab-content" style="display:none;">
                <table>
                    <thead>
                        <tr>
                            <th colspan="4" style="text-align: center; border-radius: 20px 20px 0 0;">Deleted Subjects</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th>Subject ID</th>
                            <th>Subject Name</th>
                            <th>Display Picture</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                    if (!empty($subjects)) {
                        foreach ($subjects as $row) {
                            if ($row['subject_status'] !== 'unset') {
                                continue;
                            }
                            $subjectId = htmlspecialchars($row["subject_id"]);
                            $subjectName = htmlspecialchars($row["subject_name"]);
                            $imageSrc = !empty($row["subject_display_pic"]) ? '../uploads/Subjects/' . htmlspecialchars($row["subject_display_pic"]) : '';
                    ?>
                            <tr>
                                <td><?= $subjectId ?></td>
                                <td><?= $subjectName ?></td>
                                <td><?= $imageSrc ? "<img src='$imageSrc' alt='Subject Image' style='width:50px;'>" : "No Image" ?></td>
                                <td>
                                    <a href="#" 
                                    class="btn btn-primary btn-sm restore-subject-btn" 
                                    data-subject-id="<?= $subjectId ?>"
                                    data-subject-name="<?= $subjectName ?>"
                                    data-subject-image="<?= $imageSrc ?>">
                                        Restore
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No deleted subjects found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php include_once 'EditSubjectModal.html'; ?>
    <?php include_once 'RestoreSubjectModal.html'; ?>
    <?php include_once 'AddSubjectModal.html'; ?>

    <a href="#" class="floating-btn" id="add-subject-btn">
        <i class="fas fa-plus" style="padding-right:0;margin-right:0;"></i>
    </a>
</body>
<script src="/js/admin/Admin.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('add-subject-btn');

    button.addEventListener('mouseenter', () => {
        button.innerHTML = 'Add Subject';
    });

    button.addEventListener('mouseleave', () => {
        button.innerHTML = '<i class="fas fa-plus" style="padding-right:0;margin-right:0;border-radius:50%"></i>';
    });

    const tabs = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(content => content.style.display = 'none');

            tab.classList.add('active');
            const target = tab.getAttribute('href');
            document.querySelector(target).style.display = 'block';
        });
    });
});
</script>
</html>