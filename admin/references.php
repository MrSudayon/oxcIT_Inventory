<?php 
include '../inc/auth.php'; 
$referenceTbl = $operation->getReferenceTable();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/dashboard.js"></script>
    <script src="../js/addAssets.js"></script>
    <link rel="icon" href="../assets/logo.jpg">
    <title>Reference</title>
</head>
    <style>
        span.disable-btn {
            cursor: not-allowed;
            pointer-events: none;
            filter: grayscale(1);
        }
        span.disable-acctRef {
            pointer-events: all;
            filter: grayscale(0);
        }
        .link {
            color: black;
            font-weight: 600;
        }
        .link:hover {
            color: blue;
            transition: ease-in-out .2s;
            text-decoration: underline;
        }
    </style>
<?php include '../inc/header.php'; ?>

<div class="content">
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>REFERENCE</h1>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="../assets/icons/search.png" alt="">
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th width="15%">User</th>
                        <th>Accountability Ref</th>
                        <th width="10%">File</th>
                        <th width="5%">Status</th>
                        <th width="5%">Date</th>
                        <th width="2%"></th>

                        <th>Turnover Ref</th>
                        <th width="10%">File</th>
                        <th width="5%">Status</th>
                        <th width="5%">Date</th>
                        <th width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($row = mysqli_fetch_assoc($referenceTbl)) {
                        $rid = $row['rid'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $acctRef = $row['accountabilityRef']; 
                        $acctStatus = $row['accountabilityStatus']; 
                        $acctDate = $row['accountabilityDate'];
                        $acctFile = $row['accountabilityFile']; 
                        $turnoverRef = $row['turnoverRef'];
                        $turnoverStatus = $row['turnoverStatus']; 
                        $turnoverDate = $row['turnoverDate'];
                        $turnoverFile = $row['turnoverFile'];
                        $referenceStatus = $row['referenceStatus'];
                        $empId = $row['rname']; 

                        $qrySelect = "SELECT * FROM employee_tbl WHERE id='$empId'";
                        $result = mysqli_query($db->conn, $qrySelect);

                        while($row = mysqli_fetch_assoc($result)) {
                            $empName = $row['name'];
                        }
                        if($acctRef != '' || $turnoverRef != '') {

                            switch($acctStatus) {
                                case 1:
                                    $acctStatus = 'On Process';
                                    break;
                                case 2:
                                    $acctStatus = 'Signed';
                                    break;
                                default:
                                    $acctStatus = 'None';
                            }
                                
                            switch($turnoverStatus) {
                                case 1:
                                    $turnoverStatus = 'On Process';
                                    break;
                                case 2:
                                    $turnoverStatus = 'Signed';
                                    break;
                                default:
                                    $turnoverStatus = 'None';
                            }

                            $operation->ifEmptyReference($acctRef, $turnoverRef, $acctFile, $turnoverFile);

                            if($referenceStatus == 0) {
                                echo "<tr style='background-color: #fecfcc;'>";
                            } else {
                                echo "<tr>";
                            }
                    ?> 
                                <td><?php echo $empName; ?></td>
                                <td><a class="link" href="accountability.php?id=<?php echo $acctRef; ?>"><?php echo $acctRef;?></a></td>
                                <td width="10%;"><a class="link" href="../files/download.php?acctRef_id=<?php echo $rid; ?>" target="_blank"><?php echo $acctFile; ?></td>
                                <td><?php echo $acctStatus; ?></td>
                                <td><?php echo $acctDate; ?></td>
                                <td>
                                    <center>
                                        <?php if($acctStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/remove.php?Acct_id=<?php echo $rid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a></span>
                                        <?php } else { ?>
                                            <a href="../update/remove.php?Acct_id=<?php echo $rid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                                        <?php } ?>
                                    </center>
                                </td>

                                <td><a class="link" href="turnover.php?id=<?php echo $turnoverRef; ?>"><?php echo $turnoverRef;?></a></td>
                                <td width="10%;"><a class="link" href="../files/download.php?trnRef_id=<?php echo $rid; ?>" target="_blank"><?php echo $turnoverFile; ?></td>
                                <td><?php echo $turnoverStatus; ?></td>
                                <td><?php echo $turnoverDate; ?></td>
                                <td>
                                    <center>
                                        <?php if($turnoverStatus == 'Signed' && $acctStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/referenceUpd.php?id=<?php echo $rid; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;</span>
                                        <?php } else { ?>
                                            <a href="../update/referenceUpd.php?id=<?php echo $rid; ?>&name=<?php echo $empName; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;
                                        <?php } ?>

                                        <?php if($turnoverStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/remove.php?Turnover_id=<?php echo $rid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a></span>
                                        <?php } else { ?>
                                            <a href="../update/remove.php?Turnover_id=<?php echo $rid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                                        <?php } ?>
                                        
                                    </center>
                                </td> 
                            </tr>       
                    <?php
                        }
                        } 
                    ?>           
                </tbody>             
            </table>
        </section>
    </main>

<script src="../js/sort.js"></script>
</div>
        
</body>
</html>