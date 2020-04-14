<?php if ( have_posts() ) : ?>

	<?php
	get_template_part( 'template-parts/dashboard', 'portfolio' );

else :

	get_template_part( 'content', 'none' );

endif;
?>
