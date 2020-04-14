<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package project
 */

global $woocommerce, $product;

$attributes = $product->get_variation_attributes();
?>
<!-- In stock -->
<?php $product->is_in_stock(); ?>
<!-- Permalink -->
<?php the_permalink(); ?>
<!-- Thumbnail -->
<?php echo get_the_post_thumbnail( 'shop_catalog' ); ?>
<!-- Title -->
<?php the_title(); ?>
<!-- Rating stars -->
<?php
$average = $product->get_average_rating();
$total = $product->get_review_count();
?>
<div class="row align-items-center no-gutters mobile-justify-content-center">
	<?php
	echo '<div class="col-auto star-rating m-r-10"><span style="width:'.( ( $average/5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
	echo '<div class="col-auto subtitle font-12">' . $total . ' Reviews</div>';
	 ?>
</div>
<!-- Price -->
<?php floor( $product->get_price() ); ?>
<!-- Add to cart -->
<?php
echo apply_filters(
	'woocommerce_loop_add_to_cart_link',
	sprintf(
		'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="justify-content-center mobile-block full-width no-gutters row align-items-center btn secondary small full-height  align-center add-to-cart-button %s product_type_%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		$product->is_purchasable() ? 'add_to_cart_button' : '',
		esc_attr( $product->product_type ),
		esc_html( $product->add_to_cart_text() )
	),
	$product
);
?>
