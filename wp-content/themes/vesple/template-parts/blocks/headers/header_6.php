<?php

  /**
  * header_6 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $testimonial = get_field('testimonial');
  $testimonial_name = get_field('testimonial_name');
  $testimonial_role = get_field('client_role');
  $testimonial_image = get_field('testimonial_image') ?: get_stylesheet_directory_uri() . '/images/header-6-testimonial-image-placeholder.svg';
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';
  $cf7_shortcode = get_field('cf7_shortcode');
  $heading_size = get_field('heading_size');
  $overlay_opacity = get_field('overlay_opacity') ?: 0;

?>

<header class="bg-img header_6 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-6">
      <h1 data-aos="fade-up" class="<?php echo $heading_size; ?> m-b-20 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
      <p data-aos="fade-up" data-aos-delay="250" class="subtitle large m-b-20 <?php echo $text_color; ?>">
        <?php echo $testimonial; ?>
      </p>
      <div class="row no-gutters align-items-center">
        <span class="col-md-auto m-r-20">
          <img src="<?php echo $testimonial_image; ?>" alt="Testimonial">
        </span>
        <div class="col-md-auto">
          <h6 class="<?php echo $text_color; ?>"><?php echo $testimonial_name; ?></h6>
          <p class="small <?php echo $text_color; ?>"><?php echo $testimonial_role; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-5 card no-borders">
      <?php echo do_shortcode($cf7_shortcode); ?>
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
</header>
