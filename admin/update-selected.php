<?php
require '../php/db_connection.php';
$asset = new assetsController;

if(isset($_POST['update-asset'])) {
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
    $result = $asset->update($input, $id);

    if($result) {
        echo "alert('Updated Successfully')";
        header("Location: ../admin/dashboard.php");
        exit(0);
    } else {
        echo "alert('Update Error')";
        $_SESSION['message'] = "Update Error";
        header("Location: ../update/assetUpd.php");
        exit(0);
    }
}

if(isset($_POST['turnover-asset'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);
    $input = [
        'turnover' => mysqli_real_escape_string($db->conn,$_POST['turnover']),
        'lastused' => mysqli_real_escape_string($db->conn,$_POST['lastused']),
        'reason' => mysqli_real_escape_string($db->conn,$_POST['reason']),
        'ref_code' => mysqli_real_escape_string($db->conn,$_POST['ref_code']),
    ];
    $result = $asset->assetTurnover($input, $id);

    if($result) {
        echo "alert('Updated Successfully')";
        header("Location: dashboard.php");
        exit(0);
    } else {
        echo "alert('Update Error')";
        $_SESSION['message'] = "Update Error";
        header("Location: turnoverUpd.php");
        exit(0);
    }
}

// Update employee func
if(isset($_POST['updateEmp'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['empID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'division' => mysqli_real_escape_string($db->conn,$_POST['division']),
        'location' => mysqli_real_escape_string($db->conn,$_POST['location']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $asset->empUpdate($input, $id);

    if($result) {
        echo "alert('Updated Successfully')";
        header("Location: emp_List.php");
        exit(0);
    } else {
        echo "alert('Update Error')";
        $_SESSION['message'] = "Update Error";
        header("Location: emp_List.php");
        exit(0);
    }
}

// Update Asset item
if(isset($_POST['updateAssetItem'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetItemID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $asset->assetItemUpdate($input, $id);

    if($result) {
        echo "alert('Updated Successfully')";
        header("Location: asset_List.php");
        exit(0);
    } else {
        echo "alert('Update Error')";
        $_SESSION['message'] = "Update Error";
        header("Location: asset_List.php");
        exit(0);
    }
}

?>