<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Form</title>
</head>
<body>
    <h1>Student Data Form</h1>
    <form action="process.php" method="post">
        <label for="name">Student Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
