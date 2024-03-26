<?php 
include '../inc/auth.php';
include '../inc/formHead.php'; 
include '../inc/header.php'; 
?>



<div class="container">
    <div class="add-form">
    <!-- <a href="../admin/dashboard.php" class="return">Back</a> -->
    <button onclick="history.back()" class="return">Go Back</button>

        <div class="title">Asset Details</div>
        <?php
        if(isset($_GET['id'])) {
            $assetID = mysqli_real_escape_string($db->conn, $_GET['id']);
            $result = $assetController->edit($assetID);

            if($result) {
                $assetType = $result['assettype'];
        ?>
            <form action="../admin/update-selected.php" method="POST">
                <div class="asset-details">
                    <input type="hidden" name="assetID" value="<?=$result['aId']?>">

                    <div class="input-box">
                        <span class="details">Asset Type</span>
                        <!-- <input type="text" name="asset-type" value="" id="" required> -->
                        <select id="Type" onChange="changetextbox(); displaySelectedValue();" style="background-color: #ccc;" readonly>
                            <option value="<?=$result['assettype']?>"><?=$result['assettype']?></option>
                            
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Asset Tag</span>
                        <div class="asset-tag" id="tag" style="background-color: #ccc;"><?=$result['assettag']?></div>
                        <input type="text" id="asset-tag" hidden>
                    </div>

                                            
                        <?php if($assetType == 'Laptop' || $assetType == 'Desktop' ) { ?>
                            
                            <div class="input-box" id="model">
                                <span class="details">Model</span>
                                <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                            </div>
                            
                            <div class="input-box" id="serial">
                                <span class="details">Serial no.</span>
                                <input type="text" name="serial" value="<?=$result['serial']?>" placeholder="Serial Number" id="">
                            </div>

                        <?php } elseif($assetType == 'Mobile') { ?>

                            <div class="input-box" id="model">
                                <span class="details">Model</span>
                                <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                            </div>
                            
                            <div class="input-box" id="serial">
                                <span class="details">Serial no.</span>
                                <input type="text" name="serial" value="<?=$result['serial']?>" placeholder="Serial Number" id="">
                            </div>
                            
                        <?php } elseif($assetType == 'Monitor' || $assetType == 'UPS' || $assetType == 'Printer' || $assetType == 'AVR') { ?>

                            <div class="input-box" id="model">
                                <span class="details">Model</span>
                                <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                            </div>
                            
                            <div class="input-box" id="serial">
                                <span class="details">Serial no.</span>
                                <input type="text" name="serial" value="<?=$result['serial']?>" placeholder="Serial Number" id="">
                            </div>

                        <?php } elseif($assetType == 'SIM') { ?>

                            <div class="input-box" id="mobile">
                                <span class="details">Mobile no.</span>
                                <input type="text" name="mobile" value="<?=$result['serial']?>" placeholder="Mobile no." id="">
                            </div>

                        <?php } else { ?>

                            <div class="input-box" id="model">
                                <span class="details">Model</span>
                                <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                            </div>
                            
                            <div class="input-box" id="serial">
                                <span class="details">Serial no.</span>
                                <input type="text" name="serial" value="<?=$result['serial']?>" placeholder="Serial Number" id="">
                            </div>

                        <?php } ?>

                    <div class="input-box">
                        <span class="details">Supplier</span>
                        <input type="text" name="supplier" value="<?=$result['supplier']?>" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Cost</span>
                        <input type="text" name="cost" value="<?=$result['cost']?>" id="">
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Date Purchased</span>
                        <input type="date" name="dateprchs" value="<?=$result['datepurchased']?>" id="" required>
                    </div>
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Status</span>
                        <select name="status" id="status" onChange="changetextbox()">
                            <option value="<?=$result['aStatus']?>"><?=$result['aStatus']?></option>
                            <option value="For repair">For repair</option>
                            <option value="Deployed">Deployed</option>
                            <option value="To be Deploy">To be deploy</option>
                            <option value="Defective">Defective</option>
                            <option value="Sell">Sell</option>
                            <option value="Missing">Missing</option>
                        </select>
                    </div>
                    <div class="input-box" id="repair-cost" style="display: none;">
                        <span class="details">Repair Cost</span>
                        <input type="text" name="repair-cost" value="<?=$result['repair_cost']?>" value="">
                    </div>
                    <div class="input-box">
                        <span class="details">Remarks</span>
                        <input type="text" name="remarks" value="<?=$result['remarks']?>" id="">
                    </div>

                </div>
                <div class="title">Specification</div>
                <div class="asset-details">

                    <?php if($assetType == 'Laptop' || $assetType == 'Desktop' ) { ?>

                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['cpu']?>" placeholder="Processor" id="">
                        </div>
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="os">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['os']?>" placeholder="Operating System" id="">
                        </div>

                    <?php } elseif($assetType == 'Mobile') { ?>

                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>

                    <?php } elseif($assetType == 'Monitor' || $assetType == 'UPS' || $assetType == 'Printer' || $assetType == 'AVR') { ?>

                        <div class="input-box" id="dimes">
                            <span class="details">Dimension</span>
                            <input type="text" name="dimes" value="<?=$result['dimes']?>" placeholder="Dimension" id="">
                        </div>

                    <?php } elseif($assetType == 'SIM') { ?>

                        <div class="input-box" id="plan">
                            <span class="details">Plan</span>
                            <input type="text" name="plan" value="<?=$result['plan']?>" placeholder="Plan" id="">
                        </div>

                    <?php } else { ?>
                    
                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['cpu']?>" placeholder="Processor" id="">
                        </div>          
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="os">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['os']?>" placeholder="Operating System" id="">
                        </div>
                        
                    <?php } ?>

                    <!-- <div class="input-box">
                        <span class="details">Others</span>
                        <input type="text" name="other" placeholder="Others" id="">
                    </div> -->
                    <div class="input-box" id="datedeployed" style="display: none;">
                        <span class="details">Date Deployed</span>
                        <input type="date" name="datedeployed" placeholder="Date Deployed" value="<?=$result['datedeployed']?>" id="">
                    </div>
                </div>
                <div class="title"></div>
                <div class="asset-details">
                    <div class="input-box">
                    <span class="details" style="margin-bottom: 10px;">Assigned To</span>
                        <select name="assigned" id="assigned" class="assigned">
                            <option value="<?=$result['ename']?>"><?=$result['ename']?></option>
                            <option value=''>Clear</option>
                            <?php
                                    $user = $getAllUser->selectAllEmp();
                                    foreach($user as $row) {
                            ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                        <!-- <input type="text" name="lastused" value=""> -->
                            <select name="lastused" id="lastused" class="assigned">
                                <option value="<?=$result['lastused']?>"><?=$result['lastused']?></option>
                                <option value=''>Clear</option>
                                <?php
                                    foreach($user as $row) {
                                ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php
                                    }
                                ?>
                            </select>
                    </div>
                </div>
                
                <div class="button">
                    <input type="hidden" value="ComputerUpdate" name="action"/>
                    <input type="submit" onclick="passValue()" value="Save" name="update-asset"/>
                </div>
            </form>
            <?php
                }
            }
            ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
</html>