<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <!-- Latest compiled and minified CSS -->
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="bootstrap-5.2.3-dist\js\bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .img {
            width: 100px !important;
        }
    </style>
</head>
<body>
    <!-- modal for delete all -->
    <div class="modal fade" id="alldeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employee Data Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="delete_all.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="alldelete_id" id="alldelete_id">
                        <h6>Are you sure, do you want to delete?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancelbtn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="alldeleteEm" class="btn btn-danger">Delete All</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal for delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employee Data Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="delete.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <h6>Are you sure, do you want to delete?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancelbtn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="deleteEm" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    session_start();
    if (isset($_SESSION['msg'])) {
        $success =  $_SESSION['msg'];
        unset($_SESSION['msg']); // Clear the message to prevent it from showing again
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' .  $success . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    if (isset($_SESSION['message'])) {
        $deletemessage = $_SESSION['message'];
        unset($_SESSION['message']); // Clear the message to prevent it from showing again
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">' . $deletemessage . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    <div class="">
        <h1 class="text-center">Employee Details</h1>
        <!-- search -->
        <form action="employee_data.php" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>" placeholder="Search Data">
                <button type="submit" class="btn btn-primary">Search</button>
                <button type="button" class="btn btn-danger mx-2" onclick="window.location.href = 'employee_data.php';">Cancel</button>
            </div>
        </form>
        <!-- delete all -->
        <!-- <form id="confirmForm" action="delete_all.php" method="POST">
            <input type="hidden" name="confirm" value="yes"> -->
        <table class="table table-primary">
            <tr>
                <th>
                    <button type="submit" name="del_multiple_data" class="btn btn-danger all_Delete">Delete</button>
                </th>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Salary</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
            <?php
            // database connection
            include "connection.php";
            //$sql = "SELECT * FROM employees";
            $sql = "SELECT employees.*, user.Email,user.Name, user.PhoneNumber FROM employees 
        JOIN user ON employees.user_ID = user.ID";
            $result = mysqli_query($conn, $sql);
            if (isset($_GET['search'])) {
                $search_val = $_GET['search'];
                // $query = "SELECT employees.*, user.Email, user.PhoneNumber FROM employees 
                // JOIN user ON employees.user_ID = user.ID WHERE CONCAT(UID,firstname,lastname) LIKE '%$search_val%' ";
                $query = "SELECT employees.*, user.Email,user.Name, user.PhoneNumber  FROM employees JOIN user ON employees.user_ID = user.ID  WHERE CONCAT(UID, firstname,lastname) LIKE '%$search_val%'  OR user.Email LIKE '%$search_val%' OR user.PhoneNumber LIKE '%$search_val%' OR user.Name LIKE '%$search_val%'";
                $query_result = mysqli_query($conn, $query);
                if (mysqli_num_rows($query_result) > 0) {
                    while ($row = mysqli_fetch_assoc($query_result)) {
                        $id = $row["UID"];
                        $fname =  $row["firstname"];
                        $lname = $row["lastname"];
                        $sal = $row["salary"];
                        $img = $row["picture"];
            ?>
                        <tr>
                            <td>
                                <input class="form-check-input checkall" name="del_chk[]" type="checkbox" value="<?php echo $id; ?>">
                            </td>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $fname; ?></td>
                            <td><?php echo $lname;  ?></td>
                            <td><?php echo $sal;  ?></td>
                            <td><?php echo $row["Name"]; ?></td>
                            <td><?php echo $row["Email"]; ?></td>
                            <td><?php echo $row["PhoneNumber"]; ?></td>
                            <td><?php
                                $retrievedFileNames = explode(",", $img);
                                foreach ($retrievedFileNames as $image) {
                                    echo '<img src="./uploads/' . $image . '" class="img">';
                                }
                                ?></td>
                            <td>
                                <a class="btn btn-warning" href='preview.php?previewid=<?php echo $row["user_ID"]; ?>'>Preview</a>
                                <a class="btn btn-primary" href='edit.php?updateid=<?php echo $row["user_ID"]; ?>'>Edit</a>
                                <a class="btn btn-danger delete" href='delete.php?deleteid=<?php echo $id; ?>'>Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo "<h5>No record found</h5>";
                }
            } else {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row["UID"];
                        $fname =  $row["firstname"];
                        $lname = $row["lastname"];
                        $sal = $row["salary"];
                        $img = $row["picture"];
                    ?>
                        <tr>
                            <td>
                                <input class="form-check-input checkall" name="del_chk[]" type="checkbox" value="<?php echo $id; ?>">
                            </td>
                            <td class="empid"><?php echo $id; ?></td>
                            <td><?php echo $fname; ?></td>
                            <td><?php echo $lname;  ?></td>
                            <td><?php echo $sal;  ?></td>
                            <td><?php echo $row["Name"]; ?></td>
                            <td><?php echo $row["Email"]; ?></td>
                            <td><?php echo $row["PhoneNumber"]; ?></td>
                            <td><?php
                                $retrievedFileNames = explode(",", $img);
                                //foreach ($retrievedFileNames as $image) {
                                echo '<img src="./uploads/' . $retrievedFileNames[0] . '" class="img">';
                                // }
                                ?></td>
                            <td>
                                <a class="btn btn-warning" href='preview.php?previewid=<?php echo $row["user_ID"]; ?>'>Preview</a>
                                <a class="btn btn-primary" href='edit.php?updateid=<?php echo $row["user_ID"]; ?>'>Edit</a>
                                <a class="btn btn-danger delete" href='delete.php?deleteid=<?php echo $id; ?>'>Delete</a>
                            </td>
                        </tr>
            <?php
                    }
                }
            }
            ?>
        </table>
        <!-- </form> -->
    </div>
    <script>
        // modal for delete all
        $(document).ready(function() {
            $('.all_Delete').click(function(e) {
                e.preventDefault();
                var emp_ids = [];
                $(this).closest('table').find('.checkall:checked').each(function() {
                    var emp_id = $(this).val();
                    emp_ids.push(emp_id);
                });
                //console.log(emp_ids);
                $('#alldelete_id').val(emp_ids.join(', '));
                $('#alldeleteModal').modal('show');
            });
            $('.cancelbtn').click(function(e) {
                e.preventDefault();
                location.reload();
            });
        });
        // delte function
        $('.delete').click(function(e) {
            e.preventDefault();
            var emp_id = $(this).closest('tr').find('.empid').text();
            //console.log(emp_id);
            $('#delete_id').val(emp_id);
            $('#deleteModal').modal('show');
        });
    </script>
</body>
</html>