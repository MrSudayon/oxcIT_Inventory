<?php
require '../php/db_connection.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
} else {
    header("Location: ../php/login.php");
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
    <header>
        <div class="logo">
            <img src="../assets/logo.jpg" alt="logo" width="70px">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Assets</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="content">
            <h1>Welcome Admin <?php echo $user['username']; ?></h1>
        
            <br>
            <div class="link-btns">
                <a href="#" class="link-btn">Add</a>
                <a href="#" class="link-btn">Accountability</a>
            </div>
        </div>
    </main>

</body>
</html>