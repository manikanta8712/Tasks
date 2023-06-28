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
// insert data
$sql = "INSERT INTO student_details (Name,Age)";
$sql.= "Values('student06',18)";
//mysqli_select_db("task");
if(mysqli_query($conn,$sql)){
    echo "inserted successfully";
}
mysqli_close($conn);
?>