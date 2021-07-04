<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           WorshipRego
 *
 * @wordpress-plugin
 * Plugin Name:       Worship Registration
 * Plugin URI:        https://github.com/jianostack/worship-rego
 * Description:       Sunday Worship onsite registration
 * Version:           1.0.0
 * Author:            jianostack
 * Text Domain:       worship-rego
 * Domain Path:       /languages
 */

// In strict mode, only a variable of exact type of the type declaration will be accepted.
declare(strict_types=1);

namespace WorshipRego;

use WorshipRego\Includes\Activator;
use WorshipRego\Includes\Deactivator;
use WorshipRego\Includes\Updater;
use WorshipRego\Includes\Main;

// If this file is called directly, abort.
if (!defined('ABSPATH')) exit;

// Autoloader
require_once plugin_dir_path(__FILE__) . 'Autoloader.php';

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WORSHIP_REGO_VERSION', '1.0.0');

/**
 * The string used to uniquely identify this plugin.
 */
define('WORSHIP_REGO_SLUG', 'worship-rego');

/**
 * Configuration data
 *  - db-version:   Start with 0 and increment by 1. It should not be updated with every plugin update,
 *                  only when database update is required.
 */
$configuration = array(
    'version'       => WORSHIP_REGO_VERSION,
    'db-version'    => 1
);

/**
 * The ID for the configuration options in the database.
 */
$configurationOptionName = WORSHIP_REGO_SLUG . '-configuration';
    
/**
 * The code that runs during plugin activation.
 * This action is documented in Includes/Activator.php
 */
register_activation_hook(__FILE__, function($networkWide) use($configuration, $configurationOptionName) {Activator::activate($networkWide, $configuration, $configurationOptionName);});

/**
 * Run the activation code when a new site is created.
 */
add_action('wpmu_new_blog', function($blogId) {Activator::activateNewSite($blogId);});

/**
 * The code that runs during plugin deactivation.
 * This action is documented in Includes/Deactivator.php
 */
register_deactivation_hook(__FILE__, function($networkWide) {Deactivator::deactivate($networkWide);});

/**
 * Update the plugin.
 * It runs every time, when the plugin is started.
 */
add_action('plugins_loaded', function() use ($configuration, $configurationOptionName) {Updater::update($configuration['db-version'], $configurationOptionName);}, 1);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function runPlugin(): void
{
    $plugin = new Main();
    $plugin->run();
}
runPlugin();
