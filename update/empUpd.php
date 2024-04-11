<?php 
include '../inc/auth.php';
include '../inc/formHead.php'; 
include '../inc/header.php'; 
?>
<style>
.return {
    transition: all .3s;
    border: 1px solid white;
    padding: 5px 20px;
    border-radius: 15px;
    background-color: var(--sec-color);
    font-weight: 700;
}
.return:hover {
    background-color: white;
    border: 1px solid black;
    color: var(--main-color);
    transition: all .3s;
}

</style>


<div class="container">
    <div class="add-form">
        <a href="../admin/emp_List.php" class="return">Back</a>

        <div class="title">Employee Update</div>
        <?php
        if(isset($_GET['empID'])) {
            $empID = mysqli_real_escape_string($db->conn, $_GET['empID']);
            $asset = new assetsController;
            $getData = new Operations;
            $result = $asset->empEdit($empID);

            if($result) {
        ?>
            <form action="../admin/update-selected.php" method="POST">
                <div class="asset-details">
                    <input type="hidden" name="empID" value="<?=$result['id']?>">

                    <div class="input-box">
                        <span class="details">Name</span>
                        <input type="text" name="name" value="<?=$result['name']?>" required>
                    </div>
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Division</span>
                        <select name="division">
                            <option value="<?=$result['division']?>"><?=$result['division']?></option>
                            <?php
                                
                                $emp = $getData->getEmpDiv();

                                foreach($emp as $empDiv) {
                            ?>
                                <option value="<?=$empDiv['name']?>"><?php echo $empDiv['name']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Location</span>
                        <select name="location">
                            <option value="<?=$result['location']?>"><?=$result['location']?></option>
                            <?php
                                $emp = $getData->getEmpLoc();

                                foreach($emp as $empLoc) {
                            ?>
                                <option value="<?=$empLoc['name']?>"><?php echo $empLoc['name']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Status</span>
                        <select name="status">
                        <?php
                            $status = $result['status'];
                            if($status == 1) {
                        ?>
                            <option value="<?=$result['status']?>">Active</option>
                            <option value="0">Inactive</option>
                        <?php
                            } else { 
                        ?> 
                            <option value="<?=$result['status']?>">Inactive</option>
                            <option value="1">Active</option>
                        <?php
                            }
                        ?>
                            
                        </select>
                    </div>
                    
                </div>
                <div class="button">
                    <input type="submit" value="Update" name="updateEmp"/>
                </div>
            </form>
            <?php
                }
            }
            ?>
    </div>
</div>
</body>
</html>