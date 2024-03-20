<?php
require '../php/db_connection.php';

$select = new Select();
$operation = new Operations();

if(isset($_SESSION['id'])) {
    $session = $select->selectUserById($_SESSION['id']);
}

if(!empty($_POST['action']) && $_POST['action'] == 'saveAssetDetails') {
	$operation->saveAssetDetails();

	
	if(isset($_POST['save'])) {

		$result = $operation->saveAssetFinal($_POST['asset-type'], $_POST['asset-tag'], $_POST['model'], $_POST['serial'], $_POST['supplier'], $_POST['cost'], $_POST['repair-cost'], $_POST['dateprchs'], $_POST['status'], $_POST['remarks'], $_POST['processor'], $_POST['memory'], $_POST['storage'], $_POST['os'], $_POST['other'], $_POST['datedeployed'], $_POST['assigned'], $_POST['lastused'], $_POST['provider'], $_POST['mobile'], $_POST['plan']);
		

		if($result == 1) {
			echo "<script> alert('Data Stored successfully!'); </script>";
			header("Refresh:0; url=dashboard.php");

		} elseif($result == 100) {
			echo "<script> alert('Failed'); </script>";
		}                
	}
	
	?>
	<form method="POST" id="addAssetForm">
		<div class="title">Asset Details</div>
		<div class="asset-details">
			<div class="input-box">
				<span class="details" style="margin-bottom: 10px;">Assign To</span>
				<select name="assigned" id="assigned" class="assigned">
					<option value="">Please Select</option>
					<?php
							$results = new get_All_User();

							// $user = $results->selectAllUser();
							$user = $results->selectAllEmp();
							foreach($user as $row) {
					?>
					<option value="<?php echo $row['id']; ?>">
						<?php echo $row['name']; ?>
					</option>
					<?php
						}
						
					?>
				</select>
			</div>
			<div class="input-box">
				<span class="details">Turnover Date</span>
				<input type="date" name="turnover">
			</div>
			<div class="input-box">
				<span class="details" style="margin-bottom: 10px;">Last Used by:</span>
				<select name="lastused" id="lastused" class="assigned">
					<option value="">Please Select</option>
					<?php
							$results = new get_All_User();

							// $user = $results->selectAllUser();
							$user = $results->selectAllEmp();
							foreach($user as $row) {
					?>
					<option value="<?php echo $row['id']; ?>">
						<?php echo $row['name']; ?>
					</option>
					<?php
						}
					?>
				</select>
			</div>
		</div> 
		<div class="button">
			<input type="submit" value="Save" name="save"/>
			<input type="hidden" name="action" id="action" value="saveAssetFinal" />		
		</div>
	</form>
	<?php

}