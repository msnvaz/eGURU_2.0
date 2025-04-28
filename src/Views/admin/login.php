<?php

// Include required files
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../Models/admin/AdminLoginModel.php';

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
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
            flex-direction: row;
            justify-content: center;
            align-items: center;
            background-color: rgba(245, 245, 245, 0.7);
            border-radius: 8px;
            box-shadow: 5px 5px 10px rgba(41, 50, 65);
            width: 50%;
            height: 55vh;
        }

        .login-container {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;   
        }

        .form-group {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 5px;
            margin-top: 0px;
            font-family:'poppins', sans-serif;
            text-align: center;
            color: #333;
            font-size:16px;
        }
        h3 {
            margin: 0px auto; /* Ensures proper spacing */
            padding-left: 20px;
            font-family: 'Poppins', sans-serif;
            text-align: left; /* Overrides parent center alignment */
            color: #333;
            font-size: 14px;
            font-weight:450;
            width: 100%; /* Takes full width of the container to align text to the left */
        }

        input {
            font-family:'poppins', sans-serif;
            width: 90%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        input:focus {
            border-color: #ff5869;
            border-width: 3px;
        }

        button {
            margin-top: 10px;
            position: relative;
            width: 40%;
            padding: 8px;
            background-color: rgba(41, 50, 65,1);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: background-color 1s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            overflow: hidden; /* Ensures the pseudo-element stays within the button */
        }

        button:hover{
            background-color: #ff5869;
        }


        .error {
            color: #ff4444;
            text-align: center;
            margin-bottom: 4px;
            font-size: 14px;
            padding: 7px;
            background-color: #ffe6e6;
            border-radius: 4px;         
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin:0;
            overflow: hidden;
            overflow-y: hidden;
            object-fit: cover;
            height: 100%;
            border-radius: 0 8px 8px 0;
        }

        .image-container img {
            width:100%;
            height: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .image{
            width: 100%;
            height: 30%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <form method="POST" action="/admin-login">
                <center>
                <img src="./Images/eGURU_4.png" class="image">
                <h2>Admin Login</h2>
                <?php
                 if ($error_message): ?>
                    <div class="error"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <h3>Username</h3>
                <input type="text" name="username" required placeholder="Username">
                <h3>Password</h3>
                <input type="password" name="password" required placeholder="Password">
                <button type="submit">Login</button>
                </center>
            </form>
        </div>
        <div class="image-container">
            <img src="./Images/admin-login.jpg" alt="Admin Login">
        </div>
    </div>
    
</body>
</html>
