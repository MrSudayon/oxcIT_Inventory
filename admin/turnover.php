<?php
require '../php/db_connection.php';

$select = new Select();
$db = new Connection();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
    $username = $user['username'];

} else {
    header("Location: ../php/login.php");
}

    
if(isset($_GET['select'])) {
    $selected = $_GET['select'];
    
    

// } elseif(isset($_GET['id'])) {
//     $userID = $_GET['id'];

//     $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
//     $res = mysqli_query($db->conn, $sql);
    
//     while($row = mysqli_fetch_assoc($res)) {
//         $name = $row['assigned'];
//         $dept = $row['department'];
//         $turnover_ref = $row['turnover_ref'];
//         // Logic to Ignore or dismiss if selected a multiple username/assigned user
//     }

// } else {
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

if(isset($selected)) {
    foreach ($selected as $userID){ 
            $sql = "SELECT DISTINCT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
            $res = mysqli_query($db->conn, $sql);
        
        while($row = mysqli_fetch_assoc($res)) {
            $name = $row['assigned'];
            $dept = $row['department'];
            $turnover_ref = $row['turnover_ref'];
            $arrayName[] = $name;
        }
            
    }
    $assetUser = "SELECT * FROM assets_tbl WHERE id='$userID' AND status != 'Archive'";
    $assetUserID = mysqli_query($db->conn, $assetUser);

}

?>  
    <div class="logo">
        <a href="dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
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
        } else {
            if ($turnover_ref == '') {
                echo "<b>Ref#: " .$newCode. "</b>";

                // query to fetch code in assets_tbl
                foreach ($selected as $userID) { 
                    $sql = mysqli_query($db->conn, "UPDATE assets_tbl SET turnover_ref = '$newCode' WHERE id='$userID' AND status!='Archive'");
                }

                while($row = mysqli_fetch_assoc($assetUserID)) {
                    $assettag = $row['assettag'];
                    $assigned = $row['lastused'];
            
                    $history = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                         VALUES ('', '$username', 'Turnover asset: $assettag, Last used by: $assigned', NOW())");
                }
            } else {
                echo "<b>Ref#: " . $turnover_ref . "</b>";
                while($row = mysqli_fetch_assoc($assetUserID)) {
                    $assettag = $row['assettag'];
                    $assigned = $row['lastused'];
            
                    $history = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                         VALUES ('', '$username', 'Viewed turnover form: $assettag, Last used by: $assigned', NOW())");
                }
            }
        }
    } else {
        ?>
            <script> 
            alert ('asdasder is not Allowed!')
            window.location.href = 'dashboard.php';
            </script> 
        <?php
    }
    ?>
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
                    <td><?php echo $row['remarks']; ?></td>    
                
                </tr>
            <?php
                }
            }    
                // foreach ($selected as $userID){ 
                //     $sql = "SELECT * FROM assets_tbl WHERE id='$userID' AND status !='Archive'";
                //     $res = mysqli_query($db->conn, $sql);
                
                // while($row = mysqli_fetch_assoc($res)) {
                //     $cpu = $row['CPU'];
                //     $ram = $row['MEMORY'];
                //     $storage = $row['STORAGE'];
                //     $specs = 'CPU: ' . $cpu . '<br>MEMORY: ' . $ram . '<br>STORAGE: ' . $storage;
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