<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/tutor/advertisement_gallery.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Advertisement Gallery</title>
    <style>

        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            background-color: rgba(41, 50, 65,1); /* nice blue */
            color: white;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .custom-file-upload:hover {
            background-color: rgba(41, 50, 65, 0.84); /* darker on hover */
        }

        .custom-file-upload input[type="file"] {
            display: none !important; /* hide the ugly default file input */
        }

        
        textarea:focus {
            border-color: rgba(41, 50, 65,1); /* highlight on focus */
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2); /* soft glow */
        }

    </style>
</head>

<body>

<?php $page="advertisement"; ?>


<?php include 'sidebar.php'; ?>


<?php include '../src/Views/tutor/header.php'; ?>

<?php
$successMessage = isset($_GET['success']) && !empty($_GET['success']) ? $_GET['success'] : null;
$errorMessage = isset($_GET['error']) && !empty($_GET['error']) ? $_GET['error'] : null;
?>

<?php if ($successMessage || $errorMessage): ?>
    <div id="messageModal" class="modal" style="display: block;">
        <div class="modal-content">
            <span class="close" onclick="closeMessageModal()">&times;</span>
            <h2><?= $successMessage ? 'Success' : 'Error' ?></h2>
            <hr style="color:#adb5bd;">
            <br>
            <p style="text-align:center; color: <?= $successMessage ? 'black' : 'red' ?>;">
                <?= htmlspecialchars($successMessage ?? $errorMessage) ?>
            </p>
            <div class="modal-actions" >
                <button style="margin-left:43%;" class="confirm-button" onclick="closeMessageModal()">OK</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url);
    }
</script>

        <div class="ad_page_container">
            <div class="upload-box">
                <h1>Upload Advertisement</h1>
                <form class="ad-form" action="/tutor-upload-ad" method="POST" enctype="multipart/form-data">
                    
                    <label for="image"  class="custom-file-upload">Select Image
                    <input type="file" name="image" id="image" accept="image/*" required onchange="previewAdImage(event)"></label>

                    
                    <div id="imagePreviewContainer" style="display: none; margin-top: 10px;">
                        <p style="text-align: center;">Ad Preview</p>
                        <img id="adImagePreview" src="" alt="Ad Preview" style="max-width: 200px; border: 2px solid #ccc;">

                        
                        <div style="text-align: center; margin-top: 10px;">
                            <button type="button" id="removeAdPreviewBtn" style="background-color: crimson; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius:5px;">
                                Remove
                            </button>
                        </div>
                    </div>

                    <label for="description"><b>Description:</b></label>
                    <textarea name="description" id="description" required></textarea>
                    <button class="ad-button" type="submit">Upload</button>

                </form>
            </div>

            <script>
                const imageInput = document.getElementById('image');
                const preview = document.getElementById('adImagePreview');
                const container = document.getElementById('imagePreviewContainer');
                const removeBtn = document.getElementById('removeAdPreviewBtn');

                function previewAdImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        preview.src = URL.createObjectURL(file);
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                        preview.src = '';
                    }
                }

                removeBtn.addEventListener('click', function () {
                    imageInput.value = ''; 
                    preview.src = '';
                    container.style.display = 'none'; 
                });
            </script>




            
            <h1>Advertisement Gallery</h1>
            <div class="gallery">
                <?php
                    $selectedAdId = $_SESSION['selected_ad_id'] ?? null;
                    $tutorId = $_SESSION['tutor_id']; 
                ?>
                <?php foreach ($ads as $ad): ?>
                    <div class="ad <?= $selectedAdId == $ad['ad_id'] ? 'selected' : '' ?>">
                        <img src="/uploads/tutor_ads/<?= $ad['ad_display_pic'] ?>" alt="Advertisement">
                        <div class="ad-description">
                            <p><?= $ad['ad_description'] ?></p>
                        </div>
                        <div class="button-box">
                            <button class="ad-button" onclick="showUpdatePopup(<?= $ad['ad_id'] ?>, '<?= addslashes($ad['ad_description']) ?>')">Update</button>
                        </div>
                            <form onsubmit="openDeleteModal(event, <?= $ad['ad_id'] ?>)" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $ad['ad_id'] ?>">
                                <div class="button-box">
                                    <button class="ad-button" type="submit">Delete</button>
                                </div>
                            </form>


                            <form id="chooseForm-<?= $ad['ad_id'] ?>" action="/tutor-select-ad" method="POST" >
                                <input type="hidden" name="ad_id" value="<?= $ad['ad_id'] ?>">
                                <div class="button-box">
                                    <button class="ad-button" type="button" style="display:inline;background-color:rgba(41, 50, 65,1);"
                                        onclick="confirmSelectAd(<?= $ad['ad_id'] ?>, '<?= $selectedAdId == $ad['ad_id'] ? 'remove' : 'choose' ?>')">
                                        <?= $selectedAdId == $ad['ad_id'] ? 'Remove' : 'Choose' ?>
                                    </button>
                                </div>
                            </form>

                        
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

            
            <div id="updatePopup" class="update-popup" style="display: none;">
                <div class="update-popup-content">
                    <form class="update-form" id="updateForm" action="/tutor-update-ad" method="POST">
                        <h2>Update Description</h2>
                        <input type="hidden" name="id" id="updateAdId">
                        <textarea name="description" id="updateDescription" required></textarea>
                        <div class="update-button-box" >
                            <button class="ad-button" type="submit">Save</button>
                            <button class="ad-button" type="button" onclick="closeUpdatePopup()">Cancel</button>
                        </div>
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


            <div id="confirmModal" class="chosen-ad-popup" style="display:none;">
                <div class="chosen-ad-popup-content">
                    <p id="confirmMessage"></p>
                    <button class="modal-button" onclick="submitConfirmedAd()">Yes</button>
                    <button class="modal-button" onclick="closeConfirmModal()">No</button>
                </div>
            </div>

            <script>
                let adFormToSubmit = null;

                function confirmSelectAd(adId, actionType) {
                    const message = `Are you sure you want to ${actionType} this advertisement?`;
                    document.getElementById('confirmMessage').innerText = message;
                    adFormToSubmit = document.getElementById(`chooseForm-${adId}`);
                    document.getElementById('confirmModal').style.display = 'block';
                }

                function submitConfirmedAd() {
                    if (adFormToSubmit) {
                        adFormToSubmit.submit();
                    }
                }

                function closeConfirmModal() {
                    adFormToSubmit = null;
                    document.getElementById('confirmModal').style.display = 'none';
                }
            </script>

            <div id="deleteModal" class="del-popup" style="display: none;">
                <div class="del-popup-content">
                    <p>Are you sure you want to delete this advertisement?</p>
                    <form id="deleteConfirmForm" action="/tutor-delete-ad" method="POST">
                        <input type="hidden" name="id" id="deleteAdId">
                        <button class="modal-button" type="submit">Yes</button>
                        <button class="modal-button" type="button" onclick="closeDeleteModal()">No</button>
                    </form>
                </div>
            </div>

            <style>
            .modal {
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(0,0,0,0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 999;
            }

            .modal-content {
                background: white;
                padding: 20px;
                border-radius: 8px;
                text-align: center;
            }
            </style>

            <script>
                function openDeleteModal(event, adId) {
                    event.preventDefault();
                    document.getElementById('deleteAdId').value = adId;
                    document.getElementById('deleteModal').style.display = 'flex';
                }

                function closeDeleteModal() {
                    document.getElementById('deleteModal').style.display = 'none';
                }
            </script>


    
    

</body>
</html>
