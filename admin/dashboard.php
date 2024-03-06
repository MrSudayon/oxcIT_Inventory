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
        <h1> ASSET LIST </h1>
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
                <a href="add-assets.php" class="link-btn">New Record</a>
                <a href="../php/add_assetItem.php" class="link-btn">Add Asset</a>
                <a href="../php/add_division.php" class="link-btn">Add Division</a>
                <a href="../php/add_location.php" class="link-btn">Add Location</a>
                <a href="../php/add_emp_info.php" class="link-btn">Add Employee</a>
                <button type="submit" formaction="report.php" class="link-btn" name="turnover" >Report</button>
            </div>
            <?php
                $sqlSelectAll = "SELECT * FROM assets_tbl WHERE status!='Archive'";
                $results = mysqli_query($db->conn, $sqlSelectAll);

                $results_per_page = 15;

                if (!isset ($_GET['page']) ) {  
                    $page = 1;  
                } else {  
                    $page = $_GET['page'];  
                }  
                
                $rowCount = $results->num_rows;
                $number_of_page = ceil ($rowCount / $results_per_page);  
                $page_first_result = ($page-1) * $results_per_page;  

                if(isset($_POST['search']) && $_POST['search'] != "") {
                    $search = $_POST['search'];
                    
                    $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assigned LIKE '$search%' OR assigned LIKE '%$search' OR assigned LIKE '%$search%' OR department LIKE '%$search%'
                    OR assettype LIKE '%$search%' OR status LIKE '%$search%' OR location LIKE '%$search%'
                    OR assettag LIKE '%$search%' OR model LIKE '%$search%' OR CPU LIKE '%$search%' OR MEMORY LIKE '%$search%' OR STORAGE LIKE '%$search%'
                    OR remarks LIKE '%$search%' OR Others LIKE '%$search%') LIMIT " . $results_per_page;
                } else {
                    $sql =  "SELECT * FROM assets_tbl WHERE status!='Archive' LIMIT ". $page_first_result . ',' . $results_per_page;
                }
                $res = mysqli_query($db->conn, $sql);
                $rowCountPage = $res->num_rows;
            ?>
            <div class="count">
                <p>Showing: <b style="color: yellow; font-size: 20px;"><?php echo $rowCountPage; ?></b> result/s.</p>
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
                while ($row = mysqli_fetch_array($res)) {  
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
        <?php 
            // Pagination links
            if ($page > 1) {
                echo '<a href="dashboard.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
            }
            for($i = 1; $i<= $number_of_page; $i++) {  
                echo '<a href = "dashboard.php?page=' . $i . '" class="next">' . $i . '</a>';  
            }  
            if ($page < $number_of_page) {
                echo '<a href="dashboard.php?page=' . ($page + 1) . '" class="next">Next</a>';
            }
        ?>
        <br>
    </form>
    
</div>
    
</body>
</html>