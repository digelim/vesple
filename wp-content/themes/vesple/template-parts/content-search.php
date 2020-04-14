<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package project
 */

global $woocommerce, $product;

?>
<!-- Price -->
<?php floor( $product->get_price() ); ?>
<!-- In stock -->
<?php $product->is_in_stock(); ?>
<!-- Permalink -->
<?php the_permalink(); ?>
<!-- Thumbnail -->
<?php echo get_the_post_thumbnail( $product->get_parent_id(), 'shop_catalog' ); ?>
<!-- Title -->
<?php the_title(); ?>
<!-- Review stars -->
<?php
$average = $product->get_average_rating();
$total = $product->get_review_count();
?>

<div class="row align-items-center no-gutters">
	<?php
	echo '<div class="col-auto star-rating m-r-10"><span style="width:'.( ( $average/5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
	echo '<div class="col subtitle font-12">' . $total . ' Reviews</div>';
	 ?>
</div>
<!-- Description -->
<?php echo $product->post->post_excerpt; ?>
<!-- Quantity -->
<div class="row no-gutters quantity-inputs-wrapper m-b-25">
	<button type="button" class="minus" >-</button>
	<?php
	if ( ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) {
		woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
	}
	?>
	<button type="button" class="plus" >+</button>
</div>
