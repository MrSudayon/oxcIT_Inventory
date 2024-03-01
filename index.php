<?php

include 'php/db_connection.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);

    $id = $user['id'];
    $username = $user['username'];
    $role = $user['role'];

    if($role == 'admin') {
        header("Location: ./admin/dashboard.php");
        die();
    } else {
        header("Location: ../index.php");
        die();
    }

} else {
    header("Location: ./php/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <h1>There's Nothing Here</h1><br>
    <h1>What u doing here <?php echo $user['username']; ?> Log on admin role</h1>

    <a href="./php/logout.php?id=<?php echo $id; ?>&name=<?php echo $username; ?>">Logout</a>
    
</body>
</html>