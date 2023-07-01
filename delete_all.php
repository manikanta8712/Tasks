<?php 
include "connection.php";
if(isset($_POST['del_multiple_data']))
{
    $all_id = $_POST['del_chk'];
  $separate_all_id = implode(",",$all_id);
  
if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
  $query = "DELETE FROM employees WHERE UID IN($separate_all_id)";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {
      echo "Deleted successfully";
      header("Location: employee_data.php");
     // exit();
  } else {
      echo "Cannot delete: " . mysqli_error($conn);
  }
}
}
echo '<script>';
    echo 'var confirmDelete = confirm("Are you sure you want to delete the selected employees?");';
    echo 'if (confirmDelete) {';
    echo '    document.getElementById("confirmForm").submit();';
    echo '} else {';
    echo '    window.location.href = "employee_data.php";'; // Redirect if cancel is clicked
    echo '}';
    echo '</script>';

?>