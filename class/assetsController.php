<?php
$select = new Select();

if(isset($_SESSION['id'])) {
    $session = $select->selectUserById($_SESSION['id']);
    $sess_name = $session['username'];
}
class assetsController {

    public function edit($id) {
        global $db;
        
        $assetID = mysqli_real_escape_string($db->conn, $id);
        $assetQuery = "SELECT a.id AS aId, a.assettype, a.assettag, a.model, a.status AS aStatus, 
                                a.serial, a.supplier, a.cost, a.repair_cost, a.datepurchased, a.remarks, 
                                a.datedeployed, a.empId, a.lastused, 
                                a.cpu, a.memory, a.storage, a.os, a.dimes, a.mobile, a.plan, 
                                e1.id AS assignedId, e1.name AS empName, e1.division AS empDivision, e1.location AS empLocation, 
                                e2.id AS lastUsedId, e2.name AS lastUsedName, e2.division AS lastUsedDivision, e2.location AS lastUsedLocation 
                        FROM assets_tbl AS a 
                        LEFT JOIN employee_tbl AS e1 ON e1.id = a.empId 
                        LEFT JOIN employee_tbl AS e2 ON e2.id = a.lastused
                        WHERE a.id = '$assetID' AND a.status != 'Archive'";

        $res = mysqli_query($db->conn, $assetQuery);

        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }

    public function updateData($input, $id) {
        global $db;
        global $sess_name;

        $assetID = mysqli_real_escape_string($db->conn, $id);
        
        $model = $input['model'];
        $serial = $input['serial'];
        $supplier = $input['supplier'];
        $status = $input['status'];

        if($status != 'Deployed') {
            $empId = '0';
        }

        $cost = $input['cost'];
        $repair = $input['repair-cost'];

        $cpu = $input['cpu'];
        $ram = $input['ram'];
        $storage = $input['storage'];
        $os = $input['os'];

        // SIM, Mobile
        $dimes = $input['dimes'];

        $mobile = $input['mobile'];
        $plan = $input['plan'];

        $dateprchs = $input['datepurchase'];
        $remarks = $input['remarks'];

        $datedeployed = $input['datedeployed'];

        $empId = $input['assigned'];
        $lastused = $input['lastused'];

        $qry = "UPDATE assets_tbl SET model=?, serial=?, supplier=?, empId=?, status=?, datepurchased=?, cost=?, repair_cost=?, remarks=?, datedeployed=?, cpu=?, memory=?, storage=?, dimes=?, mobile=?, plan=?, os=? WHERE id=? AND status!='Archive' LIMIT 1";
        $stmt = $db->conn->prepare($qry);
        $stmt->bind_param("sssssssssssssssssi", $model, $serial, $supplier, $empId, $status, $dateprchs, $cost, $repair, $remarks, $datedeployed, $cpu, $ram, $storage, $dimes, $mobile, $plan, $os, $assetID);
        $result = $stmt->execute();

        $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $assetID");
        while($row = $tag->fetch_assoc()) {
            $assettag = $row['assettag'];
        }

        mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                    VALUES('', '$sess_name', 'Updated record: $assettag', NOW())");

        return true;
    }

    // public function update($input, $id) {
    //     global $db;
    //     global $sess_name;

    //     $assetID = mysqli_real_escape_string($db->conn, $id);

    //     $model = $input['model'];
    //     $serial = $input['serial'];
    //     $supplier = $input['supplier'];
    //     $status = $input['status'];

    //     if($status != 'Deployed') {
    //         $empId = '0';
    //     }

    //     $cost = $input['cost'];
    //     $repair = $input['repair-cost'];

    //     $cpu = $input['cpu'];
    //     $ram = $input['ram'];
    //     $storage = $input['storage'];
    //     $os = $input['os'];

    //     // SIM, Mobile
    //     $dimes = $input['dimes'];

    //     $mobile = $input['mobile'];
    //     $plan = $input['plan'];

    //     $dateprchs = $input['datepurchase'];
    //     $remarks = $input['remarks'];

    //     $datedeployed = $input['datedeployed'];

    //     $empId = $input['assigned'];
    //     $lastused = $input['lastused'];


    //     // $qry = "UPDATE assets_tbl SET model='$model', serial='$serial', supplier='$supplier', empId='$empId', status='$status', datepurchased='$dateprchs', cost='$cost', repair_cost='$repair', remarks='$remarks', datedeployed='$datedeployed', cpu='$cpu', memory='$ram', storage='$storage', dimes='$dimes', mobile='$mobile', plan='$plan', os='$os' WHERE id='$assetID' AND status!='Archive' LIMIT 1";
    //     // $result = $db->conn->query($qry);

    //     // $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $assetID");
    //     // while($row = $tag->fetch_assoc()) {
    //     //     $assettag = $row['assettag'];
    //     // }
        

    //     $qry = "UPDATE assets_tbl SET model=?, serial=?, supplier=?, empId=?, status=?, datepurchased=?, cost=?, repair_cost=?, remarks=?, datedeployed=?, cpu=?, memory=?, storage=?, dimes=?, mobile=?, plan=?, os=? WHERE id=? AND status!='Archive' LIMIT 1";
    //     $stmt = $db->conn->prepare($qry);
    //     $stmt->bind_param("sssssssssssssssssi", $model, $serial, $supplier, $empId, $status, $dateprchs, $cost, $repair, $remarks, $datedeployed, $cpu, $ram, $storage, $dimes, $mobile, $plan, $os, $assetID);
    //     $result = $stmt->execute();

    //     if($result) {
    //         // Get asset tag
    //         $tagQuery = "SELECT assettag FROM assets_tbl WHERE id = ?";
    //         $tagStmt = $db->conn->prepare($tagQuery);
    //         $tagStmt->bind_param("i", $assetID);
    //         $tagStmt->execute();
    //         $tagResult = $tagStmt->get_result();
    //         $tagRow = $tagResult->fetch_assoc();
    //         $assettag = $tagRow['assettag'];
            

    //         $refActive = 1;
    //         $refDone = 2;
    //         // Check if reference exists
    //         // $refQuery = "SELECT * FROM reference_tbl WHERE assetId=? OR (assetId=? AND referenceStatus=?)";
    //         $refQuery = "SELECT * FROM reference_tbl WHERE assetId=? AND referenceStatus=?";

    //         $refStmt = $db->conn->prepare($refQuery);
    //         $refStmt->bind_param("ii", $assetID, $refActive);
    //         $refStmt->execute();
    //         $refResult = $refStmt->get_result();
        
    //         if ($refResult->num_rows == 0) {
    //             // Insert new reference
    //             $referenceQuery = "INSERT INTO reference_tbl (assetId, name, accountabilityRef, turnoverRef, referenceStatus) VALUES (?, ?, '', '', 1)";
    //             $referenceStmt = $db->conn->prepare($referenceQuery);
    //             $referenceStmt->bind_param("is", $assetID, $empId);
    //             $referenceResult = $referenceStmt->execute();
            
    //             // What if reference is completed?
    //             if (!$referenceResult) {
    //                 echo 'Failed to insert reference';
    //             }

    //         } else {

    //             $refQuery = "SELECT * FROM reference_tbl WHERE assetId=? AND referenceStatus=?";
    //             // referenceStatus confusion 0 to 1 Upon deletion/updating of assets
    //             $refStmt = $db->conn->prepare($refQuery);
    //             $refStmt->bind_param("ii", $assetID, $refDone);
    //             $refStmt->execute();
    //             $refResult = $refStmt->get_result();

    //             // fix this 9/17
    //             // issue when employee is resigned, ignore its record and add new reference details
    //             if($refResult->num_rows == 0) {
                    
    //                 $qry = "INSERT INTO reference_tbl (assetId, name, accountabilityRef, turnoverRef, referenceStatus) VALUES (?, ?, '', '', 1)";
    //                 $stmt = $db->conn->prepare($qry);
    //                 $stmt->bind_param("is", $assetID, $empId);
    //                 $result = $stmt->execute();

    //             } else {
                    
    //                 // Update existing reference
    //                 $qry = "UPDATE reference_tbl SET name=?, referenceStatus='1' WHERE assetId=? AND turnoverRef=''";
    //                 $stmt = $db->conn->prepare($qry);
    //                 $stmt->bind_param("si", $empId, $assetID);
    //                 $result = $stmt->execute();
    //             }
    //             // } else {
    //             //     echo "isee";
    //             // }
                
    //         }

    //         $operation = new Operations();
    //         if($empId!='0' || $empId!='') {
    //             $empName = $operation->getThyNames($empId);

    //             if($status != 'Deployed') {
    //                 mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
    //                     VALUES('', '$sess_name', 'Removed the accountability for $assettag', NOW())");
    //             } else {
    //                 mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
    //                     VALUES('', '$sess_name', 'Assigned: $assettag to $empName', NOW())");
    //             }
                
    //         } else {
    //             mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
    //                 VALUES('', '$sess_name', 'Updated record: $assettag', NOW())");
    //         }

            
    //         return true;

    //     } else {
    //         return false;
    //     }
    // }

    public function update($input, $id) {
        global $db;
        global $sess_name;

        $assetID = mysqli_real_escape_string($db->conn, $id);

        $model = $input['model'];
        $serial = $input['serial'];
        $supplier = $input['supplier'];
        $status = $input['status'];

        if($status != 'Deployed') {
            $empId = '0';
        }

        $cost = $input['cost'];
        $repair = $input['repair-cost'];

        $cpu = $input['cpu'];
        $ram = $input['ram'];
        $storage = $input['storage'];
        $os = $input['os'];

        // SIM, Mobile
        $dimes = $input['dimes'];

        $mobile = $input['mobile'];
        $plan = $input['plan'];

        $dateprchs = $input['datepurchase'];
        $remarks = $input['remarks'];

        $datedeployed = $input['datedeployed'];

        $empId = $input['assigned'];
        $lastused = $input['lastused'];


        // $qry = "UPDATE assets_tbl SET model='$model', serial='$serial', supplier='$supplier', empId='$empId', status='$status', datepurchased='$dateprchs', cost='$cost', repair_cost='$repair', remarks='$remarks', datedeployed='$datedeployed', cpu='$cpu', memory='$ram', storage='$storage', dimes='$dimes', mobile='$mobile', plan='$plan', os='$os' WHERE id='$assetID' AND status!='Archive' LIMIT 1";
        // $result = $db->conn->query($qry);

        // $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $assetID");
        // while($row = $tag->fetch_assoc()) {
        //     $assettag = $row['assettag'];
        // }
        

        $qry = "UPDATE assets_tbl SET model=?, serial=?, supplier=?, empId=?, status=?, datepurchased=?, cost=?, repair_cost=?, remarks=?, datedeployed=?, cpu=?, memory=?, storage=?, dimes=?, mobile=?, plan=?, os=? WHERE id=? AND status!='Archive' LIMIT 1";
        $stmt = $db->conn->prepare($qry);
        $stmt->bind_param("sssssssssssssssssi", $model, $serial, $supplier, $empId, $status, $dateprchs, $cost, $repair, $remarks, $datedeployed, $cpu, $ram, $storage, $dimes, $mobile, $plan, $os, $assetID);
        $result = $stmt->execute();

        if($result) {
            // Get asset tag
            $tagQuery = "SELECT assettag FROM assets_tbl WHERE id = ?";
            $tagStmt = $db->conn->prepare($tagQuery);
            $tagStmt->bind_param("i", $assetID);
            $tagStmt->execute();
            $tagResult = $tagStmt->get_result();
            $tagRow = $tagResult->fetch_assoc();
            $assettag = $tagRow['assettag'];
            
            $refArchive = 0;
            $refActive = 1;
            $refDone = 2;
            // Check if reference exists
            // $refQuery = "SELECT * FROM reference_tbl WHERE assetId=? OR (assetId=? AND referenceStatus=?)";
            $refQuery = "SELECT * FROM reference_tbl WHERE assetId=? AND referenceStatus=?";

            $refStmt = $db->conn->prepare($refQuery);
            $refStmt->bind_param("ii", $assetID, $refDone);
            $refStmt->execute();
            $refResult = $refStmt->get_result();
        
            if ($refResult->num_rows > 0) {

                // Inserts new reference and keep the reference with status '2'
                $referenceQuery = "INSERT INTO reference_tbl (assetId, name, accountabilityRef, turnoverRef, referenceStatus) VALUES (?, ?, '', '', 1)";
                $referenceStmt = $db->conn->prepare($referenceQuery);
                $referenceStmt->bind_param("is", $assetID, $empId);
                $referenceResult = $referenceStmt->execute();
            
                // What if reference is completed?
                if (!$referenceResult) {
                    echo 'Failed to insert reference';
                }

            } else {
                
                // Proceeds when theres a record with ref status 1 OR 0
                $refQuery = "SELECT * FROM reference_tbl WHERE assetId=? AND referenceStatus=?"; 
                // referenceStatus confusion 0 to 1 Upon deletion/updating of assets
                $refStmt = $db->conn->prepare($refQuery);
                $refStmt->bind_param("ii", $assetID, $refArchive);
                $refStmt->execute();
                $refResult = $refStmt->get_result();

                // fix this 9/17
                // issue when employee is resigned, ignore its record and add new reference details
                if($refResult->num_rows > 0) {

                    // Update existing reference with status 0
                    $qry = "UPDATE reference_tbl SET name=?, referenceStatus='1' WHERE assetId=? AND turnoverRef=''";
                    $stmt = $db->conn->prepare($qry);
                    $stmt->bind_param("si", $empId, $assetID);
                    $result = $stmt->execute();

                } else {
                    
                    $refQuery = "SELECT * FROM reference_tbl WHERE assetId=? AND referenceStatus=?"; 
                    // referenceStatus confusion 0 to 1 Upon deletion/updating of assets
                    $refStmt = $db->conn->prepare($refQuery);
                    $refStmt->bind_param("ii", $assetID, $refActive);
                    $refStmt->execute();
                    $refResult1 = $refStmt->get_result();

                    if($refResult1->num_rows == 0 ) {

                        $qry = "INSERT INTO reference_tbl (assetId, name, accountabilityRef, turnoverRef, referenceStatus) VALUES (?, ?, '', '', 1)";
                        $stmt = $db->conn->prepare($qry);
                        $stmt->bind_param("is", $assetID, $empId);
                        $result = $stmt->execute();

                    } else {

                        // Update existing reference with status 0 or 1
                        $qry = "UPDATE reference_tbl SET name=? WHERE assetId=? AND turnoverRef=''";
                        $stmt = $db->conn->prepare($qry);
                        $stmt->bind_param("si", $empId, $assetID);
                        $result = $stmt->execute();

                    }
                  
                }
                
            }

            $operation = new Operations();
            if($empId!='0' || $empId!='') {
                $empName = $operation->getThyNames($empId);

                if($status == 'Deployed') {
                    mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                        VALUES('', '$sess_name', 'Assigned: $assettag to $empName', NOW())");
                } else {
                    mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                    VALUES('', '$sess_name', 'Updated record: $assettag', NOW())");
                }
                
            } else {
                mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                    VALUES('', '$sess_name', 'Updated record: $assettag', NOW())");
            }

            
            return true;

        } else {
            return false;
        }
    }

    public function assetTurnover($input, $id) {
        global $db;
        global $sess_name;

        $assetID = mysqli_real_escape_string($db->conn, $id);
        $turnover = $input['turnover'];
        $lastused = $input['lastused'];
        $reason = $input['reason'];
        $ref_Code = $input['ref_code'];

        // get id of selected asset ($assetID)
        // $sql = "SELECT * FROM assets_tbl WHERE id='$assetID' AND status != 'Archive'";
        $sql = "SELECT a.id AS aId, a.assettype, a.assettag, a.model, a.status as aStatus, 
                a.serial, a.supplier, a.cost, a.repair_cost, a.datepurchased, a.remarks, 
                a.datedeployed, a.empId, a.lastused, 
                a.cpu, a.memory, a.storage, a.os, a.dimes, a.mobile, a.plan, 
                r.assetId, r.turnoverRef, 
                e.id, e.name AS empName, e.division, e.location 
                FROM assets_tbl AS a 
                LEFT JOIN employee_tbl AS e ON e.id = a.empId 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                WHERE a.id = '$assetID' AND a.status != 'Archive'";
        $res = mysqli_query($db->conn,$sql);
        while($row = $res->fetch_assoc()) {
            $assettag = $row['assettag'];
            $turnover_ref = $row['turnoverRef'];
            $assigned = $row['empId'];
            $empName = $row['empName'];
        }
        
        // validation of Turnover reference code
        if($ref_Code == $turnover_ref) {
            $lastusedby = $assigned;

            // Change Asset data based on Reason of Turnover
            if ($reason == 'Resign') {
                $newStatus = 'To be deploy';
            } elseif ($reason == 'Defective') {
                $newStatus = 'Defective';
            } else {
                $newStatus = 'Outdated';
            }

            // mysqli_query($db->conn, "UPDATE assets_tbl SET empId='', datedeployed='', turnoverdate=NOW(), lastused='$lastusedby', reason='$reason', status='$newStatus' WHERE id='$assetID' AND status!='Archive' LIMIT 1");
            mysqli_begin_transaction($db->conn);
            try {
                // Update assets_tbl
                $assetUpdateQuery = "UPDATE assets_tbl SET empId='', datedeployed='', turnoverdate=NOW(), lastused='$lastusedby', status='$newStatus' WHERE id='$assetID' AND status!='Archive' LIMIT 1";
                mysqli_query($db->conn, $assetUpdateQuery);

                // Update reference_tbl
                // $referenceUpdateQuery = "UPDATE reference_tbl SET turnoverReason='$reason', referenceStatus='0' WHERE assetId='$assetID' AND referenceStatus !='0'";
                $referenceUpdateQuery = "UPDATE reference_tbl SET referenceStatus='0' WHERE assetId='$assetID' AND referenceStatus !='0'";
                mysqli_query($db->conn, $referenceUpdateQuery);

                // Commit the transaction
                mysqli_commit($db->conn);
            } catch (Exception $e) {
                // An error occurred, rollback the transaction
                mysqli_rollback($db->conn);
                echo "Error updating database: " . $e->getMessage();
                die();
            }
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                VALUES('', '$sess_name', 'Turnover asset: $assettag, last used by: $empName' , NOW())");
            
            return 1; // Turnover success
           
        } else {
            return 100;
        }    
        
            
    }

    // Emp
    public function empEdit($id) {
        global $db;

        $empID = mysqli_real_escape_string($db->conn, $id);
        $empQuery = "SELECT * FROM employee_tbl WHERE id='$empID'";
        $res = mysqli_query($db->conn, $empQuery);
        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        }else{
            return false;
        }
    }
    public function empUpdate($input, $id) {
        global $db;
        global $sess_name;

        $empID = mysqli_real_escape_string($db->conn, $id);
        $empname = $input['name'];
        $division = $input['division'];
        $location = $input['location'];
        $status = $input['status'];
        
        // validation of Turnover reference code
        $qry = "UPDATE employee_tbl SET name='$empname', division='$division', location='$location', empStatus='$status' WHERE id='$empID' LIMIT 1";
        $result = $db->conn->query($qry);

        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$sess_name', 'Updated employee: $empname ID: $empID' , NOW())");

            return true;
        } else {
            return false;
        } 
    }

    // Asset Item
    public function assetItemEdit($id) {
        global $db;
        
        $assetItemID = mysqli_real_escape_string($db->conn, $id);
        $assetQuery = "SELECT * FROM category_tbl WHERE id='$assetItemID'";
        $res = mysqli_query($db->conn, $assetQuery);
        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        }else{
            return false;
        }
    }
    public function assetItemUpdate($input, $id) {
        global $db;
        global $sess_name;

        $assetItemID = mysqli_real_escape_string($db->conn, $id);
        $assetname = $input['name'];
        $status = $input['status'];

        // validation of Turnover reference code
        $qry = "UPDATE category_tbl SET assetType='$assetname', status='$status' WHERE id='$assetItemID' LIMIT 1";
        $result = $db->conn->query($qry);

        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$sess_name', 'Updated asset item: $assetname ID: $assetItemID' , NOW())");

            return true;
        } else {
            return false;
        } 
    }

    // Division Item
    public function divisionEdit($id) {
        global $db;
        $divID = mysqli_real_escape_string($db->conn, $id);
        $divQuery = "SELECT * FROM dept_tbl WHERE id='$divID'";
        $res = mysqli_query($db->conn, $divQuery);
        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        }else{
            return false;
        }
    }
    public function divisionUpdate($input, $id) {
        global $db;
        global $session;

        $divID = mysqli_real_escape_string($db->conn, $id);
        $divname = $input['name'];
        $status = $input['status'];
        
        // validation of Turnover reference code
        $qry = "UPDATE dept_tbl SET name='$divname', status='$status' WHERE id='$divID' LIMIT 1";
        $result = $db->conn->query($qry);

        $name = $session['username'];
        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                VALUES('', '$name', 'Updated division name: $divname' , NOW())");

            return true;
        } else {
            return false;
        } 
    }

    public function locationEdit($id) {
        global $db;

        $ID = mysqli_real_escape_string($db->conn, $id);
        $locQuery = "SELECT * FROM loc_tbl WHERE id='$ID'";
        $res = mysqli_query($db->conn, $locQuery);
        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        }else{
            return false;
        }
    }
    public function locationUpdate($input, $id) {
        global $db;
        global $session;

        $ID = mysqli_real_escape_string($db->conn, $id);
        $locName = $input['name'];
        $status = $input['status'];

        // validation of Turnover reference code
        $qry = "UPDATE loc_tbl SET name='$locName', status='$status' WHERE id='$ID' LIMIT 1";
        $result = $db->conn->query($qry);

        $name = $session['username'];
        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$name', 'Updated location name: $locName' , NOW())");

            return true;
        } else {
            return false;
        } 
    }


    // // Reference Update
    public function editReference($id) {
        global $db;
    
        // Sanitize the input
        $refNo = mysqli_real_escape_string($db->conn, $id);
    
        // SQL Query to fetch relevant data
        $sql = "SELECT DISTINCT 
                    r.name, r.assetId AS rAssetId, 
                    r.accountabilityRef, r.accountabilityStatus, r.accountabilityFile AS accountabilityFile, r.accountabilityDate,
                    r.turnoverRef, r.turnoverStatus, r.turnoverFile AS turnoverFile, r.turnoverDate, 
                    e.id AS empId, e.name AS empName 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON e.id = a.empId 
                WHERE r.accountabilityRef='$refNo' OR r.turnoverRef='$refNo'";
    
        // Execute the query
        $res = mysqli_query($db->conn, $sql);
    
        if ($res && $res->num_rows >= 1) {
            $data = [];
            $rAssetIds = [];
            $firstRow = true;
    
            while ($row = $res->fetch_assoc()) {
                // Collect all rAssetId values
                if (!empty($row['rAssetId'])) {
                    $rAssetIds[] = $row['rAssetId'];
                }
    
                // Extract other fields from the first row (assuming they are identical)
                if ($firstRow) {
                    $data = $row;
                    $firstRow = false;
                }
            }
    
            // Replace rAssetId with the array of asset IDs
            $data['rAssetId'] = $rAssetIds;
    
            return $data;
        } else {
            return false;
        }
    }

    public function updateReference($input, $id, $eId, $action) {
        global $db;
        global $sess_name;

        $refNo = mysqli_real_escape_string($db->conn, $id);
        $eName = mysqli_real_escape_string($db->conn, $eId);

        if($action == 'AccountabilityRef') {
            $assetID = $input['assetIds'];
            $acctStatus = $input['acctStatus'];
            $acctDate = $input['acctDate'];
            $acctFile = $input['acctFile'];

            if($acctStatus == 1) {
                $astatus = 'On Process';
            } elseif($acctStatus == 2) {
                $astatus = 'Signed';
            }

            $sql = "UPDATE reference_tbl 
                    SET accountabilityStatus = '$acctStatus', accountabilityDate = '$acctDate', accountabilityFile = '$acctFile' 
                    WHERE name='$eName' AND accountabilityRef='$refNo'";
            $result = $db->conn->query($sql);

            if($result) {
                mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                VALUES('', '$sess_name', 'Updated reference no: $refNo, Status: $astatus' , NOW())");

                return true;
            } else {
                return false;
            } 
        }
        elseif($action == 'TurnoverRef') {

            $assetIDs = $input['assetIds'];
            $trnStatus = $input['trnStatus'];
            $trnDate = $input['trnDate'];
            $trnFile = $input['trnFile'];

            if($trnStatus == 1) {
                $tstatus = 'On Process';
            } elseif($trnStatus == 2) {
                $tstatus = 'Signed';
            }

            if($assetIDs != '' || $assetIDs != null) {

                $sql = "UPDATE reference_tbl 
                SET turnoverStatus='$trnStatus', turnoverDate='$trnDate', turnoverFile='$trnFile', referenceStatus='2' 
                WHERE name='$eName' AND turnoverRef='$refNo'";
    
                $result = $db->conn->query($sql);
    
                if($result) {
                    if (is_array($assetIDs)) {    
                        foreach ($assetIDs as $ids) {
                            // Debugging - print or log to verify each assetId
                            echo "Updating asset ID: " . $ids . "<br>";
            
                            // Update each asset in assets_tbl
                            $updateAsset = "UPDATE assets_tbl
                                            SET empId='0', status='To be deploy', lastused='$eName' 
                                            WHERE id = '$ids'";
                            
                            // Execute the update query for each asset
                            $updateResult = mysqli_query($db->conn, $updateAsset);
            
                            // Debugging - check if query succeeded
                            if (!$updateResult) {
                                echo "Error updating asset ID: " . $assetId . " - " . mysqli_error($db->conn);
                            }
                        }
                        mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                        VALUES('', '$sess_name', 'Updated reference no: $refNo, Status: $tstatus' , NOW())");
        
                        return true;
                    } 
                }
                
            } else {
                return false;
            }
        }
    }
}

?>