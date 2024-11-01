<?php
if ( ! defined( 'ABSPATH' ) )
    exit; //Exit if accessed directly.

class WPPL_LogListAdminPage {

    public function __construct() {
        add_filter( 'bulk_actions-edit-posts-log', array( $this, 'disable_bulk_actions' ) );
        add_filter( 'manage_wppl-posts-log_posts_columns', array( $this, 'list_columns' ) );
        add_action( 'manage_wppl-posts-log_posts_custom_column', array( $this, 'list_column' ), 10, 2 );
        add_action( 'restrict_manage_posts', array( $this, 'add_user_filter_support' ) );
        add_filter( 'pre_get_posts', array( $this, 'filter_logs_by_user' ) );
    }

    public function disable_bulk_actions( $actions ) {
        return array();
    }

    public function list_columns( $columns ) {
        $columns = array(
            'log_detail'    => __( 'Log Detail ', 'wppl-posts-log' ),
            'date'      => __( 'Date', 'wppl-posts-log' )
        );

        return $columns;
    }

    public function list_column( $column, $post_id ) {
        if ( $column == 'log_detail' ) {
            $post_log = new WPPL_LogPost();
            echo $post_log->render_log( $post_id );
        }
    }

    public function add_user_filter_support( $post_type ) {
        if ( $post_type != 'wppl-posts-log' )
            return;

        if ( ! empty( $_GET['posts-log-user'] ) )
            $selected_user =  (int) $_GET['posts-log-user'];
?>

        <select name='posts-log-user'>
            <option value=""><?php echo __( 'All Users', 'wppl-posts-log' ); ?></option>

            <?php foreach ( get_users() as $user ) : ?>
                <option value='<?php echo $user->id; ?>' <?php selected( $selected_user, $user->id ); ?>>
                    <?php echo $user->display_name; ?>
                </option>

            <?php endforeach; ?>
        </select>
<?php
    }

    public function filter_logs_by_user( $wp_query ) {
        if ( ! is_admin() || $wp_query->query['post_type'] != 'wppl-posts-log' )
            return;

        if ( ! empty( $_GET['posts-log-user'] ) ) {
            $selected_user = (int) $_GET['posts-log-user'];
            $wp_query->set( 'author__in', array( $selected_user ) );
        }
    }
}

new WPPL_LogListAdminPage();
