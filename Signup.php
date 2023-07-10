<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Latest compiled and minified CSS -->
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="bootstrap-5.2.3-dist\js\bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <style>
        .gradient-custom-3,
        button {
            background: linear-gradient(to bottom right, #ff7f50, #ff6b6b);
        }

        button {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    // connection
    include "connection.php";

    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['number'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = md5($password);
        $number = $_POST['number'];
        $admin = isset($_POST['option']) ? $_POST['option'] : 0;
        // Check if the email already exists
        $checkQuery = "SELECT * FROM user WHERE Email = '$email'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            $Error_msg = "Email already exists.";
        } else {
            // Insert data
            $insertQuery = "INSERT INTO user (Name, Email, Password, PhoneNumber, admin) " .
                "VALUES ('$name', '$email', '$hashedPassword', '$number', '$admin')";
            $insertResult = $conn->query($insertQuery);

            if ($insertResult) {
                echo "Registred Successfully";
                header("Location: Login.php");
            } else {
                echo "Error: Data not inserted.";
            }
        }
    }
    ?>
    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                                <form id="myForm" method="POST" action="Signup.php">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                                        <span style="color: red;"><?php if (isset($Error_msg)) : ?>
                                                <?= $Error_msg; ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" name="number" id="phone" placeholder="Enter your phone number">
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" name="option" type="checkbox" value="1" id="admin">
                                            <label class="form-check-label" for="admin">Admin</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn">Register</button>
                                    </div>
                                    <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="Login.php" class="fw-bold text-body"><u>Login here</u></a></p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $("#myForm").validate({
            rules: {
                Name: {
                    required: true,
                    //regex: "^[a-zA-Z0-9-_.(&),\'/ ]+$",
                },
                email: {
                    email: true,
                    required: true,
                    // regex: "^[a-zA-Z0-9-_.(&),\'/ ]+$",
                },
                password: {
                    required: true,
                },
            },
            messages: {
                Name: {
                    required: "Please Enter Name.",
                    //regex: "Invalid Characters.",
                },
                email: {
                    email: "Please Enter email.",
                    //regex: "Invalid Characters.",
                },
                password: {
                    required: "Please enter your password",
                },
            },
            submitHandler: function(form) {
                // Called when the form is valid and ready to be submitted
                form.submit();
            }
        });
    </script>
    </script>
</body>

</html>