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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Menu</button>
            <div class="dropdown-content">
                <a href="../php/add_emp_info.php">Register Emp</a>
                <a href="../php/history.php">History</a>
                <a href="../php/logout.php">Logout</a>
            </div>
        </div>
        <!-- 2-16-24
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="../php/add_emp_info.php">Register Emp</a></li>
                <li><a href="../php/add_emp_info.php">Register Emp</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav> -->
    </header>
    
        <div class="content">
            <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <!-- <form action="accountability.php" method="get"> -->
                <table class="assets-table">
                    <tr>
                        <!-- <th><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th> -->
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                    
                    <tr>
                    <?php 
                        $getAllRecord = new Operations();

                        $searchData = $getAllRecord->getHistory();

                        while($row = mysqli_fetch_assoc($searchData)) {
                        
                    ?> 
                        <!-- <td><input type="checkbox" id="select" name="select[]" value="<?php echo $row['id']; ?>"></td> -->
                     
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['datedeployed']; ?></td>
                        <td><?php echo $row['dateturnover']; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>

            <!-- </form> -->
            
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>