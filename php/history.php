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

        <div class="table-nav">
            <div class="link-btns">
                <!-- <a href="add-assets.php" class="link-btn"></a> -->
            </div>
            <?php
                $getAllRecord = new Operations();

                $searchData = $getAllRecord->searchHistory();
                // $rowCount = mysqli_num_rows($searchData);
                if(isset($searchData)) {
                    $rowCount = $searchData->num_rows;
                } else {
                    $rowCount = 0;
                }
                
                
            ?>
            <div class="count">
                <p>Asset count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCount; ?></b></p>
            </div>
        </div>
        <?php
        if($rowCount>0) {

            $results_per_page = 10;

            if (!isset ($_GET['page']) ) {  
                $page = 1;  
            } else {  
                $page = $_GET['page'];  
            }  
            $number_of_page = ceil ($rowCount / $results_per_page);  
            $page_first_result = ($page-1) * $results_per_page;  

            // $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' LIMIT ". $page_first_result . ',' . $results_per_page;
            // $res = mysqli_query($db->conn, $sql);

        ?>
         
                <table class="assets-table">
                    <tr>
                  
                        <th>User</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                    
                    <tr>
                    <?php
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

                <?php
                for($page = 1; $page<= $number_of_page; $page++) {  
                    echo '<a href = "history.php?page=' . $page . '">' . $page . ' </a>';  
                }  
            }
                ?>

            
        </div>

        <script src="../js/dashboard.js"></script>
</body>
</html>