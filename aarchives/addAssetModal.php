    <a href="../admin/dashboard.php" class="return">Back</a>
    <form method="POST" id="addAssetForm">
        <div class="title">Asset Details</div>
        <div class="asset-details">
            <div class="input-box">
                <span class="details">Asset Type</span>                            
                <select name="asset-type" id="Type" required="required" onchange="displaySelectedValue();">
                <!-- <select name="asset-type" id="Type" onChange="changetextbox();displaySelectedValue();"> -->
                    <option value="">Please Select</option>
                    <?php
                        $category = new Operations;
                        $assettype = $category->getAssets();

                        foreach($assettype as $assets) {
                    ?>
                        <option value="<?=$assets['assetType']?>"><?php echo $assets['assetType']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
                
            <div class="input-box">
                <span class="details">Asset Tag</span>
                <div class="asset-tag" id="tag" style="background-color: #ccc;"></div>
                <input type="text" name="asset-tag" id="asset-tag" hidden>
                <!-- <input type="text" name="asset-tag" placeholder="Asset Tag" id="Tag" > -->
            </div>
            <div class="input-box" id="model">
                <span class="details">Model</span>
                <input type="text" name="model" placeholder="Model" id="">
            </div>
            <div class="input-box" id="provider" style="display: none;">
                <span class="details">Provider</span>
                <input type="text" name="provider" placeholder="Provider" id="">
            </div>
            
            <div class="input-box" id="serial">
                <span class="details">Serial no.</span>
                <input type="text" name="serial" placeholder="Serial Number" id="">
            </div>
            <div class="input-box" id="mobile" style="display: none;">
                <span class="details">Mobile no.</span>
                <input type="text" name="mobile" placeholder="Mobile no." id="">
            </div>

            <div class="input-box">
                <span class="details">Supplier</span>
                <input type="text" name="supplier" placeholder="Supplier" id="">
            </div>
            <div class="input-box">
                <span class="details">Cost</span>
                <input type="text" name="cost" placeholder="Item cost.." id="">
            </div>
            
            <div class="input-box">
                <span class="details">Date Purchased</span>
                <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
            </div>
            <div class="input-box">
                <span class="details" style="margin-bottom: 10px;">Status</span>
                <select name="status" id="status" onChange="changetextbox()" require>
                    <option value="">Please select</option>
                    <option value="For repair">For repair</option>
                    <option value="Deployed">Deployed</option>
                    <option value="To be Deploy">To be deploy</option>
                    <option value="Deffective">Defective</option>
                    <option value="Sell">Sell</option>
                </select>
            </div>
            <div class="input-box" id="repair-cost" style="display: none;">
                <span class="details">Repair Cost</span>
                <input type="text" name="repair-cost" value="" placeholder="Repair Cost...">
            </div>
            <div class="input-box">
                <span class="details">Remarks</span>
                <input type="text" name="remarks" placeholder="Remarks" id="">
            </div>
        </div>

        <div class="button">
            <input type="hidden" name="assetId" id="assetId" value=""/>
            <input type="hidden" name="action" id="action" value="saveAssetDetails" />		
            <input type="submit" onclick="passValue()" id="next" name="next" value="Next" />
        </div>
    </form>



    <form method="POST" id="specsAssetForm" style="display: none;">
        <div class="title ">Specification</div>
        <div class="asset-details">
            <div class="input-box">
                <span class="details">Processor</span>
                <input type="text" name="processor" placeholder="Processor" id="">
            </div>
            <div class="input-box">
                <span class="details">Memory</span>
                <input type="text" name="memory" placeholder="Memory" id="">
            </div>
            <div class="input-box">
                <span class="details">Storage</span>
                <input type="text" name="storage" placeholder="Storage" id="">
            </div>
            <div class="input-box">
                <span class="details">Operating System</span>
                <input type="text" name="os" placeholder="Operating System" id="">
            </div>
            <div class="input-box">
                <span class="details">Others</span>
                <input type="text" name="other" placeholder="Others" id="">
            </div>
            <div class="input-box">
                <span class="details">Date Deployed</span>
                <input type="date" name="datedeployed" placeholder="Date Deployed" value="" id="datedeployed">
            </div>
        </div>
        <div class="button">
            <input type="hidden" name="assetId" id="assetId" value=""/>

            <input type="hidden" name="action" id="action" value="saveAssetFinal" />		
            <input type="submit" value="Save" id="save" name="save"/>
        </div>
    </form>
