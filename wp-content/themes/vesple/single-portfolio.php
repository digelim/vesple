<?php

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

$current_fp = get_query_var('fpage');

?>

<?php

if (!$current_fp) {
    get_template_part( 'template-parts/single', 'portfolio-index' );
} else if ($current_fp == 'assets') {
    get_template_part( 'template-parts/single', 'portfolio-assets' );
} else if ($current_fp == 'investment') {
    get_template_part( 'template-parts/single', 'portfolio-investment' );
} else if ($current_fp == 'portfolio') {
    get_template_part( 'template-parts/single', 'portfolio-portfolio' );
};

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
