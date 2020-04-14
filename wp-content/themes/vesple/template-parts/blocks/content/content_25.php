<?php

  /**
  * content_25 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $subtitle= get_field('subtitle');
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $heading_size = get_field('heading_size');
  $client_image = get_field('client_image') ?: get_stylesheet_directory_uri() . '/images/content-25-client-image-placeholder.svg';

?>

<section class="content_25 bg-img <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container width-650 margin-auto">
    <div class="card shadow p-t-40 p-r-40 p-b-40 p-l-40 m-b-65">
      <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?>"><?php echo $heading; ?></h1>
    </div>
    <div data-aos="fade-up" data-aos-delay="250" class="row no-gutters p-l-25 p-r-25">
      <div class="col-auto square-80 m-r-30">
        <div class="responsive-sprites">
          <img class="icon-testimonial" src="<?php echo $client_image; ?>" alt="Image">
        </div>
      </div>
      <div class="col">
        <p class="large subtitle <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
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
