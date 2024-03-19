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
    <title>Accountability</title>
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
                <button type="submit" formaction="accountability.php" class="link-btn" name="accountability" onclick="return checkPrompt()">Generate</button>
            </div>
            <?php
                $sqlSelectAll = 
                "SELECT a.*, 
                e.id, e.name, e.division, e.location, 
                r.* 
                FROM assets_tbl AS a 
                INNER JOIN reference_tbl r 
                ON r.assetId = a.id
                LEFT JOIN employee_tbl AS e 
                ON e.id = a.empId 
                WHERE a.status!='Archive' AND (a.empId!='' || a.empId = null)";
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

                $sql = 
                "SELECT a.id AS aId, a.empId, a.status, a.assettype, a.assettag, a.model, a.remarks, 
                e.id, e.name AS ename, e.division, e.location, r.assetId, r.name, r.accountabilityRef AS accountabilityRef
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE a.empId !=0 AND a.status!='Archive' AND (a.empId != 0 OR a.empId IS NOT NULL) AND (e.name LIKE '$search%' OR e.name LIKE '%$search' OR e.name LIKE '%$search%' OR e.division LIKE '%$search%'
                OR a.assettype LIKE '%$search%' OR a.status LIKE '%$search%' OR e.location LIKE '%$search%'
                OR a.assettag LIKE '%$search%' OR a.model LIKE '%$search%' OR a.remarks LIKE '%$search%') LIMIT " . $results_per_page;
            
                $res = mysqli_query($db->conn, $sql);
                $countperPage = $res->num_rows;
            ?>
            <div class="count">
                <p>Asset count: <b style="color: yellow; font-size: 20px;"><?php echo $countperPage; ?></b></p>
            </div>
        </div>
       
        <table class="assets-table" id="myTable">
            <thead>
            <tr>
            <th width="1%"><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                <th width="20%">User</th>
                <th width="1%">Department</th>
                <th>Asset Type</th>
                <th>Asset Tag</th>
                <th width="8%">Model</th>
                <th>Specification</th>
                <th>Status</th>
                <th>Ref Code</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <?php 
                while ($row = mysqli_fetch_array($res)) {  
            ?> 
                <td><input type="checkbox" id="select" name="select[]" value="<?php echo $row['id']; ?>"></td>
                <td><?php echo $row['ename']; ?></td>
                <td><?php echo $row['division']; ?></td>
                <td><?php echo $row['assettype']; ?></td>
                <td><?php echo $row['assettag']; ?></td>
                <td><?php echo $row['model']; ?></td>
                <td>S</td>
                <!-- <td>hp echo "CPU: " . $row['CPU'] . "<br>RAM: " . $row['MEMORY'] . "<br>STORAGE: " . $row['STORAGE']; ?></td> -->
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php
                        $accountability = $row['accountabilityRef'];

                        if($accountability!='') {
                            ?> <input type="hidden" id="accountability" value="<?php echo $accountability; ?>"><?php
                            echo $accountability;
                        } else {
                            echo "N/A";
                        }
                    ?>
                </td>
            </tr>
            </tbody>
            
            <?php
                }
            ?>
        </table>
    </form>
    
<?php
        // Pagination nav
    if ($page > 1) {
        echo '<a href="create_accountability.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
    }
    for($i = 1; $i<= $number_of_page; $i++) {  
        echo '<a href = "create_accountability.php?page=' . $i . '" class="next">' . $i . '</a>';  
    }  
    if ($page < $number_of_page) {
        echo '<a href="create_accountability.php?page=' . ($page + 1) . '" class="next">Next</a>';
    }

} else {
    
    ?>
    <style>
    .noresult {
        display: flex;
        justify-content: center;
    }
    </style>
    
    </div>
        <div class="noresult">
            <h2 class="nores" style="color: white; ">⚠️Search and select user</h2>
        </div>
    <?php
}
?>
</div>


<script src="../js/dashboard.js"></script>
</body>
</html>