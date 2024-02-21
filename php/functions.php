<?php

// include_once '../php/db_connection.php';

$db = new Connection();
$select = new Select();
class Operations {
    function record_Data($type, $tag, $mdl, $srl, $spplr, $dtprchs, $stts, $rmrks, $cpu, $ram, $storage, $os, $others, $datedeployed, $assigned, $turnover, $lastused) {
        global $db;
        global $select;
        // $specification = $cpu . ", " . $ram . ", " . $storage . ", " . $os . ", " . $others;  
        $session = $select->selectUserById($_SESSION['id']);
        $name = $session['username'];

        $sql = mysqli_query($db->conn,"SELECT * FROM employee_tbl WHERE name = '$assigned'");

        while($row = $sql->fetch_assoc()) {
            $dept = $row['division'];
            $location = $row['location'];
        }
        $lastused = $assigned;
        $query = "INSERT INTO assets_tbl (id, department, assettype, assettag, model, serial, supplier, CPU, MEMORY, STORAGE, OS, Others, assigned, lastused, status, location, datepurchased, remarks, datedeployed, dateturnover)
                                VALUES ('','$dept','$type','$tag','$mdl','$srl','$spplr','$cpu','$ram','$storage','$os','$others','$assigned','$lastused','$stts','$location','$dtprchs','$rmrks','$datedeployed','$turnover')";

        $result = mysqli_query($db->conn, $query);

        if($result) { 
            mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                                VALUES('', '$name', 'Added a new Asset Data' , NOW())");
            return 1; //Success
        } else {
            return 10; //Store Failed
        }
    }


    function getAllData() {
        global $db;

        $query = "SELECT * FROM assets_tbl WHERE status!='Archive'";
        $res = mysqli_query($db->conn, $query);

        return $res;

        mysqli_free_result($res);
        $db->conn->close();

    }

    function getAssets() {
        global $db;
        $sql = "SELECT * FROM category_tbl WHERE status='1'";
        $res = mysqli_query($db->conn, $sql);

        return $res;
    }
    function searchData() {
        global $db;
        global $res;

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM assets_tbl WHERE status!='Archive' AND (assigned LIKE '$search' OR department LIKE '%$search%'
            OR assettype LIKE '%$search%' OR status LIKE '%$search%' OR location LIKE '%$search%'
            OR assettag LIKE '%$search%' OR model LIKE '%$search%' OR CPU LIKE '%$search%' OR MEMORY LIKE '%$search%' OR STORAGE LIKE '%$search%'
             OR remarks LIKE '%$search%' OR Others LIKE '%$search%')";
            $res = mysqli_query($db->conn, $sql);
        
            return $res;
        } else {
            $sql = "SELECT * FROM assets_tbl WHERE status!='Archive'";
            $res = mysqli_query($db->conn, $sql);

            return $res;
        }
        mysqli_free_result($res);

        $db->conn->close();
    }

    function searchHistory() {
        global $db;

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM history_tbl WHERE name LIKE '%$search%' OR action LIKE '%$search%' OR date LIKE '%$search%' ";
            $res = mysqli_query($db->conn, $sql);
        
            return $res;
        } else {
            $sql = "SELECT * FROM history_tbl";
            $res = mysqli_query($db->conn, $sql);

            return $res;
        }

    }

    function getHistory() {
        global $db;

        $sql = "SELECT * FROM history_tbl";
        $res = $db->conn->query($sql);

        return $res;
    }

    function checkAssetCount($assettype) {
        global $db;

        
      
        // $sql = "SELECT COUNT(*) FROM assets_tbl WHERE assettype='$assettype'";
        // $count = mysqli_query($db->conn, $sql);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the selected asset type
            $selectedAssetType = $_POST['asset-type'];
        
            // Check if the asset tag already exists in the database
            $sql = "SELECT assettag FROM assets_tbl WHERE assettype = '$selectedAssetType'";
            $result = $db->conn->query($sql);
        
            if ($result->num_rows > 0) {
                // Asset tag exists, find the highest existing asset tag number and increment it
                $highestNumber = 0;
                while($row = $result->fetch_assoc()) {
                    $parts = explode('-', $row['assettag']);
                    $number = intval(end($parts));
                    if ($number > $highestNumber) {
                        $highestNumber = $number;
                    }
                }
                
                $nextAssetTag = $selectedAssetType . '-' . ($highestNumber + 1);
            } else {
                // Asset tag doesn't exist, use the asset tag as is
                $nextAssetTag = $selectedAssetType . '-1';
            }


            function removeVowelsAndToUpper($str) {
                // Remove vowels
                $strWithoutVowels = str_replace(['a', 'e', 'i', 'o', 'u', 'E', 'I', 'O'], '', $str);
                
                // Convert to uppercase
                $strToUpper = strtoupper($strWithoutVowels);
                
                return $strToUpper;
            }
            
            // Assign the next asset tag to the submitted form data
            $finalTag = removeVowelsAndToUpper($nextAssetTag);
            $_POST['asset-tag'] = $finalTag;
        }

    }
}



?>