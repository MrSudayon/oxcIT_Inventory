<?php
require '../php/db_connection.php';

if(isset($_POST['turnover-asset'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);
    $input = [
        'turnover' => mysqli_real_escape_string($db->conn,$_POST['turnover']),
        'lastused' => mysqli_real_escape_string($db->conn,$_POST['lastused']),
        'reason' => mysqli_real_escape_string($db->conn,$_POST['reason']),
        'ref_code' => mysqli_real_escape_string($db->conn,$_POST['ref_code']),
    ];
    $asset = new assetsController;
    $result = $asset->assetTurnover($input, $id);

    if($result) {
        echo "alert('Updated Successfully')";
        header("Location: dashboard.php");
        exit(0);
    } else {
        echo "alert('Update Error')";
        // $_SESSION['message'] = "Update Error";
        header("Location: turnoverUpd.php");
        exit(0);
    }
}

?>