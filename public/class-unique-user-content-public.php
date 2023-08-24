<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/public
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/public
 */
class Unique_User_Content_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Unique_User_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Unique_User_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/unique-user-content-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Unique_User_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Unique_User_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$this->jsvariables['userLoggedIn'] = false;

		if ( is_user_logged_in() ) {

			$this->jsvariables['userLoggedIn'] = true;

		}

		$this->jsvariables['nonce']       = wp_create_nonce( 'unique-user-content-learndash' );
		$this->jsvariables['wpRestNonce'] = wp_create_nonce( 'wp_rest' );

		$this->jsvariables['api']           = array();
		$this->jsvariables['api']['base']   = get_rest_url();
		$this->jsvariables['api']['submit'] = get_rest_url( null, 'unique-user-content/v1/submit-rating' );
		$this->jsvariables['api']['fetch']  = get_rest_url( null, 'unique-user-content/v1/fetch' );
		// $this->jsvariables['api']['base'] = get_rest_url();

		$this->jsvariables['text']          = array();
		$this->jsvariables['text']['error'] = esc_html__( 'Error, Try again...', 'unique-user-content-learndash' );
		$this->jsvariables['text']['prev']  = esc_html__( 'Prev', 'unique-user-content-learndash' );
		$this->jsvariables['text']['next']  = esc_html__( 'Next', 'unique-user-content-learndash' );

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/unique-user-content-public.js' );

		wp_localize_script( $this->plugin_name, 'ldUniqueUserContentsJsVariables', $this->jsvariables );

		wp_enqueue_script( $this->plugin_name, '', array( 'jquery' ), $this->version, true );

	}


}
