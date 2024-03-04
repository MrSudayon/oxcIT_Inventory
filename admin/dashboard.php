<?php
require_once '../php/db_connection.php';

$select = new Select();
$getAllRecord = new Operations();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);

    $id = $user['id'];
    $username = $user['username'];

    $sql = mysqli_query($db->conn, "SELECT * FROM users_tbl WHERE id='$id'");

    $row = $sql->fetch_assoc();
    $role = $row['role'];

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
    <title>Admin Dashboard</title>
    <script src="../js/dashboard.js"></script>
</head>
<style>
    .table-nav {
        display: flex;
        justify-content: space-around;
    }
</style>
<body>
    <?php include '../inc/header.php'; ?>
    
        <div class="content">
            <div class="title">
                <h1> ASSET DASHBOARD </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
            
            <form action="" method="get">
                <div class="table-nav">
                    <div class="link-btns">
                        <a href="add-assets.php" class="link-btn">New Item</a>
                        <!--  -->
                        <button type="submit" formaction="accountability.php" class="link-btn" name="accountability">Accountability</button>
                        <button type="submit" formaction="turnover.php" class="link-btn" name="turnover">Turnover</button>
                        <button type="submit" formaction="references.php" class="link-btn" name="references">Reference</button>
                        <button type="submit" formaction="report.php" class="link-btn" name="turnover" >Report</button>
                    </div>
                    <?php
                        $searchData = $getAllRecord->searchData();
                        $rowCount = $searchData->num_rows;
                    ?>
                    <div class="count">
                        <p>Asset count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCount; ?></b></p>
                    </div>
                </div>
                
                <table class="assets-table" id="myTable">
                    <thead>
                    <tr>
                        <th><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                        <th width="20%">User</th>
                        <th width="1%">Department</th>
                        <th>Asset Type</th>
                        <th>Asset Tag</th>
                        <th>Model</th>
                        <th>CPU</th>
                        <th>Memory</th>
                        <th>Storage</th>
                        <th>Status</th>
                        <th coslpan="3" width="12%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php 
                        while($row = mysqli_fetch_assoc($searchData)) {
                    ?> 
                        <td><input type="checkbox" id="select" name="select[]" value="<?php echo $row['id']; ?>"></td>
                        <td><?php echo $row['assigned']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['assettype']; ?></td>
                        <td><?php echo $row['assettag']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['CPU']; ?></td>
                        <td><?php echo $row['MEMORY']; ?></td>
                        <td><?php echo $row['STORAGE']; ?></td>
                        <td><?php echo $row['status']; ?></td>

                        <td>
                        <center>
                            <a href="../update/assetUpd.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="32px"></a>&nbsp;
                            <a href="../update/turnoverUpd.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/turnover.png" width="32px"></a>&nbsp;
                            <a href="../update/remove.php?assetID=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="32px"></a>
                        </center>
                            
                        </td>    
                    
                    </tr>
                    </tbody>
                    
                    <?php
                        }
                    ?>
                </table>
                
                
            </form>
            
        </div>
</body>
</html>