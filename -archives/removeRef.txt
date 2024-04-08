<?php
include ('../php/db_connection.php');

$db = new Connection();


// Get user session for Hist
$user_sess = $select->selectUserById($_SESSION['id']);
$name = $user_sess['username'];

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
} 

// Turnover Ref Deletion
elseif(isset($_GET['Turnover_id'])) {
    $id = $_GET['Turnover_id'];

    $query = mysqli_query($db->conn, "UPDATE assets_tbl SET turnover_ref='' WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $Asset_id = $row['id'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Deleted Turnover Ref for Asset ID: $Asset_id', NOW())");
}

// Turnover Ref

header("Location: references.php");


?>