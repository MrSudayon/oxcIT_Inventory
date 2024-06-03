<?php 
include '../inc/auth.php'; 
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

$accReferenceTbl = $operation->getAccReferenceTable();
$trnReferenceTbl = $operation->getTrnReferenceTable();
?>
<main class="table">

    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'Accountability')">Accountability</button>
        <button class="tablinks" onclick="openCity(event, 'Turnover')">Turnover</button>
    </div>
    
    <div id="Accountability" class="tabcontent">
        <section class="ref__table__header">
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="../assets/icons/search.png" alt="">
            </div>
        </section>
        <section class="ref__table__body">
            <table>
                <thead>
                    <tr>
                        <th width="15%">User</th>
                        <th>Accountability Ref #</th>
                        <th width="15%">File</th>
                        <th width="8%">Status</th>
                        <th width="10%">Date</th>
                        <th colspan='2' width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevAccRef = '';

                    while ($row = mysqli_fetch_assoc($accReferenceTbl)) {
                        $rid = $row['rid'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $acctRef = $row['accountabilityRef'];
                        $acctStatus = $row['accountabilityStatus'];
                        $acctDate = $row['accountabilityDate'];
                        $acctFile = $row['accountabilityFile'];

                        $referenceStatus = $row['referenceStatus'];
                        $empId = $row['rname'];

                        $qrySelect = "SELECT * FROM employee_tbl WHERE id='$empId'";
                        $result = mysqli_query($db->conn, $qrySelect);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $empName = $row['name'];
                        }

                        if ($acctRef != '') {
                            echo "<tr>";

                            $operation->ifEmptyAccReference($acctRef, $acctFile);

                            if ($acctRef != $prevAccRef) {
                               
                                echo "<td>$empName</td>";
                                echo "<td><a class='link' href='accountability.php?id=$acctRef'>$acctRef</a></td>";
                                echo "<td width='10%'><a class='link' href='../files/download.php?acctRef_id=$rid' target='_blank'>$acctFile</td>";
                                echo "<td><span class='documentStatus'>$acctStatus</span></td>";
                                echo "<td>$acctDate</td>";
                                echo "<td>";

                                if ($acctStatus == 'Signed') {
                                    echo "<span class='disable-btn'><a href='../update/referenceUpd.php?id=$rid'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?Acct_id=$rid' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a></span>";
                                } else {
                                    echo "<a href='../update/referenceUpd.php?acctRef=$acctRef&name=$empId'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?acctRef=$acctRef&name=$empId' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a>";
                                }
                                echo "</td>";
                                echo "</tr>";

                            } 
                            $prevAccRef = $acctRef;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <div id="Turnover" class="tabcontent hidden">
        <section class="ref__table__header">
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="../assets/icons/search.png" alt="">
            </div>
        </section>
        <section class="ref__table__body">
            <table>
                <thead>
                    <tr>
                        <th width="15%">User</th>
                        <th>Turnover Ref #</th>
                        <th width="15%">File</th>
                        <th width="8%">Status</th>
                        <th width="10%">Date</th>
                        <th width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevTrnRef = '';
                    while ($row = mysqli_fetch_assoc($trnReferenceTbl)) {
                        $rid = $row['rid'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $turnoverRef = $row['turnoverRef'];
                        $turnoverStatus = $row['turnoverStatus'];
                        $turnoverDate = $row['turnoverDate'];
                        $turnoverFile = $row['turnoverFile'];
                        $referenceStatus = $row['referenceStatus'];
                        $empId = $row['rname'];

                        $qrySelect = "SELECT * FROM employee_tbl WHERE id='$empId'";
                        $result = mysqli_query($db->conn, $qrySelect);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $empName = $row['name'];
                        }

                        if ($turnoverRef != '') {
                            
                            $operation->ifEmptyTrnReference($turnoverRef, $turnoverFile);

                            if($referenceStatus == 0 || $turnoverStatus == 'Signed') {
                                echo "<tr style='background-color: #fecfcc;'>";
                            } else {
                                echo "<tr>";
                            }

                            if ($turnoverRef != $prevTrnRef) {
                                if ($prevTrnRef != '') {
                                    echo "</tr>";
                                }
                                echo "<tr>";
                                echo "<td>$empName</td>";
                                echo "<td><a class='link' href='turnover.php?id=$turnoverRef'>$turnoverRef</a></td>";
                                echo "<td width='10%;'><a class='link' href='../files/download.php?trnRef_id=$rid' target='_blank'>$turnoverFile</td>";
                                echo "<td><span class='documentStatus'>$turnoverStatus</span></td>";
                                echo "<td>$turnoverDate</td>";
                                echo "<td>";
                                if ($turnoverStatus == 'Signed') {
                                    echo "<span class='disable-btn'><a href='../update/referenceUpd.php?Turnover_id=$rid'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?Turnover_id=$rid;' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a></span>";
                                    
                                } else {
                                    echo "<a href='../update/referenceUpd.php?Turnover_id=$rid&name=$empName'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?Turnover_id=$rid;' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a>";
                                }
                                echo "</td>";
                            } 
                            $prevTrnRef = $turnoverRef;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</main>
<script src="../js/sort.js"></script>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

</body>
</html> 
