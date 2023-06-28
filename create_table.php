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
$sql = "CREATE TABLE user_tables(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User VARCHAR(50),
    Email VARCHAR(50),
    Phone_Number VARCHAR(10),
)";
if(mysqli_query($conn,$sql)){
    echo "table created successfully";
}
mysqli_close($conn);
?>