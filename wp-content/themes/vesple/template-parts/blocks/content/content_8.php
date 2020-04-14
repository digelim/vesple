<?php

  /**
  * content_8 Block Template.
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
  $round = get_field( 'round', 'options' );

?>

<section class=" bg-img content_8 <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <h1 data-aos="fade-up" data-aos-delay="0" class="<?php echo $heading_size; ?> m-b-20 width-950 margin-auto align-center <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <p data-aos="fade-up" data-aos-delay="250" class="subtitle large width-800 margin-auto align-center m-b-60 <?php echo $text_color; ?>"><?php echo $subtitle; ?></p>
    <div class="align-center">
      <div class="btns-group justify-content-center m-b-70">
        <?php

          if( have_rows('tabs') ):

            $flag = true;

            while ( have_rows('tabs') ) : the_row();

                ?>

                  <a href="#" class="tab <?php echo $round; ?> <?php echo $text_color; ?> <?php if ($flag): ?>active<?php endif; ?>" data-id="<?php the_sub_field('id'); ?>"><?php the_sub_field('label'); ?></a>

                <?php

                $flag = false;

            endwhile;

          else :

          endif;

        ?>

      </div>
    </div>

    <?php

      if( have_rows('tabs') ):
        $style = '';

        while ( have_rows('tabs') ) : the_row();

            ?>

            <div class="tab-content" style="<?php echo $style; ?>" id="<?php the_sub_field('id'); ?>">
              <div class="container-fluid" data-aos="fade-up" data-aos-delay="500">
                <div class="row justify-content-center">
                  <div class="col-auto m-r-100">
                    <img src="<?php echo get_sub_field('image') ?: bloginfo('stylesheet_directory') . '/images/block-content-8-placeholder.svg'; ?>" class="shadow">
                  </div>
                  <div class="flex-45 <?php echo $text_color; ?>">
                    <h3 class="m-b-20"><?php the_sub_field('title'); ?></h3>
                    <p class="small subtitle"><?php the_sub_field('content') ?></p>
                  </div>
                </div>
              </div>
            </div>

            <?php

        $style = 'display: none;';

        endwhile;

      else :

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
