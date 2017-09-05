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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 46);
/******/ })
/************************************************************************/
/******/ ({

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, exports) {

$(document).ready(function () {
    $('#payment-check-all').click(function () {
        $('.payment-checkbox').prop('checked', this.checked);
    });

    $('#create-new-payment').click(function () {
        location.href = '/payment/create';
    });

    $('#split-payments').click(function () {
        var paymentIds = getPaymentIds();
        if (paymentIds.length == 0) {
            flash('You need to select the payments first.', 'warning');
        } else {
            $("#group-split-payment-modal #paymentIds").val(paymentIds);
            $("#group-split-payment-modal").modal();
        }
    });

    $(".delete-payment-button").click(function () {
        var element = this;
        var paymentId = element.dataset.paymentId;
        var token = element.dataset.token;
        $.ajax({
            url: '/payment/' + paymentId,
            method: 'POST',
            data: {
                _method: 'delete',
                _token: token
            },
            success: function success(result) {
                flash('Payment was deleted!');
                element.parentElement.parentElement.remove();
            },
            error: function error() {
                flash('There was an error do delete this payment.', 'danger');
            }
        });
    });

    $(".see-bill-button").click(function () {
        var billId = this.dataset.billId;
        var billName = this.dataset.billName;
        $.ajax({
            url: '/bill/' + billId,
            success: function success(result) {
                $("#bill-modal").modal();
                $("#bill-modal .modal-title").html(billName);
                $("#bill-modal .modal-body").html(result);
            },
            error: function error() {
                flash('There was a problem to show this bill.', 'danger');
            }
        });
    });

    getPaymentIds = function getPaymentIds() {
        var paymentCheckbox = document.querySelectorAll('.payment-checkbox:checked');

        var paymentIds = [];
        paymentCheckbox.forEach(function (element) {
            paymentIds.push(element.value);
        });
        return paymentIds;
    };
});

/***/ })

/******/ });