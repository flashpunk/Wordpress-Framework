<?php
//
// scripts
//
add_action( 'wp_enqueue_scripts', 'app_load_javascript_files' );

// Register some javascript files, because we love javascript files. Enqueue a couple as well

function app_load_javascript_files() {

	// unregistering wordpress jquery
	wp_deregister_script('jquery');

	// adding necessary scripts back in
	wp_register_script( 'jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"), false, '1.9.1', true);
	wp_register_script( 'audio', get_template_directory_uri() . '/app/audio.min.js', false, '1', true );
	//wp_register_script( 'jplist', get_template_directory_uri() . '/app/jplist.min.js', false, '1', true );
	wp_register_script( 'app', get_template_directory_uri() . '/app/app.js', false, '1', true );

	// registering scripts back in
	wp_enqueue_script('jquery');
	wp_enqueue_script('audio');
	wp_enqueue_script('app');

//	if ( 'research-centre' == get_post_type() || 'resource-library' == get_post_type() ) {
//	}

}
