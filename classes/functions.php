<?php

require_once ('../php/db_connection.php');

$db = new Connection();
$results;
class Operations {
    
    public function Store_Data() {
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
    function record_Data($type, $tag, $mdl, $srl, $spplr, $dtprchs, $stts, $rmrks, $cpu, $ram, $storage, $os, $others, $datedeployed, $assigned, $dept, $location) {
        global $db;
        // $specification = $cpu . ", " . $ram . ", " . $storage . ", " . $os . ", " . $others;  


        $query = "INSERT INTO assets_tbl (id, department, assettype, assettag, model, serial, supplier, CPU, MEMORY, STORAGE, OS, Others, assigned, status, location, datepurchased, remarks, datedeployed, dateturnover)
                                VALUES ('','$dept','$type','$tag','$mdl','$srl','$spplr','$cpu','$ram','$storage','$os','$others','$assigned','$stts','$location','$dtprchs','$rmrks','$datedeployed','')";

        $result = mysqli_query($db->conn, $query);

        if($result) { 
            return 1; //Success
        } else {
            return 10; //Store Failed
        }
    }

    function getAllData() {
        global $db;

        $query = "SELECT * FROM assets_tbl WHERE status!='Archive'";
        $res = mysqli_query($db->conn, $query);

        return $res;
    }

    function getAssets() {
        global $db;
        $sql = "SELECT * FROM category_tbl WHERE status='1'";
        $res = mysqli_query($db->conn, $sql);

        return $res;
    }
    function searchData() {
        global $db;
        global $results;

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assigned LIKE '$search' OR department LIKE '%$search%'
            OR assettype LIKE '%$search%' OR status LIKE '%$search%' OR location LIKE '%$search%'
            OR assettag LIKE '%$search%' OR model LIKE '%$search%' OR remarks LIKE '%$search%' OR Others LIKE '%$search%')";
            $res = mysqli_query($db->conn, $sql);
            
            $results = $res;

            return $res;
        } else {
            $sql = "SELECT * FROM assets_tbl WHERE status!='Archive'";
            $res = mysqli_query($db->conn, $sql);

            return $res;
        }
        
    }
}



?>