<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Time in Minutes</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
    <form action="submit.php" method="post">
        <label for="t_min">Enter time in minutes:</label>
        <input type="number" id="t_min" name="t_min" required>
        <button type="submit">Submit</button>
    </form>
    </div>
</body>
</html>
