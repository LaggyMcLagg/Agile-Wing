//CHECKBOX CONTROL
document.addEventListener("DOMContentLoaded", function() {
    const checkbox = document.getElementById("checkbox");
    const availabilityTypeId = document.getElementById("availability-type-id");
    
    checkbox.addEventListener("change", function() {
        if (this.checked) {
            availabilityTypeId.value = 2; // Set to 2 when checkbox is ON
        } else {
            availabilityTypeId.value = 3; // Set to 3 when checkbox is OFF
        }
    });

    // Set the initial value based on checkbox state
    if (checkbox.checked) {
        availabilityTypeId.value = 2;
    } else {
        availabilityTypeId.value = 3;
    }
});