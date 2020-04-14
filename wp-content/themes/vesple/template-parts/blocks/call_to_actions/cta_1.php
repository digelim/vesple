<?php

  /**
  * cta_1 Block Template.
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
  $overlay_opacity = get_field('overlay_opacity') ?: '0';

?>


<section class="default_paddings bg-img cta_1 align-center <?php echo $top_padding . ' ' . $bottom_padding; ?>" id="<?php echo esc_attr($id); ?>">
  <div class="container">
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
              <?php if ($icon !== 'none'): ?>
                <i class="<?php echo $icon; ?>">

                </i>
              <?php endif; ?>
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
  <style type="text/css">
      #<?php echo $id; ?> {
         background-image: url(<?php echo $background_image_desktop; ?>);
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

      <?php if( isset( $background_image_mobile ) ) : ?>
        @media (max-width: 480px) {
          #<?php echo $id; ?> {
             background-image: <?php echo $background_image_mobile; ?>;
          }
        }
      <?php endif; ?>
  </style>
</section>
