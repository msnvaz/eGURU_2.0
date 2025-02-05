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
    <table>
        <thead>
            <tr>
                <th colspan="10" style="text-align: center; border-radius: 20px 20px 0 0;">Subject Overview</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>Subject ID</th>
                <th>Subject Name</th>
                <th>Display Picture</th>
                <th>Grade 6</th>
                <th>Grade 7</th>
                <th>Grade 8</th>
                <th>Grade 9</th>
                <th>Grade 10</th>
                <th>Grade 11</th>
                <th>Edit</th>
            </tr>
        </thead>
        
        <tbody>
        <?php
        if (!empty($subjects)) {
            foreach ($subjects as $row) {
                if ($row['status'] !== 'set') {
                    continue;
                }
                $subjectId = htmlspecialchars($row["subject_id"]);
                $subjectName = htmlspecialchars($row["subject_name"]);
                $grades = [];
                for ($i = 6; $i <= 11; $i++) {
                    if (!empty($row["grade_$i"])) {
                        $grades[] = $i;
                    }
                }
                $gradesStr = implode(',', $grades);
                $imageSrc = !empty($row["display_pic"]) ? '../uploads/' . htmlspecialchars($row["display_pic"]) : '';
        ?>
                <tr>
                    <td><?= $subjectId ?></td>
                    <td><?= $subjectName ?></td>
                    <td><?= $imageSrc ? "<img src='$imageSrc' alt='Subject Image' style='width:50px;'>" : "No Image" ?></td>
                    <td class="<?= !empty($row["grade_6"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_6"]) ? '✓' : '✗' ?></td>
                    <td class="<?= !empty($row["grade_7"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_7"]) ? '✓' : '✗' ?></td>
                    <td class="<?= !empty($row["grade_8"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_8"]) ? '✓' : '✗' ?></td>
                    <td class="<?= !empty($row["grade_9"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_9"]) ? '✓' : '✗' ?></td>
                    <td class="<?= !empty($row["grade_10"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_10"]) ? '✓' : '✗' ?></td>
                    <td class="<?= !empty($row["grade_11"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_11"]) ? '✓' : '✗' ?></td>
                    <td>
                        <a href="#" 
                        class="btn btn-primary btn-sm edit-subject-btn " 
                        data-subject-id="<?= $subjectId ?>"
                        data-subject-name="<?= $subjectName ?>"
                        data-subject-grades="<?= $gradesStr ?>"
                        data-subject-image="<?= $imageSrc ?>">
                            Edit
                        </a>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
        }
        ?>
        </tbody>

    </table>
    <!--button to view deleted subjects-->
    <center>
        <button class="dropdown-btn">View Deleted Subjects</button>
        <div class="dropdown-container">
            <table>
                <thead>
                    <tr>
                        <th colspan="10" style="text-align: center;border-radius: 20px 20px 0 0;">Deleted Subjects</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th>Subject ID</th>
                        <th>Subject Name</th>
                        <th>Display Picture</th>
                        <th>Grade 6</th>
                        <th>Grade 7</th>
                        <th>Grade 8</th>
                        <th>Grade 9</th>
                        <th>Grade 10</th>
                        <th>Grade 11</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php
                // Fetch deleted subjects
                if (!empty($subjects)) {
                    foreach ($subjects as $row) {
                        if ($row['status'] !== 'unset') {
                            continue;
                        }
                        $subjectId = htmlspecialchars($row["subject_id"]);
                        $subjectName = htmlspecialchars($row["subject_name"]);
                        $grades = [];
                        for ($i = 6; $i <= 11; $i++) {
                            if (!empty($row["grade_$i"])) {
                                $grades[] = $i;
                            }
                        }
                        $gradesStr = implode(',', $grades);
                        $imageSrc = !empty($row["display_pic"]) ? '../uploads/' . htmlspecialchars($row["display_pic"]) : '';
                ?>
                        <tr>
                            <td><?= $subjectId ?></td>
                            <td><?= $subjectName ?></td>
                            <td><?= $imageSrc ? "<img src='$imageSrc' alt='Subject Image' style='width:50px;'>" : "No Image" ?></td>
                            <td class="<?= !empty($row["grade_6"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_6"]) ? '✓' : '✗' ?></td>
                            <td class="<?= !empty($row["grade_7"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_7"]) ? '✓' : '✗' ?></td>
                            <td class="<?= !empty($row["grade_8"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_8"]) ? '✓' : '✗' ?></td>
                            <td class="<?= !empty($row["grade_9"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_9"]) ? '✓' : '✗' ?></td>
                            <td class="<?= !empty($row["grade_10"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_10"]) ? '✓' : '✗' ?></td>
                            <td class="<?= !empty($row["grade_11"]) ? 'grade-cell-success' : 'grade-cell-failure' ?>"><?= !empty($row["grade_11"]) ? '✓' : '✗' ?></td>
                            <td>
                                <a href="#" 
                                class="btn btn-primary btn-sm restore-subject-btn " 
                                data-subject-id="<?= $subjectId ?>"
                                data-subject-name="<?= $subjectName ?>"
                                data-subject-grades="<?= $gradesStr ?>"
                                data-subject-image="<?= $imageSrc ?>">
                                    Edit
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='10'>No deleted subjects found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </center>
    
    </div>
    <!-- Add this just before the closing body tag -->
    <?php include_once 'EditSubjectModal.html'; ?>
    <?php include_once 'RestoreSubjectModal.html'; ?>
    <?php include_once 'AddSubjectModal.html'; ?>

    <!--add the floating button for add subject-->
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

    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownContainer = document.querySelector('.dropdown-container');

    dropdownBtn.addEventListener('click', () => {
        dropdownContainer.classList.toggle('active-dropdown');
    });
});
</script>

</html>
