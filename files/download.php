<?php
include '../inc/auth.php';
    
if (isset($_GET['acctRef_id'])) {
    $id = $_GET['acctRef_id'];
    
    // fetch file to download from database
    $sql = "SELECT * FROM reference_tbl WHERE id = '$id'";
    $result = mysqli_query($db->conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = './accountability/'.$file['accountabilityFile'];

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

        mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$name', 'Downloaded file from reference id: $refId' , NOW())");

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
    $filepath = '../files/accountability/'.$file['turnoverFile'];

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
        mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
            VALUES('', '$name', 'Downloaded file from reference id: $refId' , NOW())");
            
        header("Location: ../admin/references.php");
        exit();
    } else {
        print_r('File not found');
    }

}
?>