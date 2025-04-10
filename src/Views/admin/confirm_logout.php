<?php
// Check if this page is being accessed directly
if (!isset($_SESSION['pending_admin_id']) || !isset($_SESSION['pending_username'])) {
    header('Location: /admin-login');
    exit();
}

$username = $_SESSION['pending_username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirm Logout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family:'poppins', sans-serif;
            background-image: linear-gradient(45deg, rgba(255, 88, 105), rgba(60, 55, 75), rgba(41, 50, 65));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(245, 245, 245, 0.7);
            border-radius: 8px;
            box-shadow: 5px 5px 10px rgba(41, 50, 65);
            width: 40%;
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
            font-family:'poppins', sans-serif;
            text-align: center;
            color: #333;
            font-size: 20px;
        }

        p {
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
            line-height: 1.5;
        }

        .button-group {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 20px;
        }

        button {
            width: 45%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: background-color 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .confirm {
            background-color: rgba(41, 50, 65, 1);
            color: white;
        }

        .cancel {
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }

        .confirm:hover {
            background-color: #ff5869;
        }

        .cancel:hover {
            background-color: #e0e0e0;
        }

        .image {
            width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="./Images/eGURU_4.png" class="image">
        <h2>Account Already Logged In</h2>
        <p>User <strong><?php echo htmlspecialchars($username); ?></strong> is already logged in from another session.</p>
        <p>Would you like to log out from the previous session and continue with this login?</p>
        
        <form method="POST" action="/admin-login" class="button-group">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
            <input type="hidden" name="confirm_logout" value="yes">
            <button type="submit" class="confirm">Yes, Log Out Previous Session</button>
        </form>
        
        <form method="POST" action="/admin-login" class="button-group">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
            <input type="hidden" name="confirm_logout" value="no">
            <button type="submit" class="cancel">No, Cancel Login</button>
        </form>
    </div>
</body>
</html>