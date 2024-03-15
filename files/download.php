<?php
require '../php/db_connection.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
} else {
    header("Location: ../php/login.php");
}

if (isset($_GET['acctRef_id'])) {
    $id = $_GET['acctRef_id'];
    
    // fetch file to download from database
    $sql = "SELECT * FROM reference_tbl WHERE id=$id";
    $result = mysqli_query($db->conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../files/accountability/'.$file['acctFile'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        
        ob_clean();
        flush();
    
        // Output the file
        // print_r($filepath);
         // Flush system output buffer
        // Now update downloads count
        // $newCount = $file['downloads'] + 1;
        // $updateQuery = "UPDATE tblfiles SET downloads=$newCount WHERE id=$id";
        // mysqli_query($conn, $updateQuery);
        
        // $his = "INSERT INTO history_tbl (id,uName,uType,uAction,timedate)
        //         VALUES (null,'$sess_name','$sess_role','Downloads modules from $sub_code',NOW())";
        // mysqli_query($conn,$his);        
        
        header("Location: ../admin/references.php");
        exit();
    } else {
        print_r('File not found');
    }

}


if (isset($_GET['trnRef_id'])) {
    $id = $_GET['trnRef_id'];
    
    // fetch file to download from database
    $sql = "SELECT * FROM reference_tbl WHERE id=$id";
    $result = mysqli_query($db->conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../files/accountability/'.$file['trnRef_id'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        
        ob_clean();
        flush();
        header("Location: ../admin/references.php");
        exit();
    } else {
        print_r('File not found');
    }

}
?>