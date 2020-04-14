<?php
/**
* Template Name: Wizard
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

?>

<?php

	if ( is_page('assets') && $post->post_parent ) {
		get_template_part( 'template-parts/wizard', 'assets' );
	}

	if ( is_page('investment') && $post->post_parent ) {
		get_template_part( 'template-parts/wizard', 'investment' );
	}

	if ( is_page('portfolio') && $post->post_parent ) {
		get_template_part( 'template-parts/wizard', 'portfolio' );
	}

?>

<?php get_footer( $footer ); ?>
