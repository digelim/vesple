/*	Function: renderPieChart
  *	Variables:
  *		*	dataset: contains the input data for plotting the pie chart,
  *					input should be in the form of array of objects where each object should be like {label: , value: }
*		*	dom_element_to_append_to : class name of the div element where the graph have to be appended
*	Contains transitions and hover effects, load the css file 'css/pieChart.css' at the top of html page where the pie chart has to be loaded
*/
function renderPieChart(dataset, dom_element_to_append_to, colorScheme){
  var $ = jQuery;
  var margin = { top: 0,bottom: 0,left: 0,right: 0 };
  var width = Math.max(260, $('#portfolio-distribution').width()) - margin.left - margin.right,
  height = width,
  radius = Math.min(width, height) / 2;
  var donutWidth = 65;
  var legendRectSize = 18;
  var legendSpacing = 4;

  dataset.forEach(function(item){
    item.enabled = true;
  });

  var color = d3.scale.ordinal()
  .range(colorScheme);

  d3.select(dom_element_to_append_to).select('svg').remove();

  var svg =  d3.select(dom_element_to_append_to)
  .append("svg")
  .attr("width", width)
  .attr("height", height)
  .append("g")
  .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");


  var arc = d3.svg.arc()
  .outerRadius(radius - 10)
  .innerRadius(radius - donutWidth);

  var pie = d3.layout.pie()
  .sort(null)
  .value(function(d) { return d.value; });

  var tooltip = d3.select(dom_element_to_append_to)
  .append('div')
  .attr('class', 'tooltip');

  tooltip.append('div')
  .attr('class', 'swatch');

  tooltip.append('div')
  .attr('class', 'label label-s2 dark');

  tooltip.append('div')
  .attr('class', 'percent label-s2 dark');

  var path = svg.selectAll('path')
  .data(pie(dataset));

  path.enter()
  .append('path')
  .attr('d', arc)
  .attr('fill', function(d, i) {
    return color(d.data.label);
  })
  .attr('stroke', '#fff')
  .attr('stroke-width', 5)
  .each(function(d) { this._current = d; });

  path.transition().duration(100);

  path.exit().remove();

  path.on('mouseover', function(d) {
    var total = d3.sum(dataset.map(function(d) {
      return (d.enabled) ? d.value : 0;
    }));

    var percent = Math.round(1000 * d.data.value / total) / 10;
    tooltip.select('.label').html(d.data.label.toUpperCase() + ": ");
    tooltip.select('.swatch').style('background', color(d.data.label));
    tooltip.select('.percent').html(percent + '%');

    tooltip.style('display', 'flex');
    tooltip.style('opacity',1);

  });


  path.on('mousemove', function(d) {
    tooltip.style('top', (d3.event.layerY + 10) + 'px')
    .style('left', (d3.event.layerX - 25) + 'px');
  });

  path.on('mouseout', function() {
    tooltip.style('display', 'none');
    tooltip.style('opacity',0);
  });

  var legend5 = d3.select('.legend5').selectAll("legend")
            .data(color.domain())

        legend5.enter().append("div")
        .attr("class","legend")

        legend5.append("div").style("background", color )
        legend5.append("span").html(function(d,i) { return d } )

  function arcTween(a) {
	  var i = d3.interpolate(this._current, a);
	  this._current = i(0);
	  return function(t) {
	    return arc(i(t));
	  };
	}
};
