<?php

add_action("admin_init", "selection_meta_box");

	function selection_meta_box(){
		//add_meta_box("featured-post", "Set Featured", "featured_post", "post", "side", "low"); Uncomment this line and comment the below foreach loop if you want the Set Featured option only for posts
		$post_types_array = get_post_types();
		foreach ( $post_types_array as $post_type ) {
			add_meta_box("featured-post", "Add To Slider", "featured_post", $post_type, "side", "low");
		}
	}

	function featured_post(){
		global $post;
		$meta_data = get_post_custom($post->ID);
		$featured_post = $meta_data["_featured_post"][0];
		$selected = ($meta_data["_featured_post"][0] == "yes") ? 'checked' : '';
		echo "<p>";
		echo "<input $selected type='checkbox' name='featured_post' value='yes' />";
		echo "<label> Check to add this post to the slider.</label>";
		echo "</p>";
	}

	add_action('save_post', 'save_post_details');

	function save_post_details(){
		global $post;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    	return;
		$featured_post = trim($_POST["featured_post"]);
		update_post_meta($post->ID, "_featured_post", $featured_post);
	}

	function show_featured_posts($numbers) {
		global $post;

		$post_args = array(
			'numberposts'		=> $numbers,
			'post_status'		=> 'publish',
			'meta_value'		=> yes,
			'meta_key'			=> '_featured_post',
			'post_type'			=> array( 'post', 'newsroom' )
		);



		//get $numbers of featured posts
		$featured_posts_array = get_posts( $post_args );

		$output .= '<div class="container hide-for-small" id="orbit">';
		$output .= '<div class="row">';
		$output .= '<div class="twelve columns">';
		$output .= '<div id="featured">';
		foreach ($featured_posts_array as $post) : setup_postdata($post);

			$post_id = get_the_ID();
			$thumbnail = get_the_post_thumbnail(get_the_ID(), 'slider-thumb', array( "class" => "post_thumbnail" ));

			// testing to see if options panel is available, otherwise defaulting to 40chars
			if( function_exists('of_get_option')) :
				$number_of_slider_excerpt_chars = of_get_option('number_of_slider_excerpt_chars', '40');
			else :
				$number_of_slider_excerpt_chars = '40';
			endif;
			// getting dynamic excerpt function, using char amount from optins panel
			$excerpt = the_content_dynamic($number_of_slider_excerpt_chars);

			$output .= "<div>\n";
			$output .= "<div class=\"row\">\n";
			$output .= "<div class=\"nine columns\">\n";

			// displaying the thumbnail, if none exists, will show grey box with OUSA text.
			if($thumbnail == '') :
				$output .= "<a href=\"".get_permalink()."#content\"><img src=\"http://placehold.it/800x400&text=OUSA\" /></a>\n";
			else :
				$output .= "<a href=\"".get_permalink()."#content\">".$thumbnail."</a>\n";
			endif;
			$output .= "</div><!-- close .nine.columns -->\n";
			$output .= "<div class=\"three columns\">\n";
			$output .= "<h2><a href=\"".get_permalink()."\">".get_the_title()."</a></h2>\n";
			$output .= $excerpt;
			$output .= "</div><!-- close .three.columns -->\n";
			$output .= "</div><!-- close .row -->\n";
			$output .= "</div><!-- close DIV -->\n";

		endforeach;
		$output .= $caption;
		$output .= "</div><!-- end #featured -->\n";
		$output .= "</div><!-- end .twelve.columns -->\n";
		$output .= "</div><!-- end .row -->\n";
		$output .= "</div><!-- end #orbit -->\n";
		echo $output;
		//reset WP query
		wp_reset_query();
	}

	function include_slider_scripts() {
		wp_deregister_script( 'jquery' );
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), true, '');
		wp_enqueue_script( 'jquery' );
	}

	add_action('wp_enqueue_scripts', 'include_slider_scripts');


//	add_action('wp_print_styles', 'add_slider_stylesheets');
//	function add_orbit_stylesheets() {
//		 wp_register_style('orbit_theme_style', get_bloginfo('template_directory').'/themes/default/default.css');
//         wp_enqueue_style( 'orbit_theme_style');
//    }


	function orbit_functioncall() {
		echo '<script>
		$(window).load(function() {
			$(\'#featured\').orbit({
				animation: \'horizontal-push\',
				animationSpeed: 800,				// how fast animtions are
				timer: true,						// true or false to have the timer
				advanceSpeed: 4000,					// if timer is enabled, time between transitions
				directionalNav: false,
				captions: false,
				bullets: true,
				bulletThumbs: false,
				fluid: \'16x6\'
			});
		});
		</script>
';
	}
	add_action('wp_footer', 'orbit_functioncall', 1000);

?>