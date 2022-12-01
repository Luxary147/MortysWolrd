<?php
/**
 * Plugin Name: WP Hooks Finder
 * Version: 1.2.1
 * Description: Easily enable/disable hooks and filters which are running in the page. A menu "WP Hooks Finder" will be added in your wordpress admin bar menu where you can display all the hooks and filters
 * Author: Muhammad Rehman
 * Author URI: https://muhammadrehman.com/
 * License: GPLv2 or later
 */

define( 'WPHF_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );

/**
 * Adding style
 * 
 * @since 1.0
 * @version 1.0
 */
function wphf_style() {
    wp_enqueue_style( 'wphf-style', WPHF_PLUGIN_PATH . 'assets/css/style.css' );    
}
add_action( 'wp_enqueue_scripts', 'wphf_style' );
add_action( 'admin_enqueue_scripts', 'wphf_style' );

/**
 * Adding menu in the Admin Bar Menu
 * 
 * @since 1.0
 * @version 1.2
 */
add_action('admin_bar_menu', 'wphf_add_toolbar_items', 99 );

function wphf_add_toolbar_items( $admin_bar ){

    $page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $page_url = wphf_clean_url($page_url);
    $page_request = parse_url( $page_url );


    $wphp_request = $page_url . ( isset( $page_request['query'] ) ? '&' : '?' ) . 'wphf=0';
    $display_label = 'Hide All hooks & Filters';
    
    if( !isset( $_GET['wphf']) || $_GET['wphf'] == 0 ) {
    

        $wphp_request = $page_url . ( isset( $page_request['query'] ) ? '&' : '?' ) . 'wphf=1';
        $display_label = 'Show All hooks & Filters';
    }

    $admin_bar->add_menu( array(
        'id'    => 'wp-hooks-finder',
        'title' => 'WP Hooks Finder',
        'href'  => '#',
        'meta'  => array(
            'title' => __('WP Hooks Finder'),            
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'enable-disable-hooks',
        'parent' => 'wp-hooks-finder',
        'title' => $display_label,
        'href'  => $wphp_request,
        'meta'  => array(
            'title' => __($display_label),
            // 'target' => '_blank',
            'class' => 'wphf-menu'
        ),
    ));
}

function wphf_clean_url( $url ) {

    $query_url = array( '?wphf=1', '?wphf=0', '&wphf=0', '&wphf=1' );

    foreach( $query_url as $q_url ) {
        if( strpos(  $url, $q_url ) !== false ) {
            $clean_url = str_replace( $q_url, '',$url );
            return $clean_url;            
        }
    }

    return $url;
}

/**
 * WordPress action hook "all", which is responsible to display hooks & filters
 * 
 * @since 1.0
 * @version 1.0
 */
add_action( 'all', 'wphf_display_all_hooks' );

function wphf_display_all_hooks( $tag ) {

    if( !isset( $_GET['wphf'] ) || $_GET['wphf'] == 0 ) return;

    global $debug_tags; global $wp_actions;
    
    if( !isset( $debug_tags ) )
        $debug_tags = array();

    if ( in_array( $tag, $debug_tags ) ) {
        return;
    }

    if( isset( $wp_actions[$tag] ) ) {
        echo "<div id='wphf-action' title=' Action Hook'><img src='".WPHF_PLUGIN_PATH."assets/img/action.png' />" . $tag . "</div>";
    } else {
        echo "<div id='wphf-filter' title='Filter Hook'><img src='".WPHF_PLUGIN_PATH."assets/img/filter.png' />" . $tag . "</div>";
    }

    $debug_tags[] = $tag;
}
