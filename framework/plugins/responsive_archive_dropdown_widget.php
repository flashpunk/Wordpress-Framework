<?php
/*
Plugin Name: Responsive Archive Dropdown Widget for Zurb Foundation
Plugin URI: http://mikecaputo.com/
Description: Displays a Responsive Archive Dropdown Widget
Author: Michael Caputo
Version: 1
Author URI: http://mikecaputo.com/
*/


class responsiveArchiveDropdown extends WP_Widget {
  function responsiveArchiveDropdown() {
    $widget_ops = array(
    	'classname' => 'responsive_archive_dropdown_widget',
    	'description' => 'Responsive Archive Dropdown Widget for Zurb Foundation'
    );
    $this->WP_Widget(
    	'responsive_archive_dropdown_widget',
    	'Responsive Archive Dropdown Widget for Zurb Foundation',
    	$widget_ops
    );
  }

  function form($instance) {
    $instance = wp_parse_args(
    	(array) $instance, array(
    		'title' => ''
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
    return $instance;
  }

  function widget($args, $instance) {
    extract($args, EXTR_SKIP);

    echo $before_widget;

	    $title = empty($instance['title']) ? 'Archives' : apply_filters('widget_title', $instance['title']);

    if (!empty($title)) {
      echo $before_title . $title . $after_title;
    ?>
				<form class="custom">
					<select style="display:none;" id="customDropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option SELECTED><?php echo $title; ?></option>
						<?php wp_get_archives( 'type=monthly&format=option' ); ?>
					</select>
					<div class="custom dropdown expand">
						<a href="#" class="current">Archives</a>
						<a href="#" class="selector"></a>
						<ul>
							<?php
								$archive_args = array(
									'type'            => 'monthly',
									'limit'           => 12,
									'format'          => 'html',
									'show_post_count' => false,
								);
								wp_get_archives($archive_args);
							?>
						</ul>
					</div>
				</form>
 <?php }
    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("responsiveArchiveDropdown");') );
