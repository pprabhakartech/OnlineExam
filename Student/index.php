<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Exam</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="start-container">
        <h1>Start Exam</h1>
        <form id="start-form" action="exam.php" method="GET">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required pattern="[A-Za-z ]+" title="Please enter only letters and spaces">
            <label for="course">Course Name:</label>
            <input type="text" id="course" name="course" required pattern="[A-Za-z ]+" title="Please enter only letters and spaces">
            <button type="submit">Start Exam</button>
        </form>
    </div>
</body>
</html>
