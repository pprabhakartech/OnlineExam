<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Upload a Question TXT File</h2>
        <form action="upload_handler.php" method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Select file to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept=".txt"><br>
            <input type="submit" value="Upload File" name="submit">
        </form>
    </div>
</body>
</html>
