/*
 (c) 2017, Vladimir Agafonkin
 Simplify.js, a high-performance JS polyline simplification library
 mourner.github.io/simplify-js
*/

(function () { 'use strict';

// to suit your point format, run search/replace for '.x' and '.y';
// for 3D version, see 3d branch (configurability would draw significant performance overhead)

// square distance between 2 points
function getSqDist(p1, p2) {

    var dx = p1.x - p2.x,
        dy = p1.y - p2.y;

    return dx * dx + dy * dy;
}

// square distance from a point to a segment
function getSqSegDist(p, p1, p2) {

    var x = p1.x,
        y = p1.y,
        dx = p2.x - x,
        dy = p2.y - y;

    if (dx !== 0 || dy !== 0) {

        var t = ((p.x - x) * dx + (p.y - y) * dy) / (dx * dx + dy * dy);

        if (t > 1) {
            x = p2.x;
            y = p2.y;

        } else if (t > 0) {
            x += dx * t;
            y += dy * t;
        }
    }

    dx = p.x - x;
    dy = p.y - y;

    return dx * dx + dy * dy;
}
// rest of the code doesn't care about point format

// basic distance-based simplification
function simplifyRadialDist(points, sqTolerance) {

    var prevPoint = points[0],
        newPoints = [prevPoint],
        point;

    for (var i = 1, len = points.length; i < len; i++) {
        point = points[i];

        if (getSqDist(point, prevPoint) > sqTolerance) {
            newPoints.push(point);
            prevPoint = point;
        }
    }

    if (prevPoint !== point) newPoints.push(point);

    return newPoints;
}

function simplifyDPStep(points, first, last, sqTolerance, simplified) {
    var maxSqDist = sqTolerance,
        index;

    for (var i = first + 1; i < last; i++) {
        var sqDist = getSqSegDist(points[i], points[first], points[last]);

        if (sqDist > maxSqDist) {
            index = i;
            maxSqDist = sqDist;
        }
    }

    if (maxSqDist > sqTolerance) {
        if (index - first > 1) simplifyDPStep(points, first, index, sqTolerance, simplified);
        simplified.push(points[index]);
        if (last - index > 1) simplifyDPStep(points, index, last, sqTolerance, simplified);
    }
}

// simplification using Ramer-Douglas-Peucker algorithm
function simplifyDouglasPeucker(points, sqTolerance) {
    var last = points.length - 1;

    var simplified = [points[0]];
    simplifyDPStep(points, 0, last, sqTolerance, simplified);
    simplified.push(points[last]);

    return simplified;
}

// both algorithms combined for awesome performance
function simplify(points, tolerance, highestQuality) {

    if (points.length <= 2) return points;

    var sqTolerance = tolerance !== undefined ? tolerance * tolerance : 1;

    points = highestQuality ? points : simplifyRadialDist(points, sqTolerance);
    points = simplifyDouglasPeucker(points, sqTolerance);

    return points;
}

// export as AMD module / Node module / browser or worker variable
if (typeof define === 'function' && define.amd) define(function() { return simplify; });
else if (typeof module !== 'undefined') {
    module.exports = simplify;
    module.exports.default = simplify;
} else if (typeof self !== 'undefined') self.simplify = simplify;
else window.simplify = simplify;

})();

jQuery(document).ready(function($) {
  var existingAssets = [];

  function appendAsset(symbol, name, quantity) {
    // Append new asset item here
    if (existingAssets.indexOf(symbol) <= 0) {
      $.getJSON('https://vesple.com/asset/' + symbol, function(apiData) {
        var dates = Object.keys(apiData.returns);

        var data = dates.map(function(date, index, array) {
          return {
            close: apiData.returns[date].close,
            date: date,
            change: array[index+1] ? (apiData.returns[date].close - apiData.returns[array[index+1]].close) / apiData.returns[array[index+1]].close : 0,
            x: index,
            y: apiData.returns[date].close,
          };
        }).slice(-365);

        data = simplify(data, 3.2, true);

        var assetContent = {
          color: apiData.returns[dates[dates.length - 1]].change >= 0 ? '#37c171' : '#ed0123',
          signal: apiData.returns[dates[dates.length - 1]].change > 0 ? '+' : '',
          cents: (apiData.returns[dates[dates.length - 1]].close - apiData.returns[dates[dates.length - 2]].close).toFixed(2),
          symbol: symbol,
          name: name,
          close: apiData.returns[dates[dates.length - 1]].close,
          change: apiData.returns[dates[dates.length - 1]].change,
          exchange: apiData.exchange,
          currency: apiData.currency,
          quantity: quantity,
        }

        var template = wp.template('assets-list');

        $('.assets-list ul').append(template(assetContent));

        $('[data-remove="item-' + symbol + '"]').on('click', function(e) {
          e.preventDefault();
          $('#item-' + symbol).remove();
        });

        var element = document.querySelector('#a-' + symbol.replace(/\./g, '\\\.'));

        if (element) {
          var graph = new Rickshaw.Graph({
            element,
            renderer: 'area',
            series: [,
              {
                color: 'url(#diagonal-stripe-1)',
                className: 'chart2-current',
                name: 'Portfolio atual',
                data: data,
              }
            ],
            interpolation: 'cardinal',
          });

          graph.render();
        }
      }).error(function(error) {
        console.log(error);
      });

      existingAssets.push(symbol);
    }
  }

  var assets = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
    identify: function(obj) {
      return obj['symbol'];
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: 'https://vesple.com?s=%QUERY&post_type=asset',
      wildcard: '%QUERY',
      filter: function (suggestions) {
        return suggestions.map(function(suggestion) {
          return {
            symbol: suggestion['symbol'],
            name: suggestion['name']
          }
        });
      }
    }
  });

  $('.typeahead').typeahead({
    hint: true,
    highlight: true,
    minLength: 1,
    limit: 10,
  }, {
    name: 'best-pictures',
    source: assets,
    display: 'symbol',
    templates: {
      empty: '<div class="m-l-20 asset-suggestion">No results.</div>',
      suggestion: function (data) {
        console.log(data);
        return '<div class="assets-suggestion"><div class="left">' + data.symbol + '</div><div class="right">' + data.name + '</div></div>';
      }
    },
  });

  $('.typeahead').on('typeahead:select', function(e, suggestion) {
    var template = wp.template('selected-assets');

    var content = {
      symbol: suggestion.symbol,
      quantity: 0,
    }

    $('#selected-assets').append(template(content));

    $('#save-quantity-' + suggestion.symbol.replace(/\./g, '\\\.')).on('click', function(event) {
      event.preventDefault();

      var quantity = $(this).parent().find('[name="stocks-amount"]').val();

      if ($('#item-' + suggestion.symbol.replace(/\./g, '\\\.')).length <= 0) {
        appendAsset(suggestion.symbol, suggestion.name, quantity);
      } else {
        $('#item-' + suggestion.symbol.replace(/\./g, '\\\.')).find('[name="stock-quantity[]"]').val(quantity);
        $('#item-' + suggestion.symbol.replace(/\./g, '\\\.') + ' span b').text(quantity);
      }

      $('.assets-popup-overlay').remove();

    });

    $('#close-assets-popup').on('click', function(event) {
      event.preventDefault();
      $('.assets-popup-overlay').remove();
    });

  });

  for (var i = 0; i < assetsToLoad.length; i++) {
    appendAsset(assetsToLoad[i].symbol, assetsToLoad[i].name, assetsToLoad[i].quantity);
  }
});


$ = jQuery;

$(window).load(function() {
  $('.add-shares-btn').on('click', function() {
    var symbol = $(this).attr('data-symbol');
    var quantity = $(this).find('[name="stock-quantity[]"]').val();
    var template = wp.template('selected-assets');

    var content = {
      symbol: symbol,
      quantity: quantity,
    }

    $('#selected-assets').append(template(content));

    // $('#edit-quantity-' + symbol.replace(/\./g, '\\\.')).on('click', function(event) {
    //   event.preventDefault();
    //
    //   var quantity = $(this).parent().find('[name="stocks-amount"]').val();
    //
    //   $('#item-' + symbol.replace(/\./g, '\\\.')).find('[name="stock-quantity[]"]').val(quantity);
    //   $('#item-' + symbol.replace(/\./g, '\\\.') + ' span b').text(quantity);
    //   $('.assets-popup-overlay').remove();
    //
    // });

  });
})
