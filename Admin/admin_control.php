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
    <title>Admin Control</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
    <h1>Activate/Deactivate Exam</h1>
    <form action="control_exam.php" method="POST">
        <button type="submit" name="action" value="activate">Activate Exam</button><br>
        <button type="submit" name="action" value="deactivate">Deactivate Exam</button>
    </form>
</div>
</body>
</html>
