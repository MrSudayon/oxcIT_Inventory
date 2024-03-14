<?php
require '../php/db_connection.php';
$asset = new assetsController;

if(isset($_POST['update-asset'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);
    $input = [
        'assettype' => mysqli_real_escape_string($db->conn,$_POST['asset-type']),
        'assettag' => mysqli_real_escape_string($db->conn,$_POST['asset-tag']),
        'model' => mysqli_real_escape_string($db->conn,$_POST['model']),
        'serial' => mysqli_real_escape_string($db->conn,$_POST['serial']),
        'supplier' => mysqli_real_escape_string($db->conn,$_POST['supplier']),
        'datepurchase' => mysqli_real_escape_string($db->conn,$_POST['dateprchs']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
        'remarks' => mysqli_real_escape_string($db->conn,$_POST['remarks']),

        'cpu' => mysqli_real_escape_string($db->conn,$_POST['processor']),
        'ram' => mysqli_real_escape_string($db->conn,$_POST['memory']),
        'storage' => mysqli_real_escape_string($db->conn,$_POST['storage']),
        'os' => mysqli_real_escape_string($db->conn,$_POST['os']),
        'others' => mysqli_real_escape_string($db->conn,$_POST['other']),
        'datedeployed' => mysqli_real_escape_string($db->conn,$_POST['datedeployed']),

        'assigned' => mysqli_real_escape_string($db->conn,$_POST['assigned']),
        'turnover' => mysqli_real_escape_string($db->conn,$_POST['turnover']),
        'lastused' => mysqli_real_escape_string($db->conn,$_POST['lastused']),

        'provider' => mysqli_real_escape_string($db->conn,$_POST['provider']),
        'mobile' => mysqli_real_escape_string($db->conn,$_POST['mobile']),
        'plan' => mysqli_real_escape_string($db->conn,$_POST['plan']),
    ];
    $result = $asset->update($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/dashboard.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/dashboard.php';
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
        'reason' => mysqli_real_escape_string($db->conn,$_POST['reason']),
        'ref_code' => mysqli_real_escape_string($db->conn,$_POST['ref_code']),
    ];
    $result = $asset->assetTurnover($input, $id);

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
    $result = $asset->empUpdate($input, $id);

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
    $result = $asset->assetItemUpdate($input, $id);

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
    $result = $asset->divisionUpdate($input, $id);

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
    $result = $asset->locationUpdate($input, $id);

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
$newFileName = null;
if(isset($_POST['update-reference'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['id']);
    if (isset($_FILES['acctfile']) && $_FILES['acctfile']['error'] === UPLOAD_ERR_OK) {
  
        // uploaded file details
    
        $fileTmpPath = $_FILES['acctfile']['tmp_name'];
    
        $fileName = $_FILES['acctfile']['name'];
    
        $fileSize = $_FILES['acctfile']['size'];
    
        $fileType = $_FILES['acctfile']['type'];
    
        $fileNameCmps = explode(".", $fileName);
    
        $fileExtension = strtolower(end($fileNameCmps));
        
        $uploaddir = '../files/accountability/';
        
        // removing extra spaces
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
        // file extensions allowed
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
    
        if (in_array($fileExtension, $allowedfileExtensions)) {
    
            // directory where file will be moved
            $uploadfile = $uploaddir . basename($_FILES['acctfile']['name']);
    
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                ?>
                    <script>
                        alert("File uploaded successfully");
                    </script>	
                <?php

            } else {
                $message = 'An error occurred while uploading the file to the destination directory. Ensure that the web server has access to write in the path directory.';
            }
    
        } else {
            $message = 'Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions);
        }
  
    }
    

    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'acctStatus' => mysqli_real_escape_string($db->conn,$_POST['acctStatus']),
        'acctDate' => mysqli_real_escape_string($db->conn,$_POST['acctDate']),
        // 'acctFile' => $newFileName,

        'trnStatus' => mysqli_real_escape_string($db->conn,$_POST['trnStatus']),
        'trnDate' => mysqli_real_escape_string($db->conn,$_POST['trnDate']),
        // 'trnFile' => $trnFile,
    ];
    $acctFile = $newFileName;
    $trnFile = $newFileName;

    $result = $asset->updateReference($input, $id, $acctFile, $trnFile);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/references.php';
        </script>";
        // die();

    } else {
        echo "<script>
        alert('⚠️Update Error');
        </script>";
        die();
    }
}
?>