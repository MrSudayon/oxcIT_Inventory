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
    <title>History</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Menu</button>
            <div class="dropdown-content">
                <a href="../admin/configuration.php">Configuration</a>
                <a href="../php/history.php">History</a>
                <a href="../php/logout.php?id=<?php echo $id; ?>&name=<?php echo $username; ?>">Logout</a>
            </div>
        </div>
    </header>
    
        <div class="content">
            <div class="title">
                <h1> History </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
         
                <table class="assets-table">
                    <tr>
                  
                        <th>User</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                    
                    <tr>
                    <?php 
                        $getAllRecord = new Operations();

                        $searchData = $getAllRecord->searchHistory();

                        while($row = mysqli_fetch_assoc($searchData)) {
                        
                    ?> 
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['action']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>

            
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>