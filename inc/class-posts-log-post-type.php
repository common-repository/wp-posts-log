<?php
if ( ! defined( 'ABSPATH' ) )
    exit; //Exit if accesseed directly.

class WPPL_PostsLogPostType {

    public function __construct() {
        add_action( 'init', array( $this, 'create_post_type' ) );
    }

    public function create_post_type() {
        $args = array(
            'label'                 => __( 'Posts Log', 'wppl-posts-log' ),
            'supports'              => false,
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_icon'             => 'dashicons-admin-plugins',
            'can_export'            => false,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'post',
            'capabilities'          => array(
                'create_posts'  => 'do_not_allow'
            ),
            'map_meta_cap' => false

        );

        register_post_type( 'wppl-posts-log', $args );
    }
}

new WPPL_PostsLogPostType();
