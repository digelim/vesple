<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package project
 */

?>

<?php
$get_author_id = get_the_author_meta('ID');
$get_author_gravatar = get_avatar_url($get_author_id, array('size' => 450));
?>
<!-- Category -->
<?php the_category()[0]; ?>
<!-- Title -->
<?php the_title(); ?>
<!-- Author avatar -->
<?php echo $get_author_gravatar; ?>
<!-- Author -->
<?php the_author(); ?>
<!-- Publish date -->
<?php the_date(); ?>
<!-- Thumbnail -->
<?php the_post_thumbnail( 'full' ); ?>
<!-- Content -->
<?php the_content(); ?>
<!-- Like button -->
<?php
global $wpdb;
$l = 0;
$postid = get_the_id();
$clientip = get_client_ip();
$row1 = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid' AND clientip = '$clientip'");

if( ! empty( $row1 ) ){
  $l=1;
}

$totalrow1 = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid'");
$total_like1 = $wpdb->num_rows;
?>

<div class="post_like">
  <a class="pp_like <?php if( $l == 1 ) {echo "liked"; } ?>" href="#" data-id="<?php echo get_the_id(); ?>">
    <i class="far fa-heart"></i>
    <span><?php echo $total_like1; ?> like</span>
  </a>
</div>
<!-- Author avatar -->
<?php echo $get_author_gravatar; ?>
<!-- Author -->
<?php the_author(); ?>
<!-- Bio -->
<?php the_author_description(); ?>
<!-- Publish date -->
<?php the_date(); ?>
<!-- Related posts -->
<?php
$related = new WP_Query(
  array(
    'posts_per_page' => 3,
    'post__not_in'   => array( $post->ID )
  )
);

$get_related_post_author_id = get_the_author_meta(  $related->ID, 'ID' );
$get_related_post_author_gravatar = get_avatar_url($get_author_id, array('size' => 450));

if( $related->have_posts() ) {
  while( $related->have_posts() ) {
    $related->the_post();
    // Permalink
    $related->the_permalink();
    // Thumbnail
    echo get_the_post_thumbnail($related->ID, 'large');
    // Category
    the_category()[0];
    // Title
    the_title( $related->ID );
    // Author avatar
    echo $get_related_post_author_gravatar;
    // Author
    the_author( $related->ID );
    // Publish date
    the_date( $related->ID );
  }

  wp_reset_postdata();
}
?>
