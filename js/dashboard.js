function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]')
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source) {
            checkboxes[i].checked = source.checked
        }
    }
}

function checkDelete(){
    return confirm('🗑️Are you sure you want to delete this Data?')
}

function checkPrompt(){
    
    var turnoverCode = document.getElementById('#turnover')
    var accountabilityCode = document.getElementById('#accountability')

    if((turnoverCode='') || (accountabilityCode='')) {
        return confirm('✔️Confirm?')
    } else { 
        return false;
    }
}