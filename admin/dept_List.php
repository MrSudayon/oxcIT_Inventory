<?php
require_once '../php/db_connection.php';

$select = new Select();
$getAllRecord = new Operations();

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

</style>
<body>
    <?php include '../inc/header.php'; ?>
    
        <div class="content">
            <div class="title">
                <h1> Configuration </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
            <div class="table-nav">
                <div class="link-btns">
                    <a href="../php/add_division.php" class="link-btn">Add Division</a>
                    <!--  -->
                    <a href="../admin/emp_List.php" class="link-btn">Employee</a>
                    <a href="../admin/asset_List.php" class="link-btn">Asset</a>
                    <a href="../admin/dept_List.php" class="link-btn">Department</a>
                    <a href="../admin/location_List.php" class="link-btn">Location</a>
                </div>

                <?php
                    $List = $getAllRecord->searchDept();
                    $rowCount = $List->num_rows;
                ?>
                <div class="count">
                    <p>Emp count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCount; ?></b></p>
                </div>
            </div>
            <form action="" method="get">
                
                <table class="assets-table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th colspan="2" width="8%">Action</th>
                    </tr>
                    <?php    
                        while($row = mysqli_fetch_assoc($List)) {
                    ?> 
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                        <center>
                            <a href="../update/deptUpd.php?empID=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="24px"></a>

                            <a href="remove?deptID=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                        </center>
                        </td>    
                    </tr>
                    <?php
                        }
                    ?>
                </table>
                
                
            </form>
            
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>