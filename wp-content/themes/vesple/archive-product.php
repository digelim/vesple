<?php
get_header();
?>

<div class="assets-popup-overlay">
      <div class="subscription-pupup card">
          <a href="<?php echo home_url('portfolio') ?>"><span class="icon-delete" id="close-subscription-popup"></span></a>
          <h1 class="label-m1 align-center">You've reached your limit. Pick a plan to continue</h1>
          <h2 class="label-s2 light m-t-5 align-center">All plans give you unlimited access.</h2>
          <div class="plans-box m-t-30 row flex-nowrap no-gutters justify-content-around">

          <?php
          if ( woocommerce_product_loop() ) :

          	if ( wc_get_loop_prop( 'total' ) ) {

          		while ( have_posts() ) {
          			the_post();
          			//wc_get_template_part( 'template-parts/content', 'product' );
                global $woocommerce, $product, $post;
                $subscription = new WC_Subscriptions_Product( $product );
                ?>
                <div class="card plan-card align-center">
                  <h3 class="label-s2 blue-text bold"><?php echo $product->get_title(); ?></h3>
                  <div class="price-tag label-l1 bold m-t-15">
                    <?php echo $product->get_price_html(); ?>
                  </div>
                  <div class="label-s1 m-b-15">
                  </div>
                  <div class="plan-description label-s2 light m-b-50">
                    <?php echo $product->get_short_description(); ?>
                  </div>
                  <?php
                  echo apply_filters(
                    'woocommerce_loop_add_to_cart_link',
                    sprintf(
                        '<a target="_self" href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="btn-primary small select-plan add-to-cart-button %s product_type_%s">Subscribe</a>',
                        esc_url( $product->add_to_cart_url() ),
                        esc_attr( $product->get_id() ),
                        esc_attr( $product->get_sku() ),
                        $product->is_purchasable() ? 'add_to_cart_button' : '',
                        esc_attr( $product->get_type() ),
                        esc_html( $product->add_to_cart_text() )
                    ),
                    $product
                  );
                  ?>
                </div>
                <?php
          		}
          	}
          endif;
          ?>
          </div>
      </div>
    </div>

<?php
get_footer();
?>
