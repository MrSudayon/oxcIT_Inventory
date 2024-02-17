<?php

include 'php/db_connection.php';

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
    <title>Document</title>
</head>
<body>
    <h1>There's Nothing Here</h1><br>
    <h1>What u doing here <?php echo $user['username']; ?> Log on admin role</h1>

    <a href="./php/logout.php">Logout</a>
    
</body>
</html>