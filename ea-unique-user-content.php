<?php
/**
 * Plugin Name:       Unique User Content for LearnDash
 * Plugin URI:        https://honorswp.com/
 * Description:       Create unique content based and assign it to individual users, courses, groups or all of the above!
 * Author:            Honors WP
 * Author URI:        https://honorswp.com
 * Version:           1.1.2
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Text Domain:       unique-user-content
 * Domain Path:       /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Unique_User_Content
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use EA\Licensing\License;

/**
 * Plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'UNIQUE_USER_CONTENT_VERSION', '1.1.2' );
define( 'UNIQUE_USER_CONTENT_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Licensing
 */
new License(
	esc_html__( 'Unique User Content for LearnDash', 'unique-user-content-learndash' ),
	6691,
	'unique-user-content-learndash',
	__FILE__,
	UNIQUE_USER_CONTENT_VERSION
);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-unique-user-content-activator.php
 */
function activate_unique_user_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-unique-user-content-activator.php';
	Unique_User_Content_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-unique-user-content-deactivator.php
 */
function deactivate_unique_user_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-unique-user-content-deactivator.php';
	Unique_User_Content_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_unique_user_content' );
register_deactivation_hook( __FILE__, 'deactivate_unique_user_content' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-unique-user-content.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_unique_user_content() {

	$plugin = new Unique_User_Content();
	$plugin->run();

}
run_unique_user_content();
