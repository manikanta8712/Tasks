<?php
// database connection
include "connection.php";
if (isset($_GET['previewid'])) {
     $employee_id = $_GET['previewid'];
    //$query = "SELECT * FROM employees WHERE UID ='$employee_id'";
    $query = "SELECT employees.*, user.Email, user.PhoneNumber FROM employees 
    JOIN user ON employees.user_ID = user.ID WHERE employees.user_ID = '$employee_id'";
    $query_run = mysqli_query($conn, $query);
    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
    } else {
        echo "No such id found";
    }
}
//mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- Latest compiled and minified CSS -->
     <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="bootstrap-5.2.3-dist\js\bootstrap.min.js"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .text_change {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80px;
            margin: 0px;
            background: rgb(65, 202, 192);
            border-radius: 13px 13px 0px 0px;
            color: white;
        }
        .btn-block {
            display: block;
            width: auto;
            background: rgb(65, 202, 192);
            border-color: rgb(65, 202, 192);
        }
        .btn-block:hover {
            background: rgb(65, 202, 192);
            border-color: rgb(65, 202, 192);
        }
    </style>
</head>
<body>
    <section class="">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <h3 class="text_change"> Details</h3>
                        <div class="card-body p-5 text-center">
                            <form id="myForm" action="employee_data.php" method="POST" enctype="multipart/form-data">
                                <!-- <input type="hidden" name="id" value='<//?php echo $row["UID"]; ?>'> -->
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="firstName">firstName</label>
                                    <input type="text" name="firstName" id="firstName" class="form-control form-control-lg" placeholder="Enter Your firstName" value='<?php echo $row["firstname"]; ?>' />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="lastName">lastName</label>
                                    <input type="text" id="typePasswordX-2" name="lastName" class="form-control form-control-lg" placeholder="Enter Your lastName" value='<?php echo $row["lastname"];  ?>' />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="salary">salary</label>
                                    <input type="text" id="salary" name="salary" class="form-control form-control-lg" placeholder="Enter Your salary" value='<?php echo $row["salary"];  ?>' />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="email">Email</label>
                                    <input type="text" id="email" name="Email" class="form-control form-control-lg" placeholder="Enter Your salary" value='<?php echo $row["Email"];  ?>' />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="lastName">Phone Number</label>
                                    <input type="text" id="salary" name="number" class="form-control form-control-lg" placeholder="Enter Your salary" value='<?php echo $row["PhoneNumber"];  ?>' />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="lastName">Image</label>
                                    <?php
                                    $retrievedFileNames = explode(",", $row["picture"]);
                                    foreach ($retrievedFileNames as $image) {
                                        echo '<img src="./uploads/' . $image . '" style="width:100px;height:100px">';
                                    }
                                    ?>
                                    <p>Accept jpeg,jpg,png,gif</p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href = 'employee_data.php';" type="submit">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>