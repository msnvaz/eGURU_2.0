<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check admin login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: /admin-login.php");
    exit();
}

// Correct path for including Model
// require_once __DIR__ . '/../../../Models/admin/AdminAnnouncementModel.php';

// Create model instance
$model = new \App\Models\admin\AdminAnnouncementModel();

// Get announcements with pagination (default to first page)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;    
$result = $model->getAllAnnouncements($page, $limit);
$announcements = $result['announcements'];
$totalAnnouncements = $result['total'];
$totalPages = ceil($totalAnnouncements / $limit);

// Handle success and error messages
$successMessage = $_GET['success'] ?? "";
$errorMessage = $_GET['error'] ?? "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Announcements</title>
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <style>
        body{
            margin-left:200px;
            margin-top:100px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a, .pagination span {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #007bff;
        }
        .pagination .current {
            background-color: #007bff;
            color: white;
        }
        .add-btn {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <?php require 'AdminHeader.php'; ?>
    <?php require 'AdminNav.php'; ?> 

    <div class="container">
        <h2>Manage Announcements</h2>

        <?php if ($successMessage): ?>
            <div class="alert success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <div class="alert error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <button class="btn add-btn" onclick="openModal('addModal')">+ Add Announcement</button>

        <table>
            <thead>
                <tr>
                    <th>Announcement</th>
                    <th>Created At</th>
                    <th>Updated At</th> <!-- Added Updated At Column -->
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($announcements)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No announcements found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($announcements as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['announcement'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['created_at'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['updated_at'] ?? 'N/A') ?></td> <!-- Displaying Updated At -->
                            <td><?= htmlspecialchars($row['status'] ?? 'inactive') ?></td>
                            <td>
                                <button class="btn edit-btn" onclick="editAnnouncement('<?= $row['announce_id'] ?>', '<?= htmlspecialchars($row['announcement'], ENT_QUOTES) ?>', '<?= $row['status'] ?>')">Edit</button>
                                <a href="/admin-announcement" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'current' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>">Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h3>Add Announcement</h3>
            <form action="/admin-announcement/create" method="post">
                <label>Announcement:</label>
                <textarea name="announcement" required></textarea>
                <button type="submit" class="btn add-btn">Save</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h3>Edit Announcement</h3>
            <form action="/admin-announcement" method="post">
                <input type="hidden" name="announce_id" id="edit-id">
                <label>Announcement:</label>
                <textarea name="announcement" id="edit-announcement" required></textarea>
                <button type="submit" class="btn edit-btn">Update</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
        document.getElementById(id).style.display = "block";
}

        function closeModal(id) {
        document.getElementById(id).style.display = "none";
}

        function editAnnouncement(id, announcement) {
        document.getElementById("edit-id").value = id;
        document.getElementById("edit-announcement").value = decodeURIComponent(announcement);
        openModal("editModal");
}

    </script>
</body>
</html>
