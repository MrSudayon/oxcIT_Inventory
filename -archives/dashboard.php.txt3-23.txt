<?php 
include '../inc/auth.php'; 
include '../inc/listsHead.php'; 
include '../inc/header.php'; 
?>
    
<div class="content">
    <div class="title">
        <h1> ASSET LIST </h1>
        
        <div class="search-container">
            <form action="" method="POST" class="">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
    <?php
        $sqlSelectAll = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assettype='Desktop' OR assettype='Laptop')";
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
                a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
                e.id, e.name, e.division, e.location 
                FROM assets_tbl AS a 
                LEFT JOIN employee_tbl AS e 
                ON a.empId = e.id 
                WHERE a.status!='Archive' AND (assettype='Desktop' OR assettype='Laptop') AND (e.name LIKE '$search%' OR e.name LIKE '%$search' OR e.name LIKE '%$search%' OR e.division LIKE '%$search%'
                OR a.assettype LIKE '%$search%' OR a.status LIKE '%$search%' OR e.location LIKE '%$search%'
                OR a.assettag LIKE '%$search%' OR a.model LIKE '%$search%')";
        } 
        elseif((isset($_POST['aType']) && $_POST['aType'] != "") || (isset($_POST['aStatus']) && $_POST['aStatus'] != "")) {

            $type = $_POST['aType'];
            $status = $_POST['aStatus'];
            $sql = 
                "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, 
                a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
                e.id, e.name, e.division, e.location 
                FROM assets_tbl AS a 
                LEFT JOIN employee_tbl AS e 
                ON a.empId = e.id 
                WHERE a.status='$status' AND a.assettype = '$type' LIMIT ". $page_first_result . ',' . $results_per_page;
        } else {
            // $sql =  "SELECT * FROM assets_tbl WHERE status!='Archive' ORDER BY lpad(assettag, 10, 0) LIMIT ". $page_first_result . ',' . $results_per_page;
            $sql =  
                "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, 
                a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
                e.id, e.name, e.division, e.location 
                FROM assets_tbl AS a 
                LEFT JOIN employee_tbl AS e 
                ON e.id = a.empId 
                WHERE a.status!='Archive' AND (assettype='Desktop' OR assettype='Laptop') 
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
        <div class="link-btns">
            <a href="add-assets.php" class="link-btn">New Record</a>
            <!-- <a href="../php/add_assetItem.php" class="link-btn">Add Asset</a>
            <a href="../php/add_division.php" class="link-btn">Add Division</a>
            <a href="../php/add_location.php" class="link-btn">Add Location</a>
            <a href="../php/add_emp_info.php" class="link-btn">Add Employee</a> -->
            <!-- <button type="submit" formaction="report.php" class="link-btn" name="turnover" >Report</button> -->
        </div>
    
        <p>Showing: <b style="color: yellow; font-size: 20px; margin-top: 10px;"><?php echo $rowCountPage; ?></b> result/s.</p>
    </div>
    <form action="" method="get">

        <table class="assets-table" id="myTable">
            <thead>
            <tr>
                <th width="1%"><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                <!-- <th>Asset Type</th> -->
                <th width="10%">Asset Tag</th>
                <th width="20%">Model</th>
                <th width="40%">Specification</th>
                <th width="10%">Status</th>
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
                    $assetType = $row['assettype'];
            ?> 
                <td><input type="checkbox" id="select" name="select[]" value="<?php echo $aId; ?>"></td>
                <!-- <td>?php echo $assetType; ?></td> -->
                <td><b><?php echo $row['assettag']; ?></b></td>
                <td><?php echo $row['model']; ?></td>
                <td>
                    <?php 
                    if($assetType == 'Laptop' || $assetType == 'Desktop' ) { 
                            echo "CPU: ". $row['cpu'].
                            "<br>MEMORY: ". $row['memory'].
                            "<br>STORAGE: ". $row['storage'];
                            // "<br>OS: ". $row['os'];
                        } elseif($assetType == 'Mobile') {
                            echo "MEMORY: ". $row['memory'].
                            "<br>STORAGE: ". $row['storage'];
                        } elseif($assetType == 'Monitor' || $assetType == 'UPS' || $assetType == 'Printer' || $assetType == 'AVR') {
                            echo "DIMENSION: ". $row['dimes'];
                        } elseif($assetType == 'SIM') {
                            echo "PLAN: ". $row['plan'];
                        } else {
                            echo "MEMORY: ". $row['memory'].
                            "<br>STORAGE: ". $row['storage'];
                        }
                    ?>
                </td>
                
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
                    echo '<a href="Desktop.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'active' : ''; // Add active class to current page
                    echo '<a href="Desktop.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="Desktop.php?page=' . ($page + 1) . '" class="next">Next</a>';
                }
            }
        ?>
    </form>
    
</div>

</body>
</html>