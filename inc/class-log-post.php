<?php
if ( ! defined( 'ABSPATH' ) )
    exit; //Exit if accessed directly.

class WPPL_LogPost {
    private $key_prefix = 'wppl-posts-log_';

    public function insert_log_post( $post, $status ) {
        wp_insert_post( array(
            'post_type'     => 'wppl-posts-log',
            'post_author'   => get_current_user_id(),
            'post_status'   => 'publish',
            'meta_input'    => array(
                "{$this->key_prefix}_status" => $status,
                "{$this->key_prefix}_post_id" => $post->ID,
                "{$this->key_prefix}_user" => get_current_user_id()
            ),
        ) );
    }

    private function find_log_meta( $log_id, $meta ) {
        return get_post_meta( $log_id, "{$this->key_prefix}{$meta}", true );
    }

    private function get_message( $log_id ) {
        $status = $this->find_log_meta( $log_id, '_status' );

        switch( $status ) {
            case 'publish':
                $message =  __( '%1$s %2$s published the %3$s', 'wppl-posts-log' );
                break;
            case 'update':
                $message =  __( '%1$s %2$s edited the %3$s', 'wppl-posts-log' );
                break;
            case 'trash':
                $message =  __( '%1$s %2$s trashed the %3$s', 'wppl-posts-log' );
                break;
            case 'draft':
                $message =  __( '%1$s %2$s drafted the %3$s', 'wppl-posts-log' );
                break;
            case 'untrash':
                $message =  __( '%1$s %2$s untrashed the %3$s', 'wppl-posts-log' );
                break;
            case 'future':
                $message =  __( '%1$s %2$s scheduled the %3$s', 'wppl-posts-log' );
                break;
        }

        return $message;
    }

    public function render_log( $log_id ) {
        $post = get_post( $this->find_log_meta( $log_id, '_post_id' ));
        $user = get_userdata( $this->find_log_meta( $log_id, '_user' ) );
        $message =  $this->get_message( $log_id );

        return sprintf(
            $message,
            '<img src="'. get_avatar_url( $user->ID ) .'" class="alignleft" style="margin-right: 30px;" width="48" height="48" />',
            '<a href="' . get_edit_user_link( $user->id ) . '">' . $user->display_name  . '</a>',
            '<a href="' . get_edit_post_link( $post->ID ) . '">'. $post->post_title .'</a>'
        );
    }
}
