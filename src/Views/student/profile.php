<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/student/new.css">
</head>

<body>
<?php include '../src/Views/navbar.php'; ?>
<!-- header part here -->
    <div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

<div class="bodyform">
        <!-- Profile Content -->
        <div class="profile-content">
            <div class="profile-header">
                <!-- Profile Picture -->
                <div class="profile-picture">
                    <img src="images/student-uploads/stu2.jpg" alt="Profile Picture" id="profilePic">
                    
                </div>
                <h1>Sachini Wimalasiri</h1>
                <label for="profilePictureUpload" class="btn">Change profile</label>
                <input type="file" id="profilePictureUpload" accept="image/*">
            </div>

            <div class="profile-section">
                <div class="section-row">
                  <div class="section-box">
                    <h3>Bio</h3>
                    <textarea placeholder="Enter your bio"></textarea>
                  </div>
                  <div class="section-box">
                    <h3>Education</h3>
                    <textarea placeholder="Enter your education details"></textarea>
                  </div>
                </div>
                <div class="section-row">
                    <div class="section-box">
                      <h3>Contact Information</h3>
                      <input type="text" placeholder="Enter phone number">
                      <input type="email" placeholder="Enter email">
                    </div>
                    <div class="section-box">
                        <h3>Interests</h3>
                        <textarea placeholder="Enter your interests"></textarea>
                      </div>
  
  
                  </div>
                <div class="section-row">
                  <div class="section-box">
                    
                        <h3>Country</h3>
                        <input type="text" placeholder="Country" required>
                    
                      </div>
                      

                  <div class="section-box">
                    <h3>City/town</h3>
                    <input type="text" placeholder="City/town" required>
                
                  </div>
                  
                </div>
                <div class="section-row">
                  <div class="section-box">
                    <h3>Change Password</h3>
                    <input type="password" placeholder="Enter new password">
                    <input type="password" placeholder="Confirm new password">
                  </div>
                  
                  <div class="section-box">
                    <h3>Grade</h3>
                    <input type="number" placeholder="Enter your Grade">
                  </div>


                </div>
                <div class="section-row">
                    <button onclick="window.location.href='viewprofile.php'" type="submit" class="savechanges-btn">Save Changes</button>
                </div>
              </div>
              
        </div>
    </div>
</div>
    <!-- JavaScript -->
    <script src="profile.js"></script>
</body>
</html>
