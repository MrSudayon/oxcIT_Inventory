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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/dashboard.js"></script>
    <script src="../js/addAssets.js"></script>
    <title>Asset List</title>
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
            <form action="" method="POST" class="">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        <!-- </div>
        <div class="filter"> -->
            <form action="" method="POST" class="filter">
                <select name="aType" class="">
                    <option>Select Asset</option>
                    <?php
                        $assettype = $getAllRecord->getAssets();
                        foreach($assettype as $assets) {
                    ?>
                        <option value="<?=$assets['assetType']?>"><?php echo $assets['assetType']; ?></option>
                    <?php
                        }
                    ?>
                </select>
                <select name="aStatus" class="">
                    <option>Select Status</option>
                    <option value="For repair">For repair</option>
                    <option value="Deployed">Deployed</option>
                    <option value="To be Deploy">To be deploy</option>
                    <option value="Deffective">Defective</option>
                    <option value="Sell">Sell</option>
                </select>
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

                    $sql = 
                    "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, 
                    e.id, e.name, e.division, e.location 
                    FROM assets_tbl AS a 
                    LEFT JOIN employee_tbl AS e 
                    ON a.empId = e.id 
                    WHERE a.status!='Archive' AND (e.name LIKE '$search%' OR e.name LIKE '%$search' OR e.name LIKE '%$search%' OR e.division LIKE '%$search%'
                    OR a.assettype LIKE '%$search%' OR a.status LIKE '%$search%' OR e.location LIKE '%$search%'
                    OR a.assettag LIKE '%$search%' OR a.model LIKE '%$search%')";
                 
                } 
                elseif((isset($_POST['aType']) && $_POST['aType'] != "") || (isset($_POST['aStatus']) && $_POST['aStatus'] != "")) {

                    $type = $_POST['aType'];
                    $status = $_POST['aStatus'];
                    $sql = 
                    "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, 
                    e.id, e.name, e.division, e.location 
                    FROM assets_tbl AS a 
                    LEFT JOIN employee_tbl AS e 
                    ON a.empId = e.id 
                    WHERE a.status='$status' AND a.assettype = '$type' LIMIT ". $page_first_result . ',' . $results_per_page;
                    
                } else {
                    // $sql =  "SELECT * FROM assets_tbl WHERE status!='Archive' ORDER BY lpad(assettag, 10, 0) LIMIT ". $page_first_result . ',' . $results_per_page;
                    $sql =  
                    "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, 
                    e.id, e.name, e.division, e.location 
                    FROM assets_tbl AS a 
                    LEFT JOIN employee_tbl AS e 
                    ON e.id = a.empId 
                    WHERE a.status!='Archive' 
                    LIMIT ". $page_first_result . ',' . $results_per_page;
                  
                }
                $res = mysqli_query($db->conn, $sql);
                $rowCountPage = $res->num_rows;

                $rows = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $rows[] = $row;
                }
                
                // Sort the result array by assettag
                usort($rows, function($a, $b) {
                    preg_match('/\d+$/', $a['assettag'], $aMatches);
                    preg_match('/\d+$/', $b['assettag'], $bMatches);
                    $aNum = intval($aMatches[0] ?? 0);
                    $bNum = intval($bMatches[0] ?? 0);

                    if ($aNum == $bNum) {
                        return strcmp($a['assettag'], $b['assettag']);
                    }
                    return ($aNum < $bNum) ? -1 : 1;
                });
                
            ?>            
            <div class="count">
                <p>Showing: <b style="color: yellow; font-size: 20px;"><?php echo $rowCountPage; ?></b> result/s.</p>
            </div>
        </div>
        
        <table class="assets-table" id="myTable">
            <thead>
            <tr>
                <th width="1%"><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                <th>Asset Type</th>
                <th>Asset Tag</th>
                <th>Model</th>
                <th width="50%">Specification</th>
                <th>Status</th>
                <th coslpan="3" width="10%">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <?php
                // while ($row = mysqli_fetch_array($res)) {  
                foreach ($rows as $row) {
                    $status = $row['status'];
                    $aId = $row['aId'];
            ?> 
                <td><input type="checkbox" id="select" name="select[]" value="<?php echo $aId; ?>"></td>
                <td><?php echo $row['assettype']; ?></td>
                <td><?php echo $row['assettag']; ?></td>
                <td><?php echo $row['model']; ?></td>
                <td>
                    <?php 

                    // Logic if laptop/desktop = true {}
                        echo "CPU:  
                            <br>MEMORY:   
                            <br>STORAGE: " ; 
                    ?>
                </td>
                    
                <!-- <td> echo $row['CPU']; ?></td>
                <td> echo $row['MEMORY']; ?></td>
                <td> echo $row['STORAGE']; ?></td> -->
                
                <td><?php echo "<span class='statusSpan' >".$status."</span>" ?></td>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var spans = document.getElementsByClassName("statusSpan"); 
                        for (var i = 0; i < spans.length; i++) {
                            var span = spans[i];
                            if (span.innerHTML === 'Deployed') { 
                                span.classList.add("deployed"); 
                            } else if (span.innerHTML === 'To be Deploy') { 
                                span.classList.add("available"); 
                            } else if (span.innerHTML === 'Defective' || span.innerHTML === 'For repair') { 
                                span.classList.add("defect"); 
                            } else if (span.innerHTML === 'Sell') { 
                                span.classList.add("sell"); 
                            } else {
                                span.classList.add("missing"); 
                                // span.innerHTML.add("missing"); 
                            }
                        }
                    });
                </script>

                <td>
                <center>
                    <a href="../update/assetUpd.php?id=<?php echo $aId; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;
                    <?php 
                        $sqlSel = mysqli_query($db->conn, "SELECT * FROM reference_tbl WHERE assetId = $id"); 
                        while($results = mysqli_fetch_assoc($sqlSel)) {
                        if($results['turnoverRef'] != '') { 
                    ?>    
                        <a href="../update/turnoverUpd.php?id=<?php echo $aId; ?>"><img src="../assets/icons/turnover.png" width="24px"></a>&nbsp;
                    <?php }} ?>
                    <a href="../update/remove.php?assetID=<?php echo $aId; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
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
            // if($rowCountPage != $rowCount) {
            //     if ($page > 1) {
            //         echo '<a href="dashboard.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
            //     }
            //     for($i = 1; $i<= $number_of_page; $i++) {  
            //         echo '<a href = "dashboard.php?page=' . $i . '" class="next">' . $i . '</a>';  
            //     }  
            //     if ($page < $number_of_page) {
            //         echo '<a href="dashboard.php?page=' . ($page + 1) . '" class="next">Next</a>';
            //     }
            // }
            if($rowCountPage != $rowCount) {
                if ($page > 1) {
                    echo '<a href="dashboard.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'active' : ''; // Add active class to current page
                    echo '<a href="dashboard.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="dashboard.php?page=' . ($page + 1) . '" class="next">Next</a>';
                }
            }
        ?>
    </form>
    
</div>

</body>
</html>