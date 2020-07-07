<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if ( is_page('my-account') ) {
	?>

	<meta name="robots" content="noindex,nofollow">

	<?php
	} ?>

	<?php wp_head(); ?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-161453820-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-161453820-1');
		gtag('config', 'AW-968076197');
	</script>
	<!-- Hotjar Tracking Code for vesple.com -->
	<script>
	    (function(h,o,t,j,a,r){
	        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
	        h._hjSettings={hjid:1746329,hjsv:6};
	        a=o.getElementsByTagName('head')[0];
	        r=o.createElement('script');r.async=1;
	        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
	        a.appendChild(r);
	    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>

	<?php
	if ( is_account_page() ) {
		?>

		<!-- Event snippet for Purchase conversion page -->
		<script>
		  gtag('event', 'conversion', {
		      'send_to': 'AW-968076197/W2zNCIqszdYBEKXXzs0D',
		      'transaction_id': ''
		  });
		</script>

		<?php
	}
	?>
</head>

<body <?php body_class(); ?>>
