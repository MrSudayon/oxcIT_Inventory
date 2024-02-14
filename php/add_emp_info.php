<?php 
require('db_connection.php');

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);

    if ($user['role'] == 'admin') {
        
        $register = new AddEmployee();

        if(isset($_POST['submit'])) {

            $result = $register->addEmployee($_POST['name'], $_POST['division'], $_POST['location']);
            
            if($result == 1) {
                echo "<script> alert('Registration Successful'); </script>";
            }
            elseif($result == 10) {
                echo "<script> alert('This user already exists'); </script>";
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
    <title>Add Employee</title>
</head>
<body>
    <div class="container">
        <div class="add-form">
            <a href="../admin/dashboard.php" class="return">Back</a>
            
            <form action="" method="POST" autocomplete="off">
                <div class="title">Add Employee</div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">Name:</span>
                        <input type="text" name="name"/>
                    </div>
                    <div class="input-box">
                        <span class="details">Department:</span>
                        <select name="division" required>
                            <option>Please Select</option>
                            <option value="Finance">Finance</option>
                            <option value="Sales/Marketing">Sales/Marketing</option>
                            <option value="IT">IT</option>
                            <option value="Operations">Operations</option>
                            <option value="Sauber">Sauber</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Location:</span>
                        <select name="location" required>
                            <option>Please Select</option>
                            <option value="Pasig">Pasig HO</option>
                            <option value="Mandaluyong">Mandaluyong</option>
                            <option value="Laguna">Laguna</option>
                        </select>
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