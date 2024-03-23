<?php 
include '../inc/auth.php';

if(isset($_GET['select'])) {
    $selected = $_GET['select'];
    
    $escaped_values = array_map(array($db->conn, 'real_escape_string'), array_values($selected));
    
    $values  = implode(', ', array_values($escaped_values));

    $result = mysqli_query($db->conn, "SELECT assettag FROM assets_tbl WHERE id IN ($values)");
    $names = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $names[] = $row['assettag'];
    }
    $nameString = implode(', ', $names);
    
    // History
    mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
        VALUES ('','$username','Generated a report for asset IDs: $nameString',NOW())");
    
} else {
    ?>
        <script>
            alert('Please select User');
            window.location.replace('dashboard.php');
        </script>
    <?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/accountability.css">
    <title>Report</title>
</head>
<body>
<div class="content">
<?php           
foreach ($selected as $userID){ 
        $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
        $res = mysqli_query($db->conn, $sql);
    
    while($row = mysqli_fetch_assoc($res)) {
        $name = $row['assigned'];
        $dept = $row['department'];
    }
}

?>  
    <div class="logo">
        <a href="dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
    </div>
    <br><br><br>
    <center>
    <h2>Report Form</h2><br>
    </center>
        <table class="assets-table">
            
            <tr>
                <th>Assigned to</th>
                <th>Asset Type</th>
                <th>Specification</th>
                <th>Others</th>
                <th>Serial no.</th>
                <th>Remarks</th>
                <th>Date Deployed</th>
                <th>Turnover Date</th>
                <th>Last Used</th>
            </tr>
            <?php 
                foreach ($selected as $userID) { 
                    $sql = "SELECT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
                    $res = mysqli_query($db->conn, $sql);
                
                while($row = mysqli_fetch_assoc($res)) {
                    $cpu = $row['CPU'];
                    $ram = $row['MEMORY'];
                    $storage = $row['STORAGE'];
                    $specs = 'CPU: ' . $cpu . '<br>MEMORY: ' . $ram . '<br>STORAGE: ' . $storage;
            ?>
            <tr>
                <td><?php echo $row['assigned']; ?></td>
                <td><?php echo $row['assettype']; ?></td>
                <td><?php echo $specs; ?></td>
                <td><?php echo $row['Others']; ?></td>
                <td><?php echo $row['serial']; ?></td>
                <td><?php echo $row['remarks']; ?></td>    
                <td><?php echo $row['datedeployed']; ?></td>    
                <td><?php echo $row['dateturnover']; ?></td>    
                <td><?php echo $row['lastused']; ?></td>    
            </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
        
    
<script src="../js/print.js"></script>
</body>
</html>