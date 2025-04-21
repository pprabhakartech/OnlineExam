<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $t_min = intval($_POST["t_min"]);

    // Ensure the value is a positive integer
    if ($t_min > 0) {
        // Write the value to t_min.txt in the student directory
        $filePath = '../student/t_min.txt';
        file_put_contents($filePath, $t_min);
        
       echo "<script>alert('Time in minutes successfully set to $t_min.');window.close();</script>";

    } else {
        echo"<script>alert('Invalid input. Please enter a positive integer.'); window.location.href='settime.php';</script>";
    }
} else {
    echo "Invalid request.";
}
?>
