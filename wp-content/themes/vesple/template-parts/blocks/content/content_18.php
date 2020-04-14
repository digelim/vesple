<?php

  /**
  * content_18 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $subtitle = get_field('subtitle');
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';
  $heading_size = get_field('heading_size');
  $image = get_field('image') ?: get_stylesheet_directory_uri() . '/images/content-18-image-placeholder.svg';
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
?>

<section class="bg-img content_18 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col header-content text-white m-r-70">
        <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-20 width-800 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
        <p data-aos="fade-up" data-aos-delay="250" class="width-700 large subtitle <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
      </div>
      <?php if ( get_field('video') ): ?>
        <div class="embed-container col">
          <?php the_field('video'); ?>
        </div>
      <?php else: ?>
        <img class="col-auto" src="<?php echo $image ?>" alt="Image">
      <?php endif; ?>
    </div>
  </div>
  <style type="text/css">
      #<?php echo $id; ?> {
         background-image: <?php echo $background_image_desktop; ?>;
         position: relative;
      }

      #<?php echo $id; ?> .container {
         position: relative;
         z-index: 1;
      }

      #<?php echo $id; ?>:before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background: <?php echo $overlay_color; ?>;
        opacity: <?php echo $overlay_opacity; ?>;
      }

      <?php if( isset( $background_image_mobile ) ) : ?>
        @media (max-width: 480px) {
          #<?php echo $id; ?> {
             background-image: <?php echo $background_image_mobile; ?>;
          }
        }
      <?php endif; ?>
  </style>
</section>
