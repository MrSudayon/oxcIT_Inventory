<?php
include '../inc/auth.php';

if(isset($_GET['assetID'])) {
    $id = $_GET['assetID'];

    $name = $user['username'];
    
    $query = mysqli_query($db->conn, "UPDATE assets_tbl SET status='Archive' WHERE id='$id' AND empId!='0'");
    
    $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $tag->fetch_assoc()) {
        $assettag = $row['assettag'];
        $assettype = $row['assettype'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Deleted Tag: $assettag from Assets Record', NOW())");
    
    if($assettype == 'Desktop') { 
        $url = "../assetLists/Desktop.php";
    } elseif($assettype == 'Laptop') {
        $url = "../assetLists/Laptop.php";
    } elseif($assettype == 'Monitor') {
        $url = "../assetLists/Monitor.php";
    } elseif($assettype == 'Printer') {
        $url = "../assetLists/Printer.php";
    } elseif($assettype == 'Mobile') {
        $url = "../assetLists/Mobile.php";
    } elseif($assettype == 'SIM') {
        $url = "../assetLists/SIM.php";
    } elseif($assettype == 'UPS') {
        $url = "../assetLists/UPS.php";
    } else {
        $url = "../admin/dashboard.php"; // Change name to 'All Assets'
    }

    header("Location: \"$url\"");
}

if(isset($_GET['unassignId']) && isset($_GET['empId'])) {
    $id = $_GET['unassignId'];
    $empId = $_GET['empId'];
    $name = $user['username'];
    
    $query = mysqli_query($db->conn, "UPDATE assets_tbl SET status='To be deploy', empId='0' WHERE id='$id'");
    
    $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $tag->fetch_assoc()) {
        $assettag = $row['assettag'];
        $assettype = $row['assettype'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Unassigned item: $assettag from emp: $empId Record', NOW())");
    
   
    header("Location: ../admin/employeeLists.php");
}

// Accountability Ref Deletion
if(isset($_GET['Acct_id'])) {
    $id = $_GET['Acct_id'];

    $query = "SELECT a.id, a.assettag, r.assetId, r.turnoverRef, r.accountabilityRef 
              FROM assets_tbl AS a 
              LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
              WHERE r.id='$id'";
    $result =  mysqli_query($db->conn, $query);
    
    while($row = mysqli_fetch_assoc($result)) {
        $accountabilityRef = $row['accountabilityRef'];
        $turnoverRef = $row['turnoverRef'];
        $assetTag = $row['assettag'];
    }

    $query = mysqli_query($db->conn, "UPDATE reference_tbl 
                                    SET accountabilityRef='',
                                        accountabilityFile='',
                                        accountabilityStatus=0,
                                        accountabilityDate='' 
                                    WHERE id = '$id'");

    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Deleted turnover reference code for Asset Tag: $assetTag', NOW())");

    header("Location: ../admin/reference.php");
} 

// Reference_id Ref Deletion
if(isset($_GET['Turnover_id'])) {
    $id = $_GET['Turnover_id'];

    $query = mysqli_query($db->conn, "UPDATE reference_tbl 
                                        SET turnoverRef='',
                                            turnoverFile='', 
                                            turnoverStatus=0, 
                                            turnoverDate='' 
                                        WHERE id = '$id'"
                                        );

    $sql_All = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $sql_All->fetch_assoc()) {
        $assetTag = $row['assettag'];
    }
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Deleted turnover reference code for Asset Tag: $assetTag', NOW())");

    header("Location: ../admin/reference.php");
}

if(isset($_GET['empID'])) {
    $id = $_GET['empID'];

    $query = mysqli_query($db->conn, "UPDATE employee_tbl SET empStatus=0 WHERE id='$id'");

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