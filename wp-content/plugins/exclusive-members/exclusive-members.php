<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/jianostack
 * @since             1.0.0
 * @package           Exclusive_Members
 *
 * @wordpress-plugin
 * Plugin Name:       Exclusive Members
 * Plugin URI:        https://github.com/jianostack/exclusive-members
 * Description:       Only allow certain emails to register. 
 * Version:           1.0.0
 * Author:            jianostack
 * Author URI:        https://github.com/jianostack
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       exclusive-members
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EXCLUSIVE_MEMBERS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-exclusive-members-activator.php
 */
function activate_exclusive_members() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-exclusive-members-activator.php';
	Exclusive_Members_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-exclusive-members-deactivator.php
 */
function deactivate_exclusive_members() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-exclusive-members-deactivator.php';
	Exclusive_Members_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_exclusive_members' );
register_deactivation_hook( __FILE__, 'deactivate_exclusive_members' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-exclusive-members.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_exclusive_members() {

	$plugin = new Exclusive_Members();
	$plugin->run();

}
run_exclusive_members();
