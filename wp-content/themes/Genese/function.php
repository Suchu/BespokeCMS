<?php
function wp_nav_menu() {
    wp_nav_menu( 'primary', 'Main Navigation Menu' );
}
add_action( 'init', 'wp_nav_menu' );
?>