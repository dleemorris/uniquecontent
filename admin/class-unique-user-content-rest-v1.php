<?php
/**
 * The REST API functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * REST API setup
 */
class Unique_User_Content_REST {

	private $plugin_name;

	private $version;

	private $schema;

	private $aux;

	private $sample;

	public function __construct( $plugin_name, $version ) {

		require_once UNIQUE_USER_CONTENT_PATH . 'admin/partials/rest/v1/class-unique-user-content-rest-aux.php';

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->namespace = 'unique-user-content/v1';

		$this->aux = new Unique_User_Content_REST_aux();

	}

	public function register_routes() {

	}

}
