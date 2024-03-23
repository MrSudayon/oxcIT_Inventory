<?php 
include '../inc/auth.php'; 

$addItems = new AddItems();

if(isset($_POST['submit'])) {

    $result = $register->addEmployee($_POST['name'], $_POST['division'], $_POST['location']);
    $empName = $_POST['name'];

    if($result == 1) { 
        echo "<script> alert('Registration Successful'); </script>";
        $history = mysqli_query($db->conn, "INSERT INTO history_tbl (id, name, action, date)
                VALUES ('', '$username', 'Added empployee: $empName', NOW())");
    }
    elseif($result == 10) {
        echo "<script> alert('This Name already exists'); </script>";
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
    <title>Add Employee</title>
</head>
<body>
    <div class="container">
        <div class="add-form">
            <a href="../admin/emp_List.php" class="return">Back</a>
            
            <form action="" method="POST" autocomplete="off">
                <div class="title">Add Employee</div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">Name:</span>
                        <input type="text" name="name"/>
                    </div>

                    <!-- Link to dbase dept table -->
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Division:</span>
                        <select name="division" required>
                        <option value="">Please Select</option>

                        <?php
                            $getDept = $operation->getEmpDiv();
                            foreach($getDept as $row) {
                        ?>
                            <option value="<?php echo $row['name']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>

                    <!-- Link to dbase location table -->
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Location:</span>
                        <select name="location" required>
                        <option value="">Please Select</option>
                        <?php
                            $getLoc = $operation->getEmpLoc();
                            foreach($getLoc as $row) {
                        ?>
                            <option value="<?php echo $row['name']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                            <!-- <option value="Pasig">Pasig HO</option>
                            <option value="Mandaluyong">Mandaluyong</option>
                            <option value="Laguna">Laguna</option>
                            <option value="Cebu">Cebu</option>
                            <option value="Boracay">Boracay</option>
                            <option value="Davao">Davao</option> -->
                        <?php
                            }
                        ?>
                        </select>
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