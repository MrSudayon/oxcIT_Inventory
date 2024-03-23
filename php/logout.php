<?php

include '../class/db_connection.php';
$db = new Connection();

$_SESSION = [];
session_unset();
session_destroy();
header("Location: login.php");
