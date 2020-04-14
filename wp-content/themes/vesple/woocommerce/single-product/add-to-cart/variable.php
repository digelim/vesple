<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
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
				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				//do_action( 'woocommerce_before_variations_form' );
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
		<?php else : ?>
			<table class="variations" cellspacing="0">
				<tbody>
					<?php foreach ( $attributes as $attribute_name => $options ) : ?>
						<tr>
							<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></td>
							<td class="value">
								<?php
									dropdown_variation_attribute_options( array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									) );
									wc_dropdown_variation_attribute_options( array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									) );
									//echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link' ) ) : '';
								?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
	<div class="radio">
		<div>
			<input type="radio" name="one-time-purchase-<?php echo $product->get_id(); ?>" id="one-time-<?php echo $product->get_id(); ?>">
			<label for="one-time-<?php echo $product->get_id(); ?>">One-time purchase</label>
		</div>
		<div>
			<input checked type="radio" name="one-time-purchase-<?php echo $product->get_id(); ?>" id="lifetime-<?php echo $product->get_id(); ?>">
			<label for="lifetime-<?php echo $product->get_id(); ?>">Subscribe and save 20-30%</label>
			<a href="#" class="font-14 m-t-5 m-l-30 block type-medium m-b-20">How Membership Works</a>
		</div>
	</div>
	<a href="#" class="dropdown block p-t-20 p-b-20 p-l-20 text-black font-16">
		<div class="row justify-content-between no-gutters align-items-center">
			<span>Once a month (20%)</span>
			<span class="fa fa-chevron-down m-l-10 m-r-20 font-15 subtitle"></span>
		</div>
		<ul class="dropdown-list">
			<li class="dropdown-option">Once a year (10%)</li>
			<li class="dropdown-option">Twice a year (15%)</li>
		</ul>
	</a>
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
