 /**
 * Handles the behavior of the course control form.
 * 
 * This script manages:
 * - The toggling between editing and view modes.
 * - The persistence of form states across page reloads using session storage.
 * - Transferring data from table rows to the form for potential editing.
 * - Storing certain form states and selections in session storage.
 *
 *
 */

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

    // Load the form state from session storage
    let formState = sessionStorage.getItem("formState");

    if (formState === "edit") {
        enableEdit();  // Enable the edit mode

        const storedCourseId = sessionStorage.getItem("selectedId");

        if (storedCourseId) {
            idLabel.textContent = storedCourseId;
        }

        // Set the method and action for the form when a row is selected
        document.getElementById("hiddenMethod").value = "PUT";
        controlForm.action = baseAction + '/' + storedCourseId;

    } else if (formState === "create") {
        enableEdit();  // Enable the create mode
    } else {
        disableEdit(); // By default, keep the form disabled
    }

    // Function to reset the form
    function clearForm() {
        // Clear all inputs in the form
        document.querySelectorAll('#controlForm [data-name]').forEach(input => {
            input.value = '';
        });

        // Uncheck all checkboxes in the checkbox list
        document.querySelectorAll('#ufcdsCheckboxList input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Clear the stored course ID
        idLabel.textContent = "";
        sessionStorage.removeItem("selectedId");  
    }

    // Function to enable the form editing mode
    function enableEdit() {
        document.querySelectorAll('#controlForm input, #controlForm select').forEach(input => {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });
        document.querySelectorAll('#ufcdsCheckboxList input[type="checkbox"]').forEach(checkbox => {
            checkbox.removeAttribute('disabled');
        });
        saveBtn.style.display = 'block';
        cancelBtn.style.display = 'block';
        isEditing = true;
    }

    // This function processes the checkbox-lists and matches values.
    function processCheckboxList(formInput, cellContent) {
        const listId = cellContent.getAttribute('data-list-id');
        const listDiv = document.getElementById(listId);
        
        if (!listDiv) return;

        const itemValues = Array.from(listDiv.querySelectorAll('li')).map(li => li.getAttribute('value'));
        
        const checkboxes = formInput.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            if (itemValues.includes(checkbox.value)) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    }

    // Function to disable the form editing mode
    function disableEdit() {
        clearForm();
        document.querySelectorAll('#controlForm input, #controlForm select').forEach(input => {
            input.setAttribute('readonly', true);
            input.setAttribute('disabled', true);
        });
        document.querySelectorAll('#ufcdsCheckboxList input[type="checkbox"]').forEach(checkbox => {
            checkbox.setAttribute('disabled', true);
        });
        saveBtn.style.display = 'none';
        cancelBtn.style.display = 'none';
        isEditing = false;
    }

    // On "Edit" button click, enable editing if not already editing
    editBtn.addEventListener("click", function() {
        // Check if idLabel is empty (including just whitespace)
        if (!idLabel.textContent.trim()) {
            disableEdit();
            return;
        }
        sessionStorage.setItem("formState", "edit");  // Store the EDIT state to session storage
        if (!isEditing) {
            enableEdit();
        }
    });

    // On "Create" button click, reset the form and enable editing
    createBtn.addEventListener("click", function() {
        clearForm();
        enableEdit();

        document.getElementById("hiddenMethod").value = "POST";
        controlForm.action = baseAction;

        sessionStorage.setItem("formState", "create");  // Store the CREATE state to session storage
    });

    // On "Cancel" button click, reset the form and disable editing
    cancelBtn.addEventListener("click", function(event) {
        event.preventDefault(); // Prevent any default form submission
        clearForm();
        disableEdit();

        sessionStorage.removeItem("formState");  // Clear the state from session storage
    });

    tableRows.forEach(function(row) {
        row.addEventListener("click", function() {
            if (!isEditing) {
                // Get the ID from the clicked row
                const id = row.querySelector('[data-name="id"]').textContent;
                idLabel.textContent = id;
                sessionStorage.setItem("selectedId", id);

                row.querySelectorAll('[data-name]').forEach(cell => {
                    const fieldName = cell.getAttribute('data-name');

                    const formInput = document.querySelector(`#controlForm [data-name="${fieldName}"]`);

                    if (formInput) {
                        switch (formInput.getAttribute('data-type')) {

                            case 'comboBox':
                                if (formInput.tagName === 'SELECT') {
                                    let value = cell.textContent.trim();
                                    for (let option of formInput.options) {
                                        if (option.text === value) {
                                            formInput.value = option.value;
                                            break;
                                        }
                                    }
                                }
                                break;
                            
                            case 'checkBoxList':
                                processCheckboxList(formInput, cell);
                                break;

                            case 'colorPicker':
                                formInput.value = cell.getAttribute('data-value');
                                break;

                            default:
                                formInput.value = cell.textContent;
                                break;
                        }
                    }
                });

                // Set the method and action for the form when a row is selected
                document.getElementById("hiddenMethod").value = "PUT";
                controlForm.action = baseAction + '/' + id;
            }
        });
    });
});