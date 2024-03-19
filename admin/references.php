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
    <title>Reference</title>
</head>
<style>
 span.disable-btn {
    cursor: not-allowed;
    pointer-events: none;
    filter: grayscale(1);
}
.link {
    color: black;
    font-weight: 600;
}
.link:hover {
    color: blue;
    transition: ease-in-out .2s;
    text-decoration: underline;
}

</style>
<body>
    <?php include '../inc/header.php'; ?>
    
        <div class="content">
            <div class="title">
                <h1> REFERENCE </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
        <div class="table-nav">
            <div class="pagination-btns">
            <?php

                $refData = mysqli_query($db->conn, "SELECT * FROM reference_tbl WHERE accountabilityRef != '' OR turnoverRef != ''");
                // "SELECT a.id AS aId, a.empId, a.status, a.assettype, a.assettag, a.model, a.remarks, 
                // e.id, e.name AS ename, e.division, e.location, r.assetId, r.name, r.turnoverRef AS turnoverRef, r.accountabilityRef AS accountabilityRef 
                // FROM assets_tbl AS a 
                // LEFT JOIN reference_tbl AS r ON r.assetId = a.id
                // LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                // WHERE status!='Archive' AND (accountabilityRef != '' 
                // OR turnoverRef != '')");
                $rowCount = $refData->num_rows;
                
                $results_per_page = 10;

                if (!isset ($_GET['page']) ) {  
                    $page = 1;  
                } else {  
                    $page = $_GET['page'];  
                }  
            
                $number_of_page = ceil ($rowCount / $results_per_page);  
                $page_first_result = ($page-1) * $results_per_page;  

                if(isset($_POST['search']) && $_POST['search'] != "") {
                    $search = $_POST['search'];
                    $page = 1;  
                
                    $sql = "SELECT * FROM reference_tbl WHERE name LIKE '%$search%' OR accountabilityRef LIKE '%$search%' 
                        OR turnoverRef LIKE '%$search%' LIMIT " . $results_per_page;
                } else {
                    $sql = "SELECT * FROM reference_tbl LIMIT ". $page_first_result . ', ' . $results_per_page;
                }
                $res = mysqli_query($db->conn, $sql);
                $rowCountPage = $res->num_rows;

                // Pagination nav
                if ($page > 1) {
                    echo '<a href="references.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                for($i = 1; $i<= $number_of_page; $i++) {  
                    echo '<a href = "references.php?page=' . $i . '" class="next">' . $i . '</a>';  
                }  
                if ($page < $number_of_page) {
                    echo '<a href="references.php?page=' . ($page + 1) . '" class="next">Next</a>';
                }
                ?>
            </div>
            <div class="count">
                <p>Asset count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCountPage ?></b></p>
            </div>
        </div> 
            <form action="" method="get">

                <table class="assets-table">
                    <tr>
                        <!-- <th><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th> -->
                        <th width="15%">User</th>
                        <th width="5%">Asset Type</th>
                        <th>Accountability Ref</th>
                        <th width="10%">File</th>
                        <th width="5%">Status</th>
                        <th width="5%">Date</th>
                        <th width="2%"></th>

                        <th width="5%">Asset Type</th>
                        <th>Turnover Ref</th>
                        <th width="10%">File</th>
                        <th width="5%">Status</th>
                        <th width="5%">Date</th>
                        <th width="5%">Action</th>
                    </tr>
                    <style>
                        
                        span.disable-acctRef {
                            pointer-events: all;
                            filter: grayscale(0);
                        }</style>
                      <tr>
                    <?php 
                    
                if($rowCount < 1) {
                    echo "<td colspan=13 style='text-align:center; color:red; font-size: 1.5em;'>No result</td>";
                } else {
                    // Get reference records
                    $referenceTbl = $getAllRecord->getReferenceTable();

                    while($row = mysqli_fetch_assoc($referenceTbl)) {
                        $aId = $row['aId'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $acctRef = $row['accountabilityRef']; 
                        $acctStatus = $row['accountabilityStatus']; 
                        $acctDate = $row['accountabilityDate']; 
                        $turnoverRef = $row['turnoverRef'];
                        $turnoverStatus = $row['turnoverStatus']; 
                        $turnoverDate = $row['turnoverDate'];
                        $name1 = $row['rname']; 

                        if($acctRef != '' || $turnoverRef != '') {
                            // 0 N/A
                            // 1 Process
                            // 2 Signed
                            switch($acctStatus) {
                                case 1:
                                    $acctStatus = 'On Process';
                                    break;
                                case 2:
                                    $acctStatus = 'Signed';
                                    break;
                                default:
                                    $acctStatus = 'None';
                            }
                                
                            switch($turnoverStatus) {
                                case 1:
                                    $turnoverStatus = 'On Process';
                                    break;
                                case 2:
                                    $turnoverStatus = 'Signed';
                                    break;
                                default:
                                    $turnoverStatus = 'None';
                            }
                            
                            // if($name1=='') {
                            //     echo "<tr style='background-color: #afafaf ;'>";
                            // } else {
                            //     echo "<tr>";
                            // }
                            ?> 
                          
                            <td><?php echo $name1; ?></td>

                            <?php 
                            if($acctRef == '') {
                                
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td>" . $acctStatus;"</td>";
                                echo "<td>" . $acctDate;"</td>";
                                echo "<td><span class='disable-btn'><img src='../assets/icons/remove.png' width='24px'></span></td>";
                            } else {               
                            ?>

                                <td><?php echo $assettag;?></td>
                                <td><a class="link" href="accountability.php?id=<?php echo $assetId; ?>"><?php echo $acctRef;?></a></td>
                                <td width="10%;"><a class="link" href="../files/download.php?acctRef_id=<?php echo $id; ?>" target="_blank"><?php echo $row['accountabilityFile']; ?></td>
                                <td><?php echo $acctStatus; ?></td>
                                <td><?php echo $row['accountabilityDate']; ?></td>
                                <td>
                                    <center>
                                        <?php if($acctStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/remove.php?Acct_id=<?php echo $id; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a></span>
                                        <?php } else { ?>
                                            <a href="../update/remove.php?Acct_id=<?php echo $id; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                                        <?php } ?>
                                    </center>
                                </td>
                            <?php
                            }
                            ?>
                            
                            <?php
                            if ($turnoverRef == '') {
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td style='font-weight:600;'>N/A</td>";   
                                echo "<td style='font-weight:600;'>N/A</td>";   
                                echo "<td>" . $turnoverStatus;"</td>";
                                echo "<td>" . $turnoverDate;"</td>";   
                                if($turnoverStatus == 'Signed') {              
                                    echo "<td><center><span class='disable-btn'><a href='../update/referenceUpd.php?id=" . $id . "'><img src='../assets/icons/update.png' width='24px'></a></span></center></td>";
                                } else {
                                    echo "<td><center><a href='../update/referenceUpd.php?id=" . $id . "'><img src='../assets/icons/update.png' width='24px'></a></center></td>";
                                }
                            } else {
                            ?>
                                <td><?php echo $assettag;?></td>
                                <td><a class="link" href="turnover.php?id=<?php echo $assetId; ?>"><?php echo $turnoverRef;?></a></td>
                                <td width="10%;"><a class="link" href="../files/download.php?trnRef_id=<?php echo $row['id']; ?>" target="_blank"><?php echo $row['turnoverFile']; ?></td>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $turnoverDate; ?></td>
                                <td>
                                    <center>
                                        <?php if($turnoverStatus == 'Signed' && $acctStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/referenceUpd.php?id=<?php echo $id; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;</span>
                                        <?php } else { ?>
                                            <a href="../update/referenceUpd.php?id=<?php echo $id; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;
                                        <?php } ?>

                                        <?php if($turnoverStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/remove.php?Turnover_id=<?php echo $id; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a></span>
                                        <?php } else { ?>
                                            <a href="../update/remove.php?Turnover_id=<?php echo $id; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                                        <?php } ?>
                                        
                                    </center>
                                </td>    
                            <?php
                            }
                        }
                    }
                } 
                            ?>                        
                        </tr>
                </table>
                
                
            </form>
            
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>