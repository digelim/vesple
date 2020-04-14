<?php

  /**
  * content_21 Block Template.
  */

  $id = $block['id'];
  $bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $heading_size = get_field('heading_size');

?>

<section class=" bg-img content_21 align-center <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">

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

  <div class="container">
    <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-75 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <div class="row align-center margin-auto <?php echo $width_class; ?>">

      <?php

        if( have_rows('benefits_row') ):
            $count = 0;
            while ( have_rows('benefits_row') ) : the_row();
              $count++;
            ?>

              <div data-aos="fade-up" data-aos-delay="<?php echo ( $count * 250 ); ?>" class="col <?php echo $text_color; ?> <?php echo $responsive_class; ?>">
                <p class="large type-medium m-b-30 color-primary"><?php the_sub_field('title'); ?></p>
                <p class="subtitle small m-b-30"><?php the_sub_field('description'); ?></p>
                <p class="type-bold content">
                  <?php echo the_sub_field('content'); ?>
                </p>
              </div>

              <?php

            endwhile;
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
