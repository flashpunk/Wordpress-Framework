<?php
/*
Plugin Name: Responsive Category Dropdown Widget for Zurb Foundation
Plugin URI: http://mikecaputo.com/
Description: Displays a Responsive Category Dropdown Widget
Author: Michael Caputo
Version: 1
Author URI: http://mikecaputo.com/
*/


class responsiveCategoryDropdown extends WP_Widget {
  function responsiveCategoryDropdown() {
    $widget_ops = array(
    	'classname' => 'responsive_category_dropdown_widget',
    	'description' => 'Responsive Category Dropdown Widget for Zurb Foundation'
    );
    $this->WP_Widget(
    	'responsive_category_dropdown_widget',
    	'Responsive Category Dropdown Widget for Zurb Foundation',
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
    	$site_url = network_site_url( '/' );
	    $title = empty($instance['title']) ? 'Category Browse' : apply_filters('widget_title', $instance['title']);

    if (!empty($title)) {
      echo $before_title . $title . $after_title;
    ?>
				<form class="custom">
					<select style="display:none;" id="customDropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option SELECTED><?php echo $title; ?></option>
						 <?php
						 	$categories = get_categories();
							foreach ($categories as $category) {
								$option = '<option value="' . $site_url . '/category/'.$category->category_nicename.'">';
								$option .= $category->cat_name;
								$option .= '</option>';
								echo $option;
							}
						 ?>
					</select>
					<div class="custom dropdown expand">
						<a href="#" class="current"><?php echo $title; ?></a>
						<a href="#" class="selector"></a>
						<ul>
							<?php wp_list_categories('depth=1&current_category=1&orderby=name&title_li='); ?>
						</ul>
					</div>
				</form>
 <?php }
    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("responsiveCategoryDropdown");') );
