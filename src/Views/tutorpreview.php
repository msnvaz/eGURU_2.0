<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tutor['name']) ?> - Tutor Profile</title>
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            background: white;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
        }

        .availability-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 1rem;
        }

        .available {
            background-color: #e6ffe6;
            color: #008000;
        }

        .unavailable {
            background-color: #ffe6e6;
            color: #cc0000;
        }

        .connect-btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 2rem;
            transition: background-color 0.3s;
        }

        .connect-btn:hover {
            background-color: #45a049;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-btn {
            background-color: #4CAF50;
            color: white;
        }

        .signup-btn {
            background-color: #008CBA;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="profile-container">
        <div class="profile-header">
            <!-- <img src="<?= htmlspecialchars($tutor['profile_image']) ?>" 
                 alt="<?= htmlspecialchars($tutor['name']) ?>" 
                 class="profile-image"> -->
            
            <div class="profile-info">
                <h1><?= htmlspecialchars($tutor['name']) ?></h1>
                <p><strong>Qualification:</strong> <?= htmlspecialchars($tutor['qualification']) ?></p>
                <p><strong>Subject:</strong> <?= htmlspecialchars($tutor['subject']) ?></p>
                <!-- <p><strong>Investment per hour:</strong> LKR.<?= number_format($tutor['hour_fees']) ?></p> -->
                <div class="availability-badge <?= strtolower($tutor['availability']) ?>">
                    <?= htmlspecialchars($tutor['availability']) ?>
                </div>
            </div>
        </div>

        <button onclick="handleConnect()" class="connect-btn">
            Connect to Teacher
        </button>
    </div>

    <!-- Login/Signup Modal -->
    <div id="authModal" class="modal">
        <div class="modal-content">
            <h2>Join Our Community</h2>
            <p>Please login or sign up to connect with this tutor</p>
            <div class="modal-buttons">
                <a href="/login.php" class="modal-btn login-btn">Login</a>
                <a href="/signup.php" class="modal-btn signup-btn">Sign Up</a>
            </div>
        </div>
    </div>

    <script>
        function handleConnect() {
            <?php if ($isLoggedIn): ?>
                window.location.href = '/connect.php?tutor_id=<?= urlencode($tutorId) ?>';
            <?php else: ?>
                document.getElementById('authModal').style.display = 'flex';
            <?php endif; ?>
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('authModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>