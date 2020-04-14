<?php

  /**
  * content_3 Block Template.
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


?>

<section class=" bg-img content_3 align-center <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">

  <?php

    $benefits_count = sizeof(get_field('benefits_row'));
    $responsive_class = '';
    $width_class = '';

    switch ( $benefits_count ) {
      case 2:
        $responsive_class = ' responsive-480';
        $width_class = ' width-700';

        break;
      case 3:
        $responsive_class = ' responsive-768';
        $width_class = ' width-1000';

        break;
      case 4:
        $responsive_class = ' responsive-991';

        break;
    }
  ?>

  <div class="container <?php echo $width_class; ?>">
    <h1 data-aos="fade-up" class="<?php echo $heading_size; ?> m-b-20 width-950 margin-auto <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <p data-aos="fade-up" data-aos-delay="250" class="subtitle large width-950 margin-auto <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
    <div class="row align-center margin-auto">

      <?php

        if( have_rows('benefits_row') ):
            $count = 0;
            while ( have_rows('benefits_row') ) : the_row();
              $count++;
              ?>

              <div data-aos="fade-up" data-aos-delay="<?php echo ( $count * 250 ); ?>" class="col <?php echo $text_color; ?> <?php echo $responsive_class; ?> m-t-60">
                <img src="<?php echo get_sub_field('image') ?: bloginfo('stylesheet_directory') . '/images/placeholder.svg'; ?>" alt="Image" class="m-b-20">
                <p class="large type-medium m-b-10"><?php the_sub_field('title'); ?></p>
                <p class="subtitle small"><?php the_sub_field('description'); ?></p>
              </div>

              <?php

            endwhile;

        else :
        endif;

      ?>
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
