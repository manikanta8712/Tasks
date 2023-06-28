<?php 
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "task";
$conn = mysqli_connect($servername,$username,$password,$databasename);
if(!$conn){
    die("connection failed").mysqli_connect_error();
}
$file = "data.sql";
//$sql = "SELECT * INTO OUTFILE '$file' FROM user";
$sql = "LOAD DATA INFILE '$file' INTO TABLE user";
if(mysqli_query($conn,$sql)){
    echo "backup created";
}
mysqli_close($conn);
?>