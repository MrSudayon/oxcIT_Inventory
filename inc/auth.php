<?php
require_once '../class/db_connection.php';

$addItems = new AddItems();
$assetController = new assetsController;
$select = new Select();
$operation = new Operations();
$db = new Connection();
$register = new Register();
$getAllUser = new get_All_User();

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