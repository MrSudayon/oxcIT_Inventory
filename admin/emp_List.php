<?php include '../inc/auth.php'; ?>

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
th {
  cursor: pointer;
}
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
                    <a href="../admin/dashboard.php" class="link-btn" >Back</a>
                    <a href="../php/add_emp_info.php" class="link-btn">Add Emp</a>
                </div>

                <?php
                    $List = $operation->getEmp();
                    $results = mysqli_query($db->conn, $List);

                    $results_per_page = 30;

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

                        $sql = 
                        "SELECT * FROM employee_tbl 
                        WHERE name LIKE '%$search%' OR division LIKE '%$search%' OR location LIKE '%$search%'";
                    
                    } else {
                        // $sql =  "SELECT * FROM assets_tbl WHERE status!='Archive' ORDER BY lpad(assettag, 10, 0) LIMIT ". $page_first_result . ',' . $results_per_page;
                        $sql =  
                        "SELECT * FROM employee_tbl 
                        ORDER BY empStatus DESC 
                        LIMIT ". $page_first_result . ',' . $results_per_page;
                    
                    }
                    $res = mysqli_query($db->conn, $sql);
                    $rowCountPage = $res->num_rows;
                ?>
                <div class="count">
                    <p>Emp count: <b style="color: yellow; font-size: 20px;"><?php echo $rowCount; ?></b></p>
                </div>
            </div>
            <form action="" method="get">
                
                <table class="assets-table" id="myTable">
                    <tr>
                        <th onclick="sortTable(0)">User</th>
                        <th>Division</th>
                        <th>Location</th>
                        <th colspan="2" width="8%">Action</th>
                    </tr>
                    <?php 
                        while($row = mysqli_fetch_assoc($res)) {
                                 
                            $status = $row['empStatus'];
                            if($status==0) {
                                echo "<tr style='background-color: pink'>";
                            } else {
                                echo "<tr>";
                            }
                    ?> 
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['division']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td>
                        <center>
                            <a href="../update/empUpd.php?empID=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="24px"></a>

                            <a href="../update/remove.php?empID=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                        </center>
                        </td>    
                    </tr>
                    <?php
                        }
                    ?>
                </table>
                
            <?php
            if($rowCountPage != $rowCount) {
                if ($page > 1) {
                    echo '<a href="dashboard.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'active' : ''; // Add active class to current page
                    echo '<a href="dashboard.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="dashboard.php?page=' . ($page + 1) . '" class="next">Next</a>';
                }
            }
            ?>
            </form>
            
        </div>

        <script src="../js/dashboard.js"></script>
        <script src="../js/sort.js"></script>
</body>
</html>