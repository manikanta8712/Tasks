<?php 
// connection
//include "connection2.php";
$servername = "localhost";
$username = "root";
$password =  "";
$dbname = "task";
$conn = mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
    die("can not connected").mysqli_connect_error();
}
// delete table
$sql = "DROP TABLE users";
if(mysqli_query($conn,$sql)){
    echo "deleted successfully";
}else{
    die("could not delete".mysqli_connect_error());
}
mysqli_close($conn);
?>