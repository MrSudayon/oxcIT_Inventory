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
        <a href="../admin/configuration.php"><img src="../assets/logo.png" width="150px"></img></a>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <a href="../php/history.php">History</a>
            <a href="../php/logout.php?id=<?php echo $id; ?>&name=<?php echo $username; ?>">Logout</a>
        </div>
    </div>
</header>

    <div class="container">
        <div class="add-form">
            <a href="../admin/references.php" class="return">Back</a>

            <div class="title">Reference Details</div>
            <?php
            if(isset($_GET['id']))
            {
                $refId = mysqli_real_escape_string($db->conn, $_GET['id']);
                $ref = new assetsController;
                $result = $ref->editReference($refId);

                if($result) {
                    
                    $trnStatus = $result['trnStatus'];
                    $accStatus = $result['acctStatus'];
                    $empId = $result['assetId'];
                    
                    $sql = "SELECT * FROM assets_tbl WHERE id='$empId'";
                    $res = mysqli_query($db->conn, $sql);
                    $data = $res->fetch_assoc();
    
            ?>
                <form action="../admin/update-selected.php" method="POST">
                    <div class="asset-details">
                        <div class="input-box" style="width: 100%;">
                            <span class="details">Name</span>
                            <input type="text" name="name" id="name" value="<?=$result['name']?>" style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details">Accountability Code</span>
                            <input type="text" value="<?=$data['accountability_ref'] ?>"  style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="trnStatus">

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
                                    $trnStatus = 'N/A';
                            }
                            ?>
                                
                            </select>
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
                            }
                            ?>
                                
                            </select>
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