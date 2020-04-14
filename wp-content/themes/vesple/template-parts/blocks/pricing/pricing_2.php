<?php

  /**
  * pricing_2 Block Template.
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
  $image = get_field('image');
  $heading_size = get_field('heading_size');

?>

<section class="default-paddings bg-img pricing_2 align-center <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
    <h1 class="<?php echo $heading_size; ?> m-b-35 <?php echo $text_color; ?>"><?php echo $heading; ?></h1>
    <p class="subtitle large m-b-65"><?php echo $subtitle; ?></p>
    <div class="width-650 margin-auto">
      <div class="row align-center justify-content-between pricing-box margin-auto">

        <?php

          if( have_rows('pricing_row') ):

              while ( have_rows('pricing_row') ) : the_row();

                  if (get_sub_field('price') == '0') {
                    $amount = 'Free';
                  } else {
                    $amount = get_sub_field('price');
                  }

                  ?>

                  <div class="flex-49 row flex-column p-l-30 p-r-30 p-t-40 p-b-40 card shadow">
                    <p class="color-primary medium type-medium m-b-25">
                      <?php the_sub_field('package_name'); ?>
                    </p>
                    <div class="price-tag type-medium m-b-25">
                      <?php echo $amount; ?>
                    </div>
                    <div class="subtitle small m-b-30">
                      <?php the_sub_field('description'); ?>
                    </div>
                    <div class="m-t-auto">
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
