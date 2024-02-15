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
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <li><a href="../php/add_emp_info.php">Register Emp</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
        <div class="content">
            <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <form action="accountability.php" method="get">
                <table class="assets-table">
                    <tr>
                        <th><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
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

                        // $Records = $getAllRecord->getAllData();

                        $searchData = $getAllRecord->searchData();

                        // foreach($Records as $data) {
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
                        <td><?php echo $row['datedeployed']; ?></td>
                        <td><?php echo $row['dateturnover']; ?></td>

                        <td>
                        <center>
                            <a href="update.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="32px"></a>&nbsp;
                            <a href="remove.php?id=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="32px"></a>
                        </center>
                            
                        </td>    
                    
                    </tr>
                    <?php
                        }
                    ?>
                </table>
                
                <div class="link-btns">
                    <a href="add-assets.php" class="link-btn">Add</a>
                    <button type="submit" class="link-btn" name="accountability" >Accountability</button>
                    <button type="submit" formaction="turnover.php" class="link-btn" name="turnover" >Turn Over</button>
                    <button type="submit" formaction="report.php" class="link-btn" name="turnover" >Report</button>
                    <!-- <a href="accountability.php" class="link-btn">Accountability</a> -->
                </div>
            </form>
            
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>