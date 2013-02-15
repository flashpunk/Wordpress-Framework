<?php
/*
Plugin Name: Latest Publication Widget
Plugin URI: http://mikecaputo.com/
Author: Michael Caputo
Version: 1
Author URI: http://mikecaputo.com/
*/


class LatestPublicationWidget extends WP_Widget {
  function LatestPublicationWidget() {
    $widget_ops = array(
    	'classname' => 'latest_publication_widget',
    	'description' => 'Displays a list of posts based on how many comments they have'
    );
    $this->WP_Widget(
    	'latest_publication_widget',
    	'Displays the latest publication',
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
      			'post_type'			=> array ('research-centre', 'resource-library')
      		);

			query_posts($pub_posts_args);
			if (have_posts()) :
				echo "<div class='row'>";
				while (have_posts()) : the_post();

					$permalink = permalink_figureout(); ?>
						<div class="twelve columns sideArticle" id="post-<?php the_ID(); ?>">
							<div class="holder">
								<div class="imageHolder">
									<?php
										if (has_post_thumbnail( $post->ID ) ):
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'article-thumb' ); ?>
											<img class="d1" src="<?php echo $image[0]; ?>" width="300" height="300" style="width:100%;min-height:210px;" />
									<?php endif; ?>
									<div class="contenthover">
										<h3><a data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal" data-reveal-id="pdf-modal-<?php the_ID(); ?>" href="#" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
										<?php
											// testing to see if options panel is available, otherwise defaulting to 40chars
											$number_of_article_excerpt_chars = of_get_option('resource_excerpt_chars', '40');
											// getting dynamic excerpt function, using char amount from optins panel
											$excerpt = the_excerpt_dynamic($number_of_article_excerpt_chars);
											echo $excerpt;
										?>
									</div>
								</div>
								<?php $permalink = permalink_figureout(); ?>
								<a class="tiny secondary button buttonForModal" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal" data-reveal-id="pdf-modal-<?php the_ID(); ?>" href="#">View</a>
								<a class="tiny secondary button right" href="<?php echo $permalink[img_url]; ?>">Download</a>
							</div>
						</div>

					<?

//					echo "<li>";
//					if(has_post_thumbnail( $post->ID )) :
//						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slider-thumb' );
//						echo "<a href=\"#\" class=\"buttonForModal\" data-animation=\"fadeAndPop\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" data-reveal-id=\"pdf-modal-".get_the_ID()."\" href=\"#\"><img src=\"".$image[0]."\" /></a>";
//					endif;
//
//					$permalink = permalink_figureout();
//					echo "<h6><a href=\"#\" class=\"buttonForModal\" data-animation=\"fadeAndPop\" data-animationspeed=\"300\" data-closeonbackgroundclick=\"true\" data-dismissmodalclass=\"close-reveal-modal\" data-reveal-id=\"pdf-modal-".get_the_ID()."\" href=\"#\">".get_the_title()."</a></h6>";
//
//					echo '<a class="tiny secondary button buttonForModal" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal" data-reveal-id="pdf-modal-'.get_the_ID().'" href="#">View</a>';
//					echo '<a class="tiny secondary button right" href="'. $permalink[img_url].'">Download</a>';
//					echo '<div style="clear:both"></div>';
//
//					echo "</li>";
				endwhile;
				echo "</div>";
			endif;
			wp_reset_query();

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("LatestPublicationWidget");') );


function LatestPublication_functioncall() {
		    $pub_posts_args = array(
      			'posts_per_page'	=> 1,
      			'post_type'			=> array ('research-centre', 'resource-library')
      		);

			query_posts($pub_posts_args);
			if (have_posts()) :
				while (have_posts()) : the_post();

					$permalink = permalink_figureout();

					echo "<div class=\"reveal-modal xlarge\" id=\"pdf-modal-".get_the_ID()."\" style=\"height:50%;\">";
					echo "<iframe src=\"http://docs.google.com/gview?url=".$permalink[img_url]."&embedded=true\" style=\"width:100%; height:100%;\" frameborder=\"0\"></iframe>";
					echo "<a class=\"close-reveal-modal\">&#215;</a>";
					echo "</div>";

				endwhile;
			endif;
			wp_reset_query();
}
add_action('wp_footer', 'LatestPublication_functioncall', 1000);

