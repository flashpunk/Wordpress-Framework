<?php
/*-------------------------------------------------------------------------*/
/*  Wordpress Modifications
/*-------------------------------------------------------------------------*/
remove_action ('wp_head', 'rsd_link');
remove_action ('wp_head', 'wlwmanifest_link');
remove_action ('wp_head', 'wp_generator');
remove_action ('wp_head', 'feed_links_extra');
remove_action ('wp_head', 'feed_links');
remove_action ('wp_head', 'index_rel_link');
remove_action ('wp_head', 'parent_post_rel_link');
remove_action ('wp_head', 'start_post_rel_link');
remove_action ('wp_head', 'adjacent_posts_rel_link');
add_filter('widget_text', 'do_shortcode');
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support('nav-menus');
add_theme_support( 'post-thumbnails' , array( 'post' ));


/*-------------------------------------------------------------------------*/
/*   Remove rel="category" from blog links for HTML5 validation
/*-------------------------------------------------------------------------*/
add_filter( 'the_category', 'add_nofollow_cat' );
function add_nofollow_cat( $text ) {
$text = str_replace('rel="category tag"', "", $text); return $text;
}


/*-------------------------------------------------------------------------*/
/*    Hide user profile fields
/*-------------------------------------------------------------------------*/
add_filter('user_contactmethods','hide_profile_fields',10,1);

function hide_profile_fields( $contactmethods ) {
unset($contactmethods['aim']);
unset($contactmethods['jabber']);
unset($contactmethods['yim']);
return $contactmethods;
}


/*-----------------------------------------------------------------------------------*/
/*  add wmode=opaque to WordPress video embed shortcode, fixes menu behind video issue. @since version 1.0.4
/*  original codes from http://mehigh.biz/wordpress/adding-wmode-transparent-to-wordpress-3-media-embeds.html
/*-----------------------------------------------------------------------------------*/
function THEME_add_video_wmode_transparent($html, $url, $attr) {

if ( strpos( $html, "<embed src=" ) !== false )
   { return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html); }
elseif ( strpos ( $html, 'feature=oembed' ) !== false )
   { return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html ); }
else
   { return $html; }
}
add_filter( 'embed_oembed_html', 'THEME_add_video_wmode_transparent', 10, 3);


// Add body class if there's a sidebar
function wpfme_has_sidebar($classes) {
    if (is_active_sidebar('sidebar')) {
        // add 'class-name' to the $classes array
        $classes[] = 'has_sidebar';
    }
    // return the $classes array
    return $classes;
}

// Remove the admin bar from the front end
// add_filter( 'show_admin_bar', '__return_false' );

// Put post thumbnails into rss feed
function wpfme_feed_post_thumbnail($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '' . $content;
    }
    return $content;
}



// Minify CSS */
// http://kitmacallister.com/2011/03/10/minify-css-with-php/
function minifyCSS($string){

    /* Strips Comments */
    $string = preg_replace('!/\*.*?\*/!s','', $string);
    $string = preg_replace('/\n\s*\n/',"\n", $string);

    /* Minifies */
    $string = preg_replace('/[\n\r \t]/',' ', $string);
    $string = preg_replace('/ +/',' ', $string);
    $string = preg_replace('/ ?([,:;{}]) ?/','$1',$string);
    return $string;
}

/***** Numbered Page Navigation (Pagination) Code.
      Tested up to WordPress version 3.1.2 *****/

/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}

/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $pagenavi_options = array();
    $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%:');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = 'Next &raquo;';
    $pagenavi_options['prev_text'] = '&laquo; Prev';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;

    //If NOT a single Post is being displayed
    /*http://codex.wordpress.org/Function_Reference/is_single)*/
    if (!is_single()) {
        $request = $wp_query->request;
        //intval — Get the integer value of a variable
        /*http://php.net/manual/en/function.intval.php*/
        $posts_per_page = intval(get_query_var('posts_per_page'));
        //Retrieve variable in the WP_Query class.
        /*http://codex.wordpress.org/Function_Reference/get_query_var*/
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;

        //empty — Determine whether a variable is empty
        /*http://php.net/manual/en/function.empty.php*/
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }

        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        //ceil — Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;

        if($start_page <= 0) {
            $start_page = 1;
        }

        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }

        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);

        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            /*http://php.net/manual/en/function.str-replace.php */
            /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
            echo $before.'<div class="pagenavi">'."\n";

            if(!empty($pages_text)) {
                echo '<span class="pages">'.$pages_text.'</span>';
            }
            //Displays a link to the previous post which exists in chronological order from the current post.
            /*http://codex.wordpress.org/Function_Reference/previous_post_link*/
            previous_posts_link($pagenavi_options['prev_text']);

            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                //esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
                /*http://codex.wordpress.org/Data_Validation*/
                //get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">1</a>';
                if(!empty($pagenavi_options['dotleft_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotleft_text'].'</span>';
                }
            }

            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }

            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="current">'.$current_page_text.'</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }

            if ($end_page < $max_page) {
                if(!empty($pagenavi_options['dotright_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotright_text'].'</span>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$max_page.'</a>';
            }
            next_posts_link($pagenavi_options['next_text'], $max_page);

            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            echo '</div>'.$after."\n";
        }
    }
}


/* Removing Paragraph Tags From Around Images http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/ */
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');


// Multiple Excerpts - http://stackoverflow.com/questions/4082662/multiple-excerpt-lengths-in-wordpress
function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    echo '<p>'.$excerpt.'</p>';
}

function content($limit) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    } else {
        $content = implode(" ",$content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    echo '<p>'.$excerpt.'</p>';
}


// add category nicenames in body and post class
function category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category)
        $classes[] = $category->category_nicename;
        return $classes;
}
add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');



// posts per page based on CPT - http://mondaybynoon.com/2011/05/16/wordpress-posts-per-page-per-custom-post-type/
function iti_custom_posts_per_page($query) {
    switch ( $query->query_vars['post_type'] ) {
        case 'post':  // Post Type named 'post'
            $query->query_vars['posts_per_page'] = 7;
            break;
        case 'portfolio':  // Post Type named 'portfolio'
            $query->query_vars['posts_per_page'] = 9;
            break;
        case 'resources':  // Post Type named 'resources'
            $query->query_vars['posts_per_page'] = 6;
            break;
        default:
            break;
    }
    return $query;
}
if( !is_admin() )
{ add_filter( 'pre_get_posts', 'iti_custom_posts_per_page' ); }



// Get the Category Slug by ID
// http://wordpress.org/support/topic/i-need-to-get-the-category-slug-from-the-category-id?replies=8
function get_cat_slug($cat_id) {
    $cat_id = (int) $cat_id;
    $category = &get_category($cat_id);
    return $category->slug;
}


// Comment Template
function mytheme_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class('twelve columns'); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="two columns commentInfo">
            <?php echo get_avatar( $id_or_email, $size = '200' ); ?>
            <p class="commentMeta"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date('m.d.y'),  get_comment_time()) ?></a>
            <?php edit_comment_link(__('(Edit)'),'  ','') ?></p>
        </div>
        <div class="ten columns" id="comment-<?php comment_ID(); ?>">
            <?php if ($comment->comment_approved == '0') : ?>
                <em><?php _e('Your comment is awaiting moderation.') ?></em>
                <br />
            <?php endif; ?>
            <h5 class="source"><?php printf(__('%s'), get_comment_author_link()) ?></h5>
            <hr />
            <?php comment_text() ?>
        </div>

<?php
}

// Dropdown Menus http://wordpress.org/extend/plugins/dropdown-menus/
add_filter( 'dropdown_blank_item_text', 10, 2 );
function my_dropdown_blank_text( $title, $args ) {
    return __( '- Browse -' );
}


// Adding PDF support to Media Manager
// http://www.wprecipes.com/how-to-add-pdf-support-to-the-wordpress-media-manager
function modify_post_mime_types( $post_mime_types ) {
    // select the mime type, here: 'application/pdf'
    // then we define an array with the label values
    $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
    // then we return the $post_mime_types variable
    return $post_mime_types;
}
// Add Filter Hook
add_filter( 'post_mime_types', 'modify_post_mime_types' );



/*
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */
if ( !function_exists( 'of_get_option' ) ) {
    function of_get_option($name, $default = false) {
        $optionsframework_settings = get_option('optionsframework');
        // Gets the unique option id
        $option_name = $optionsframework_settings['id'];
        if ( get_option($option_name) ) {
            $options = get_option($option_name);
        }
        if ( isset($options[$name]) ) {
            return $options[$name];
        } else {
            return $default;
        }
    }
}



// Hiding the theme editor from the back end
// http://www.wprecipes.com/how-to-hide-theme-editor-from-wordpress-dashboard
function wpr_remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}

global $remove_submenu_page, $current_user;
get_currentuserinfo();
if($current_user->user_login == 'admin') { //Specify admin name here
    add_action('admin_menu', 'wpr_remove_editor_menu', 1);
}


function excerpt_ellipse($text) {
   return str_replace('[...]', ' <a href="'.get_permalink().'">Read more...</a>', $text); }
add_filter('the_excerpt', 'excerpt_ellipse');


// hiding email addresses from spambots - http://www.wprecipes.com/how-to-automatically-hide-email-adresses-from-spambots-on-your-wordpress-blog
function security_remove_emails($content) {
    $pattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/i';
    $fix = preg_replace_callback($pattern,"security_remove_emails_logic", $content);

    return $fix;
}
function security_remove_emails_logic($result) {
    return antispambot($result[1]);
}
add_filter( 'the_content', 'security_remove_emails', 20 );
add_filter( 'widget_text', 'security_remove_emails', 20 );


// adding opengraph - http://www.wprecipes.com/how-to-use-open-graph-to-make-your-content-easily-recognizable-by-social-networks
function site_opengraph_for_posts() {
    if ( is_singular() ) {
        global $post;
        setup_postdata( $post );
        $og_type = '<meta property="og:type" content="article" />' . "\n";
        $og_title = '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
        $og_url = '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
        $og_description = '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
        if ( has_post_thumbnail() ) {
            $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb-fb' );
            $og_image = '<meta property="og:image" content="' . $imgsrc[0] . '" />' . "\n";
        }
        echo $og_type . $og_title . $og_url . $og_description . $og_image;
    }
}
add_action( 'wp_head', 'site_opengraph_for_posts' );



// remove links from images http://wordpress.stackexchange.com/questions/33724/remove-links-from-images-using-functions-php
add_filter( 'the_content', 'attachment_image_link_remove_filter' );
function attachment_image_link_remove_filter( $content ) {
    $content =
        preg_replace(
            array('{<a(.*?)(wp-att|wp-content\/uploads)[^>]*><img}',
                '{ wp-image-[0-9]*" /></a>}'),
            array('<img','" />'),
            $content
        );
    return $content;
}


//Add Twitter Cards Meta Info
function add_twitter_card_info() {
    global $post;
    if ( !is_singular())
        return;
    echo '<meta name="twitter:card" content="summary"/>';
    echo '<meta name="twitter:url" content="' . get_permalink() . '"/>';
    echo '<meta name="twitter:title" content="' . get_the_title() . '"/>';
    echo '<meta name="twitter:description" content="' . get_the_excerpt() . '"/>';
    echo '<meta name="twitter:site" content="theblogstudio"/>'; //optional: username of website
     echo '<meta name="twitter:creator" content="theblogstudio"/>'; //optional: username of content creator
    if(!has_post_thumbnail( $post->ID )) { //use a default image if no featured image set
        $default_image="http://www.theblogstudio.com/wp/wp-content/themes/v10/images/logo.png"; //replace this with a default image
        echo '<meta name="twitter:image" content="' . $default_image . '"/>';
    }
    else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        echo '<meta name="twitter:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    }
    echo "\n";
}
add_action( 'wp_head', 'add_twitter_card_info');


function add_twitter_contactmethod( $contactmethods ) {
  // Add Twitter
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = 'Twitter';

  return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_twitter_contactmethod', 10, 1 );



// get first tax term
// http://wordpress.stackexchange.com/questions/39175/in-a-loop-of-custom-post-type-display-first-custom-taxonomy-term
function get_single_term($post_id, $taxonomy) {
    $terms = wp_get_object_terms($post_id, $taxonomy);
    if(!is_wp_error($terms)) {
        return $terms[0]->name;   
    }
}

//example
echo get_single_term(5, 'category');
