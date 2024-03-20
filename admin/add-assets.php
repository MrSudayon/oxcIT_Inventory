<?php
require '../php/db_connection.php';
// require '../classes/functions.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
    if($user['role'] == 'admin') {
        // $record = new Operations();

        // if(isset($_POST['save'])) {

        //     $result = $record->record_Data($_POST['asset-type'], $_POST['asset-tag'], $_POST['model'], $_POST['serial'], $_POST['supplier'], $_POST['cost'], $_POST['repair-cost'], $_POST['dateprchs'], $_POST['status'], $_POST['remarks'], $_POST['processor'], $_POST['memory'], $_POST['storage'], $_POST['os'], $_POST['other'], $_POST['datedeployed'], $_POST['assigned'], $_POST['lastused'], $_POST['provider'], $_POST['mobile'], $_POST['plan']);
            

        //     if($result == 1) {
        //         echo "<script> alert('Data Stored successfully!'); </script>";
        //         header("Refresh:0; url=dashboard.php");

        //     } elseif($result == 100) {
        //         echo "<script> alert('Failed'); </script>";
        //     }                
        // }

    } else {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../php/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/modal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Add Assets</title>
</head>
<body>
<?php include '../inc/header.php'; ?>

    <div class="container">
        <div class="add-form">
    
            <a href="../admin/dashboard.php" class="return">Back</a>
            <?php include 'addAssetModal.php'; ?>

        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>

</body>
</html>