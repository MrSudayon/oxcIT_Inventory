<?php
require_once '../php/db_connection.php';

$select = new Select();
$operation = new Operations();
$db = new Connection();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
    $id = $user['id'];
    $username = $user['username'];
    $role = $user['role'];
    if($role != 'admin') {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../php/login.php");
}