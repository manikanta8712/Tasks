<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("connection failed" . mysqli_connect_error());
}
if(isset($_POST['del_multiple_data']))
{
    $all_id = $_POST['del_chk'];
  $separate_all_id = implode(",",$all_id);
  
  $query = "DELETE FROM employees WHERE UID IN($separate_all_id)";
  $query_run = mysqli_query( $conn,$query);
  if($query_run){
    echo "deleted successfully";
    //header("Loation:employee_data.php");
  }else{
    echo "can not delete";
  }
}


?>