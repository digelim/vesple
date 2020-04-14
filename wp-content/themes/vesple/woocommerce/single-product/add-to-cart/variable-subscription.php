<?php
/**
 * Variable subscription product add to cart
 *
 * @author  Prospress
 * @package WooCommerce-Subscriptions/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys = array_keys( $attributes );
$user_id        = get_current_user_id();

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wcs_json_encode( $available_variations ) ) ?>">
	<div class="single_variation_wrap">
		<?php
		/**
		 * woocommerce_before_single_variation Hook.
		 */
		do_action( 'woocommerce_before_single_variation' );
		?>
		<script type="text/template" id="tmpl-variation-template">
			<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
			<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
			<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
		</script>
		<script type="text/template" id="tmpl-unavailable-variation-template">
			<p><?php esc_html_e( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ); ?></p>
		</script>
		<?php
		do_action( 'woocommerce_single_variation' );

		/**
		 * woocommerce_after_single_variation Hook.
		 */
		do_action( 'woocommerce_after_single_variation' );
		?>
	</div>
	<?php do_action( 'woocommerce_before_variations_form' ); ?>
	<div data-aos="fade-up" class="row align-items-center no-gutters m-b-30" id="strength-drops">
		<?php
		$strength = isset( $_REQUEST[ 'attribute_pa_strength' ] ) ? wc_clean( $_REQUEST[ 'attribute_pa_strength' ] ) : '300mg';
		$options = $attributes['pa_strength'];
		$is_filled = true;

		for ($i=0; $i <= sizeof( $options ); $i++) {

			$is_filled = ( array_search( $strength, array_values( $options ) ) < $i || !$is_filled ) ? false : true;

			?>
			<svg class="m-r-10" width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M0 10.333C0 13.463 2.427 16 5.418 16C8.41 16 11 13.463 11 10.333C11 7.204 5.418 0 5.418 0C5.418 0 0 7.204 0 10.333Z" fill="<?php echo $is_filled ? '#79AD6F' : '#D8D8D8'; ?>"/>
			</svg>
			<?php
		}
		?>
		<div class="subtitle font-12 m-l-10">
			Strength
		</div>
	</div>
	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce-subscriptions' ); ?></p>
	<?php else : ?>
		<?php if ( ! $product->is_purchasable() && 0 !== $user_id && 'no' !== wcs_get_product_limitation( $product ) && wcs_is_product_limited_for_user( $product, $user_id ) ) : ?>
			<?php $resubscribe_link = wcs_get_users_resubscribe_link_for_product( $product->get_id() ); ?>
			<?php if ( ! empty( $resubscribe_link ) && 'any' === wcs_get_product_limitation( $product ) && wcs_user_has_subscription( $user_id, $product->get_id(), wcs_get_product_limitation( $product ) ) && ! wcs_user_has_subscription( $user_id, $product->get_id(), 'active' ) && ! wcs_user_has_subscription( $user_id, $product->get_id(), 'on-hold' ) ) : // customer has an inactive subscription, maybe offer the renewal button. ?>
				<a href="<?php echo esc_url( $resubscribe_link ); ?>" class="woocommerce-button button product-resubscribe-link"><?php esc_html_e( 'Resubscribe', 'woocommerce-subscriptions' ); ?></a>
			<?php else : ?>
				<p class="limited-subscription-notice notice"><?php esc_html_e( 'You have an active subscription to this product already.', 'woocommerce-subscriptions' ); ?></p>
			<?php endif; ?>
		<?php else : ?>
			<?php if ( wp_list_filter( $available_variations, array( 'is_purchasable' => false ) ) ) : ?>
				<p class="limited-subscription-notice notice"><?php esc_html_e( 'You have added a variation of this product to the cart already.', 'woocommerce-subscriptions' ); ?></p>
			<?php endif; ?>
			<table data-aos="fade-up" class="variations" cellspacing="0">
				<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label></td>
						<td class="value">
							<?php
							$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
							wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
							echo wp_kses( end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce-subscriptions' ) . '</a>' ) : '', array( 'a' => array( 'class' => array(), 'href' => array() ) ) );
							?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<?php
			/**
			 * Post WC 3.4 the woocommerce_before_add_to_cart_button hook is triggered by the callback @see woocommerce_single_variation_add_to_cart_button() hooked onto woocommerce_single_variation.
			 */
			if ( WC_Subscriptions::is_woocommerce_pre( '3.4' ) ) {
				do_action( 'woocommerce_before_add_to_cart_button' );
			}

			/**
			 * Post WC 3.4 the woocommerce_after_add_to_cart_button hook is triggered by the callback @see woocommerce_single_variation_add_to_cart_button() hooked onto woocommerce_single_variation.
			 */
			if ( WC_Subscriptions::is_woocommerce_pre( '3.4' ) ) {
				do_action( 'woocommerce_after_add_to_cart_button' );
			}
			?>
		<?php endif; ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
	<div class="woocommerce-variation-add-to-cart variations_button">
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		?>

		<div class="row no-gutters quantity-inputs-wrapper m-r-30">
			<button type="button" class="minus" >-</button>
			<?php
			woocommerce_quantity_input( array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			) );
			 ?>
			 <button type="button" class="plus" >+</button>
		</div>
		<?php

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<button type="submit" class="single_add_to_cart_button btn secondary medium"><i class="icon-local_grocery_store m-r-10"></i><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
	</div>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
