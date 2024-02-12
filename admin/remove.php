<?php
include ('../php/db_connection.php');

$db = new Connection();

$id = $_GET['id'];

$query = mysqli_query($db->conn, "UPDATE assets_tbl SET status='Archive' WHERE id='$id'");

?>
<script>
    alert('Record Removed')

</script>
<?php
    header("Location: dashboard.php");


?>