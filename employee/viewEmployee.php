<?php 
include '../inc/auth.php';
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

if(isset($_GET['id']) && $_GET['id'] != '') {
    $eid = $_GET['id'];
    $rows = [];

    // Separate selected Employee
    $sqlSelectEmp = "SELECT * FROM employee_tbl WHERE id='$eid' AND empStatus='1'";
    $sqlResult = mysqli_query($db->conn, $sqlSelectEmp);
    if($sqlResult) {
        while($row = mysqli_fetch_assoc($sqlResult)) {
            $rows[] = $row;
        }
        foreach($rows as $row) {
            $empId = $row['id'];
            $name = $row['name'];
            $dept = $row['division'];
            $location = $row['location'];
        }
    } else {
        echo 'no selected. where the employee?';
        die();
    }

    $sql =
        "SELECT DISTINCT a.id AS aId, a.empId, a.assettype, a.assettag, a.status, 
        a.cpu, a.memory, a.storage, a.os, a.dimes, a.plan, a.mobile, 
        r.name, r.accountabilityRef, r.turnoverRef 
        FROM assets_tbl AS a 
        LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
        WHERE a.empId='$eid' AND a.status!='Archive'"; 

    $results = mysqli_query($db->conn, $sql);
    $rowCount = $results->num_rows;
}
?>       
<div class="content">
<form method="get" action="../generateCode/generate.php">
    <main class="table" id="customers_table">
            <section class="table__header">
                <div class="btn">
                <a href="../admin/employeeLists.php" class="link-btn">Back</a>
                <!-- <button type="submit" formaction="../admin/accountability.php" class="link-btn" onclick="return checkPrompt()">Generate Acc</button> -->
                <button type="submit" name="generateAcc" class="link-btn" onclick="return checkPrompt()">Generate Accountability</button>
                <button type="submit" name="generateTrn" class="link-btn" onclick="return checkPrompt()">Generate Turnover</button>

                    <!--<button type="submit" class="link-btn" name="generateAcc" onclick="return checkPrompt()">Generate Acc</button>
                    <button type="submit" class="link-btn" name="generateTurnover" onclick="return checkPrompt()">Generate Turnover</button> -->
                </div>

                <div class="input-group">
                    <input type="search" placeholder="Search Data...">
                    <img src="../assets/icons/search.png" alt="">
                </div>
            </section>

            <section class="table__body">
                <h1 style='width: 20%; padding: 0 .5em; margin: 0 .4em; border-radius: 1em; background-color: #ddd; color: black; '></h1>
                <table>
                    <thead>
                        <tr>
                            <th colspan=3 style='background:white; color: black; pointer-events: none;'>
                                <strong><?php echo $name; ?></strong><br>
                                <i><?php echo $dept; ?><br>
                                <?php echo $location; ?>
                            </th>
                            <th colspan=2 style='background:white; color: black; pointer-events: none;'>
                                <p><h1 style='color:#2E4583; font-size: 2em;'>~<strong><?php echo $rowCount; ?></strong></h1>accountabilities</p>
                            </th>
                        </tr>
                        <tr>
                            <th width="2%"><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                            <th width='60%;'> Assets <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Accountability Code <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Turnover Code <span class="icon-arrow">&UpArrow;</span></th>
                            <th width='10%'> Action <span class="icon-arrow">&UpArrow;</span></th>
                        </tr>
                    </thead>
                    <tbody>          
                        <?php
                            while ($row = mysqli_fetch_assoc($results)) {

                                $aId = $row['aId'];
                                $assettype = $row['assettype'];
                                $assettag = $row['assettag'];
                                
                                $cpu = $row['cpu'];
                                $ram = $row['memory'];
                                $storage = $row['storage'];
                                $os = $row['os'];
                                $dimes = $row['dimes'];
                                $plan = $row['plan'];
                                $mobile = $row['mobile'];

                                $accountabilityRef = $row['accountabilityRef'];
                                $turnoverRef = $row['turnoverRef'];

                                $specification = $operation->specificationCondition($aId);

                        ?>
                            <tr>
                                <td><input type="checkbox" id="select" name="select[]" value="<?php echo $aId; ?>"></td>
                                <td>
                                    <strong><?php echo $assettag; ?></strong><br><br>
                                    <?php echo $specification; ?>
                                </td>
                                <td><?php echo $accountabilityRef; ?></td>
                                <td><?php echo $turnoverRef; ?></td>
                                <td>
                                    <?php
                                    if($turnoverRef != '') {
                                    ?>
                                        <a href="../update/turnoverUpd.php?id=<?php echo $aId; ?>"><img src="../assets/icons/turnover.png" width="32px"></a>&nbsp;
                                    <?php
                                    }
                                    ?>
                                    <a href="../update/remove.php?assetID=<?php echo $aId; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="32px"></a>
                                </td>   
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>      
    </main> 
</form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var spans = document.getElementsByClassName("statusSpan");
    for (var i = 0; i < spans.length; i++) {
        var span = spans[i];
        if (span.innerHTML === '1') {
            span.innerText = 'Active'; // Use innerText or textContent to update the text
            span.classList.add("status", "delivered");
        } else if (span.innerHTML === '0') {
            span.innerText = 'Inactive';
            span.classList.add("status", "cancelled");
        }
    }
});
</script>

</body>
</html>