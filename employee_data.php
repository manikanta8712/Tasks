<?php
session_start();
// Check if user is logged in
include "connection.php";
if (!empty($_SESSION['name'])) {
    $username = $_SESSION['name'];
}
$query_sql = "SELECT admin FROM user WHERE Name = '$username'";
$result = $conn->query($query_sql);
$row = $result->fetch_assoc();
$admin = $row["admin"];
//echo $admin;
// echo $username;
// if (empty($_SESSION['name'])) {
//     header('location:Login.php');
//     exit();
// }
// Check if user is an admin
if ($admin == 1) {
    // Redirect to a different page or display an error message
    // header('Location:employee_data.php');
?>
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
                    <input type="text" class="form-control" name="search" value="<?php if (isset($_GET['search'])) {
                                                                                        echo $_GET['search'];
                                                                                    } ?>" placeholder="Search Data">
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
                    <th>
                        Actions
                        <a class="btn btn-danger" type="button" href="Login.php">Log Out</a>
                    </th>
                </tr>
                <?php
                // Database connection
               // include "connection.php";
                // SQL query to retrieve employee data
                $sql = "SELECT employees.*, user.Email, user.Name, user.PhoneNumber, employee_images.image
        FROM employees INNER JOIN user ON employees.user_ID = user.ID INNER JOIN employee_images ON employees.user_ID = employee_images.user_ID";

                // Check if search parameter is set
                if (isset($_GET['search'])) {
                    $search_val = $_GET['search'];
                    $sql .= " WHERE CONCAT(employees.UID, employees.firstname, employees.lastname, user.Email, user.PhoneNumber, user.Name, employee_images.image) LIKE '%$search_val%'";
                }
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $employeeData = array(); // Array to store employee data
                    foreach ($result as $row) {
                        $employeeId = $row['UID'];
                        if (!isset($employeeData[$employeeId])) {
                            // Initialize the employee data
                            $employeeData[$employeeId] = array(
                                'UID' => $row['UID'],
                                'user_ID' => $row['user_ID'],
                                'Name' => $row['Name'],
                                'Firstname' => $row['firstname'],
                                'Lastname' => $row['lastname'],
                                'Salary' => $row['salary'],
                                'Email' => $row['Email'],
                                'PhoneNumber' => $row['PhoneNumber'],
                                'Images' => array() // Array to store images
                            );
                        }
                        // Add the image to the employee's images array
                        $employeeData[$employeeId]['Images'][] = $row['image'];
                    }
                    $a = 0;
                    foreach ($employeeData as $employee) {
                        $a++;
                ?>
                        <tr>
                            <td>
                                <input class="form-check-input checkall" name="del_chk[]" type="checkbox" value="<?= $employee['user_ID']; ?>">
                            </td>
                            <td class="empid" style="display: none;"><?= $employee['user_ID']; ?></td>
                            <td class=""><?= $employee['UID']; ?></td>
                            <td><?= $employee['Firstname']; ?></td>
                            <td><?= $employee['Lastname']; ?></td>
                            <td><?= $employee['Salary']; ?></td>
                            <td><?= $employee['Name']; ?></td>
                            <td><?= $employee['Email']; ?></td>
                            <td><?= $employee['PhoneNumber']; ?></td>
                            <td>
                                <?php
                                $lastImageIndex = count($employee['Images']) - 1;
                                $imagePath = explode(",", $employee['Images'][$lastImageIndex]);
                                echo '<img src="./uploads/' . ltrim($imagePath[0]) . '" class="img">';
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-warning" href='preview.php?previewid=<?= $employee['user_ID']; ?>'>Preview</a>
                                <a class="btn btn-primary" href='edit.php?updateid=<?= $employee['user_ID']; ?>'>Edit</a>
                                <a class="btn btn-danger delete" href='delete.php?deleteid=<?= $employee['user_ID']; ?>'>Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<h5>No record found</h5>";
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
<?php
} else {
    echo "you don't have access";
}
?>