<?php

function fcf2013_setup() {

  // Switches default core markup for search form, comment form, and comments
  // to output valid HTML5.
  add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

  /*
   * This theme uses a custom image size for featured images, displayed on
   * "standard" posts and pages.
   */
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 604, 270, true );

  // This theme uses its own gallery styles.
  add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'fcf2013_setup' );

/**
 * Enqueues scripts and styles for front end.
 *
 * @since fcf2013
 *
 * @return void
 */
function fcf2013_scripts_styles() {
  wp_enqueue_style( 'style', get_stylesheet_uri());

  if ($_SERVER['SERVER_NAME'] == 'thefishermanofchrist.localhost') {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.0.3', true );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap302.css', array(), '3.0.2' );
    wp_enqueue_style( 'theme', get_template_directory_uri() . '/css/theme.css', array(), '' );
  } else {
    wp_enqueue_style( 'all styles', get_template_directory_uri() . '/dist/all.min.css', false, null);
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'all scripts', get_template_directory_uri() . '/dist/all.min.js', false, null);
  }
}
add_action( 'wp_enqueue_scripts', 'fcf2013_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function twentythirteen_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() )
    return $title;

  // Add the site name.
  $title .= get_bloginfo( 'name' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    $title = "$title $sep $site_description";

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 )
    $title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

  return $title;
}
add_filter( 'wp_title', 'twentythirteen_wp_title', 10, 2 );

/**
 * Registers two widget areas.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Header ', 'fcf2013' ),
    'id'            => 'header-verse',
    'description'   => __( 'bible verse', 'fcf2013' ),
    'before_widget' => '<div class="col-md-12 churchVerse">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="hidden">',
    'after_title'   => '</h4>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Links', 'fcf2013' ),
    'id'            => 'sidebar-links',
    'description'   => __( 'homepage left sidebar', 'fcf2013' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h5 class="dailyVerses">',
    'after_title'   => '</h5>',
  ) );
}
add_action( 'widgets_init', 'twentythirteen_widgets_init' );





/**
 * Let subscriber view private pages
 *
 */
function add_theme_caps() {
  $subRole = get_role( 'subscriber' );
  $subRole->add_cap( 'read_private_pages' );
}
add_action( 'admin_init', 'add_theme_caps');

/**
 * Subscriber login redirect
 *
 * When Subscribers log in, you don’t necessarily want them dumped onto the dashboard.
 */
function loginRedirect( $redirect_to, $request_redirect_to, $user ) {
    if ( is_a( $user, 'WP_User' ) && $user->has_cap( 'edit_posts' ) === false ) {
        $newsletter = "/newsletter";
        return $newsletter;
        //return get_bloginfo( 'siteurl');
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'loginRedirect', 10, 3 );

/**
 * Menu locations
 *
 * We need this to add filter to main menu
 */
register_nav_menus( array(
    'main'   => __( 'Top primary menu', 'fcf2013' ),
));

/**
 * Subscriber menu
 *
 */
function subscribers_menu( $menu ) {
    $submenu = '<li class"menu-item"><a href="/newsletter">Newsletter</a></li>';

    if(is_user_logged_in()){
        $menu .= $submenu;
    }

    return $menu;
}
add_filter( 'wp_nav_menu_main_items','subscribers_menu' );

/**
 * Subscriber menu zh
 *
 */
function subscribers_menu_zh( $menu ) {
    $submenu = '<li class"menu-item"><a href="/newsletter-2/?lang=zh-hans">通讯</a></li>';

    if(is_user_logged_in()){
        $menu .= $submenu;
    }

    return $menu;
}
add_filter( 'wp_nav_menu_chinese-main_items','subscribers_menu_zh' );

/**
 * Add loginout onto menus
 *
 */
function wpsites_loginout_menu_link( $menu ) {
    $loginout = '<li class"menu-item">'.wp_loginout($_SERVER['REQUEST_URI'], false ).'</li>';
    $menu .= $loginout;
    return $menu;
}
add_filter( 'wp_nav_menu_main_items','wpsites_loginout_menu_link' );
add_filter( 'wp_nav_menu_chinese-main_items','wpsites_loginout_menu_link' );


/**
 * Add NRIC field to registration form
 *
 */
function myplugin_add_registration_fields() {

    //Get and set any values already sent
    $user_extra = ( isset( $_POST['user_extra'] ) ) ? $_POST['user_extra'] : '';
    ?>

    <p>
        <label for="user_extra"><?php _e( 'NRIC', 'myplugin_nric' ) ?><br />
            <input type="text" name="user_nric" id="user_nric" class="input" value="<?php echo esc_attr( stripslashes( $user_nric ) ); ?>" size="25" /></label>
    </p>

    <?php
}
//add_action( 'register_form', 'myplugin_add_registration_fields' );

/**
 * Registration form validation
 * Subscriber's NRIC needs to be in the sgers table.
 * See changelog.md for DB structure
 */
function myplugin_check_fields($errors, $sanitized_user_login, $user_email) {

    //from the rego form
    $user_nric = $_POST['user_nric'];

    //is user_nric in the DB? If so we have a $result
    global $wpdb;
    $table_name = $wpdb->prefix."sgers";
    $results = $wpdb->get_row(
        "SELECT NRIC
        FROM $table_name
        WHERE NRIC = '$user_nric'
        ");

    if($results == null){
        $errors->add( 'nric_error', __( '<strong>ERROR</strong>: Invalid NRIC.', 'my_textdomain' ) );
    }

    return $errors;
}
//add_filter( 'registration_errors', 'myplugin_check_fields', 10, 3 );

/**
 * Registration form validation
 * Subscriber's email needs to be in the sgfcfers table.
 * See changelog.md for DB structure
 */
function istheemailgood($errors, $sanitized_user_login, $user_email) {

    global $wpdb;
    $table_name = $wpdb->prefix."sgfcfers";
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
 * Remove WP logo
 *
 *
 */
function my_login_logo() {
    echo '
    <style type="text/css">
      .login h1 {
        display: none;
      }
    </style>
    ';
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/**
 * Custom register message
 *
 *
 */
function custom_register_msg() {
  echo '<p class="message register">
  Email needs to be registered with FCF. See contact us page.</p>
  ';
}
add_filter('login_message','custom_register_msg');

