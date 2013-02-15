<?php


// Please do not remove this line of code. Sky will fall.
require_once(TEMPLATEPATH . '/framework/init.php');

//Thumbnail Loader
//require_once(TEMPLATEPATH . '/framework/theme-specific/thumbnails.php');



function simple_cart_total_itmes() {
    $total = 0;
    if (is_array($_SESSION['simpleCart'])) {

	    foreach ( $_SESSION['simpleCart'] as $item ) {
	        $total ++;
	    }
    	return $total;
	}
}

