<?php
// Registers a widget
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name' => 'About Us Page Blurb',
        'before_widget' => '<!-- page title container --><div id="pageTitleHolder" class="container %2$s %1$s"><div class="row"><div class="twelve columns">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="pageTitle source">',
        'after_title' => '</h2></div></div></div><!-- end #ctaContainer --><div id="pageContentHolder" class="hide-on-phones container"><div class="row">'
    ));
    register_sidebar(array(
        'name' => 'Services Page Blurb',
        'before_widget' => '<!-- page title container --><div id="pageTitleHolder" class="container %2$s %1$s"><div class="row"><div class="twelve columns">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="pageTitle source">',
        'after_title' => '</h2></div></div></div><!-- end #ctaContainer --><div id="pageContentHolder" class="hide-on-phones container"><div class="row">'
    ));
    register_sidebar(array(
        'name' => 'Portfolio Page Blurb',
        'before_widget' => '<!-- page title container --><div id="pageTitleHolder" class="container %2$s %1$s"><div class="row"><div class="twelve columns">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="pageTitle source">',
        'after_title' => '</h2></div></div></div><!-- end #ctaContainer --><div id="pageContentHolder" class="hide-on-phones container"><div class="row">'
    ));
    register_sidebar(array(
        'name' => 'Blog Page Blurb',
        'before_widget' => '<!-- page title container --><div id="pageTitleHolder" class="container %2$s %1$s"><div class="row"><div class="twelve columns">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="pageTitle source">',
        'after_title' => '</h2></div></div></div><!-- end #ctaContainer --><div id="pageContentHolder" class="hide-on-phones container"><div class="row">'
    ));
    register_sidebar(array(
        'name' => 'Resource Centre Page Blurb',
        'before_widget' => '<!-- page title container --><div id="pageTitleHolder" class="container %2$s %1$s"><div class="row"><div class="twelve columns">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="pageTitle source">',
        'after_title' => '</h2></div></div></div><!-- end #ctaContainer --><div id="pageContentHolder" class="hide-on-phones container"><div class="row">'
    ));
    register_sidebar(array(
        'name' => 'Contact Page Blurb',
        'before_widget' => '<!-- page title container --><div id="pageTitleHolder" class="container %2$s %1$s"><div class="row"><div class="twelve columns">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="pageTitle source">',
        'after_title' => '</h2></div></div></div><!-- end #ctaContainer --><div id="pageContentHolder" class="hide-on-phones container"><div class="row">'
    ));
    register_sidebar(array(
        'name' => 'Footer Column One',
        'before_widget' => '<div class="footerWidget %2$s %1$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4 class="source">',
        'after_title' => '</h4><div class="footerColumnContent">'
    ));
    register_sidebar(array(
        'name' => 'Footer Column Two',
        'before_widget' => '<div class="footerWidget %2$s %1$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4 class="source">',
        'after_title' => '</h4><div class="footerColumnContent">'
    ));
    register_sidebar(array(
        'name' => 'Footer Column Three',
        'before_widget' => '<div class="footerWidget %2$s %1$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4 class="source">',
        'after_title' => '</h4><div class="footerColumnContent">'
    ));
    register_sidebar(array(
        'name' => 'Footer Column Four',
        'before_widget' => '<div class="footerWidget %2$s %1$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4 class="source">',
        'after_title' => '</h4><div class="footerColumnContent">'
    ));
    register_sidebar(array(
        'name' => 'Blog Sidebar',
        'before_widget' => '<div class="widget %2$s %1$s">',
        'after_widget' => '</div><div class="clearMe"></div>',
        'before_title' => '<h4 class="displayNone">',
        'after_title' => '</h4>'
    ));
}
