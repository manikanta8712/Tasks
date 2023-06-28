<?php 
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "task";
   
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   
   if (isset($_GET['deleteid'])) {
       $id = $_GET['deleteid'];
   
       $sql = "DELETE FROM employees WHERE UID = '$id'";
       $result = mysqli_query($conn, $sql);
   
       if ($result) {
        //    echo "Deleted successfully";
        header("location:employee_data.php");
       } else {
           die("Deletion failed: " . mysqli_error($conn));
       }
   }
   
    ?>
