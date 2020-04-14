<?php

  /**
  * content_17 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $text_color = get_field('text_color');
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';

?>

<section class=" content_17 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">

  <?php

    $statistics_count = sizeof(get_field('statistics_row'));
    $statistics_class = '';
    $width_class = '';

    switch ( $statistics_count ) {
      case 2:
        $responsive_class = ' responsive-320';
        $width_class = ' width-400';

        break;
      case 3:
        $responsive_class = ' responsive-480';
        $width_class = ' width-600';

        break;
      case 4:
        $responsive_class = ' responsive-650';
        $width_class = ' width-800';

      case 5:
        $responsive_class = ' responsive-991';
        $width_class = ' width-900';

        break;
    }
  ?>

  <div class="container <?php echo $width_class; ?>">
    <div class="row justify-content-between">
      <?php
      if( have_rows('statistics_row') ):
          $count = 0;
          while ( have_rows('statistics_row') ) : the_row();
          ?>
            <div data-aos="fade-up" data-aos-delay="<?php echo ( $count * 250 ); ?>" class="col-auto <?php echo $responsive_class; ?> align-center">
              <h1 class="large type-bold m-b-25 <?php echo $text_color; ?>"><?php the_sub_field('title'); ?></p>
              <p class="small type-medium <?php echo $text_color; ?>"><?php the_sub_field('description'); ?></p>
            </div>

          <?php
          $count++;
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
