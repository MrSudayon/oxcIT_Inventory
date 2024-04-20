<?php include '../inc/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <!-- ICONS CDN FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Dashboard</title>
</head>
<?php include '../inc/header.php'; ?>

<div class="grid-container">


      <!-- Main -->
    <main class="main-container">
    <div class="main-title">
        <h2>DASHBOARD</h2>
    </div>

    <div class="main-cards">

        <div class="card">
        <div class="card-inner">
            <h3>ASSETS</h3>
            <span class="material-icons-outlined">inventory_2</span>
        </div>
        <h1>510</h1>
        </div>

        <div class="card">
        <div class="card-inner">
            <h3>DEPLOYED</h3>
            <span class="material-symbols-outlined">
deployed_code_account
</span>
        </div>
        <h1>333</h1>
        </div>

        <div class="card">
        <div class="card-inner">
            <h3>AVAILABLE</h3>
            <span class="material-icons-outlined">event_available</span>
        </div>
        <h1>76</h1>
        </div>

        <div class="card">
        <div class="card-inner">
            <h3>DEFECTIVE</h3>
            <span class="material-icons-outlined">notification_important</span>
        </div>
        <h1>30</h1>
        </div>

        <div class="card">
        <div class="card-inner">
            <h3>SELL</h3>
            <span class="material-icons-outlined">sell</span>
        </div>
        <h1>54</h1>
        </div>
    </div>

    <div class="charts">

        <div class="charts-card">
        <h2 class="chart-title">Top 5 Products</h2>
        <div id="bar-chart"></div>
        </div>

        <div class="charts-card">
        <h2 class="chart-title">Purchase and Sales Orders</h2>
        <div id="area-chart"></div>
        </div>

    </div>
    </main>
      <!-- End Main -->

    </div>

<!-- Scripts -->
<!-- ApexCharts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
<!-- Custom JS -->
<script src="../js/dashboard.js"></script>

</body>
</html>