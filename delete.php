<?php 
// database connection
   include "connection.php";
//    if (isset($_GET['deleteid'])) {
//        $id = $_GET['deleteid'];
//        // Check if the user clicked "Yes" on the confirmation box
//        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
//            $sql = "DELETE FROM employees WHERE UID = '$id'";
//            $result = mysqli_query($conn, $sql);
//            if ($result) {
//                // Deletion successful, redirect to employee_data.php
//                header("location: employee_data.php");
//                session_start();
//                $deletemessage = "Deleted Successfully";
//                $_SESSION['message'] = $deletemessage;
//                exit();
//            } else {
//                die("Deletion failed: " . mysqli_error($conn));
//            }
//        }
//        // Display the confirmation alert box
//        echo '<script>';
//        echo 'var confirmDelete = confirm("Are you sure you want to delete this employee?");';
//        echo 'if (confirmDelete) {';
//        echo '    window.location.href = "delete.php?deleteid=' . $id . '&confirm=yes";';
//        echo '} else {';
//        echo '    window.location.href = "employee_data.php";'; // Redirect if cancel is clicked
//        echo '}';
//        echo '</script>';
//    }
if (isset($_POST['deleteEm'])) {
    $employee_id = $_POST['delete_id'];
    $query = "DELETE FROM employees WHERE UID='$employee_id' ";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        header("Location: employee_data.php");
        session_start();
              $deletemessage = "Deleted Successfully";
                $_SESSION['message'] = $deletemessage;

    }

}
    ?>
