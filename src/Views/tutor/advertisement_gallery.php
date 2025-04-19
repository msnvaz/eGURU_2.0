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
        .ad.selected {
            background-color: #CBF1F9;
            color: black;
            border: 2px solid #1e3a8a;
        }

        .chosen-ad-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: flex; 
            align-items: center; 
            justify-content: center;
            z-index: 1000;
        }

        .chosen-ad-popup-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-top: 18%;
            margin-left: 35%;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 500px;
        }

        .del-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: flex; 
            align-items: center; 
            justify-content: center;
            z-index: 1000;
        }

        .del-popup-content {
            margin-top:-2%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        #imagePreviewContainer img {
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .modal-button {
            background-color: #ff4081;
            color: white;
            border: none;
            margin-top:15px;
            padding: 10px 18px;
            width: 80px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .modal-button:hover {
            background-color: #e03570;
        }


        .ad-description {
            height:150px;
        }

        .upload-box{
            width :auto;
            padding: 20px;
            background-color: #CBF1F9;
            margin-top:10%;
            border-radius: 2%;
        }



    </style>
</head>

<body>

<?php $page="advertisement"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>

        <div class="ad_page_container">
            <div class="upload-box">
                <h1>Upload Advertisement</h1>
                <form class="ad-form" action="/tutor-upload-ad" method="POST" enctype="multipart/form-data">
                    <!-- File Input -->
                    <label for="image">Select Image:</label>
                    <input type="file" name="image" id="image" accept="image/*" required onchange="previewAdImage(event)">

                    <!-- Preview Box -->
                    <div id="imagePreviewContainer" style="display: none; margin-top: 10px;">
                        <p style="text-align: center;">Ad Preview</p>
                        <img id="adImagePreview" src="" alt="Ad Preview" style="max-width: 200px; border: 2px solid #ccc;">

                        <!-- Remove Button -->
                        <div style="text-align: center; margin-top: 10px;">
                            <button type="button" id="removeAdPreviewBtn" style="background-color: crimson; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                                Remove
                            </button>
                        </div>
                    </div>

                    <label for="description">Description:</label>
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
                    imageInput.value = ''; // Clear file input
                    preview.src = ''; // Clear image preview
                    container.style.display = 'none'; // Hide the preview box
                });
            </script>




            
            <h1>Advertisement Gallery</h1>
            <div class="gallery">
                <?php
                    $selectedAdId = $_SESSION['selected_ad_id'] ?? null;
                    $tutorId = $_SESSION['tutor_id']; // Assuming tutor ID is stored in session
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


                            <form id="chooseForm-<?= $ad['ad_id'] ?>" action="/tutor-select-ad" method="POST" style="display:inline;">
                                <input type="hidden" name="ad_id" value="<?= $ad['ad_id'] ?>">
                                <div class="button-box">
                                    <button class="ad-button" type="button"
                                        onclick="confirmSelectAd(<?= $ad['ad_id'] ?>, '<?= $selectedAdId == $ad['ad_id'] ? 'remove' : 'choose' ?>')">
                                        <?= $selectedAdId == $ad['ad_id'] ? 'Remove' : 'Choose' ?>
                                    </button>
                                </div>
                            </form>

                        
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

            <!-- Popup for updating description -->
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
                    event.preventDefault(); // stop form from submitting
                    document.getElementById('deleteAdId').value = adId;
                    document.getElementById('deleteModal').style.display = 'flex';
                }

                function closeDeleteModal() {
                    document.getElementById('deleteModal').style.display = 'none';
                }
            </script>


    
    

</body>
</html>
