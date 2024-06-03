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

// if(isset($_GET['unassignId']) && isset($_GET['empId'])) {
if(isset($_GET['unassignId']) && isset($_GET['empId']) && isset($_GET['voidRemark'])) {

    $id = $_GET['unassignId'];
    $empId = $_GET['empId'];
    $voidRemarks = $_GET['voidRemark'];

    $name = $user['username'];
    
    // First update query
    $query = "UPDATE assets_tbl SET status='To be deploy', remarks='$voidRemarks', empId='0' WHERE id='$id'";
    $result = mysqli_query($db->conn, $query);

    if ($result) {
        // Second update query
        $query1 = "UPDATE reference_tbl SET accountabilityRef='', accountabilityStatus='0', referenceStatus='0' WHERE assetId='$id'";
        $result1 = mysqli_query($db->conn, $query1);

        if ($result1) {
            echo "Both updates were successful.";
        } else {
            echo "Error updating reference_table: " . mysqli_error($db->conn);
        }
    } else {
        echo "Error updating assets_tbl: " . mysqli_error($db->conn);
    }
    
    $tag = mysqli_query($db->conn, "SELECT * FROM assets_tbl WHERE id = $id");
    while($row = $tag->fetch_assoc()) {
        $assettag = $row['assettag'];
        $assettype = $row['assettype'];
    }

    $empName = $operation->getThyNames($empId);
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Unassigned item: $assettag from: $empName. Remarks: $voidRemarks', NOW())");
    
   
    header("Location: ../admin/employeeLists.php");
}

// Accountability Ref Deletion

if(isset($_GET['name']) || isset($_GET['acctRef'])) {
    // $refId = mysqli_real_escape_string($db->conn, $_GET['Acct_id']); // refId from reference tbl
    $refNo = mysqli_real_escape_string($db->conn, $_GET['acctRef']); // refId from reference tbl
    $empName = mysqli_real_escape_string($db->conn, $_GET['name']);

    $query = "SELECT a.id, a.assettag, r.assetId, r.name, r.turnoverRef, r.accountabilityRef 
              FROM assets_tbl AS a 
              LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
              WHERE r.accountabilityRef='$refNo' AND r.name='$empName'";
    $result =  mysqli_query($db->conn, $query);
    
    while($row = mysqli_fetch_assoc($result)) {
        $accountabilityRef = $row['accountabilityRef'];
        $turnoverRef = $row['turnoverRef'];
        $assetTags[] = $row['assettag'];
    }

    // $updateQuery = mysqli_query($db->conn, "UPDATE reference_tbl 
    //                                 SET accountabilityRef='',
    //                                     accountabilityFile='',
    //                                     accountabilityStatus=0,
    //                                     accountabilityDate='',
    //                                     referenceStatus=0 
    //                                 WHERE id = '$id'");

    $refQry = mysqli_prepare($db->conn, "UPDATE reference_tbl 
                                        SET accountabilityRef='',
                                            accountabilityFile='',
                                            accountabilityStatus=0,
                                            accountabilityDate='',
                                        WHERE accountabilityRef=?
                                        AND name=?");
        mysqli_stmt_bind_param($refQry, "ss", $refNo, $empName);
        mysqli_stmt_execute($refQry);
    // $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
    //                         VALUES ('', '$name', 'Deleted Accountability reference for asset tags: $assetTags[]', NOW())");

    if($refQry) {
        $history = mysqli_prepare($db->conn, "INSERT INTO history_tbl (name, action, date) VALUES (?, ?, NOW())");
        $name = $user['username'];
        $action = "Deleted Accountability reference for assets: " . implode(", ", $assetTags);
            mysqli_stmt_bind_param($history, "ss", $name, $action);
            mysqli_stmt_execute($history);
    } else {
        echo "failed updating";
        die(); 
    }
    

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
    
    $name = $user['username'];
    $sql = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                            VALUES ('', '$name', 'Removed employee: $empName', NOW())");

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