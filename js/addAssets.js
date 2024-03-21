// $(document).ready(function() {

//     $('#addAssetForm').submit(function(event) {
//         event.preventDefault(); // Prevent default form submission

//         // Serialize form data
//         var formData = $(this).serialize();

//         // Send form data using AJAX
//         $.ajax({
//             type: 'POST',
//             url: 'admin_action.php',
//             data: formData,
//             success: function(response) {
//                 var assetId = response.id;
//                 $('#addAssetForm').hide(); // Hide asset details form
//                 $('#specsAssetForm').show(); // Show specification form
//                 $('#action').val('saveAssetDetails');
//                 $('#next').val('Nexxt');
//                 $('#assetId').val(assetId);
//                 console.log(formData);
//             },
//             error: function(xhr, status, error) {
//                 alert('Failed to store data!' + error, status, xhr);
//             }
//         });
//     });

//     $('#specsAssetForm').submit(function(event) {
// 		event.preventDefault(); // Prevent default form submission

// 		// Serialize form data
// 		var formData = $(this).serialize();

// 		// Send form data using AJAX
// 		$.ajax({
// 			type: 'POST',
// 			url: 'admin_action.php', // Update the URL with the correct endpoint for the current page
// 			data: formData,
// 			success: function(response) {
//                 console.log(formData);
//                 console.log(response);
// 				// die();
// 			},
// 			error: function(xhr, status, error) {
// 				alert('Failed to store data!' + error, status, xhr);
// 			}
// 		});
// 	});
// });

// $(document).ready(function() {

//     $('#addAssetForm').submit(function(event) {
//         event.preventDefault(); // Prevent default form submission
        
//         // Serialize form data
//         var formData = $(this).serialize();

//         // Send form data using AJAX
//         $.ajax({
//             type: 'POST',
//             url: '../admin/admin_action.php',
//             data: formData,
//             success: function(response) {
//                 var assetId = response.assetId;
//                 $('#addAssetForm').hide(); // Hide asset details form
//                 $('#specsAssetForm').show(); // Show specification form
//                 $('#save').val('Save'); // Corrected value
//                 $('#assetId').val(assetId);
//                 console.log(formData);
//             },
//             error: function(xhr, status, error) {
//                 alert('Failed to store data!' + error, status, xhr);
//             }
//         });
//     });

//     $('#specsAssetForm').submit(function(event) {
// 		event.preventDefault(); // Prevent default form submission

// 		// Serialize form data
// 		var formData = $(this).serialize();

// 		// Send form data using AJAX
// 		$.ajax({
// 			type: 'POST',
//             url: '../admin/admin_action.php',
// 			data: formData,
// 			success: function(response) {
//                 var assetId = response.assetId;
//                 $('#assetId').val(assetId);
//                 console.log(formData);
// 				// die();
// 			},
// 			error: function(xhr, status, error) {
// 				alert('Failed to store data!' + error, status, xhr);
// 			}
// 		});
// 	});
// });

function removeVowels(str) {
    // Use a regular expression to replace vowels (both upper and lower case) with an empty string
    return str.replace(/[aeiouEI]/g, '');
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
    

    var serial = document.getElementById("serial");
    var mobile = document.getElementById("mobile");
    var model = document.getElementById("model");
    var provider = document.getElementById("provider");
    var processor = document.getElementById("processor");
    var plan = document.getElementById("plan");
    var ram = document.getElementById("ram");
    var storage = document.getElementById("storage");
    var os = document.getElementById("os");
    var plan = document.getElementById("plan");

    if(selectElement.value == "SIM") {
        serial.style.display = "none";
        model.style.display = "none";
        processor.style.display = "none";
        ram.style.display = "none";
        storage.style.display = "none";
        os.style.display = "none";

        mobile.style.display = "block";
        provider.style.display = "block";
        plan.style.display = "block";
    } else {
        serial.style.display = "block";
        model.style.display = "block";
        processor.style.display = "block";

        mobile.style.display = "none";
        provider.style.display = "none";
        plan.style.display = "none";
    }
    // document.getElementById("division").innerText = selectedEmp;
    // var xhr = new XMLHttpRequest();
    // xhr.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         var response = JSON.parse(this.responseText);
    //         document.getElementById("tag").innerText = response.data;
    //     }
    // };
    // xhr.open("GET", "../admin/admin_action.php?id='17'", true);
    // xhr.send();
}

function changetextbox() {
    var status = document.getElementById("status");
    var repair = document.getElementById("repair-cost");
    var datedeployed = document.getElementById("datedeployed");
    
    if (status.value == "For repair") {
        repair.style.display = "block";
    } else if (status.value == "Deployed") {
        datedeployed.style.display = "block";
    } else {
        repair.style.display = "none";
        datedeployed.style.display = "none";
    }
}

function passValue() {
    var divValue = document.getElementById("tag").innerText;

    // Set the value of the input field
    document.getElementById("asset-tag").value = divValue;
}
