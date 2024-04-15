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
    <div class="logo">
        <a href="configuration.php"><img src="../assets/logo.png" width="150px"></img></a>
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
                <th>Serial no.</th>
                <th>Remarks</th>
                <th>Date Deployed</th>
                <th>Turnover Date</th>
                <th>Last Used</th>
            </tr>
            <?php 
            foreach ($selected as $userID){ 
                // $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
                $sql = "SELECT DISTINCT a.*, e.id, e.name AS ename, e1.name AS lastusedName 
                        FROM assets_tbl AS a 
                        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                        LEFT JOIN employee_tbl AS e1 ON a.lastused = e1.id 
                        WHERE a.id='$userID' AND a.status!='Archive'";
                $res = mysqli_query($db->conn, $sql);
                // foreach ($selected as $userID) { 
                //     $sql = "SELECT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
                //     $res = mysqli_query($db->conn, $sql);
                
                while($row = mysqli_fetch_assoc($res)) {
                    $assettype = $row['assettype'];

                    $cpu = $row['cpu'];
                    $ram = $row['memory'];
                    $storage = $row['storage'];
                    $os = $row['os'];
                    $dimes = $row['dimes'];
                    $plan = $row['plan'];
                    $mobile = $row['mobile'];
                    switch($assettype) {
                        case 'Desktop':
                        case 'Laptop':
                            $specs = $cpu . '<br>' . $ram . '<br>' . $storage . '<br>' . $os;
                        break;

                        case 'Monitor':
                        case 'Printer':
                        case 'AVR':
                        case 'UPS':
                            $specs = $dimes;
                        break;

                        case 'SIM':
                            $specs = $plan . '<br>' . $mobile;
                        break;
                        
                        case 'Mobile':
                            $specs = $ram . '<br>' . $storage . '<br>' . $plan;
                    } 
            ?>
            <tr>
                <td><?php echo $row['ename']; ?></td>
                <td><?php echo $assettype; ?></td>
                <td><?php echo $specs; ?></td>
                <td><?php echo $row['serial']; ?></td>
                <td><?php echo $row['remarks']; ?></td>    
                <td><?php echo $row['datedeployed']; ?></td>    
                <td><?php echo $row['turnoverdate']; ?></td>    
                <td><?php echo $row['lastusedName']; ?></td>    
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