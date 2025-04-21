<?php
$file = 'students.csv';
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
deleteData(); // Uncomment this line if you want to delete data

?>