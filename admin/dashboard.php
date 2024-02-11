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
            <h2>Welcome Admin <?php echo $user['username']; ?></h2><br>
            <h1> Assets </h1>
            <table class="assets-table">
                <tr>
                    <th>User</th>
                    <th>Department</th>
                    <th>Asset Type</th>
                    <th>Asset Tag</th>
                    <th>Model</th>
                    <th>Socification</th>
                    <th>Status</th>
                    <th>Date Deployed</th>
                    <th>Date Turnover</th>
                    <th coslpan="2">Action</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="#">Update</a>
                        <a href="#">Delete</a>
                    </td>                    
                </tr>
            </table>
            
            
            <div class="link-btns">
                <a href="add-assets.php" class="link-btn">Add</a>
                <a href="#" class="link-btn">Accountability</a>
            </div>
            
        </div>
    </main>

</body>
</html>