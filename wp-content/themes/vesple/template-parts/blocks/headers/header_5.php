<?php

  /**
  * header_5 Block Template.
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
  $intro = get_field('intro');
  $cf7_shortcode = get_field('cf7_shortcode');
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $round = get_field('round', 'options');

?>


<header class="bg-img header_5 align-center <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container width-750">
    <p class="font-12 m-b-20 caps subtitle">
      <b><?php echo $intro; ?></b>
    </p>
    <h1 data-aos="fade-up" class="<?php echo $heading_size; ?> m-b-20 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <p data-aos="fade-up" data-aos-delay="250" class="subtitle large m-b-40 <?php echo $text_color; ?>">
      <?php echo $subtitle; ?>
    </p>
    <?php

    if ( ! $cf7_shortcode ) {
      ?>
      <form>
        <div class="row width-600 margin-auto">
          <input class="col m-r-15" type="text" name="your-email" placeholder="Email Address">
          <input class="btn primary medium <?php echo $round; ?>" type="submit" name="" value="Call to action">
        </div>
      </form>
      <?php
    } else {
      echo $cf7_shortcode;
    }

    ?>
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
</header>
