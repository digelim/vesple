<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

$product_detail_accordions = get_field('product_detail_accordions');
$product_details_table = get_field('product_details_table');

$benefit_1_title = get_field('benefit_1_title'); // THC Free
$benefit_1_content = get_field('benefit_1_content'); // Enjoy our products with no high whatsoever. Feel better while keeping a clear mind.
$benefit_2_title = get_field('benefit_2_title'); // CO2 Extracted
$benefit_2_content = get_field('benefit_2_content'); // Clean, pure safe, and completely free of any toxic residue extraction method.
$benefit_3_title = get_field('benefit_3_title'); // Whole Plant Benefits
$benefit_3_content = get_field('benefit_3_content'); // Maximize wellness by introducing all parts of the plant than just CDB alone.
$benefit_4_title = get_field('benefit_4_title'); // Terpenes
$benefit_4_content = get_field('benefit_4_content'); // Feel better, get better with naturally derived terpenes intact.

$content_1_title = get_field('content_1_title'); // More than just CDB
$contente_1_description = get_field('contente_1_description'); // Get the benefits of CBD along with other phytocannabinoids & terpenes with our Broad Spectrum CBD Oil. There are 100+ phytocannabinoids and over 200 terpenes found in hemp that each have a unique feature and to ignore it is to leave out a big part of the powerful benefits of hemp.
$content_1_image = get_field('content_1_image');
$content_2_title = get_field('content_2_title'); // Feel the Difference
$contente_2_description = get_field('contente_2_description'); // Designed to support those with demanding lifestyles, our CDB Oil offers easy, consistent servings of Colorado Botanicals that run as hard as you do to provide even more support for everyday stresses, help in achieving a sense of calm, recovery from exercise-induced inflammation, and healthy sleep cycles.
$content_2_image = get_field('content_2_image');

?>
<?php while ( have_posts() ) : the_post(); ?>

	<div class="p-l-20 p-r-20">
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
	</div>

	<section>
		<div class="container m-t-110">
			<div class="width-1150 margin-auto">
				<div class="row">
					<div data-aos="fade-right" class="flex-50 p-r-25 single-product-accordions-column responsive-768">
						<?php
						if( have_rows('product_detail_accordions') ):
					    while ( have_rows('product_detail_accordions') ) : the_row();
							?>
								<div class="accordion-item"><?php the_sub_field('title'); ?> <i class="icon-expand_more inline-block font-24"></i></div>
						    <p class="accordion-content subtitle medium ">
						      <?php the_sub_field('description'); ?>
						    </p>
							<?php
					    endwhile;
						endif;
						?>
					</div>
					<div data-aos="fade-left" class="flex-50 p-l-25 responsive-768 single-product-details-column">
						<div class="card p-l-40 p-t-40 p-r-40 p-b-40 single-product-details">
							<?php
							if( have_rows('product_details_table') ):
						    while ( have_rows('product_details_table') ) : the_row();
								?>
									<div class="m-b-15 font-18">
										<b><?php the_sub_field('title'); ?></b><br>
										<?php the_sub_field('description'); ?>
									</div>
								<?php
						    endwhile;
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="p-t-130">
		<div class="container">
			<div class="row justify-content-between no-gutters">
				<div data-aos="fade-down" class="flex-45 m-b-50 responsive-768">
					<div class="row no-gutters">
						<div class="col-auto m-r-40">
							<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/thc-free.svg" alt="Image">
						</div>
						<div class="col">
							<p class="type-bold font-24 m-b-10"><?php echo $benefit_1_title; ?></p>
							<p class="subtitle medium"><?php echo $benefit_1_content; ?></p>
						</div>
					</div>
				</div>
				<div data-aos="fade-down" data-aos-delay="300" class="flex-45 m-b-50 responsive-768">
					<div class="row no-gutters">
						<div class="col-auto m-r-40">
							<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/co2-extracted.svg" alt="Image">
						</div>
						<div class="col">
							<p class="type-bold font-24 m-b-10"><?php echo $benefit_2_title; ?></p>
							<p class="subtitle medium"><?php echo $benefit_2_content; ?></p>
						</div>
					</div>
				</div>
				<div data-aos="fade-down" data-aos-delay="600" class="flex-45 m-b-50 responsive-768">
					<div class="row no-gutters">
						<div class="col-auto m-r-40">
							<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/whole-plant-benefits.svg" alt="Image">
						</div>
						<div class="col">
							<p class="type-bold font-24 m-b-10"><?php echo $benefit_3_title; ?></p>
							<p class="subtitle medium"><?php echo $benefit_3_content; ?></p>
						</div>
					</div>
				</div>
				<div data-aos="fade-down" data-aos-delay="900" class="flex-45 m-b-50 responsive-768">
					<div class="row no-gutters">
						<div class="col-auto m-r-40">
							<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/terpenes.svg" alt="Image">
						</div>
						<div class="col">
							<p class="type-bold font-24 m-b-10"><?php echo $benefit_4_title; ?></p>
							<p class="subtitle medium"><?php echo $benefit_4_content; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="p-t-40 hide-max-768">
		<div class="width-1000 margin-auto">
			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div data-aos="fade-right" class="flex-47 responsive-768">
						<h1 class="small m-b-20"><?php echo $content_1_title; ?></h1>
						<div class="subtitle font-18">
							<?php echo $contente_1_description; ?>
						</div>
					</div>
					<div data-aos="fade-left" class="flex-47 responsive-768">
						<img src="<?php echo $content_1_image; ?>" alt="Image">
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="p-t-40 hide-max-768">
		<div class="width-1000 margin-auto">
			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div data-aos="fade-right" class="flex-47 responsive-768">
						<img src="<?php echo $content_2_image; ?>" alt="Image">
					</div>
					<div data-aos="fade-left" class="flex-47 responsive-768">
						<h1 class="small m-b-20"><?php echo $content_2_title; ?></h1>
						<div class="subtitle font-18">
							<?php echo $contente_2_description; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="what-people-saying" class="p-t-100 p-b-130 m-t-85">
		<div class="width-700 margin-auto">
			<h1 data-aos="fade-down" class="small m-b-30 align-center mobile-font-20">What Are People Saying About <?php the_title(); ?>?</h1>
			<div data-aos="fade-down" data-aos-delay="300" class="container">
				<?php
	      $average = $product->get_average_rating();
	      $total = $product->get_review_count();

	      echo '<div class="star-rating margin-auto m-b-20"><span style="width:'.( ( $average/5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
	      echo '<div class="subtitle m-b-35 align-center">' . $total . ' Reviews</div>';
	      ?>
		    <div class="width-350 margin-auto">
		      <div class="row align-items-center m-b-10">
		        <div class="flex-41">
		          <div class="row align-items-center justify-content-between no-gutters">
		            <div class="col">
		              <div class="star-rating">
		                <span style="width: 100%;">
		                  <strong itemprop="ratingValue" class="rating">5</strong>
		                </span>
		              </div>
		            </div>
		            <div class="col font-12 subtitle m-l-10">
		              (0)
		            </div>
		          </div>
		        </div>
		        <div class="flex-56">
		          <progress max="100" value="width:'<?php echo ( ( $average/5 ) * 100 ); ?>"></progress>
		        </div>
		      </div>
		      <div class="row align-items-center m-b-10">
		        <div class="flex-41">
		          <div class="row align-items-center justify-content-between no-gutters">
		            <div class="col">
		              <div class="star-rating">
		                <span style="width: 80%;">
		                  <strong itemprop="ratingValue" class="rating">4</strong>
		                </span>
		              </div>
		            </div>
		            <div class="col font-12 subtitle m-l-10">
		              (0)
		            </div>
		          </div>
		        </div>
		        <div class="flex-56">
		          <progress max="100" value="0"></progress>
		        </div>
		      </div>
		      <div class="row align-items-center m-b-10">
		        <div class="flex-41">
		          <div class="row align-items-center justify-content-between no-gutters">
		            <div class="col">
		              <div class="star-rating">
		                <span style="width: 60%;">
		                  <strong itemprop="ratingValue" class="rating">3</strong>
		                </span>
		              </div>
		            </div>
		            <div class="col font-12 subtitle m-l-10">
		              (0)
		            </div>
		          </div>
		        </div>
		        <div class="flex-56">
		          <progress max="100" value="0"></progress>
		        </div>
		      </div>
		      <div class="row align-items-center m-b-10">
		        <div class="flex-41">
		          <div class="row align-items-center justify-content-between no-gutters">
		            <div class="col">
		              <div class="star-rating">
		                <span style="width: 40%;">
		                  <strong itemprop="ratingValue" class="rating">2</strong>
		                </span>
		              </div>
		            </div>
		            <div class="col font-12 subtitle m-l-10">
		              (0)
		            </div>
		          </div>
		        </div>
		        <div class="flex-56">
		          <progress max="100" value="0"></progress>
		        </div>
		      </div>
		      <div class="row align-items-center">
		        <div class="flex-41">
		          <div class="row align-items-center justify-content-between no-gutters">
		            <div class="col">
		              <div class="star-rating">
		                <span style="width: 20%;">
		                  <strong itemprop="ratingValue" class="rating">1</strong>
		                </span>
		              </div>
		            </div>
		            <div class="col font-12 subtitle m-l-10">
		              (0)
		            </div>
		          </div>
		        </div>
		        <div class="flex-56">
		          <progress max="100" value="0"></progress>
		        </div>
		      </div>
		    </div>
				<!--
					<div class="m-t-80">
					<div class="card block p-t-40 p-r-40 p-b-40 p-l-40 m-b-40">
						<div class="row no-gutters align-items-center justify-content-between m-b-15">
							<div class="row col-auto align-items-center">
								<p class="col-auto type-bold large">Vincent Stewart</p>
								<p class="subtitle font-12">Verified buyer</p>
							</div>
							<div class="col-auto font-14 subtitle">
								24 Dec 2018
							</div>
						</div>
						<div class="star-rating m-b-15">
							<span style="width: 100%;">
								<strong itemprop="ratingValue" class="rating">5</strong>
							</span>
						</div>
						<p class="small subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat aute irure dolor.</p>
					</div>
					<div class="card block p-t-40 p-r-40 p-b-40 p-l-40 m-b-40">
						<div class="row no-gutters align-items-center justify-content-between m-b-15">
							<div class="row col-auto align-items-center">
								<p class="col-auto type-bold large">Vincent Stewart</p>
								<p class="subtitle font-12">Verified buyer</p>
							</div>
							<div class="col-auto font-14 subtitle">
								24 Dec 2018
							</div>
						</div>
						<div class="star-rating m-b-15">
							<span style="width: 100%;">
								<strong itemprop="ratingValue" class="rating">5</strong>
							</span>
						</div>
						<p class="small subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat aute irure dolor.</p>
					</div>
					<div class="card block p-t-40 p-r-40 p-b-40 p-l-40 m-b-40">
						<div class="row no-gutters align-items-center justify-content-between m-b-15">
							<div class="row col-auto align-items-center">
								<p class="col-auto type-bold large">Vincent Stewart</p>
								<p class="subtitle font-12">Verified buyer</p>
							</div>
							<div class="col-auto font-14 subtitle">
								24 Dec 2018
							</div>
						</div>
						<div class="star-rating m-b-15">
							<span style="width: 100%;">
								<strong itemprop="ratingValue" class="rating">5</strong>
							</span>
						</div>
						<p class="small subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat aute irure dolor.</p>
					</div>
					<div class="align-center">
						<a href="#" class="btn ghost transparent medium text-black m-t-20">LOAD MORE (275)</a>
					</div>
				</div> -->
		  </div>
		</div>
	</section>

	<?php
	global $product;
	$limit = 3;
	$columns = 3;
	$upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), 'rand', 'desc' );
	$upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells;
	wc_get_template(
		'single-product/up-sells.php',
		array(
			'upsells'        => $upsells,
			// Not used now, but used in previous version of up-sells.php.
			'posts_per_page' => $limit,
			'orderby'        => 'rand',
			'columns'        => $columns,
		)
	);
	?>

<?php endwhile; // end of the loop. ?>

<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
?>

<?php get_footer( $footer );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
