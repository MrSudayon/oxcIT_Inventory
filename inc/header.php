<header>
    <div class="logo">
        <a href="dashboard.php"><img src="../assets/logo.png" width="150px"></img></a>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <!-- <a href="../php/add_emp_info.php">Register</a> -->
            <a href="../admin/emp_List.php">Employee List</a>
            <a href="../php/history.php">History</a>
            <a href="../php/logout.php?id=<?php echo $id; ?>&name=<?php echo $username; ?>">Logout</a>
        </div>
    </div>
</header>