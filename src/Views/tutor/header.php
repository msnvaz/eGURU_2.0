<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300,400,600&display=swap');

    /* General Styles */
    ::-webkit-scrollbar {
        display: none;
    }

    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

body {
    background-color: #f5f7fb;
    color: #1a1a1a;
    line-height: 1.6;
}

    .header {
        display: flex;
        align-items: center;
        padding-top: 10px;
        background-color: rgb(255, 255, 255);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        min-height: 8%;
    }

    .logo-image {
        height: 55px;
        width: auto;
        padding: 10px;
        margin-left: 10px;
        padding-left: 0px;
        padding-top: 10px;
    }

    .logout {
        margin-right: 15px;
        margin-left: auto;
        color: white;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        background-color: rgba(240, 248, 255, 0);
    }

    .logout a {
        text-decoration: none;
        color: white;
        background-color: #E14177;
        padding: 5px;
        padding-left: 15px;
        border-radius: 5px;
    }

    i {
        padding: 5px;
    }

    .profile-container {
        display: flex;
        align-items: center;
        gap: 20px;
        /* Increased gap between bell and profile picture */
        flex-shrink: 0;
        margin-left: 1150px;
        padding-right: 10px;

        .notification {
            position: relative;
            display: flex;
            align-items: center;

            i.fas.fa-bell {
                font-size: 20px;
                color: #f7931e;
                cursor: pointer;
            }

            .notification-badge {
                position: absolute;
                top: -8px;
                right: -8px;
                background-color: red;
                color: white;
                border-radius: 50%;
                width: 18px;
                height: 18px;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 12px;
                font-weight: bold;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            }
        }
    }

    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid $page-bg-color;
        margin: 0px;
    }
    </style>



    <link rel="icon" type="image/png" href="/images/eGURU_3.png">
</head>
<div class="header">
    <a href="/" class="logo-link">
        <img src="/images/eGURU_3.png" alt="Your Logo" class="logo-image">
    </a>

    <div class="profile-container">
        <div class="notification">
            <i class="fas fa-bell"></i>
            <div class="notification-badge">1</div>
        </div>
    </div>
    <div class="logout">
        <a href="/tutor-logout" class="logout">Logout<i
                class="fa-solid fa-right-from-bracket"></i></a>
    </div>
</div>

</html>