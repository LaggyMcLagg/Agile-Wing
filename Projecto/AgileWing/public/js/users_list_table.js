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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/logic/users_list_table.js":
/*!************************************************!*\
  !*** ./resources/js/logic/users_list_table.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function () {
  // Client-side sorting
  var table = document.getElementById("sortable-table");
  var headers = table.querySelectorAll("th[data-column-index]");
  var rows = table.querySelectorAll("tbody tr");
  headers.forEach(function (header) {
    header.addEventListener("click", function () {
      sortTableByColumn(table, headers, rows, header);
    });
  });
  // Live search
  var searchInput = document.getElementById("search-input");
  searchInput.addEventListener("keyup", function () {
    filterRowsBySearchInput(searchInput, rows);
  });
  // Clickable rows
  var editCells = document.querySelectorAll(".clickable-row");
  editCells.forEach(function (cell) {
    cell.addEventListener("dblclick", function () {
      redirectToShowPage(cell);
    });
  });
});
function sortTableByColumn(table, headers, rows, clickedHeader) {
  var columnIndex = parseInt(clickedHeader.getAttribute("data-column-index"));
  var sortDirection = clickedHeader.classList.contains("sorted-asc") ? "desc" : "asc";
  rows = Array.from(rows);
  rows.sort(function (a, b) {
    var aValue = a.children[columnIndex].textContent;
    var bValue = b.children[columnIndex].textContent;
    if (sortDirection === "asc") {
      return aValue.localeCompare(bValue);
    } else {
      return bValue.localeCompare(aValue);
    }
  });
  rows.forEach(function (row) {
    table.querySelector("tbody").appendChild(row);
  });
  headers.forEach(function (header) {
    header.classList.remove("sorted-asc", "sorted-desc");
  });
  clickedHeader.classList.add(sortDirection === "asc" ? "sorted-asc" : "sorted-desc");
}
function filterRowsBySearchInput(searchInput, rows) {
  var searchText = searchInput.value.toLowerCase();
  rows.forEach(function (row) {
    var rowText = row.textContent.toLowerCase();
    if (rowText.includes(searchText)) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}
function redirectToShowPage(cell) {
  var userId = cell.getAttribute("data-user-id");
  window.location.href = "/users/" + userId;
}

/***/ }),

/***/ 2:
/*!******************************************************!*\
  !*** multi ./resources/js/logic/users_list_table.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\PROJETO_FINAL\Agile-Wing\Projecto\AgileWing\resources\js\logic\users_list_table.js */"./resources/js/logic/users_list_table.js");


/***/ })

/******/ });