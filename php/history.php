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
            <div class="pagination-btns">
            <?php


                $sqlSelectAll = "SELECT * FROM history_tbl";
                $results = mysqli_query($db->conn, $sqlSelectAll);

                $results_per_page = 25;

                if (!isset ($_GET['page']) ) {  
                    $page = 1;  
                } else {  
                    $page = $_GET['page'];  
                }  
                
                $rowCount = $results->num_rows;
                $number_of_page = ceil ($rowCount / $results_per_page);  
                $page_first_result = ($page-1) * $results_per_page;  

                if(isset($_POST['search']) && $_POST['search'] != "") {
                        $search = $_POST['search'];
                        $page = 1;  
                    
                        $sql = "SELECT * FROM history_tbl WHERE name LIKE '%$search%' OR action LIKE '%$search%' OR date LIKE '%$search%' LIMIT " . $results_per_page;
                } else {
                        $sql =  "SELECT * FROM history_tbl LIMIT ". $page_first_result . ',' . $results_per_page;
                }
                $res = mysqli_query($db->conn, $sql);
                $rowCountPage = $res->num_rows;

                // Pagination nav
                if ($page > 1) {
                    echo '<a href="history.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                for($i = 1; $i<= $number_of_page; $i++) {  
                    echo '<a href = "history.php?page=' . $i . '" class="next">' . $i . '</a>';  
                }  
                if ($page < $number_of_page) {
                    echo '<a href="history.php?page=' . ($page + 1) . '" class="next">Next</a>';
                }
                ?>
            </div>
            <div class="count">
                <p>Asset count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCountPage; ?></b></p>
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
                        while($row = mysqli_fetch_assoc($res)) {
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