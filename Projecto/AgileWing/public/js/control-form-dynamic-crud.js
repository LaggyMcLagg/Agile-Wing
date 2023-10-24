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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/logic/control-form-dynamic-crud.js":
/*!*********************************************************!*\
  !*** ./resources/js/logic/control-form-dynamic-crud.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
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

  // Load the form state from session storage
  var formState = sessionStorage.getItem("formState");
  if (formState === "edit") {
    enableEdit(); // Enable the edit mode

    var storedCourseId = sessionStorage.getItem("selectedId");
    if (storedCourseId) {
      idLabel.textContent = storedCourseId;
    }

    // Set the method and action for the form when a row is selected
    document.getElementById("hiddenMethod").value = "PUT";
    controlForm.action = baseAction + '/' + storedCourseId;
  } else if (formState === "create") {
    enableEdit(); // Enable the create mode
  } else {
    disableEdit(); // By default, keep the form disabled
  }

  // Function to reset the form
  function clearForm() {
    // Clear all inputs in the form
    document.querySelectorAll('#controlForm [data-name]').forEach(function (input) {
      input.value = '';
    });

    // Uncheck all checkboxes in the checkbox list
    document.querySelectorAll('#ufcdsCheckboxList input[type="checkbox"]').forEach(function (checkbox) {
      checkbox.checked = false;
    });

    // Clear the stored course ID
    idLabel.textContent = "";
    sessionStorage.removeItem("selectedId");
  }

  // Function to enable the form editing mode
  function enableEdit() {
    document.querySelectorAll('#controlForm input, #controlForm select').forEach(function (input) {
      input.removeAttribute('readonly');
      input.removeAttribute('disabled');
    });
    document.querySelectorAll('#ufcdsCheckboxList input[type="checkbox"]').forEach(function (checkbox) {
      checkbox.removeAttribute('disabled');
    });
    saveBtn.style.display = 'block';
    cancelBtn.style.display = 'block';
    isEditing = true;
  }

  // This function processes the checkbox-lists and matches values.
  function processCheckboxList(formInput, cellContent) {
    var listId = cellContent.getAttribute('data-list-id');
    var listDiv = document.getElementById(listId);
    if (!listDiv) return;
    var itemValues = Array.from(listDiv.querySelectorAll('li')).map(function (li) {
      return li.getAttribute('value');
    });
    var checkboxes = formInput.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
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
    document.querySelectorAll('#controlForm input, #controlForm select').forEach(function (input) {
      input.setAttribute('readonly', true);
      input.setAttribute('disabled', true);
    });
    document.querySelectorAll('#ufcdsCheckboxList input[type="checkbox"]').forEach(function (checkbox) {
      checkbox.setAttribute('disabled', true);
    });
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
    isEditing = false;
  }

  // On "Edit" button click, enable editing if not already editing
  editBtn.addEventListener("click", function () {
    // Check if idLabel is empty (including just whitespace)
    if (!idLabel.textContent.trim()) {
      disableEdit();
      return;
    }
    sessionStorage.setItem("formState", "edit"); // Store the EDIT state to session storage
    if (!isEditing) {
      enableEdit();
    }
  });

  // On "Create" button click, reset the form and enable editing
  createBtn.addEventListener("click", function () {
    clearForm();
    enableEdit();
    document.getElementById("hiddenMethod").value = "POST";
    controlForm.action = baseAction;
    sessionStorage.setItem("formState", "create"); // Store the CREATE state to session storage
  });

  // On "Cancel" button click, reset the form and disable editing
  cancelBtn.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent any default form submission
    clearForm();
    disableEdit();
    sessionStorage.removeItem("formState"); // Clear the state from session storage
  });

  tableRows.forEach(function (row) {
    row.addEventListener("click", function () {
      if (!isEditing) {
        // Get the ID from the clicked row
        var id = row.querySelector('[data-name="id"]').textContent;
        idLabel.textContent = id;
        sessionStorage.setItem("selectedId", id);
        row.querySelectorAll('[data-name]').forEach(function (cell) {
          var fieldName = cell.getAttribute('data-name');
          var formInput = document.querySelector("#controlForm [data-name=\"".concat(fieldName, "\"]"));
          if (formInput) {
            switch (formInput.getAttribute('data-type')) {
              case 'comboBox':
                if (formInput.tagName === 'SELECT') {
                  var value = cell.textContent.trim();
                  var _iterator = _createForOfIteratorHelper(formInput.options),
                    _step;
                  try {
                    for (_iterator.s(); !(_step = _iterator.n()).done;) {
                      var option = _step.value;
                      if (option.text === value) {
                        formInput.value = option.value;
                        break;
                      }
                    }
                  } catch (err) {
                    _iterator.e(err);
                  } finally {
                    _iterator.f();
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

/***/ }),

/***/ 5:
/*!***************************************************************!*\
  !*** multi ./resources/js/logic/control-form-dynamic-crud.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\ATEC\repos\Agile-Wing\Projecto\AgileWing\resources\js\logic\control-form-dynamic-crud.js */"./resources/js/logic/control-form-dynamic-crud.js");


/***/ })

/******/ });