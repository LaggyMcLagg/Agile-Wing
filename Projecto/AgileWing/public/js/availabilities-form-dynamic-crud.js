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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/logic/availabilities-form-dynamic-crud.js":
/*!****************************************************************!*\
  !*** ./resources/js/logic/availabilities-form-dynamic-crud.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener('DOMContentLoaded', function () {
  var baseUrl = sessionStorage.getItem('baseUrl');
  var userId = sessionStorage.getItem('userId');
  var formHeader = document.querySelector('#crudFormHeader');
  var liElements = document.querySelectorAll('li.list-group-item');

  //Edit form
  var editFormCont = document.querySelector('#editFormCont');
  var editForm = document.querySelector('#editForm');
  var submitButton = editForm.querySelector('#editFormBtn');
  var cancelButtonEdit = editForm.querySelector('#cancelBtnEdit');
  var dateInput = editForm.querySelector('#date');
  var hourBlockSelect = editForm.querySelector('#hourBlock');
  var availabilityTypeSelect = editForm.querySelector('#availabilityType');

  //create form
  var createFormCont = document.querySelector('#createFormCont');
  var createForm = document.querySelector('#createForm');
  var startDateInput = createForm.querySelector('#startDate');
  var startHourBlockSelect = createForm.querySelector('#startHourBlock');
  var cancelButtonCreate = createForm.querySelector('#cancelBtnCreate');
  var endDateInput = createForm.querySelector('#endDate');
  var endHourBlockSelect = createForm.querySelector('#endHourBlock');
  var availabilityTypeCreateSelect = createForm.querySelector('#availabilityType');

  // Show Edit Form and Hide Create Form
  var showEditForm = function showEditForm() {
    createFormCont.style.display = "none";
    editFormCont.style.display = "";
  };

  // Show Create Form and Hide Edit Form
  var showCreateForm = function showCreateForm() {
    createFormCont.style.display = "";
    editFormCont.style.display = "none";
  };
  liElements.forEach(function (li) {
    li.addEventListener('click', function () {
      // Set form values based on clicked li
      dateInput.value = li.getAttribute('data-date');
      hourBlockSelect.value = li.getAttribute('data-hour-block-id');
      availabilityTypeSelect.value = li.getAttribute('data-type');

      // Change form to "edit" state
      var availabilityId = li.getAttribute('data-id');
      editForm.action = baseUrl + '/' + availabilityId;
      formHeader.textContent = "Edição";
      showEditForm();
    });
  });

  // editform Cancel button
  cancelButtonEdit.addEventListener('click', function () {
    dateInput.value = '';
    hourBlockSelect.selectedIndex = 0;
    availabilityTypeSelect.selectedIndex = 0;
    formHeader.textContent = "Criação";
    showCreateForm();
  });

  // Createform Cancel button
  cancelButtonCreate.addEventListener('click', function () {
    startDateInput.value = '';
    startHourBlockSelect.selectedIndex = 0;
    endDateInput.value = '';
    endHourBlockSelect.selectedIndex = 0;
    availabilityTypeCreateSelect.selectedIndex = 0;
  });
});

/***/ }),

/***/ 9:
/*!**********************************************************************!*\
  !*** multi ./resources/js/logic/availabilities-form-dynamic-crud.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\ruiru\Desktop\Agile-Wing\Projecto\AgileWing\resources\js\logic\availabilities-form-dynamic-crud.js */"./resources/js/logic/availabilities-form-dynamic-crud.js");


/***/ })

/******/ });