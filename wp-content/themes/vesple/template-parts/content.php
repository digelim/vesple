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
<!-- Permalink -->
<?php esc_url( get_permalink() ); ?>
<!-- Thumbnail -->
<?php the_post_thumbnail( 'thumbnail' ); ?>
<!-- Category -->
<?php the_category()[0]; ?>
<!-- Title -->
<?php the_title(); ?>
<!-- Author -->
<?php the_author(); ?>
<!-- Publish data -->
<?php the_date(); ?>
