<?php 
require('db_connection.php');

$register = new Register();

if(isset($_POST['submit'])) {

    $result = $register->register($_POST['role'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['cpassword']);
    
    if($result == 1) {
        echo "<script> alert('Registration Successful'); </script>";
    }
    elseif($result == 10) {
        echo "<script> alert('Username or Email Has Already Taken'); </script>";
    }
    elseif($result == 100) {
        echo "<script> alert('Password Does Not Match'); </script>";
    }    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/fields.css">
    <title>Register User</title>
</head>
<body>
    <main>
        <div class="register-form">
        <a href="../admin/dashboard.php" class="return">Back</a>


            <div class="register-field">
                <h1> Add User </h1>

                <form action="" method="POST" autocomplete="off">
                    
                    <label for="role"> User Access: </label>
                    <input type="text" name="role" id="role"/><br>

                    <label for="username"> Username: </label>
                    <input type="text" name="username" id="user"/><br>

                    <label for="email"> Email: </label>
                    <input type="email" name="email" id="email"/><br>

                    <label for="password"> Password: </label>
                    <input type="password" name="password" id="pass"/><br>

                    <label for="cpassword"> Confirm Password: </label>
                    <input type="password" name="cpassword" id="cpass"/><br>
                    
                    <button type="submit" name="submit" class="login">Create</button>
                </form>
                <br>
            </div>
        </div>
    </main>
</body>
</html>