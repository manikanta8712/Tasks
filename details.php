<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>MyForms</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <style>

        .error {
            color: red;
            font-weight: 500;
            padding-bottom: 0px;
        }
    </style>
</head>

<body>
<?php
// session_start();

// if(empty($_SESSION['name'])){
//     header('location: loginForm.php');
//     exit; 
// }

// $user = $_SESSION['name'];

// include ('connection.php');

// $sql = "SELECT Email FROM users WHERE Name='$user'";
// $result = $conn->query($sql);
// $row = $result->fetch_assoc();
// $email = $row["Email"];
// if (isset($_POST['submit'])) {
//     $sql = 'CREATE TABLE employee( '.
//     'Id INT NOT NULL AUTO_INCREMENT, '.
//     'Firstname VARCHAR(50) NOT NULL, '.
//     'Lastname  VARCHAR(50) NOT NULL, '.
//     'Salary   DECIMAL(10, 2) NOT NULL, '.
//     'ProfilePic BLOB NOT NULL, '.
//     'primary key ( Id ))';

//  $retval = mysqli_query( $conn,$sql );
 
 
//  $Firstname = $_POST['firstname'];
//  $Lastname = $_POST['lastname'];
//  $Salary = $_POST['salary'];
//  $Profilepic = $_POST['profilepic'];
//  $data = "INSERT INTO employee ". "(Firstname,Lastname, Salary, 
//  ProfilePic) ". "VALUES('$Firstname','$Lastname',$Salary, $Profilepic)";
      
//       $retva = mysqli_query( $conn,$data );
   
//    if(! $retva ) {
//       die('Could not enter data: ' . $conn->connect_error);
//    }
   
//    echo "Entered data successfully\n";
// }


// // Close the database connection
// mysqli_close($conn);

session_start();

if (empty($_SESSION['name'])) {
    header('location: loginForm.php');
    exit; 
}

$user = $_SESSION['name'];

include ('connection.php');

$sql = "SELECT Email FROM users WHERE Name='$user'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$email = $row["Email"];





if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $salary = $_POST['salary'];
    $profilepic = $_FILES['profilepic']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
   
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["profilepic"]["name"]). " has been uploaded.";
    } else {
        echo "";
    }

    $image=basename( $_FILES["profilepic"]["name"],".jpg"); // used to store the filename in a variable
    

    
    //$imagee = $_FILES['profilepic']['tmp_name'];
    
    $data = "INSERT INTO employee (ID,Firstname, Lastname, Salary,Image) " .
                "VALUES ('1','$firstname', '$lastname', $salary , '$image')";

        $retva = mysqli_query($conn, $data);

        if (!$retva) {
            die('Could not enter data: ' . $conn->error);
        }else{
            header('location: page1.php');
        }

    
}



//$filenamee = $_FILES['file']['name'];



// if (isset($_POST['firstname'])&& isset($_POST['lastname']) && isset($_POST['salary'])) {
//     $firstname = $_POST['firstname'];
// $lastname = $_POST['lastname'];
// $salary = $_POST['salary'];
// $filename = $_FILES['profilepic']['name'];
//     $getparentID = $conn->query("SELECT ID FROM users where Email='$email'");
    
//     while($row=mysqli_fetch_assoc($getparentID)){
//         $value1=$row['ID'];
//         $_SESSION['ID']=$row['ID'];
//     }

//     $extension = pathinfo($filename, PATHINFO_EXTENSION);
//     $imgallowedtypes = array('jpg', 'jpeg', 'png', 'bpm', 'gif');


//     if (in_array($extension, $imgallowedtypes)) {
//         $image = $_FILES['profilepic']['tmp_name'];
//         $imgContent = addslashes(file_get_contents($image));
//         $mainquery = $conn->prepare("INSERT INTO employee (ID, Firstname, Lastname, Salary, Image) VALUES ('$value1', '$firstname', '$lastname', '$salary', '$imgContent')");
//         $mainquery->execute();
//         header('location: page1.php');

//     }
//     else{
//         header('location: details.php');
//         echo 'Failed';
//     }



// }
// Close the database connection
mysqli_close($conn);









?>
<center><h1>Hai <?php echo $user; ?> Login successful</h1></center>
<center><h2>This Is Your Email <?php echo $email; ?></h2></center>
<center><h2><a href="logout.php">Logout</a></h2></center>
<center><h3><a href="page1.php">Page 1</a></h3></center>
<center><h3><a href="page2.php">Page 2</a></h3></center>
<center><h3><a href="page3.php">Page 3</a></h3></center>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class=" shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body ">
                        <form action="details.php" method="post" enctype="multipart/form-data" class="form-signin" id="myForm">
                        <h2 class="form-signin-heading">Enter Details</h2>
                        <div class="login-wrap">
                            <div class="form-outline mb-2">
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter First Name" />
                            </div>
                            <div class="form-outline mb-2">
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter Last Name" />
                            </div>
                            <div class="form-outline mb-2">
                                <input type="text" class="form-control" name="salary" id="salary" placeholder="Enter Salary" />
                            </div>
                            <div class="form-outline">
                                <input type="file" class="form-control" name="profilepic" id="profilepic"  />
                            </div>
                            <span class="FormHint">Accepted extensions: JPG, JPEG, PNG, GIF.</span>
                            <button type="submit" name="submit" class="btn btn-lg btn-block btn-login mt-5">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        $.validator.addMethod("extension", function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, "|") : "jpg|jpeg|gif|png";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, "Please enter a valid image file.");
        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        });
        $("#myForm").validate({
            rules: {
                firstname: {
                    required: true,
                    lettersonly: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    maxlength: 50
                },
                lastname: {
                    required: true,
                    lettersonly: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    maxlength: 50
                },
                salary: {
                    required: true,
                    normalizer: function(value) {
                      return $.trim(value);
                    },
                    minlength: 2,
                    digits: true,
                },
                profilepic: {
                    //required: true,
                    extension: "jpg|jpeg|png|gif",
                },

            },
            messages: {
                firstname: {
                    required: "Please Enter First Name.",
                    maxlength: "Maximum Limit For First Name Is 50.",
                    lettersonly: "Invalid Characters."
                },
                lastname: {
                    required: "Please Enter Last Name.",
                    maxlength: "Maximum Limit For Last Name Is 50.",
                    lettersonly: "Invalid Characters."
                },
                salary: {
                    required: "Please Enter Your Salary.",
                    minlength: "Minimum 2 digits required.",
                    digits: "Please Enter Valid salary.",
                },
                profilepic: {
                    //required: "Please Upload Your profilepic",
                    extension: "Invalid File.",
                },
            },
        });
    </script>
</body>

</html>