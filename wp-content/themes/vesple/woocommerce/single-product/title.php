<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

$args = array( 'taxonomy' => 'product_cat' );
$terms = get_terms('product_cat', $args);
?>

<p data-aos="fade-down" class="subtitle m-b-10 type-bold caps font-12">
	<?php
	foreach ($terms as $term) {
		echo $term->name;
		break;
	}
	?>
</p>

<?php
the_title( '<h1 data-aos-delay="200" data-aos="fade-down" class="medium m-b-20 mobile-font-24">', '</h1>' );
