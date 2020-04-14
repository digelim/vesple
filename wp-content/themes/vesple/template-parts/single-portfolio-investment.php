<?php global $post; ?>
<form action="<?php echo home_url('/wp-admin/admin-post.php'); ?>" method="post">
  <input type="hidden" name="action" value="update_portfolio_investment">
  <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
  <div class="steps-overlay">
    <nav class="steps-bar">
      <div class="left">
        <a href="<?php echo the_permalink(); ?>" class="tab" id="steps-close">
          <span class="icon-delete"></span>
        </a>
        <a href="<?php the_permalink(); ?>/assets" class="tab" id="tab-1">
          <span class="icon-assets-tab"></span>
          <span class="tab-label">Assets</span>
        </a>
        <a class="tab active" id="tab-2">
          <span class="icon-investment-tab"></span>
          <span class="tab-label">investment</span>
        </a>
        <button type="submit" class="tab" id="tab-3">
          <span class="icon-portfolio-tab"></span>
          <span class="tab-label">portfolio</span>
        </button>
      </div>
      <div class="right">
        <button type="submit" class="btn btn-next-step">Improve portfolio<span class="icon-next-tab"><span class="path1"></span><span class="path2"></span></span></button>
      </div>
    </nav>
    <div class="container">
    <div class="group material-design">
      <input type="text" class="input-mask" required="required" name="investment-value" value="<?php echo get_field('initial_investment'); ?>">
      <span class="bar"></span>
      <label>Initial investment</label>
    </div>
    <div class="group material-design big">
      <input type="text" class="input-mask" name="dividends" required="required" value="<?php echo get_field('dividends'); ?>">
      <span class="bar"></span>
      <label>Dividend yield</label>
      <div class="label-s1 caps m-t-10">The average percent of dividends paid by the selected assets for one year.</div>
    </div>
    <div class="group material-design big">
      <input type="text" class="input-mask" name="dividends-growth" required="required" value="<?php echo get_field('dividends_growth'); ?>">
      <span class="bar"></span>
      <label>Annual dividend growth rate</label>
      <div class="label-s1 caps m-t-10">For the S&P500, the historical dividends growth rate is about 6%.</div>
    </div>
    <div class="group material-design big">
      <input type="text" class="input-mask" name="inflation" required="required" value="<?php echo get_field('inflation'); ?>">
      <span class="bar"></span>
      <label>Inflation rate</label>
    </div>
    <h1 class="m-b-15">Do you plan to invest regularly?</h1>
    <div class="group">
      <?php $true = get_field('regular_investment') ? 'checked' : ''; ?>
      <?php $false = !get_field('regular_investment') ? 'checked' : ''; ?>
      <p>
        <input type="radio" id="test1" <?php echo $false; ?> name="radio-group" value="off">
        <label for="test1">No <span class="icon-check-circle"><span class="path1"></span><span class="path2"></span></span></label>
      </p>
      <p>
        <input type="radio" id="test2" <?php echo $true; ?> name="radio-group" value="on">
        <label for="test2">Yes <span class="icon-check-circle"><span class="path1"></span><span class="path2"></span></span></label>
      </p>
    </div>
    <?php $show = get_field('regular_investment') ? '' : 'display: none;'; ?>
    <div class="regular-investment-fields" style="<?php echo $show; ?>">
      <h1 class="m-b-15">How often do you plan to invest on the selected assets?</h1>
      <div class="group material-design small">
        <input type="text" class="input-mask" name="investment-interval" value="<?php echo get_field('investment_interval'); ?>">
        <span class="bar"></span>
        <label>Every</label>
        <div class="label-s1 caps m-t-10">Months</div>
      </div>
      <div class="group material-design big">
        <input type="text" class="input-mask" name="investment-amount" value="<?php echo get_field('investment_amount'); ?>">
        <span class="bar"></span>
        <label>Regular investment amount</label>
        <div class="label-s1 caps m-t-10">Define the amount you will invest with that frequency.</div>
      </div>
      <div class="group material-design big">
        <input type="text" class="input-mask" name="regular-investment-growth-rate" value="<?php echo get_field('regular_investment_growth_rate'); ?>">
        <span class="bar"></span>
        <label>Annual growth rate of your regular investments</label>
        <div class="label-s1 caps m-t-10"></div>
        <div class="label-s1 caps m-t-10">How fast does your regular investments increase?</div>
      </div>
    </div>
  </div>
</form>
<?php $class = ( has_active_subscription() || has_available_credits(5) ) ? 'inactive' : 'active' ?>
<iframe class="checkout-iframe <?php echo $class; ?>" sandbox="allow-same-origin allow-scripts allow-popups allow-forms" src="<?php echo home_url('/shop'); ?>" style="display: none;"></iframe>
