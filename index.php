<?php
session_start();
if(empty($_SESSION['name'])){
    header('location:Login.php');

}
if(!empty($_SESSION['name'])){
    $username = $_SESSION['name'];

}
?>
<h1>Hi</h1>