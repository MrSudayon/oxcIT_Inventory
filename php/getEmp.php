<?php

require_once('db_connection.php');

$db = new Connection();

$name = $_POST['assigned'];
$sql = "SELECT * FROM employee_tbl WHERE name = $name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row); // Send item details back as JSON
} else {
    echo "Item not found";
}

$conn->close();
?>