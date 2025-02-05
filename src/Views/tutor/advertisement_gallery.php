<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/tutor/advertisement_gallery.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">

    <link rel="stylesheet" href="/css/navbar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Advertisement Gallery</title>
</head>
<body>
<?php include '../src/Views/navbar.php'; ?>
<?php //include '../src/Views/tutor/sidebar.php'; ?>
    

<div class="sidebar">
            <h2>e-Guru</h2>
            <ul>
                <li><i class="fa-solid fa-table-columns"></i><a href="tutor-dashboard">Dashboard</a></li>
                <li><i class="fa-solid fa-calendar-days"></i><a href="tutor-event">Events</a></li>
                <li><i class="fa-solid fa-comment"></i><a href="tutor-request">Student Requests</a></li>
                <li><i class="fa-solid fa-user"></i><a href="tutor-public-profile">Public profile</a></li>
                <li><i class="fa-solid fa-star"></i><a href="tutor-feedback">Student Feeback</a></li>
                <li><i class="fa-solid fa-rectangle-ad"></i><a href="tutor-advertisement"> Advertisement</a></li>
                <li><i class="fa-solid fa-right-from-bracket"></i><a href="tutor-logout"> Logout</a></li>
            </ul>
        </div>
        <div class="ad_page_container">
            <h1>Upload Advertisement</h1>
            <form action="/tutor-upload-ad" method="POST" enctype="multipart/form-data">
                <label for="image">Select Image:</label>
                <input type="file" name="image" id="image" required>
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
                <button type="submit">Upload</button>
            </form>

            <br><br>
            
            <h1>Advertisement Gallery</h1>
            <div class="gallery">
                <?php foreach ($ads as $ad): ?>
                    <div class="ad">
                        <img src="<?= $ad['image_path'] ?>" alt="Advertisement">
                        <p><?= $ad['description'] ?></p>
                        <div class="button-box">
                            <button onclick="showUpdatePopup(<?= $ad['id'] ?>, '<?= addslashes($ad['description']) ?>')">Update</button>
                            <form action="/tutor-delete-ad" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $ad['id'] ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this advertisement?')">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

            <!-- Popup for updating description -->
            <div id="updatePopup" class="popup" style="display: none;">
                <div class="popup-content">
                    <h2>Update Description</h2>
                    <form id="updateForm" action="/tutor-update-ad" method="POST">
                        <input type="hidden" name="id" id="updateAdId">
                        <textarea name="description" id="updateDescription" required></textarea>
                        <button type="submit">Save</button>
                        <button type="button" onclick="closeUpdatePopup()">Cancel</button>
                    </form>
                </div>
            </div>

            <script>
                function showUpdatePopup(id, description) {
                    document.getElementById('updateAdId').value = id;
                    document.getElementById('updateDescription').value = description;
                    document.getElementById('updatePopup').style.display = 'block';
                }

                function closeUpdatePopup() {
                    document.getElementById('updatePopup').style.display = 'none';
                }
            </script>

    
    

</body>
</html>
