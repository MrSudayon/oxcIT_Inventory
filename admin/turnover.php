<?php
require '../php/db_connection.php';

$select = new Select();
$db = new Connection();
$functions = new Operations();
if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
    $username = $user['username'];

} else {
    header("Location: ../php/login.php");
}

    
if(isset($_GET['select'])) {

    $selected = $_GET['select'];
    foreach ($selected as $userID){ 
        // $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
        $sql = 
        "SELECT DISTINCT a.*, 
        e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.turnoverRef  
        FROM assets_tbl AS a 
        LEFT JOIN reference_tbl AS r ON r.assetId = a.id
        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
        WHERE a.id='$userID' AND a.status !='Archive'";

        $res = mysqli_query($db->conn, $sql);
    
        while($row = mysqli_fetch_assoc($res)) {
            $name = $row['ename'];
            $dept = $row['division'];
            $turnover_ref = $row['turnoverRef'];
            $arrayName[] = $name;
        }
    }

    $assetUserID = mysqli_query($db->conn, 
                                        "SELECT DISTINCT a.id AS aId, a.empId, a.status, a.assettype, a.assettag, a.model, a.remarks, 
                                        e.id, e.name AS ename, e.division, e.location, r.assetId, r.name, r.turnoverRef 
                                        FROM assets_tbl AS a 
                                        LEFT JOIN reference_tbl AS r ON r.assetId = a.id
                                        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                                        WHERE a.id='$userID' AND a.status !='Archive'"); 
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
        <div class="logo">
            <a href="create_turnover.php"><img src="../assets/logo.png" width="150px"></img></a>
        </div>
        <br><br><br>
        <center>
        <h2>Turnover Form</h2>
        </center>
    <div class="reference-code" align="right">
    <?php 
         // Generating Reference Code
    $n=4;
    function getCode($n) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
            $refCode = $randomString. "-" .date("Y");
        }
        
        return "TRNO-".$refCode;
    }

    $newCode = getCode($n);

    if(isset($arrayName)) {
        if($arrayName != array_filter($arrayName)) {
            ?>
                <script> 
                alert ('⚠️Invalid Action')
                window.location.href = 'create_turnover.php';
                </script> 
            <?php
            // print_r($arrayName);
            // print_r($userID);

        } elseif(count(array_unique($arrayName))>1) {
            ?>
                <script> 
                alert ('⚠️Multiple User is not Allowed!')
                window.location.href = 'create_turnover.php';
                </script> 
            <?php
        } else {

            // assets tbl
            while($row = mysqli_fetch_assoc($assetUserID)) {
                $id = $row['aId']; //assetId 
                $assettag = $row['assettag'];
                $assigned = $row['ename'];
            }

            if ($turnover_ref == '') {
                echo "<b>Ref#: " .$newCode. "</b>";
                // If assetId is existing in reference tbl
                // $refSql = mysqli_query($db->conn, "SELECT * FROM reference_tbl WHERE assetId = $id");

                // Insert accountability code to reference_tbl
                // if(!$refSql) {
                    $refQry = mysqli_query($db->conn, "INSERT INTO reference_tbl (id, assetId, name, turnoverRef, turnoverStatus, turnoverFile, turnoverDate, referenceStatus)
                    VALUES ('', '$id', '$assigned', '$newCode', 0, '', '', 1)");
                // } else {    
                //     $refQry = mysqli_query($db->conn, "UPDATE reference_tbl SET turnoverStatus=1 WHERE assetId = $id");
                // }
            } else {
                echo "<b>Ref#: " . $turnover_ref . "</b>";
                
                $history = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                VALUES ('', '$username', 'Viewed turnover form for: $assigned', NOW())");
            }
        }
    }    
    // From reference Tab to existing Turnover form
} elseif(isset($_GET['id'])) {
    $userID = $_GET['id'];

    $sql = 
        "SELECT DISTINCT a.*, 
        e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.turnoverRef  
        FROM assets_tbl AS a 
        LEFT JOIN reference_tbl AS r ON r.assetId = a.id
        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
        WHERE a.id='$userID' AND a.status !='Archive'";

        $res = mysqli_query($db->conn, $sql);
    
        while($row = mysqli_fetch_assoc($res)) {
            $name = $row['ename'];
            $dept = $row['division'];
            $turnover_ref = $row['turnoverRef'];
        }
    
    $assetUserID = mysqli_query($db->conn, 
                                        "SELECT DISTINCT a.*, 
                                        e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.turnoverRef  
                                        FROM assets_tbl AS a 
                                        LEFT JOIN reference_tbl AS r ON r.assetId = a.id
                                        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                                        WHERE a.id='$userID' AND a.status !='Archive'");
} else {
    ?>
        <script>
            alert('Please select User');
            window.location.replace('create_turnover.php');
        </script>
    <?php
} 
?>
</div>
    <table class="assets-table">
        
        <tr>
            <th>Asset Type</th>
            <th>Specification</th>
            <th>Model</th>
            <th>Serial no.</th>
            <th>Remarks</th>
        </tr>
        <?php 
        if($selected) {
            //  = $_GET['select'];

            foreach ($selected as $userID) {
                // $sql = "SELECT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
                $sql = "SELECT a.id AS aId, a.empId, a.status, a.assettype, a.assettag, a.model, a.serial, a.remarks, 
                        e.id, e.name AS ename, e.division, e.location, r.assetId, r.name, r.turnoverRef 
                        FROM assets_tbl AS a 
                        LEFT JOIN reference_tbl AS r ON r.assetId = a.id
                        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                        WHERE a.id='$userID' AND status !='Archive'";
                        $res = mysqli_query($db->conn, $sql);

                $res = mysqli_query($db->conn, $sql);

                while($row = mysqli_fetch_assoc($res)) {
                    $id = $row['aId'];
                    $ram = $row['name'];
                    // $storage = $row['STORAGE'];
                    // $specs = 'CPU: ' . $cpu . '<br>MEMORY: ' . $ram . '<br>STORAGE: ' . $storage;
        ?>
            <tr>
            
                <td><?php echo $row['assettype']; ?></td>
                <td><?php echo $id; ?></td>
                <td><?php echo $row['model']; ?></td>
                <td><?php echo $row['serial']; ?></td>
                <td><?php echo $row['remarks']; ?></td>    
            
            </tr>
        <?php
                }
            }
        ?>
        <?php
        // } elseif(isset($_GET['id'])) {
        } elseif($userID) {

            $userID = $_GET['id'];

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
            }
        }    
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