<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Data Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Stack elements vertically */
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            padding: 20px 0; /* Space before and after the table */
        }
        .table-container {
            width: 80%;
            max-width: 1000px;
            overflow-y: auto; /* Enable vertical scrolling */
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 40px 0; /* Space before and after the table */
            margin-top: 50px; /* Additional space from the top */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #ffffff;
            position: relative; /* Ensure position is relative for the fixed header */
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 14px;
            position: sticky;
            top: 0; /* Fixed header at the top */
            z-index: 1; /* Ensure header is above other content */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        caption {
            font-size: 24px;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchCSVData();
        });

        function fetchCSVData() {
            // Relative URL to the CSV file from the Admin directory
            const csvUrl = '../Student/records/exam_records.csv';
            
            fetch(csvUrl)
                .then(response => response.text())
                .then(data => {
                    displayCSVData(data);
                })
                .catch(error => {
                    console.error('Error fetching the CSV file:', error);
                });
        }

        function displayCSVData(data) {
            // Parse CSV data
            const rows = data.split('\n').map(row => row.split(','));

            // Build the HTML and CSS for the table
            let tableHTML = `
            <div class="table-container">
                <table>
                    <caption><b>Exam Records</b></caption>
                    <thead>
                        <tr><th>SNo.</th><th>Student Name</th><th>Course</th><th>Marks Gain</th><th>Date and Time</th></tr>
                    </thead>
                    <tbody>
            `;

            // Loop through the rows and add them to the table with an auto-incrementing serial number
            rows.forEach((row, index) => {
                if (row.length === 4) {
                    tableHTML += '<tr>';
                    tableHTML += `<td>${index+1}</td>`;  // Auto-incrementing serial number
                    tableHTML += `<td>${row[0].trim()}</td>`;
                    tableHTML += `<td>${row[1].trim()}</td>`;
                    tableHTML += `<td>${row[2].trim()}</td>`;
                    tableHTML += `<td>${row[3].trim()}</td>`;
                    tableHTML += '</tr>';
                }
            });

            tableHTML += `
                    </tbody>
                </table>
            </div>
            <button id="close-tab">Close Tab</button>
            `;

            // Insert the table and button into the body of the page
            document.body.innerHTML = tableHTML;

            // Add event listener to the close button
            document.getElementById('close-tab').addEventListener('click', function() {
                window.close();
            });
        }
    </script>
</body>
</html>
