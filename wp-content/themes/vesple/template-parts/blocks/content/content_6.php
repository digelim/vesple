<?php

  /**
  * content_6 Block Template.
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

<section class=" content_6 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="flex-44">
        <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-20 margin-auto <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
        <p data-aos="fade-up" data-aos-delay="250" class="subtitle large m-b-60 margin-auto <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>

          <?php

            if( have_rows('benefits_row') ):
                while ( have_rows('benefits_row') ) : the_row();

                ?>
                <div class="row" data-aos="fade-up" data-aos-delay="250">
                  <div class="col m-r-20">
                    <img src="<?php echo get_sub_field('image') ?: bloginfo('stylesheet_directory') . '/images/placeholder.svg'; ?>" alt="Image">
                    <p class="large type-medium m-b-15"><?php the_sub_field('title'); ?></p>
                    <p class="subtitle small"><?php the_sub_field('description'); ?></p>
                  </div>
                  <div class="col-auto <?php echo $text_color; ?>">
                    <p class="large type-medium m-b-15"><?php the_sub_field('title'); ?></p>
                    <p class="subtitle small"><?php the_sub_field('description'); ?></p>
                  </div>
                </div>

                <?php

              endwhile;

          else :
          endif;

        ?>
      </div>
      <div class="flex-33">
        <img src="<?php echo $image; ?>" alt="Image">
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
