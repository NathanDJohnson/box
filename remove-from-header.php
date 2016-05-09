<?php
/*
Plugin Name: Remove from Header
Plugin URI: 
Description: Removes a bunch of stuff from the header to speed up page loads.
Author: Nathan Johnson
Version: 1.0
Author URI: http://atmoz.org/
*/

/* Exit if accessed directly */
if( ! defined( 'ABSPATH' ) ) exit;

/* Disable Admin Bar */
add_filter( 'show_admin_bar', '__return_false' );

/* Remove WordPress generator */
remove_action( 'wp_head', 'wp_generator' );

/* Remove RSD link */
remove_action( 'wp_head', 'rsd_link' );

/* Remove Feed links */
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3);

/* Remove index link */
remove_action( 'wp_head', 'index_rel_link' );

/* Remove wlwmanifest link */
remove_action( 'wp_head', 'wlwmanifest_link' );

/* Remove parent post link */
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

/* Remove prev and next post links */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

/* Remove shortlink */
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/* Remove REST API link */
remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );

/* Remove canonical link */
remove_action( 'wp_head', 'rel_canonical' );

/* Remove oembed discovery links */
remove_action ( 'wp-head', 'wp_oembed_add_discovery_links', 10, 1 );

/* Remove Genericons */
function dequeue_genericons() {
	wp_dequeue_style( 'genericons' );
}
add_action( 'wp_print_styles', 'dequeue_genericons', 100 );

/* Disable Emoji Support */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}
	else {
		return array();
	}
}

// Remove Feed Generator Tags 
foreach ( array( 'rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head' ) as $action ) { 
    remove_action( $action, 'the_generator' ); 
} 

remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
