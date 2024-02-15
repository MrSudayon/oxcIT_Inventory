function removeVowels(str) {
    // Use a regular expression to replace vowels (both upper and lower case) with an empty string
    return str.replace(/[aeiouEIO]/g, '');
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

    // Get the selected value
    var selectedValue = selectElement.options[selectElement.selectedIndex].value;
    var asset = removeVowels(selectedValue);
    var assetTag = asset.toUpperCase();

    // Display the selected value in the output display
    document.getElementById("tag").innerText = assetTag;


    var selectEmp = document.getElementById("assigned");
}

function changetextbox() {
    var status = document.getElementById("status");
    var datedeployed = document.getElementById("datedeployed");
    var assigned = document.getElementById("assigned");
    
    if (status.value == "Deployed") {
        datedeployed.disabled='';
        assigned.disabled='';
    } else {
        datedeployed.disabled='true';
        assigned.disabled='true';
    }
}

function passValue() {
    var divValue = document.getElementById("tag").innerText;

    // Set the value of the input field
    document.getElementById("asset-tag").value = divValue;
}
