<?php 
include '../inc/auth.php'; 

if(isset($_POST['submit'])) {

    $result = $addItems->addLocation($_POST['name']);
    $locName = $_POST['name'];
    
    if($result == 1) {
        echo "<script> alert('Registration Successful'); </script>";
        $history = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                VALUES ('', '$username', 'Added a location: $locName', NOW())");
    }
    elseif($result == 10) {
        echo "<script> alert('This Division already exists'); </script>";
    }
    elseif($result == 100) {
        echo "<script> alert('Something went wrong'); </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/styles.css"> -->
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/fields.css">
    <title>Add Location</title>
</head>
<body>
    <div class="container">
        <div class="add-form">
            <a href="../admin/location_List.php" class="return">Back</a>
            
            <form action="" method="POST" autocomplete="off">
                <div class="title">Add Location</div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">Location Name:</span>
                        <input type="text" name="name" style="width: 150%;"/>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="submit" value="Save">
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>