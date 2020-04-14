<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package project
 */

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation ); ?>

<?php
	while ( have_posts() ) :
		the_post();

		do_action( 'storefront_page_before' );

		get_template_part( 'template-parts/content', 'page' );

		/**
		 * Functions hooked in to storefront_page_after action
		 *
		 * @hooked storefront_display_comments - 10
		 */
		do_action( 'storefront_page_after' );

	endwhile; // End of the loop.
?>

<?php
//get_sidebar();
get_footer( $footer );
