<?php
require '../php/db_connection.php';

$select = new Select();
$operation = new Operations();
global $db;

if(isset($_SESSION['id'])) {
    $session = $select->selectUserById($_SESSION['id']);
}

if (!empty($_POST['action']) && $_POST['action'] == 'saveAssetDetails') {
    $countRes = $record->checkAssetCount($_POST['asset-type']);
    $result = $operation->saveAssetDetails($_POST);
    echo json_encode($result); // You can return the assetId if needed
}

// if (!empty($_POST['action']) && $_POST['action'] == 'saveAssetFinal') {
//     $result = $operation->saveAssetFinal($_POST);
//     echo json_encode($result); // Return success or error message
// }


    // Check if the form was submitted from the first step
    if (!empty($_POST['action']) && $_POST['action'] == 'saveAssetDetails') {


        $type = $_POST['asset-type'];
        $tag =  $countRes;
        $dateprchs = $_POST['dateprchs'];
        $model = $_POST['model'];
        $serial = $_POST['serial'];
        $supplier = $_POST['supplier'];
        
        // Insert into assets_tbl   
        $query = "INSERT INTO assets_tbl (assettype, assettag, model, serial, supplier, datepurchased) 
                VALUES ('$type','$tag','$model','$serial','$supplier','$dateprchs')";
        // $result = mysqli_query($db->conn, $query);
        // $last_id = mysqli_insert_id($db->conn);
        if ($db->conn->query($query) === TRUE) {
            // Retrieve the ID of the newly inserted asset
            $assetId = mysqli_insert_id($db->conn);

            // Return the asset ID as JSON response
            return json_encode(['assetId' => $assetId]);
        } else {
            return json_encode(['error' => 'Failed to store asset data']);
        }
    }

    // Check if the form was submitted from the second step
    if (!empty($_POST['action']) && $_POST['action'] == 'saveAssetFinal') {

        $assetId = $_POST['assetId'];
        $cpu = $_POST['processor'];
        $memory = $_POST['memory'];
        $storage = $_POST['storage'];
        $os = $_POST['os'];
    
        // Insert into specs_tbl
        $query = "INSERT INTO specs_tbl (assetId, cpu, memory, storage, os, status) 
                VALUES ('$assetId','$cpu','$memory','$storage','$os', 1)";
        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => 'Data stored successfully']);
        } else {
            echo json_encode(['error' => 'Failed to store specification data']);
        }
    }



// if(!empty($_POST['action']) && $_POST['action'] == 'saveAssetDetails') {
// 	$countRes = $operation->checkAssetCount();
// 	$assetDetails = $operation->saveAssetDetails();
// }
// if(!empty($_POST['action']) && $_POST['action'] == 'saveAssetFinal') {

// 	$result = $operation->saveAssetFinal(); //$_POST['processor'], $_POST['memory'], $_POST['storage'], $_POST['os'], $_POST['other'], $_POST['datedeployed'], $_POST['provider'], $_POST['mobile'], $_POST['plan']
	
// 	if($result == 1) {
// 		echo "<script> alert('Data Stored successfully!'); </script>";
// 		header("Refresh:0; url=dashboard.php");

// 	} elseif($result == 100) {
// 		echo "<script> alert('Failed'); </script>";
// 	}                
// }

