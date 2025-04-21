<?php
$file = 'students.csv';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    
    // Open file for appending
    $fileHandle = fopen($file, 'a');
    
    if ($fileHandle) {
        fputcsv($fileHandle, [$name, $dob]);
        fclose($fileHandle);
        echo "Data submitted successfully!";
    } else {
        echo "Failed to open file.";
    }
}

// Function to delete all data from the CSV file
function deleteData() {
    global $file;
    if (file_exists($file)) {
        file_put_contents($file, ''); // Empty the file
        echo "All data deleted successfully!";
    } else {
        echo "File does not exist.";
    }
}
// Call deleteData() if needed
//deleteData(); // Uncomment this line if you want to delete data


?>
