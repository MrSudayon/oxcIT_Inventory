<?php 
include 'db_connection.php';


if(!empty($_SESSION['id'])) {
    header("Location: ../index.php");
}

$login = new Login();
$db = new Connection();
if(isset($_POST['submit'])) {
    $result = $login->login($_POST['username'], $_POST['password']);
    global $db;
    if($result == 1) {

        $_SESSION['login'] = true;
        $_SESSION['id'] = $login->idUser();

        $user_sess = $select->selectUserById($_SESSION['id']);
        $id = $user_sess['id'];
        $name = $user_sess['username'];
      
        // $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
        //                             VALUES ('', '$name', 'Logged in', NOW())");   
        if(!$sql) {
            die('error'.$db->conn->connect_error);
        } else { 

            ?>
                <script>
                    alert('Login Successful');
                    window.location.replace('../admin/dashboard.php');
                </script>
            <?php
        }
        $db->conn->close();
    }
    elseif($result == 2) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $login->idUser();

        $user_sess = $select->selectUserById($_SESSION['id']);
        $id = $user_sess['id'];
        $name = $user_sess['username'];
      
        $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                    VALUES ('', '$name', 'Logged in', NOW())");   
        if(!$sql) {
            die('error'.$db->conn->connect_error);
        } else { 
            ?>
                <script>
                    alert('Login Successful');
                    window.location.replace('../index.php');
                </script>
            <?php
        }
        $db->conn->close();

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
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>
<body>
    <main>
        <div class="login-form">
            <div class="logo">
                <img src="../assets/logo.png" alt="logo" width="300px">
            </div>
            <div class="login-field">
                <form action="" method="POST" autocomplete="off">
                    
                    <label for="username"> Username: </label>
                    <input type="text" name="username" placeholder="Username" required>

                    <label for="password"> Password: </label>
                    <input type="password" name="password" placeholder="Password" required>
                    <br>
                    <button type="submit" name="submit" class="login">Login</button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>