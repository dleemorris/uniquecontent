<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       example.com
 * @since      1.0.0
 *
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Unique_User_Content
 * @subpackage Unique_User_Content/admin
 * @author     Srikanth <none@example.com>
 */
class Unique_User_Content_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	private $learndash_courses_list;

	private $learndash_groups_list;

	private $learndash_users_list;

	private $admin_variables;

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->learndash_courses_list = array( 'select' => esc_html__( 'Select', 'unique-user-content-learndash' ) );
		$this->learndash_groups_list  = array( 'select' => esc_html__( 'Select', 'unique-user-content-learndash' ) );
		$this->learndash_users_list   = array( 'select' => esc_html__( 'Select', 'unique-user-content-learndash' ) );

		$this->admin_variables = array();
	}

	public function available_content() {
		$available_courses = get_posts(
			array(
				'post_type'      => 'sfwd-courses',
				'posts_per_page' => -1,
			)
		);
		foreach ( $available_courses as $i ) {
			$this->learndash_courses_list[ esc_html( $i->ID ) ] = esc_html( $i->post_title );
		}

		$available_groups = get_posts(
			array(
				'post_type'      => 'groups',
				'posts_per_page' => -1,
			)
		);
		foreach ( $available_groups as $i ) {
			$this->learndash_groups_list[ esc_html( $i->ID ) ] = esc_html( $i->post_title );
		}

		$available_users = get_users( array( 'fields' => array( 'display_name', 'ID' ) ) );
		foreach ( $available_users as $i ) {
			$this->learndash_users_list[ esc_html( $i->ID ) ] = esc_html( $i->display_name );
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/unique-user-content-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$this->admin_variables['labels'] = array();
		// $this->admin_variables['labels']['selectDefault'] = __( 'Select', 'learndash-related-courses' );

		$this->admin_variables['courses'] = $this->learndash_courses_list;
		$this->admin_variables['groups']  = $this->learndash_groups_list;
		$this->admin_variables['users']   = $this->learndash_users_list;

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/unique-user-content-admin.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'lduucVariables', $this->admin_variables );
		wp_enqueue_script( $this->plugin_name );
		wp_register_script( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-select2' );
	}

	/**
	 * Create post type
	 *
	 * To add a class to body tag of plugin admin page
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function create_unique_user_content_post_type() {

		$labels = array(
			'name'                  => esc_html_x( 'Unique User Content', 'Post type general name', 'unique-user-content-learndash' ),
			'singular_name'         => esc_html_x( 'Unique User Content', 'Post type singular name', 'unique-user-content-learndash' ),
			'menu_name'             => esc_html_x( 'Unique User Content', 'Admin Menu text', 'unique-user-content-learndash' ),
			'name_admin_bar'        => esc_html_x( 'Unique User Content', 'Add New on Toolbar', 'unique-user-content-learndash' ),
			'add_new'               => esc_html__( 'Add New Unique User Content', 'unique-user-content-learndash' ),
			'add_new_item'          => esc_html__( 'Add New Unique User Content', 'unique-user-content-learndash' ),
			'new_item'              => esc_html__( 'New Unique User Content', 'unique-user-content-learndash' ),
			'edit_item'             => esc_html__( 'Edit Unique User Content', 'unique-user-content-learndash' ),
			'view_item'             => esc_html__( 'View Unique User Content', 'unique-user-content-learndash' ),
			'all_items'             => esc_html__( 'All Unique User Content', 'unique-user-content-learndash' ),
			'search_items'          => esc_html__( 'Search Unique User Content', 'unique-user-content-learndash' ),
			'parent_item_colon'     => esc_html__( 'Parent Unique User Content:', 'unique-user-content-learndash' ),
			'not_found'             => esc_html__( 'No Unique User Content found.', 'unique-user-content-learndash' ),
			'not_found_in_trash'    => esc_html__( 'No Unique User Content found in Trash.', 'unique-user-content-learndash' ),
			'featured_image'        => esc_html_x( 'Unique User Content Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'unique-user-content-learndash' ),
			'set_featured_image'    => esc_html_x( 'Set Unique User Content image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'unique-user-content-learndash' ),
			'remove_featured_image' => esc_html_x( 'Remove Unique User Content image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'unique-user-content-learndash' ),
			'use_featured_image'    => esc_html_x( 'Use as Unique User Content image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'unique-user-content-learndash' ),
			'archives'              => esc_html_x( 'Unique User Content archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'unique-user-content-learndash' ),
			'insert_into_item'      => esc_html_x( 'Insert into Unique User Content', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'unique-user-content-learndash' ),
			'uploaded_to_this_item' => esc_html_x( 'Uploaded to this Unique User Content', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'unique-user-content-learndash' ),
			'filter_items_list'     => esc_html_x( 'Filter Unique User Content', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'unique-user-content-learndash' ),
			'items_list_navigation' => esc_html_x( 'Wishlist navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Unique User Content navigation”. Added in 4.4', 'unique-user-content-learndash' ),
			'items_list'            => esc_html_x( 'Unique User Content', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'unique-user-content-learndash' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'unique-user-content' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor' ),
			'show_in_rest'       => true,
			'map_meta_cap'       => true,
		);

		register_post_type( 'unique-user-content', $args );

	}

	public function add_unique_user_content_admin_menu( $add_submenu ) {
		$cap = apply_filters( 'unique_user_content_admin_menu_access', 'administrator' );

		$add_submenu['unique-user-content'] = array(
			'name'  => esc_html_x( 'Unique User Content', 'Unique User Content for marketing', 'unique-user-content-learndash' ),
			'cap'   => $cap,
			'link'  => 'edit.php?post_type=unique-user-content',
			'class' => 'submenu-ldlms-essays',
		);

		return $add_submenu;

	}

	public function disable_gutenberg_for_post_type( $is_enabled, $post_type ) {

		if ( 'unique-user-content' === $post_type ) {
			return false;
		}

		return $is_enabled;

	}

	/**
	 * Add meta box to product post type
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_meta_box_courses() {

		add_meta_box( 'ldrating_meta_box_courses', __( 'Associated Courses', 'unique-user-content-learndash' ), array( $this, 'add_meta_box_courses_html' ), 'unique-user-content', 'normal', '', null );

	}

	public function add_meta_box_groups() {

		add_meta_box( 'ldrating_meta_box_groups', __( 'Associated Groups', 'unique-user-content-learndash' ), array( $this, 'add_meta_box_groups_html' ), 'unique-user-content', 'normal', '', null );

	}

	public function add_meta_box_users() {

		add_meta_box( 'ldrating_meta_box_users', __( 'Associated Users', 'unique-user-content-learndash' ), array( $this, 'add_meta_box_users_html' ), 'unique-user-content', 'normal', '', null );

	}

	/**
	 * Html for meta box
	 *
	 * @since    1.0.0
	 * @access   public
	 * @param Object $object The admin file name of this plugin.
	 */
	public function add_meta_box_courses_html( $object ) {

		wp_nonce_field( basename( __FILE__ ), 'lduuc-meta-courses' );
		$course_list = $this->learndash_courses_list;
		require_once UNIQUE_USER_CONTENT_PATH . 'admin/partials/meta-box-courses.php';

	}

	public function save_meta_courses( $post_id ) {

		if ( ! isset( $_POST['lduuc-meta-courses'] ) || ! wp_verify_nonce( $_POST['lduuc-meta-courses'], basename( __FILE__ ) ) ) { //phpcs:ignore
			return $post_id;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( isset( $_POST['post_type'] ) && 'unique-user-content' === $_POST['post_type'] ) {

			$update_ucc_course_data    = array();
			$update_ucc_course_current = get_post_meta( $post_id, 'learndash-ucc-courses-data', true );

			if ( isset( $_POST['ld-ucc-courses'] ) && '' != $_POST['ld-ucc-courses'] ) {

				$update_ucc_course_new = $_POST['ld-ucc-courses'];

				if (
					$update_ucc_course_current && is_array( $update_ucc_course_current ) &&
					$update_ucc_course_new && is_array( $update_ucc_course_new )
				) {

					foreach ( $update_ucc_course_current as $i ) {
						if ( ! in_array( $i, $update_ucc_course_new ) ) {
							$course_meta = get_post_meta( $i, 'ld_ucc', true );
							if ( $course_meta && is_array( $course_meta ) && array_key_exists( $post_id, $course_meta ) ) {
								unset( $course_meta[ $post_id ] );
								update_post_meta( $i, 'ld_ucc', $course_meta );
							}
						}
					}
				}

				if (
					$update_ucc_course_new && is_array( $update_ucc_course_new )
				) {

					foreach ( $update_ucc_course_new as $k ) {

						$course_meta = get_post_meta( $k, 'ld_ucc', true );

						if ( ! is_array( $course_meta ) ) {
							$course_meta = array();
						}
						$course_meta_key                     = esc_html( $k );
						$course_meta[ esc_html( $post_id ) ] = esc_html( get_the_title( $post_id ) );
						update_post_meta( $k, 'ld_ucc', $course_meta );
						$update_ucc_course_data[] = $course_meta_key;

					}
				}
			} else {

				if ( is_array( $update_ucc_course_current ) ) {

					foreach ( $update_ucc_course_current as $f ) {

						$course_meta = get_post_meta( $f, 'ld_ucc', true );
						if ( $course_meta && is_array( $course_meta ) && array_key_exists( $post_id, $course_meta ) ) {
							unset( $course_meta[ $post_id ] );
							update_post_meta( $f, 'ld_ucc', $course_meta );
						}
					}
				}
			}

			$update_ucc_course = update_post_meta( $post_id, 'learndash-ucc-courses-data', $update_ucc_course_data );

		} else {

			return $post_id;

		}

	}

	public function add_meta_box_groups_html( $object ) {

		wp_nonce_field( basename( __FILE__ ), 'lduuc-meta-groups' );
		$groups_list = $this->learndash_groups_list;
		require_once UNIQUE_USER_CONTENT_PATH . 'admin/partials/meta-box-groups.php';

	}

	public function save_meta_groups( $post_id ) {

		if ( ! isset( $_POST['lduuc-meta-groups'] ) || ! wp_verify_nonce( $_POST['lduuc-meta-groups'], basename( __FILE__ ) ) ) { //phpcs:ignore
			return $post_id;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( isset( $_POST['post_type'] ) && 'unique-user-content' === $_POST['post_type'] ) {

			$update_ucc_group_data    = array();
			$update_ucc_group_current = get_post_meta( $post_id, 'learndash-ucc-groups-data', true );

			if ( isset( $_POST['ld-ucc-groups'] ) && '' != $_POST['ld-ucc-groups'] ) {

				$update_ucc_group_new = $_POST['ld-ucc-groups'];

				if (
					$update_ucc_group_current && is_array( $update_ucc_group_current ) &&
					$update_ucc_group_new && is_array( $update_ucc_group_new )
				) {

					foreach ( $update_ucc_group_current as $i ) {
						if ( ! in_array( $i, $update_ucc_group_new ) ) {
							$group_meta = get_post_meta( $i, 'ld_ucc', true );
							if ( $group_meta && is_array( $group_meta ) && array_key_exists( $post_id, $group_meta ) ) {
								unset( $group_meta[ $post_id ] );
								update_post_meta( $i, 'ld_ucc', $group_meta );
							}
						}
					}
				}

				if (
					$update_ucc_group_new && is_array( $update_ucc_group_new )
				) {

					foreach ( $update_ucc_group_new as $k ) {

						$group_meta = get_post_meta( $k, 'ld_ucc', true );

						if ( ! is_array( $group_meta ) ) {
							$group_meta = array();
						}
						$group_meta_key                     = esc_html( $k );
						$group_meta[ esc_html( $post_id ) ] = esc_html( get_the_title( $post_id ) );
						update_post_meta( $k, 'ld_ucc', $group_meta );
						$update_ucc_group_data[] = $group_meta_key;

					}
				}
			} else {

				if ( is_array( $update_ucc_group_current ) ) {

					foreach ( $update_ucc_group_current as $f ) {

						$group_meta = update_post_meta( $f, 'ld_ucc', true );
						if ( $group_meta && is_array( $group_meta ) && array_key_exists( $post_id, $group_meta ) ) {
							unset( $group_meta[ $post_id ] );
							update_post_meta( $f, 'ld_ucc', $group_meta );
						}
					}
				}
			}

			$update_ucc_group = update_post_meta( $post_id, 'learndash-ucc-groups-data', $update_ucc_group_data );

		} else {

			return $post_id;

		}

	}

	public function add_meta_box_users_html( $object ) {

		wp_nonce_field( basename( __FILE__ ), 'lduuc-meta-users' );
		$users_list = $this->learndash_users_list;
		require_once UNIQUE_USER_CONTENT_PATH . 'admin/partials/meta-box-users.php';

	}

	public function save_meta_users( $post_id ) {

		if ( ! isset( $_POST['lduuc-meta-users'] ) || ! wp_verify_nonce( $_POST['lduuc-meta-users'], basename( __FILE__ ) ) ) { //phpcs:ignore
			return $post_id;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( isset( $_POST['post_type'] ) && 'unique-user-content' === $_POST['post_type'] ) {

			$update_ucc_user_data    = array();
			$update_ucc_user_current = get_post_meta( $post_id, 'learndash-ucc-users-data', true );

			if ( isset( $_POST['ld-ucc-users'] ) && '' != $_POST['ld-ucc-users'] ) {

				$update_ucc_user_new = $_POST['ld-ucc-users'];

				if (
					$update_ucc_user_current && is_array( $update_ucc_user_current ) &&
					$update_ucc_user_new && is_array( $update_ucc_user_new )
				) {

					foreach ( $update_ucc_user_current as $i ) {
						if ( ! in_array( $i, $update_ucc_user_new ) ) {
							$user_meta = get_user_meta( $i, 'ld_ucc', true );
							if ( $user_meta && is_array( $user_meta ) && array_key_exists( $post_id, $user_meta ) ) {
								unset( $user_meta[ $post_id ] );
								update_user_meta( $i, 'ld_ucc', $user_meta );
							}
						}
					}
				}

				if (
					$update_ucc_user_new && is_array( $update_ucc_user_new )
				) {

					foreach ( $update_ucc_user_new as $k ) {

						$user_meta = get_user_meta( $k, 'ld_ucc', true );

						if ( ! is_array( $user_meta ) ) {
							$user_meta = array();
						}
						$user_meta_key                     = esc_html( $k );
						$user_meta[ esc_html( $post_id ) ] = esc_html( get_the_title( $post_id ) );
						update_user_meta( $k, 'ld_ucc', $user_meta );
						$update_ucc_user_data[] = $user_meta_key;

					}
				}
			} else {

				if ( is_array( $update_ucc_user_current ) ) {

					foreach ( $update_ucc_user_current as $f ) {

						$user_meta = update_user_meta( $f, 'ld_ucc', true );
						if ( $user_meta && is_array( $user_meta ) && array_key_exists( $post_id, $user_meta ) ) {
							unset( $user_meta[ $post_id ] );
							update_user_meta( $f, 'ld_ucc', $user_meta );
						}
					}
				}
			}

			$update_ucc_user = update_post_meta( $post_id, 'learndash-ucc-users-data', $update_ucc_user_data );

		} else {

			return $post_id;

		}

	}
	/**
	 * Html for meta box
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function course_content_before( $course_id, $user_id ) {

		echo '<h2>User content</h2>';

	}

	/**
	 * Html for meta box
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function course_content_after( $course_id, $user_id ) {

		echo '<div>Course content after</div>';

	}

	public function add_unique_user_content_tab( $tabs = array(), $context = '', $course_id = 0, $user_id = 0 ) {
		$content = '';

		$content_id = get_post_meta( $course_id, 'ld_ucc', true );

		if ( is_array( $content_id ) ) {
			foreach ( $content_id as $key => $value ) {

				$user_has_access  = true;
				$group_has_access = false;

				$content_meta_users  = get_post_meta( $key, 'learndash-ucc-users-data', true );
				$content_meta_groups = get_post_meta( $key, 'learndash-ucc-groups-data', true );

				if ( ! empty( $content_meta_users ) || ! empty( $content_meta_groups ) ) {
					$user_has_access = false;
				}

				// $content_meta = get_post_meta($key);

				if ( $content_meta_users ) {
					foreach ( $content_meta_users as $i ) {
						if ( in_array( $user_id, $content_meta_users ) ) {
							$user_has_access = true;
							break;
						}
					}
				}

				if ( $content_meta_groups ) {
					foreach ( $content_meta_groups as $j ) {

						if ( learndash_is_user_in_group( $user_id, $j ) ) {
							$group_has_access = true;
							break;
						}
					}
				}

				if ( $user_has_access || $group_has_access ) {

					$content_raw = get_post( $key );
					if ( $content_raw ) {
						$content .= '<div class="ld_ucc_item_container">';
						$content .= '<h3>' . $content_raw->post_title . '</h3><span></span>';
						$content .= '<div class="ld_ucc_item_content">';
						$content .= $this->parse_content_through_the_content_filter( $content_raw );
						$content .= '</div>';
						$content .= '</div>';
					}
				}
			}
		}

		if ( ! isset( $tabs['ucc'] ) && ! empty( $content ) ) {
			$tabs['ucc'] = array(
				'id'      => 'unique-user-content-tab',
				'icon'    => 'dashicons-before dashicons-lock',
				'label'   => esc_html__( 'Unique Content', 'unique-user-content-learndash' ),
				'content' => $content,
			);
		}

		return $tabs;
	}

	public function delete_uuc_post( $postid, $post ) {

		if ( 'unique-user-content' !== $post->post_type ) {
			return;
		}

		$courses_array = get_post_meta( $postid, 'learndash-ucc-courses-data', true );

		if ( ! empty( $courses_array ) && is_array( $courses_array ) ) {

			foreach ( $courses_array as $i ) {

				$course_meta = get_post_meta( $i, 'ld_ucc', true );
				if ( $course_meta ) {

					if ( is_array( $course_meta ) && array_key_exists( $postid, $course_meta ) ) {
						unset( $course_meta[ $postid ] );
						update_post_meta( $i, 'ld_ucc', $course_meta );
					}
				}
			}
		}

		$groups_array = get_post_meta( $postid, 'learndash-ucc-groups-data', true );

		if ( ! empty( $groups_array ) && is_array( $groups_array ) ) {

			foreach ( $groups_array as $i ) {

				$groups_meta = get_post_meta( $i, 'ld_ucc', true );
				if ( $groups_meta ) {

					if ( is_array( $groups_meta ) && array_key_exists( $postid, $groups_meta ) ) {
						unset( $groups_meta[ $postid ] );
						update_post_meta( $i, 'ld_ucc', $groups_meta );
					}
				}
			}
		}

		$users_array = get_post_meta( $postid, 'learndash-ucc-users-data', true );

		if ( ! empty( $users_array ) && is_array( $users_array ) ) {

			foreach ( $users_array as $i ) {

				$users_meta = get_user_meta( $i, 'ld_ucc', true );
				if ( $users_meta ) {

					if ( is_array( $users_meta ) && array_key_exists( $postid, $users_meta ) ) {
						unset( $users_meta[ $postid ] );
						update_user_meta( $i, 'ld_ucc', $users_meta );
					}
				}
			}
		}

	}

	public function unique_user_content_func( $atts ) {

		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'unique_user_content'
		);

		$output         = '';
		$user_ucc_final = array();

		if ( '' == $atts['id'] ) {
			$user_id = get_current_user_id();

			$user_ucc    = get_user_meta( $user_id, 'ld_ucc', true );
			$user_groups = learndash_get_users_group_ids( $user_id, true );

			if ( $user_ucc && is_array( $user_ucc ) ) {

				foreach ( $user_ucc as $key => $value ) {

					$user_ucc_final[ $key ] = $value;

				}
			}

			if ( $user_groups && is_array( $user_groups ) ) {

				foreach ( $user_groups as $i ) {
					$user_groups_ucc = get_post_meta( $i, 'ld_ucc', true );
					if ( $user_groups_ucc && is_array( $user_groups_ucc ) ) {
						foreach ( $user_groups_ucc as $key => $value ) {
							$user_ucc_final[ $key ] = $value;
						}
					}
				}
			}

			foreach ( $user_ucc_final as $key => $value ) {

				$content_raw = get_post( $key );
				if ( $content_raw ) {
					$output .= '<div class="ld_ucc_item_container">';
					$output .= '<h3>' . $content_raw->post_title . '</h3><span></span>';
					$output .= '<div class="ld_ucc_item_content">';

					$output .= $this->parse_content_through_the_content_filter( $content_raw );

					$output .= '</div>';
					$output .= '</div>';
				}
			}
		} else {

			$user_id         = get_current_user_id();
			$user_has_access = false;
			$key             = $atts['id'];

			$content_meta_users  = get_post_meta( $key, 'learndash-ucc-users-data', true );
			$content_meta_groups = get_post_meta( $key, 'learndash-ucc-groups-data', true );

			if ( $content_meta_users ) {
				foreach ( $content_meta_users as $i ) {
					if ( in_array( $user_id, $content_meta_users ) ) {
						$user_has_access = true;
						break;
					}
				}
			}

			if ( $content_meta_groups ) {
				foreach ( $content_meta_groups as $j ) {
					if ( learndash_is_user_in_group( $user_id, $j ) ) {
						$user_has_access = true;
						break;
					}
				}
			}

			if ( $user_has_access ) {

				$content_raw = get_post( $atts['id'] );
				if ( $content_raw ) {
					$output .= '<div class="ld_ucc_item_container">';
					$output .= '<h3>' . $content_raw->post_title . '</h3><span></span>';
					$output .= '<div class="ld_ucc_item_content">';

					$output .= $this->parse_content_through_the_content_filter( $content_raw );

					$output .= '</div>';
					$output .= '</div>';
				}
			}
		}

		return $output;

	}

	public function parse_content_through_the_content_filter( $post_raw ){
		global $post;
		$post = $post_raw;
		$parsed_content = apply_filters( 'the_content', $post->post_content );
		wp_reset_postdata();
		return $parsed_content;
	}

}
