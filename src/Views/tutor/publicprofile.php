<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/tutor/publicprofile.css">
    <link rel="stylesheet" href="css/tutor/sidebar.css">
    <style>

#rating {
    font-family: 'Arial', sans-serif;
    display: flex;
    align-items: center;
    font-size: 20px;
    color: #333;
    padding: 20px;
    background-color: #CBF1F9;;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    height: 75px;
    margin-left: 3%;
    margin-top: 5%;
    margin-bottom: 3%;
    justify-content: center;
    position: relative;
    left: 40px;
    
  }
  
  .rating-text {
    text-align: center;
    font-weight: bold;
    margin-right: 10px;
    color: rgba(41, 50, 65,1);
    
  }
  
  .stars {
    display: flex;
}

.star {
    font-size: 24px;
    color: #898989; /* Default empty stars */
    position: relative;
}

.star.filled {
    color: gold; /* Fully filled stars */
}

.star.half-filled {
    position: relative;
}

.star.half-filled::before {
    content: "★";
    position: absolute;
    width: 50%;
    overflow: hidden;
    color: gold; /* Half-filled star */
}

  .rating-number {
    text-align: center;
    margin-left: 2%;
    font-size: 22px;
    color: rgba(41, 50, 65,1);
    font-weight: bold;
  }

  .viewprofile-details {
    display: flex;
    flex-wrap: wrap;
    gap: 60px;
    }

    .profile-column {
        flex: 1;
        min-width: 300px;
        margin-right:60px;
    }

    .detail-item {
        margin-bottom: 10px;
    }

    /* Modal Background */
    .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.59); /* dark background */
        }

        /* Modal Content Box */
        .modal-content {
            text-align:center;
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

        /* Close Button (X) */
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

        /* Modal Buttons */
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

<?php $page="profile"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
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


<div class="container">
        
        $_SESSION['profile_picture'] = $profileData['tutor_profile_photo'] ?? 'profile1.jpg'; ?>

        <div class="profile-bodyform">
            <div class="viewprofile-content">
                <div class="viewprofile-header">
                    <img src="/images/tutor_uploads/tutor_profile_photos/<?php echo isset($profileData['tutor_profile_photo']) ? $profileData['tutor_profile_photo'] : 'profile1.jpg'; ?>"
                        alt="Profile Image" class="viewprofile-img">
                        <h1>
                            <?= isset($profileData['tutor_first_name'], $profileData['tutor_last_name']) 
                                ? htmlspecialchars($profileData['tutor_first_name'] . ' ' . $profileData['tutor_last_name']) 
                                : 'Tutor Name' ?>
                        </h1>

                    <button class="edit-button"><a style="text-decoration:none; color:white;"
                            href="/tutor-profile-edit"><?php echo $profileData ? "Edit profile" : "Create profile"; ?></a></button>
                    <form action="/tutor-profile-delete" method="POST" style="display:inline;">
                        <button type="submit" class="delete-button" >Delete Profile</button>
                    </form>

                        <div id="rating">
                            <span class="rating-text">Overall Rating </span>
                            <div class="stars" id="starContainer">
                                <!-- Stars will be dynamically updated -->
                            </div>
                            <span class="rating-number"> <?php echo $tutorRating?></span>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                function updateStarRating(rating) {
                                    const maxStars = 5;
                                    const starContainer = document.getElementById("starContainer");

                                    if (!starContainer) return; // Prevent errors if the element is missing

                                    starContainer.innerHTML = ""; // Clear existing stars

                                    for (let i = 1; i <= maxStars; i++) {
                                        const star = document.createElement("span");
                                        star.classList.add("star");

                                        if (i <= Math.floor(rating)) {
                                            star.classList.add("filled"); // Full star
                                            star.innerHTML = "&#9733;";
                                        } else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                                            star.classList.add("half-filled"); // Half-star
                                            star.innerHTML = "&#9733;";
                                        } else {
                                            star.innerHTML = "&#9733;"; // Empty star
                                        }

                                        starContainer.appendChild(star);
                                    }
                                }

                                // Get the rating from PHP and parse it to a number
                                const tutorRating = parseFloat(
                                    document.querySelector(".rating-number").textContent
                                );

                                if (!isNaN(tutorRating)) {
                                    updateStarRating(tutorRating);
                                }
                            });

                        </script>

                </div>

                <div class="viewprofile-details" style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <!-- Column 1 -->
                    <div class="profile-column" style="flex: 1; min-width: 300px;">
                        <div class="detail-item"><strong>Bio:</strong> <?= $profileData['bio'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>Education:</strong> <?= $profileData['education'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>Specialization:</strong> <?= $profileData['specialization'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>Experience:</strong> <?= $profileData['experience'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>NIC No.:</strong> <?= $profileData['tutor_NIC'] ?? 'N/A' ?></div><br>
                        <div class="detail-item">
                        <strong>Subjects:</strong> 
                        <?= !empty($profileData['subjects']) ? implode(', ', $profileData['subjects']) : 'N/A' ?>
                    </div><br>
                    </div>

                    <!-- Column 2 -->
                    <div class="profile-column" style="flex: 1; min-width: 300px;">
                        <div class="detail-item"><strong>Phone:</strong> <?= $profileData['tutor_contact_number'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>Email:</strong> <?= $profileData['tutor_email'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>Date of Birth:</strong> <?= $profileData['tutor_DOB'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>Country:</strong> <?= $profileData['country'] ?? 'N/A' ?></div><br>
                        <div class="detail-item"><strong>City/Town:</strong> <?= $profileData['city_town'] ?? 'N/A' ?></div><br>
                        <div class="detail-item">
                        <strong>Grades:</strong> 
                        <?= !empty($profileData['grades']) ? implode(', ', $profileData['grades']) : 'N/A' ?>
                    </div><br>
                    </div>
                
                    

                    

                    

                </div>

            </div>

        </div>


</body>

</html>