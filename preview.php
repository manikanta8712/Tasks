<?php
// database connection
include "connection.php";
if (isset($_GET['previewid'])) {
    $employee_id = $_GET['previewid'];
    //$query = "SELECT * FROM employees WHERE UID ='$employee_id'";
    $queryy = "SELECT * FROM employees WHERE user_ID = '$employee_id'";
 $query_result = mysqli_query($conn,$queryy);
 $rows = mysqli_num_rows($query_result);
 if($rows>0){
    $query = "SELECT employees.*, user.Email, user.Name, user.PhoneNumber, employee_images.image 
    FROM employees INNER JOIN user ON employees.user_ID = user.ID INNER JOIN employee_images ON employees.user_ID = employee_images.user_ID WHERE employees.user_ID = '$employee_id'";
 }else{
    $query = "SELECT *  FROM user WHERE ID = '$employee_id'";
 }
 $query_run = mysqli_query($conn, $query);
    if (mysqli_num_rows($query_run) > 0) {
        $employeeData = array(); // Initialize the $employeeData array
        while ($row = mysqli_fetch_assoc($query_run)) {
            $employeeId = !empty($row['user_ID'])?$row['user_ID']:'';
            if (!isset($employeeData[$employeeId])) {
                // Initialize the employee data
                $employeeData[$employeeId] = array(
                    'UID' => !empty($row['user_ID'])?$row['user_ID']:'',
                    'Name' => !empty($row['Name'])?$row['Name']:'',
                    'Firstname' => !empty($row['firstname'])?$row['firstname']:'',
                    'Lastname' =>!empty( $row['lastname'])?$row['lastname']:'',
                    'Salary' =>!empty( $row['salary'])?$row['salary']:'',
                    'Email' => $row['Email'],
                    'PhoneNumber' => $row['PhoneNumber'],
                    'Images' => array() // Array to store images
                );
            }
            // Add the image to the employee's images array
            if (!empty($row['image'])) {
                $employeeData[$employeeId]['Images'][] = $row['image'];
            }
        }
        $a = 0;
        foreach ($employeeData as $employee) {
            $a = $a + 1;      }
    } else {
        echo "No such id found";
    }
}
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
                        <div class="card-body p-5">
                            <form id="myForm" action="employee_data.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-2">
                                    <span class="font-weight-bold text-uppercase" style="font-weight: 700;">FirstName:</span>
                                    <span class=""><?= $employee['Firstname']; ?></span>
                                </div>
                                <div class="mb-2">
                                    <span class=" text-uppercase" style="font-weight: 700;">LastName:</span>
                                    <span class=""><?= $employee['Lastname']; ?></span>
                                </div>
                                <div class="mb-2">
                                    <span class="form-label text-uppercase" style="font-weight: 700;">salary:</span>
                                    <span class=""><?= $employee['Salary']; ?></span>
                                </div>
                                <div class="mb-2">
                                    <span class="text-uppercase" style="font-weight: 700;">username:</span>
                                    <span class=""><?= $employee['Name']; ?></span>
                                </div>
                                <div class="mb-2">
                                    <span class="text-uppercase" style="font-weight: 700;">Email:</span>
                                    <span class=""><?= $employee['Email']; ?></span>
                                </div>
                                <div class="mb-2">
                                    <span class="form-label text-uppercase" style="font-weight: 700;">Phone Number:</span>
                                    <span class=""><?= $employee['PhoneNumber']; ?></span>
                                </div>
                                <div class="form-outline">
                                    <p class="form-label d-flex" style="font-weight: 700;">Image</p>
                                    <?php
                                    $employeeImages = $employee['Images'];
                                    foreach ($employeeImages as $image) {
                                        $imagePath = explode(",", $image);
                                        echo '<img src="./uploads/' . ltrim($imagePath[0]) . '" class="img" style="width:100px";>';
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

</html>