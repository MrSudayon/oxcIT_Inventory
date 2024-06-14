<?php 
include "../inc/auth.php";

function getCode($n) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    
    return $randomString . "-" . date("Y");
}

if(isset($_GET['generateAcc'])) {
    
    if(isset($_GET['select'])) {
        $selected = $_GET['select'];
    
        $existingAccountability = false; // Flag to check if any selected asset already has an accountability code
    
        // Loop through selected assets
        foreach ($selected as $assetID) {
            $sql = 
                "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
                e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE a.id='$assetID' AND a.status = 'Deployed'";

            $res = mysqli_query($db->conn, $sql);
        
            while($row = mysqli_fetch_assoc($res)) {
                $assetTags[] = $row['assettag'];
                $acc_ref = $row['accountabilityRef'];
    
                $empId = $row['empId'];
            }
        }

        // Check if any of the selected assets already have an accountability code
        // $existingCodeQuery = mysqli_prepare($db->conn, "SELECT * FROM reference_tbl WHERE assetId IN (?) AND name='$empId' AND accountabilityRef != '' AND referenceStatus='1'");
        // $selectedImploded = implode(",", $selected);
        // mysqli_stmt_bind_param($existingCodeQuery, "s", $selectedImploded);
        // mysqli_stmt_execute($existingCodeQuery);
        // $existingCodeResult = mysqli_stmt_get_result($existingCodeQuery);

        $selectedImploded = implode(",", $selected);
        $existingCodeQuery = mysqli_prepare($db->conn, "SELECT * FROM reference_tbl WHERE accountabilityRef != '' AND assetId IN ($selectedImploded) AND name='$empId' AND referenceStatus='1'");
        mysqli_stmt_execute($existingCodeQuery);
        $existingCodeResult = mysqli_stmt_get_result($existingCodeQuery);

        if (mysqli_num_rows($existingCodeResult) > 0) {
            $existingAccountability = true;
        }
        if($existingAccountability) {
            ?>
            <script> 
                alert('Some selected assets already have accountability codes.');
                window.location.href = '../admin/employeeLists.php';
            </script> 
            <?php
        } else {
            if ($acc_ref == '') {
            
                $n = 5;
                $newCode = getCode($n); // Generate new accountability code for all selected assets
                $acc_ref = "ACCT-" . $newCode;
    
                // If assetId is existed in reference tbl
                // $refSql = mysqli_prepare($db->conn, "SELECT * FROM reference_tbl WHERE assetId = ? AND accountabilityRef!=''");
                // mysqli_stmt_bind_param($refSql, "i", $assetID);
                // mysqli_stmt_execute($refSql);
                // $result = mysqli_stmt_get_result($refSql);
                
                // if (mysqli_num_rows($result) > 0) {
                foreach ($selected as $assetID) {
                    $refQry = mysqli_prepare($db->conn, "UPDATE reference_tbl SET accountabilityStatus = 1, accountabilityRef = ?, referenceStatus='1' WHERE assetId = ? AND name=?");
                    mysqli_stmt_bind_param($refQry, "sis", $acc_ref, $assetID, $empId);
                    mysqli_stmt_execute($refQry);
                }
                    
                // } else {

                //     foreach ($selected as $assetID) {
                //         // Insert new accountability reference for each asset
                //         $refQry = mysqli_prepare($db->conn, "INSERT INTO reference_tbl (assetId, name, accountabilityRef, accountabilityStatus, referenceStatus) VALUES (?, ?, ?, 1, 1)");
                //         mysqli_stmt_bind_param($refQry, "iss", $assetID, $empId, $acc_ref);
                //         mysqli_stmt_execute($refQry);
                //     }

                // }
                // Log history for generated accountability code
                $history = mysqli_prepare($db->conn, "INSERT INTO history_tbl (name, action, date) VALUES (?, ?, NOW())");
                $action = "Generated accountability form for asset/s: " . implode(", ", $assetTags);
                mysqli_stmt_bind_param($history, "ss", $username, $action);
                mysqli_stmt_execute($history);
            } else {        
                // Log history
                $history = mysqli_prepare($db->conn, "INSERT INTO history_tbl (name, action, date) VALUES (?, ?, NOW())");
                $action = "Viewed accountability form for: " . implode(", ", $assetTags);
                mysqli_stmt_bind_param($history, "ss", $username, $action);
                mysqli_stmt_execute($history);
            }
        }
    } else {
        ?>
        <script>
            alert('Please select asset');
            window.location.replace('../admin/employeeLists.php');
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
        <div class="logo">
            <a href="../admin/employeeLists.php"><img src="../assets/logo.png" width="150px"></img></a>
        </div>
        <br>
        <center>
        <h2>Accountability Form</h2>
        </center>
        <div class="reference-code" align="right">
            <?php echo "<b>Ref#: " . $acc_ref . "</b>"; ?>
        </div>
            <table class="assets-table">
                <tr>
                    <th>Asset Tag</th>
                    <th>Model</th>
                    <th>Specification</th>
                    <th>Serial no.</th>
                    <th>Date Deployed</th>
                    <th>Remarks</th>
                </tr>
                <?php
                if(isset($selected)) {
    
                    foreach ($selected as $assetID) {
                        $sql = "SELECT * FROM assets_tbl WHERE id='$assetID' AND status !='Archive'";
                        $res = mysqli_query($db->conn, $sql);
        
                        while($row = mysqli_fetch_assoc($res)) {
                            $aId = $row['id'];
                            $assettag = $row['assettag'];
                            $model = $row['model'];
    
                            $serial = $row['serial'];
                            $datedeployed = $row['datedeployed'];
                            $remarks = $row['remarks'];
        
                            $specification = $operation->specificationCondition($aId);
                    ?>
                    <tr>
                        <td><?php echo $assettag; ?></td>
                        <td><?php echo $model; ?></td> 
                        <td><?php echo $specification; ?></td> 
                        <td><?php echo $serial; ?></td>
                        <td><?php echo $datedeployed; ?></td>
                        <td><?php echo $remarks; ?></td>    
                    </tr>
                    <?php
                        }
                    } 
                        
                }
                if(isset($selectedReferenceCode)) {
                    // Function for getting all same reference codes
                    $getAll = $operation->getAllSameCodes($selectedReferenceCode);
    
                    while($row = mysqli_fetch_assoc($getAll)) {
                        $aId[] = $row['aId'];
                        $assettype = $row['assettype'];
    
                        $serial = $row['serial'];
                        $datedeployed = $row['datedeployed'];
                        $remarks = $row['remarks'];
    
                        $specification = $operation->specificationCondition($aId);
                    ?>
                    <tr>
                        <td><?php echo $assettype; ?></td>
                        <td><?php echo $specification; ?></td> 
                        <td><?php echo $serial; ?></td>
                        <td><?php echo $datedeployed; ?></td>
                        <td><?php echo $remarks; ?></td>    
                    </tr>
                    <?php
                    }
                    
                }
    
                $result = $operation->getSpecificEmp($empId);
    
                while($row = mysqli_fetch_assoc($result)) {
                    $empName = $row['name'];
                    $dept = $row['division'];
                }
                ?>
            </table>

        <div class="info"><br>
            <h3>&nbsp;Responsibilities:</h3>
            <p>
            &nbsp;&nbsp;&nbsp;&nbsp;I, <b><?php echo $empName; ?></b>, acknowledge that the above-mentioned asset has been issued to me for the purpose of performing my job responsibilities. I understand and agree to the following responsibilities:
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
            <br><br><h4>Employee Signature: _________________</h4>
                <h4>Department: <b><?php echo $dept; ?></b></h4>
                <h4>Date: ___________</h4><br><br>

                [For Asset Administrator Use Only]<br><br>
                <p>Deployed by: ____________<br>
                Signature: ______________</p>
            <br>
        </div>
    </div> 
</body>
            
<?php
}

if(isset($_GET['generateTrn'])) {

    if(isset($_GET['select'])) {
        $selected = $_GET['select'];
        $existingTurnover = false; // Flag to check if any selected asset already has an accountability code
    
        // Loop through selected assets
        foreach ($selected as $assetID){
    
            $sql = 
                "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
                e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.turnoverRef, r.accountabilityRef, r.accountabilityStatus 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE a.id='$assetID' AND a.status !='Archive'";
            $res = mysqli_query($db->conn, $sql);
        
            while($row = mysqli_fetch_assoc($res)) {
                $assetTags[] = $row['assettag'];
                $trn_ref = $row['turnoverRef'];
                $acc_ref = $row['accountabilityRef'];
                $acc_status = $row['accountabilityStatus'];
                $empId = $row['empId'];
            }
        }
        if(empty($acc_ref) || $acc_ref == '' || $acc_status != '2') {
            echo "<script>
                alert ('Failed: Make a signed accountability first');
                window.location.replace('../admin/employeeLists.php');
                </script>";
        } else {
            // Check if any of the selected assets already have an turnover code
            // $existingCodeQuery = mysqli_prepare($db->conn, "SELECT * FROM reference_tbl WHERE turnoverRef != '' AND assetId IN (?)");
            $selectedImploded = implode(",", $selected);
            $existingCodeQuery = mysqli_prepare($db->conn, "SELECT * FROM reference_tbl WHERE turnoverRef != '' AND assetId IN ($selectedImploded) AND referenceStatus='1'");
            mysqli_stmt_execute($existingCodeQuery);
            $existingCodeResult = mysqli_stmt_get_result($existingCodeQuery);

            if (mysqli_num_rows($existingCodeResult) > 0) {
                $existingTurnover = true;
            }
        
            if($existingTurnover) {
                ?>
                <script> 
                    alert('Some selected assets already have turnover codes.');
                    window.location.href = '../admin/employeeLists.php';
                </script> 
                <?php
            } else {
        
                if ($trn_ref == '') {
                
                    $n = 5;
                    $newCode = getCode($n); // Generate new turnover code for all selected assets
                    $trn_ref = "TRNO-" . $newCode;
        

                    foreach ($selected as $assetID) {
                        $refQry = mysqli_prepare($db->conn, "UPDATE reference_tbl SET turnoverStatus='1', turnoverRef = ? WHERE assetId = ? AND name=?");
                        mysqli_stmt_bind_param($refQry, "sis", $trn_ref, $assetID, $empId);
                        mysqli_stmt_execute($refQry);
                    }

                    // Log history for generated turnover code
                    $history = mysqli_prepare($db->conn, "INSERT INTO history_tbl (name, action, date) VALUES (?, ?, NOW())");
                    $action = "Generated turnover form for multiple assets: " . implode(", ", $assetTags);
                    mysqli_stmt_bind_param($history, "ss", $username, $action);
                    mysqli_stmt_execute($history);
                } else {        
                    // Log history
                    $history = mysqli_prepare($db->conn, "INSERT INTO history_tbl (name, action, date) VALUES (?, ?, NOW())");
                    $action = "Viewed turnover form for: " . implode(", ", $assetTags);
                    mysqli_stmt_bind_param($history, "ss", $username, $action);
                    mysqli_stmt_execute($history);
                }
            }
        }

    } else {
        ?>
        <script>
            alert('Please select asset');
            window.location.replace('../admin/employeeLists.php');
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
        <div class="logo">
            <a href="../admin/employeeLists.php"><img src="../assets/logo.png" width="150px"></img></a>
        </div>
        <br>
        <center>
            <h2>Turnover Form</h2>
        </center>
        <div class="reference-code" align="right">
            <?php echo "<b>Ref#: " . $trn_ref . "</b>"; ?>
        </div>
        <table class="assets-table">
            <tr>
                <th>Asset Tag</th>
                <th>Model</th>
                <th>Specification</th>
                <th>Serial no.</th>
                <th>Date Deployed</th>
                <th>Remarks</th>
            </tr>
            <?php
            if(isset($selected)) {

                foreach ($selected as $assetID) {
                    $sql = "SELECT * FROM assets_tbl WHERE id='$assetID' AND status !='Archive'";
                    $res = mysqli_query($db->conn, $sql);
    
                    while($row = mysqli_fetch_assoc($res)) {
                        $aId = $row['id'];
                        $assettag = $row['assettag'];
                        $model = $row['model'];

                        $serial = $row['serial'];
                        $datedeployed = $row['datedeployed'];
                        $remarks = $row['remarks'];
    
                        $specification = $operation->specificationCondition($aId);
                ?>
                <tr>
                    <td><?php echo $assettag; ?></td>
                    <td><?php echo $model; ?></td>
                    <td><?php echo $specification; ?></td> 
                    <td><?php echo $serial; ?></td>
                    <td><?php echo $datedeployed; ?></td>
                    <td><?php echo $remarks; ?></td>    
                </tr>
                <?php
                    }
                } 
                    
            }
            if(isset($selectedReferenceCode)) {
                // Function for getting all same reference codes
                $getAll = $operation->getAllSameCodes($selectedReferenceCode);

                while($row = mysqli_fetch_assoc($getAll)) {
                    $aId[] = $row['aId'];
                    $assettype = $row['assettype'];

                    $serial = $row['serial'];
                    $datedeployed = $row['datedeployed'];
                    $remarks = $row['remarks'];

                    $specification = $operation->specificationCondition($aId);
                ?>
                <tr>
                    <td><?php echo $assettype; ?></td>
                    <td><?php echo $specification; ?></td> 
                    <td><?php echo $serial; ?></td>
                    <td><?php echo $datedeployed; ?></td>
                    <td><?php echo $remarks; ?></td>    
                </tr>
                <?php
                }
                
            }

            $result = $operation->getSpecificEmp($empId);

            while($row = mysqli_fetch_assoc($result)) {
                $empName = $row['name'];
                $dept = $row['division'];
            }
            ?>
        </table>

        <div class="info"><br><br>
            <h3>Acknowledgment:</h3>
            <p>
            &nbsp;&nbsp;I, <b><?php echo $empName; ?></b>, acknowledge that I have returned the above-mentioned equipment in the condition stated above. I understand that any damage or missing items may result in charges or disciplinary action.
            <br><br>
            <p>
            &nbsp;&nbsp;I, the undersigned, approve the transfer of the equipment as documented in this form.<br><br>
            Signature: __________________    <br>Date: __________</p>
            <br><br>
            [For Asset Administrator Use Only]<br><br>
            <h3>Asset Status:</h3>
            <p>
            ☐ Accepted in Good Condition<br>
            ☐ Accepted with Noted Issues (please specify): _______________________
            </p>
        </div>

        <!-- <div class="info"><br>
            <h4>&nbsp;Reason:</h4><br>
            <h3>Acknowledgment:</h3>
            <p>
            &nbsp;&nbsp;I, <b>?php echo $empName; ?></b>, acknowledge that I have returned the above-mentioned equipment in the condition stated above. I understand that any damage or missing items may result in charges or disciplinary action.
            <br><br>
            <h3>Asset Administrator:</h3>
            <p>
            &nbsp;&nbsp;I, the undersigned, approve the transfer of the equipment as documented in this form.<br>
            <br>Asset Administrator: [Signature] __________________    [Date] __________</p>
            <br><br>
            [For Asset Administrator Use Only]<br><br>
            <h3>Asset Status:</h3>
            <p>
            ☐ Accepted in Good Condition<br>
            ☐ Accepted with Noted Issues (please specify): _______________________
            </p>
        </div> -->
    </div>
</body>

<?php
}
?>
    
<script src="../js/print.js"></script>




</html>

