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
    color: #1e3a8a;
    
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
    color: #1e3a8a;
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


    </style>
    </head>
<body>

<?php $page="profile"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>

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