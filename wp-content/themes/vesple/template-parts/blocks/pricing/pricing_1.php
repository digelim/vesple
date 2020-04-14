<?php

  /**
  * pricing_1 Block Template.
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

<section class="default-paddings bg-img pricing_1 align-center <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <h1 class="<?php echo $heading_size; ?> m-b-60 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <div class="card width-950 margin-auto">
      <div class="row align-center pricing-box margin-auto">

        <?php

          if( have_rows('pricing_row') ):

              $count = 0;

              while ( have_rows('pricing_row') ) : the_row();

                 $count = $count + 1;


                  if (get_sub_field('price') === 'Free') {
                    $amount = 0;
                  } else {
                    $amount = get_sub_field('price');
                  }


                  ?>

                  <div class="col flex-column row margin-auto p-l-40 p-r-40 p-t-40 p-b-40">

                      <div class="color-primary type-medium m-b-20">
                        <?php the_sub_field('package_name'); ?>
                      </div>
                      <h2 class="price-tag m-b-20"><?php the_sub_field('price'); ?></h2>
                      <p class="payment-cycle m-b-25 type-medium subtitle font-12 caps">
                        <?php the_sub_field('payment_cycle'); ?>
                      </p>
                      <div class="subtitle small">
                        <?php the_sub_field('description'); ?>
                      </div>
                    <div class="m-t-auto">
                      <div class="m-t-auto">
                        <div class="m-b-40 align-left">
                          <table class="m-t-15 border-top pricing-includes-table full-width">
                            <?php
                              if( have_rows('package_includes') ):

                                while ( have_rows('package_includes') ) : the_row();
                                    ?>

                                      <tr>
                                        <td><img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/package-includes.svg" alt="Image"></td>
                                        <td class="p-l-15">
                                          <div class="subtitle">
                                            <?php the_sub_field('item'); ?>
                                          </div>
                                        </td>
                                      </tr>

                                    <?php

                                endwhile;

                            endif;

                            if( have_rows('package_excludes') ):

                              while ( have_rows('package_excludes') ) : the_row();

                                  ?>

                                    <tr>

                                    </tr>
                                      <td></td>
                                      <td class="p-l-15">
                                        <div class="subtitle">
                                          <?php the_sub_field('item'); ?>
                                        </div>
                                      </td>
                                    </li>

                                  <?php

                              endwhile;

                            else :

                            endif;

                            ?>
                          </table>
                        </div>
                        <div class="m-t-auto ">
                          <?php
                          $url = get_sub_field('url');
                          $label = get_sub_field('label');
                          $target = get_sub_field('target');
                          $color = get_sub_field('color');
                          $round = get_field( 'round', 'options' );
                          $size = get_sub_field('size');
                          ?>

                          <a href="<?php echo $url; ?>" class="btn block <?php echo $color; ?> <?php echo $size; ?> <?php echo $round; ?> " target="<?php echo $target; ?>">
                            <?php echo $label; ?>
                          </a>
                        </div>
                      </div>
                    </div>
                    </div>

                  <?php

              endwhile;

          else :
          endif;

        ?>
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
      }

      @media (max-width: 480px) {
        #<?php echo $id; ?> {
           background-image: <?php echo $background_image_mobile; ?>;
        }
      }
  </style>
</section>
