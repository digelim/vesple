<?php

  /**
  * content_7 Block Template.
  */

  $id = $block['id'];
$bottom_padding = get_field('bottom_padding');
  $top_padding = get_field('top_padding');
  $text_color = get_field('text_color');
  $heading = get_field('heading');
  $subtitle = get_field('subtitle');
  $heading_size = get_field('heading_size');
  $image = get_field('image');
  $background_image_desktop = get_field('background_image_desktop')? "url(" . get_field('background_image_desktop') . ")" : 'none';
  $background_image_mobile = get_field('background_image_mobile') ?: '';
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';
  $overlay_opacity = get_field('overlay_opacity') ?: 0;

?>

<section class=" content_7 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-20 align-center <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <p data-aos="fade-up" data-aos-delay="250" class="subtitle align-center large m-b-60 width-650 margin-auto <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
      <div class="row" data-aos="fade-up" data-aos-delay="500">
      <?php

        if( have_rows('benefits_row') ):

          while ( have_rows('benefits_row') ) : the_row();

            ?>
              <div class="col-md-6 m-b-30">
                <div class="row">
                  <div class="col-auto m-r-20 m-t-10">
                    <img src="<?php echo get_sub_field('image') ?: bloginfo('stylesheet_directory') . '/images/placeholder.svg'; ?>" alt="Image">
                  </div>
                  <div class="col">
                    <p class="large type-medium m-b-10 <?php echo $text_color; ?>"><?php the_sub_field('title'); ?></p>
                    <p class="subtitle small <?php echo $text_color; ?>"><?php the_sub_field('description'); ?></p>
                  </div>
                </div>
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
