<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Set Question and Time of OESystem</title>
    <style>
  /* Global Styles */

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  color: #333;
  background-color: #f9f9f9;
  padding: 20px;
  margin: 0;
}

.container {
  max-width: 800px;
  margin: 40px auto;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

 .links {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .links li {
    margin-bottom: 20px;
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }
  .links li:last-child {
    border-bottom: none;
  }
  .links a {
    text-decoration: none;
    color: #337ab7;
    font-size: 18px;
    font-weight: bold;
  }
  .links a:hover {
    color: #23527c;
  }
  .links .link-text {
    font-size: 16px;
    color: #666;
  }

button {
  background-color: #337ab7;
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
}

button:hover {
  background-color: #23527c;
}


    </style>
    
</head>
<body>
    <div class="container">
      <h1 align="center">Admin Exam Control Panel</h1>
      <ul class="links">
        <li> 
          <span class="link-text">View a Result Sheet</span>
          <a href="fetch.php" id="fetch-csv" style="text-decoration: none;" target="_blank">Click here......</a>
        </li>
        <li> 
          <span class="link-text">Upload a Question File</span>
          <a href="upload.php" style="text-decoration: none;" target="_blank">Click here......</a>
        </li>
        <li> 
          <span class="link-text">Set a Exam Duration Time</span>
          <a href="settime.php" style="text-decoration: none;" target="_blank" >Click here......</a>
        </li>
        <li> 
          <span class="link-text">Activate or Deactivate Exam Mode</span>
          <a href="admin_control.php" style="text-decoration: none;" target="_blank" >Click here......</a>
        </li>
        <li> 
          <span class="link-text">Delete CSV file Data/ Reset CSV File</span>
          <a href="delete_CSV_Data/superadmin.php" style="text-decoration: none;" target="_blank" >Click here......</a>
        </li>
  
        <button onclick="window.location.href = '../../index.php'">Close Now...</button>
    </div>
</body>
</html>
