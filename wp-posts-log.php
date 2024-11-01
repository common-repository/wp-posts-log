<?php
/**
 * Plugin Name: WordPress Posts Log
 * Description: A plugin for log posts activity.
 * Author: Adil Öztaşer
 * Author URI: https://oztaser.com
 * Version: 1.0.0
 * License: GPLv3
 * Text Domain: wppl-posts-log
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) )
    exit; //Exit if accesseed directly.

if ( ! class_exists( 'WPPL_PostsLog' ) ) {

    class WPPL_PostsLog {

        public function __construct() {
            define( 'WPPL_INCLUDES', dirname( __FILE__ ) . '/inc/' );
            define( 'WPPL_LANGUAGES', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

            add_action( 'plugins_loaded', array( $this, 'init' ) );
        }

        public function init() {
            include_once( WPPL_INCLUDES . 'class-posts-log-post-type.php' );
            include_once( WPPL_INCLUDES . 'class-log-post.php' );
            include_once( WPPL_INCLUDES . 'class-post-actions.php' );
            include_once( WPPL_INCLUDES . 'class-admin-page.php' );

            load_plugin_textdomain( 'wppl-posts-log', FALSE, WPPL_LANGUAGES );
        }

    }

    new WPPL_PostsLog();
}
