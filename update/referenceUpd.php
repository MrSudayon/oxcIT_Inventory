<?php include '../inc/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/formStyles.css">
    <title>Update</title>
</head>
<body>
<?php include '../inc/header.php'; ?>
<!-- 
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
        <a href="../admin/configuration.php"><img src="../assets/logo.png" width="150px"></img></a>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <a href="../php/history.php">History</a>
            <a href="../php/logout.php?id=?php echo $id; ?>&name=?php echo $username; ?>">Logout</a>
        </div>
    </div>
</header> -->

    <div class="container">
        <div class="add-form">
            <a href="../admin/references.php" class="return">Back</a>

            <div class="title">Reference Details</div>
            <?php
            if(isset($_GET['id']))
            {
                $refId = mysqli_real_escape_string($db->conn, $_GET['id']); // assetId from reference tbl
                $result = $assetController->editReference($refId);

                if($result) {
                    
                    $trnStatus = $result['trnStatus'];
                    $accStatus = $result['acctStatus'];
                    
                    $sql = "SELECT * FROM assets_tbl WHERE id='$refId'";
                    $res = mysqli_query($db->conn, $sql);
                    $data = $res->fetch_assoc();
    
            ?>
                <form action="../admin/update-selected.php" method="POST" enctype="multipart/form-data">
                    <div class="asset-details">
                        <input type="hidden" name="id" value="<?=$result['id']?>">

                        <div class="input-box" style="width: 100%;">
                            <span class="details">Name</span>
                            <input type="text" name="name" value="<?=$result['name']?>" style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details">Accountability Code</span>
                            <input type="text" value="<?=$data['accountability_ref'] ?>"  style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="acctStatus">

                            <?php
                            switch($accStatus) {
                                case 1:
                                    $accStatus = 'On Process';
                                    ?>
                                        <option value="<?=$result['acctStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="2">Signed</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                case 2:
                                    $accStatus = 'Signed';
                                    ?>
                                        <option value="<?=$result['acctStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                default:
                                    $accStatus = 'N/A';
                                    ?>
                                        <option value="<?=$result['acctStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="2">Signed</option>
                                    <?php
                                    break;
                            }
                            ?>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Accountability File</span>
                            <input type="file" name="acctfile" id="acctfile" accept="files/*" value="<?=$result['acctFile']?>">
                        </div>
                        <div class="input-box">
                            <span class="details">Date</span>
                            <input type="date" name="acctDate" id="acctDate" value="<?=$result['acctDate']?>">
                        </div>

                </div>
                <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Turnover Code</span>
                            <input type="text" value="<?=$data['turnover_ref'] ?>"  style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="trnStatus">

                            <?php
                            switch($trnStatus) {
                                case 1:
                                    $trnStatus = 'On Process';
                                    ?>
                                        <option value="<?=$result['trnStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="2">Signed</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                case 2:
                                    $trnStatus = 'Signed';
                                    ?>
                                        <option value="<?=$result['trnStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                default:
                                    $trnStatus = 'N/A';
                                    ?>
                                        <option value="<?=$result['trnStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="2">Signed</option>
                                    <?php
                            }
                            ?>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Turnover File</span>
                            <input type="file" name="trnfile" accept="files/*" value="<?=$result['trnFile']?>">
                        </div>
                        <div class="input-box">
                            <span class="details">Date</span>
                            <input type="date" name="trnDate" id="trnDate" value="<?=$result['trnDate']?>">
                        </div>
                    </div>
            <?php 
                } 
            }
            ?>
                    <div class="button">
                        <input type="submit" onclick="passValue()" value="Save" name="update-reference"/>
                    </div>
                </form>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
</html>