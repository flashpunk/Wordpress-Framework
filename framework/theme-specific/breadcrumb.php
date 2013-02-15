<?php
function the_breadcrumb() {
   $current = $post->ID;
   $parent = $post->post_parent;
   $grandparent_get = get_post($parent);
   $grandparent = $grandparent_get->post_parent;
   echo '<ul class="breadcrumbs">';
   if (!is_home()) {
      echo '<li><a href="';
      echo get_option('home');
      echo '"><span>';
      echo 'Home';
      echo "</span></a></li> ";
      if (is_category() || is_single() || is_archive()) {
         the_category('title_li=');
         if (is_single()) {
            echo "<li><span>";
            the_title();
            echo "</span></li>";
         }
      } elseif (is_page()) {
         if ($root_parent = get_the_title($grandparent) !== $root_parent = get_the_title($current)) {
            echo "<li><a href='";
            echo get_permalink($grandparent_get->post_parent);
            echo "'>";
            echo get_the_title($grandparent);
            echo "</a>";
            echo "</li>";
         }
         echo '<li><span>';
         echo the_title();
         echo '</span></li>';
      }
   } else if ( is_home() ) {
      echo '<li><a href="';
      echo get_option('home');
      echo '"><span>';
      echo 'Home';
      echo "</span></a></li>";
   };
   echo '</ul>';
}