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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/logic/form-control-schedule-atributions.js":
/*!*****************************************************************!*\
  !*** ./resources/js/logic/form-control-schedule-atributions.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//USER -> UFCD -> FORM CONTROL
var usersWithUfcdsData = JSON.parse(sessionStorage.getItem('usersWithUfcdsJson'));
document.addEventListener("DOMContentLoaded", function () {
  // Reference to the users and ufcds tables
  var usersTable = document.getElementById("users-table");
  var ufcdsTable = document.getElementById("ufcds-table");

  // Reference to hidden input fields
  var hiddenUserId = document.getElementById("hidden-user-id");
  var hiddenUfcdId = document.getElementById("hidden-ufcd-id");

  // Reference to UFCD table rows within tbody
  var ufcdRows = ufcdsTable.querySelectorAll("tbody tr");

  // Reference to the currently selected user and ufcd rows
  var selectedUserRow = null;
  var selectedUfcdRow = null;

  // Add click event to every row in the users table
  usersTable.querySelectorAll("tbody tr").forEach(function (row) {
    row.addEventListener("click", function () {
      var userId = row.getAttribute("data-user-id");
      hiddenUserId.value = userId;

      // Filter UFCDs based on this user
      var selectedUser = Object.values(usersWithUfcdsData).find(function (user) {
        return user.id == userId;
      });
      if (selectedUser) {
        var allowedUfcdIds = new Set(selectedUser.ufcd_ids);
        ufcdRows.forEach(function (ufcdRow) {
          var ufcdId = ufcdRow.getAttribute("data-ufcd-id");
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
  ufcdRows.forEach(function (row) {
    row.addEventListener("click", function () {
      if (!selectedUserRow) {
        alert("Selecione um formador antes de escolher um UFCD.");
        return;
      }
      var ufcdId = row.getAttribute("data-ufcd-id");
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
  var form = document.querySelector("#form-schedule-atribution");
  form.addEventListener("submit", function (e) {
    if (hiddenUserId.value == "" || hiddenUfcdId.value == "") {
      e.preventDefault();
      alert("Por favor, selecione um formador e uma UFCD antes de submeter.");
    }
  });
});

/***/ }),

/***/ 10:
/*!***********************************************************************!*\
  !*** multi ./resources/js/logic/form-control-schedule-atributions.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\LOCAL REPOS\Agile-Wing\Projecto\AgileWing\resources\js\logic\form-control-schedule-atributions.js */"./resources/js/logic/form-control-schedule-atributions.js");


/***/ })

/******/ });