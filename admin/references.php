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

                $refData = mysqli_query($db->conn,"SELECT * FROM assets_tbl WHERE status!='Archive' AND (accountability_ref != '' 
                OR turnover_ref != '')");
                $rowCount = $refData->num_rows;

                $results_per_page = 20;

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
                
                    $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assigned LIKE '%$search%' OR accountability_ref LIKE '%$search%' 
                        OR turnover_ref LIKE '%$search%') LIMIT " . $results_per_page;
                } else {
                        $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (accountability_ref != '' OR turnover_ref != '') LIMIT ". $page_first_result . ',' . $results_per_page;
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
                <p>Asset count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCountPage; ?></b></p>
            </div>
        </div> 
            <form action="" method="get">

                <table class="assets-table">
                    <tr>
                        <!-- <th><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th> -->
                        <th>User</th>
                        <th colspan=2>Accountability Ref</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th colspan=2>Turnover Ref</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="1%">Action</th>
                    </tr>
                    
                    <tr>
                    <?php 

                    // Get reference records
                    while($row = mysqli_fetch_assoc($refData)) {
                        
                    ?> 
                        <!-- <td><input type="checkbox" id="select" name="select[]" value="<?php echo $row['id']; ?>"></td> -->
                        <td><?php echo $row['assigned']; ?></td>
                        <td><a class="link" href="accountability.php?id=<?php echo $row['id']; ?>"><?php echo $row['accountability_ref']; ?></a></td>
                        <?php 
                            $acctRef = $row['accountability_ref'];
                            $turnoverRef = $row['turnover_ref'];

                            if($acctRef == '') {
                                echo "<td></td>";
                                
                            } else {                       
                        ?>
                        <td width="1%">
                            <center>
                                <a href="../update/remove.php?Acct_id=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="18px"></a>
                            </center>
                        </td>   
                        <?php
                            }
                        ?>
                        <td>N/A</td>
                        <td>N/A</td>


                        <td><a class="link" href="turnover.php?id=<?php echo $row['id']; ?>"><?php echo $row['turnover_ref']; ?></a></td>
                        <?php
                            if ($turnoverRef == '') {
                                echo "<td></td>";
                            } else {
                        ?>
                        <td width="1%">
                            <center>
                                <a href="../update/remove.php?Turnover_id=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="18px"></a>
                            </center>
                        </td>    
                        <?php
                            }
                        ?>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>
                            <center>
                                <a href="../update/referenceUpd.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="18px"></a>&nbsp;
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