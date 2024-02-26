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
    <title>Reference</title>
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
    
        <div class="content">
            <div class="title">
                <h1> Reference </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
            
            <form action="" method="get">

                <table class="assets-table">
                    <tr>
                        <th>User</th>
                        <th>Division</th>
                        <th>Location</th>
                        <th colspan="2" width="6%">Action</th>
                    </tr>
                    <?php 
                        $empList = $getEmp->selectAllEmp();

                        foreach($empList as $row) {
                    ?> 
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['division']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td>
                        <center>
                            <a href="#?Turnover_id=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="24px"></a>

                            <a href="#?Turnover_id=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
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