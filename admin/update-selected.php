<?php
include '../inc/auth.php';

if(isset($_POST['update-asset'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);

    if(isset($_POST['action']) && $_POST['action'] == 'ComputerUpdate') {
        $action = mysqli_real_escape_string($db->conn,$_POST['action']);
        $input = [
            'model'        => mysqli_real_escape_string($db->conn,$_POST['model']),
            'serial'       => mysqli_real_escape_string($db->conn,$_POST['serial']),
            'supplier'     => mysqli_real_escape_string($db->conn,$_POST['supplier']),
            'cost'         => mysqli_real_escape_string($db->conn,$_POST['cost']),
            'datepurchase' => mysqli_real_escape_string($db->conn,$_POST['dateprchs']),
            'status'       => mysqli_real_escape_string($db->conn,$_POST['status']),
            'repair-cost'  => mysqli_real_escape_string($db->conn,$_POST['repair-cost']),
            'remarks'      => mysqli_real_escape_string($db->conn,$_POST['remarks']),

            'cpu'          => mysqli_real_escape_string($db->conn,$_POST['processor']),
            'ram'          => mysqli_real_escape_string($db->conn,$_POST['memory']),
            'storage'      => mysqli_real_escape_string($db->conn,$_POST['storage']),
            'os'           => mysqli_real_escape_string($db->conn,$_POST['os']),
            'datedeployed' => mysqli_real_escape_string($db->conn,$_POST['datedeployed']),

            'assigned'     => mysqli_real_escape_string($db->conn,$_POST['assigned']),
            'lastused'     => mysqli_real_escape_string($db->conn,$_POST['lastused'])
        ];
    } 
   
    $result = $assetController->update($action, $input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.history.back();
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.history.back();
        </script>";
        die();
    }
}


// Turnover Item
if(isset($_POST['turnover-asset'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);
    $input = [
        'turnover' => mysqli_real_escape_string($db->conn,$_POST['turnover']),
        'lastused' => mysqli_real_escape_string($db->conn,$_POST['lastused']),
        // 'reason' => mysqli_real_escape_string($db->conn,$_POST['reason']),
        'ref_code' => mysqli_real_escape_string($db->conn,$_POST['ref_code']),
    ];
    $result = $assetController->assetTurnover($input, $id);

    if ($result == 1) {
        echo "<script>
                alert('✅Turnover Successful');
                window.location.href='../admin/dashboard.php';
                </script>";
        die();
    } elseif($result == 100) {
        echo "<script>
                alert('⚠️Wrong reference code');
                window.location.href='../admin/dashboard.php';
                </script>";
        die();
    } 
}

// Update employee func
if(isset($_POST['updateEmp'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['empID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'division' => mysqli_real_escape_string($db->conn,$_POST['division']),
        'location' => mysqli_real_escape_string($db->conn,$_POST['location']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->empUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/emp_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/emp_List.php';
        </script>";
        die();
    }
}

// Update Asset item
if(isset($_POST['updateAssetItem'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetItemID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->assetItemUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/asset_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/asset_List.php';
        </script>";
        die();
    }
}

// Update division
if(isset($_POST['updateDivision'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['divisionID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->divisionUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/dept_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/dept_List.php';
        </script>";
        die();
    }
}

// Update location
if(isset($_POST['updateLocation'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['locationID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->locationUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/location_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/location_List.php';
        </script>";
        die();
    }
}

// Reference update
if(isset($_POST['update-reference'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['id']);
    $trnFileName = '';
    $accFileName = '';
    if (isset($_FILES['acctfile']) && $_FILES['acctfile']['error'] === UPLOAD_ERR_OK) {

        // uploaded file details
        $fileTmpPath = $_FILES["acctfile"]['tmp_name'];

        $accFileName = basename($_FILES["acctfile"]['name']);
        
        $fileSize = $_FILES['acctfile']['size'];
    
        $fileType = $_FILES['acctfile']['type'];
    
        $fileNameCmps = explode(".", $accFileName);
    
        $fileExtension = strtolower(end($fileNameCmps));
        
        $uploaddir = '../files/accountability/' . $_FILES['acctfile']['name'];
    
        // file extensions allowed
        $allowedfileExtensions = array('zip', 'pdf', 'jpg', 'pdf');
    
        if (in_array($fileExtension, $allowedfileExtensions)) {
            if($fileSize > 2000000) {
                echo "<script> alert('File too large'); window.history.back();</script>";
            } else {
                move_uploaded_file($fileTmpPath, $uploaddir);
            }
        } else {
            echo "<script> alert('Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions)'); window.history.back();</script>";
        }
    }

    if (isset($_FILES['trnfile']) && $_FILES['trnfile']['error'] === UPLOAD_ERR_OK) {

        // uploaded file details
        $fileTmpPath = $_FILES["acctfile"]['tmp_name'];

        $accFileName = basename($_FILES["acctfile"]['name']);
        
        $fileSize = $_FILES['acctfile']['size'];
    
        $fileType = $_FILES['acctfile']['type'];
    
        $fileNameCmps = explode(".", $accFileName);
    
        $fileExtension = strtolower(end($fileNameCmps));
        
        $uploaddir = '../files/accountability/' . $_FILES['acctfile']['name'];
    
        // file extensions allowed
        $allowedfileExtensions = array('zip', 'pdf', 'jpg', 'pdf');
    
        if (in_array($fileExtension, $allowedfileExtensions)) {
            if($fileSize > 2000000) {
                echo "<script> alert('File too large'); window.history.back();</script>";
            } else {
                move_uploaded_file($fileTmpPath, $uploaddir);
            }
        } else {
            echo "<script> alert('Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions)'); window.history.back();</script>";
        }
    }
    

    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'acctStatus' => mysqli_real_escape_string($db->conn,$_POST['acctStatus']),
        'acctDate' => mysqli_real_escape_string($db->conn,$_POST['acctDate']),
        'acctFile' => mysqli_real_escape_string($db->conn,$accFileName),

        'trnStatus' => mysqli_real_escape_string($db->conn,$_POST['trnStatus']),
        'trnDate' => mysqli_real_escape_string($db->conn,$_POST['trnDate']),
        'trnFile' => mysqli_real_escape_string($db->conn,$trnFileName),
    ];

   
    $result = $assetController->updateReference($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/references.php';
        </script>";
        die();

    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/references.php';
        </script>";
        die();
    }
}
?>