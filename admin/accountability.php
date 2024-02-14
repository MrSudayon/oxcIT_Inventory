<?php
require '../php/db_connection.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
} else {
    header("Location: ../php/login.php");
}

if(isset($_GET['select'])) {
    $selected = $_GET['select'];
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
    <link rel="stylesheet" href="../css/accountability.css">
    <title>Accountability</title>
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
    <div class="head">
        <div class="logo">

        </div>

        <div class="info">
            <h3>Employee Information</h3><br>
            <h4>Date:</h4>
            <h4>Name: <?php echo $name; ?></h4>
            <h4>Department: <?php echo $dept; ?></h4>
        </div>
    </div>
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

                
                foreach ($selected as $userID){ 
                    $sql = "SELECT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
                    $res = mysqli_query($db->conn, $sql);
                
                while($row = mysqli_fetch_assoc($res)) {
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
                }}
            
            ?>
        </table>
        <div class="info">
            <h3>Responsibilities</h3>
            <p>
            I, [Employee Name], acknowledge that the above-mentioned asset has been issued to me for the purpose of<br> performing my job responsibilities. I understand and agree to the following responsibilities:
            <br><br>
            1. I am responsible for the proper use and care of the assigned asset.
            <br>2. I will report any damage, loss, or malfunction of the asset to my supervisor immediately.
            <br>3. I will not loan, transfer, or dispose of the asset without prior authorization from the appropriate authority.
            <br>4. I will return the asset in good condition upon termination of my employment or upon request by the company.
            <br><br>
            Asset Return:<br>
            I understand that I am required to return the asset on the specified date or upon termination of my employment. Failure to return the asset in good condition may result in disciplinary action and/or financial responsibility for repair or replacement costs.
            <br><br>
            <div class="empInfo">
                <h3>Employee Signature:</h3><h3>Date:<?php echo date("Y-m-d"); ?></h3>
            </div>
            </p>
        </div>
        
    </div>
    <div class="link-btns">
        <button id="print" class="link-btn">Save PDF</button><br>
        <button id="back" class="link-btn">Back</a>
    </div>
        
    
<script src="../js/print.js"></script>
</body>
</html>