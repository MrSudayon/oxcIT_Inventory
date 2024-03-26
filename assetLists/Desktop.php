<?php 
include '../inc/auth.php'; 
include '../inc/header.php'; 
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
    <title>Desktop</title>
</head>
<body>

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

    $sql =  
            "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, a.datepurchased, 
            a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
            e.id, e.name, e.division, e.location 
            FROM assets_tbl AS a 
            LEFT JOIN employee_tbl AS e 
            ON e.id = a.empId 
            WHERE a.status!='Archive' AND assettype='Desktop' 
            LIMIT ". $page_first_result . ',' . $results_per_page;
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

<div class="content">
    <main class="table" id="customers_table">
        <section class="table__header">
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="../assets/icons/search.png" alt="">
            </div>
            
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Asset Tag <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Model <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Specification <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Purchase Date <span class="icon-arrow">&UpArrow;</span></th>
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

                            $cpu = $row['cpu'];
                            $ram = $row['memory'];
                            $storage = $row['storage']
                    ?>            
                    <tr>
                        <td><a href="../update/assetUpd.php?id=<?php echo $aId; ?>"><strong><?php echo $row['assettag']; ?></strong></td></a>
                        <td><?php echo $row['model']; ?></td>
                        <td>
                            <?php 
                            if($cpu == '' || $ram == '' || $storage == '') {
                                echo "<i style='color:#FF6646;'>No details found.";
                            } else {
                                echo "CPU: ". $cpu .
                                "<br>MEMORY: ". $ram.
                                "<br>STORAGE: ". $storage;
                            }
                                
                            ?>
                        </td>
                        <td><?php echo $row['datepurchased']; ?></td>
                        <td><?php echo "<span class='statusSpan'>".$status."</span>" ?></td>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var spans = document.getElementsByClassName("statusSpan");
                                for (var i = 0; i < spans.length; i++) {
                                    var span = spans[i];
                                    if (span.innerHTML === 'Deployed') {
                                        span.classList.add("status", "delivered");
                                    } else if (span.innerHTML === 'To be Deploy') {
                                        span.classList.add("status", "shipped");
                                    } else if (span.innerHTML === 'Defective' || span.innerHTML === 'For repair') {
                                        span.classList.add("status", "cancelled");
                                    } else if (span.innerHTML === 'Sell') {
                                        span.classList.add("status", "pending");
                                    } else {
                                        span.classList.add("status", "missing");
                                    }
                                }
                            });
                        </script>

                        <td>
                            <!-- <a href="../update/assetUpd.php?id=?php echo $aId; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp; -->
                            <?php 
                                $sqlSel = mysqli_query($db->conn, "SELECT * FROM reference_tbl WHERE assetId = $id"); 
                                while($results = mysqli_fetch_assoc($sqlSel)) {
                                if($results['turnoverRef'] != '') { 
                            ?>    
                                <a href="../update/turnoverUpd.php?id=<?php echo $aId; ?>"><img src="../assets/icons/turnover.png" width="24px"></a>&nbsp;
                            <?php }} ?>
                            <a href="../update/remove.php?assetID=<?php echo $aId; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                            
                        </td>   
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="../js/sort.js"></script>

</div>

</body>
</html>