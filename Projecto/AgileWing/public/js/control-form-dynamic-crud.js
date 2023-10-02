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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/logic/control-form-dynamic-crud.js":
/*!*********************************************************!*\
  !*** ./resources/js/logic/control-form-dynamic-crud.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
  // Getting elements from the DOM
  var controlForm = document.getElementById("controlForm");
  // Store the initial action URL
  var baseAction = controlForm.action;
  var editBtn = document.getElementById("editBtn");
  var createBtn = document.getElementById("createBtn");
  var saveBtn = document.getElementById("saveBtn");
  var cancelBtn = document.getElementById("cancelBtn");
  var idLabel = document.getElementById("id_label");
  var tableRows = document.querySelectorAll("tbody tr");

  // Flag to check if the form is in editing mode
  var isEditing = false;

  // Function to reset the form
  function clearForm() {
    // Clear all inputs in the form
    document.querySelectorAll('#controlForm [data-name]').forEach(function (input) {
      input.value = '';
    });
  }

  // Function to enable the form editing mode
  function enableEdit() {
    document.querySelectorAll('input').forEach(function (input) {
      return input.removeAttribute('readonly');
    });
    saveBtn.style.display = 'block';
    cancelBtn.style.display = 'block';
    isEditing = true;
  }

  // Function to disable the form editing mode
  function disableEdit() {
    document.querySelectorAll('input').forEach(function (input) {
      return input.setAttribute('readonly', true);
    });
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
    isEditing = false;
  }

  // On "Edit" button click, enable editing if not already editing
  editBtn.addEventListener("click", function () {
    if (!isEditing) {
      enableEdit();
    }
  });

  // On "Create" button click, reset the form and enable editing
  createBtn.addEventListener("click", function () {
    clearForm();
    enableEdit();
    document.getElementById("hiddenMethod").value = "POST";
    controlForm.method = "POST";
    controlForm.action = baseAction;
  });

  // On "Cancel" button click, reset the form and disable editing
  cancelBtn.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent any default form submission
    clearForm();
    disableEdit();
  });

  // When clicking on a table row, populate the form with row data
  tableRows.forEach(function (row) {
    row.addEventListener("click", function () {
      if (!isEditing) {
        row.querySelectorAll('[data-name]').forEach(function (cell) {
          var fieldName = cell.getAttribute('data-name');
          var formInput = document.querySelector("#controlForm [data-name=\"".concat(fieldName, "\"]"));
          if (formInput) {
            formInput.value = cell.textContent;
          }
        });

        // Set the ID label
        var id = row.querySelector('[data-name="id"]').textContent;
        idLabel.textContent = id;

        // Set the method and action for the form when a row is selected
        document.getElementById("hiddenMethod").value = "PUT";
        controlForm.method = "POST";
        controlForm.action = baseAction + '/' + id;
      }
    });
  });
});

/***/ }),

/***/ 4:
/*!***************************************************************!*\
  !*** multi ./resources/js/logic/control-form-dynamic-crud.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\ruiru\Desktop\Agile-Wing\Projecto\AgileWing\resources\js\logic\control-form-dynamic-crud.js */"./resources/js/logic/control-form-dynamic-crud.js");


/***/ })

/******/ });