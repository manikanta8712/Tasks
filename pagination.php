<table border="1">
    <tr>
    <th>ID</th>
    <th>NAME</th>
    <th>AGE</th>
    </tr>
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "task";
$conn = mysqli_connect($servername,$username,$password,$databasename);
if(!$conn){
    die("connection failed").mysqli_connect();
}
//$sql = "SELECT * FROM student_details LIMIT 5";
$sql = "SELECT * FROM student_details LIMIT 3, 8";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <th><?php echo $row['ID'];?></th>
            <th><?php echo $row['Name'];?></th>
            <th><?php echo $row['Age'];?></th>
        </tr>
        <?php
    }
}
?>