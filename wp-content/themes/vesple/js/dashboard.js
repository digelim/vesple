function _getCurrentAssetPrice(asset) {
  var price = 0;
  var keys = Object.keys(asset.returns);
  var last = keys.length - 1;
  var lastKey = keys[last];

  price = asset.returns[lastKey].close;

  return price;
};

jQuery(document).ready(function($) {
  var colorScheme = ['#5300e8', '#61d800', '#3722f6', '#ba00e5', '#dd0074', '#ff8d00', '#00ACC1', '#E53935', '#8E24AA', '#039BE5', '#00897B', '#C0CA33', '#7CB342', '#43A047', '#FDD835', '#FFB300', '#F4511E', '#546E7A', '#6D4C41', '#FFB300'];

  $(window).on('resize', function () {
    emptyCharts();
    renderCharts();
  });

  function renderCharts() {
    $('.legend').remove();

    if (assets.length > 0) {
      renderPieChart(assets.map(function(asset) {
        var price = _getCurrentAssetPrice(asset);

        asset.value = asset.quantity * price;
        asset.label = asset.symbol;

        return asset;
      }).filter(function(asset) {
        return asset.quantity > 0;
      }), '#portfolio-distribution', colorScheme);
    } else {
      $('#portfolio-distribution').html('');
    }

    var returns = JSON.parse(currentResults.replace(/'/g, '"'));

    var graph = new Rickshaw.Graph({
      element: document.querySelector('#chart3'),
      renderer: 'area',
      series: [{
        color: '#495dc6',
        className: 'chart3-current',
        name: 'Portfolio atual',
        data: returns.slice(0, window.observe.simulationYears * 12)
      }]
    });

    var Hover = Rickshaw.Class.create(Rickshaw.Graph.HoverDetail, {
      render: function render(args) {
        var details = document.createElement('table');
        details.className = 'details-table';
        details.innerHTML = '<thead><tr class="labels"><th>Label</th><th class="label-s1 light caps ">Crescimento</th><th class="label-s1 light caps ">Valor esperado</th></tr></thead>';
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
          ePercent.innerHTML = parseInt(d.value.percent * 100) - 100 + '%';
          var eValue = document.createElement('td');
          eValue.className = 'expected-value';
          eValue.innerHTML = 'R$' + d.value.y.toLocaleString('pt-BR', {
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
      element: document.getElementById('chart3X')
    });
    xAxis.render();
    graph.render();
  }

  function emptyCharts() {
    $('#chart3, #chart3X, #chart3Legend, #portfolio-distribution').empty();
  }

  renderCharts();

  window.observe.registerListener(function(val) {
    emptyCharts();
    renderCharts();
  });
});
