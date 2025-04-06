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
                <a href="?tab=active&page=1" class="tab-link <?= ($currentTab === 'active') ? 'active' : '' ?>">Active Subjects</a>
                <a href="?tab=deleted&page=1" class="tab-link <?= ($currentTab === 'deleted') ? 'active' : '' ?>">Deleted Subjects</a>
            </div>
            <br>

            <?php
            // Get the current tab from URL parameter or default to 'active'
            $currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'active';
            
            // Get current page from URL or default to 1
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            
            // Define subjects per page
            $perPage = 10;
            
            // Filter subjects based on status
            $activeSubjects = array_filter($subjects ?? [], fn($row) => $row['subject_status'] === 'set');
            $deletedSubjects = array_filter($subjects ?? [], fn($row) => $row['subject_status'] === 'unset');
            
            // Choose which array to paginate based on current tab
            $currentSubjects = $currentTab === 'deleted' ? $deletedSubjects : $activeSubjects;
            
            // Calculate pagination values
            $total = count($currentSubjects);
            $pages = ceil($total / $perPage);
            $page = max(1, min($page, $pages)); // Ensure page is within valid range
            $offset = ($page - 1) * $perPage;
            $paginatedSubjects = array_slice($currentSubjects, $offset, $perPage);
            ?>

            <div id="active-subjects" class="tab-content" style="<?= $currentTab === 'deleted' ? 'display:none;' : '' ?>">
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
                    if (!empty($activeSubjects)) {
                        if ($currentTab !== 'deleted') {
                            foreach ($paginatedSubjects as $row) {
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
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div id="deleted-subjects" class="tab-content" style="<?= $currentTab !== 'deleted' ? 'display:none;' : '' ?>">
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
                    if (!empty($deletedSubjects)) {
                        if ($currentTab === 'deleted') {
                            foreach ($paginatedSubjects as $row) {
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
                        }
                    } else {
                        echo "<tr><td colspan='4'>No deleted subjects found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?tab=<?= $currentTab ?>&page=<?= $page - 1 ?>">«</a>
            <?php endif; ?>
            
            <?php
            // Show limited page numbers for better UX
            $startPage = max(1, $page - 2);
            $endPage = min($pages, $page + 2);
            
            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?tab=<?= $currentTab ?>&page=<?= $i ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $pages): ?>
                <a href="?tab=<?= $currentTab ?>&page=<?= $page + 1 ?>">»</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
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

    // Remove tab click event handlers since we're now using direct links
    // with proper page reloads to maintain state correctly
});
</script>
</html>