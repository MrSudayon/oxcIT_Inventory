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
    // query to update Turnover date.
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
    <title>Turnover Form</title>
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
    <h2>Turnover Form</h2><br>
    </center>
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
        <div class="info"><br>
            <h4>Reason:</h4><br>
            <h3>Acknowledgment:</h3>
            <p>
            &nbsp;&nbsp;I, <b><?php echo $name; ?></b>, acknowledge that I have returned the above-mentioned equipment in the condition stated above. I understand that any damage or missing items may result in charges or disciplinary action.
            <br><br>
            <h3>Asset Administrator:</h3>
            <p>
            &nbsp;&nbsp;I, the undersigned, approve the transfer of the equipment as documented in this form.<br>
            <br>Asset Administrator: [Signature] __________________ [Date] __________</p>
            <br>
            [For Asset Administrator Use Only]<br><br>
            <h3>Asset Status:</h3>
            <p>
            ☐ Accepted in Good Condition<br>
            ☐ Accepted with Noted Issues (please specify): _______________________
            </p>
        </div>
        
    </div>
        
    
<script src="../js/print.js"></script>
</body>
</html>