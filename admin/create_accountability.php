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
    <title>ACCOUNTABILITY</title>
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
        <h1> ACCOUNTABILITY </h1>
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
                <!-- <a href="add-assets.php" class="link-btn"></a> -->
                <button type="submit" formaction="accountability.php" class="link-btn" name="accountability">Generate</button>
            </div>
            <?php
                $searchData = $getAllRecord->searchDataPagination();
                // $rowCount = mysqli_num_rows($searchData);
                if(isset($searchData)) {
                    $rowCount = $searchData->num_rows;
                } else {
                    $rowCount = 0;
                }
                
                
            ?>
            <div class="count">
                <p>Asset count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCount; ?></b></p>
            </div>
        </div>
        <?php
        if($rowCount>0) {

            $results_per_page = 10;

            if (!isset ($_GET['page']) ) {  
                $page = 1;  
            } else {  
                $page = $_GET['page'];  
            }  
            $number_of_page = ceil ($rowCount / $results_per_page);  
            $page_first_result = ($page-1) * $results_per_page;  

            // $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' LIMIT ". $page_first_result . ',' . $results_per_page;
            // $res = mysqli_query($db->conn, $sql);

            $countperPage = $res->num_rows;
        ?>
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
                while ($row = mysqli_fetch_array($searchData)) {  
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
                    <a href="../update/assetUpd.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;
                    <a href="../update/turnoverUpd.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/turnover.png" width="24px"></a>&nbsp;
                    <a href="../update/remove.php?assetID=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                </center>
                    
                </td>    
            
            </tr>
            </tbody>
            
            <?php
                }
            ?>
        </table>
    </form>
    <?php
            for($page = 1; $page<= $number_of_page; $page++) {  
                echo '<a href = "dashboard.php?page=' . $page . '">' . $page . ' </a>';  
            }  
        } else {
            ?>
            <center>
                <h2 style="color: red;">⚠️Please search and select some user </h2>
            </center>
            <?php
        }
    ?>
    
</div>
    
</body>
</html>