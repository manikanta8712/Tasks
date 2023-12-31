<?php 
session_start();
 include "connection.php";
 $id = $_SESSION['id'];
 $query = "SELECT * FROM employees WHERE user_ID = '$id'";
 $query_result = mysqli_query($conn,$query);
 $rows = mysqli_num_rows($query_result);
 if($rows>0){
    //echo "hello";
    header("Location:employee_data.php");
    ?>
    <?php
 }
 else{
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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
    <?php
   // session_start();
    //include "connection.php";
    if (empty($_SESSION['name'])) {
        header('location:Login.php');
        exit();
    }
    $username = $_SESSION['name'];
    $sql = "SELECT Email  FROM user WHERE Name = '$username'";
    $result = $conn->query($sql);
    //print_r($result);
    //print_r($result->num_rows);
    //exit();
    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        //$row = $result->fetch_array();
        //$row = $result->fetch_object();
        //$row = $result->fetch_all();
        //print_r($row);
        //exit();
        $email = $row["Email"];
    } else {
        $email = "Email Not Found";
    }
    // if(empty($_SESSION['email'])){
    //     header('location:Login.php');
    // }
    // if (!empty($_SESSION['name'])) {
    //     $username = $_SESSION['name'];
    // }

    $check_id =  $_SESSION['id'];

    //multiple file upload
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['salary']) && isset($_FILES['image']['name'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $salary = $_POST['salary'];
        $profilepics = $_FILES['image']['name'];
        $getparentID = $conn->query("SELECT ID FROM user where Email='$email'");
        while ($row = mysqli_fetch_assoc($getparentID)) {
            $value1 = $row['ID'];
            $_SESSION['id'] = $row['ID'];
        }
        // Loop through each uploaded file
        
        foreach ($_FILES['image']['name'] as $key => $name) {
            $fileNames = array();
            $target_dir = "./uploads/";
            // echo $target_dir;
            // exit;
            $uniqueFileName = uniqid() . '_' .time(). $name; // Generate a unique file name
            $target_file = $target_dir.basename($uniqueFileName);
            // echo $target_file;
            // exit;
            $fileNames[] = $uniqueFileName;
            // $target_dir = "uploads/";
            //$target_file = $target_dir . $newFileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $target_file)) {
                echo "The file " . basename($name) . " has been uploaded as " . basename($uniqueFileName) . ".";
                 // Convert array of file names to a comma-separated string
        $images = implode(',', $fileNames);
                // Start the transaction for each file
                mysqli_begin_transaction($conn);
                try {
                    // Update the employeeImage table
                    $username = $_SESSION['name'];
                    $userData = "INSERT INTO employee_images (username,image, user_ID) " .
                        "VALUES ('$username','$images', '$value1')";
                    mysqli_query($conn, $userData);
                    mysqli_commit($conn);
                } catch (Exception $e) {
                    // Rollback the transaction on error
                    mysqli_rollback($conn);
                    echo "Error updating data: " . $e->getMessage();
                }
            } else {
                echo "";
            }
        }
        // Start the transaction for the employee table
        mysqli_begin_transaction($conn);
        try {
            // insert the employee table
            $data = "INSERT INTO employees (firstname, lastname, salary, user_ID) " .
                "VALUES ('$firstName', '$lastName', $salary, '$value1')";
            mysqli_query($conn, $data);
            mysqli_commit($conn);
           // $_SESSION['status'] = 'Data Inserted Successfully';
             header('Location: employee_data.php');
        } catch (Exception $e) {
            // Rollback the transaction on error
            mysqli_rollback($conn);
            echo "Error updating data: " . $e->getMessage();
        }
        // Close the database connection
    mysqli_close($conn);
    }
    $userid = $_SESSION['id'];
    ?>
    <div class="container">
        <span>Hello <?php
                    echo $username . "," .
                        $email; ?> Login successful ,</span>

        <a class="btn btn-primary" href="Logout.php">Logout</a>
        <a class="btn btn-primary" onclick="<?php $_SESSION['idd'] = $userid;?>" href="employee_data.php">List View</a>
        <div>
            <a href="page1.php">page1</a>
            <a href="page2.php">page2</a>
            <a href="page3.php">page3</a>
        </div>
        <h1>This is welcome Page</h1>
            </div>
            </div>
    <section class="">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <h3 class="text_change">Enter Details</h3>
                        <div class="card-body p-5 text-center">

                            <!-- <h3 class="mb-5">Sign in</h3> -->
                            <form id="myForm" action="success_message.php" method="POST" enctype="multipart/form-data">
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="firstName">firstName</label>
                                    <input type="text" name="firstName" id="firstName" class="form-control form-control-lg" placeholder="Enter Your firstName" />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="lastName">lastName</label>
                                    <input type="text" id="typePasswordX-2" name="lastName" class="form-control form-control-lg" placeholder="Enter Your lastName" />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="lastName">salary</label>
                                    <input type="text" id="salary" name="salary" class="form-control form-control-lg" placeholder="Enter Your salary" />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="lastName">Image</label>
                                    <input type="file" id="image" name="image[]" class="form-control form-control-lg" multiple />
                                    <p>Accept jpeg,jpg,png,gif</p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">SUBMIT</button>
                                </div>
                            </form>
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
                    digits: true,
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
                    digits: "Please enter only digits",
                },
                image: {
                    required: "please upload image",
                    extension: "please upload image jpg,jpeg,gif,png",
                },
            },
            submitHandler: function(form) {
                // Called when the form is valid and ready to be submitted
                form.submit();
            }
        });
    </script>
</body>
</html>
    <?php
 }
?>