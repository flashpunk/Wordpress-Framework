<?php

// Define File Directores
$theme_name = get_current_theme();
define('THEME_FUNCTIONS', TEMPLATEPATH . '/framework');
/*
define('THEME_ADMIN', TEMPLATEPATH . '/framework/admin');
define('THEME_EXTENDED', TEMPLATEPATH . '/framework/extended');
*/

// Load Theme Specific Functions
require_once(TEMPLATEPATH . '/framework/theme-specific/_theme_specific_init.php');

// Load Global Functions
require_once('theme-functions.php');

//
// Custom addon scripts
//
// require_once(TEMPLATEPATH . '/framework/plugins/social_widget.php');								// popular post custom widget
// require_once(TEMPLATEPATH . '/framework/plugins/sidebar_author_widget.php');						// Sidebar Current author widget
// require_once(TEMPLATEPATH . '/framework/plugins/auto_post_thumb.php');							// Automatic Post Thumbnail
//require_once(TEMPLATEPATH . '/framework/plugins/responsive_category_dropdown_widget.php');		// responsive category dropdown widget
//require_once(TEMPLATEPATH . '/framework/plugins/responsive_archive_dropdown_widget.php');		// responsive category dropdown widget
//require_once(TEMPLATEPATH . '/framework/plugins/recent_posts_widget.php');							// Recent Post Custom Widget
//require_once(TEMPLATEPATH . '/framework/plugins/latest_video_widget.php');							// latest video custom widget
//require_once(TEMPLATEPATH . '/framework/plugins/latest_publication_widget.php');					// latest publication custom widget
//require_once(TEMPLATEPATH . '/framework/plugins/slider.php');										// Slider
//require_once(TEMPLATEPATH . '/framework/plugins/login_screen.php');									// Login Screen


// Adding the options panel
//if ( !function_exists( 'optionsframework_init' ) ) {
//	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/options/' );
//	require_once (TEMPLATEPATH . '/framework/options/options-framework.php');
//}