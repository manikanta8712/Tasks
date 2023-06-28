<?php 
// connection
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "task";
$conn = mysqli_connect($servername,$username,$password,$databasename);
if(!$conn){
    die("connection failed").mysqli_connect_error();
}
$sql = "DELETE FROM user where ID = 4";
if(mysqli_query($conn,$sql)){
    echo "deleted successfully";
}else{
    die("can not delete").mysqli_connect_error();
}
?>