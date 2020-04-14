<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
global $post;

$short_description = $post->post_excerpt;

if ( $short_description ) {
	?>
	<p data-aos="fade-down" data-aos-delay="600" class="subtitle font-18 m-b-30">
		<?php echo $short_description; // WPCS: XSS ok. ?>
	</p>
	<?php
}
?>
