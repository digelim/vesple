<?php

  /**
  * content_24 Block Template.
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

<section class="default-paddings bg-img content_24 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container width-850">
    <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-30 width-950 margin-auto align-center <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <div data-aos="fade-up" data-aos-delay="250" class="card-columns-2">

        <?php

          if( have_rows('faqs') ):

            while ( have_rows('faqs') ) : the_row();

              ?>

                <div class="m-t-30 inline-block">
                    <h2 class="m-b-15"><?php the_sub_field('title'); ?></h2>
                    <p class="subtitle small"><?php the_sub_field('content'); ?></p>
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
