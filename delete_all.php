<?php 
include "connection.php";
// if(isset($_POST['del_multiple_data']))
// {

//     $all_id = $_POST['del_chk'];
//   $separate_all_id = implode(",",$all_id);
  
// if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
//   $query = "DELETE FROM employees WHERE UID IN($separate_all_id)";
//   $query_run = mysqli_query($conn, $query);

//   if ($query_run) {
//       echo "Deleted successfully";
//       header("Location: employee_data.php");
//      // exit();
//   } else {
//       echo "Cannot delete: " . mysqli_error($conn);
//   }
// }
// }
// delete all
if (isset($_POST['alldeleteEm'])) {
  $All_id = $_POST['alldelete_id'];
  //$idList = implode(',', $All_id); // Convert array of IDs to a comma-separated string
  $query = "DELETE FROM employees WHERE UID IN ($All_id)";
  $query_run = mysqli_query($conn, $query);
  if ($query_run) {
    session_start();
               $deletemessage = "Deleted Successfully";
               $_SESSION['message'] = $deletemessage;
      //echo "<script type='text/javascript'>alert('Record Deleted Successfully')</script>";
      header("Location: employee_data.php");
  } else {
      echo "Error: " . mysqli_error($conn);
  }
}

?>