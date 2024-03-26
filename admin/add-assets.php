<?php 
include '../inc/auth.php';

if(isset($_GET['id'])) {
    $id = $_GET['id']; 
} else {
    $id = 'default';
}

if(isset($_POST['save'])) {
    $operation->checkAssetCount($_POST['asset-type']);
    
    $result = $operation->record_Data($_POST['asset-type'], $_POST['asset-tag'], $_POST['model'], $_POST['serial'], $_POST['supplier'], 
    $_POST['assigned'], $_POST['lastused'], $_POST['status'], $_POST['dateprchs'], $_POST['cost'], $_POST['repair-cost'], $_POST['remarks'], $_POST['datedeployed'], 
    $_POST['processor'], $_POST['memory'], $_POST['storage'], $_POST['dimes'], $_POST['mobile'], $_POST['plan'], $_POST['os'], $_POST['action']);
    

    if ($result >= 1 && $result <= 7) {
        $urls = [
            1 => "../assetLists/Laptop.php",
            2 => "../assetLists/Desktop.php",
            3 => "../assetLists/Monitor.php",
            4 => "../assetLists/Printer.php",
            5 => "../assetLists/UPS.php",
            6 => "../assetLists/Mobile.php",
            7 => "../assetLists/SIM.php",
        ];
    
        $url = $urls[$result];
    
        echo "<script> alert('Data Stored successfully!'); </script>";
        header("Refresh:0; url= $url");
    } elseif ($result == 8) {
        echo "<script> alert('Data Stored successfully!'); </script>";
        header("Refresh:0; url= dashboard.php");
    } elseif ($result == 100) {
        echo "<script> alert('Failed'); </script>";
    }
                 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/formStyles.css">
    <title>Add Assets</title>
</head>
<body>
<?php include '../inc/header.php'; ?>

    <div class="container">
        <div class="add-form">
            <?php 
                if($id == 'recordLaptop') { 
                    $url = "../assetLists/Laptop.php";
                } elseif($id == 'recordLaptop') {
                    $url = "../assetLists/Laptop.php";
                } elseif($id == 'recordLaptop') {
                    $url = "../assetLists/Laptop.php";
                } elseif($id == 'recordLaptop') {
                    $url = "../assetLists/Laptop.php";
                } else {
                    $url = "../admin/dashboard.php"; // Change name to 'All Assets'
                }

                echo "<a href=\"$url\" class=\"return\">Back</a>";
            ?>

            <!-- <button onclick="history.back()" class="return">Go Back</button> -->
                <form action="" method="POST">
                    <div class="title">Asset Details</div>
                    <div class="asset-details">

                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Asset Type</span>                            
                            <select name="asset-type" id="Type" onChange="changetextbox();displaySelectedValue();" required>
                                <option value='' hidden selected disabled>Please Select</option>
                                <?php
                                    $assettype = $operation->getAssets($id);
                                    foreach($assettype as $assets) {
                                ?>
                                    <option value="<?=$assets['assetType']?>"><?php echo $assets['assetType']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                            
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Asset Tag</span>
                            <div class="asset-tag" id="tag" style="background-color: #ccc;"></div>
                            <input type="text" name="asset-tag" id="asset-tag" hidden>
                            <!-- <input type="text" name="asset-tag" placeholder="Asset Tag" id="Tag" > -->
                        </div>
                        <div class="input-box" id="model">
                            <span class="details">Model</span>
                            <input type="text" name="model" placeholder="Model" id="">
                        </div>
                        
                        <div class="input-box" id="serial">
                            <span class="details">Serial no.</span>
                            <input type="text" name="serial" placeholder="Serial Number" id="">
                        </div>
                        <div class="input-box" id="mobile" style="display: none;">
                            <span class="details">Mobile no.</span>
                            <input type="text" name="mobile" placeholder="Mobile no." id="">
                        </div>

                        <div class="input-box">
                            <span class="details">Supplier</span>
                            <input type="text" name="supplier" placeholder="Supplier" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Cost</span>
                            <input type="text" name="cost" placeholder="Item cost.." id="">
                        </div>
                        
                        <div class="input-box">
                            <span class="details">Date Purchased</span>
                            <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="status" id="status" onChange="changetextbox()" required>
                                <option value='' hidden selected disabled>Please select</option>
                                <option value="For repair">For repair</option>
                                <option value="Deployed">Deployed</option>
                                <option value="To be Deploy">To be deploy</option>
                                <option value="Defective">Defective</option>
                                <option value="Sell">Sell</option>
                                <option value="Missing">Missing</option>
                            </select>
                        </div>
                        <div class="input-box" id="repair-cost" style="display: none;">
                            <span class="details">Repair Cost</span>
                            <input type="text" name="repair-cost" value="" placeholder="Repair Cost...">
                        </div>
                        <div class="input-box">
                            <span class="details">Remarks</span>
                            <input type="text" name="remarks" placeholder="Remarks" id="">
                        </div>
                    
                    </div>
                    <div class="title">Specification</div>
                    <div class="asset-details">

                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" placeholder="Processor" id="">
                        </div>
                        <div class="input-box" id="plan" style="display: none;">
                            <span class="details">Plan</span>
                            <input type="text" name="plan" placeholder="Plan" id="">
                        </div>
                        <div class="input-box" id="dimes" style="display: none;">
                            <span class="details">Dimension</span>
                            <input type="text" name="dimes" placeholder="Dimension" id="">
                        </div>
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="os">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" placeholder="Operating System" id="">
                        </div>
                        <div class="input-box" id="datedeployed" style="display: none;">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" value="" id="">
                        </div>

                    </div>
                    <div class="title"></div>
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Assign To</span>
                            <select name="assigned" id="assigned" class="assigned">
                                <option value='' selected>Please Select</option>
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
                        <!-- <div class="input-box">
                            <span class="details">Turnover Date</span>
                            <input type="date" name="turnover">
                        </div> -->
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                            <!-- <input type="text" name="lastused" placeholder="Last used..." value="" > -->
                            <select name="lastused" id="lastused" class="assigned">
                                <option value='' selected>Please Select</option>
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
                        <input type="hidden" name="action" value="<?php echo $id; ?>"/>
                        <input type="submit" onclick="passValue()" value="Save" name="save"/>
                    </div>
                </form>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
</html>