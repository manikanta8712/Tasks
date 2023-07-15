<?php
include"connection.php";
session_start();
if (isset($_POST['selectedadminValues'])) {
    $selectedadminValues = $_POST['selectedadminValues'];
    foreach ($selectedadminValues as $checkbox) {
        $id = $checkbox['id'];
        $admin = $checkbox['admin'];
        $sqlUpdate = "UPDATE user SET admin='$admin' WHERE ID='$id'";
        mysqli_query($conn, $sqlUpdate);
    }
    //echo "Update successful";
}
?>
