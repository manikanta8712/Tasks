<?php
// MySQLi Procedural
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername,$username,$password);
if(!$conn){
    die("connection failed".mysqli_connect_error());
}
?>