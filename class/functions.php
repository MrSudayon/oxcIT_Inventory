<?php
$select = new Select();

if(isset($_SESSION['id'])) {
    $session = $select->selectUserById($_SESSION['id']);
    $sess_name = $session['username'];
}
class Operations {
    function record_Data($type, $tag, $mdl, $srl, $supplier, $empId, $lastused, $status, $dtprchs, $cost, $repair_cost, $remarks, $datedeployed, $cpu, $ram, $storage, $dimes, $mobile, $plan, $os, $action) {
        global $db;
        global $sess_name;

        $type         = mysqli_real_escape_string($db->conn, $type);
        $tag          = mysqli_real_escape_string($db->conn, $tag);
        $mdl          = mysqli_real_escape_string($db->conn, $mdl);
        $srl          = mysqli_real_escape_string($db->conn, $srl);
        $supplier     = mysqli_real_escape_string($db->conn, $supplier);
        $empId        = mysqli_real_escape_string($db->conn, $empId);
        $lastused     = mysqli_real_escape_string($db->conn, $lastused);
        $dtprchs      = mysqli_real_escape_string($db->conn, $dtprchs);
        $cost         = mysqli_real_escape_string($db->conn, $cost);
        $repair_cost  = mysqli_real_escape_string($db->conn, $repair_cost);
        $lastused     = mysqli_real_escape_string($db->conn, $remarks);
        $remarks      = mysqli_real_escape_string($db->conn, $remarks);
        $datedeployed = mysqli_real_escape_string($db->conn, $datedeployed);
        $cpu          = mysqli_real_escape_string($db->conn, $cpu);
        $storage      = mysqli_real_escape_string($db->conn, $storage);
        $dimes        = mysqli_real_escape_string($db->conn, $dimes);
        $mobile       = mysqli_real_escape_string($db->conn, $mobile);
        $plan         = mysqli_real_escape_string($db->conn, $plan);
        $os           = mysqli_real_escape_string($db->conn, $os);
        $action       = mysqli_real_escape_string($db->conn, $action);
        // $specification = $cpu . ", " . $ram . ", " . $storage . ", " . $os . ", " . $others;    
        if(isset($empId) && $empId != '') {
            $sql = "SELECT * FROM employee_tbl WHERE id='$empId' AND empStatus=1";
            $result = mysqli_query($db->conn, $sql);
            if($result) {
                while($row = mysqli_fetch_array($result)) {
                    $empName = $row['name'];
                }
                if($lastused == '') {
                    $lastused = $empName;
                }
            }
        }
        // further logic; clear reason upon accounting to other employee

        // $query = "INSERT INTO assets_tbl (assettype, assettag, model, serial, supplier, empId, lastused, status, datepurchased, cost, repair_cost, remarks, datedeployed, cpu, memory, storage, dimes, mobile, plan, os)
        //                             VALUES ('$type','$tag','$mdl','$srl','$supplier','$empId','$lastused','$status','$dtprchs', '$cost', '$repair_cost','$remarks','$datedeployed','$cpu','$ram','$storage','$dimes','$mobile','$plan','$os')";
       
        // $result = mysqli_query($db->conn, $query);
        $query = $db->conn->prepare("INSERT INTO assets_tbl (assettype, assettag, model, serial, supplier, empId, lastused, status, datepurchased, cost, repair_cost, remarks, datedeployed, cpu, memory, storage, dimes, mobile, plan, os) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("sssssisssiisssssssss", $type, $tag, $mdl, $srl, $supplier, $empId, $lastused, $status, $dtprchs, $cost, $repair_cost, $remarks, $datedeployed, $cpu, $ram, $storage, $dimes, $mobile, $plan, $os);
        $result = $query->execute();

        if ($result) {
            $actionMessage = '';
            switch ($action) {
                case 'recordLaptop':
                    $actionMessage = "Added Laptop record: $tag";
                    break;
                case 'recordDesktop':
                    $actionMessage = "Added Desktop record: $tag";
                    break;
                case 'recordMonitor':
                    $actionMessage = "Added Monitor record: $tag";
                    break;
                case 'recordPrinter':
                    $actionMessage = "Added Printer record: $tag";
                    break;
                case 'recordUPS':
                    $actionMessage = "Added UPS record: $tag";
                    break;
                case 'recordMobile':
                    $actionMessage = "Added Phone record: $tag";
                    break;
                case 'recordSIM':
                    $actionMessage = "Added SIM record: $tag";
                    break;
                default:
                    $actionMessage = "Added asset record: $tag";
                    return 8;
            }
        
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date) VALUES('', '$sess_name', '$actionMessage', NOW())");

            return array_search($action, ['recordLaptop', 'recordDesktop', 'recordMonitor', 'recordPrinter', 'recordUPS', 'recordMobile', 'recordSIM']) + 1;
        } else {
            return 100; // Store Failed
        }
        
    }

    // function getAllData() {
    //     global $db;

    //     $query = "SELECT * FROM assets_tbl WHERE status!='Archive'";
    //     $res = mysqli_query($db->conn, $query);

    //     return $res;

    //     $db->conn->close();
    // }

    function getAssets($category) {
        global $db;
        // $sql = "SELECT * FROM category_tbl WHERE status='1'";
        // $res = mysqli_query($db->conn, $sql);

        // return $res;
        global $db;
        $sql = "SELECT * FROM category_tbl WHERE";
    
        switch ($category) {
            case 'recordLaptop':
                $sql .= " assetType='Laptop'";
                break;
            case 'recordDesktop':
                $sql .= " assetType='Desktop'";
                break;
            case 'recordMonitor':
                $sql .= " assetType='Monitor'";
                break;
            case 'recordPrinter':
                $sql .= " assetType='Printer'";
                break;
            case 'recordMobile':
                $sql .= " assetType='Mobile'";
                break;
            case 'recordSim':
                $sql .= " assetType='SIM'";
                break;
        }
    
        $result = $db->conn->query($sql);
        return $result;
    }

    // function searchDataPagination() {
    //     global $db;
    //     global $res;
        
    //     if(isset($_POST['search']) && $_POST['search'] != "") {
    //         $search = $_POST['search'];
    //         $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assigned LIKE '$search%' OR assigned LIKE '%$search' OR assigned LIKE '%$search%' OR department LIKE '%$search%'
    //         OR assettype LIKE '%$search%' OR status LIKE '%$search%' OR location LIKE '%$search%'
    //         OR assettag LIKE '%$search%' OR model LIKE '%$search%' OR CPU LIKE '%$search%' OR MEMORY LIKE '%$search%' OR STORAGE LIKE '%$search%'
    //          OR remarks LIKE '%$search%' OR Others LIKE '%$search%')";
    //         $res = mysqli_query($db->conn, $sql);
        
    //         return $res;
    //     }
    

    //     $db->conn->close();
    // }

    // function searchHistory() {
    //     global $db;

    //     if(isset($_POST['search'])) {
    //         $search = $_POST['search'];
    //         $sql = "SELECT * FROM history_tbl WHERE name LIKE '%$search%' OR action LIKE '%$search%' OR date LIKE '%$search%' ";
    //         $res = mysqli_query($db->conn, $sql);
        
    //         return $res;
    //     } else {
    //         $sql = "SELECT * FROM history_tbl";
    //         $res = mysqli_query($db->conn, $sql);

    //         return $res;
    //     }
    // }

    function getHistory() {
        global $db;

        $sql = "SELECT * FROM history_tbl";
        $res = $db->conn->query($sql);

        return $res;
    }

    public function checkAssetCount($assettype) {
        global $db;
      
        // Get the selected asset type
        $selectedAssetType = mysqli_real_escape_string($db->conn, $assettype);
    
        // Check if the asset tag already exists in the database
        $sql = "SELECT assettag FROM assets_tbl WHERE assettype = '$selectedAssetType' AND status != 'Archive'";
        $result = $db->conn->query($sql);
    
        if ($result->num_rows > 0) {
            // Asset tag exists, find the highest existing asset tag number and increment it
            $highestNumber = 0;
            while($row = $result->fetch_assoc()) {
                $parts = explode('-', $row['assettag']);
                $number = intval(end($parts));
                if ($number > $highestNumber) {
                    $highestNumber = $number;
                }
            }
            
            $nextAssetTag = $selectedAssetType . '-' . ($highestNumber + 1);
        } else {
            // Asset tag doesn't exist, use the asset tag as is
            $nextAssetTag = $selectedAssetType . '-1';
        }


        function removeVowelsAndToUpper($str) {
            // Remove vowels
            $strWithoutVowels = str_replace(['a', 'e', 'i', 'o', 'u', 'E', 'I'], '', $str);
            
            // Convert to uppercase
            $strToUpper = strtoupper($strWithoutVowels);
            
            return $strToUpper;
        }
        
        // Assign the next asset tag to the submitted form data
        $finalTag = removeVowelsAndToUpper($nextAssetTag);
        $_POST['asset-tag'] = $finalTag;

    }

    function referencesData() {
        global $db;

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assigned LIKE '%$search%' OR accountability_ref LIKE '%$search%' 
            OR turnover_ref LIKE '%$search%')";
            $res = mysqli_query($db->conn, $sql);
        
            return $res;
        } else {
            $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (turnover_ref !='' OR accountability_ref !='')";
            $res = mysqli_query($db->conn, $sql);

            return $res;
        }
        mysqli_free_result($res);

        $db->conn->close();
    }

    //Emp List
    function getEmpDiv() {
        global $db;
        $sql = "SELECT * FROM dept_tbl WHERE status=1";
        $res = mysqli_query($db->conn, $sql);

        return $res;
    }
    function getEmpLoc() {
        global $db;
        $sql = "SELECT * FROM loc_tbl WHERE status=1";
        $res = mysqli_query($db->conn, $sql);

        return $res;
    }

    function getEmp() {
        global $db;

        $sql = "SELECT * FROM employee_tbl ";
        $result = mysqli_query($db->conn, $sql);
       
        return $result;
    }
    function getSpecificEmp($id) {
        global $db;

        $sql = "SELECT * FROM employee_tbl WHERE id='$id'";
        $result = mysqli_query($db->conn, $sql);
       
        return $result;
    }

    // Asset List
    function searchAsset() {
        global $db;

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM category_tbl WHERE assetType LIKE '$search%' ORDER BY status DESC";
            $res = mysqli_query($db->conn, $sql);
        
            return $res;
        } else {
            $sql = "SELECT * FROM category_tbl ORDER BY status DESC";
            $res = mysqli_query($db->conn, $sql);

            return $res;
        }
        mysqli_free_result($res);

        $db->conn->close();
    }
    
    // Dept List
    function searchDept() {
        global $db;

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM dept_tbl WHERE name LIKE '$search%' ORDER BY status DESC";
            $res = mysqli_query($db->conn, $sql);
        
            return $res;
        } else {
            $sql = "SELECT * FROM dept_tbl ORDER BY status DESC";
            $res = mysqli_query($db->conn, $sql);

            return $res;
        }
        mysqli_free_result($res);

        $db->conn->close();
    }

    // Loc List
    function searchLoc() {
        global $db;

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM loc_tbl name LIKE '$search%' ORDER BY status DESC";
            $res = mysqli_query($db->conn, $sql);
        
            return $res;
        } else {
            $sql = "SELECT * FROM loc_tbl ORDER BY status DESC";
            $res = mysqli_query($db->conn, $sql);

            return $res;
        }
        mysqli_free_result($res);

        $db->conn->close();
    }

    // Getting reference table values
    function getReferenceTable() {
        global $db;
        // $sql = mysqli_query($db->conn, "SELECT * FROM reference_tbl ORDER BY name ASC, accountabilityStatus ASC, turnoverStatus");
        $sqlSelect = 
                        "SELECT a.id AS aId, a.empId, a.status AS status, a.assettype, a.assettag AS tag, a.model, a.remarks, 
                        e.id, e.name AS ename, e.division, e.location, 
                        r.id AS rid, r.assetId AS assetId, r.name AS rname, r.turnoverRef AS turnoverRef, r.accountabilityRef AS accountabilityRef, 
                        r.turnoverStatus AS turnoverStatus, r.accountabilityStatus AS accountabilityStatus, 
                        r.turnoverDate AS turnoverDate, r.accountabilityDate AS accountabilityDate, 
                        r.turnoverFile AS turnoverFile, r.accountabilityFile AS accountabilityFile, r.referenceStatus 
                        FROM assets_tbl AS a 
                        LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                        WHERE status!='Archive' ORDER BY referenceStatus DESC";
        $result = mysqli_query($db->conn, $sqlSelect);

        return $result;  
    }

    function specificationCondition($assetIds) {

        global $db;

        if(is_array($assetIds)) {
            $specs = [];
            foreach($assetIds as $assetId) {
                $sql =
                "SELECT a.*, r.* 
                -- a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
                -- e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef, r.turnoverRef 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                WHERE r.assetId = '$assetId'";
                $result = mysqli_query($db->conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    $assettype = $row['assettype'];
                    
                    $cpu = $row['cpu'];
                    $ram = $row['memory'];
                    $storage = $row['storage'];
                    $os = $row['os'];
                    $dimes = $row['dimes'];
                    $plan = $row['plan'];
                    $mobile = $row['mobile'];
                
                    switch($assettype) {
                        case 'Laptop':
                        case 'Desktop':
                            if(!empty($cpu) || !empty($ram) || !empty($storage) || !empty($os)) {
                                $specs =  $cpu .
                                        "<br>". $ram.
                                        "<br>". $storage.
                                        "<br>". $os;
                            } else {
                                $specs = "<i style='color:#FF6666;'>No details found.";
                            }
                            return $specs;
                            break;
        
                        case 'Monitor':
                        case 'Printer':
                        case 'UPS':
                        case 'AVR':
                            if(!empty($dimes)) {
                                // $specs = "Dimension: <i>". $dimes;
                                $specs = $dimes;
                            } else {
                                $specs = "<i style='color:#FF6646;'>No details found.";
                            }
                            return $specs;
                            break;
                        
                        case 'Mobile':
                            if(!empty($ram) || !empty($storage)) {
                                // $specs = "Ram: <i>". $ram .
                                //         "</i><br>Storage: <i>". $storage .
                                //         "</i><br>Plan: <i>". $plan;
                                $specs = $ram .
                                        "<br>" . $storage .
                                        "<br>" . $plan;
                            } else {
                                $specs = "<i style='color:#FF6646;'>No details found.";
                            }
                            return $specs;
                            break;
        
                        case 'SIM':
                            if(!empty($plan) || !empty($mobile)) {
                                // $specs = "Plan: <i>". $plan.
                                //         "</i><br>Mobile: <i>". $mobile;
                                $specs = $plan .
                                        "<br>" . $mobile;
                            } else {
                                $specs = "<i style='color:#FF6646;'>No details found.";
                            }
                            return $specs;
                            break;
        
                        default:
                            $specs =  $cpu .
                                "<br>". $ram.
                                "<br>". $storage.
                                "<br>". $os;
                            return $specs;
                            break;
                            
                    }
                }
            }
        } else {
            $sql =
            "SELECT * FROM assets_tbl WHERE id='$assetIds' AND status!='Archive'";
            $result = mysqli_query($db->conn, $sql);
    
            while($row = mysqli_fetch_assoc($result)) {
                $assettype = $row['assettype'];
    
                $cpu = $row['cpu'];
                $ram = $row['memory'];
                $storage = $row['storage'];
                $os = $row['os'];
                $dimes = $row['dimes'];
                $plan = $row['plan'];
                $mobile = $row['mobile'];
            
                switch($assettype) {
                    case 'Laptop':
                    case 'Desktop':
                        if(!empty($cpu) || !empty($ram) || !empty($storage) || !empty($os)) {
                            $specs =  $cpu .
                                        "<br>". $ram.
                                        "<br>". $storage.
                                        "<br>". $os;
                        } else {
                            $specs = "<i style='color:#FF6666;'>No details found.";
                            // $specs = "-
                            //         <br>-
                            //         <br>-
                            //         <br>-";
                        }
                        return $specs;
                        break;
    
                    case 'Monitor':
                    case 'Printer':
                    case 'UPS':
                    case 'AVR':
                        if(!empty($dimes)) {
                            $specs = $dimes;
                        } else {
                            $specs = "<i style='color:#FF6646;'>No details found.";
                        }
                        return $specs;
                        break;
                    
                    case 'Mobile':
                        if(!empty($ram) || !empty($storage)) {
                            $specs = $ram .
                                "<br>" . $storage .
                                "<br>" . $plan;
                        } else {
                            $specs = "<i style='color:#FF6646;'>No details found.";
                        }
                        return $specs;
                        break;
    
                    case 'SIM':
                        if(!empty($plan) || !empty($mobile)) {
                            $specs = $plan .
                                    "<br>" . $mobile;
                        } else {
                            $specs = "<i style='color:#FF6646;'>No details found.";
                        }
                        return $specs;
                        break;
    
                    default:
                        $specs =  $cpu .
                            "<br>". $ram.
                            "<br>". $storage.
                            "<br>". $os;
                        return $specs;
                        break;
                        
                }
            }
        }        
        return;
       
    }

    function ifEmptyReference($acctRef, $turnoverRef, $acctFile, $turnoverFile) {
        if(empty($acctRef)) { $acctRef = 'N/A'; return $acctRef; }
        if(empty($turnoverRef)) { $turnoverRef = 'N/A'; return $turnoverRef; }
        if(empty($acctFile)) { 
            $acctFile = 'N/A'; 
            return;  }
        if(empty($turnoverFile)) { $turnoverFile = 'N/A'; return $turnoverFile; }
    }

    function getAllSameCodes($id) {

        global $db;

        $query = "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
                e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef, r.turnoverRef 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE r.accountabilityRef = '$id' OR r.turnoverRef = '$id'";
                
        $result = mysqli_query($db->conn, $query);

        return $result;

        // $queryAll = "SELECT a.id as aId, a.assettype, a.serial, a.remarks, a.datedeployed, r.* 
        //             FROM assets_tbl AS a 
        //             LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
        //             WHERE r.accountabilityRef = '$accRef' OR r.turnoverRef = '$trnRef'";
        // return mysqli_query($db->conn, $queryAll);
    }
}
?>