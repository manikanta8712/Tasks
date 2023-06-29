<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .img{
            width: 100px !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center">Employee Details</h1>
        <form action="employee_data.php" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search" value="<?php if (isset($_GET['search'])) {
                                                  echo $_GET['search']; } ?>" placeholder="Search Data">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                                
        <form action="delete_all.php" method="POST">
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
                <th>Actions</th>
            </tr>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "task";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("connection failed" . mysqli_connect_error());
            }
            $sql = "SELECT * FROM employees";
            $result = mysqli_query($conn, $sql);
            if (isset($_GET['search'])) {
                $search_val = $_GET['search'];
                $query = "SELECT * FROM employees WHERE CONCAT(UID,firstname,lastname) LIKE '%$search_val%' ";
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
                        <td>
                            <a class="btn btn-warning" href='preview.php?previewid=<?php echo $id; ?>'>Preview</a>
                            <a class="btn btn-primary" href='edit.php?updateid=<?php echo $id; ?>'>Edit</a>
                            <a class="btn btn-danger" href='delete.php?deleteid=<?php echo $id; ?>'>Delete</a>
                        </td>
                    </tr>
            <?php
                }
            }else {
                echo "<h5>No record found</h5>";
            }
        }else {
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
                        <td>
                            <a class="btn btn-warning" href='preview.php?previewid=<?php echo $id; ?>'>Preview</a>
                            <a class="btn btn-primary" href='edit.php?updateid=<?php echo $id; ?>'>Edit</a>
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