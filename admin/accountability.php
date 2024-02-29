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

foreach ($selected as $userID) { 
    $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
    $res = mysqli_query($db->conn, $sql);

    while($row = mysqli_fetch_assoc($res)) {
        $name = $row['assigned'];
        $dept = $row['department'];
        $acc_ref = $row['accountability_ref'];
        $arrayName[] = $name;
        // Logic to Ignore or dismiss if selected a multiple username/assigned user
        
    }
}
} elseif(isset($_GET['selectAll'])) {
    ?>
        <script>
            alert('Accountability handle per person only');
            window.location.replace('dashboard.php');
        </script>
    <?php
} elseif(isset($_GET['id'])) {
    $userID = $_GET['id'];

    $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
    $res = mysqli_query($db->conn, $sql);
    
    while($row = mysqli_fetch_assoc($res)) {
        $name = $row['assigned'];
        $dept = $row['department'];
        $acc_ref = $row['accountability_ref'];
        // Logic to Ignore or dismiss if selected a multiple username/assigned user
    }

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
    <title>Accountability Form</title>
</head>
<body>
<div class="content">
<?php 

                
// foreach ($selected as $userID) { 
//         $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
//         $res = mysqli_query($db->conn, $sql);
    
//     while($row = mysqli_fetch_assoc($res)) {
//         $name = $row['assigned'];
//         $dept = $row['department'];
//         $acc_ref = $row['accountability_ref'];
//         $arrayName[] = $name;
//         // Logic to Ignore or dismiss if selected a multiple username/assigned user
        
//     }
// }


?>  
    <div class="logo">
        <a href="dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
    </div>
    <br><br><br>
    <center>
    <h2>Accountability Form</h2><br>
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
            
            return "ACCT-".$refCode;
        }
        $newCode = getCode($n);
        
        // If reference code exists, Display existing Ref Code
        // else generate new
    if(isset($arrayName)) {
        if(count(array_unique($arrayName))>1) {
            ?>
                <script> 
                alert ('Multiple User is not Allowed!')
                window.location.href = 'dashboard.php';
                </script> 
            <?php
        } elseif($name == '') {
            ?>
                <script> 
                alert ('There is no Assigned User')
                window.location.href = 'dashboard.php';
                </script> 
            <?php
        } else {
            if ($acc_ref == '') {
                echo "<b>Ref#: " .$newCode. "</b>";
                // query to fetch code in assets_tbl
                foreach ($selected as $userID) { 
                    $sql = mysqli_query($db->conn, "UPDATE assets_tbl SET accountability_ref = '$newCode' WHERE id='$userID' AND status!='Archive'");
                }
            } else {
                echo "<b>Ref#: " . $acc_ref . "</b>";
            }
        }
    } else {
        echo "<b>Ref#: " . $acc_ref . "</b>";
    }
        
    ?>
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

            if(isset($_GET['select'])) {
                $selected = $_GET['select'];

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
                
                    <td><?php echo $row['assettype']; ?></td>
                    <td><?php echo $specs; ?></td>
                    <td><?php echo $row['Others']; ?></td>
                    <td><?php echo $row['serial']; ?></td>
                    <td><?php echo $row['datedeployed']; ?></td>
                    <td><?php echo $row['remarks']; ?></td>    
                
                </tr>
                <?php
                    }
                }
            } elseif(isset($_GET['id'])) {
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
                    <td><?php echo $row['datedeployed']; ?></td>
                    <td><?php echo $row['remarks']; ?></td>    
                
                </tr>
            <?php
                }
            }
            ?>
        </table>
        <div class="info"><br>
            <h3>Responsibilities</h3>
            <p>
            &nbsp;&nbsp; &nbsp;&nbsp;I, <b><?php echo $name; ?></b>, acknowledge that the above-mentioned asset has been issued to me for the purpose of performing my job responsibilities. I understand and agree to the following responsibilities:
            <br><br></p>
            <p style="font-weight: 600;">
            1. I am responsible for the proper use and care of the assigned asset.
            <br>2. I will report any damage, loss, or malfunction of the asset to my supervisor immediately.
            <br>3. I will not loan, transfer, or dispose of the asset without prior authorization from the appropriate authority.
            <br>4. I will return the asset in good condition upon termination of my employment or upon request by the company.
            </p>
           
            <br><br>
            <h3>Asset Return:</h3>
            <p>
            &nbsp;&nbsp; &nbsp;&nbsp;I understand that I am required to return the asset on the specified date or upon termination of my employment. Failure to return the asset in good condition may result in disciplinary action and/or financial responsibility for repair or replacement costs.</p>
            <br>[For Asset Administrator Use Only]<br><br>
                <p>Deployed by: ____________<br>
                Signature: ______________</p>
            <br><br>
            
                <h4>Employee Signature: _________________</h4>
                <h4>Department: <b><?php echo $dept; ?></b></h4>
                <h4>Date: ___________</h4><br>
        </div>
        
    </div>
    
<script src="../js/print.js"></script>
</body>
</html>