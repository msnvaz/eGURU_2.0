<?php

require_once '../vendor/autoload.php';

use App\Controllers\manager\ManagerAnnouncementController;

$controller = new ManagerAnnouncementController();
// $announcements = $controller->getAnnouncements() ?? []; // Ensure it returns an array

// Handle delete request
if (isset($_GET['delete_id'])) {
    $controller->deleteAnnouncement($_GET['delete_id']);
    header("Location: announcement.php?success=Announcement Deleted");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .message {
            text-align: center;
            font-size: 16px;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .form-container {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }
        td a:hover {
            text-decoration: underline;
        }
        .edit-btn {
            color: #28a745;
        }
        .delete-btn {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Announcements</h2>

        <?php if (isset($_GET['success'])): ?>
            <p class="message success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="message error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <div class="form-container">
            <h3>Add New Announcement</h3>
            <form method="POST" action="process_announcement.php?action=create">
                <textarea name="announcement" required></textarea><br>
                <button type="submit">Create Announcement</button>
            </form>
        </div>

        <?php if (!empty($announcements)): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Announcement</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($announcements as $announcement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($announcement['announce_id']); ?></td>
                        <td><?php echo htmlspecialchars($announcement['announcement']); ?></td>
                        <td>
                            <a href="announcement.php?edit_id=<?php echo htmlspecialchars($announcement['announce_id']); ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
                            <a href="announcement.php?delete_id=<?php echo htmlspecialchars($announcement['announce_id']); ?>" class="delete-btn" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No announcements found.</p>
        <?php endif; ?>

        <?php if (isset($_GET['edit_id'])):
            $announcement = $controller->getAnnouncementById($_GET['edit_id']);
            if ($announcement): ?>
                <div class="form-container">
                    <h3>Edit Announcement</h3>
                    <form method="POST" action="process_announcement.php?action=update">
                        <input type="hidden" name="announce_id" value="<?php echo htmlspecialchars($announcement['announce_id']); ?>">
                        <textarea name="announcement" required><?php echo htmlspecialchars($announcement['announcement']); ?></textarea><br>
                        <button type="submit">Update</button>
                    </form>
                </div>
        <?php endif; endif; ?>
    </div>
</body>
</html>
