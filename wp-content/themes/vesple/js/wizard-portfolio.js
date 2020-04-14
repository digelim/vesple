// Matrix functions
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _correlation(d1, d2) {
  var min = Math.min,
      pow = Math.pow,
      sqrt = Math.sqrt;

  var add = function add(a, b) {
    return a + b;
  };

  var n = min(d1.length, d2.length);

  if (n === 0) {
    return 0;
  }

  var _ref = [d1.slice(0, n), d2.slice(0, n)];
  d1 = _ref[0];
  d2 = _ref[1];

  var _map = [d1, d2].map(function (l) {
    return l.reduce(add);
  }),
      _map2 = _slicedToArray(_map, 2),
      sum1 = _map2[0],
      sum2 = _map2[1];

  var _map3 = [d1, d2].map(function (l) {
    return l.reduce(function (a, b) {
      return a + pow(b, 2);
    }, 0);
  }),
      _map4 = _slicedToArray(_map3, 2),
      pow1 = _map4[0],
      pow2 = _map4[1];

  var mulSum = d1.map(function (n, i) {
    return n * d2[i];
  }).reduce(add);
  var dense = sqrt((pow1 - pow(sum1, 2) / n) * (pow2 - pow(sum2, 2) / n));

  if (dense === 0) {
    return 0;
  }

  return (mulSum - sum1 * sum2 / n) / dense;
};

function _average(array) {
  var sum;
  var average = 0;

  if (array.length) {
    sum = array.reduce(function (a, b) {
      return a + b;
    });

    average = sum / array.length;
  }

  return average;
};

function _standardDeviation(array) {
  var average = _average(array);

  var diffs = array.map(function (value) {
    return value - average;
  });

  var squareDiffs = diffs.map(function (diff) {
    return diff * diff;
  });

  var avgSquareDiff = _average(squareDiffs);

  return Math.sqrt(avgSquareDiff);
};

function _sumProduct(a, b) {
  return math.sum(math.dotMultiply(a, b));
}

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

// Create the current and optimal portfolio comparison table
function getComparisonData(assets, currentAssetsPercents, optimalAssetsPercents) {
  var comparisonData = [];
  var comparisonCurrentPortfolioData = assets.map(function (asset, index) {
    var data = {};

    data.name = 'Current portfolio';
    data.axis = asset.symbol;
    data.value = currentAssetsPercents[index];

    return data;
  });

  var comparisonOptimalPortfolioData = assets.map(function (asset, index) {
    var data = {};

    data.name = 'Optimal portfolio';
    data.axis = asset.symbol;
    data.value = optimalAssetsPercents[index];

    return data;
  });

  comparisonData.push(comparisonCurrentPortfolioData);
  comparisonData.push(comparisonOptimalPortfolioData);

  return comparisonData;
};

// Get current total value of a given asset
function _assetCurrentValue(asset) {
  var number = _assetIHaveNumber(asset);
  var price = _getCurrentAssetPrice(asset);

  return number * price;
};

// Get the relative weight of all assets
function assetIHavePercents(assets, portfolioValue) {
  var percents = [];

  for (var i = 0; i < assets.length; i++) {
    var asset = assets[i];
    var assetValue = _assetCurrentValue(asset);
    var percent = 0;

    if (portfolioValue) {
     percent = assetValue / portfolioValue;
    }

    percents.push(percent);
  }

  return percents;
};

// Get the current total portfolio value
function portfolioCurrentValue(assets) {
  var value = 0;
  var assetCurrentValue = 0;

  for (var i = 0; i < assets.length; i++) {
    var asset = assets[i];

    assetCurrentValue = _assetCurrentValue(asset);
    value += assetCurrentValue;
  }

  return value;
};

// Calculates the average returns for all the assets
function _currentAverageReturns(assets, returns) {
  var averageReturns = [];

  for (var i = 0; i < assets.length; i++) {
    var average = _average(returns[i]);

    averageReturns.push(average);
  }

  return averageReturns;
};

// Get elements instersect
function intersect(a, b) {
  var aa = {};

  a.forEach(function(v) { aa[v]=1; });

  return b.filter(function(v) { return v in aa; });
}

// Get the returns for all assets in portfolio
function _getAssetsReturns(assets) {
  //var returns = asset.returns;
  var keys = [];
  var filteredReturns = [];

  for (var i = 0; i < assets.length; i++) {
    var allReturns = assets[i].returns;

    keys.push(Object.keys(allReturns));
  }

  var commonKeys = keys.reduce(intersect);

  for (var i = 0; i < assets.length; i++) {
    filteredReturns.push(commonKeys.map(function(key, index) {
      return assets[i].returns[key].change/100;
    }));
  }

  return filteredReturns;
};

// Calculates the optimal weights for all assets
function iShouldHavePercents(assets, returns) {
  var covarianceMatrix = PortfolioAllocation.covarianceMatrix.apply(void 0, _toConsumableArray(returns));
  var currentAverageReturns = _currentAverageReturns(assets, returns);
  var optimalWeights = PortfolioAllocation.maximumSharpeRatioWeights(currentAverageReturns, covarianceMatrix, 0);

  return optimalWeights;
};

// Calculates how many stocks one should have given the optimal weights, assets and the current total value
function iShouldHaveNumbers(optimalWeights, assets, portfolioValue) {
  var iShouldHaveArray = [];
  var iWillInvest = parseInt(investment.iWillInvest) || 0;
  var iShouldHaveNum;
  var optimalWeight;
  var price;

  for (var i = 0; i < optimalWeights.length; i++) {
    optimalWeight = optimalWeights[i];
    price = _getCurrentAssetPrice(assets[i]);
    iShouldHaveNum = Math.floor(optimalWeight * (portfolioValue + iWillInvest) / price);
    iShouldHaveArray.push(iShouldHaveNum);
  }

  return iShouldHaveArray;
};

// Calculates how many stocks one should buy for all assets given the current and optimal quantities
function iShouldBuy(currentAssetsNumbers, optimalAssetsNumbers) {
  var toBuy = currentAssetsNumbers.map(function (number, index) {
    return optimalAssetsNumbers[index] - currentAssetsNumbers[index];
  });

  return toBuy;
};

// Calculates portfolio risk for given weights and assets
function _portfolioRisk(weights, assets, returns) {
  var weightsStandardDeviationMatrix = [];
  var standardDeviationWeights = [];
  var correlationMatrix = [];
  var standardDeviationWeightsTranspose = [];

  for (var i = 0; i < assets.length; i++) {
    var asset1 = returns[i];

    var standardDeviation = _standardDeviation(asset1);

    standardDeviationWeights.push(standardDeviation * weights[i]);
    correlationMatrix[i] = [];
    standardDeviationWeightsTranspose.push([standardDeviation * weights[i]]);

    for (var j = 0; j < assets.length; j++) {
      var asset2 = returns[j];

      correlationMatrix[i][j] = _correlation(asset1, asset2);
    }
  }

  var A = [standardDeviationWeights];
  var B = correlationMatrix;
  var C = standardDeviationWeightsTranspose;
  var portfolioRisk = math.multiply((math.multiply(A, B)), C)[0][0];

  return portfolioRisk;
};

// Calculates the portfolio risk reduction
function optimalPortfolioRiskReduced(currentAssetsPercents, optimalAssetsPercents, assets, returns) {
  var currentRisk = _portfolioRisk(currentAssetsPercents, assets, returns);
  var optimalRisk = _portfolioRisk(optimalAssetsPercents, assets, returns);

  return (currentRisk - optimalRisk) / optimalRisk;
};

// Calculate monthly volatility based on daily voliatility
function _monthlyVolatility(dailyRisk) {
  var monthly = dailyRisk * Math.sqrt(30); //we assume there are 30 trading days in a month

  return monthly;
};

// Caluclate the average portfolio regurn for given weights and returns
function _portfolioReturn(weights, averageReturns) {
  var averageReturn = _sumProduct(weights, averageReturns);
  return averageReturn;
};

// Calculates the return change for a given pair of portfolios
function optimalPortfolioReturnIncreased(currentPortfolioReturn, optimalPortfolioReturn) {
  var returnIncreased = (optimalPortfolioReturn - currentPortfolioReturn) / currentPortfolioReturn;
  return returnIncreased;
};

// Calculates the average monthly return for a given daily average
function _monthlyReturns(dailyReturn) {
  var monthly = Math.pow(dailyReturn + 1, 30) - 1;
  return monthly;
};

// Gets asset's current price
function _getCurrentAssetPrice(asset) {
  var price = 0;
  var keys = Object.keys(asset.returns);
  var last = keys.length - 1;
  var lastKey = keys[last];

  price = asset.returns[lastKey].close;

  return price;
};

// Gets the current asset quantity
function _assetIHaveNumber(asset) {
  return parseInt(asset.quantity);
};

// Gets the all the quantities of current portfolio
function iHaveNumbers(assets) {
  var numbers = assets.map(function(asset) {
    return asset.quantity;
  });

  return numbers;
};

// generate returns based on risk and montlhly average
function portfolioReturnsGenerator(result, risk) {
  var returns = [];
  var randomResult = 1;

  for (var i = 0; i < 360; i++) {
    randomResult = result;
    returns.push(randomResult);
  }

  return returns;
};

// Generates the expected results data for displaying a chart
function expectedResults(simulationYears, monthlyResults, initialInvestment, dividends, dividendsGrowth, inflation, regularMonthsPeriod, regularInvestment, regularInvestmentGrowthRate, portfolioValue) {
  var months = Math.min(360, simulationYears * 12);
  var percent = 1;
  initialInvestment = parseInt(initialInvestment);
  dividendsGrowth = parseFloat(dividendsGrowth);
  inflation = parseFloat(inflation);
  regularInvestmentGrowthRate = parseFloat(regularInvestmentGrowthRate);
  regularInvestment = parseInt(regularInvestment);


  var value = (initialInvestment || 0) + (portfolioValue || 1);
  var x = moment().valueOf();
  var y = parseInt(value);

  var results = [{
    percent: percent,
    value: value,
    x: x,
    y: y
  }];

  for (var i = 1; i < months; i++) {
    if (regularInvestment) {
      if (i % regularMonthsPeriod === 0) {
        if ( i % 12 === 0 && regularInvestmentGrowthRate) {
          regularInvestment *= 1 + (regularInvestmentGrowthRate/100);
        }

        value += regularInvestment;
        percent *= 1 + (value - results[i - 1].value) / results[i - 1].value;
      }
    }

    percent *= 1 + monthlyResults[i];
    value = ((initialInvestment || 0) + (portfolioValue || 1)) * percent;

    if (dividends) {
      if (i % 12 === 0) {
        value *= 1 + dividends * (dividendsGrowth/100);
        percent *= 1 + (value - results[i - 1].value) / results[i - 1].value;
      }
    }

    if (inflation) {
      if (i % 12 === 0) {
        value *= (1 - (inflation/100));
        percent *= 1 + (value - results[i - 1].value) / results[i - 1].value;
      }
    }

    x = moment().add(i, 'months').valueOf();
    y = value;

    var result = {
      percent: percent,
      value: value,
      x: x,
      y: y
    };

    results.push(result);
  }

  return results;
};

function renderPerformanceChart(current, optimal, simulationYears) {
  var currentData = {};
  var optimalData = {};

  if (current.length > 0) {
    currentData = {
      color: '#eceef9',
      className: 'chart1-current',
      name: 'Current portfolio',
      data: current.slice(0, simulationYears * 12)
    }
  }

  if (optimal.length > 0) {
    optimalData = {
      color: 'url(#diagonal-stripe-1)',
      className: 'chart1-optimized',
      name: 'Optimal portfolio',
      data: optimal.slice(0, simulationYears * 12)
    }

    console.log(optimal);
  }

  series = [optimalData, currentData];

  var graph = new Rickshaw.Graph({
    element: document.querySelector('#chart1'),
    renderer: 'area',
    series: series,
    stack: false,
  });

  var Hover = Rickshaw.Class.create(Rickshaw.Graph.HoverDetail, {
    render: function render(args) {
      var details = document.createElement('table');

      details.className = 'details-table';
      details.innerHTML = '<thead><tr class="labels"><th>Label</th><th class="label-s1 light caps ">date</th><th class="label-s1 light caps ">expected ($)</th></tr></thead>';
      details.style.top = args.mouseY + "px";
      this.element.appendChild(details);

      var boundingRect = this.element.parentNode.getBoundingClientRect();

      if (args.mouseX > boundingRect.width * 2 / 3) {
        this.element.classList.remove('left');
        this.element.classList.add('right');
      } else {
        this.element.classList.remove('right');
        this.element.classList.add('left');
      }

      var tbody = document.createElement('tbody');
      args.detail.sort(function (a, b) {
        return a.order - b.order;
      }).forEach(function (d) {
        var line = document.createElement('tr');
        var swatch = document.createElement('td');

        swatch.className = 'swatch ' + d.series.className;

        var div = document.createElement('div');
        var ePercent = document.createElement('td');

        ePercent.className = 'expected-change';
        ePercent.innerHTML = moment(d.value.x).format('MM/YY');
        //ePercent.innerHTML = parseInt(d.value.percent * 100) - 100 + '%';

        var eValue = document.createElement('td');

        eValue.className = 'expected-value';

        eValue.innerHTML = '$' + d.value.y.toLocaleString('en-US', {
          maximumFractionDigits: 0
        });

        swatch.appendChild(div);
        line.appendChild(swatch);
        line.appendChild(ePercent);
        line.appendChild(eValue);
        tbody.appendChild(line);

        var dot = document.createElement('div');

        dot.className = 'dot ' + d.series.className;
        dot.style.top = graph.y(d.value.y0 + d.value.y) + 'px';
        dot.style.borderColor = d.series.color;
        this.element.appendChild(dot);
        dot.className = 'dot active ' + d.series.className;
        this.show();
      }, this);

      details.appendChild(tbody);
    }
  });

  var hover = new Hover({
    graph: graph
  });

  var xAxis = new Rickshaw.Graph.Axis.X({
    graph: graph,
    tickFormat: function tickFormat(x) {
      return moment(x).format('MM/YY');
    },
    element: document.getElementById('chart1X')
  });

  xAxis.render();

  var legend = new Rickshaw.Graph.Legend({
    graph: graph,
    element: document.getElementById('chart1Legend')
  });

  //graph.renderer.unstack = true;
  graph.render();
}

function renderRadarChart(data) {
  var $ = jQuery;
  var margin = {
    top: 50,
    right: 70,
    bottom: 50,
    left: 70
  };

  if (window.innerWidth < 768) {
    margin.top = 20;
    margin.bottom = 20;
    margin.left = 50;
    margin.right = 50;
  }

  var w = Math.max(260, $('.comparison-box').width() * 0.6) - margin.left - margin.right;
  var h = Math.max(260, $('.comparison-box').width() * 0.6);
  var color = d3.scale.ordinal().range(['#495dc6', "#fdd368"]);
  var opacity = d3.scale.ordinal().range(['0.3', '1']);

  var radarChartOptions = {
    w: w,
    h: h,
    margin: margin,
    maxValue: 1,
    levels: 6,
    roundStrokes: true,
    color: color,
    opacity: opacity
  };

  RadarChart(".radarChart", data, radarChartOptions);
}

// Clear charts for rendering again
function emptyCharts() {
  var $ = jQuery;

  $('#chart1, #chart1Legend, #chart1X').empty();
}

jQuery(document).ready(function($) {
  try {
    var returns = _getAssetsReturns(assets);
    var optimalAssetsPercents = iShouldHavePercents(assets, returns);

    if (optimalAssetsPercents) {
      var portfolioValue = portfolioCurrentValue(assets);
      var optimalAssetsNumbers = iShouldHaveNumbers(optimalAssetsPercents, assets, portfolioValue);
      var currentAssetsPercents = assetIHavePercents(assets, portfolioValue);
      var currentAssetsNumbers = iHaveNumbers(assets);
      var toBuy = iShouldBuy(currentAssetsNumbers, optimalAssetsNumbers);
      var riskChange = optimalPortfolioRiskReduced(currentAssetsPercents, optimalAssetsPercents, assets, returns);
      var optimalPortfolioRisk = _portfolioRisk(optimalAssetsPercents, assets, returns);
      var optimalMonthlyVolatility = _monthlyVolatility(optimalPortfolioRisk);
      var currentPortioRisk = _portfolioRisk(currentAssetsPercents, assets, returns);
      var currentMonthlyVolatility = _monthlyVolatility(currentPortioRisk);
      var assetsReturn = _currentAverageReturns(assets, returns);
      var currentPortfolioReturn = _portfolioReturn(currentAssetsPercents, assetsReturn);
      var optimalPortfolioReturn = _portfolioReturn(optimalAssetsPercents, assetsReturn);
      var returnChange = optimalPortfolioReturnIncreased(currentPortfolioReturn, optimalPortfolioReturn);
      var currentMonthlyReturn = _monthlyReturns(currentPortfolioReturn);
      var optimalMonthlyReturn = _monthlyReturns(optimalPortfolioReturn);
      var optimalMonthlyReturns = portfolioReturnsGenerator(optimalMonthlyReturn, optimalMonthlyVolatility);
      var currentMonthlyReturns = portfolioReturnsGenerator(currentMonthlyReturn, currentMonthlyVolatility);
      var dividendsGrowth = investment.dividendsGrowth;
      var inflation = investment.inflation;
      var regularInvestmentGrowthRate = investment.regularInvestmentGrowthRate;
      var portfolioCurrentExpectedResults = expectedResults(30, currentMonthlyReturns, investment.iWillInvest, investment.dividends/100, dividendsGrowth, inflation, investment.regularMonthsPeriod, investment.regularInvestment, regularInvestmentGrowthRate, portfolioValue);
      var portfolioOptimalExpectedResults = expectedResults(30, optimalMonthlyReturns, investment.iWillInvest, investment.dividends/100, dividendsGrowth, inflation, investment.regularMonthsPeriod, investment.regularInvestment, regularInvestmentGrowthRate, portfolioValue);
      var comparisonData = getComparisonData(assets, currentAssetsPercents, optimalAssetsPercents);

      // Portfolio optimization results
      for (var i = 0; i < assets.length; i++) {
        $('form').append('<input type="hidden" name="weight[]" value="' + currentAssetsPercents[i] + '">');
        $('form').append('<input type="hidden" name="optimal_weights[]" value="' + optimalAssetsPercents[i] + '">');
        $('form').append('<input type="hidden" name="optimal_quantity[]" value="' + optimalAssetsNumbers[i] + '">');
        $('form').append('<input type="hidden" name="needs_to_buy_or_sell[]" value="' + toBuy[i] + '">');
      }

      $('form').append('<input type="hidden" name="risk_reduction" value="' + riskChange + '">');
      $('form').append('<input type="hidden" name="return_increase" value="' + returnChange + '">');
      $('form').append('<input type="hidden" name="expected_monthly_average_return" value="' + optimalMonthlyReturn + '">');
      $('form').append('<input type="hidden" name="current_average_monthly_return" value="' + currentMonthlyReturn + '">');
      $('form').append('<input type="hidden" name="portfolio_value" value="' + portfolioValue + '">');
      $('form').append('<input type="hidden" name="current_portfolio_expected_results" value="' + JSON.stringify(portfolioCurrentExpectedResults).replace(/["]/g, "'") + '">');
      $('form').append('<input type="hidden" name="optimal_portfolio_expected_results" value="' + JSON.stringify(portfolioOptimalExpectedResults).replace(/["]/g, "'") + '">');

      window.portfolioData = {
        assets: assets,
        investment: investment,
        portfolioValue: portfolioValue,
        optimalAssetsNumbers: optimalAssetsNumbers,
        optimalAssetsPercents: optimalAssetsPercents,
        currentAssetsPercents: currentAssetsPercents,
        currentAssetsNumbers: currentAssetsNumbers,
        toBuy: toBuy,
        riskChange: riskChange,
        optimalPortfolioRisk: optimalPortfolioRisk,
        optimalMonthlyVolatility: optimalMonthlyVolatility,
        currentPortioRisk: currentPortioRisk,
        currentMonthlyVolatility: currentMonthlyVolatility,
        assetsReturn: assetsReturn,
        currentPortfolioReturn: currentPortfolioReturn,
        optimalPortfolioReturn: optimalPortfolioReturn,
        returnChange: returnChange,
        currentMonthlyReturn: currentMonthlyReturn,
        optimalMonthlyReturn: optimalMonthlyReturn,
        optimalMonthlyReturns: optimalMonthlyReturns,
        currentMonthlyReturns: currentMonthlyReturns,
        portfolioCurrentExpectedResults: portfolioCurrentExpectedResults,
        portfolioOptimalExpectedResults: portfolioOptimalExpectedResults,
        comparisonData: comparisonData
      }

      var template = wp.template('portfolio');

      $('#portfolio-container').append(template(portfolioData));

      renderPerformanceChart(portfolioCurrentExpectedResults, portfolioOptimalExpectedResults, 10);
      renderRadarChart(comparisonData);

      window.observe.registerListener(function(val) {
        emptyCharts();
        renderPerformanceChart(portfolioData.portfolioCurrentExpectedResults, portfolioData.portfolioOptimalExpectedResults, val || 5 );
      });

    }
  } catch (exception) {
    if (exception.message === 'no corner portfolio with a strictly positive excess return') {
      console.log('Nenhuma carteira com retorno positivo encontrada.');
    } else {
      console.log(exception);
    }
  }

  $(window).on('resize', function() {
    $('.radarChart').empty();
    emptyCharts();
    renderPerformanceChart(portfolioData.portfolioCurrentExpectedResults, portfolioData.portfolioOptimalExpectedResults, window.observe.simulationYears);
    renderRadarChart(portfolioData.comparisonData);
  })
});
