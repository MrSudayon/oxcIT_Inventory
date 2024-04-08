<?php
require '../php/db_connection.php';


if(isset($_POST['update-asset']))
{
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);
    $input = [
        'assettype' => mysqli_real_escape_string($db->conn,$_POST['asset-type']),
        'assettag' => mysqli_real_escape_string($db->conn,$_POST['asset-tag']),
        'model' => mysqli_real_escape_string($db->conn,$_POST['model']),
        'serial' => mysqli_real_escape_string($db->conn,$_POST['serial']),
        'supplier' => mysqli_real_escape_string($db->conn,$_POST['supplier']),
        'datepurchase' => mysqli_real_escape_string($db->conn,$_POST['dateprchs']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
        'remarks' => mysqli_real_escape_string($db->conn,$_POST['remarks']),

        'cpu' => mysqli_real_escape_string($db->conn,$_POST['processor']),
        'ram' => mysqli_real_escape_string($db->conn,$_POST['memory']),
        'storage' => mysqli_real_escape_string($db->conn,$_POST['storage']),
        'os' => mysqli_real_escape_string($db->conn,$_POST['os']),
        'others' => mysqli_real_escape_string($db->conn,$_POST['other']),
        'datedeployed' => mysqli_real_escape_string($db->conn,$_POST['datetdeployed']),

        'assigned' => mysqli_real_escape_string($db->conn,$_POST['assigned']),
        'turnover' => mysqli_real_escape_string($db->conn,$_POST['turnover']),
        'lastused' => mysqli_real_escape_string($db->conn,$_POST['lastused']),
    ];
    $asset = new assetsController;
    $result = $asset->update($input, $id);

    if($result) {
        echo "alert('Updated Successfully')";
        header("Location: ../admin/dashboard.php");
        exit(0);
    } else {
        echo "alert('Update Error')";
        $_SESSION['message'] = "Update Error";
        header("Location: ../admin/dashboard.php");
        exit(0);
    }
}

?>