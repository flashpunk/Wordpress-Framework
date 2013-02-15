<?php
/*
Plugin Name: Recent Podcast Widget
Description: Recent Podcast Widget
*/


/**
 * Recent Podcast Widget Class
 */
class podcast_recent_posts extends WP_Widget {


    /** constructor */
    function podcast_recent_posts() {
        parent::WP_Widget(false, $name = 'Recent Podcast widget');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
		global $posttypes;
	        $title 			= apply_filters('widget_title', $instance['title']);
	        $number 		= apply_filters('widget_title', $instance['number']);
	        $posttype 		= 'podcasts';
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
							<?php
								global $post;
								$tmp_post = $post;

								// get the category IDs and place them in an array

								$args = 'numberposts=' . $number . '&post_type=podcasts';
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) : setup_postdata($post);
								$permalink = permalink_figureout();
							?>
									<li>
										<a href="<?php echo $permalink; ?>"><?php the_title(); ?></a><br/>
									</li>
								<?php endforeach; ?>
								<?php $post = $tmp_post; ?>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		global $posttypes;
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {

        $title = esc_attr($instance['title']);
        $number = esc_attr($instance['number']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
        <?php
    }


} // class utopian_recent_posts
// register Recent Podcast widget
add_action('widgets_init', create_function('', 'return register_widget("podcast_recent_posts");'));

?>