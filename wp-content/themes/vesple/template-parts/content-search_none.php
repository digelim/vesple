<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package project
 */

?>
<!-- Search query -->
<?php
	printf( esc_attr__( 'Search Results for: \'%s\'', 'storefront' ), get_search_query() );
?>
<!-- Related posts -->
<?php
$query = new WP_Query( array(
  'posts_per_page' => 6,
  'post_type' => 'product',
  'post_status' => 'publish',
  'meta_key' => 'total_sales',
  'orderby' => 'meta_value_num',
  'order' => 'DESC',
) );

if($query->have_posts()) :
  while($query->have_posts()) : $query->the_post();
    get_template_part('template-parts/content', 'product');
  endwhile;
  wp_reset_postdata();
endif;
?>
