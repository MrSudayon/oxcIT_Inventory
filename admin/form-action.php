<?php
    if(isset($_POST["accountability"])){
        header("Location: accountability.php");
    }
    if(isset($_POST["turnover"])) {
        header("Location: turnover.php");
    }
?>