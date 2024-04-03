<?php 
include '../inc/auth.php';
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

    if(isset($_GET['id']) && $_GET['id'] != '') {
        $eid = $_GET['id'];

        $sql = "SELECT a.id AS aId, a.empId, a.status, a.assettype, a.assettag, a.model, a.remarks, 
                a.cpu, a.memory, a.storage, a.dimes, a.mobile, a.plan, a.os, 
                e.id, e.name AS ename, e.empStatus, e.division, e.location, r.assetId, r.name, 
                r.accountabilityRef AS accountabilityRef, r.turnoverRef AS turnoverRef 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE e.id='$eid' AND a.status!='Archive'";
        // $sql = "SELECT DISTINCT e.name AS ename, a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.status, a.datepurchased, a.empId, 
        //         a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
        //         e.id, e.division, e.location, e.empStatus, 
        //         r.assetId, r.accountabilityRef AS accountabilityRef, r.turnoverRef AS turnoverRef 
        //         FROM employee_tbl AS e 
        //         LEFT JOIN assets_tbl AS a ON a.empId = e.id 
        //         LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
        //         WHERE a.status!='Archive' AND e.id='$eid'";
        $results = mysqli_query($db->conn, $sql);
        $rowCount = $results->num_rows;
        $rows = [];
        while ($row = mysqli_fetch_assoc($results)) {
            $rows[] = $row;
        }

        foreach ($rows as $row) :
            $name = $row['ename'];
            $dept = $row['division'];
            $location = $row['location'];
        endforeach;
?>       
<div class="content">
    <main class="table" id="customers_table">
    <form method='post'>  

        <section class="table__header">
            <div class="btn">
                <button type="submit" formaction="../admin/accountability.php" class="link-btn" onclick="return checkPrompt()">Generate Acc</button>
                <button type="submit" formaction="../admin/turnover.php" class="link-btn" onclick="return checkPrompt()">Generate Turnover</button>
            </div>

            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="../assets/icons/search.png" alt="">
            </div>
        </section>
            <h1 style='width: 20%; padding: 0 .5em; margin: 0 .4em; border-radius: 1em; background-color: #ddd; color: black; '> </h1>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th colspan=3 style='background:white; color: black; pointer-events: none;'>
                        <strong><?php echo $name; ?></strong><br>
                            <i><?php echo $dept; ?><br>
                            <?php echo $location; ?>
                        </th>
                        <th colspan=2 style='background:white; color: black; pointer-events: none;'>
                        <p><h1 style='color:#2E4583; font-size: 2em;'>~<strong><?php echo $rowCount; ?> </strong></h1>accountabilities</p>
                        </th>
                    </tr>
                    <tr>
                        <th width="1%"><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                        <th width='60%;'> Assets <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Accountability Code <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Turnover Code <span class="icon-arrow">&UpArrow;</span></th>
                        <th width='10%'> Action <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>          
                    <?php
                        foreach ($rows as $row) {
                            $aId = $row['aId'];
                            $status = $row['empStatus'];
                    ?>
                    <tr>
                        <td><input type="checkbox" id="select" name="select[]" value="<?php echo $aId; ?>"></td>
                        <td>
                            <strong><?php echo $row['assettag']; ?></strong><br>
                            <?php echo $row['cpu']; ?><br>
                            <?php echo $row['memory']; ?><br>
                            <?php echo $row['storage']; ?><br>
                            <?php echo $row['dimes']; ?>
                        </td>
                        <td><?php echo $row['accountabilityRef']; ?></td>
                        <td><?php echo $row['turnoverRef']; ?></td>
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

                        <td>
                            <!-- <a href="../update/assetUpd.php?id=?php echo $aId; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp; -->
                            <?php
                                if($row['turnoverRef'] != '') {
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
        <!-- </form> -->
        </section>      
    </form>
    </main> 
    <script src="../js/sort.js"></script>

</div>
<?php } else {
        header('Location: ../admin/configuration.php');
} ?>

</body>
</html>