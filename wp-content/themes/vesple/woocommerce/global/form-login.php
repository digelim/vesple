<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( is_user_logged_in() ) {
	return;
}
?>


<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="card full-width p-t-50 p-l-50 p-r-70 shadow checkout-login-card relative">
  <div class="row align-items-center no-gutters m-b-20 back-to-shopping-link">
    <i class="icon-arrow_back_ios m-r-10 subtitle"></i>
    <a href="#" class="font-18 subtitle type-regular">Back to Shopping</a>
  </div>
  <div class="m-l-35 m-t-20 m-r-35 shipping-method-note caps type-bold font-16 p-t-25 p-b-25 p-l-40 p-r-40 mobile-align-center">
      oh no, you need to have an account to continue
  </div>
  <div class="m-l-35 m-t-70 checkout-login-form-wrapper">
    <div class="row no-gutters justify-content-between">
      <div class="flex-48 border-right responsive-991">
        <h1 class="font-30 m-b-30">New Customers</h1>
        <div class="width-400 m-b-30 subtitle m-r-30 new-customers-subtitle">
          Proceed to checkout and you will have an opportunity to create an account at the end if one does not already exist for you.
        </div>
        <button id="wpmc-skip-login" class="btn secondary medium current" type="button">Proceed to checkout <i class="m-l-10 icon-arrow_right_alt"></i></button>
      </div>
      <div class="flex-52 responsive-991">
        <div class="offset-3 width-350 p-b-70">
          <h1 class="font-30 m-b-30">Returning Customers</h1>
          <form class="woocommerce-form woocommerce-form-login login" method="post">

          	<?php do_action( 'woocommerce_login_form_start' ); ?>

          	<p class="m-b-30 woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
          		<label for="username" class="caps type-bold font-12"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
          		<input type="text" class="m-t-10 woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
          	</p>
          	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
          		<label for="password" class="caps type-bold font-12"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
          		<input class="m-t-10 full-width woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
          	</p>

          	<?php do_action( 'woocommerce_login_form' ); ?>

          	<p class="m-t-30">
          		<input class="full-width woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme" for="rememberme">Remember me</label>
          		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
          		<button type="submit" class="m-t-30 btn secondary large full-width block woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
          	</p>
            <div class="login-alternate row no-gutters m-t-30 m-b-30 justify-content-between align-items-center">
              <div class="col horizontal-line"></div>
              <div class="col-auto">
                <div class="subtitle font-12 type-bold caps p-l-35 p-r-35">
                  or
                </div>
              </div>
              <div class="col horizontal-line"></div>
            </div>
            <?php echo do_shortcode('[woocommerce_social_login_buttons return_url="https://coloradobotanicals.org/checkout"]') ?>
            <div class="m-t-30 font-12 subtitle align-center type-medium">
              <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="subtitle underline type-medium">Forgot Password?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
