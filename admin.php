<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Latest compiled and minified CSS -->
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="bootstrap-5.2.3-dist\js\bootstrap.min.js"></script>
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
            width: 100%;
            background: rgb(65, 202, 192);
            border-color: rgb(65, 202, 192);
        }
    </style>
</head>
<?php
// session_start();
// $servername = "localhost";
// $username = "root";
// $password = "";
// $databasename = "task";
// // Create connection
// $conn = new mysqli($servername, $username, $password, $databasename);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// if (isset($_POST['Email']) &&  isset($_POST['password'])) {
//     $email = $_POST['Email'];
//     $password = $_POST['password'];
//     $crypted = md5($password);
//     // echo $email . "<br>";
//     // echo $crypted;
// }
// $sql = "SELECT  Email, Password FROM user";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     // output data of each row
//     while ($row = $result->fetch_assoc()) {
//         $Email = $row["Email"];
//         $Password = $row["Password"];
//         // echo $Email . "<br>";
//         // echo $Password;
//     }
// } else {
//     echo "0 results";
// }
// if ($email != $Email) {
//     echo "Invalid Email";
// } else if ($email == $Email && $crypted != $Password) {
//     echo "Email and Password Not Matched";
// } else {
//     header('location: message.php');
// }
//echo $Email . "<br>";
//echo $email;
//$conn->close();
//session_destroy();

?>

<?php
session_start();
// MySQLi Object-Oriented
// $servername = "localhost";
// $username = "root";
// $password = "";
// $databasename = "task";
// // Create connection
// $conn = new mysqli($servername, $username, $password, $databasename);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
include "connection.php";

if (isset($_POST['Email']) && isset($_POST['Password'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $hashedPlaintextPassword = md5($password);
    $sql = "SELECT Email, Password, Name FROM user";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $emailMatched = false;
        $passwordMatched = false;
        while ($row = $result->fetch_assoc()) {

            $emailFromDB = $row["Email"];
            //strtolower($emailFromDB);
            $passwordFromDB = $row["Password"];
            if (strtolower($email) === strtolower($emailFromDB)) {
                $emailMatched = true;
                if ($hashedPlaintextPassword === $passwordFromDB) {

                    $passwordMatched = true;

                    $name = $row["Name"];
                    $admin = $row["admin"];
                    
                    //$_SESSION['email'] = $emailFromDB;
                    $_SESSION['name'] = $name;
                    $_SESSION['admin'] = $admin;
                    header('Location:employee_data.php');
                    exit;
                }
            }
        }
        if (!$emailMatched) {
            $show_error = "Invalid Email";
        } elseif (!$passwordMatched) {
            $show_error = "Email and Password Not Matched";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
}
?>

<body>
    <!-- <div class="container d-flex justify-content-center mt-3">
        <div class="col-6">
            <form action="Login.php" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="text" name="Email" class="form-control" id="exampleFormControlInput1" placeholder="Enter Email">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="form-label">password</label>
                    <input type="password" name="Password" class="form-control" id="exampleFormControlInput2" placeholder="Enter password">
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <input class="btn btn-primary" name="submit" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div> -->
    <!--  -->
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <h3 class="text_change">Admin</h3>
                        <div class="card-body p-5 text-center">

                            <!-- <h3 class="mb-5">Sign in</h3> -->
                            <form action="Login.php" method="POST">
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="typeEmailX-2">Email</label>
                                    <input type="email" name="Email" id="typeEmailX-2" class="form-control form-control-lg" placeholder="Enter Your Email" />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex" for="typePasswordX-2">Password</label>
                                    <input type="password" id="typePasswordX-2" name="Password" class="form-control form-control-lg" placeholder="Enter Your password" />
                                </div>
                                <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Login</button>
                                <p><?php if (!empty($show_error)) {
                                        echo $show_error;
                                    } ?></p>
                            </form>
                            <hr class="my-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>