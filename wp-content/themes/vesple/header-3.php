<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php

		$navigation_theme = get_field('navigation_theme', 'options');

		if ( $navigation_theme == 'dark' ) {
			$logo = get_field('white_logo', 'options');
		} else {
			$logo = get_field('black_logo', 'options');
		}

	?>

	<nav class="navigation_3">
		<div class="container-fluid">
			<div class="main-menu row no-gutters justify-content-between align-items-center">
				<a class="logo" href="/">
					<?php if ( $logo ): ?>
						<img src="<?php echo $logo; ?>" alt="Logo" class="inline-block">
					<?php
						else:
							?>

								LOGO

							<?php
						endif;
					?>
				</a>
				<div class="menu-wrapper row align-items-center p-r-15">
					<?php
						wp_nav_menu(array(
							'theme_location' => 'Primary',
							'menu' => 'menu-1',
							'menu_class' => 'navigation-list',
						));
					?>
					<div class="navigation-extra-elements">

						<?php
							if( have_rows('extra_navigation_elements', 'options') ):

								?>

									<div class="m-l-40">

										<?php

											while ( have_rows('extra_navigation_elements', 'options') ) : the_row();

												the_sub_field('item');

											endwhile;

										?>

									</div>

								<?php

							endif;
						?>

					</div>
			</div>
			</div>
		</div>
	</nav>


	<div class="mobile-menu">
		<div class="container">
			<div class="menu-wrapper">
				<?php
					wp_nav_menu(array(
						'theme_location' => 'Primary',
						'menu' => 'menu-1',
						'menu_class' => 'navigation-list',
					));
				?>
			</div>
		</div>
		<a href="#" class="close-mobile-menu">
			<i class="fa fa-times"></i>
		</a>
	</div>

	<a href="#" class="open-mobile-menu">
		<i class="fa fa-bars"></i>
	</a>
