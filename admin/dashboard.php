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
            <img src="../assets/logo.png" alt="logo" width="200px">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="../php/register.php">Users</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="content">
            <h1> Assets </h1><br>
            <table class="assets-table">
                <tr>
                    <th>User</th>
                    <th>Department</th>
                    <th>Asset Type</th>
                    <th>Asset Tag</th>
                    <th>Model</th>
                    <th>CPU</th>
                    <th>Memory</th>
                    <th>Storage</th>
                    <th>Status</th>
                    <th>Date Deployed</th>
                    <th>Date Turnover</th>
                    <th coslpan="2">Action</th>
                </tr>
                
                <tr>
                <?php 
                    $getAllRecord = new Operations();

                    $Records = $getAllRecord->getAllData();

                    // foreach($Records as $data) {
                    while($row = mysqli_fetch_assoc($Records)) {
                    
                ?>
                    <td><?php echo $row['assigned']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['assettype']; ?></td>
                    <td><?php echo $row['assettag']; ?></td>
                    <td><?php echo $row['model']; ?></td>
                    <td><?php echo $row['CPU']; ?></td>
                    <td><?php echo $row['MEMORY']; ?></td>
                    <td><?php echo $row['STORAGE']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['datedeployed']; ?></td>
                    <td><?php echo $row['dateturnover']; ?></td>

                    <td>
                    <center>
                        <a href="update.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="32px"></a>&nbsp;
                        <a href="remove.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/remove.png" width="32px"></a>
                    </center>
                        
                    </td>    
                
                </tr>
                <?php
                    }
                ?>
            </table>
            
            <div class="link-btns">
                <a href="add-assets.php" class="link-btn">Add</a>
                <a href="accountability.php" class="link-btn">Accountability</a>
            </div>
            
        </div>
    </main>

</body>
</html>