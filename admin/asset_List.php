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
    <title>Asset List</title>
</head>
<body>
    <?php include '../inc/header.php'; ?>
    
        <div class="content">
            <div class="title">
                <h1> Configuration </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="searchAsset">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>

            <div class="table-nav">
                <?php include '../inc/table-nav.php'; ?>

                <?php
                    $assetList = $getAllRecord->searchAsset();
                    // $assetData = $getEmp->assetCount();
                    $rowCount = $assetList->num_rows;
                ?>
                <div class="count">
                    <p>Emp count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCount; ?></b></p>
                </div>
            </div>

            <form action="" method="get">
                
                <table class="assets-table">
                    <tr>
                        <th>ID</th>
                        <th>Asset Type</th>
                        <th>Asset Tag</th>
                        <th colspan="2" width="8%">Action</th>
                    </tr>
                    <?php                         
                        
                            
                        while($row = mysqli_fetch_assoc($assetList)) {
                                 
                            $status = $row['status'];
                            if($status=='Archive') {
                                echo "<tr style='background-color: pink'>";
                            } else {
                                echo "<tr>";
                            }
                    ?> 
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['assettype']; ?></td>
                        <td><?php echo $row['assettag']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                        <center>
                            <a href="assetUpd.php?empID=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="24px"></a>

                            <a href="remove.php?empID=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                        </center>
                        </td>    
                    </tr>
                    <?php
                        }
                    ?>
                </table>
                
                
            </form>
            
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>