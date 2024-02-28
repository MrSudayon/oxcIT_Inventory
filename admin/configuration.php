<?php
require_once '../php/db_connection.php';

$select = new Select();
$getAllRecord = new Operations();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);

    $id = $user['id'];
    $username = $user['username'];

} else {
    header("Location: ../php/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Configuration</title>
</head>
<style>
.contents {
    min-height: 100dvh;
    background: linear-gradient(-95deg, var(--ter-color), var(--bg-color));
    padding: 10px 40px;
    overflow: hidden;
}
.config-buttons {
    border: 1px solid black;
    display: flex;
    justify-content: space-evenly;
}
.config-btns img {
    height: 200px;
    width: auto;
    
}

</style>
<body>
    <?php include '../inc/header.php'; ?>
    
        <div class="contents">
            <div class="title">
                <h1> Configuration Dashboard </h1>
            </div>
            <div class="config-buttons">
                <div class="config-btns">
                    <a href="../admin/emp_List.php" class="config-btn"><img src="../assets/icons/config/employee.png"></a>
                    <a href="../admin/asset_List.php" class="config-btn"><img src="../assets/icons/config/asset.png"></a>
                    <a href="../admin/dept_List.php" class="config-btn"><img src="../assets/icons/config/division.png"></a>
                    <a href="../admin/location_List.php" class="config-btn"><img src="../assets/icons/config/location.png"></a>
                </div>
            </div>
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>