<?php
include ('../php/db_connection.php');

$db = new Connection();

// Get user session for Hist
$user_sess = $select->selectUserById($_SESSION['id']);
$name = $user_sess['username'];

if(isset($_GET['assetID'])) {
    $id = $_GET['assetID'];
    $user_sess = $select->selectUserById($_SESSION['id']);
    $name = $user_sess['username'];
    
    $query = mysqli_query($db->conn, "UPDATE assets_tbl SET status='Archive' WHERE id='$id'");
    
    $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $tag->fetch_assoc()) {
        $assettag = $row['assettag'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Deleted Tag: $assettag from Assets Record', NOW())");
    
    header("Location: dashboard.php");
}

// Accountability Ref Deletion
if(isset($_GET['Acct_id'])) {
    $id = $_GET['Acct_id'];

    $query = mysqli_query($db->conn, "UPDATE assets_tbl SET accountability_ref='' WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $Asset_id = $row['id'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Deleted Accountability Ref for Asset ID: $Asset_id', NOW())");

    header("Location: references.php");
} 

// Turnover Ref Deletion
if(isset($_GET['Turnover_id'])) {
    $id = $_GET['Turnover_id'];

    $query = mysqli_query($db->conn, "UPDATE assets_tbl SET turnover_ref='' WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $Asset_id = $row['id'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Deleted Turnover Ref for Asset ID: $Asset_id', NOW())");

    header("Location: references.php");
}

if(isset($_GET['empID'])) {
    $id = $_GET['empID'];

    $query = mysqli_query($db->conn, "UPDATE employee_tbl SET status='' WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM employee_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $empName = $row['name'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Edited employee: $Asset_id`s Information', NOW())");

    header("Location: emp_List.php");
}



?>