<?php
// Add theme support for Post Thumbnails
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 75, 75, TRUE );

if ( function_exists( 'add_image_size' ) ) {
	//add_image_size( 'square-300x300', 300, 300, TRUE );
	add_image_size( 'square-160', 160, 160, TRUE );
	//add_image_size( 'thumb-300x150', 300, 150, FALSE );
	//add_image_size( 'thumbAlt-715x425', 715, 425, FALSE );
	//add_image_size( 'thumb-330x250', 330, 250, TRUE );
	//add_image_size( 'thumb-fb', 200, 200, TRUE );
/*
	add_image_size( 'homeslider-650x150', 650, 300, TRUE );
	add_image_size( 'homenews-280x140', 280, 140, TRUE );
	add_image_size( 'academics-220x130', 220, 130, TRUE );
*/

}
