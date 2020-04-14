<?php

  /**
  * header_12 Block Template.
  */

  $bottom_padding = get_field('bottom_padding');
  $id = $block['id'];
  $top_padding = get_field('top_padding');
  $image = get_field('image') ?: get_stylesheet_directory_uri() . '/images/header-12-image-placeholder.svg';;
  $heading_size = get_field('heading_size');
  $overlay_opacity = get_field('overlay_opacity') ?: 0;
  $overlay_color = get_field('overlay_color') ?: 'rgba(0,0,0,0)';

?>


<header class="bg-img header_12" id="<?php echo esc_attr($id); ?>">
  <div class="content-wrapper">
    <div class="owl-carousel owl-theme hero-carousel">
      <?php

        if( have_rows('slider') ):
          $count = 0;

            while ( have_rows('slider') ) : the_row();
                $count .= 1;
                $slide_id = $id . '-slide-' . $count;
                $heading = get_sub_field('heading');
                $subtitle = get_sub_field('subtitle');
                $background_image_desktop = get_sub_field('background_image_desktop');
                $background_image_mobile = get_sub_field('background_image_mobile');
                $text_color = get_sub_field('text_color');

                ?>

                <div class="hero-slide <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($slide_id); ?>">
                  <div class="container">
                    <div class="flex-54 hero-content">
                      <h1 class="<?php echo $heading_size; ?> m-b-20 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
                      <p class="subtitle large m-b-40 <?php echo $text_color; ?>">
                        <?php echo $subtitle; ?>
                      </p>

                        <?php

                          if( have_rows('buttons') ):

                            ?>

                            <div class="btns-group">

                              <?php

                              while ( have_rows('buttons') ) : the_row();

                                $url = get_sub_field('url');
                                $label = get_sub_field('label');
                                $target = get_sub_field('target');
                                $color = get_sub_field('color');
                                $round = get_field( 'round', 'options' );
                                $size = get_sub_field('size');
                                ?>

                                <a href="<?php echo $url; ?>" class="btn <?php echo $color; ?> <?php echo $size; ?> <?php echo $round; ?> " target="<?php echo $target; ?>">
                                  <?php echo $label; ?>
                                </a>

                                <?php

                              endwhile;

                              ?>

                            </div>

                            <?php

                          else :
                          endif;

                        ?>
                    </div>
                    <style>
                      #<?php echo $slide_id; ?> {
                         background-image: <?php echo 'url(' . $background_image_desktop . ')' ?: 'none'; ?>;
                         position: relative;
                      }

                      @media (max-width: 480px) {
                        #<?php echo $slide_id; ?> {
                           background-image: <?php echo 'url(' . $background_image_mobile . ')'  ?: 'none'; ?>;
                        }
                      }
                    </style>
                  </div>
                </div>

                <?php


            endwhile;

        else :

        endif;

        ?>

    </div>
    <div class="hero-image">
      <img src="<?php echo $image; ?>" alt="Image">
    </div>
  </div>
  <style type="text/css">
      #<?php echo $id; ?> {
         background-image: <?php echo $background_image_desktop; ?>;
         position: relative;
      }

      #<?php echo $id; ?> .content-wrapper {
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
