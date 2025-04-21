<?php
$file = '../../Student/records/exam_records.csv';
// Function to delete all data from the CSV file
function deleteData() {
    global $file;
    if (file_exists($file)) {
        file_put_contents($file, ''); // Empty the file
        echo "<div id='modal'>
                <div id='modal-content'>
                    <p>All data deleted successfully!</p>
                    <button id='close-modal'>OK</button>
                </div>
              </div>
              <script>
                document.getElementById('close-modal').addEventListener('click', function() {
                    // Close the current browser tab or window
        				window.close();
                });
              </script>
              <style>
                #modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 1000;
                }
                #modal-content {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                #modal-content p {
                    font-size: 18px;
                    margin-bottom: 20px;
                }
                #close-modal {
                    padding: 10px 20px;
                    font-size: 16px;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                #close-modal:hover {
                    background-color: #0056b3;
                }
              </style>";

         

    } else {
        echo "File does not exist.";
    }
}
// Call deleteData() if needed
deleteData(); // Uncomment this line if you want to delete data

?>