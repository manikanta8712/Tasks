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
    <style>
        .img {
            width: 100px !important;
        }
    </style>
</head>

<body>

    <?php
    session_start();
    if (isset($_SESSION['msg'])) {
        $success  =   $_SESSION['msg'];
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

    <div class="container">
        <h1 class="text-center">Employee Details</h1>
        <form action="employee_data.php" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>" placeholder="Search Data">
                <button type="submit" class="btn btn-primary">Search</button>
                <button type="button" class="btn btn-danger mx-2" onclick="window.location.href = 'employee_data.php';">Cancel</button>
            </div>
        </form>

        <form id="confirmForm" action="delete_all.php" method="POST">
        <input type="hidden" name="confirm" value="yes">
            <table class="table table-primary">
                <tr>
                    <th>
                        <button type="submit" name="del_multiple_data" class="btn btn-danger">Delete</button>
                    </th>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Salary</th>
                    <th>Picture</th>
                    <!-- <th>Username</th> -->
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
                <?php
                include "connection.php";
                //$sql = "SELECT * FROM employees";
                $sql = "SELECT employees.*, user.Email, user.PhoneNumber FROM employees 
        JOIN user ON employees.user_ID = user.ID";
                $result = mysqli_query($conn, $sql);
                if (isset($_GET['search'])) {
                    $search_val = $_GET['search'];
                    // $query = "SELECT employees.*, user.Email, user.PhoneNumber FROM employees 
                    // JOIN user ON employees.user_ID = user.ID WHERE CONCAT(UID,firstname,lastname) LIKE '%$search_val%' ";
                    $query = "SELECT employees.*, user.Email, user.PhoneNumber  FROM employees JOIN user ON employees.user_ID = user.ID  WHERE CONCAT(UID, firstname,lastname) LIKE '%$search_val%'  OR user.Email LIKE '%$search_val%' OR user.PhoneNumber LIKE '%$search_val%'";
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
                                    <input class="form-check-input" name="del_chk[]" type="checkbox" value="<?php echo $id; ?>">
                                </td>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $fname; ?></td>
                                <td><?php echo $lname;  ?></td>
                                <td><?php echo $sal;  ?></td>
                                <td><?php
                                    $retrievedFileNames = explode(",", $img);
                                    foreach ($retrievedFileNames as $image) {
                                        echo '<img src="./uploads/' . $image . '" class="img">';
                                    }
                                    ?></td>
                                <td><?php echo $row["Email"]; ?></td>
                                <td><?php echo $row["PhoneNumber"]; ?></td>
                                <td>

                                    <a class="btn btn-warning" href='preview.php?previewid=<?php echo $id; ?>'>Preview</a>
                                    <a class="btn btn-primary" href='edit.php?updateid=<?php echo $id; ?>'>Edit</a>
                                    <a class="btn btn-danger" href='delete.php?deleteid=<?php echo $id; ?>'>Delete</a>
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
                                    <input class="form-check-input" name="del_chk[]" type="checkbox" value="<?php echo $id; ?>">
                                </td>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $fname; ?></td>
                                <td><?php echo $lname;  ?></td>
                                <td><?php echo $sal;  ?></td>
                                <td><?php
                                    $retrievedFileNames = explode(",", $img);
                                    foreach ($retrievedFileNames as $image) {
                                        echo '<img src="./uploads/' . $image . '" class="img">';
                                    }

                                    ?></td>
                                <!-- <th><?php echo $row["Name"]; ?></th> -->
                                <td><?php echo $row["Email"]; ?></td>
                                <td><?php echo $row["PhoneNumber"]; ?></td>
                                <td>
                                    <a class="btn btn-warning" href='preview.php?previewid=<?php echo $row["user_ID"]; ?>'>Preview</a>
                                    <a class="btn btn-primary" href='edit.php?updateid=<?php echo $row["user_ID"]; ?>'>Edit</a>
                                    <a class="btn btn-danger" href='delete.php?deleteid=<?php echo $id; ?>'>Delete</a>
                                </td>
                            </tr>
                <?php
                        }
                    }
                }
                ?>
            </table>
        </form>
    </div>
</body>

</html>