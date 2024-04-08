<?php 
include "../inc/auth.php";

function getCode($n) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    
    return "ACCT-" . $randomString . "-" . date("Y");
}

if(isset($_GET['generateAcc'])) {
    
    if(isset($_GET['select'])) {
        $selected = $_GET['select'];
        $existingAccountability = false; // Flag to check if any selected asset already has an accountability code
    
        // Loop through selected assets
        foreach ($selected as $assetID){
    
            $sql = 
                "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
                e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE a.id='$assetID' AND a.status !='Archive'";
            $res = mysqli_query($db->conn, $sql);
        
            while($row = mysqli_fetch_assoc($res)) {
                $assetTags[] = $row['assettag'];
                $acc_ref = $row['accountabilityRef'];
    
                $empId = $row['empId'];
            }
        }
    
        // Check if any of the selected assets already have an accountability code
        $existingCodeQuery = mysqli_prepare($db->conn, "SELECT accountabilityRef FROM reference_tbl WHERE assetId IN (?) AND accountabilityRef != ''");
        $selectedImploded = implode(",", $selected);
        mysqli_stmt_bind_param($existingCodeQuery, "s", $selectedImploded);
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
                $acc_ref = $newCode;
    
                // If assetId is existed in reference tbl
                $refSql = mysqli_prepare($db->conn, "SELECT * FROM reference_tbl WHERE assetId = ?");
                mysqli_stmt_bind_param($refSql, "i", $assetID);
                mysqli_stmt_execute($refSql);
                $result = mysqli_stmt_get_result($refSql);
                
                if (mysqli_num_rows($result) > 0) {
    
                    $refQry = mysqli_prepare($db->conn, "UPDATE reference_tbl SET accountabilityStatus = 1, accountabilityRef = ? WHERE assetId = ?");
                    mysqli_stmt_bind_param($refQry, "si", $newCode, $assetID);
                    mysqli_stmt_execute($refQry);
                    
                } else {
    
                    foreach ($selected as $assetID) {
                        // Insert new accountability reference for each asset
                        $refQry = mysqli_prepare($db->conn, "INSERT INTO reference_tbl (assetId, name, accountabilityRef, accountabilityStatus, referenceStatus) VALUES (?, ?, ?, 1, 1)");
                        mysqli_stmt_bind_param($refQry, "iss", $assetID, $empId, $newCode);
                        mysqli_stmt_execute($refQry);
                    }
    
                }
                // Log history for generated accountability code
                $history = mysqli_prepare($db->conn, "INSERT INTO history_tbl (name, action, date) VALUES (?, ?, NOW())");
                $action = "Generated accountability form for multiple assets: " . implode(", ", $assetTags);
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
    } elseif(isset($_GET['id'])) {
        // $assetID = $_GET['id'];
        // $selectedRefID = $assetID;
        $selectedReferenceCode = $_GET['id'];
    
        $sql =  
            "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
            e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef, r.turnoverRef 
            FROM assets_tbl AS a 
            LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
            LEFT JOIN employee_tbl AS e ON a.empId = e.id 
            WHERE r.accountabilityRef = '$selectedReferenceCode'";  
    
        $res = mysqli_query($db->conn, $sql);
    
        while($row = mysqli_fetch_assoc($res)) {
            $assetTags[] = $row['assettag'];
            $acc_ref = $row['accountabilityRef'];
    
            $empId = $row['empId'];
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
        <br><br><br>
        <center>
        <h2>Accountability Form</h2><br>
        </center>
        <div class="reference-code" align="right">
            <?php echo "<b>Ref#: " . $acc_ref . "</b>"; ?>
        </div>
            <table class="assets-table">
                <tr>
                    <th>Asset Type</th>
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
                <h3>Responsibilities</h3>
                <p>
                &nbsp;&nbsp; &nbsp;&nbsp;I, <b><?php echo $empName; ?></b>, acknowledge that the above-mentioned asset has been issued to me for the purpose of performing my job responsibilities. I understand and agree to the following responsibilities:
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
<?php
}

if(isset($_GET['generateTurnover'])) {
    if(isset($_GET['select'])) {
        $selected = $_GET['select'];
        $existingAccountability = false; // Flag to check if any selected asset already has an accountability code
    
        // Loop through selected assets
        foreach ($selected as $assetID){
    
            $sql = 
                "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
                e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE a.id='$assetID' AND a.status !='Archive'";
            $res = mysqli_query($db->conn, $sql);
        
            while($row = mysqli_fetch_assoc($res)) {
                $assetTags[] = $row['assettag'];
                $acc_ref = $row['accountabilityRef'];
    
                $empId = $row['empId'];
            }
        }
    
        // Check if any of the selected assets already have an accountability code
        $existingCodeQuery = mysqli_prepare($db->conn, "SELECT accountabilityRef FROM reference_tbl WHERE assetId IN (?) AND accountabilityRef != ''");
        $selectedImploded = implode(",", $selected);
        mysqli_stmt_bind_param($existingCodeQuery, "s", $selectedImploded);
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
                $acc_ref = $newCode;
    
                // If assetId is existed in reference tbl
                $refSql = mysqli_prepare($db->conn, "SELECT * FROM reference_tbl WHERE assetId = ?");
                mysqli_stmt_bind_param($refSql, "i", $assetID);
                mysqli_stmt_execute($refSql);
                $result = mysqli_stmt_get_result($refSql);
                
                if (mysqli_num_rows($result) > 0) {
    
                    $refQry = mysqli_prepare($db->conn, "UPDATE reference_tbl SET accountabilityStatus = 1, accountabilityRef = ? WHERE assetId = ?");
                    mysqli_stmt_bind_param($refQry, "si", $newCode, $assetID);
                    mysqli_stmt_execute($refQry);
                    
                } else {
    
                    foreach ($selected as $assetID) {
                        // Insert new accountability reference for each asset
                        $refQry = mysqli_prepare($db->conn, "INSERT INTO reference_tbl (assetId, name, accountabilityRef, accountabilityStatus, referenceStatus) VALUES (?, ?, ?, 1, 1)");
                        mysqli_stmt_bind_param($refQry, "iss", $assetID, $empId, $newCode);
                        mysqli_stmt_execute($refQry);
                    }
    
                }
                // Log history for generated accountability code
                $history = mysqli_prepare($db->conn, "INSERT INTO history_tbl (name, action, date) VALUES (?, ?, NOW())");
                $action = "Generated accountability form for multiple assets: " . implode(", ", $assetTags);
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

    } elseif(isset($_GET['id'])) {
        // $assetID = $_GET['id'];
        // $selectedRefID = $assetID;
        $selectedReferenceCode = $_GET['id'];
    
        $sql =  
            "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
            e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef, r.turnoverRef 
            FROM assets_tbl AS a 
            LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
            LEFT JOIN employee_tbl AS e ON a.empId = e.id 
            WHERE r.accountabilityRef = '$selectedReferenceCode'";  
    
        $res = mysqli_query($db->conn, $sql);
    
        while($row = mysqli_fetch_assoc($res)) {
            $assetTags[] = $row['assettag'];
            $acc_ref = $row['accountabilityRef'];
    
            $empId = $row['empId'];
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
        <br><br><br>
        <center>
        <h2>Accountability Form</h2><br>
        </center>
        <div class="reference-code" align="right">
            <?php echo "<b>Ref#: " . $acc_ref . "</b>"; ?>
        </div>
            <table class="assets-table">
                <tr>
                    <th>Asset Type</th>
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
                <h3>Responsibilities</h3>
                <p>
                &nbsp;&nbsp; &nbsp;&nbsp;I, <b><?php echo $empName; ?></b>, acknowledge that the above-mentioned asset has been issued to me for the purpose of performing my job responsibilities. I understand and agree to the following responsibilities:
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

<?php
}

?>

