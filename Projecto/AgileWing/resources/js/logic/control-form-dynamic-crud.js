    // Wait until the DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function() {

        // Getting elements from the DOM
        const controlForm = document.getElementById("controlForm");
        // Store the initial action URL
        const baseAction = controlForm.action; 
        const editBtn = document.getElementById("editBtn");
        const createBtn = document.getElementById("createBtn");
        const saveBtn = document.getElementById("saveBtn");
        const cancelBtn = document.getElementById("cancelBtn");
        const idLabel = document.getElementById("id_label");
        const tableRows = document.querySelectorAll("tbody tr"); 

        // Flag to check if the form is in editing mode
        let isEditing = false;

        // Function to reset the form
        function clearForm() {
            // Clear all inputs in the form
            document.querySelectorAll('#controlForm [data-name]').forEach(input => {
                input.value = '';
            });
        }

        // Function to enable the form editing mode
        function enableEdit() {
            document.querySelectorAll('input').forEach(input => input.removeAttribute('readonly'));
            saveBtn.style.display = 'block';
            cancelBtn.style.display = 'block';
            isEditing = true;
        }

        // Function to disable the form editing mode
        function disableEdit() {
            document.querySelectorAll('input').forEach(input => input.setAttribute('readonly', true));
            saveBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
            isEditing = false;
        }

        // On "Edit" button click, enable editing if not already editing
        editBtn.addEventListener("click", function() {
            if (!isEditing) {
                enableEdit();
            }
        });

        // On "Create" button click, reset the form and enable editing
        createBtn.addEventListener("click", function() {
            clearForm();
            enableEdit();

            document.getElementById("hiddenMethod").value = "POST";
            controlForm.method = "POST";
            controlForm.action = baseAction;
        });

        // On "Cancel" button click, reset the form and disable editing
        cancelBtn.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent any default form submission
            clearForm();
            disableEdit();
        });

        // When clicking on a table row, populate the form with row data
        tableRows.forEach(function(row) {
            row.addEventListener("click", function() {
                if (!isEditing) {
                    row.querySelectorAll('[data-name]').forEach(cell => {
                        const fieldName = cell.getAttribute('data-name');
                        const formInput = document.querySelector(`#controlForm [data-name="${fieldName}"]`);
                        if (formInput) {
                            formInput.value = cell.textContent;
                        }
                    });

                    // Set the ID label
                    const id = row.querySelector('[data-name="id"]').textContent;
                    idLabel.textContent = id;

                    // Set the method and action for the form when a row is selected
                    document.getElementById("hiddenMethod").value = "PUT";
                    controlForm.method = "POST"; 
                    controlForm.action = baseAction + '/' + id; 
                }
            });
        });
    });