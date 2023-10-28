//USER -> UFCD -> FORM CONTROL
const usersWithUfcdsData = JSON.parse(sessionStorage.getItem('usersWithUfcdsJson'));

document.addEventListener("DOMContentLoaded", function() {

    // Reference to the users and ufcds tables
    const usersTable = document.getElementById("users-table");
    const ufcdsTable = document.getElementById("ufcds-table");

    // Reference to hidden input fields
    const hiddenUserId = document.getElementById("hidden-user-id");
    const hiddenUfcdId = document.getElementById("hidden-ufcd-id");

    // Reference to UFCD table rows within tbody
    const ufcdRows = ufcdsTable.querySelectorAll("tbody tr");

    // Reference to the currently selected user and ufcd rows
    let selectedUserRow = null;
    let selectedUfcdRow = null;

    // Add click event to every row in the users table
    usersTable.querySelectorAll("tbody tr").forEach(row => {
        row.addEventListener("click", function() {
            const userId = row.getAttribute("data-user-id");
            hiddenUserId.value = userId;

            // Filter UFCDs based on this user
            const selectedUser =  Object.values(usersWithUfcdsData).find(user => user.id == userId);
            if (selectedUser) {
                const allowedUfcdIds = new Set(selectedUser.ufcd_ids);
                ufcdRows.forEach(ufcdRow => {
                    const ufcdId = ufcdRow.getAttribute("data-ufcd-id");
                    if (allowedUfcdIds.has(parseInt(ufcdId))) {
                        ufcdRow.style.display = ""; // show row
                    } else {
                        ufcdRow.style.display = "none"; // hide row
                    }
                });
            }

        // Remove selected class from previously selected user row, if any
        if (selectedUserRow) {
            selectedUserRow.classList.remove("selected");
            selectedUfcdRow.classList.remove("selected");
            hiddenUfcdId.value = "";
        }

        // Add selected class to the clicked row
        row.classList.add("selected");
        selectedUserRow = row;
        });
    });

    // Add click event to every row in the ufcds table
    ufcdRows.forEach(row => {
        row.addEventListener("click", function() {

            if (!selectedUserRow) {
                alert("Selecione um formador antes de escolher um UFCD."); 
                return;
            }

            const ufcdId = row.getAttribute("data-ufcd-id");
            hiddenUfcdId.value = ufcdId;

        // Remove selected class from previously selected ufcd row, if any
        if (selectedUfcdRow) {
            selectedUfcdRow.classList.remove("selected");
        }

        // Add selected class to the clicked row
        row.classList.add("selected");
        selectedUfcdRow = row;
        });        
    });

    // Ensure all fields are filled before submission
    const form = document.querySelector("#form-schedule-atribution");
    form.addEventListener("submit", function(e) {
        if (hiddenUserId.value == "" || hiddenUfcdId.value == "") {
            e.preventDefault(); 
            alert("Por favor, selecione um formador e uma UFCD antes de submeter."); 
        }
    });

});