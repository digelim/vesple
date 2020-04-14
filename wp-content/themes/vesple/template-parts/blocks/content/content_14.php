<?php

  /**
  * content_14 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';

?>

<section class=" content_14 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container width-700 margin-auto">
    <h2 data-aos="fade-up" data-aos-delay="0" class="<?php echo $text_color; ?> align-center"><?php echo $heading; ?></h2>
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
