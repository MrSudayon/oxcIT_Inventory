<?php

// include_once '../php/db_connection.php';

$db = new Connection();
$select = new Select();

if(isset($_SESSION['id'])) {
    $session = $select->selectUserById($_SESSION['id']);
}
class Operations {
    public $id;
    public $select;
    public $db;
    // function record_Data($type, $tag, $mdl, $srl, $spplr, $cost, $repair_cost, $dtprchs, $stts, $rmrks, $cpu, $ram, $storage, $os, $datedeployed, $empId, $lastused, $provider, $mobile, $plan) {
    //     global $db;
    //     global $session;
        
    //     $dept = "";
    //     $location = "";
    //     // $specification = $cpu . ", " . $ram . ", " . $storage . ", " . $os . ", " . $others;  
    //     $name = $session['username'];

    //     if(!isset($empId) || $empId == '') {
    //         $dept = "";
    //         $location = "";
            
    //     } else {
    //         if($stts=="") {
    //             $stts = 'Deployed';
    //         }

    //         $sql = mysqli_query($db->conn,"SELECT * FROM employee_tbl WHERE id = '$empId'");

    //         while($row = $sql->fetch_assoc()) {
    //             $assigned = $row['name'];
    //         } 
    //         $lastused = $assigned;
    //     }          
        
        
    //     // $query = "INSERT INTO assets_tbl (id, department, assettype, assettag, model, serial, supplier, CPU, MEMORY, STORAGE, OS, Others, empId, assigned, lastused, status, location, datepurchased, cost, repair_cost, remarks, datedeployed)
    //     //                         VALUES ('','$dept','$type','$tag','$mdl','$srl','$spplr','$cpu','$ram','$storage','$os','$others','$empId','$assigned','$lastused','$stts','$location','$dtprchs', '$cost', '$repair_cost','$rmrks','$datedeployed')";
    //     // $result = mysqli_query($db->conn, $query);
    //     $query = "INSERT INTO assets_tbl (id, assettype, assettag, model, serial, supplier, empId, lastused, status, datepurchased, cost, repair_cost, remarks, datedeployed)
    //                                 VALUES ('','$type','$tag','$mdl','$srl','$spplr','$empId','$lastused','$stts','$dtprchs', '$cost', '$repair_cost','$rmrks','$datedeployed')";
       
    //     $result = mysqli_query($db->conn, $query);

    //     if($result) { 
    //         mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
    //                             VALUES('', '$name', 'Added a new asset: $tag' , NOW())");
    //         return 1; //Success
    //     } else {
    //         return 10; //Store Failed
    //     }
    // }
    function saveAssetDetails() {
        global $db;
    
        // Extract fields from POST data
        $type = $_POST['asset-type'];
        $tag = $_POST['asset-tag'];
        $dateprchs = $_POST['dateprchs'];
        $model = $_POST['model'];
        $serial = $_POST['serial'];
        $supplier = $_POST['supplier'];
    
        // Insert into assets_tbl
        $query = "INSERT INTO assets_tbl (assettype, assettag, model, serial, supplier, datepurchased) VALUES ('$type','$tag','$model','$serial','$supplier','$dateprchs')";
        $result = mysqli_query($db->conn, $query);
        $last_id = mysqli_insert_id($db->conn);
    
        return array('result' => $result, 'last_id' => $last_id);
        // return $result;
    }
    
    function saveAssetFinal() {
        global $db;
    
        // Extract fields from POST data
        $assetId = $_POST['assetId'];
        $cpu = $_POST['processor'];
        $memory = $_POST['memory'];
        $storage = $_POST['storage'];
        $os = $_POST['os'];
    
        // Insert into specs_tbl
        $query = "INSERT INTO specs_tbl (assetId, cpu, memory, storage, os) VALUES ('$assetId','$cpu','$memory','$storage','$os')";
        $result = mysqli_query($db->conn, $query);
    
        return $result;
    }
    function getAllData() {
        global $db;

        $query = "SELECT * FROM assets_tbl WHERE status!='Archive'";
        $res = mysqli_query($db->conn, $query);

        return $res;

        mysqli_free_result($res);
        $db->conn->close();

    }

    function getAssets() {
        global $db;
        $sql = "SELECT * FROM category_tbl WHERE status='1'";
        $res = mysqli_query($db->conn, $sql);

        return $res;
    }

    function searchDataPagination() {
        global $db;
        global $res;
        
        if(isset($_POST['search']) && $_POST['search'] != "") {
            $search = $_POST['search'];
            $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assigned LIKE '$search%' OR assigned LIKE '%$search' OR assigned LIKE '%$search%' OR department LIKE '%$search%'
            OR assettype LIKE '%$search%' OR status LIKE '%$search%' OR location LIKE '%$search%'
            OR assettag LIKE '%$search%' OR model LIKE '%$search%' OR CPU LIKE '%$search%' OR MEMORY LIKE '%$search%' OR STORAGE LIKE '%$search%'
             OR remarks LIKE '%$search%' OR Others LIKE '%$search%')";
            $res = mysqli_query($db->conn, $sql);
        
            return $res;
        }
    

        $db->conn->close();
    }

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

    function checkAssetCount() {
        global $db;
      
        // $sql = "SELECT COUNT(*) FROM assets_tbl WHERE assettype='$assettype'";
        // $count = mysqli_query($db->conn, $sql);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the selected asset type
            $selectedAssetType = $_POST['asset-type'];
        
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

    }
    function referencesData() {
        global $db;
        global $res;

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
        global $res;

        $sql = "SELECT * FROM employee_tbl ";
       
        return $sql;

    }

    // Asset List
    function searchAsset() {
        global $db;
        global $res;

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
        global $res;

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
        global $res;

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
                        WHERE status!='Archive'";
        $sql = mysqli_query($db->conn, $sqlSelect);

        return $sql;  
    }
   
}
?>