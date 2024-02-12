<?php
require '../php/db_connection.php';
// require '../classes/functions.php';

$select = new Select();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
    if($user['role'] == 'admin') {
        $record = new Operations();

        if(isset($_POST['save'])) {
           
            $result = $record->record_Data($_POST['asset-type'], $_POST['asset-tag'], $_POST['model'], $_POST['serial'], $_POST['supplier'], $_POST['dateprchs'], $_POST['status'], $_POST['remarks'], $_POST['processor'], $_POST['memory'], $_POST['storage'], $_POST['os'], $_POST['other'], $_POST['datedeployed'], $_POST['assigned'], $_POST['department'], $_POST['location']);
        
            if($result == 1) {
                echo "<script> alert('Data Stored successfully!'); </script>";
                header("Refresh:0; url=add-assets.php");

            } elseif($result == 100) {
                echo "<script> alert('Failed'); </script>";
            }    
            
        }
    } else {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../php/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Add Assets</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../assets/logo.png" alt="logo" width="200px">
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="../php/register.php">Users</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <script>
    // Function to update the output div with the selected value
    function removeVowels(str) {
        // Use a regular expression to replace vowels (both upper and lower case) with an empty string
        return str.replace(/[aeiouAEIOU]/g, '');
    }

    function displaySelectedValue() {
        // Get the select element
        var selectElement = document.getElementById("Type");

        // Get the selected value
        var selectedValue = selectElement.options[selectElement.selectedIndex].value;
        var asset = removeVowels(selectedValue);
        var assetTag = asset.toUpperCase();

        var incrementalVal = 1;
        // Display the selected value in the output div
        for (var i = 1; i <= incrementalVal; i++) {
            var output = document.getElementById("Tag").innerText = assetTag + "-" + i;
        }
    }
    </script>
    <div class="container">
        <div class="add-form">
            <div class="title">Asset Details</div>
                <form action="" method="POST">
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Asset Type</span>
                            <!-- <input type="text" name="asset-type" placeholder="Asset Type" id="" required> -->
                            <select name="asset-type" id="Type" onchange="displaySelectedValue()" required>
                                <option value="">Please Select</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Monitor">Monitor</option>
                                <option value="Printer">Printer</option>
                                <option value="Mobile">Mobile</option>
                                <option value="UPS">UPS</option>
                                <option value="AVR">AVR</option>
                            </select>
                        </div>

                        <div class="input-box">
                            <span class="details">Asset Tag</span>
                            <div class="asset-tag" id="Tag"></div>
                            <!-- <input type="text" name="asset-tag" placeholder="Asset Tag" id="Tag" disabled > -->
                        </div>
                        <div class="input-box">
                            <span class="details">Model</span>
                            <input type="text" name="model" placeholder="Model" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Serial no.</span>
                            <input type="text" name="serial" placeholder="Serial Number" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Supplier</span>
                            <input type="text" name="supplier" placeholder="Supplier" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Date Purchased</span>
                            <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Status</span>
                            <select name="status">
                                <option value="To be Deploy">To be Deploy</option>
                                <option value="Deployed">Deployed</option>
                                <option value="Maintenance">For Repair</option>

                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Remarks</span>
                            <input type="text" name="remarks" placeholder="Remarks" id="">
                        </div>

                    </div>
                    <div class="title">Specification</div>
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" placeholder="Processor" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" placeholder="Memory" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" placeholder="Storage" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" placeholder="Operating System" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Others</span>
                            <input type="text" name="other" placeholder="Others" id="">
                        </div>
                        <div class="input-box">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" id="">
                        </div>
                    </div>
                    <div class="title">User Information</div>
                    <div class="asset-details">
                        <div class="input-box">
                            <span class="details">Assigned To</span>
                            <!-- <input type="text" name="assigned" placeholder="Assigned To" id="" required> -->
                            <select name="assigned" id="assigned" required class="assigned">
                                <?php
                                     $results = new get_All_User();

                                     $user = $results->selectAllUser();
                                     foreach($user as $row) {
                                ?>
                                <option value="<?php echo $row['username']; ?>">
                                    <?php echo $row['username']; ?>
                                </option>
                                <?php
                                    }
                                    
                                ?>
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Department</span>
                            <input type="text" name="department" placeholder="Department" id="" required>
                        </div>
                        <div class="input-box">
                            <span class="details">location</span>
                            <input type="text" name="location" placeholder="Location" id="">
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" value="Save" name="save"/>
                    </div>
                </form>
        </div>
    </div>
    
</body>
</html>