<?php
// include_once '../php/db_connection.php';
$select = new Select();

class assetsController {
    public function edit($id) {
        global $db;
        $assetID = mysqli_real_escape_string($db->conn, $id);
        $assetQuery = "SELECT * FROM assets_tbl WHERE id='$assetID' AND status!='Archive'";
        $res = mysqli_query($db->conn, $assetQuery);
        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        }else{
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
        $status = $input['status'];
        $remarks = $input['remarks'];
        $cpu = $input['cpu'];
        $ram = $input['ram'];
        $storage = $input['storage'];
        $os = $input['os'];
        $others = $input['others'];
        $assigned = $input['assigned'];
        $department = $input['department'];
        $location = $input['location'];

        $qry = "UPDATE assets_tbl SET assettype='$assetType', assettag='$assetTag', model='$model', serial='$serial', supplier='$supplier', datepurchased='$dateprchs', status='$status', remarks='$remarks', CPU='$cpu', MEMORY='$ram', STORAGE='$storage', OS='$os', Others='$others', assigned='$assigned', department='$department', location='$location' WHERE id='$assetID' LIMIT 1";
        $result = $db->conn->query($qry);


        $session = $select->selectUserById($_SESSION['id']);
        $name = $session['username'];

        $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $assetID");
            while($row = $tag->fetch_assoc()) {
                $assettag = $row['assettag'];
            }
        if($result) {

            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                VALUES('', '$name', 'Updated the Tag: $assettag from Assets Record' , NOW())");
            return true;
        } else {
            return false;
        }
    }
}

?>

