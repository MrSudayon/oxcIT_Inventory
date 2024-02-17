<?php
include ('../php/db_connection.php');

$db = new Connection();

$id = $_GET['id'];
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


?>