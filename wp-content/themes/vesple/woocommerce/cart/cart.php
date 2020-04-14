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
	<?php do_action( 'woocommerce_cart_contents' ); ?>
	<?php do_action( 'woocommerce_before_cart' );  ?>
	<!-- back to shopping link -->
	<?php wc_get_page_permalink( 'shop' ); ?>
	<?php
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$_product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

	  if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			$_product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

			if ( ! $_product_permalink ) {
				echo $thumbnail; // PHPCS: XSS ok.
			} else {
				printf( '<a href="%s">%s</a>', esc_url( $_product_permalink ), $thumbnail ); // PHPCS: XSS ok.
			}
			?>
      <?php
      echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
      do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
      // Meta data.
      echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
      // Backorder notification.
      if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $_product_id ) );
      }
      ?>
			<!-- Description -->
			<?php echo $_product->post->post_excerpt; ?>
			<!-- Product subtotal -->
      <?php
      echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] );
      ?>
			<!-- Ratings -->
      <?php
			if ( wc_review_ratings_enabled() ) {
				$rating_count = $_product->get_rating_count();
				$review_count = $_product->get_review_count();
				$average      = $_product->get_average_rating();
				?>
				<?php
				$average = $_product->get_average_rating();
				$total = $_product->get_review_count();
				?>

				<div class="row align-items-center no-gutters m-b-15 cart-rating">
					<?php
					echo '<div class="col-auto star-rating m-r-10"><span style="width:'.( ( $average/5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
					echo '<div class="col-auto subtitle font-12">' . $total . ' Reviews</div>';
					 ?>
				</div>
			<?php } ?>
			<!-- Remove link -->
      <?php
				echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'woocommerce_cart_item_remove_link',
					sprintf(
						'<a href="%s" class="font-14 subtitle m-r-15 type-regular" data-product_id="%s" data-product_sku="%s">Remove</a>',
						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
						esc_html__( 'Remove', 'woocommerce' ),
						esc_attr( $_product_id ),
						esc_attr( $_product->get_sku() )
					),
					$cart_item_key
				);
			?>
			<!-- Quantity -->
      <div class="row no-gutters quantity-inputs-wrapper">
        <button type="button" class="minus" >-</button>
        <?php
				if ( $_product->is_sold_individually() ) {
					$_product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
				} else {
					$_product_quantity = woocommerce_quantity_input(
						array(
							'input_name'   => "cart[{$cart_item_key}][qty]",
							'input_value'  => $cart_item['quantity'],
							'max_value'    => $_product->get_max_purchase_quantity(),
							'min_value'    => '0',
							'product_name' => $_product->get_name(),
						),
						$_product,
						false
					);
				}
				echo apply_filters( 'woocommerce_cart_item_quantity', $_product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
				?>
        <button type="button" class="plus" >+</button>
      </div>
      <!-- subtotal -->
			<?php
				//echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
			?>
			<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

			<?php do_action( 'woocommerce_cart_actions' ); ?>

			<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			<?php
		}
	}
	?>
	<!-- Subtotal -->
	<?php
	$subtotal = 0;

	foreach( WC()->cart->get_cart() as $cart_item ) {
	  $subtotal += $cart_item['data']->get_price() * $cart_item['quantity'];
	}

	echo '$' . $subtotal;
	?>
	<!-- List of coupons -->
	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<?php wc_cart_totals_coupon_label( $coupon ); ?>
		<?php wc_cart_totals_coupon_html( $coupon ); ?>
	<?php endforeach; ?>
	<!-- Coupons input field -->
	<?php if ( wc_coupons_enabled() ) { ?>
	  <input type="text" name="coupon_code" class="full-width m-b-20" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>">
	  <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
		<?php do_action( 'woocommerce_cart_coupon' ); ?>
	<?php } ?>
	<a href="<?php echo home_url('/checkout'); ?>" class="btn secondary large full-width">proceed to checkout</a>
</form>
