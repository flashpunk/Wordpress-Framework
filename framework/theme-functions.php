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
