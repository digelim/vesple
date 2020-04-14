jQuery(document).ready(function($) {
  $('input[name="radio-group"]').on('change', function() {
    var regularInvestment = $('#test2').is(':checked') ? true : false;

    if (regularInvestment) {
      $('.regular-investment-fields').slideDown();
    } else {
      $('.regular-investment-fields').hide();
    }
  });

  $('#optimize-portfolio').on('click', function(e) {
    e.preventDefault();

  });

  $('[name="regular-investment-growth-rate"]').mask('00,00%', {reverse: true, clearMaskOnSubmit: true});
  $('[name="dividends"]').mask('00,00%', {reverse: true, clearMaskOnSubmit: true});
  $('[name="dividends-growth"]').mask('00,00%', {reverse: true, clearMaskOnSubmit: true});
  $('[name="inflation"]').mask('00,00%', {reverse: true, clearMaskOnSubmit: true});

  $('[name="investment-amount"]').mask('000.000.000.000.000', {reverse: true, clearMaskOnSubmit: true});
  $('[name="investment-interval"]').mask('00');
  $('[name="investment-value"]').mask('000.000.000.000.000', {reverse: true, clearMaskOnSubmit: true})

  $('form').on('submit', function(e) {
    if ( $('iframe').hasClass('active') ) {
      e.preventDefault();
      $('iframe').fadeIn();
    }
  });
});

function removeIframe(transactionId, value) {
  $iframe = jQuery('iframe');
  $iframe.remove();
  jQuery('form').submit();
}
