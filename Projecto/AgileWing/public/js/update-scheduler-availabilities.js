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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/logic/update-scheduler-availabilities.js":
/*!***************************************************************!*\
  !*** ./resources/js/logic/update-scheduler-availabilities.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
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

document.addEventListener("DOMContentLoaded", function () {
  updateScheduller();
  document.getElementById("prevMonth").addEventListener("click", function () {
    updateScheduller();
  });
  document.getElementById("nextMonth").addEventListener("click", function () {
    updateScheduller();
  });
  function updateScheduller() {
    // Load availabilities from sessionStorage
    var availabilities = JSON.parse(sessionStorage.getItem('localJson'));
    var baseUrl = sessionStorage.getItem('baseUrl');
    var userId = sessionStorage.getItem('userId');
    availabilities.forEach(function (availability) {
      // Convert the availability date to YYYY-MM-DD format for comparison
      var availabilityDate = new Date(availability.availability_date).toISOString().split('T')[0];

      // Get the correct cell based on date and hour block
      var row = document.querySelector("#scheduler tbody tr td[data-id=\"".concat(availability.hour_block_id, "\"]")).parentNode;
      var cell = _toConsumableArray(row.children).find(function (td) {
        return td.getAttribute('data-date') === availabilityDate;
      });
      if (cell) {
        // Set background color according to availability type
        var legendColorBox = document.querySelector(".legend-color-box[data-id=\"".concat(availability.availability_type_id, "\"]"));
        if (legendColorBox) {
          cell.style.backgroundColor = legendColorBox.style.backgroundColor;

          // Attach event listener to cell
          cell.addEventListener('click', function () {
            window.location.href = "".concat(baseUrl, "/").concat(availability.id, "/").concat(userId, "/edit");
          });
          cell.style.cursor = 'pointer';
        }
      }
    });

    // Set create links for empty cells
    var cells = document.querySelectorAll("#scheduler tbody td:not(:first-child)");
    cells.forEach(function (cell) {
      if (!cell.style.backgroundColor) {
        // If the cell doesn't already contain a link via the bg-color
        cell.addEventListener('click', function () {
          window.location.href = "".concat(baseUrl, "/create/").concat(userId);
        });
        cell.style.cursor = 'pointer';
      }
    });
  }
});

/***/ }),

/***/ 6:
/*!*********************************************************************!*\
  !*** multi ./resources/js/logic/update-scheduler-availabilities.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\LOCAL REPOS\Agile-Wing\Projecto\AgileWing\resources\js\logic\update-scheduler-availabilities.js */"./resources/js/logic/update-scheduler-availabilities.js");


/***/ })

/******/ });