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
            <img src="../assets/logo.png" width="150px"></img>
        </div>

        <div class="info">
            <h3>Employee Information</h3><br>
            <h4>Date: _________</h4>
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
                <td><?php echo $row['remarks']; ?></td>    
            
            </tr>
            <?php
                }}
            
            ?>
        </table>
        <div class="info">
            <h4>Reason:</h4><br>
            <h3>Acknowledgment:</h3>
            <p>
            &nbsp;&nbsp;I, <?php echo $name; ?>, acknowledge that I have returned the above-mentioned equipment in the condition stated above.<br> I understand that any damage or missing items may result in charges or disciplinary action.
            <br><br>
            <h3>Asset Administrator:</h3>
            &nbsp;&nbsp;I, the undersigned, approve the transfer of the equipment as documented in this form.<br>
            Asset Administrator: [Signature] ________________________ [Date] ________
            <br><br>
            [For Asset Administrator Use Only]<br><br>
            <h3>Asset Status:</h3>
            ☐ Accepted in Good Condition<br>
            ☐ Accepted with Noted Issues (please specify): _______________________
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