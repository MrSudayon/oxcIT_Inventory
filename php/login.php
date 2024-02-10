<?php 
require('db_connection.php');

if(!empty($_SESSION['id'])) {
    header("Location: ../index.php");
}

$login = new Login();

if(isset($_POST['submit'])) {

    $result = $login->login($_POST['username'], $_POST['password']);

    if($result == 1) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $login->idUser();
        header("Location: ../admin/dashboard.php");
        echo "<script> alert('Login Successful'); </script>";
    } 
    elseif($result == 2) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $login->idUser();
        header("Location: ../index.php");
        echo "<script> alert('Login Successful'); </script>";
    } 
    elseif($result == 10) {
        echo "<script> alert('Wrong Password'); </script>";
    } 
    elseif($result == 100) {
        echo "<script> alert('User doesn't exists'); </script>";
    }    
    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login</title>
</head>
<body>
    <div class="login-form">
        <div class="logo">
            <img src="../assets/logo.jpg" style="height: 180px; width: auto;"></img>
        </div>
        <div class="login-field">
            <form action="" method="POST" autocomplete="off">
                
                <label for="username"> Username: </label>
                <input type="text" name="username" id="user" required>

                <label for="password"> Password: </label>
                <input type="password" name="password" id="pass" required>

                <button type="submit" name="submit" class="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>