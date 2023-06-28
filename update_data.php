<?php 
// connection
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "task";
$conn = mysqli_connect($servername,$username,$password,$databasename);
if(!$conn){
    die("can not connect".mysqli_connect_error());
}
$name = "siva";
//$email = "siva@gmail.com";
$sql = "UPDATE user SET Name = '$name' WHERE ID = 2";
if(mysqli_query($conn,$sql)){
    echo "updated successfully";
}else{
    die("can not update").mysqli_connect_error();
}
mysqli_close($conn);
?>