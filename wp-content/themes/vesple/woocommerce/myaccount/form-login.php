<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="container">
	<div class="logo-wrapper align-center m-b-20 m-t-50">
		<span class="icon-logotype">
			<img src="<?php echo bloginfo('stylesheet_directory'); ?>/img/vesple.svg" alt="Image">
		</span>
	</div>
	<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
	<div class="login-card">
	<?php
	if ( isset( $_GET['register'] ) ): ?>
		<!-- Register -->
		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
				<?php do_action( 'woocommerce_register_form_start' ); ?>
				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
					<label class="pure-material-textfield-outlined">
						<input placeholder=" " type="text" class="m-t-10 full-width" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						<span>Username</span>
					</label>
					<label class="pure-material-textfield-outlined m-t-20">
						<input placeholder=" " type="email" class="m-t-10 full-width" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			      <span>Email</span>
			    </label>
				<?php endif; ?>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
					<label class="pure-material-textfield-outlined m-t-20">
			      <input id="reg_password" type="password" name="password" value="" placeholder=" ">
			      <span>Password</span>
			    </label>
				<?php else : ?>

					<?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?>

				<?php endif; ?>
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<button type="submit" class="sign-in-btn btn btn-primary btn-large m-t-20 woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
					<div class="login-signup-alternative m-t-20">
				    <div class="label-s2 dark align-center">
				      or continue with
				    </div>
				  </div>
					<?php
					echo do_shortcode('[woocommerce_social_login_buttons return_url="https://vesple.com/my-account"]');
					?>
				<?php do_action( 'woocommerce_register_form_end' ); ?>

			</form>
		<?php endif; ?>
		<?php else: ?>
		<!-- Sign in -->
		<form class="woocommerce-form woocommerce-form-login login" method="post">

	  	<?php do_action( 'woocommerce_login_form_start' ); ?>
			<label class="pure-material-textfield-outlined">
				<input placeholder=" " id="login-email" type="text" class="m-t-10 woocommerce-Input woocommerce-Input--text input-text" name="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
	      <span>Email</span>
	    </label>
			<label class="pure-material-textfield-outlined m-t-20">
				<input type="password" name="password" value="" placeholder=" ">
				<span>Password</span>
			</label>
			<?php do_action( 'woocommerce_login_form' ); ?>
			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
	    <a class="forgot-password-link label-s2 light align-right block m-t-10" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
	      Forgot the password?
	    </a>
	  	<button id="sign-in-btn" type="submit" class="sign-in-btn btn btn-primary btn-large m-t-20 woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			<div class="login-signup-alternative m-t-20">
		    <div class="label-s2 dark align-center">
		      or continue with
		    </div>
		  </div>
			<!-- Social Login -->
	    <?php
			echo do_shortcode('[woocommerce_social_login_buttons return_url="https://vesple.com/my-account"]');
			?>
	  </form>
	<?php endif; ?>
	</div>
	<?php if (isset( $_GET['register'] )): ?>
		<div class="label-s2 white align-center m-t-20 m-b-50">Already have an account? <a class="dark-bg" href="<?php echo home_url('/my-account') ?>">Sign in</a></div>
	<?php else: ?>
		<div class="label-m1 white align-center m-t-20 m-b-50">New here? <a class="dark-bg" href="<?php echo home_url('/my-account') ?>?register">Sign up</a></div>
	<?php endif; ?>
</div>
