<?php
if ( ! defined( 'ABSPATH' ) )
    exit; //Exit if accesseed directly.

class WPPL_PostActions {

    public function __construct() {
        add_action( 'transition_post_status', array(
            $this,
            'transition_post_status'
        ), 10, 3 );
    }

    public function transition_post_status( $new_status, $old_status, $post ) {
        if ( in_array( $post->post_type, array( 'wppl-posts-log', 'revision' ) ) )
            return;

        // do not write log for auto drafted posts.
        if ( $new_status == 'auto-draft' )
            return;

        if ( $old_status == 'publish' && $new_status == 'publish' )
            $log = 'update';
        elseif ( $old_status == 'trash' && $new_status == 'publish' )
            $log = 'untrash';
        else
            $log = $new_status;

        $log_post = new WPPL_LogPost();
        $log_post->insert_log_post( $post, $log );
    }

}

new WPPL_PostActions();
