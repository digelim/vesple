<?php global $post; ?>
<form action="<?php echo home_url('/wp-admin/admin-post.php'); ?>" method="post">
  <input type="hidden" name="action" value="save_optimal_portfolio">
  <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
  <div class="steps-overlay">
    <nav class="steps-bar">
      <div class="left">
        <a href="<?php the_permalink(); ?>" class="tab" id="steps-close">
          <span class="icon-delete"></span>
        </a>
        <a href="<?php the_permalink(); ?>/assets" class="tab" id="tab-1">
          <span class="icon-assets-tab"></span>
          <span class="tab-label">Assets</span>
        </a>
        <a href="<?php the_permalink(); ?>/investment" class="tab" id="tab-2">
          <span class="icon-investment-tab"></span>
          <span class="tab-label">investment</span>
        </a>
        <a href="<?php the_permalink(); ?>/portfolio" class="tab active" id="tab-3">
          <span class="icon-portfolio-tab"></span>
          <span class="tab-label">portfolio</span>
        </a>
      </div>
      <div class="right">
        <button type="submit" class="btn btn-next-step">Save portfolio<span class="icon-next-tab"><span class="path1"></span><span class="path2"></span></span></button>
      </div>
    </nav>
    <div class="container" id="portfolio-container">
      <script type="text/html" id="tmpl-portfolio">
        <div class="improved-portfolio">
        <# if(data) { #>
            <img class="m-b-50" style="mix-blend-mode: darken; width: 210px;" src="<?php echo bloginfo('stylesheet_directory'); ?>/img/teste24.png" alt="Portfolio optimzed">
            <p>Congratulations! Your portfolio is good, and it can be even better. <# if (assets.length > 1) { #> Allocate correctly <# } else { #>  Diversify by adding more stocks <# } #><# if(data.riskChange > 0) { #>and reduce the risk by {{(data.riskChange * 100).toFixed(0)}}% <# } #><# if (data.returnChange > 0) { #>and increase the return by {{(data.returnChange * 100).toFixed(0)}}%<# } #>.</p>
            <div class="m-b-60 m-t-10 btns-group justify-content-center">
              <a href="#expected" class="btn btn-round btn-primary btn-medium m-b-100">See how</a>
              <a href="https://www.investopedia.com/managing-wealth/modern-portfolio-theory-why-its-still-hip/" target="_blank" class="btn btn-round btn-ghost-primary btn-medium m-b-100">Learn more</a>
            </div>
        <# } else { #>
            <img class="m-b-50" src="<?php echo bloginfo('stylesheet_directory'); ?>/img/portfolio-not-optimized.svg" style="width: 350px; max-width: 100%; margin-bottom: -30px; margin-top: -30px" alt="Portfolio not optimzed">
            <p>This action could not be completed. Update your portfolio and try again. </p>
        <# } #>
        </div>
        <h1 id="expected" class="m-b-50">Expected performance</h1>
        <ul class="performance-items">
          <li>
            <div class="performance-item-content">
              <div class="label-l1 dark bold m-b-10">${{{(data.portfolioValue).toFixed(0)}}}</div>
              <div class="label-s2 light caps">
                portfolio value
              </div>
            </div>
            <span class="icon-investment-circle"><span class="path1"></span><span class="path2"></span></span>
          </li>
          <li>
            <div class="performance-item-content">
              <span class="label-l1 dark bold m-r-10"><div class="investment-period" contenteditable="true">5</div>Years</span><span class="icon-edit"></span>
              <div class="label-s2 light caps m-t-10">
                Simulation interval
              </div>
            </div>
            <span class="icon-period-circle"><span class="path1"></span><span class="path2"></span></span>
          </li>
          <li>
            <div class="performance-item-content">
              <div class="regular-investment m-b-10">
                <span class="label-l1 dark bold">${{data.investment.regularInvestment}}</span><span class="label-s1 bold dark m-l-10">Every<br>{{{data.investment.regularMonthsPeriod}}} months</span>
              </div>
              <div class="label-s2 light caps">
                Regular investment
              </div>
            </div>
            <span class="icon-regular-amount-circle"><span class="path1"></span><span class="path2"></span></span>
          </li>
          <li class="dividend-yield">
            <div class="performance-item-content">
              <div class="label-l1 dark bold m-b-10">{{{data.investment.inflation}}}%</div>
              <div class="label-s2 light caps">
                Inflation
              </div>
            </div>
            <span class="icon-dividend-circle"><span class="path1"></span><span class="path2"></span></span>
          </li>
        </ul>
        <div class="expected-performance-chart">
          <ul>
            <li>
              <div class="label-s1 light caps">
                Potential return
              </div>
              <div class="label-l1 dark bold">
                {{{(data.optimalMonthlyReturn * 100).toFixed(2)}}}%
              </div>
              <div class="label-s1 dark bold">
                / month
              </div>
            </li>
            <li>
              <div class="label-s1 light caps">
                Current return
              </div>
              <div class="label-l1 dark bold">
                {{{(data.currentMonthlyReturn * 100).toFixed(2)}}}%
              </div>
              <div class="label-s1 dark bold">
                / month
              </div>
            </li>
            <!-- <li>
              <div class="label-s1 light caps">
                perda máxima
              </div>
              <div class="label-l1 dark bold">
                9,5%
              </div>
            </li> -->
            <# if(data.riskChange > 0) { #>
            <li>
              <div class="label-s1 light caps">
                  risk reduced
              </div>
              <div class="label-l1 dark bold">
                {{(data.riskChange * 100).toFixed(0)}}%
              </div>
            </li>
            <# } else { #>
              <li>
                <div class="label-s1 light caps">
                    risk increased
                </div>
                <div class="label-l1 dark bold">
                  {{(Math.abs(data.riskChange * 100)).toFixed(0)}}%
                </div>
              </li>
            <# } #>
            <# if(data.returnChange > 0) { #>
            <li>
              <div class="label-s1 light caps">
                  return increased
              </div>
              <div class="label-l1 dark bold">
                {{(data.returnChange * 100).toFixed(0)}}%
              </div>
            </li>
            <# } else { #>
              <li>
                <div class="label-s1 light caps">
                    return reduced
                </div>
                <div class="label-l1 dark bold">
                  {{(Math.abs(data.returnChange * 100)).toFixed(0)}}%
                </div>
              </li>
            <# } #>
          </ul>
          <div class="chart-wrapper">
            <div class="row no-gutters justify-content-between align-items-center">
              <div id="chart1Legend">

              </div>
              <div class="share-buttons">
                <div class="label-s1 light">SHARE:</div>
                <#
                var string1 = (data.riskChange > 0) ? 'I reduced the risk by ' + (data.riskChange * 100).toFixed(0) + '%' : '';
                var string2 = (data.returnChange > 0) ? 'and increased the return by ' + (data.returnChange * 100).toFixed(0) + '%' : '';
                var final = escape('I improved my portfolio! ' + string1 + string2 + '. See how: https://vesple.com');
                #>
                <a href="https://twitter.com/intent/tweet?text={{final}}" target="_blank">
                  <i class="fa fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//vesple.com" target="_blank">
                  <i class="fa fa-facebook"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=https%3A//vesple.com&title=Vesple&summary={{final}}&source=" target="_blank">
                  <i class="fa fa-linkedin"></i>
                </a>
                <a href="mailto:?body={{final}}" target="_blank">
                  <i class="fa fa-envelope"></i>
                </a>
              </div>
            </div>
            <div id="chart1">
            </div>
            <div id="chart1X">

            </div>
            <div class="chart1-disclaimer label-s2 light align-right m-t-30 m-b-20">
              The expected results are based on past performance and are not a guarantee of future results.
            </div>
          </div>
        </div>
        <# if (assets.length > 1) {
        #>
        <h1 class="m-b-50 m-t-100">Comparison</h1>
        <div class="card comparison-box">
          <div class="radarChart"></div>
          <div class="comparison-table">
            <ul class="current-portfolio">
              <li class="title">Current portfolio<br><b>allocation</b></li>
                <# for (var i = 0; i < assets.length; i++) { #>
                <li class="comparison-table-quantity">{{{assets[i].quantity}}}</li>
                <li class="comparison-table-percents">{{{(data.currentAssetsPercents[i] * 100).toFixed(0)}}}%</li>
                <# } #>
            </ul>
            <ul class="assets">
              <li></li>
              <# for (var i = 0; i < assets.length; i++ ) { #>
              <li title="{{{assets[i].name}}}">{{assets[i].symbol}}</li>
              <# } #>
            </ul>
            <ul class="optimal-portfolio">
              <li class="title">Optimized portfolio<br><b>allocation</b></li>
              <# for (var i = 0; i < assets.length; i++) { #>
              <li class="comparison-table-quantity">{{{data.optimalAssetsNumbers[i]}}}</li>
              <li class="comparison-table-percents">{{{(data.optimalAssetsPercents[i] * 100).toFixed(0) }}}%</li>
              <# } #>
            </ul>
          </div>
          <label class="form-switch">
            Percent
            <input type="checkbox">
            <i></i>
            Shares
          </label>
        </div> <!-- .comparison-box -->
        <div class="recommendations-wrapper m-t-150 align-center">
          <h1 class="m-b-30">Take Action</h1>
          <p class="label-m2 m-b-70 dark">To achieve the ideal portfolio, including your investment you would need to buy or sell the following number of shares:</p>
          <ul class="recommendations-box">
            <# for (var i = 0; i < assets.length; i++) { #>
              <li title="{{{assets[i].name}}}">
                <div class="recommendations-item card">
                  <div class="label-l1 dark bold m-b-5">
                    {{{Math.abs(data.toBuy[i])}}}
                  </div>
                  <div class="label-m1 dark caps">
                    {{{assets[i].symbol}}}
                  </div>
                </div>
                <# if (data.toBuy[i] >= 0) {
                   var tag = 'comprar';
                   var text = 'buy';
                 } else {
                   var tag = 'vender';
                   var text = 'sell';
                 }
                #>
                <div class="label-s1 caps buy-sell-tag {{{tag}}}">
                  {{{text}}}
                </div>
              </li>
            <# } #>
          </ul>
        </div>
        <#
        } #>
        <div class="recommendations-wrapper m-t-150 align-center">
          <h1 class="m-b-30">Invest with 0% comission</h1>
          <p class="label-m2 m-b-70 dark">Vesple partnered with eToro, the leading social investing platform to offer you 0% comission on all stocks. Start investing today.</p>
          <div class="align-center">
            <a href="http://partners.etoro.com/B11738_A88838_TClick_SVesple.aspx" target="_blank" class="btn btn-round btn-primary btn-medium m-b-100">Visit eToro</a>
          </div>
        </div>
        <svg height="10" width="10" xmlns="http://www.w3.org/2000/svg" version="1.1">
          <defs>
            <pattern id="diagonal-stripe-1" patternUnits="userSpaceOnUse" width="6" height="6">
              <g id="Artboard-3-Copy-2" fill="#e1e7eb">
                <rect fill-opacity="0.3" width="100%" fill="#fdd368"></rect>
                <polygon id="Rectangle-9" points="5 0 6 0 0 6 0 5"></polygon>
                <polygon id="Rectangle-9-Copy" points="6 5 6 6 5 6"></polygon>
              </g>
           </pattern>
         </defs>
       </svg>
      </script>
    </div>
  </div>
</form>
