<?php
/*
Plugin Name: SW_ajax-load-policy
Plugin URI: warsztatkodu.pl
Description: Load policy info without refresh page
Version: 1.0.0
Author: Sebastian Wesołowski
Author URI: warsztatkodu.pl
Copyright: Sebastian Wesołowski
*/

add_action( 'wp_enqueue_scripts', 'ajax_test_enqueue_scripts' );
function ajax_test_enqueue_scripts() {
    wp_enqueue_script( 'load-policy', plugins_url( 'assets/js/SW_ajax-load-policy.js', __FILE__ ), array('jquery'), '1.0', true );

	wp_localize_script( 'load-policy', 'settings', array(
		'ajaxurl'    => admin_url( 'admin-ajax.php' ),
        'send_label' => __( 'Send report', 'reportabug' )
    ));

}

add_action( 'wp_ajax_nopriv_send_bug_report', 'send_bug_report' );
add_action( 'wp_ajax_send_bug_report', 'send_bug_report' );

function send_bug_report() {
    global $wpdb;
    $args = array(
        'page_id'   => url_to_postid( get_privacy_policy_url())
    );

    $my_posts = new WP_Query( $args );
    if ( $my_posts->have_posts() ) : while ( $my_posts->have_posts() ) : $my_posts->the_post();
            $title = get_the_title();
            $content = get_the_content();
        endwhile;
    endif;

    wp_send_json_success( __( $content, $title ) );
	wp_die();
    die();
}
?>
