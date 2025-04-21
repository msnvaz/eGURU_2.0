<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Guru Signin</title>
    <link rel="stylesheet" href="\css\tutor\signup.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    
        <style>
        .preview-box {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            max-width: 500px;
        }
        .preview-box img,
        .preview-box embed {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin-top: 10px;
        }
        .remove-btn {
            margin-top: 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .remove-btn:hover {
            background-color: #e60000;
        }
        .file-upload-section {
            margin-top: 20px;
            padding: 20px;
            border: 2px #aaa;
            border-radius: 10px;
            background-color:rgba(250, 250, 250, 0.16);
            transition: all 0.3s ease;
        }

        .file-upload-section:hover {
            border-color: #555;
            
        }

        .file-upload-section label {
            font-family: Arial, sans-serif
            font-size: 12px;
            display: block;
            margin-bottom: 10px;
            color: white;
        }

        .file-upload-section input[type="file"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 100%;
            background-color: white;
            cursor: pointer;
            transition: border-color 0.2s ease;
        }

        .file-upload-section input[type="file"]:hover {
            border-color: #666;
        }

        input[type="file"]#qualification_file {
            display: block;
            margin-top: 10px;
            padding-left: 20px;
            padding: 10px;
            font-family: inherit;
            font-size: 14px;
            color: #333;
            background-color: #f9f9f9;
            border: 2px #ccc;
            border-radius: 10px;
            cursor: pointer;
            transition: border-color 0.3s ease, background-color 0.3s ease;
            width: 100%;
            max-width: 500px;
        }

        input[type="file"]#qualification_file:hover {
            border-color: #999;
            background-color: #f1f1f1;
        }

        .error-message {
            color: red;
            background-color:rgba(255, 255, 255, 0.46);
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }


    </style>
    
</head>
<body>

<?php include '../src/Views/navbar.php'; ?>



<div class="container">
    <div class="form-box">
        
        <h1>Welcome to e-Guru</h1>
        <?php if (!empty($error)) : ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="/tutor-signup-action" method="POST" enctype="multipart/form-data">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="date" name="birth_date" placeholder="Date of Birth" required>
            <input type="text" name="nic" placeholder="NIC" required>
            <input type="tel" name="contact_number" placeholder="Contact Number" required>
            <br>
            <!-- File Upload -->
            <div class="file-upload-section">
                <label for="qualification_file">Proof of Highest Qualification <br> (PDF or Image)</label>
                <input type="file" id="qualification_file" name="highest-qualification" accept=".pdf, image/*">

                <div id="filePreview" class="preview-box" style="display: none;">
                    <div id="previewContent"></div>
                    <button type="button" class="remove-btn" onclick="removeFile()">Remove</button>
                </div>
            </div>


            <div class="terms">
                <input type="checkbox" required>
                <label>I agree to the <a href="#">Terms & Privacy Policy</a></label>
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('qualification_file');
    const filePreview = document.getElementById('filePreview');
    const previewContent = document.getElementById('previewContent');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        previewContent.innerHTML = '';
        filePreview.style.display = 'none';

        if (!file) return;

        const reader = new FileReader();
        filePreview.style.display = 'block';

        if (file.type.startsWith('image/')) {
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = "Image preview";
                img.style.maxWidth = "200px";
                previewContent.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            reader.onload = function (e) {
                const embed = document.createElement('embed');
                embed.src = e.target.result;
                embed.type = "application/pdf";
                embed.width = "100%";
                embed.height = "400px";
                previewContent.appendChild(embed);
            };
            reader.readAsDataURL(file);
        } else {
            previewContent.textContent = 'Unsupported file type';
        }
    });

    function removeFile() {
        fileInput.value = '';
        previewContent.innerHTML = '';
        filePreview.style.display = 'none';
    }
</script>

<!-- Registration Success Modal -->
<div id="successModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5);">
  <div style="background-color:#fff; margin:15% auto; padding:20px; border-radius:10px; width:80%; max-width:400px; text-align:center;">
    <h2>Registration Successful</h2>
    <p>You have been successfully registered.</p>
    <button onclick="redirectToLogin()" style="padding:10px 20px; background-color:#ff4081; color:white; border:none; border-radius:5px;">OK</button>
  </div>
</div>

<script>
    function redirectToLogin() {
        window.location.href = '/tutor-login';
    }

    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'true') {
            document.getElementById('successModal').style.display = 'block';
        }
    }
</script>




</body>
</html>
