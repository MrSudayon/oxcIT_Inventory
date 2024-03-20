$(document).ready(function() {
    $('#addAssetForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send form data using AJAX
        $.ajax({
            type: 'POST',
            url: 'admin_action.php',
            data: formData,
            success: function(response) {
                $('#addAssetForm').hide(); // Hide asset details form
                $('#specsAssetForm').show(); // Show specification form
            },
            error: function(xhr, status, error) {
                alert('Failed to store data!');
            }
        });
    });
    $('#addAssetForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send form data using AJAX
        $.ajax({
            type: 'POST',
            url: 'admin_action.php', // Update the URL with the correct endpoint for the current page
            data: formData,
            success: function(response) {
                var assetId = response.assetId;

                $('#action').val('saveAssetDetails');
                $('#assetId').val(assetId);
                print_r(response);
                $('#specsAssetForm').modal('show');

            },
            error: function(xhr, status, error) {
                alert('Failed to store data!' + error, status, xhr);
            }
        });
    });

    $('#specsAssetForm').submit(function(event) {
		event.preventDefault(); // Prevent default form submission

		// Serialize form data
		var formData = $(this).serialize();

		// Send form data using AJAX
		$.ajax({
			type: 'POST',
			url: 'admin_action.php', // Update the URL with the correct endpoint for the current page
			data: formData,
			success: function(response) {
                $('#action').val('saveAssetFinal');
				print_r(response); // Replace first form with second form
				die();
			},
			error: function(xhr, status, error) {
				alert('Failed to store data!' + error, status, xhr);
			}
		});
	});
});
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

// function changetextbox() {
    
// }

function passValue() {
    var divValue = document.getElementById("tag").innerText;

    // Set the value of the input field
    document.getElementById("asset-tag").value = divValue;
}
