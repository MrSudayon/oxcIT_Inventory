<?php 
require('../php/db_connection.php');

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);

    if ($user['role'] == 'admin') {
        
        $register = new AddItems();

        if(isset($_POST['submit'])) {

            $result = $register->addDivision($_POST['name']);
            
            if($result == 1) {
                echo "<script> alert('Registration Successful'); </script>";
            }
            elseif($result == 10) {
                echo "<script> alert('This Division already exists'); </script>";
            }
            elseif($result == 100) {
                echo "<script> alert('Something went wrong'); </script>";
            }
        }
    } else {
        echo "<script> alert('Please contact Admin for creating new user'); </script>";
        header("Location: ../index.php");
    }
} else {
    header("Location: ../php/login.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/styles.css"> -->
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/fields.css">
    <title>Add Division</title>
</head>
<body>
    <div class="container">
        <div class="add-form">
            <a href="../admin/dept_List.php" class="return">Back</a>
            
            <form action="" method="POST" autocomplete="off">
                <div class="title">Add Division</div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">Division Name:</span>
                        <input type="text" name="name" style="width: 150%;"/>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="submit" value="Save">
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>