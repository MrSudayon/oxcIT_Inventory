<?php
require_once '../php/db_connection.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);

    $id = $user['id'];
    $username = $user['username'];

    $sql = mysqli_query($db->conn, "SELECT * FROM users_tbl WHERE id='$id'");

    $row = $sql->fetch_assoc();
    $role = $row['role'];

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
    <script src="../js/dashboard.js"></script>
</head>
<body>
    <?php include '../inc/header.php'; ?>
    
        <div class="content">
            <div class="title">
                <h1> Asset Dashboard </h1>
                <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
            
            <form action="accountability.php" method="get">

            
                <div class="link-btns">
                    <a href="add-assets.php" class="link-btn">Add</a>
                    <button type="submit" class="link-btn" name="accountability" >Accountability</button>
                    <button type="submit" formaction="turnover.php" class="link-btn" name="turnover" >Turnover</button>
                    <button type="submit" formaction="references.php" class="link-btn" name="references" >Reference</button>
                    <button type="submit" formaction="report.php" class="link-btn" name="turnover" >Report</button>
                </div>
                <table class="assets-table" id="myTable">
                    <thead>
                    <tr>
                        <th><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                        <th>User</th>
                        <th>Department</th>
                        <th>Asset Type</th>
                        <th>Asset Tag</th>
                        <th>Model</th>
                        <th>CPU</th>
                        <th>Memory</th>
                        <th>Storage</th>
                        <th>Status</th>
                        <th coslpan="3">Action</th>
                    </tr>
</thead>
<tbody>
                    <tr>
                    <?php 
                        $getAllRecord = new Operations();

                        // $Records = $getAllRecord->getAllData();

                        $searchData = $getAllRecord->searchData();

                        // foreach($Records as $data) {
                        while($row = mysqli_fetch_assoc($searchData)) {
                        
                    ?> 
                        <td><input type="checkbox" id="select" name="select[]" value="<?php echo $row['id']; ?>"></td>
                        <td><?php echo $row['assigned']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['assettype']; ?></td>
                        <td><?php echo $row['assettag']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['CPU']; ?></td>
                        <td><?php echo $row['MEMORY']; ?></td>
                        <td><?php echo $row['STORAGE']; ?></td>
                        <td><?php echo $row['status']; ?></td>

                        <td>
                        <center>
                            <a href="update.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/update.png" width="32px"></a>&nbsp;
                            <a href="turnoverUpd.php?id=<?php echo $row['id']; ?>"><img src="../assets/icons/turnover.png" width="32px"></a>&nbsp;
                            <a href="remove.php?id=<?php echo $row['id']; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="32px"></a>
                        </center>
                            
                        </td>    
                    
                    </tr>
</tbody>
                    
                    <?php
                        }
                    ?>
                </table>
                <ul class="pagination" id="pagination"></ul>
                
                
            </form>
            
        </div>

        
<script>
const table = document.getElementById('myTable');
const rowsPerPage = 2;
let currentPage = 1;

function displayTablePage(page) {
    const start = (page - 1) * rowsPerPage + 1;
    const end = start + rowsPerPage - 1;
    const rows = table.rows;

    for (let i = 1; i < rows.length; i++) {
        if (i >= start && i <= end) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

function setupPagination() {
    const totalPages = Math.ceil((table.rows.length - 1) / rowsPerPage);
    const paginationElement = document.getElementById('pagination');
    paginationElement.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.textContent = i;
        li.addEventListener('click', () => {
            currentPage = i;
            displayTablePage(currentPage);
            updatePaginationUI();
        });
        paginationElement.appendChild(li);
    }

    updatePaginationUI();
}

function updatePaginationUI() {
    const paginationItems = document.querySelectorAll('.pagination li');
    paginationItems.forEach((item, index) => {
        if (index + 1 === currentPage) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

displayTablePage(currentPage);
setupPagination();
</script>
        
</body>
</html>