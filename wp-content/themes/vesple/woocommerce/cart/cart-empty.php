<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */
defined( 'ABSPATH' ) || exit;
/*
 * @hooked wc_empty_cart_message - 10
 */
?>
<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */
defined( 'ABSPATH' ) || exit;
?>
	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<!-- Shop url -->
	<?php echo wc_get_page_permalink( 'shop' ); ?>
	<!-- Cart total -->
	<?php echo WC()->cart->get_cart_total(); ?>
	<!-- coupons list -->
	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<?php wc_cart_totals_coupon_label( $coupon ); ?>
				<?php wc_cart_totals_coupon_html( $coupon ); ?>
	<?php endforeach; ?>
	<!-- Add Coupon field -->
	<?php if ( wc_coupons_enabled() ) { ?>
		<div class="coupon">
	    <p class="type-bold m-b-10 caps font-12 subtitle">coupon code</p>
	    <input type="text" disabled name="coupon_code" class="full-width m-b-20" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>">
	    <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
			<?php do_action( 'woocommerce_cart_coupon' ); ?>
		</div>
	<?php } ?>
	<a href="<?php echo home_url('/checkout'); ?>" class="btn secondary large full-width" disabled>proceed to checkout</a>
</form>
