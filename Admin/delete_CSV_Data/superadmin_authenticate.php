<?php
session_start();

// Read credentials from the file
$credentials = file('superadmin_credentials.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$is_authenticated = false;

// Get the posted username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Check the credentials
foreach ($credentials as $credential) {
    list($stored_username, $stored_password) = explode(',', trim($credential));
    if ($username === $stored_username && $password === $stored_password) {
        $is_authenticated = true;
        $_SESSION['username'] = $username;
        break;
    }
}

if ($is_authenticated) {
    header("Location: delete.php");
    exit;
} else {
    echo "Invalid username or password. <a href='superadmin.php'>Try again</a>";
}
?>
