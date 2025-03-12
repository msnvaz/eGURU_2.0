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

// Create model instance
$model = new \App\Models\admin\AdminAnnouncementModel();

// Get announcements with pagination (default to first page)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;    
$result = $model->getActiveAnnouncements($page, $limit);
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
        body {
            margin-left: 200px;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <?php require 'AdminHeader.php'; ?>
    <?php require 'AdminNav.php'; ?> 

    <div class="container">
        <h2>Manage Announcements</h2>
        
        <button class="btn add-btn" onclick="openModal('addModal')">+ Add Announcement</button>

        <?php if (!empty($successMessage)) : ?>
            <p class="success"><?= htmlspecialchars($successMessage) ?></p>
        <?php endif; ?>
        
        <?php if (!empty($errorMessage)) : ?>
            <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Announcement</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($announcements as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['announcement'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['created_at'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['updated_at'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['status'] ?? 'inactive') ?></td>
                        <td>
                            <button class="btn edit-btn" onclick="editAnnouncement('<?= $row['announce_id'] ?>', '<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['announcement'], ENT_QUOTES) ?>')">Edit</button>
                            <a href="/admin-announcement/delete/<?= $row['announce_id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Add Announcement Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h3>Add Announcement</h3>
            <form action="/admin-announcement/create" method="post">
                <label>Title:</label>
                <input type="text" name="title" required>
                <label>Announcement:</label>
                <textarea name="announcement" required></textarea>
                <button type="submit" class="btn add-btn">Save</button>
            </form>
        </div>
    </div>

    <!-- Edit Announcement Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h3>Edit Announcement</h3>
            <form action="/admin-announcement/update" method="post">
                <input type="hidden" name="announce_id" id="edit-id">
                <label>Title:</label>
                <input type="text" name="title" id="edit-title" required>
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

        function editAnnouncement(id, title, announcement) {
            document.getElementById("edit-id").value = id;
            document.getElementById("edit-title").value = decodeURIComponent(title);
            document.getElementById("edit-announcement").value = decodeURIComponent(announcement);
            openModal("editModal");
        }
    </script>
</body>
</html>
