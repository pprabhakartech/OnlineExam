<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $statusFile = '../Student/exam_status.txt';

    if ($action === 'activate') {
        file_put_contents($statusFile, 'active');
        echo "<script>alert('The exam has been activated.');window.close();</script>"; 
        
    } elseif ($action === 'deactivate') {
        file_put_contents($statusFile, 'inactive');
        echo "<script>alert('The exam has been deactivated.');window.close();</script>";
         
    } else {
        echo "Invalid action.";
    }
} else {
    echo "No action specified.";
}
?>
