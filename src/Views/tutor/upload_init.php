<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Study Materials</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h1>Manage Study Materials</h1>
    
    <h2>Upload New File</h2>
    <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="file">Select File:</label>
        <input type="file" name="file" id="file" required>
    
        <label for="visibility">Visibility:</label>
        <select name="visibility" id="visibility">
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>

        <button type="submit">Upload</button>
    </form>

    <h2>Uploaded Files</h2>
    <div id="fileList">
        <?php
        // Display files in the 'assets' directory
        $files = array_diff(scandir('assets'), ['.', '..']);
        foreach ($files as $file) {
            echo "<div class='file-item'>
                    <p><a href='assets/$file' target='_blank'>$file</a></p>
                    <form action='manage.php' method='POST' enctype='multipart/form-data' style='display: inline-block;'>
                        <input type='hidden' name='currentName' value='$file'>
                        <label for='newFile'>Replace File:</label>
                        <input type='file' name='newFile' required>
                        <button type='submit' name='action' value='replace'>Replace</button>
                    </form>
                    <form action='manage.php' method='POST' style='display: inline-block;'>
                        <input type='hidden' name='fileName' value='$file'>
                        <button type='submit' name='action' value='delete'>Delete</button>
                    </form>
                  </div>";
        }
        ?>
    </div>
</body>
</html>
