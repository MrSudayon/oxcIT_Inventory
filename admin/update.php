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
    <link rel="stylesheet" href="../css/styles.css">
    <title>Update</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="../php/register.php">Users</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="add-form">
            <div class="title">Asset Details</div>
            <?php
            if(isset($_GET['id']))
            {
                $assetID = mysqli_real_escape_string($db->conn, $_GET['id']);
                $asset = new assetsController;
                $result = $asset->edit($assetID);

                if($result)
                {
            ?>
                <form action="assets-update.php" method="POST">
                    <div class="asset-details">
                        <input type="hidden" name="assetID" value="<?=$result['id']?>">

                        <div class="input-box">
                            <span class="details">Asset Type</span>
                            <!-- <input type="text" name="asset-type" value="" id="" required> -->
                            <select name="asset-type" id="Type" onChange="displaySelectedValue()" required>
                                <option value="<?=$result['assettype']?>"><?=$result['assettype']?></option>
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
                            <!-- <input type="text" name="asset-tag" value="" id="" required> -->
                            <div class="asset-tag" id="tag" style="background-color: #ccc;"><?=$result['assettag']?></div>
                            <input type="text" name="asset-tag" value="<?=$result['assettag']?>" id="asset-tag" hidden>
                        </div>
                        <div class="input-box">
                            <span class="details">Model</span>
                            <input type="text" name="model" value="<?=$result['model']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Serial no.</span>
                            <input type="text" name="serial" value="<?=$result['serial']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Supplier</span>
                            <input type="text" name="supplier" value="<?=$result['supplier']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Date Purchased</span>
                            <input type="date" name="dateprchs" value="<?=$result['datepurchased']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Status</span>
                            <select name="status">
                                <option value="<?=$result['status']?>"><?=$result['status']?></option>
                                <option value="Maintenance">For Repair</option>
                                <option value="To be Deploy">To be Deploy</option>
                                <option value="Deployed">Deployed</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Remarks</span>
                            <input type="text" name="remarks" value="<?=$result['remarks']?>" id="">
                        </div>

                    </div>
                    <div class="title">Specification</div>
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['CPU']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['MEMORY']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['STORAGE']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['OS']?>" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Others</span>
                            <input type="text" name="other" value="<?=$result['Others']?>" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" id="">
                        </div>
                    </div>
                    <div class="title">User Information</div>
                    <div class="asset-details">
                        <div class="input-box">
                        <span class="details">Assigned To</span>
                            <select name="assigned" id="assigned" class="assigned">
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
                            <span class="details">Last Used by:</span>
                            <input type="text" name="lastused" style="background-color: #ccc;" value="<?=$result['lastused']?>" readonly>
                        </div>
                    </div>
                    
                    <div class="button">
                        <input type="submit" value="Save" name="update-asset"/>
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