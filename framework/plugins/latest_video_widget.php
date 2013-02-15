<?php
/*
Plugin Name: Latest Video Widget
Plugin URI: http://mikecaputo.com/
Author: Michael Caputo
Version: 1
Author URI: http://mikecaputo.com/
*/


class LatestVideoWidget extends WP_Widget {
  function LatestVideoWidget() {
    $widget_ops = array(
    	'classname' => 'latest_video_widget',
    	'description' => 'Displays a list of posts based on how many comments they have'
    );
    $this->WP_Widget(
    	'latest_video_widget',
    	'Displays the latest video',
    	$widget_ops
    );
  }

  function form($instance) {
    $instance = wp_parse_args(
    	(array) $instance, array(
    		'title' => '',
    		'number' => ''
    	)
    );
    $title = $instance['title'];
    $number = $instance['number'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['number'] = $new_instance['number'];
    return $instance;
  }

  function widget($args, $instance) {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $number_to_display = empty($instance['number']) ? '1' : apply_filters('num_posts', $instance['number']);

    if (!empty($title))
      echo $before_title . $title . $after_title;

      		$pub_posts_args = array(
      			'posts_per_page'	=> 1,
      			'post_type'			=> array ('videos')
      		);

			query_posts($pub_posts_args);
			if (have_posts()) :
				echo "<ul>";
				while (have_posts()) : the_post();

					$permalink = permalink_figureout();

					echo "<li>";
					echo "<a href=\"#\" class=\"buttonForModal\" data-animation=\"fadeAndPop\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" data-reveal-id=\"pdf-modal-".get_the_ID()."\" href=\"#\"><img src=\"http://img.youtube.com/vi/".$permalink."/hqdefault.jpg\" /></a>";

					echo "<a href=\"#\" class=\"buttonForModal\" data-animation=\"fadeAndPop\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" data-reveal-id=\"pdf-modal-".get_the_ID()."\" href=\"#\">".get_the_title()."</a>";

					echo "</li>";
				endwhile;
				echo "</ul>";
			endif;
			wp_reset_query();

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("LatestVideoWidget");') );


function LatestVideo_functioncall() {
		    $pub_posts_args = array(
      			'posts_per_page'	=> 1,
      			'post_type'			=> array ('videos')
      		);

			query_posts($pub_posts_args);
			if (have_posts()) :
				while (have_posts()) : the_post();

					$permalink = permalink_figureout();

					echo "<div class=\"reveal-modal xlarge\" id=\"pdf-modal-".get_the_ID()."\">";
					echo "<div frameborder=\"0\" class=\"flex-video widescreen\"><iframe src=\"http://www.youtube.com/embed/".$permalink."\" allowfullscreen></iframe></div>";
					echo "<a class=\"close-reveal-modal\">&#215;</a>";
					echo "</div>";

				endwhile;
			endif;
			wp_reset_query();
}
add_action('wp_footer', 'LatestVideo_functioncall', 1000);

