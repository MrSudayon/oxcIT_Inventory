
$(document).ready(function() {
    $('#addAssetForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send form data using AJAX
        $.ajax({
            type: 'POST',
            url: '../admin/admin_action.php', // Update the URL with the correct endpoint for the current page
            data: formData,
            success: function(response) {
                $('#addAssetForm').replaceWith(response); // Replace first form with second form
            },
            error: function(xhr, status, error) {
                alert('Failed to store data!');
            }
        });
    });
});
function removeVowels(str) {
    // Use a regular expression to replace vowels (both upper and lower case) with an empty string
    return str.replace(/[aeiouEI]/g, '');
}

const categoryIncrementMap = {
    "Laptop": 1,
    "Monitor": 1,
    "Printer": 1,
    "Mobile": 2,
    "UPS": 1,
    "AVR": 2
};
let i = 1;

function handleCategorySelection(category) {
    // Check if the category exists in the mapping
    if (category in categoryIncrementMap) {
        // Increment the counter based on the selected category
        i += categoryIncrementMap[category];
    } else {
        // If category is not found, default to 1
        i = 1;
    }
    // Output the updated value of i
    console.log("Current value of i:", i);
}

function displaySelectedValue() {
    // Get the select element
    var selectElement = document.getElementById("Type");

    var status = document.getElementById("status");
    var repair = document.getElementById("repair-cost");

    // var selectElement = document.getElementById("Type");
    var serial = document.getElementById("serial");
    var mobile = document.getElementById("mobile");
    var model = document.getElementById("model");
    var provider = document.getElementById("provider");
    // var processor = document.getElementById("processor");
    // var plan = document.getElementById("plan");
    if (status.value == "For repair") {
        repair.style.display = "block";
    } else {
        repair.style.display = "none";
    }

    if(selectElement.value == "SIM") {
        serial.style.display = "none";
        model.style.display = "none";
        // processor.style.display = "none";

        mobile.style.display = "block";
        provider.style.display = "block";
        // plan.style.display = "block";
    } else {
        serial.style.display = "block";
        model.style.display = "block";
        // processor.style.display = "block";

        mobile.style.display = "none";
        provider.style.display = "none";
        // plan.style.display = "none";
    }


    // Get the selected value
    var selectedValue = selectElement.options[selectElement.selectedIndex].value;
    var asset = removeVowels(selectedValue);
    var assetTag = asset.toUpperCase();

    // Display the selected value in the output display
    document.getElementById("tag").innerText = assetTag;
    
    // var assigned = document.getElementById("assigned").value;
    // var selectedEmp = assigned.options[assigned.selectedIndex].value;

    // document.getElementById("division").innerText = selectedEmp;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.getElementById("tag").innerText = response.data;
            assetTagItem = response.data;
        }
    };
    // xhr.open("GET", "getData.php?id=" + selectedEmp, true);
    xhr.send();
}

function changetextbox() {
    
}

function passValue() {
    var divValue = document.getElementById("tag").innerText;

    // Set the value of the input field
    document.getElementById("asset-tag").value = divValue;
}
