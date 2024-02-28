<?php
require_once '../php/db_connection.php';

$select = new Select();
$getEmp = new get_All_User();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);

    $id = $user['id'];
    $username = $user['username'];

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Employee List</title>
</head>
<style>
.link {
    color: black;
    font-weight: 600;
}
.link:hover {
    color: blue;
    transition: ease-in-out .2s;
    text-decoration: underline;
}

</style>
<body>
<?php include '../inc/header.php'; ?>

<div class="container">
    <div class="add-form">
        <div class="title">Employee Update</div>
        <?php
        if(isset($_GET['empID'])) {
            $empID = mysqli_real_escape_string($db->conn, $_GET['empID']);
            $asset = new assetsController;
            $result = $asset->empEdit($empID);

            if($result) {
        ?>
            <form action="update-selected.php" method="POST">
                <div class="asset-details">
                    <input type="hidden" name="empID" value="<?=$result['id']?>">

                    <div class="input-box">
                        <span class="details">Name</span>
                        <input type="text" name="name" value="<?=$result['name']?>" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Division</span>
                        <select name="division">
                            <option value="<?=$result['division']?>"><?=$result['division']?></option>
                            <?php
                                $getData = new Operations;
                                $emp = $getData->getEmpDiv();

                                foreach($emp as $empDiv) {
                            ?>
                                <option value="<?=$empDiv['division']?>"><?php echo $empDiv['division']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Location</span>
                        <select name="location">
                            <option value="<?=$result['location']?>"><?=$result['location']?></option>
                            <?php
                                $getData = new Operations;
                                $emp = $getData->getEmpLoc();

                                foreach($emp as $empLoc) {
                            ?>
                                <option value="<?=$empLoc['division']?>"><?php echo $empLoc['division']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Status</span>
                        <select name="status">
                        <?php
                            $status = $result['status'];
                            if($status = 1) {
                        ?>
                            <option value="<?=$result['status']?>">Active</option>
                            <option value="0">Inactive</option>
                        <?php
                            } else { 
                        ?> 
                            <option value="<?=$result['status']?>">Inactive</option>
                            <option value="1">Active</option>
                        <?php
                            }
                        ?>
                            
                        </select>
                    </div>
                    
                </div>
                <div class="button">
                    <input type="submit" value="Update" name="updateEmp"/>
                </div>
            </form>
            <?php
                }
            }
            ?>
    </div>
</div>
</body>
</html>