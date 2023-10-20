/**
 * This script manages and builds an interactive scheduler calendar.
 *
 * Key Functionalities:
 * 1. Upon DOM content loading, it initializes the scheduler with the current month.
 * 2. Enables navigation to previous and next months, with the scheduler grid updating accordingly.
 * 3. Displays days from the previous, current, and next months in a consistent 7x7 grid format.
 *    Days from previous and next months are differentiated by gray color.
 * 4. The header of the scheduler displays day names (in Portuguese) and dates for the current month.
 * 5. The scheduler body adjusts to show the correct cells for the current month's days.
 *
 * Major Components:
 * - `buildScheduler`: This function constructs the scheduler calendar based on a given month and year.
 *     It starts by setting the header with day names, then calculates key days (like the start and end 
 *     days of the month). Days are then rendered on the calendar, including tail days from the previous 
 *     and next months. The scheduler header and body are also adjusted to the current month.
 *
 * Assumptions:
 * - There exists a grid element (`daysGrid`) to show days of the month.
 * - The page contains elements with ids "prevMonth" and "nextMonth" for navigation.
 * - The scheduler structure uses a table format with specific elements expected (e.g., a `thead` for headers).
 * - Portuguese month and day names are used.
 *
 * @listens DOMContentLoaded - The script triggers upon the complete loading of the page's DOM.
 */

document.addEventListener("DOMContentLoaded", function() {
    // Current month and year for the scheduler.
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    // Display the calendar for the current month and year upon page load.
    buildScheduler(currentMonth, currentYear);

    // Event listener for navigating to the previous month.
    document.getElementById("prevMonth").addEventListener("click", function() {
        currentMonth--;
        // When January is the current month, revert to December of the previous year.
        if(currentMonth < 0) {
            currentMonth = 11; // December
            currentYear--;
        }
        buildScheduler(currentMonth, currentYear);
    });

    // Event listener for navigating to the next month.
    document.getElementById("nextMonth").addEventListener("click", function() {
        currentMonth++;
        // When December is the current month, advance to January of the next year.
        if(currentMonth > 11) {
            currentMonth = 0; // January
            currentYear++;
        }
        buildScheduler(currentMonth, currentYear);
    });

    /**
     * The main function to construct the scheduler calendar.
     * @param {number} month - The current month (0-11).
     * @param {number} year - The current year.
     */
    function buildScheduler(month, year) {
        // Start by cleaning the calendar grid.
        const daysGrid = document.getElementById("daysGrid");
        daysGrid.innerHTML = '';
        
        // Add weekday headers.
        const dayNames = ["D", "S", "T", "Q", "Q", "S", "S"];
        dayNames.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.textContent = day;
            dayElement.classList.add('day-name');
            daysGrid.appendChild(dayElement);
        });

        // Calculate important days for calendar building.

        // Determine which day of the week the current month starts on. 
        // E.g., 0 for Sunday, 1 for Monday, etc.
        const firstDayOfMonth = new Date(year, month, 1).getDay();

        // Get the total number of days in the previous month.
        // By setting the day parameter to 0, it essentially asks for the last day of the previous month.
        const daysInLastMonth = new Date(year, month, 0).getDate();

        // Get the total number of days in the current month.
        // We increment the month by 1 and set the day to 0 to get the last day of the current month.
        const daysInThisMonth = new Date(year, month + 1, 0).getDate();

        // Display days from the previous month in gray.

        // Depending on which day of the week the current month starts on, 
        // fill in the calendar grid with the corresponding number of days from the end of the previous month.
        // These are displayed in gray to differentiate them from the days of the current month.
        for (let i = 0; i < firstDayOfMonth; i++) {
            const dayElement = document.createElement('div');
            dayElement.textContent = daysInLastMonth - firstDayOfMonth + i + 1;  // Calculates the exact day from the previous month.
            dayElement.style.color = "gray";  // Style these days in gray.
            daysGrid.appendChild(dayElement);  // Add to the calendar grid.
        }

        // Display the days of the current month.

        // Create and display elements for each day of the current month in the calendar grid.
        for (let i = 1; i <= daysInThisMonth; i++) {
            const dayElement = document.createElement('div');
            dayElement.textContent = i;  // This is the actual day number of the current month.
            daysGrid.appendChild(dayElement);  // Add to the calendar grid.
        }

        // Display days from the next month in gray to ensure a complete grid.

        // To keep a consistent look of the calendar grid, sometimes it's necessary to show some days from the next month.
        // The calendar grid has 7 rows of 7 days, totaling 49 cells. 
        // Thus, after filling the days of the current and previous months, 
        // any remaining cells are filled with the days from the next month.
        let nextMonthDay = 1;  // Start from the first day of the next month.
        while (daysGrid.children.length < 49) {
            const dayElement = document.createElement('div');
            dayElement.textContent = nextMonthDay++;  // Display and then increment the day for the next iteration.
            dayElement.style.color = "gray";  // Style these days in gray.
            daysGrid.appendChild(dayElement);  // Add to the calendar grid.
        }

        // Update the displayed month and year above the calendar.
        const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
        const monthYearEle = document.getElementById("currentMonthYear")
        monthYearEle.textContent = `${monthNames[month]} ${year}`;

        // Start updating the scheduler headers.
        const schedulerHeader = document.querySelector("#scheduler thead tr");
        
        // Remove headers of the days from the previous month.
        while (schedulerHeader.children.length > 1) { // Keep the 'Horários' column
            schedulerHeader.removeChild(schedulerHeader.lastChild);
        }

        // Portuguese short day names for the headers.
        const dayNamesShort = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"];

        // Populate the headers with the current month's days.
        for (let i = 1; i <= daysInThisMonth; i++) {
            const th = document.createElement('th');
            const dateElem = document.createElement('div');
            const dayOfWeekElem = document.createElement('div');
            
            const currentDayOfWeek = new Date(year, month, i).getDay();
            
            dateElem.textContent = i;
            dayOfWeekElem.textContent = dayNamesShort[currentDayOfWeek];
            
            th.appendChild(dateElem);
            th.appendChild(dayOfWeekElem);
            schedulerHeader.appendChild(th);
        }

        // Update the body of the scheduler for the current month.
        const schedulerRows = document.querySelectorAll("#scheduler tbody tr");
        schedulerRows.forEach(row => {
            // Remove the previous month's data.
            while (row.children.length > 1) {
                row.removeChild(row.lastChild);
            }

            // Populate cells for each day of the current month.
            for (let i = 1; i <= daysInThisMonth; i++) {
                const td = document.createElement('td');
                const currentDate = new Date(year, month, i);
                td.setAttribute("data-date", `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`);

                td.classList.add("cells"); //this applies a general-purpose class if INES/SARA needs it
                row.appendChild(td);
            }
        });
    }
});