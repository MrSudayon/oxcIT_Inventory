<?php
// Get the selected value from the AJAX request
$selectedValue = $_GET['value'];

// Process the selected value (you can perform any server-side processing here)
$output = 'You selected: ' . $selectedValue;

// Return the output
echo $output;
?>
