<?php

//
// shows
//
add_action( 'init', 'register_cpt_show' );
function register_cpt_show() {

    $labels = array( 
        'name' => _x( 'Shows', 'show' ),
        'singular_name' => _x( 'Show', 'show' ),
        'add_new' => _x( 'Add New', 'show' ),
        'add_new_item' => _x( 'Add New Show', 'show' ),
        'edit_item' => _x( 'Edit Show', 'show' ),
        'new_item' => _x( 'New Show', 'show' ),
        'view_item' => _x( 'View Show', 'show' ),
        'search_items' => _x( 'Search Shows', 'show' ),
        'not_found' => _x( 'No shows found', 'show' ),
        'not_found_in_trash' => _x( 'No shows found in Trash', 'show' ),
        'parent_item_colon' => _x( 'Parent Show:', 'show' ),
        'menu_name' => _x( 'Shows', 'show' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title' ),
        'taxonomies' => array( 'venue', 'city' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'show', $args );
}



add_action( 'init', 'register_taxonomy_venue' );

function register_taxonomy_venue() {

    $labels = array( 
        'name' => _x( 'Venue', 'venue' ),
        'singular_name' => _x( 'Venues', 'venue' ),
        'search_items' => _x( 'Search Venue', 'venue' ),
        'popular_items' => _x( 'Popular Venue', 'venue' ),
        'all_items' => _x( 'All Venue', 'venue' ),
        'parent_item' => _x( 'Parent Venues', 'venue' ),
        'parent_item_colon' => _x( 'Parent Venues:', 'venue' ),
        'edit_item' => _x( 'Edit Venues', 'venue' ),
        'update_item' => _x( 'Update Venues', 'venue' ),
        'add_new_item' => _x( 'Add New Venues', 'venue' ),
        'new_item_name' => _x( 'New Venues', 'venue' ),
        'separate_items_with_commas' => _x( 'Separate venue with commas', 'venue' ),
        'add_or_remove_items' => _x( 'Add or remove Venue', 'venue' ),
        'choose_from_most_used' => _x( 'Choose from most used Venue', 'venue' ),
        'menu_name' => _x( 'Venue', 'venue' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => false,

        'rewrite' => true,
        'sort' => true,
        'query_var' => true
    );

    register_taxonomy( 'venue', array('show'), $args );
}



add_action( 'init', 'register_taxonomy_cities' );

function register_taxonomy_cities() {

    $labels = array( 
        'name' => _x( 'City', 'cities' ),
        'singular_name' => _x( 'City', 'cities' ),
        'search_items' => _x( 'Search Cities', 'cities' ),
        'popular_items' => _x( 'Popular Cities', 'cities' ),
        'all_items' => _x( 'All Cities', 'cities' ),
        'parent_item' => _x( 'Parent City', 'cities' ),
        'parent_item_colon' => _x( 'Parent City:', 'cities' ),
        'edit_item' => _x( 'Edit City', 'cities' ),
        'update_item' => _x( 'Update City', 'cities' ),
        'add_new_item' => _x( 'Add New City', 'cities' ),
        'new_item_name' => _x( 'New City', 'cities' ),
        'separate_items_with_commas' => _x( 'Separate cities with commas', 'cities' ),
        'add_or_remove_items' => _x( 'Add or remove Cities', 'cities' ),
        'choose_from_most_used' => _x( 'Choose from most used Cities', 'cities' ),
        'menu_name' => _x( 'Cities', 'cities' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => false,

        'rewrite' => true,
        'sort' => true,
        'query_var' => true
    );

    register_taxonomy( 'cities', array('show'), $args );
}