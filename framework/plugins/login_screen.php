<?php
//--------------- Login Screen Wallpaper ---------------//

	function login_enqueue_scripts(){

		echo '

			<div class="background-cover"></div>

			<style type="text/css" media="screen">

				.background-cover

					{
						background:#EFEFEF;

					}

				#login

					{

						z-index:9999;

						position:relative;

					}

				.login form

					{

						-moz-box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, .2) !important;

						-webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, .2) !important;

						box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, .2) !important;

						-moz-border-radius: 14px;
						webkit-border-radius: 14px;
						border-radius: 14px;
						khtml-border-radius: 14px;
						border:1px solid #DDD;
					}

				.login h1 a

					{

						background:url('.get_bloginfo('template_directory').'/framework/plugins/images/loginScreen-logo.png) no-repeat center top !important;margin-bottom:5px;

					}

				input.button-primary, button.button-primary, a.button-primary

					{


	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #ffffff;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#f0f0f0 0%,
		#b8b8b8 25%,
		#6b6b6b 75%,
		#424242);
	background: -webkit-gradient(
		linear, left top, left bottom,
		from(#f0f0f0),
		color-stop(0.25, #b8b8b8),
		color-stop(0.75, #6b6b6b),
		to(#424242));
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	border-radius: 6px;
	border: 0px;
	-moz-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 10px rgba(087,087,087,0.7);
	-webkit-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 10px rgba(087,087,087,0.7);
	box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 10px rgba(087,087,087,0.7);
	text-shadow:
		0px -1px 0px rgba(000,000,000,0.4),
		0px 1px 0px rgba(255,255,255,0.3);

					}

				.button:active, .submit input:active, .button-secondary:active

					{

						background:#96C800 !important;

						text-shadow: none !important;



					}

				.login #nav a, .login #backtoblog a

					{

						color:#777 !important;

						text-shadow: none !important;
						text-deocration:none;

					}

				.login #nav a:hover, .login #backtoblog a:hover

					{

						color:#000 !important;

						text-shadow: none !important;

					}

				.login #nav, .login #backtoblog

					{

						text-shadow: none !important;

					}

				</style>

		';

	}

	add_action( 'login_enqueue_scripts', 'login_enqueue_scripts' );
