<?php
require '../php/db_connection.php';
// require '../classes/functions.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
    if($user['role'] == 'admin') {
        $record = new Operations();

        if(isset($_POST['save'])) {
            $countRes = $record->checkAssetCount($_POST['asset-type']);
           
            $result = $record->record_Data($_POST['asset-type'], $_POST['asset-tag'], $_POST['model'], $_POST['serial'], $_POST['supplier'], $_POST['dateprchs'], $_POST['status'], $_POST['remarks'], $_POST['processor'], $_POST['memory'], $_POST['storage'], $_POST['os'], $_POST['other'], $_POST['datedeployed'], $_POST['assigned'], $_POST['turnover'], $_POST['lastused']);

            if($result == 1) {
                echo "<script> alert('Data Stored successfully!'); </script>";
                header("Refresh:0; url=add-assets.php");

            } elseif($result == 100) {
                echo "<script> alert('Failed'); </script>";
            }                
        }

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
    <link rel="stylesheet" href="../css/styles.css">
    <title>Add Assets</title>
</head>
<body>
<?php include '../inc/header.php'; ?>

    <div class="container">
        <div class="add-form">
            <form action="" method="POST">
                <div class="title">Asset Details</div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">Asset Type</span>                            
                        <select name="asset-type" id="Type" onChange="displaySelectedValue()" required>
                            <option value="">Please Select</option>
                            <?php
                                $category = new Operations;
                                $assettype = $category->getAssets();

                                foreach($assettype as $assets) {
                            ?>
                                <option value="<?=$assets['assetType']?>"><?php echo $assets['assetType']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                        
                    <div class="input-box">
                        <span class="details">Asset Tag</span>
                        <div class="asset-tag" id="tag" style="background-color: #ccc;"></div>
                        <input type="text" name="asset-tag" id="asset-tag" hidden>
                        <!-- <input type="text" name="asset-tag" placeholder="Asset Tag" id="Tag" > -->
                    </div>
                    <div class="input-box">
                        <span class="details">Model</span>
                        <input type="text" name="model" placeholder="Model" id="" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Serial no.</span>
                        <input type="text" name="serial" placeholder="Serial Number" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Supplier</span>
                        <input type="text" name="supplier" placeholder="Supplier" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Date Purchased</span>
                        <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Status</span>
                        <select name="status" id="status">
                            <option value="Deployed">Deployed</option>
                            <option value="To be Deploy">To be Deploy</option>
                            <option value="Maintenance">For Repair</option>

                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Remarks</span>
                        <input type="text" name="remarks" placeholder="Remarks" id="">
                    </div>
                </div>
                <div class="title">Specification</div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">Processor</span>
                        <input type="text" name="processor" placeholder="Processor" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Memory</span>
                        <input type="text" name="memory" placeholder="Memory" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Storage</span>
                        <input type="text" name="storage" placeholder="Storage" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Operating System</span>
                        <input type="text" name="os" placeholder="Operating System" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Others</span>
                        <input type="text" name="other" placeholder="Others" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Date Deployed</span>
                        <input type="date" name="datedeployed" placeholder="Date Deployed" value="" id="datedeployed">
                    </div>
                </div>
                <div class="title"></div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">Assigned To</span>
                        <select name="assigned" id="assigned" class="assigned">
                            <option value="">Please Select</option>
                            <?php
                                    $results = new get_All_User();

                                    // $user = $results->selectAllUser();
                                    $user = $results->selectAllEmp();
                                    foreach($user as $row) {
                            ?>
                            <option value="<?php echo $row['name']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                            <?php
                                }
                                
                            ?>
                        </select>
                    </div>
                    <!-- <div class="input-box">
                        <span class="details">Turnover Date</span>
                        <input type="date" name="turnover">
                    </div> -->
                    <div class="input-box">
                        <span class="details">Last Used by:</span>
                        <input type="text" name="lastused" style="background-color: #ccc;" readonly>
                    </div>
                    <!-- <div class="input-box">
                        <span class="details">Division</span>
                        <div class="division" id="division"></div>
                        <input type="text" name="department" placeholder="Division" id="1" style="background-color: #ccc;" readonly>
                    </div>
                    <div class="input-box">
                        <span class="details">Location</span>
                        <input type="text" name="location" placeholder="Location" id="location" style="background-color: #ccc;" readonly>
                    </div> -->
                </div>
                <div class="button">
                    <input type="submit" onclick="passValue()" value="Save" name="save"/>
                </div>
            </form>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
</html>