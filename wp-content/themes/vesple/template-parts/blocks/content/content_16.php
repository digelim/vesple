<?php

  /**
  * content_16 Block Template.
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

<section class=" content_16 row <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container col-auto width-850 margin-auto">

    <?php

      if( have_rows('benefits_row') ):

        while ( have_rows('benefits_row') ) : the_row();

        ?>
          <div data-aos="fade-up" data-aos-delay="0" class="row benefit-row col-auto no-gutters">
            <div class="col-auto m-r-80 responsive-768">
              <img src="<?php echo get_sub_field('image') ?: bloginfo('stylesheet_directory') . '/images/placeholder.svg'; ?>" alt="Image">
            </div>
            <div class="col responsive-768">
              <h1 class="small type-medium m-b-25 <?php echo $text_color; ?>"><?php the_sub_field('title'); ?></h1>
              <p class="subtitle small <?php echo $text_color; ?>"><?php the_sub_field('description'); ?></p>
            </div>
          </div>

        <?php

        endwhile;
      endif;

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

      @media (max-width: 480px) {
        #<?php echo $id; ?> {
           background-image: <?php echo $background_image_mobile; ?>;
        }
      }
  </style>
</section>
