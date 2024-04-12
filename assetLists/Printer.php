<?php 
include '../inc/auth.php';
include '../inc/listsHead.php'; 
include '../inc/header.php'; 
?>
<body>

<?php
    $sqlSelectAll = "SELECT * FROM assets_tbl WHERE status!='Archive' AND assettype='Printer'";
    $results = mysqli_query($db->conn, $sqlSelectAll);

    $results_per_page = 15;
    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } elseif ($_GET['page'] === 'all') {  
        $sql = "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, a.datepurchased, 
                a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
                e.id, e.name, e.division, e.location 
                FROM assets_tbl AS a 
                LEFT JOIN employee_tbl AS e 
                ON e.id = a.empId 
                WHERE a.status!='Archive' AND assettype='Printer'";
        $res = mysqli_query($db->conn, $sql);
        $rowCountPage = $res->num_rows;
    } else {
        $page = $_GET['page'];  
    }
    
    $rowCount = $results->num_rows;
    $number_of_page = ceil ($rowCount / $results_per_page);  
    $page_first_result = ($page-1) * $results_per_page;  

    if (!isset($_GET['page']) || $_GET['page'] !== 'all') {
        $sql = "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, a.datepurchased, 
                a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
                e.id, e.name, e.division, e.location 
                FROM assets_tbl AS a 
                LEFT JOIN employee_tbl AS e 
                ON e.id = a.empId 
                WHERE a.status!='Archive' AND assettype='Printer' 
                LIMIT $page_first_result, $results_per_page";
        $res = mysqli_query($db->conn, $sql);
        $rowCountPage = $res->num_rows;
    }

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

<div class="content">
    <main class="table" id="customers_table">
        <section class="table__header">
            <a href="../admin/add-assets.php?id=recordPrinter" class="link-btn">New Record</a>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="../assets/icons/search.png" alt="">
            </div>
            <p> <b style="color: yellow; font-size: 20px; margin-top: 10px;"><?php echo $rowCountPage; ?></b> result/s.</p>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Asset Tag <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Model <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Specification <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Status <span class="icon-arrow">&UpArrow;</span></th>
                        <th width='10%'> Action <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($rows as $row) {
                            $status = $row['status'];
                            $aId = $row['aId'];
                            $assetType = $row['assettype'];

                            $dimes = $row['dimes'];
                    ?>            
                    <tr>
                        <td><a href="../update/assetUpd.php?id=<?php echo $aId; ?>"><strong><?php echo $row['assettag']; ?></strong></td></a>
                        <td><?php echo $row['model']; ?></td>
                        <td>
                            <?php 
                            if($dimes == '') { //type
                                echo "<i style='color:#FF6646;'>No details found.";
                            } else {
                                echo $dimes;
                            }
                            ?>
                        </td>
                        <td><?php echo "<span class='statusSpan'>". $status ."</span>" ?></td>

                        <td>
                            <a href="../update/remove.php?assetID=<?php echo $aId; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                        </td>   
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
           
        </section>
        <?php 
            if($rowCountPage != $rowCount) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="Printer.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'activePage' : ''; // Add active class to current page
                    echo '<a href="Printer.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="Printer.php?page=' . ($page + 1) . '" class="next">Next</a>';
                    echo '<a href="Printer.php?page=all" class="next">All</a>';
                }
                echo '</div>';

            }
        ?>
    </main>
    <script src="../js/sort.js"></script>

</div>

</body>
</html>