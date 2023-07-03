<?php

include "connection.php";

if (isset($_POST['submit'])) {
    $employee_id = $_POST['id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$salary = $_POST['salary'];
$phoneNumber = $_POST['number'];
$target_dir = "./uploads/";

// Check if new images were uploaded
if (!empty($_FILES['image']['name'][0])) {
    // Loop through each uploaded file
    $fileNames = array();
    foreach ($_FILES['image']['name'] as $key => $name) {
        $uniqueFileName = uniqid() . '_' . time() . $name; // Generate a unique file name
        $target_file = $target_dir . basename($uniqueFileName);
        $fileNames[] = $uniqueFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $target_file)) {
            echo "The file " . basename($name) . " has been uploaded as " . basename($uniqueFileName) . ".";
        }
    }

    // Convert array of file names to a comma-separated string
    $images = implode(',', $fileNames);
    $image = $images;
} else {
    $sql_query = "SELECT picture FROM employees WHERE user_ID = '$employee_id'";
    $squery = mysqli_query($conn, $sql_query);
    $rows = mysqli_fetch_array($squery);
    $image = $rows['picture'];
}

$sql = "UPDATE employees
    JOIN user ON employees.user_ID = user.ID
    SET employees.firstname = '$firstName',
        employees.lastname = '$lastName',
        employees.salary = '$salary',
        employees.picture = '$image',
        user.PhoneNumber = '$phoneNumber'
    WHERE employees.user_ID = '$employee_id'";

$result = mysqli_query($conn, $sql);
session_start();
if ($result) {
    header("location:employee_data.php");
    $success = "Updated Successfully";
    $_SESSION['msg'] = $success;
} else {
    die(mysqli_error($conn));
}

}
// if (isset($_GET['id'])) {
//     $employee_id = $_GET['id'];
//     $query = "SELECT * FROM employees WHERE UID ='$employee_id'";
//     $query_run = mysqli_query($conn, $query);
//     $firstName = $_POST['firstName'];
//     $lastName = $_POST['lastName'];
//     $salary = $_POST['salary'];

// }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
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
                        <h3 class="text_change">Edit Details</h3>
                        <div class="card-body p-5 text-center">
                            <?php

                            if (isset($_GET['updateid'])) {

                                $employee_id = $_GET['updateid'];

                                // $query = "SELECT * FROM employees WHERE UID='$employee_id' ";
                                $query1 = "SELECT employees.*, user.PhoneNumber FROM employees 
                                JOIN user ON employees.user_ID = user.ID WHERE employees.user_ID = '$employee_id'";
                                $query_run = mysqli_query($conn, $query1);
                                if (mysqli_num_rows($query_run) > 0) {
                                    $row = mysqli_fetch_array($query_run);
                            ?>
                                    <form id="myForm" action="edit.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value='<?php echo $row["user_ID"]; ?>'>
                                        <div class="form-outline mb-4">
                                            <label class="form-label d-flex" for="firstName">firstName</label>
                                            <input type="text" name="firstName" id="firstName" class="form-control form-control-lg" placeholder="Enter Your firstName" value='<?php echo $row["firstname"]; ?>' />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label d-flex" for="lastName">lastName</label>
                                            <input type="text" id="typePasswordX-2" name="lastName" class="form-control form-control-lg" placeholder="Enter Your lastName" value='<?php echo $row["lastname"];  ?>' />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label d-flex" for="lastName">salary</label>
                                            <input type="text" id="salary" name="salary" class="form-control form-control-lg" placeholder="Enter Your salary" value='<?php echo $row["salary"];  ?>' />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label d-flex" for="lastName">PhoneNumber</label>
                                            <input type="text" id="salary" name="number" class="form-control form-control-lg" placeholder="Enter Your Phone Number" value='<?php echo $row["PhoneNumber"];  ?>' />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label d-flex" for="lastName">Image</label>
                                            <?php
                                            $retrievedFileNames = explode(",", $row["picture"]);
                                            foreach ($retrievedFileNames as $image) {
                                                echo '<img src="./uploads/' . $image . '" style="width:100px;height:100px">';
                                            }

                                            ?>
                                            <input type="file" id="image" name="image[]" class="form-control form-control-lg" multiple />

                                            <p>Accept jpeg,jpg,png,gif</p>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">SUBMIT</button>
                                        </div>
                                    </form>
                            <?php

                                } else {

                                    echo "No such id found";
                                }
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $.validator.addMethod("extension", function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, "|") : "jpg|jpeg|gif|png";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, "Please enter a valid image file.");

        $("#myForm").validate({
            rules: {
                firstName: {
                    required: true,
                    //regex: "^[a-zA-Z0-9-_.(&),\'/ ]+$",
                },
                lastName: {
                    required: true,
                    // regex: "^[a-zA-Z0-9-_.(&),\'/ ]+$",
                },
                salary: {
                    required: true,
                    //digits: true,
                    minlength: 2,
                },
                image: {
                    required: true,
                    extension: "jpg|jpeg|gif|png",
                },
            },
            messages: {
                firstName: {
                    required: "Please Enter firstName.",
                    //regex: "Invalid Characters.",
                },
                lastName: {
                    required: "Please Enter lastName.",
                    //regex: "Invalid Characters.",
                },
                salary: {
                    required: "Please enter your salary",
                    //digits: "Please enter only digits",
                },
                image: {
                    required: "please upload image",
                    extension: "please upload image jpg,jpeg,gif,png",
                },
            },
            // submitHandler: function(form) {
            //     // Called when the form is valid and ready to be submitted
            //     form.submit();
            // }
        });
    </script>

</body>

</html>