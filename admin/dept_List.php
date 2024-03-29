<?php include '../inc/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/formStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Division List</title>
</head>
<style>

</style>
<body>
    <?php include '../inc/header.php'; ?>
    
        <div class="content">
            <div class="title">
                <h1> CONFIGURATION </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
            <div class="table-nav">
                <div class="link-btns">
                    <a href="../admin/adminConfig.php" class="link-btn" >Back</a>
                    <a href="../php/add_division.php" class="link-btn">Add Division</a>
                </div>

                <?php
                    $List = $operation->searchDept();
                    $rowCount = $List->num_rows;
                ?>
                <div class="count">
                    <p>Division count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCount; ?></b></p>
                </div>
            </div>
            <form action="" method="get">
                
                <table class="assets-table">
                    <tr>
                        <th>Name</th>
                        <th colspan="2" width="8%">Action</th>
                    </tr>
                    <?php 
                        while($row = mysqli_fetch_assoc($List)) {
                                 
                            $status = $row['status'];
                            if($status==0) {
                                echo "<tr style='background-color: pink'>";
                            } else {
                                echo "<tr>";
                            }
                    ?> 
                        <td><?php echo $row['name']; ?></td>
                        <td>
                        <center>
                            <a href="../update/deptUpd.php?deptID=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="24px"></a>
                            <!-- <a href="remove?deptID=" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a> -->
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