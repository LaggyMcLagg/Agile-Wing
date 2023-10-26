/**
 * This script is responsible for updating the scheduler based on the availability of the teacher.
 * It functions as follows:
 *
 * 1. Once the DOM is fully loaded, it retrieves availability data from sessionStorage.
 * 2. For each availability record, it finds the corresponding cell in the scheduler (based on date and hour block).
 * 3. It then sets the background color of this cell based on the availability type.
 * 4. Each availability cell, when clicked, navigates to a specific URL for that availability record.
 * 5. Any empty cells in the scheduler (ones without availabilities) are clickable and will navigate 
 *    to a generic URL to perhaps create a new availability.
 * 
 * Dependencies:
 * - The page should have elements with ids "prevMonth" and "nextMonth" which, when clicked, 
 *   should invoke the update on the scheduler.
 * - The scheduler structure is expected to be in a specific format with cells having `data-date` 
 *   and `data-id` attributes for identification.
 * - Availability types should have a corresponding color box in the DOM with class `legend-color-box`
 *   and a `data-id` attribute for correct color mapping.
 * 
 * Assumptions:
 * - Availability data is stored in sessionStorage with key 'localJson' and contains fields: 
 *   'availability_date', 'hour_block_id', 'availability_type_id', and 'id'.
 * - There's an existing structure in the DOM that matches the query selectors used in the script.
 *
 * Event Listeners:
 * - The script listens for the "DOMContentLoaded" event to initialize the scheduler update.
 * - It also listens for clicks on "prevMonth" and "nextMonth" to re-invoke the scheduler update.
 *
 * @event DOMContentLoaded Fires when the initial HTML document has been completely loaded.
 * @function updateScheduller Responsible for the main logic of updating the scheduler.
 */
document.addEventListener("DOMContentLoaded", function() {

    updateScheduller();

    document.getElementById("prevMonth").addEventListener("click", function() {
        updateScheduller();
    });

    document.getElementById("nextMonth").addEventListener("click", function() {
        updateScheduller();
    });

    function updateScheduller(){
        // Load availabilities from sessionStorage
        const availabilities = JSON.parse(sessionStorage.getItem('localJson'));

        // Load users
        const users = JSON.parse(sessionStorage.getItem('localJsonUser'));

        // Load UFCDS
        const ufcds = JSON.parse(sessionStorage.getItem('localJsonUfcd'));

        const baseUrl = sessionStorage.getItem('baseUrl');
        const userId = sessionStorage.getItem('userId');
        const courseClassId = sessionStorage.getItem('courseClassId');

        availabilities.forEach(availability => {
            // Convert the availability date to YYYY-MM-DD format for comparison
            const dateToUse = availability.availability_date ? availability.availability_date : availability.date;
            const availabilityDate = new Date(dateToUse).toISOString().split('T')[0];
            

            // Get the correct cell based on date and hour block
            const idToUse = availability.hour_block_id ? availability.hour_block_id : availability.hour_block_course_class_id;
            const row = document.querySelector(`#scheduler tbody tr td[data-id="${idToUse}"]`).parentNode;            
            const cell = [...row.children].find(td => td.getAttribute('data-date') === availabilityDate);

            if (cell) {
                // Set background color according to availability type
                const legendColorBox = document.querySelector(`.legend-color-box[data-id="${availability.availability_type_id}"]`);
                if (legendColorBox) {
                    cell.style.backgroundColor = legendColorBox.style.backgroundColor;

                    // Attach event listener to cell
                    cell.addEventListener('click', function() {
                        window.location.href = `${baseUrl}/${availability.id}/${userId}/edit`;
                    });
                    cell.style.cursor = 'pointer';
                } 
                else
                {
                    // Find the relevant user and UFCD data
                    const relevantUser = Object.values(users).find(user => user.id === availability.user_id);
                    const relevantUfcd = Object.values(ufcds).find(ufcd => ufcd.id === availability.ufcd_id);
                                
                    if(relevantUser) {
                        
                        cell.style.backgroundColor = relevantUser.color_1;

                        // Generate div for user name
                        const userDiv = document.createElement('div');
                        userDiv.classList.add('user-name');
                        userDiv.textContent = relevantUser.name;
                        cell.appendChild(userDiv);
                    } 

                    // Generate div for UFCD info
                    if (relevantUfcd) {
                        const ufcdDiv = document.createElement('div');
                        ufcdDiv.classList.add('ufcd-info');
                        ufcdDiv.textContent = `${relevantUfcd.number}`;
                        cell.appendChild(ufcdDiv);
                    }

                    // Attach event listener to cell
                    cell.addEventListener('click', function() {
                        window.location.href = `${baseUrl}/${availability.id}/${courseClassId}/edit`;
                    });
                    cell.style.cursor = 'pointer';
                }
            }
        });
        if (userId === null) {

            // create links for empty cells TEACHER AVAILABILITIES
            const cells = document.querySelectorAll("#scheduler tbody td:not(:first-child)");
            cells.forEach(cell => {
                if (!cell.style.backgroundColor) { // If the cell doesn't already contain a link via the bg-color
                    cell.addEventListener('click', function() {
                        window.location.href = `${baseUrl}/create/${userId}`;
                    });
                    cell.style.cursor = 'pointer';
                }
            });
        } else {

            // create links for empty cells COURSE CLASSE ATRIBUTIONS
            const cells = document.querySelectorAll("#scheduler tbody td:not(:first-child)");
            cells.forEach(cell => {
                // If the cell doesn't already contain a link via the bg-color
                if (!cell.style.backgroundColor) {

                    // Get the block ID from the first <td> of the row
                    const blockId = cell.parentNode.querySelector('td[data-id]').getAttribute('data-id'); 

                    // Get the date from the clicked cell
                    const date = cell.getAttribute('data-date'); 

                    cell.addEventListener('click', function() {
                        window.location.href = `${baseUrl}/create/${courseClassId}/${blockId}/${date}`;
                    });
                    cell.style.cursor = 'pointer';
                }
            });            
        }
    }
});