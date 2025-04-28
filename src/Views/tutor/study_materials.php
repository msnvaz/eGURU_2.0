<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Study materials</title>
    <script src="request.js"></script>
    <link rel="stylesheet" href="/css/tutor/study_material.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .material {
            border: 1px solid #ccc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            max-width: 300px;
        }
        .material-description {
            margin-top: 10px;
            min-height: 130px;
            overflow-y: auto;
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


        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

.material {
    width: 200px;
    min-height: 350px; 
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.material-description p {
    margin: 5px 0 10px 0;
    flex-grow: 1;
}

.button-box {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: auto;
}

.ad-button {
    background-color: #ff4081;
    color: white;
    border: none;
    padding: 8px 0;
    border-radius: 4px;
    cursor: pointer;
}

.ad-button:hover {
    background-color: #e73370;
}
.upload-box{
    width :auto;
    padding: 20px;
    background-color: #CBF1F9;
    margin-top:12%;
    border-radius: 5%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.33);
}

       
       .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.59); 
        }

        
        .modal-content {
            border-top: 6px solid #e03570;
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
            align-items: center;
        }

       
        .close {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 24px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

      
        .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .confirm-button {
            background-color: #ff4081;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-button:hover {
            background-color: #e03570;
        }

        .modal-cancel-button {
            background-color: #ddd;
            color: #333;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-cancel-button:hover {
            background-color: #bbb;
        }






    </style>
</head>
<body>

<?php $page="upload"; ?>


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
            <h2 style="text-align:center;"><?= $successMessage ? 'Success' : 'Error' ?></h2>
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
        <h1>Upload Study Material</h1>
        <form class="ad-form" action="/tutor-upload-material" method="POST" enctype="multipart/form-data">
            <label for="subject">Select Subject:</label>
            <select name="subject_id" id="subject" required>
                <option value="" style="text-align: center;">  Select Subject  </option>
                <?php foreach ($subjects as $subject): ?>
                    <option style="text-align: center;" value="<?= $subject['subject_id'] ?>"><?= $subject['subject_name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="grade">Select Grade:</label>
            <select name="grade" id="grade" required>
                <?php for ($i = 6; $i <= 11; $i++): ?>
                    <option style="text-align: center;" value="<?= $i ?>">Grade <?= $i ?></option>
                <?php endfor; ?>
            </select>

            <label for="material">Upload File (PDF, DOCX, PPTX, Images):</label>
            <input type="file" name="material" id="material" accept=".pdf,.doc,.docx,.ppt,.pptx,image/*" required>

            <!-- Preview area -->
            <div id="filePreview" style="margin-top: 15px;"></div>

            <!-- Remove button (initially hidden) -->
            <button type="button" id="removePreviewBtn" style="display: none; margin-top: 10px;background-color: crimson; color: white; border: none; padding: 5px 10px; cursor: pointer;" >Remove File</button>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <button class="ad-button" type="submit">Upload</button>
        </form>
    </div>

    <script>
        const materialInput = document.getElementById('material');
        const preview = document.getElementById('filePreview');
        const removeBtn = document.getElementById('removePreviewBtn');

        materialInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            preview.innerHTML = '';
            removeBtn.style.display = 'none';

            if (!file) return;

            const fileType = file.type;

            if (fileType.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                preview.appendChild(img);
            } else if (fileType === 'application/pdf') {
                const embed = document.createElement('embed');
                embed.src = URL.createObjectURL(file);
                embed.type = 'application/pdf';
                embed.width = '100%';
                embed.height = '300px';
                preview.appendChild(embed);
            } else {
                const info = document.createElement('p');
                info.textContent = `Selected File: ${file.name}`;
                preview.appendChild(info);
            }

            removeBtn.style.display = 'inline-block';
        });

        removeBtn.addEventListener('click', function() {
            materialInput.value = '';       
            preview.innerHTML = '';         
            removeBtn.style.display = 'none'; 
        });
    </script>



    <h1>Your Study Materials</h1>
    <div class="gallery">
        <?php foreach ($materials as $mat): ?>
            <div class="material">
                <p><strong>Subject:</strong> <?= $mat['subject_name'] ?></p>
                <p><strong>Grade:</strong> <?= $mat['grade'] ?></p>
                <div class="material-description">
                    <strong>Description:</strong>
                    <p><?= $mat['material_description'] ?></p>
                </div>
                
                <div class="button-box">
                    <button class="ad-button"
                        onclick="showUpdatePopup(
                            <?= $mat['material_id'] ?>,
                            `<?= addslashes($mat['material_description']) ?>`,
                            <?= $mat['subject_id'] ?>,
                            <?= $mat['grade'] ?>
                        )">Update</button>
                

                    <button class="ad-button" type="button" onclick="openDeleteModal(<?= $mat['material_id'] ?>)">Delete</button>
                 
                </div>
                        
                    <button class="ad-button" type="button" ><a href="/uploads/tutor_study_materials/<?= $mat['material_path'] ?>" target="_blank" style="text-decoration: none; color: white;">View File</a></button>
                
                
                
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div id="updatePopup" class="update-popup" style="display: none;">
    <div class="update-popup-content">
        <form class="update-form" id="updateForm" action="/tutor-update-material" method="POST">
            <h2>Update Study Material</h2>
            <input type="hidden" name="id" id="updateMaterialId">

            <label for="updateDescription">Description:</label>
            <textarea name="description" id="updateDescription" required></textarea>

            <label for="updateSubject">Subject:</label>
            <select name="subject_id" id="updateSubject" required>
                <option value="">-- Select Subject --</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject['subject_id'] ?>"><?= $subject['subject_name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="updateGrade">Grade:</label>
            <select name="grade" id="updateGrade" required>
                <?php for ($i = 6; $i <= 11; $i++): ?>
                    <option value="<?= $i ?>">Grade <?= $i ?></option>
                <?php endfor; ?>
            </select>

            <div class="update-button-box">
                <button class="ad-button" type="submit">Save</button>
                <button class="ad-button" type="button" onclick="closeUpdatePopup()">Cancel</button>
            </div>
        </form>
    </div>
</div>


<div id="deleteModal" class="del-popup" style="display: none; position: fixed; top:0; left:0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); justify-content: center; align-items: center;">
    <div class="del-popup-content" style="background-color: white; padding: 20px; border-radius: 8px;">
        <p>Are you sure you want to delete this study material?</p>
        <form id="deleteConfirmForm" action="/tutor-delete-material" method="POST">
            <input type="hidden" name="id" id="deleteMaterialId">
            <button class="modal-button" type="submit">Yes</button>
            <button class="modal-button" type="button" onclick="closeDeleteModal()">No</button>
        </form>
    </div>
</div>



<script>
    function showUpdatePopup(id, description, subjectId, grade) {
        document.getElementById('updateMaterialId').value = id;
        document.getElementById('updateDescription').value = description;
        document.getElementById('updateSubject').value = subjectId;
        document.getElementById('updateGrade').value = grade;
        document.getElementById('updatePopup').style.display = 'block';
    }

    function closeUpdatePopup() {
        document.getElementById('updatePopup').style.display = 'none';
    }

    function openDeleteModal(id) {
    const modal = document.getElementById('deleteModal');
    const input = document.getElementById('deleteMaterialId');

    if (modal && input) {
        input.value = id;
        modal.style.display = 'flex';
    } else {
        console.error('Delete modal or hidden input not found');
    }
}



    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }
</script>

</body>
</html>
