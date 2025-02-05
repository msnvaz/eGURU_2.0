<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/advertisement_gallery.css">
    <title>Advertisement Gallery</title>
</head>
<body>

    <div class="ad_page_container">
    
            <h1>Upload Advertisement</h1>
            <form action="/upload-ad" method="POST" enctype="multipart/form-data">
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
                            <form action="/delete-ad" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $ad['id'] ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this advertisement?')">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Popup for updating description -->
            <div id="updatePopup" class="popup" style="display: none;">
                <div class="popup-content">
                    <h2>Update Description</h2>
                    <form id="updateForm" action="/update-ad" method="POST">
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

    </div>
    

</body>
</html>
