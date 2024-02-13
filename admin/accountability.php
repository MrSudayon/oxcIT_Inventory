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
    <link rel="stylesheet" href="../css/admin.css">
    <title>Accountability</title>
</head>
<body>
    
    <main>
        <div class="content">
            <h2> Assets </h2><br>
            <table class="assets-table">
                
                <tr>
                    <th>Asset Type</th>
                    <th>Specification</th>
                    <th>Others</th>
                    <th>Serial no.</th>
                    <th>Date Deployed</th>
                    <th>Remarks</th>
                </tr>
                <?php 
                    $getAllRecord = new Operations();

                    $Records = $getAllRecord->getAllData();

                    // foreach($Records as $data) {
                    while($row = mysqli_fetch_assoc($Records)) {
                        $cpu = $row['CPU'];
                        $ram = $row['MEMORY'];
                        $storage = $row['STORAGE'];
                        $specs = 'CPU: ' . $cpu . '<br>MEMORY: ' . $ram . '<br>STORAGE: ' . $storage;
                    
                ?>
                <tr>
                
                    <td><?php echo $row['assettype']; ?></td>
                    <td><?php echo $specs; ?></td>
                    <td><?php echo $row['Others']; ?></td>
                    <td><?php echo $row['serial']; ?></td>
                    <td><?php echo $row['datedeployed']; ?></td>
                    <td><?php echo $row['remarks']; ?></td>    
                
                </tr>
                <?php
                    }
                ?>
            </table>
            
            <div class="link-btns">
                <button id="print" class="link-btn">Save PDF</button><br>
                <button id="back" class="link-btn">Back</a>
            </div>
            
        </div>
    </main>
<script src="../js/print.js"></script>
</body>
</html>