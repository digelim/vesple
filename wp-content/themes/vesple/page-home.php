<?php
/**
* Template Name: Home
*/

get_header();

?>
<nav>
	<div class="container-fluid">
		<div class="main-menu row no-gutters justify-content-between align-items-center">
			<div class="">
				<img src="<?php echo bloginfo('stylesheet_directory'); ?>/img/vesple-dark.svg" alt="Image">
			</div>
			<div class="menu-login">
				<a href="<?php echo home_url('my-account') ?>">Sign in</a>
				<a class="btn-primary btn-small" href="<?php echo home_url('my-account') ?>?register">Sign up</a>
			</div>
		</div>
	</div>
</nav>

<header class="bg-img">
<div class="container">
  <div class="header-content p-t-150 p-b-150 row no-gutters justify-content-between align-items-center">
    <div class="col-md-6">
      <h1 class="medium m-b-20 color-primary" style="font-size: 58px;">Get the most out of the <span class="txt-type" data-wait="1500" data-words='["Stocks", "Crypto", "Forex", "Funds", "Index"]'></span> market</h1>
      <p class="subtitle medium m-b-20" style="font-size: 20px;">Whether you are an investor or looking for getting started, Vesple helps you reduce the risk of your assets and turn your low performance portfolio into a highly profitable gold mine.</p>
      <a href="<?php echo home_url('my-account'); ?>?register" class="btn-primary btn-large btn-round">START FOR FREE</a>
    </div>
    <div class="col-md-6">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/img/home-header.png" style="max-width: 720px;">
    </div>
  </div>
</div>
</header>

<section class="default-paddings benefits-section">
<div class="container benefits-container">
  <div class="row justify-content-between">
    <div class="benefits-col col-md-4">
			<img class="m-b-30" src="<?php echo bloginfo('stylesheet_directory'); ?>/img/savings.svg" alt="Image">
      <h5 class="m-b-15">Simulate your results</h5>
      <p class="large">Enter the amount and frequency of investments and learn how to achieve your goals. Say goodbye to spreadsheets.</p>
    </div>
    <div class="benefits-col col-md-4">
      <img class="m-b-30" src="<?php echo bloginfo('stylesheet_directory'); ?>/img/search.svg" alt="Image">
      <h5 class="m-b-15">Build your portfolio</h5>
      <p class="large">Discover the flaws and potential of each of the assets you have chosen.</p>
    </div>
    <div class="benefits-col col-md-4">
      <img class="m-b-30" src="<?php echo bloginfo('stylesheet_directory'); ?>/img/charts.svg" alt="image">
      <h5 class="m-b-15">Get actionable insights</h5>
      <p class="large">You already know that diversification can decrease the risk of losses, right? Now, learn how to also increase your potential return.</p>
    </div>
  </div>
</div>
</section>

<section class="default-paddings">
<div class="container">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-6">
      <div class="responsive-sprites">
        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/img/screen-2.png">
      </div>
    </div>
    <div class="col-md-5">
      <h3 class="m-b-20">See your expected performance</h3>
      <p class="subtitle large">Vesple calculates, compares and tells you all the benefits of diversification, also known as "not putting eggs in one basket".</p>
    </div>
  </div>
</div>
</section>

<section class="default-paddings p-t-0">
	<div class="container">
	  <div class="row justify-content-between align-items-center feature-row">
	    <div class="col-md-6 feature-col">
	      <h3 class="m-b-20">By the Nobel Prize winner</h3>
	      <p class="subtitle large" style="
	  padding-bottom: 110px;
	">Optimize your investment portfolio through the algorithm developed by the Nobel Prize in Economics, Harry Markowitz. Generate the best possible results whithout complex spreadsheets, and no crazy calculations.</p>
	    </div>
	    <div class="col-md-6 feature-col">
	      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/img/screen-1.png" alt="Image">
	    </div>
	  </div>
	</div>
</section>



<section class="cta-section bg-img extra-paddings">
	<div class="cta-container container align-center">
	  <h3 class="m-b-40">Try the revolutionary tool that will help you achieve your goals</h3>
	  <a href="<?php echo home_url('my-account'); ?>?register" class="btn primary large">Start for free</a>
	</div>
</section>
<footer class="p-t-40 p-b-20">
  <div class="container">
    <div class="row justify-content-between align-items-center p-b-20">
      <div class="col">
        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/img/vesple.svg" alt="Vesple">
      </div>
      <div class="col align-right menu-login">
				<a class="text-white" href="<?php echo home_url('my-account') ?>">Sign in</a>
				<a class="btn-ghost btn-small" href="<?php echo home_url('my-account') ?>?register">Sign up</a>
			</div>
    </div>

    <div class="align-center p-t-40 p-b-20 text-white">
      © <?php echo date('Y'); ?> Vesple. All rights reserved.<br><br>
			<div style="color: white;">
				support@vesple.com
			</div><br><br>
			<a style="color: white;" href="<?php echo home_url('terms-and-conditions'); ?>" class="m-r-20">Terms & Conditions</a><a href="<?php echo home_url('privacy-policy'); ?>" style="color: white;" >Privacy Policy</a>
    </div>
  </div>
</footer>

<?php get_footer(); ?>
