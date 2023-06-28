<?php
//require will produce a fatal error (E_COMPILE_ERROR) and stop the script
//include will only produce a warning (E_WARNING) and the script will continue
// However, there is one big difference between include and require; when a file is included with the include statement and PHP cannot find it, the script will continue to execute:
// Use require when the file is required by the application.
//Use include when the file is not required and application should continue when file is not found.

// MySQLi Object-Oriented
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "task";
// Create connection
$conn = new mysqli($servername, $username, $password, $databasename);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// MySQLi Procedural
// $servername = "localhost";
// $username = "root";
// $password = "";
// $databasename = "task";
// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $databasename);
// // Check connection
// if(!$conn){
//     die('Could not connect: ' . mysqli_error());
// }
// mysqli_close($conn);