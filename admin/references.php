<?php
require_once '../php/db_connection.php';

$select = new Select();

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
                        <!-- <th><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th> -->
                        <th>User</th>
                        <th>Accountability Ref</th>
                        <th width="3%;"></th>
                        <th>Turnover Ref</th>
                        <th width="3%;"></th>
                    </tr>
                    
                    <tr>
                    <?php 
                        $getAllRecord = new Operations();

                        // $Records = $getAllRecord->getAllData();

                        $refData = $getAllRecord->referencesData();

                        // foreach($Records as $data) {
                        while($row = mysqli_fetch_assoc($refData)) {
                        
                    ?> 
                        <!-- <td><input type="checkbox" id="select" name="select[]" value="<?php echo $row['id']; ?>"></td> -->
                        <td><?php echo $row['assigned']; ?></td>
                        <td><a class="link" href="accountability.php?id=<?php echo $row['id']; ?>"><?php echo $row['accountability_ref']; ?></a></td>
                        <?php 
                            $acctRef = $row['accountability_ref'];
                            $turnoverRef = $row['turnover_ref'];

                            if($acctRef == '') {
                                echo "<td></td>";
                            } else {                       
                        ?>
                        <td>
                        <center>
                            <a href="remove.php?Acct_id=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                        </center>
                        </td>   
                        <?php
                            }
                        ?>
                        <td><a class="link" href="Turnover.php?id=<?php echo $row['id']; ?>"><?php echo $row['turnover_ref']; ?></a></td>
                        <?php
                            if ($turnoverRef == '') {
                                echo "<td></td>";
                            } else {
                        ?>
                        <td>
                        <center>
                            <a href="remove.php?Turnover_id=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                        </center>
                        </td>    
                        <?php
                            }
                        ?>
                    
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