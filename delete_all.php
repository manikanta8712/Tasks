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
// if (isset($_POST['alldeleteEm'])) {
//   $All_id = $_POST['alldelete_id'];
//   //$idList = implode(',', $All_id); // Convert array of IDs to a comma-separated string
//   $query = "DELETE FROM employees WHERE UID IN ($All_id)";
//   $query_run = mysqli_query($conn, $query);
//   if ($query_run) {
//     session_start();
//                $deletemessage = "Deleted Successfully";
//                $_SESSION['message'] = $deletemessage;
//       //echo "<script type='text/javascript'>alert('Record Deleted Successfully')</script>";
//       header("Location: employee_data.php");
//   } else {
//       echo "Error: " . mysqli_error($conn);
//   }
// }
if (isset($_POST['alldeleteEm'])) {
  $All_id = $_POST['alldelete_id'];
  // Convert the array of IDs into a comma-separated string
  //$id_list = implode(',', $All_id);

  // Delete from the employeeImage table first
  $query_image = "DELETE FROM employee_images WHERE user_ID IN ($All_id)";
  $query_image_run = mysqli_query($conn, $query_image);
  // Then, delete from the employee table
  $query = "DELETE FROM employees WHERE user_ID IN ($All_id)";
  $query_run = mysqli_query($conn, $query);
  if ($query_run && $query_image_run) {
      //echo "<script type='text/javascript'>alert('Record Deleted Successfully')</script>";
      $_SESSION['alldelete'] = 'Data Deleted Successfully';
      header("Location: employee_data.php");
  }
}
?>