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
    <title>Add Assets</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../assets/logo.jpg" alt="logo" width="70px">
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
                <form action="" method="POST">
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Asset Type</span>
                            <input type="text" name="asset-type" placeholder="Asset Type" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Asset Tag</span>
                            <input type="text" name="asset-tag" placeholder="Asset Tag" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Model</span>
                            <input type="text" name="model" placeholder="Model" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Serial no.</span>
                            <input type="text" name="serial" placeholder="Serial Number" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Supplier</span>
                            <input type="text" name="supplier" placeholder="Supplier" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Date Purchased</span>
                            <input type="date" name="asset-type" placeholder="Date Purchased" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Status</span>
                            <input type="text" name="status" placeholder="Status" id="" required>
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
                            <input type="text" name="processor" placeholder="Processor" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" placeholder="Memory" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" placeholder="Storage" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" placeholder="Operating System" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Others</span>
                            <input type="text" name="other" placeholder="Others" id="">
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
                                <input type="text" name="assigned" placeholder="Assigned To" id="" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Department</span>
                                <input type="text" name="department" placeholder="Department" id="" required>
                            </div>
                            <div class="input-box">
                                <span class="details">location</span>
                                <input type="text" name="location" placeholder="Location" id="">
                            </div>
                        </div>
                    <div class="button">
                        <input type="submit" value="Save" name="save">
                    </div>
                </form>
        </div>
</div>
    
    
</body>
</html>