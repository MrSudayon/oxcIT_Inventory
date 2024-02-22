<?php

include 'db_connection.php';
$db = new Connection();
// $name = $_GET['name'];

// mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
//                 VALUES ('', '$name', 'Logged out', NOW())");

$_SESSION = [];
session_unset();
session_destroy();
header("Location: login.php");

?>