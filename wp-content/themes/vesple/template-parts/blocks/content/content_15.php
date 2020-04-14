<?php

  /**
  * content_15 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $subtitle = get_field('subtitle');
  $heading_size = get_field('heading_size');
  $image = get_field('image') ?: get_stylesheet_directory_uri() . '/images/content-15-image-placeholder.svg';
  $image_size = get_field('image_size');
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';

?>

<section class="content_15 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <div class="row justify-content-between no-gutters">
      <div class="row flex-<?php echo $image_size; ?> flex-column responsive-991">
        <div class="block bg-img" style="width: <?php echo $image_size + 2; ?>vw; background: url(<?php echo $image; ?>); height: 100%;"></div>
      </div>
      <div class="row p-l-120 flex-<?php echo 100 - $image_size - 3; ?> flex-column responsive-991 ">
        <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-20 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
        <p data-aos="fade-up" data-aos-delay="250" class="subtitle large <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
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
