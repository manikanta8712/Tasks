<?php
session_start();
// Check if user is logged in
include "connection.php";
if (!empty($_SESSION['id'])) {
    $id = $_SESSION['id'];
    // echo $id;
    $query = "SELECT * FROM employees WHERE user_ID = '$id'";
    $query_result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($query_result);
    if ($rows > 0) {
        $query_sql = "SELECT * FROM employees 
                  INNER JOIN user ON employees.user_ID = user.ID
                  INNER JOIN employee_images ON employees.user_ID = employee_images.user_ID
                  WHERE user.ID = '$id'";
    } else {
        $query_sql = "SELECT *  FROM user WHERE ID = '$id'";
    }
    $result = $conn->query($query_sql);
    $employee = $result->fetch_assoc();


    $employeeImages = !empty($employee['image']) ? explode(",", $employee['image']) : array(); // Convert the image string to an array
    // Remove empty elements from the image array
    $employeeImages = array_filter($employeeImages, function ($value) {
        return !empty($value);
    });
    $lastImageIndex = count($employeeImages) - 1;
    $isAdmin = $employee['admin'];
    if (!empty($employee['user_ID'])) {
        $_SESSION['uid'] = $employee['user_ID'];
    }
    if (!empty($employee['user_ID'])) {
        $userId = $employee['user_ID']; // Get the user ID
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Employee Details</title>
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
            <form action="employee_data.php" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" value="<?php if (isset($_GET['search'])) {
                                                                                        echo $_GET['search'];
                                                                                    } ?>" placeholder="Search Data">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-danger mx-2" onclick="window.location.href = 'employee_data.php';">Cancel</button>
                </div>
            </form>
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th>
                            <?php if ($isAdmin) { ?>
                                <button type="submit" name="delete_multi_employees" class="btn btn-light btn-sm all_Delete">Delete</button>
                            <?php } ?>
                        </th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Salary</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Picture</th>
                        <?php if (!$isAdmin || $userId == $employee['user_ID']) { ?>
                            <th>Actions</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php if ($isAdmin && $userId != $employee['user_ID']) { ?>
                                <input class="form-check-input checkall" name="del_chk[]" type="checkbox" value="<?= $employee['user_ID'] ?>">
                            <?php } ?>
                        </td>


                        <td><?= !empty($employee['UID']) ? $employee['UID'] : ''; ?></td>
                        <td><?= !empty($employee['firstname']) ? $employee['firstname'] : ''; ?></td>
                        <td><?= !empty($employee['lastname']) ? $employee['lastname'] : ''; ?></td>
                        <td><?= !empty($employee['salary']) ? $employee['salary'] : ''; ?></td>
                        <!-- <td><//?= $employee['firstname']; ?></td>
                        <td><//?= $employee['lastname']; ?></td>
                        <td><//?= $employee['salary']; ?></td> -->
                        <td><?= $employee['Name']; ?></td>
                        <td><?= $employee['Email']; ?></td>
                        <td><?= $employee['PhoneNumber']; ?></td>
                        <td>
                            <?php
                            if (!empty($employeeImages[$lastImageIndex])) {
                                $imagePath = explode(",", $employeeImages[$lastImageIndex]);
                                echo '<img src="./uploads/' . ltrim($imagePath[0]) . '" class="img">';
                            }
                            ?>
                        </td>


                        <?php if ($isAdmin || (!empty($userId) == !empty($employee['user_ID']))) { ?>
                            <td>
                                <a class="btn btn-primary" href='edit.php?updateid=<?= !empty($employee['user_ID']) ? $employee['user_ID'] : $employee['ID']; ?>'>Update Details</a>
                                <a class="btn btn-warning" href='preview.php?previewid=<?= !empty($employee['user_ID']) ? $employee['user_ID'] : $employee['ID']; ?>'>Preview</a>
                                <?php if (!empty($userId) == !empty($employee['user_ID'])) { ?>
                                    <a class="btn btn-primary" href='Login.php'>Log Out</a>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php
                    $employeesQuery = "SELECT temp.user_ID, temp.UID, temp.firstname, temp.lastname, temp.salary, temp.Email, temp.Name, temp.admin, temp.PhoneNumber, GROUP_CONCAT(temp.image) AS images
                                    FROM (
                                        SELECT DISTINCT employees.user_ID, employees.UID, employees.firstname, employees.lastname, employees.salary, user.Email, user.Name, user.admin, user.PhoneNumber, employee_images.image
                                        FROM employees
                                        INNER JOIN user ON employees.user_ID = user.ID
                                        INNER JOIN employee_images ON user.ID = employee_images.user_ID  WHERE user.ID != '$id'
                                        ORDER BY employees.UID
                                    ) AS temp";
                    // 
                    if (isset($_GET['search'])) {
                        $search_val = $_GET['search'];
                        $employeesQuery .= " WHERE CONCAT(temp.UID, temp.firstname, temp.lastname) LIKE '%$search_val%' OR temp.Email LIKE '%$search_val%' OR temp.Name LIKE '%$search_val%' OR temp.PhoneNumber LIKE '%$search_val%'";
                    }
                    $employeesQuery .= " GROUP BY temp.user_ID, temp.UID, temp.firstname, temp.lastname, temp.salary, temp.Email, temp.Name, temp.admin, temp.PhoneNumber";
                    // Execute the query
                    //$ress = mysqli_query($conn, $employeesQuery);
                    $employeesResult = $conn->query($employeesQuery);
                    if ($employeesResult->num_rows > 0) {
                        while ($row = $employeesResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>";
                            if ($isAdmin && !$row['admin']) {
                                echo "<input class='form-check-input checkall' name='del_chk[]' type='checkbox' value='" . $row['user_ID'] . "'>";
                            }
                            echo "</td>";
                            echo "<td class='empid' style='display: none;'>" . $row['user_ID'] . "</td>";
                            echo "<td>" . $row['UID'] . "</td>";
                            echo "<td>" . $row['firstname'] . "</td>";
                            echo "<td>" . $row['lastname'] . "</td>";
                            echo "<td>" . $row['salary'] . "</td>";
                            echo "<td>" . $row['Name'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['PhoneNumber'] . "</td>";
                            echo "<td>";
                            foreach (explode(",", $row['images']) as $image) {
                                echo '<img src="./uploads/' . $image . '" width="100px" height="100px" style="margin-right: 10px;">';
                                break; // Break the loop after displaying the first image
                            }
                            echo "</td>";

                            if (!$isAdmin) {
                                echo "<td>
                                <a class='btn btn-warning' href='preview.php?previewid=" . $row['user_ID'] . "'>Preview</a>
                                </td>";
                            }
                            if ($isAdmin) {
                                if ($row['admin']) {
                                    echo "<td>
                                <span>Admin</span>
                                <a class='btn btn-warning' href='preview.php?previewid=" . $row['user_ID'] . "'>Preview</a>
                                <input class='form-check-input admin' checked name='option' type='checkbox' value=" . $row['user_ID'] . " id='admin' data-ids=" . $row['user_ID'] . ">
                                <label class='form-check-label' for='admin'>change to Admin</label>
                                </td>";
                                } else {
                                    echo "<td>
                                     <a class='btn btn-warning' href='preview.php?previewid=" . $row['user_ID'] . "'>Preview</a>
                                     <a class='btn btn-primary' href='edit.php?updateid=" . $row['user_ID'] . "'>Edit</a>
                                     <a class='btn btn-danger delete' href='delete.php?deleteid=" . $row['user_ID'] . "'>Delete</a>
                                            <input class='form-check-input admin' name='option' type='checkbox' value=" . $row['user_ID'] . " id='admin' data-ids=" . $row['user_ID'] . ">
                                            <label class='form-check-label' for='admin'>change to Admin</label>
                                     </td>";
                                }
                            }
                            echo "</tr>";
                        }
                    }
                    // else {
                    //     echo "<tr><td colspan='9'>No employees found.</td></tr>";
                    // }
                    ?>
                </tbody>
            </table>
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
                        console.log(emp_ids);
                        $('#alldelete_id').val(emp_ids.join(', '));
                        $('#alldeleteModal').modal('show');
                    });
                    $('.cancelbtn').click(function(e) {
                        e.preventDefault();
                        location.reload();
                    });
                });
                // delete function
                $('.delete').click(function(e) {
                    e.preventDefault();
                    var emp_id = $(this).closest('tr').find('.empid').text();
                    console.log(emp_id);
                    $('#delete_id').val(emp_id);
                    $('#deleteModal').modal('show');
                });
                $('.admin').on('change', function() {
                    var selectedadminValues = [];
                    // Loop through all the checkboxes
                    $('.admin').each(function() {
                        var adminValue = $(this).is(':checked') ? 1 : 0;
                        var checkboxValue = $(this).val();
                        //alert(checkboxValue);
                        // Only add to selectedadminValues if the checkbox is checked or the admin value is 1
                        if (adminValue === 1 || adminValue === 0) {
                            selectedadminValues.push({
                                id: checkboxValue,
                                admin: adminValue
                            });
                        }
                    });
                    // Make an AJAX request to the PHP script
                    $.ajax({
                        url: 'update_admin.php',
                        method: 'POST',
                        data: {
                            selectedadminValues: selectedadminValues
                        },
                        success: function(response) {
                            // Handle the response from the server if needed
                            console.log(response);
                            location.reload();

                        },
                        error: function(xhr, status, error) {
                            // Handle errors if any
                            console.log(error);
                        }
                    });
                });
            </script>
    </body>

    </html>
<?php
} else {
    echo "<h2 class='text-center'>You are not logged in</h2>
        <a href='Login.php' type='button' class='btn btn-primary'>Log In</a>
    ";
}
?>