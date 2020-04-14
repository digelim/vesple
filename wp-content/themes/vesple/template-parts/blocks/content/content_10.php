<?php

  /**
  * content_10 Block Template.
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
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $heading_size = get_field('heading_size');
  $image = get_field('image') ?: get_stylesheet_directory_uri() . '/images/content-10-image-placeholder.svg';

?>

<section class=" bg-img content_10 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col">
        <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-20 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
        <p data-aos="fade-up" data-aos-delay="250" class="subtitle large <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
      </div>
      <div class="col offset-1">
        <img src="<?php echo $image; ?>" alt="image">
      </div>
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

      @media (max-width: 480px) {
        #<?php echo $id; ?> {
           background-image: <?php echo $background_image_mobile; ?>;
        }
      }
  </style>
</section>
