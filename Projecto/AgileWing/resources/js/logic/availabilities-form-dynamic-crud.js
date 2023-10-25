document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = sessionStorage.getItem('baseUrl');
    const formHeader = document.querySelector('#crudFormHeader');
    const liElements = document.querySelectorAll('li.list-group-item');
    
    //Edit form
    const editFormCont = document.querySelector('#editFormCont');
    const editForm = document.querySelector('#editForm');
    const submitButton = editForm.querySelector('#editFormBtn');
    const cancelButtonEdit = editForm.querySelector('#cancelBtnEdit');
    const dateInput = editForm.querySelector('#date');
    const hourBlockSelect = editForm.querySelector('#hourBlock');
    const availabilityTypeSelect = editForm.querySelector('#availabilityType');
    
    //create form
    const createFormCont = document.querySelector('#createFormCont');
    const createForm = document.querySelector('#createForm');
    const startDateInput = createForm.querySelector('#startDate');
    const startHourBlockSelect = createForm.querySelector('#startHourBlock');
    const cancelButtonCreate = createForm.querySelector('#cancelBtnCreate');
    const endDateInput = createForm.querySelector('#endDate');
    const endHourBlockSelect = createForm.querySelector('#endHourBlock');
    const availabilityTypeCreateSelect = createForm.querySelector('#availabilityType');

    // Show Edit Form and Hide Create Form
    const showEditForm = () => {
        createFormCont.style.display = "none";
        editFormCont.style.display = "";
    };

    // Show Create Form and Hide Edit Form
    const showCreateForm = () => {
        createFormCont.style.display = "";
        editFormCont.style.display = "none";
    };

    liElements.forEach(li => {
        li.addEventListener('click', function() {
            // Set form values based on clicked li
            dateInput.value = li.getAttribute('data-date');
            hourBlockSelect.value = li.getAttribute('data-hour-block-id');
            availabilityTypeSelect.value = li.getAttribute('data-type');

            // Change form to "edit" state
            const availabilityId = li.getAttribute('data-id');
            editForm.action = baseUrl + '/' + availabilityId;
            formHeader.textContent = "Edição";

            showEditForm();
        });
    });

    // edit Cancel button
    cancelButtonEdit.addEventListener('click', function() {
        dateInput.value = '';
        hourBlockSelect.selectedIndex = 0;
        availabilityTypeSelect.selectedIndex = 0;
        formHeader.textContent = "Criação"
        showCreateForm();
    });

    // Create Cancel button
    cancelButtonCreate.addEventListener('click', function() {
        startDateInput.value = '';
        startHourBlockSelect.selectedIndex = 0;
        endDateInput.value = '';
        endHourBlockSelect.selectedIndex = 0;
        availabilityTypeCreateSelect.selectedIndex = 0;
    });
});