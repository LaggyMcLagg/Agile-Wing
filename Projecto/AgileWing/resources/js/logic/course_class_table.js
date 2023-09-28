// // Get references to the <td> elements by their IDs
// // let courseClassId = document.getElementById('courseClassId');
// // let courseClassName = document.getElementById('courseClassName');
// // let courseClassNumber = document.getElementById('courseClassNumber');
// // let courseClassCourseId = document.getElementById('courseClassCourseId');


// document.addEventListener("DOMContentLoaded", function () {
    
//     let showButtons = document.querySelectorAll(".showButton");
    
//     //show function
    
//     if (showButtons.length > 0) {
//         showButtons.forEach(function (showButton) {
//             showButton.addEventListener("click", function () {
//                 // Retrieve the data attributes
//                 let courseId = showButton.getAttribute("data-course-class-id");
//                 let courseName = showButton.getAttribute("data-course-class-name");
//                 let courseNumber = showButton.getAttribute("data-course-class-number");
//                 let courseCourseId = showButton.getAttribute("data-course-class-course-id");

//                 // Populate the form with the retrieved data
//                 let wordsElement = document.getElementById("target");

//                 // Check if the element exists
//                 if (wordsElement) {
//                     wordsElement.innerHTML = `
//                             <div class="form-group">
//                                 <label for="name">Name:</label>
//                                 <input type="text" class="form-control" id="name" name="name" placeholder="${courseName}" disabled>
//                             </div>
//                             <div class="form-group">
//                                 <label for="number">Number:</label>
//                                 <input type="text" class="form-control" id="number" name="number" placeholder="${courseNumber}" disabled>
//                             </div>
//                             <div class="form-group">
//                                 <label for="course_id">Course ID:</label>
//                                 <input type="text" class="form-control" id="course_id" name="course_id" placeholder="${courseCourseId}" disabled>
//                             </div>
//                     `;
//                 } else {
//                     console.error("Element with id 'target' not found.");
//                 }
//             });
//         });
//     }

//     //edit function

//     let editButtons = document.querySelectorAll(".editButton");
//     let form = document.getElementById("form-thing");

//     if (editButtons.length > 0) {
//         editButtons.forEach(function (editButton) {
//             editButton.addEventListener("click", function () {
//                 let courseId = editButton.getAttribute("data-course-class-id");
//                 let courseName = editButton.getAttribute("data-course-class-name");
//                 let courseNumber = editButton.getAttribute("data-course-class-number");
//                 let courseCourseId = editButton.getAttribute("data-course-class-course-id");

//                 form.action = `/course-classes/${courseId}`;
//                 form.setAttribute("method", "PUT");

//                 let targetElement = document.getElementById("target");

//                 // Check if the element exists
//                 if (targetElement) {
//                     targetElement.innerHTML = `
//                         <div class="form-group">
//                             <label for="name">Name:</label>
//                             <input type="text" class="form-control" id="name" name="name" value="${courseName}">
//                         </div>
//                         <div class="form-group">
//                             <label for="number">Number:</label>
//                             <input type="text" class="form-control" id="number" name="number" value="${courseNumber}">
//                         </div>
//                         <div class="form-group">
//                             <label for="course_id">Course ID:</label>
//                             <input type="text" class="form-control" id="course_id" name="course_id" value="${courseCourseId}">
//                         </div>
//                         <button type="submit" class="btn btn-primary">Submit</button>

//                     `;
//                 } else {
//                     console.error("Element with id 'target' not found.");
//                 }
//             });
//         });
//     }

//     //create function

//     let createButton = document.querySelector("#createButton");

//     if (createButton) {
//         createButton.addEventListener("click", function () {

//             form.action = `/course-classes/`; 
//             form.setAttribute("method", "POST");
//             let targetElement = document.getElementById("target");

//             if (targetElement) {
//                 targetElement.innerHTML = `
//                         <div class="form-group">
//                             <label for="name">Name:</label>
//                             <input type="text" class="form-control" id="name" name="name">
//                         </div>
//                         <div class="form-group">
//                             <label for="number">Number:</label>
//                             <input type="text" class="form-control" id="number" name="number">
//                         </div>
//                         <div class="form-group">
//                             <label for="course_id">Course ID:</label>
//                             <input type="text" class="form-control" id="course_id" name="course_id">
//                         </div>
//                         <button type="submit" class="btn btn-primary">Submit</button>

//                     `;
//             } else {
//                 console.error("Element with id 'target' not found.");
//             }
//         });
//     }
// });


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