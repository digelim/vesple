<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<nav class="navigation_9">
		<div class="container">
			<div class="main-menu row no-gutters justify-content-between align-items-center">
				<a class="logo" href="/">
					<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/dist/logo.png" alt="Tyellem" class="inline-block">
				</a>
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
