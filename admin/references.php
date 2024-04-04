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
<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/formStyles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Reference</title>
</head> -->
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
<body>

    
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
                        <th width="5%">Asset Type</th>
                        <th>Accountability Ref</th>
                        <th width="10%">File</th>
                        <th width="5%">Status</th>
                        <th width="5%">Date</th>
                        <th width="2%"></th>

                        <th width="5%">Asset Type</th>
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
                        $turnoverRef = $row['turnoverRef'];
                        $turnoverStatus = $row['turnoverStatus']; 
                        $turnoverDate = $row['turnoverDate'];
                        $name1 = $row['rname']; 

                        if($acctRef != '' || $turnoverRef != '') {
                            // 0 N/A
                            // 1 Process
                            // 2 Signed
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
                    ?> 
                        <tr>
                            <td><?php echo $name1; ?></td>

                            <?php 
                            if($acctRef == '') {
                                
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td>" . $acctStatus;"</td>";
                                echo "<td>" . $acctDate;"</td>";
                                echo "<td><span class='disable-btn'><img src='../assets/icons/remove.png' width='24px'></span></td>";
                            } else {               
                            ?>

                                <td><?php echo $assettag;?></td>
                                <td><a class="link" href="accountability.php?id=<?php echo $rid; ?>"><?php echo $acctRef;?></a></td>
                                <td width="10%;"><a class="link" href="../files/download.php?acctRef_id=<?php echo $rid; ?>" target="_blank"><?php echo $row['accountabilityFile']; ?></td>
                                <td><?php echo $acctStatus; ?></td>
                                <td><?php echo $row['accountabilityDate']; ?></td>
                                <td>
                                    <center>
                                        <?php if($acctStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/remove.php?Acct_id=<?php echo $rid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a></span>
                                        <?php } else { ?>
                                            <a href="../update/remove.php?Acct_id=<?php echo $rid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                                        <?php } ?>
                                    </center>
                                </td>
                            <?php
                            }
                            ?>
                            
                            <?php
                            if ($turnoverRef == '') {
                                echo "<td style='font-weight:600;'>N/A</td>";
                                echo "<td style='font-weight:600;'>N/A</td>";   
                                echo "<td style='font-weight:600;'>N/A</td>";   
                                echo "<td>" . $turnoverStatus;"</td>";
                                echo "<td>" . $turnoverDate;"</td>";   
                                if($turnoverStatus == 'Signed') {              
                                    echo "<td><center><span class='disable-btn'><a href='../update/referenceUpd.php?id=" . $rid . "'><img src='../assets/icons/update.png' width='24px'></a></span></center></td>";
                                } else {
                                    echo "<td><center><a href='../update/referenceUpd.php?id=" . $rid . "'><img src='../assets/icons/update.png' width='24px'></a></center></td>";
                                }
                            } else {
                            ?>
                                <td><?php echo $assettag;?></td>
                                <td><a class="link" href="turnover.php?id=<?php echo $rid; ?>"><?php echo $turnoverRef;?></a></td>
                                <td width="10%;"><a class="link" href="../files/download.php?trnRef_id=<?php echo $row['id']; ?>" target="_blank"><?php echo $row['turnoverFile']; ?></td>
                                <td><?php echo $turnoverStatus; ?></td>
                                <td><?php echo $turnoverDate; ?></td>
                                <td>
                                    <center>
                                        <?php if($turnoverStatus == 'Signed' && $acctStatus == 'Signed') { ?>
                                            <span class="disable-btn"><a href="../update/referenceUpd.php?id=<?php echo $rid; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;</span>
                                        <?php } else { ?>
                                            <a href="../update/referenceUpd.php?id=<?php echo $rid; ?>"><img src="../assets/icons/update.png" width="24px"></a>&nbsp;
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
                    }
                
                            ?>                        
                        
                </table>
        </section>
    </main>

<script src="../js/sort.js"></script>

</div>
        
</body>
</html>