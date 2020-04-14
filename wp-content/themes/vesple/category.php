<?php
  $navigation = get_field('navigation', 'options') ?: null;
  $footer = get_field('footer', 'options') ?: null;

  get_header( $navigation );
?>

<section class="p-t-90 bg-img p-l-20 p-r-20" id="learn-header">
  <div class="container width-650 align-center mobile-align-left">
    <h1 data-aos="fade-down" class="medium m-b-15 text-white">Learn About CBD</h1>
    <p data-aos="fade-down" data-aos-delay="300" class=" small text-white">Our team consists of bright, educated, & experienced individuals who are experts in everything about CBD and how it works. They will also be able to advice you on how you can incorporate Colorado Botanicals CBD products into your daily life to maximize your results. </p>
  </div>
  <div class="container width-1100 m-t-25">
    <div class="card p-t-35 p-b-35 p-l-100 p-r-100 learn-menu-card shadow hide-max-991">
      <?php
        wp_nav_menu(array(
          'theme_location' => 'Learn',
          'menu' => 'learn-menu',
          'menu_class' => 'learn-list',
        ));
      ?>
    </div>
    <div class="shadow hide-min-992 relative learn-mobile-menu-wrapper">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'Learn',
      	'menu'           => 'learn-menu',
      	'walker'         => new Walker_Nav_Menu_Dropdown(),
      	'items_wrap'     => '<form><select onchange="if (this.value) window.location.href=this.value">%3$s</select></form>',
      ) );
      ?>
    </div>
  </div>
</section>

<div class="p-t-110 p-b-190 p-l-20 p-r-20">
  <div class="container width-1050">
    <div class="row justify-content-between no-gutters">
      <div class="col-md width-750">
        <?php
        	while ( have_posts() ) :
        		the_post();
            get_template_part( 'template-parts/content', get_post_format() );

        	endwhile; // End of the loop.
        ?>
      </div>
      <div class="flex-25 responsive-768 blog-sidebar">
        <?php dynamic_sidebar('blog'); ?>
      </div>
    </div>
  </div>
</div>

<?php
get_footer( $footer );
