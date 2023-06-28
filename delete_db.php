<?php 
// connection
include "connection2.php";
// delete table
$sql = "DROP DATABASE newdb";
if(mysqli_query($conn,$sql)){
    echo "deleted successfully";
}else{
    die("could not delete".mysqli_connect_error());
}
mysqli_close($conn);
?>