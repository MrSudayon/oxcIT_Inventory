<?php include '../inc/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/config.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>index</title>
</head>
<body>
<?php include '../inc/header.php'; ?>
    
    <div class="content">
        <div class="config-buttons">
            <!-- <div class="config-btn"><a href="" title="All Asset"><img src="../assets/icons/config/dash.png"></a><br></div> -->
            <div class="config-btn"><a href="../assetLists/Laptop.php" title="Desktop"><img src="../assets/icons/config/laptop.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/Desktop.php" title="Desktop"><img src="../assets/icons/config/computer.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/Monitor.php" title="Desktop"><img src="../assets/icons/config/monitor.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/Printer.php" title="Printer"><img src="../assets/icons/config/printer.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/#.php" title="UPS/AVR"><img src="../assets/icons/config/UPS.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/#.php" title="Mobile"><img src="../assets/icons/config/mobile.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/#.php" title="Sim"><img src="../assets/icons/config/sim.png"></a><br></div>
        </div>
        <div class="config-buttons sub-config">
            <div class="sub-btn"></div>
            <div class="sub-btn"><a href="../admin/create_accountability.php" title="Accountability"><img src="../assets/icons/config/daily-tasks.png"></a></div>
            <div class="sub-btn"><a href="../admin/create_turnover.php" title="Turnover"><img src="../assets/icons/config/turnover.png"></a></div>
            <div class="sub-btn"><a href="../admin/references.php" title="Reference"><img src="../assets/icons/config/research.png"></a></div>
            <div class="sub-btn"></div>
        </div>
    </div>
    
    <script src="../js/dashboard.js"></script>
</body>
</html>