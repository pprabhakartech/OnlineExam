<?php
if (!isset($_POST['name']) || !isset($_POST['course']) || !isset($_POST['score'])) {
    header('Location: index.html');
    exit();
}

$name = htmlspecialchars($_POST['name']);
$course = htmlspecialchars($_POST['course']);
$score = intval($_POST['score']);
$date = date('Y-m-d H:i:s');

// Define the record file path
$recordFilePath = 'records/exam_records.csv';

// Prepare the record data
$record = [$name, $course, $score, $date];

// Open the file in append mode
$file = fopen($recordFilePath, 'a');

// Write the record data as a CSV row
fputcsv($file, $record);

// Close the file
fclose($file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="result-container">
        <h1>Exam Completed</h1>
        <p>Name: <?php echo $name; ?></p>
        <p>Course: <?php echo $course; ?></p>
        <p>Your Score: <?php echo $score; ?> / <?php echo count(file('questions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) / 6; ?></p>
    </div>
</body>
</html>