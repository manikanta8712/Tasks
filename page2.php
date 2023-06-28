<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
session_start();
if(empty($_SESSION['name'])){
    header('location:Login.php');

}
if(!empty($_SESSION['name'])){
    $username = $_SESSION['name'];

}
?>
<div class="container">
<span>Hello <?php if(!empty($_SESSION['name'])){echo $username; }?> Login successful This is Second Page ,</span>
<a href="Logout.php">Logout</a>
<div>
    <a href="page1.php">page1</a>
    <!-- <a href="page2.php">page2</a> -->
    <a href="page3.php">page3</a>
</div>
</div>
<!-- <h1>This is Second Page</h1> -->
</body>

</html>