<?php
/**
* Template Name: Home
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>
<?php

	$args = array(
		'author' => get_current_user_id(),
		'post_type' => 'portfolio',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) :
			$query->the_post();
	    get_template_part( 'loop' );
		endwhile;
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
?>

<!-- {{#if selectedAsset}}
	<div class="assets-popup-overlay">
		<div class="assets-popup">
			<span class="icon-delete" id="close-assets-popup"></span>
			<h1 class="label-m1">Quantas ações você possui?</h1>
			<div class="group material-design popup-input-group">
				<input required="required" type="tel" name="stocks-amount" value="{{selectedAsset.amount}}">
				<span class="bar"></span>
				<label>{{selectedAsset.symbol}}</label>
			</div>
			<a href="#" class="btn btn-primary btn-small block" id="save-stocks-amount">Salvar</a>
		</div>
	</div>
{{/if}} -->

<?php get_footer( $footer ); ?>
