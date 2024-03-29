<?php include '../inc/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../assets/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Turnover</title>
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
                            <select name="asset-type" id="Type" style="background-color: #ccc;" readonly onChange="displaySelectedValue()" required>
                                <option value="<?=$result['assettype']?>"><?=$result['assettype']?></option>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Asset Tag</span>
                            <!-- <input type="text" name="asset-tag" value="" id="" required> -->
                            <div class="asset-tag" id="tag" style="background-color: #ccc;"><?=$result['assettag']?></div>
                            <input type="text" name="asset-tag" value="<?=$result['assettag']?>" id="asset-tag" hidden>
                        </div>
                        <div class="input-box">
                            <span class="details">Model</span>
                            <input type="text" name="model" style="background-color: #ccc;" readonly value="<?=$result['model']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Serial no.</span>
                            <input type="text" name="serial" style="background-color: #ccc;" readonly value="<?=$result['serial']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Supplier</span>
                            <input type="text" name="supplier" style="background-color: #ccc;" readonly value="<?=$result['supplier']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Date Purchased</span>
                            <input type="date" name="dateprchs" style="background-color: #ccc;" readonly value="<?=$result['datepurchased']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select style="background-color: #ccc;">
                                <option value=<?=$result['status']?>><?=$result['status']?></option>
                            
                            </select>
                        </div>
                        <div class="input-box" id="cost">
                            <span class="details">Cost</span>
                            <input type="text" name="cost" style="background-color: #ccc;" value="<?=$result['cost']?>" readonly>
                        </div>
                        <div class="input-box" id="repair-cost">
                            <span class="details">Repair Cost</span>
                            <input type="text" name="repair-cost" style="background-color: #ccc;" value="<?=$result['repair_cost']?>" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details">Remarks</span>
                            <input type="text" name="remarks" style="background-color: #ccc;" readonly value="<?=$result['remarks']?>" id="">
                        </div>

                    </div>
                    <div class="title">Specification</div>
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" style="background-color: #ccc;" readonly value="<?=$result['CPU']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" style="background-color: #ccc;" readonly value="<?=$result['MEMORY']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" style="background-color: #ccc;" readonly value="<?=$result['STORAGE']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" style="background-color: #ccc;" readonly value="<?=$result['OS']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Others</span>
                            <input type="text" name="other" style="background-color: #ccc;" readonly value="<?=$result['Others']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" style="background-color: #ccc;" readonly value="<?=$result['datedeployed']?>" id="">
                        </div>
                    </div>
                    <div class="title"></div>
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Turnover Date</span>
                            <input type="date" name="turnover" value="<?php echo date('Y-m-d'); ?>" style="background-color: #ccc;">
                        </div>
                        <div class="input-box">
                            <span class="details">Last Used by:</span>
                            <input type="text" name="lastused" value="<?=$result['assigned']?>">
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Reason: </span>
                            <select name="reason">
                                <option value="Replacement">Replacement</option>
                                <option value="Defective">Defective</option>
                                <option value="Resign">Resign</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Reference Code</span>
                            <input type="text" name="ref_code" id="ref_code" placeholder="XXXX-XXXX-XXXX" required>
                        </div>
                    </div>
                    
                    <div class="button">
                        <input type="submit" value="Turnover" name="turnover-asset"/>
                    </div>
                </form>
                <?php
                    }
                }
                ?>
        </div>
    </div>
    <script src="../js/addAssets.js"></script>
</body>
</html>