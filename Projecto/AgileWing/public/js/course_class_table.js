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

/***/ "./resources/js/logic/course_class_table.js":
/*!**************************************************!*\
  !*** ./resources/js/logic/course_class_table.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\resources\\js\\logic\\course_class_table.js: Unexpected token (1:0)\n\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 1 |\u001b[39m \u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<\u001b[39m \u001b[33mHEAD\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m   |\u001b[39m \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 2 |\u001b[39m \u001b[90m/**\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 3 |\u001b[39m \u001b[90m* Handles the behavior of the course control form.\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 4 |\u001b[39m \u001b[90m* \u001b[39m\u001b[0m\n    at instantiate (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:63:32)\n    at constructor (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:358:12)\n    at Parser.raise (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:3207:19)\n    at Parser.unexpected (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:3237:16)\n    at Parser.parseExprAtom (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:11238:16)\n    at Parser.parseExprSubscripts (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10844:23)\n    at Parser.parseUpdate (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10827:21)\n    at Parser.parseMaybeUnary (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10803:23)\n    at Parser.parseMaybeUnaryOrPrivate (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10641:61)\n    at Parser.parseExprOps (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10646:23)\n    at Parser.parseMaybeConditional (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10623:23)\n    at Parser.parseMaybeAssign (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10584:21)\n    at Parser.parseExpressionBase (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10538:23)\n    at C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10534:39\n    at Parser.allowInAnd (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:12229:16)\n    at Parser.parseExpression (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:10534:17)\n    at Parser.parseStatementContent (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:12687:23)\n    at Parser.parseStatementLike (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:12538:17)\n    at Parser.parseModuleItem (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:12515:17)\n    at Parser.parseBlockOrModuleBlockBody (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:13139:36)\n    at Parser.parseBlockBody (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:13132:10)\n    at Parser.parseProgram (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:12414:10)\n    at Parser.parseTopLevel (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:12404:25)\n    at Parser.parse (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:14300:10)\n    at parse (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\parser\\lib\\index.js:14341:38)\n    at parser (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\core\\lib\\parser\\index.js:41:34)\n    at parser.next (<anonymous>)\n    at normalizeFile (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\core\\lib\\transformation\\normalize-file.js:64:38)\n    at normalizeFile.next (<anonymous>)\n    at run (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\core\\lib\\transformation\\index.js:21:50)\n    at run.next (<anonymous>)\n    at transform (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\core\\lib\\transform.js:22:41)\n    at transform.next (<anonymous>)\n    at step (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:261:32)\n    at C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:273:13\n    at async.call.result.err.err (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:223:11)\n    at C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:189:28\n    at C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\@babel\\core\\lib\\gensync-utils\\async.js:68:7\n    at C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:113:33\n    at step (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:287:14)\n    at C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:273:13\n    at async.call.result.err.err (C:\\LOCAL REPOS\\Agile-Wing\\Projecto\\AgileWing\\node_modules\\gensync\\index.js:223:11)");

/***/ }),

/***/ 4:
/*!********************************************************!*\
  !*** multi ./resources/js/logic/course_class_table.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\LOCAL REPOS\Agile-Wing\Projecto\AgileWing\resources\js\logic\course_class_table.js */"./resources/js/logic/course_class_table.js");


/***/ })

/******/ });