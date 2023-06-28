<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <!-- <style>
        .container {
            max-width: 400px;
            /* margin: 0 auto;
      margin-top: 100px; */
        }
    </style> -->
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
    include "connection.php";

    session_start();
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
    // $conn->close();

    // if(empty($_SESSION['email'])){
    //     header('location:Login.php');

    // }

    // if (!empty($_SESSION['name'])) {
    //     $username = $_SESSION['name'];
    // }
    ?>
    <div class="container">
        <span>Hello <?php
                    echo $username . "," .
                        $email; ?> Login successful ,</span>

        <a href="Logout.php">Logout</a>
        <div>
            <a href="page1.php">page1</a>
            <a href="page2.php">page2</a>
            <a href="page3.php">page3</a>
        </div>
        <h1>This is welcome Page</h1>
        <!-- <h2 class="text-center">Login</h2>
        <form id="myForm" method="post" action="success_message.php">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name">
            </div>
            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="text" class="form-control" id="salary" name="salary" placeholder="Enter your salary">
            </div>
            <div class="form-group mt-2 mb-2">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="imageUpload" name="image">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form> -->
    </div>
    <!-- <//?php if (isset($_POST['image']) && isset($_POST['firstName'])) {
        $img = $_POST['image'];
        echo $img;
    } ?> -->
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
    <?php
    include "connection.php";

    // $sql2 = "CREATE TABLE employee(
    //         Emp_ID INT Auto_increment,
    //         firstname VARCHAR(30) NOT NULL,
    //         lastname VARCHAR(30) NOT NULL,
    //         salary DECIMAL(10,2),
    //         picture VARCHAR(255),
    //         foreign key(Emp_ID) references user(ID),
    // )";
    // $sql2 = "CREATE TABLE employees(
    //     UID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    //     firstname VARCHAR(30) NOT NULL,
    //     lastname VARCHAR(30) NOT NULL,
    //     salary FLOAT(10,2),
    //     picture VARCHAR(255),
    //     user_ID INT NOT NULL,
    //     foreign key(user_ID) references user(ID)
    // )";
    // if ($conn->query($sql2) === TRUE) {
    //     echo "Table employee created successfully";
    // } else {
    //     echo "Error creating table: " . $conn->error;
    // }

        // single file upload

    // if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['salary']) && isset($_FILES['image']['name'])) {
    //     $firstName = $_POST['firstName'];
    //     $lastName = $_POST['lastName'];
    //     $salary = $_POST['salary'];
    //     $img = $_FILES['image']['name'];
    //     $target_dir = "./uploads/";
    //     $target_file = $target_dir . basename($_FILES['image']['name']);

    //     if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    //         echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
    //     }
    //     $image = $_FILES["image"]["name"]; // used to store the filename in a variable
    //     $getparentID = $conn->query("SELECT ID FROM user where Email='$email'");
    //     while($row=mysqli_fetch_assoc($getparentID)){

    //     $value1=$row['ID'];

    //     //$_SESSION['id'] = $row['ID'];

    // }
    //     $data = "INSERT INTO employees (firstname, lastname, salary,picture,user_ID)
    // VALUES ('$firstName', '$lastName', '$salary','$image','$value1')";

    //     if ($conn->query($data) === TRUE) {
    //         echo "New record created successfully";
    //     } else {
    //         echo "Error: " . $data . "<br>" . $conn->error;
    //     }
    // }

    //multiple file upload
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['salary']) && isset($_FILES['image']['name'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $salary = $_POST['salary'];
    
        $target_dir = "./uploads/";
    
        // Loop through each uploaded file
        $fileNames = array();
        foreach ($_FILES['image']['name'] as $key => $name) {
           // echo $_FILES['image']['name'];
            $target_file = $target_dir . basename($name);
            $fileNames[] = $name;
    
            if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $target_file)) {
                echo "The file " . basename($name) . " has been uploaded.";
            }
        }
    
        // Convert array of file names to a comma-separated string
        $images = implode(',', $fileNames);
    
        $getparentID = $conn->query("SELECT ID FROM user WHERE Email='$email'");
        while ($row = mysqli_fetch_assoc($getparentID)) {
            $value1 = $row['ID'];
        }
    
        $data = "INSERT INTO employees (firstname, lastname, salary, picture, user_ID)
                 VALUES ('$firstName', '$lastName', '$salary', '$images', '$value1')";
    
        if ($conn->query($data) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $data . "<br>" . $conn->error;
        }
    }
    

    $conn->close();
    ?>
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