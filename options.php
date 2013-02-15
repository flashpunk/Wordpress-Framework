<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'options_framework_theme'),
		'two' => __('Two', 'options_framework_theme'),
		'three' => __('Three', 'options_framework_theme'),
		'four' => __('Four', 'options_framework_theme'),
		'five' => __('Five', 'options_framework_theme')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_framework_theme'),
		'two' => __('Pancake', 'options_framework_theme'),
		'three' => __('Omelette', 'options_framework_theme'),
		'four' => __('Crepe', 'options_framework_theme'),
		'five' => __('Waffle', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

//	//
//	// Home Page Slider Slides
//	//
//		$options[] = array('name' => __('Home Page Slider Slides', 'options_framework_theme'),'type' => 'heading');
//	// Home Mid Page Right
//		$options[] = array(
//			'name' => __('URL to Slide 1', 'options_framework_theme'),
//		    'id' => 'slider_slide_1',
//		    'desc' => __('Home page slider fields to add/remove slides to the rotating slider. Dimentions for images should be 1600px x 600px (They must ALL the same size). Use the Media uploader to upload the file, and copy/paste the URL to the file into the fields below.', 'options_framework_theme'),
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 2', 'options_framework_theme'),
//		    'id' => 'slider_slide_2',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 3', 'options_framework_theme'),
//		    'id' => 'slider_slide_3',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 4', 'options_framework_theme'),
//		    'id' => 'slider_slide_4',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 5', 'options_framework_theme'),
//		    'id' => 'slider_slide_5',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 6', 'options_framework_theme'),
//		    'id' => 'slider_slide_6',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 7', 'options_framework_theme'),
//		    'id' => 'slider_slide_7',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 8', 'options_framework_theme'),
//		    'id' => 'slider_slide_8',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 9', 'options_framework_theme'),
//		    'id' => 'slider_slide_9',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 10', 'options_framework_theme'),
//		    'id' => 'slider_slide_10',
//			'std' => '',
//			'type' => 'upload'
//		);
//		$options[] = array(
//			'name' => __('URL to Slide 11', 'options_framework_theme'),
//		    'id' => 'slider_slide_11',
//			'std' => '',
//			'type' => 'upload'
//		);




//	$options[] = array(
//		'name' => __('Textarea', 'options_framework_theme'),
//		'desc' => __('Textarea description.', 'options_framework_theme'),
//		'id' => 'example_textarea',
//		'std' => 'Default Text',
//		'type' => 'textarea');
//
//	$options[] = array(
//		'name' => __('Input Select Small', 'options_framework_theme'),
//		'desc' => __('Small Select Box.', 'options_framework_theme'),
//		'id' => 'example_select',
//		'std' => 'three',
//		'type' => 'select',
//		'class' => 'mini', //mini, tiny, small
//		'options' => $test_array);
//
//	$options[] = array(
//		'name' => __('Input Select Wide', 'options_framework_theme'),
//		'desc' => __('A wider select box.', 'options_framework_theme'),
//		'id' => 'example_select_wide',
//		'std' => 'two',
//		'type' => 'select',
//		'options' => $test_array);
//
//	$options[] = array(
//		'name' => __('Select a Category', 'options_framework_theme'),
//		'desc' => __('Passed an array of categories with cat_ID and cat_name', 'options_framework_theme'),
//		'id' => 'example_select_categories',
//		'type' => 'select',
//		'options' => $options_categories);
//
//	$options[] = array(
//		'name' => __('Select a Tag', 'options_check'),
//		'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
//		'id' => 'example_select_tags',
//		'type' => 'select',
//		'options' => $options_tags);
//
//	$options[] = array(
//		'name' => __('Select a Page', 'options_framework_theme'),
//		'desc' => __('Passed an pages with ID and post_title', 'options_framework_theme'),
//		'id' => 'example_select_pages',
//		'type' => 'select',
//		'options' => $options_pages);
//
//	$options[] = array(
//		'name' => __('Input Radio (one)', 'options_framework_theme'),
//		'desc' => __('Radio select with default options "one".', 'options_framework_theme'),
//		'id' => 'example_radio',
//		'std' => 'one',
//		'type' => 'radio',
//		'options' => $test_array);
//
//	$options[] = array(
//		'name' => __('Example Info', 'options_framework_theme'),
//		'desc' => __('This is just some example information you can put in the panel.', 'options_framework_theme'),
//		'type' => 'info');
//
//	$options[] = array(
//		'name' => __('Input Checkbox', 'options_framework_theme'),
//		'desc' => __('Example checkbox, defaults to true.', 'options_framework_theme'),
//		'id' => 'example_checkbox',
//		'std' => '1',
//		'type' => 'checkbox');
//
//	$options[] = array(
//		'name' => __('Advanced Settings', 'options_framework_theme'),
//		'type' => 'heading');
//
//	$options[] = array(
//		'name' => __('Check to Show a Hidden Text Input', 'options_framework_theme'),
//		'desc' => __('Click here and see what happens.', 'options_framework_theme'),
//		'id' => 'example_showhidden',
//		'type' => 'checkbox');
//
//	$options[] = array(
//		'name' => __('Hidden Text Input', 'options_framework_theme'),
//		'desc' => __('This option is hidden unless activated by a checkbox click.', 'options_framework_theme'),
//		'id' => 'example_text_hidden',
//		'std' => 'Hello',
//		'class' => 'hidden',
//		'type' => 'text');
//
//	$options[] = array(
//		'name' => __('Uploader Test', 'options_framework_theme'),
//		'desc' => __('This creates a full size uploader that previews the image.', 'options_framework_theme'),
//		'id' => 'example_uploader',
//		'type' => 'upload');
//
//	$options[] = array(
//		'name' => "Example Image Selector",
//		'desc' => "Images for layout.",
//		'id' => "example_images",
//		'std' => "2c-l-fixed",
//		'type' => "images",
//		'options' => array(
//			'1col-fixed' => $imagepath . '1col.png',
//			'2c-l-fixed' => $imagepath . '2cl.png',
//			'2c-r-fixed' => $imagepath . '2cr.png')
//	);
//
//	$options[] = array(
//		'name' =>  __('Example Background', 'options_framework_theme'),
//		'desc' => __('Change the background CSS.', 'options_framework_theme'),
//		'id' => 'example_background',
//		'std' => $background_defaults,
//		'type' => 'background' );
//
//	$options[] = array(
//		'name' => __('Multicheck', 'options_framework_theme'),
//		'desc' => __('Multicheck description.', 'options_framework_theme'),
//		'id' => 'example_multicheck',
//		'std' => $multicheck_defaults, // These items get checked by default
//		'type' => 'multicheck',
//		'options' => $multicheck_array);
//
//	$options[] = array(
//		'name' => __('Colorpicker', 'options_framework_theme'),
//		'desc' => __('No color selected by default.', 'options_framework_theme'),
//		'id' => 'example_colorpicker',
//		'std' => '',
//		'type' => 'color' );
//
//	$options[] = array( 'name' => __('Typography', 'options_framework_theme'),
//		'desc' => __('Example typography.', 'options_framework_theme'),
//		'id' => "example_typography",
//		'std' => $typography_defaults,
//		'type' => 'typography' );
//
//	$options[] = array(
//		'name' => __('Custom Typography', 'options_framework_theme'),
//		'desc' => __('Custom typography options.', 'options_framework_theme'),
//		'id' => "custom_typography",
//		'std' => $typography_defaults,
//		'type' => 'typography',
//		'options' => $typography_options );
//
//	$options[] = array(
//		'name' => __('Text textarea', 'options_framework_theme'),
//		'type' => 'heading' );
//
//	/**
//	 * For $settings options see:
//	 * http://codex.wordpress.org/Function_Reference/wp_textarea
//	 *
//	 * 'media_buttons' are not supported as there is no post to attach items to
//	 * 'textarea_name' is set by the 'id' you choose
//	 */
//
//	$wp_textarea_settings = array(
//		'wpautop' => true, // Default
//		'textarea_rows' => 5,
//		'tinymce' => array( 'plugins' => 'wordpress' )
//	);
//
//	$options[] = array(
//		'name' => __('Default Text textarea', 'options_framework_theme'),
//		'desc' => sprintf( __( 'You can also pass settings to the textarea.  Read more about wp_textarea in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_framework_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_textarea' ),
//		'id' => 'example_textarea',
//		'type' => 'textarea',
//		'settings' => $wp_textarea_settings );

	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}

});
</script>

<?php
}