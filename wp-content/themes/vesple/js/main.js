// Change simulation years
window.observe = {
  aInternal: 10,
  aListener: function(val) {},
  set simulationYears(val) {
    this.aInternal = val;
    this.aListener(val);
  },
  get simulationYears() {
    return this.aInternal;
  },
  registerListener: function(listener) {
    this.aListener = listener;
  }
}

window.observe.simulationYears = 5;

jQuery(document).ready(function($) {
  // Accept numbers only
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };

  $('input[type="tel"]').inputFilter(function(value) {
    return /^\d*$/.test(value);
  });

  // Comparison table display toggle
  $('.form-switch input').on('change', function() {
    $('.comparison-table-quantity, .comparison-table-percents').toggle();
  });

  $('.icon-edit').on('click', function(e) {
    e.preventDefault();
    $('.investment-period').html('');
    $('.investment-period').focus();
  });

  $('.investment-period').on('keypress', function(e) {
    if (isNaN(String.fromCharCode(e.which) || e.key === ' ' || e.key === 'Spacebar')) e.preventDefault();
  });

  $('.investment-period').on('keydown', function(e) {
    var currentValue = Number($(e.currentTarget).text());
    var typed = Number(String.fromCharCode(e.which));
    var prohibitedNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    var isProhibited = $.inArray(currentValue, prohibitedNumbers) && currentValue > 3 || currentValue === 3 && typed !== 0;
    var isDeleteOrBackspaceKey = e.which == 8 || e.which == 46;

    if ((currentValue > 30 || isProhibited) && !isDeleteOrBackspaceKey) {
      e.preventDefault();
    }
  });

  $('.investment-period').on('blur', function() {
    window.observe.simulationYears = Math.min(30, Number($('.investment-period').text())) || 5;
    $('.investment-period').html(window.observe.simulationYears);
  });

  if ($('body').hasClass('page-id-5')) {
    init();  
  }
});

function _instanceof(left, right) { if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) { return !!right[Symbol.hasInstance](left); } else { return left instanceof right; } }

function _classCallCheck(instance, Constructor) { if (!_instanceof(instance, Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var TypeWriter = /*#__PURE__*/function () {
  function TypeWriter(txtElement, words) {
    var wait = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 3000;

    _classCallCheck(this, TypeWriter);

    this.txtElement = txtElement;
    this.words = words;
    this.txt = '';
    this.wordIndex = 0;
    this.wait = parseInt(wait, 10);
    this.type();
    this.isDeleting = false;
  }

  _createClass(TypeWriter, [{
    key: "type",
    value: function type() {
      var _this = this;
      var current = this.wordIndex % this.words.length;
      var fullTxt = this.words[current];

      if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
      } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
      }


      this.txtElement.innerHTML = "<span class=\"txt\">".concat(this.txt, "</span>"); // Initial Type Speed

      var typeSpeed = 200;

      if (this.isDeleting) {
        typeSpeed /= 2;
      }


      if (!this.isDeleting && this.txt === fullTxt) {
        typeSpeed = this.wait;

        this.isDeleting = true;
      } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;

        this.wordIndex++;

        typeSpeed = 350;
      }

      setTimeout(function () {
        return _this.type();
      }, typeSpeed);
    }
  }]);

  return TypeWriter;
}();

function init() {
  var txtElement = document.querySelector('.txt-type');
  var words = JSON.parse(txtElement.getAttribute('data-words'));
  var wait = txtElement.getAttribute('data-wait');

  new TypeWriter(txtElement, words, wait);
}
