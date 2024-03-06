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
    <link rel="stylesheet" href="../css/config.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>home</title>
</head>
<body>
<?php include '../inc/header.php'; ?>
    
    <div class="content">
        <div class="title">
            <h1>Hello, <span class="uname"><?php echo $username; ?></span>!</h1>
        </div>
        <div class="config-buttons">
            <div class="config-btn"><a href="../admin/dashboard.php" title="Asset"><img src="../assets/icons/config/dash.png"></a><br></div>
            <div class="config-btn"><a href="../admin/create_accountability.php" title="Accountability"><img src="../assets/icons/config/daily-tasks.png"></a></div>
            <div class="config-btn"><a href="../admin/create_turnover.php" title="Turnover"><img src="../assets/icons/config/turnover.png"></a></div>
            <div class="config-btn"><a href="../admin/references.php" title="Reference"><img src="../assets/icons/config/research.png"></a></div>
        </div>
    </div>
    
    <script src="../js/dashboard.js"></script>
</body>
</html>