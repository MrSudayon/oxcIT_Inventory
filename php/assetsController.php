<?php
// include_once '../php/db_connection.php';
$select = new Select();

if(isset($_SESSION['id'])) {
    $session = $select->selectUserById($_SESSION['id']);
}

class assetsController {

    public function edit($id) {
        global $db;
        $assetID = mysqli_real_escape_string($db->conn, $id);
        $assetQuery = "SELECT * FROM assets_tbl WHERE id='$assetID' AND status!='Archive'";
        $res = mysqli_query($db->conn, $assetQuery);
        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }
    public function update($input, $id) {
        global $db;
        global $select;

        $assetID = mysqli_real_escape_string($db->conn, $id);
        $assetType = $input['assettype'];
        $assetTag = $input['assettag'];
        $model = $input['model'];
        $serial = $input['serial'];
        $supplier = $input['supplier'];
        $dateprchs = $input['datepurchase'];
        $datedeployed = $input['datedeployed'];
        $status = $input['status'];
        $remarks = $input['remarks'];


        // Specification
        // SIM
        $provider = $input['provider'];
        $mobile = $input['mobile'];
        $plan = $input['plan'];

        // Laptop, Desktop, Cellphone
        $cpu = $input['cpu'];
        $ram = $input['ram'];
        $storage = $input['storage'];
        $os = $input['os'];
        $others = $input['others'];

        // Monitor, Keyboard, Mouse
        // $dimes = $input['dimension'];

        $assigned = $input['assigned'];
        $turnover = $input['turnover'];
        $lastused = $input['lastused'];

        // further logic; clear reason upon accounting to other employee
        // $reason = '';
        // if(isset($input['reason'])) {
        //     $reason = $input['reason'];
        // }
       
        if(!isset($assigned) || $assigned == '') {
            $dept = "";
            $location = "";
            
        } else {
            if($status=="") {
                $status = 'Deployed';
            }

            $sql = mysqli_query($db->conn,"SELECT * FROM employee_tbl WHERE name = '$assigned'");

            while($row = $sql->fetch_assoc()) {
                $dept = $row['division'];
                $location = $row['location'];
            } 

            if($lastused == '') {
                $lastused = $assigned;
            } else {
                $lastused = $input['lastused'];
            }
        }   

        

        $qry = "UPDATE assets_tbl SET department='$dept', assettype='$assetType', assettag='$assetTag', model='$model', serial='$serial', supplier='$supplier', datepurchased='$dateprchs', status='$status', location='$location', remarks='$remarks', CPU='$cpu', MEMORY='$ram', STORAGE='$storage', OS='$os', Others='$others', assigned='$assigned', lastused='$lastused', dateturnover='$turnover', datedeployed='$datedeployed' WHERE id='$assetID' AND status!='Archive' LIMIT 1";
        $result = $db->conn->query($qry);


        // Get current user for History record....
        $session = $select->selectUserById($_SESSION['id']);
        $name = $session['username'];

        $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $assetID");
            while($row = $tag->fetch_assoc()) {
                $assettag = $row['assettag'];
            }
        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                VALUES('', '$name', 'Updated item: $assettag, ID: $assetID from Assets Record' , NOW())");
            return true;
        } else {
            return false;
        }
    }

    public function assetTurnover($input, $id) {
        global $db;
        global $session;

        $assetID = mysqli_real_escape_string($db->conn, $id);
        $turnover = $input['turnover'];
        $lastused = $input['lastused'];
        $reason = $input['reason'];
        $ref_Code = $input['ref_code'];
        

        // get id of selected asset ($assetID)
        $sql = "SELECT * FROM assets_tbl WHERE id = $assetID AND status != 'Archive'";
        $res = mysqli_query($db->conn,$sql);
        while($row = $res->fetch_assoc()) {
            $assetName = $row['assettype'];
            $turnover_ref = $row['turnover_ref'];
            $assigned = $row['assigned'];
        }
        
        
        // validation of Turnover reference code
        if($ref_Code == $turnover_ref) {
            
            if($lastused != '') {
                $lastusedby = $assigned;
            } else {
                $lastusedby = $lastused;
            }

            // Change Asset data based on Reason of Turnover
            if ($reason == 'Resign') {
                $newStatus = 'To be deploy';
            } elseif ($reason == 'Defective') {
                $newStatus = 'Defective';
            } else {
                $newStatus = 'Outdated';
            }

            $db->conn->query("UPDATE assets_tbl SET assigned='', department='', location='', lastused='$lastusedby', dateturnover='$turnover', reason='$reason', status='$newStatus' WHERE id='$assetID' AND status!='Archive' LIMIT 1");
            
            $name = $session['username'];
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                VALUES('', '$name', 'Turnover asset: $assetName ID: $assetID' , NOW())");
            
            return 1; // Turnover success
           
        } else {
            return 100;
        }    
        
            
    }

    // Emp
    public function empEdit($id) {
        global $db;
        global $session;

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
        global $session;

        $empID = mysqli_real_escape_string($db->conn, $id);
        $empname = $input['name'];
        $division = $input['division'];
        $location = $input['location'];
        $status = $input['status'];
        
        // Get current user for History record....
        $name = $session['username'];

        // validation of Turnover reference code
        $qry = "UPDATE employee_tbl SET name='$empname', division='$division', location='$location', status='$status' WHERE id='$empID' LIMIT 1";
        $result = $db->conn->query($qry);

        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$name', 'Updated employee: $empname ID: $empID' , NOW())");

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
        global $session;

        $assetItemID = mysqli_real_escape_string($db->conn, $id);
        $assetname = $input['name'];
        $status = $input['status'];
        
        // Get current user for History record....
        $name = $session['username'];

        // validation of Turnover reference code
        $qry = "UPDATE category_tbl SET assetType='$assetname', status='$status' WHERE id='$assetItemID' LIMIT 1";
        $result = $db->conn->query($qry);

        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$name', 'Updated asset item: $assetname ID: $assetItemID' , NOW())");

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


    // Reference Update
    public function editReference($id) {
        global $db;

        $refId = mysqli_real_escape_string($db->conn, $id);
        $sql = "SELECT * FROM reference_tbl WHERE assetId='$refId'";
        $res = mysqli_query($db->conn, $sql);
        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }
    public function updateReference($input, $id) {
        global $db;
        global $session;

        $refName = $input['name'];
        $acctStatus = $input['acctStatus'];
        $acctDate = $input['acctDate'];
        $trnStatus = $input['trnStatus'];
        $trnDate = $input['trnDate'];
        $acctFile = $input['acctFile'];
        $trnFile = $input['trnFile'];
     
        $refId = mysqli_real_escape_string($db->conn, $id);
        

        $sql = "UPDATE reference_tbl SET acctStatus = '$acctStatus', acctFile='$acctFile', acctDate = '$acctDate', trnStatus = '$trnStatus', trnFile = '$trnFile', trnDate = '$trnDate' WHERE id = '$refId'";
        $result = $db->conn->query($sql);

        $name = $session['username'];
        if($result) {
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$name', 'Updated reference ID: $refId. Name: $refName' , NOW())");

            return true;
        } else {
            return false;
        } 
    }
}

?>

