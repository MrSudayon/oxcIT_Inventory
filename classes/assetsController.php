<?php

require_once ('../php/db_connection.php');

$db = new Connection;

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
}

?>