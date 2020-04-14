<?php

  /**
  * content_13 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $heading_size = get_field('heading_size');
  $subtitle = get_field('subtitle');
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';

?>

<section class=" content_13 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container width-1100">
    <div class="row justify-content-between p-l-15 p-r-15">
      <div class="flex-49 responsive-991">
        <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size . ' ' . $text_color; ?>"><?php echo $heading; ?></h1>
      </div>
      <div class="flex-46 responsive-991">
        <p data-aos="fade-up" data-aos-delay="250" class="large <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
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
