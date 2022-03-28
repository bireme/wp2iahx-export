<?php
/*
Plugin Name: WP2iAHx Export
Plugin URI: https://github.com/bireme/wp2iahx-export
Description: This plugin generates a XML file in iAHx format for multiple posts from your Wordpress blog.
Author: Wilson Moura - BIREME/PAHO/WHO
Author URI: http://github.com/wilsonmoura
Version: 1.0
*/

define( 'WP2IAHX_EXPORT_DIR', plugin_dir_path(__FILE__) );
define( 'WP2IAHX_EXPORT_URL', plugin_dir_url(__FILE__) );

require_once(WP2IAHX_EXPORT_DIR . 'functions.php');

if ( !function_exists( 'do_feed_iahx' ) ) {
    function do_feed_iahx() {
        load_template( WP2IAHX_EXPORT_DIR . 'feed-iahx.php' );
    }
}
add_action( 'do_feed_iahx', 'do_feed_iahx', 10, 1 );

?>
