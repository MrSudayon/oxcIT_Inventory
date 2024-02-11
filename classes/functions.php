<?php 

require_once ('../php/db_connection.php');

$db = new Connection();

class Operations {
    
    public function Store_Data() {
        global $db;
        // if(isset($_POST['save'])) {
        //     //asset details
        //     $assettype = $db->check($_POST['asset-type']);
        //     $assettag = $db->check($_POST['asset-tag']);
        //     $model = $db->check($_POST['model']);
        //     $serial = $db->check($_POST['serial']);
        //     $supplier = $db->check($_POST['supplier']);
        //     $datepurch = $db->check($_POST['asset-type']);
        //     $status = $db->check($_POST['status']);
        //     $remarks = $db->check($_POST['remarks']);

        //     if($this->record_Data($assettype, $assettag, $model, $serial, $supplier, $datepurch, $status, $remarks)) {
        //        
        //     } else {
        //         
        //     }
        // }
    }
    function record_Data($type, $tag, $mdl, $srl, $spplr, $dtprchs, $stts, $rmrks) {
        global $db;
        $query = "INSERT INTO assets_tbl (usersID, department, assettype, assettag, model, serial, supplier, specification, status, datepurchased, remarks, datedeployed, dateturnover)
                VALUES ('1','','$type','$tag','$mdl','$srl','$spplr','','$stts','$dtprchs','$rmrks','','')";

        $result = mysqli_query($db->conn, $query);

        if($result) { 
            return 1; //Success
        } else {
            return 10; //Store Failed
        }

    }
}

?>