<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/includes
 */
class Unique_User_Content {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Unique_User_Content_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'UNIQUE_USER_CONTENT_VERSION' ) ) {
			$this->version = UNIQUE_USER_CONTENT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'unique-user-content';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Unique_User_Content_Loader. Orchestrates the hooks of the plugin.
	 * - Unique_User_Content_i18n. Defines internationalization functionality.
	 * - Unique_User_Content_Admin. Defines all hooks for the admin area.
	 * - Unique_User_Content_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-unique-user-content-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-unique-user-content-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-unique-user-content-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-unique-user-content-public.php';

		/* REST */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-unique-user-content-rest-v1.php';

		$this->loader = new Unique_User_Content_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Unique_User_Content_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Unique_User_Content_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Unique_User_Content_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_rest  = new Unique_User_Content_REST( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'create_unique_user_content_post_type' );
		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'available_content' );
		$this->loader->add_filter( 'learndash_submenu', $plugin_admin, 'add_unique_user_content_admin_menu', 1 );

		$this->loader->add_action( 'rest_api_init', $plugin_rest, 'register_routes' );

		// $this->loader->add_filter( 'use_block_editor_for_post_type', $plugin_admin, 'disable_gutenberg_for_post_type', 10, 2);

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_box_courses' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_box_groups' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_box_users' );

		$this->loader->add_action( 'save_post', $plugin_admin, 'save_meta_courses', 10, 3 );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_meta_groups', 11, 3 );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_meta_users', 12, 3 );

		$this->loader->add_action( 'before_delete_post', $plugin_admin, 'delete_uuc_post', 10, 2 );

		// $this->loader->add_action( 'learndash-course-heading-after', $plugin_admin, 'course_content_before', 10, 2 );
		// $this->loader->add_action( 'learndash-course-content-list-after', $plugin_admin, 'course_content_after', 10, 2 );

		$this->loader->add_filter( 'learndash_content_tabs', $plugin_admin, 'add_unique_user_content_tab', 30, 4 );

		add_shortcode( 'unique_user_content', array( $plugin_admin, 'unique_user_content_func' ) );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Unique_User_Content_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Unique_User_Content_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
