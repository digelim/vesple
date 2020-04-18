<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>

	<?php if ( !is_front_page() ) {
	?>
	<!-- Start of Async Drift Code -->
	<script>
	"use strict";

	!function() {
	  var t = window.driftt = window.drift = window.driftt || [];
	  if (!t.init) {
	    if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
	    t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ],
	    t.factory = function(e) {
	      return function() {
	        var n = Array.prototype.slice.call(arguments);
	        return n.unshift(e), t.push(n), t;
	      };
	    }, t.methods.forEach(function(e) {
	      t[e] = t.factory(e);
	    }), t.load = function(t) {
	      var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
	      o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
	      var i = document.getElementsByTagName("script")[0];
	      i.parentNode.insertBefore(o, i);
	    };
	  }
	}();
	drift.SNIPPET_VERSION = '0.3.1';
	drift.load('x6mkverwd7zh');
	</script>
	<!-- End of Async Drift Code -->
	<?php
	} ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-161453820-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-161453820-1');
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
</head>

<body <?php body_class(); ?>>
