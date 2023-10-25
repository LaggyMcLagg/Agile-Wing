/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/components/build-scheduler.js":
/*!****************************************************!*\
  !*** ./resources/js/components/build-scheduler.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

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

document.addEventListener("DOMContentLoaded", function () {
  // Current month and year for the scheduler.
  var currentMonth = new Date().getMonth();
  var currentYear = new Date().getFullYear();

  // Display the calendar for the current month and year upon page load.
  buildScheduler(currentMonth, currentYear);

  // Event listener for navigating to the previous month.
  document.getElementById("prevMonth").addEventListener("click", function () {
    currentMonth--;
    // When January is the current month, revert to December of the previous year.
    if (currentMonth < 0) {
      currentMonth = 11; // December
      currentYear--;
    }
    buildScheduler(currentMonth, currentYear);
  });

  // Event listener for navigating to the next month.
  document.getElementById("nextMonth").addEventListener("click", function () {
    currentMonth++;
    // When December is the current month, advance to January of the next year.
    if (currentMonth > 11) {
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
    var daysGrid = document.getElementById("daysGrid");
    daysGrid.innerHTML = '';

    // Add weekday headers.
    var dayNames = ["D", "S", "T", "Q", "Q", "S", "S"];
    dayNames.forEach(function (day) {
      var dayElement = document.createElement('div');
      dayElement.textContent = day;
      dayElement.classList.add('day-name');
      daysGrid.appendChild(dayElement);
    });

    // Calculate important days for calendar building.

    // Determine which day of the week the current month starts on. 
    // E.g., 0 for Sunday, 1 for Monday, etc.
    var firstDayOfMonth = new Date(year, month, 1).getDay();

    // Get the total number of days in the previous month.
    // By setting the day parameter to 0, it essentially asks for the last day of the previous month.
    var daysInLastMonth = new Date(year, month, 0).getDate();

    // Get the total number of days in the current month.
    // We increment the month by 1 and set the day to 0 to get the last day of the current month.
    var daysInThisMonth = new Date(year, month + 1, 0).getDate();

    // Display days from the previous month in gray.

    // Depending on which day of the week the current month starts on, 
    // fill in the calendar grid with the corresponding number of days from the end of the previous month.
    // These are displayed in gray to differentiate them from the days of the current month.
    for (var i = 0; i < firstDayOfMonth; i++) {
      var dayElement = document.createElement('div');
      dayElement.textContent = daysInLastMonth - firstDayOfMonth + i + 1; // Calculates the exact day from the previous month.
      dayElement.style.color = "gray"; // Style these days in gray.
      daysGrid.appendChild(dayElement); // Add to the calendar grid.
    }

    // Display the days of the current month.

    // Create and display elements for each day of the current month in the calendar grid.
    for (var _i = 1; _i <= daysInThisMonth; _i++) {
      var _dayElement = document.createElement('div');
      _dayElement.textContent = _i; // This is the actual day number of the current month.
      daysGrid.appendChild(_dayElement); // Add to the calendar grid.
    }

    // Display days from the next month in gray to ensure a complete grid.

    // To keep a consistent look of the calendar grid, sometimes it's necessary to show some days from the next month.
    // The calendar grid has 7 rows of 7 days, totaling 49 cells. 
    // Thus, after filling the days of the current and previous months, 
    // any remaining cells are filled with the days from the next month.
    var nextMonthDay = 1; // Start from the first day of the next month.
    while (daysGrid.children.length < 49) {
      var _dayElement2 = document.createElement('div');
      _dayElement2.textContent = nextMonthDay++; // Display and then increment the day for the next iteration.
      _dayElement2.style.color = "gray"; // Style these days in gray.
      daysGrid.appendChild(_dayElement2); // Add to the calendar grid.
    }

    // Update the displayed month and year above the calendar.
    var monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    var monthYearEle = document.getElementById("currentMonthYear");
    monthYearEle.textContent = "".concat(monthNames[month], " ").concat(year);

    // Start updating the scheduler headers.
    var schedulerHeader = document.querySelector("#scheduler thead tr");

    // Remove headers of the days from the previous month.
    while (schedulerHeader.children.length > 1) {
      // Keep the 'Horários' column
      schedulerHeader.removeChild(schedulerHeader.lastChild);
    }

    // Portuguese short day names for the headers.
    var dayNamesShort = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"];

    // Populate the headers with the current month's days.
    for (var _i2 = 1; _i2 <= daysInThisMonth; _i2++) {
      var th = document.createElement('th');
      var dateElem = document.createElement('div');
      var dayOfWeekElem = document.createElement('div');
      var currentDayOfWeek = new Date(year, month, _i2).getDay();
      dateElem.textContent = _i2;
      dayOfWeekElem.textContent = dayNamesShort[currentDayOfWeek];
      th.appendChild(dateElem);
      th.appendChild(dayOfWeekElem);
      schedulerHeader.appendChild(th);
    }

    // Update the body of the scheduler for the current month.
    var schedulerRows = document.querySelectorAll("#scheduler tbody tr");
    schedulerRows.forEach(function (row) {
      // Remove the previous month's data.
      while (row.children.length > 1) {
        row.removeChild(row.lastChild);
      }

      // Populate cells for each day of the current month.
      for (var _i3 = 1; _i3 <= daysInThisMonth; _i3++) {
        var td = document.createElement('td');
        var currentDate = new Date(year, month, _i3);
        td.setAttribute("data-date", "".concat(currentDate.getFullYear(), "-").concat(String(currentDate.getMonth() + 1).padStart(2, '0'), "-").concat(String(_i3).padStart(2, '0')));
        td.classList.add("cells"); //this applies a general-purpose class if INES/SARA needs it
        row.appendChild(td);
      }
    });
  }
});

/***/ }),

/***/ 8:
/*!**********************************************************!*\
  !*** multi ./resources/js/components/build-scheduler.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\ATEC\repos\Agile-Wing\Projecto\AgileWing\resources\js\components\build-scheduler.js */"./resources/js/components/build-scheduler.js");


/***/ })

/******/ });