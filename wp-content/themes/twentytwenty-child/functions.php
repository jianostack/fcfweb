<?php

function my_theme_enqueue_styles() {
 
    $parent_style = 'parent-style'; 
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Registration form validation
 * Subscriber's email needs to be in the sgfcfers table.
 * See changelog.md for DB structure
 */
function istheemailgood($errors, $sanitized_user_login, $user_email) {

    global $wpdb;
    $table_name = $wpdb->prefix."users_fcf";
    $results = $wpdb->get_row(
        "SELECT EMAIL
        FROM $table_name
        WHERE EMAIL = '$user_email'
        ");

    if($results == null){
        $errors->add( 'email_error', __( '<strong>ERROR</strong>: Invalid EMAIL.', 'my_textdomain' ) );
    }

    return $errors;
}
add_filter( 'registration_errors', 'istheemailgood', 10, 3 );

/**
 * Remove Private: from page titles
 *
 *
 */
function bl_remove_private_title( $title ) {
    // Return only the title portion as defined by %s, not the additional
    // 'Private: ' as added in core
    return "%s";
}
add_filter( 'private_title_format', 'bl_remove_private_title' );

/**
 * Add loginout onto menus
 *
 */
function wpsites_loginout_menu_link( $menu ) {
    $loginout = '<li class="menu-item">'.wp_loginout($_SERVER['REQUEST_URI'], false ).'</li>';
    $updated_loginout = str_replace("Log", "Members log", $loginout);
    $menu .= $updated_loginout;
    return $menu;
}
add_filter( 'wp_nav_menu_primary_items','wpsites_loginout_menu_link' );
add_filter( 'wp_nav_menu_primaryzh_items','wpsites_loginout_menu_link' );

/**
 * Let subscriber view private pages
 *
 */
$subRole = get_role( 'subscriber' );
$subRole->add_cap( 'read_private_pages' );

/**
 * Subscriber login redirect
 *
 * When Subscribers log in, you don’t necessarily want them dumped onto the dashboard.
 */
function loginRedirect( $redirect_to, $request_redirect_to, $user ) {
    if ( is_a( $user, 'WP_User' ) ) {
        $redirect_path = "/members";
        return $redirect_path;
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'loginRedirect', 10, 3 );


/**
 * Polylang string translations
 *
 *
 */
if ( function_exists('pll_register_string') ) {
    pll_register_string('Test', 'Test Translation');
    pll_register_string('worship-name', 'Name');
    pll_register_string('worship-email', 'Email');
    pll_register_string('worship-mobile', 'Mobile Phone Number');
    pll_register_string('worship-service', 'Which service will you be attending?');
    pll_register_string('worship-choose', 'Please choose 1');
    pll_register_string('worship-breaking', 'Breaking of Bread');
    pll_register_string('worship-worship', 'Worship Service');
    pll_register_string('worship-both', 'Both Services');
    pll_register_string('worship-thankyou', 'Thank you');
    pll_register_string('worship-duplicate', 'Worship duplicate message');
}

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function twentytwenty_child_menus() {

    $locations = array(
        'expanded_logged_in'   => __( 'Desktop Expanded Menu Logged in', 'twentytwenty' ),
        'mobile_logged_in'   => __( 'Mobile Menu Logged in', 'twentytwenty' )
    );

    register_nav_menus( $locations );
}

add_action( 'init', 'twentytwenty_child_menus' );
