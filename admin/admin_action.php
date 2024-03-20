<?php
require '../php/db_connection.php';

$select = new Select();
$operation = new Operations();
if(isset($_SESSION['id'])) {
    $session = $select->selectUserById($_SESSION['id']);
}

if (!empty($_POST['action']) && $_POST['action'] == 'saveAssetDetails') {
    $result = $operation->saveAssetDetails($_POST);
    echo json_encode($result); // You can return the assetId if needed
}

if (!empty($_POST['action']) && $_POST['action'] == 'saveAssetFinal') {
    $result = $operation->saveAssetFinal($_POST);
    echo json_encode($result); // Return success or error message
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

