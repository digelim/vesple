<?php

  /**
  * social_proof_2 Block Template.
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


?>

<section class="default-paddings social_proof_2 bg-img <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container align-center">
    <h1 class="<?php echo $heading_size; ?> m-b-60 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <div class="testimonials owl-carousel">

      <?php

        if( have_rows('testimonials_row') ):

            while ( have_rows('testimonials_row') ) : the_row();
                ?>

                <div class="testimonial">
                  <h4 class="type-regular width-650 margin-auto m-b-30"><?php the_sub_field('text'); ?></h4>
                  <h5 class="m-b-15 type-bold"><?php the_sub_field('name'); ?></h5>
                  <p class="subtitle small m-b-40"><?php the_sub_field('role'); ?></p>
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
      }

      @media (max-width: 480px) {
        #<?php echo $id; ?> {
           background-image: <?php echo $background_image_mobile; ?>;
        }
      }
  </style>
</section>
