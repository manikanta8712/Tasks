<?php 
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "task";
$conn = mysqli_connect($servername,$username,$password,$databasename);
if(!$conn){
    die("can not connected").mysqli_connect_error();
}
$sql = "SELECT Name,Email FROM user";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo $row['Name']."<br>";
        echo $row['Email']."<br>";
        // echo $row['Phone Number']."<br>";
    }
}else{
    echo "0 results";
}
?>