<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

 $navigation = get_field('navigation', 'options') ?: null;
 $footer = get_field('footer', 'options') ?: null;

 get_header( $navigation ); ?>

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'single' );

	endwhile;
	?>

<?php
get_footer( $footer );
