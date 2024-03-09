<?php
require '../php/db_connection.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
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
    <title>Update</title>
</head>
<body>
<header>
    <div class="logo">
        <a href="../admin/dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <!-- <a href="../php/add_emp_info.php">Register</a> -->
            <a href="../php/history.php">History</a>
            <a href="../php/logout.php?id=<?php echo $id; ?>&name=<?php echo $username; ?>">Logout</a>
        </div>
    </div>
</header>

    <div class="container">
        <div class="add-form">
        <a href="../admin/dashboard.php" class="return">Back</a>

            <div class="title">Asset Details</div>
            <?php
            if(isset($_GET['id']))
            {
                $assetID = mysqli_real_escape_string($db->conn, $_GET['id']);
                $asset = new assetsController;
                $result = $asset->edit($assetID);

                if($result) {
            ?>
                <form action="../admin/update-selected.php" method="POST">
                    <div class="asset-details">
                        <input type="hidden" name="assetID" value="<?=$result['id']?>">

                        <div class="input-box">
                            <span class="details">Asset Type</span>
                            <!-- <input type="text" name="asset-type" value="" id="" required> -->
                            <select name="asset-type" id="Type" onChange="changetextbox(); displaySelectedValue();" style="background-color: #ccc;" readonly>
                                <option value="<?=$result['assettype']?>"><?=$result['assettype']?></option>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Asset Tag</span>
                            <div class="asset-tag" id="tag" style="background-color: #ccc;"><?=$result['assettag']?></div>
                            <input type="text" name="asset-tag" id="asset-tag" hidden>
                        </div>
                        <div class="input-box" id="model">
                            <span class="details">Model</span>
                            <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                        </div>
                        <div class="input-box" id="provider" style="display: none;">
                            <span class="details">Provider</span>
                            <input type="text" name="provider" placeholder="Provider" value="<?=$result['model']?>" id="">
                        </div>
                        
                        <div class="input-box" id="serial">
                            <span class="details">Serial no.</span>
                            <input type="text" name="serial" value="<?=$result['serial']?>" placeholder="Serial Number" id="">
                        </div>
                        <div class="input-box" id="mobile" style="display: none;">
                            <span class="details">Mobile no.</span>
                            <input type="text" name="mobile" value="<?=$result['serial']?>" placeholder="Mobile no." id="">
                        </div>

                        <div class="input-box">
                            <span class="details">Supplier</span>
                            <input type="text" name="supplier" value="<?=$result['supplier']?>" placeholder="Supplier" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Cost</span>
                            <input type="text" name="cost" value="<?=$result['cost']?>" placeholder="Item cost.." id="">
                        </div>
                        
                        <div class="input-box">
                            <span class="details">Date Purchased</span>
                            <input type="date" name="dateprchs" value="<?=$result['datepurchased']?>" placeholder="Date Purchased" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="status" id="status" onChange="changetextbox()">
                                <option value="<?=$result['status']?>"><?=$result['status']?></option>
                                <option value="For repair">For repair</option>
                                <option value="Deployed">Deployed</option>
                                <option value="To be Deploy">To be deploy</option>
                                <option value="Deffective">Defective</option>
                                <option value="Sell">Sell</option>
                            </select>
                        </div>
                        <div class="input-box" id="repair-cost" style="display: none;">
                            <span class="details">Repair Cost</span>
                            <input type="text" name="repair-cost" value="<?=$result['repair_cost']?>" value="" placeholder="Repair Cost...">
                        </div>
                        <div class="input-box">
                            <span class="details">Remarks</span>
                            <input type="text" name="remarks" value="<?=$result['remarks']?>" placeholder="Remarks" id="">
                        </div>

                    </div>
                    <div class="title">Specification</div>
                    <div class="asset-details">
                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['CPU']?>" placeholder="Processor" id="">
                        </div>
                        <div class="input-box" id="plan" style="display: none;">
                            <span class="details">Plan</span>
                            <input type="text" name="plan" value="<?=$result['CPU']?>" placeholder="Plan" id="">
                        </div>
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['MEMORY']?>" placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['STORAGE']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['OS']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Others</span>
                            <input type="text" name="other" value="<?=$result['Others']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" value="<?=$result['datedeployed']?>" id="">
                        </div>
                    </div>
                    <div class="title"></div>
                    <div class="asset-details">
                        <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Assign To</span>
                            <select name="assigned" id="assigned" class="assigned">
                                <option value="">None</option>
                                <option value="<?=$result['assigned']?>"><?=$result['assigned']?></option>
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
                        <div class="input-box">
                            <span class="details">Turnover Date</span>
                            <input type="date" name="turnover" value="<?=$result['dateturnover']?>">
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                            <!-- <input type="text" name="lastused" value=""> -->
                                <select name="lastused" id="lastused" class="assigned">
                                    <option value="<?=$result['lastused']?>"><?=$result['lastused']?></option>
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
                    </div>
                    
                    <div class="button">
                        <input type="submit" onclick="passValue()" value="Save" name="update-asset"/>
                    </div>
                </form>
                <?php
                    }
                }
                ?>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
</html>