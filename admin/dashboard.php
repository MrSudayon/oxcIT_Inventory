<?php
require '../php/db_connection.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
} else {
    header("Location: ./php/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <!-- <div class="side-menu side-menu-admin" id="mySidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
     
    </div> -->

    <div class="header">
        <div class="logo"> OXYCHEM </div>
        <div class="navigators"></div>
    </div>
    <div class="content">
        <h1>Welcome Admin <?php echo $user['username']; ?></h1>
        <!-- <a href="../php/logout.php">Logout</a> -->
    </div>


    <script src="../js/sidebar_nav.js"></script>
</body>
</html>