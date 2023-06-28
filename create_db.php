<?php 
// MySQLi Procedural
// $servername = "localhost";
// $username = "root";
// $password = "";
// $conn = mysqli_connect($servername,$username,$password);
// if(!$conn){
//     die("connection failed".mysqli_connect_error());
// }
// connection
include "connection2.php";
// create database
$sql = "CREATE DATABASE newDB";
if(mysqli_query($conn,$sql)){
    echo "created successfully";
}else {
    echo "error not created".mysqli_connect_error();
}
mysqli_close($conn);
?>