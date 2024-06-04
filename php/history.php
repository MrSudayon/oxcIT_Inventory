 <?php include '../inc/auth.php'; 
include '../inc/listsHead.php'; 
include '../inc/header.php'; ?>
<body>
<div class="content">

        <?php 
            $sqlSelectAll = "SELECT * FROM history_tbl";
            $results = mysqli_query($db->conn, $sqlSelectAll);

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
                    $page = 1;  
                
                    $sql = "SELECT * FROM history_tbl WHERE name LIKE '%$search%' OR action LIKE '%$search%' OR date LIKE '%$search%' ORDER BY id DESC LIMIT " . $results_per_page;
            } else {
                    $sql =  "SELECT * FROM history_tbl ORDER BY id DESC LIMIT ". $page_first_result . ',' . $results_per_page;
            }
            $res = mysqli_query($db->conn, $sql);
            $rowCountPage = $res->num_rows;

        ?>
<!-- <div class="title">
        <h1> History </h1>
        <div class="search-container">
        <form action="" method="POST">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        </div>
    </div> -->
        
    <main class="table" id="customers_table">
        <section class="table__header">
            <div class="input-group">
                <input type="search" id="searchInput" placeholder="Search Data..." oninput="searchTable()">
                <img src="../assets/icons/search.png" alt="">
            </div>
            <p> <b style="color: yellow; font-size: 20px; margin-top: 10px;" class="result-count"><?php echo $rowCountPage; ?></b> result/s.</p>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
           
        </section>
        <?php

            // Pagination nav
            if($rowCountPage != $rowCount) {
                if ($page > 1) {
                    echo '<a href="history.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'active' : ''; // Add active class to current page
                    echo '<a href="history.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="history.php?page=' . ($page + 1) . '" class="next">Next</a>';
                    echo '<a href="history.php?page=all" class="next">All</a>';
                }
            }
        ?>

    </main>

</div>
<script src="../js/sort.js"></script>
<script src="../js/dashboard.js"></script>
</body>
</html>