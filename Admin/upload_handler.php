<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$target_dir = "../Student/";
$target_file = $target_dir . "questions.txt";
$uploadOk = 1;
$fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Check if the uploaded file is a .txt file
if($fileType != "txt") {
    echo "Sorry, only TXT files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<script>alert('The file has been uploaded and renamed to questions.txt.');window.close();</script>";
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href='upload.php';</script>";
    }
}
?>
