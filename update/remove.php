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
    
    header("Location: ../admin/dashboard.php");
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

    header("Location: ../admin/references.php");
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

    header("Location: ../admin/references.php");
}

if(isset($_GET['empID'])) {
    $id = $_GET['empID'];

    $query = mysqli_query($db->conn, "UPDATE employee_tbl SET status='' WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM employee_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $empName = $row['name'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Removed employee: $Asset_id', NOW())");

    header("Location: ../admin/emp_List.php");
}

// Remove from Employee tbl
// if(isset($_GET['empID1'])) {
//     $id = $_GET['empID1'];

//     $query = mysqli_query($db->conn, "UPDATE employee_tbl SET status=0 WHERE id='$id'");

//     $sql_All = mysqli_query($db->conn, "SELECT * FROM employee_tbl WHERE id = $id");
//     while($row = $sql_All->fetch_assoc()) {
//         $empName = $row['name'];
//     }
//     $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
//                             VALUES ('', '$name', 'Removed employee: $empName from the List', NOW())");

//     header("Location: emp_List.php");
// }

// Remove from Asset tbl
if(isset($_GET['assetItemID'])) {
    $id = $_GET['assetItemID'];

    $query = mysqli_query($db->conn, "UPDATE category_tbl SET status=0 WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM category_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $assetName = $row['assetType'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Removed Asset item: $assetType from the List', NOW())");

    header("Location: ../admin/asset_List.php");
}

// Remove from Dept tbl
if(isset($_GET['deptID'])) {
    $id = $_GET['deptID'];

    $query = mysqli_query($db->conn, "UPDATE dept_tbl SET status=0 WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM dept_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $deptName = $row['name'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Removed Division: $deptName from the List', NOW())");

    header("Location: ../admin/dept_List.php");
}

// Remove from Loc tbl
if(isset($_GET['locID'])) {
    $id = $_GET['locID'];

    $query = mysqli_query($db->conn, "UPDATE loc_tbl SET status=0 WHERE id='$id'");

    $sql_All = mysqli_query($db->conn, "SELECT * FROM loc_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $locName = $row['name'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Removed Location: $locName from the List', NOW())");

    header("Location: ../admin/loc_List.php");
}
?>