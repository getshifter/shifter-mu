<?php
/**
 * Shifter-MU
 *
 *
 * @package   Shifter-MU
 * @author    Shifter
 * @license   GPL-3.0
 * @link      https://getshifter.io
 * @copyright DigitalCube, Co. Ltd.
 */

namespace Shifter\WPR;

require("api/shifter-api.php");

/**
 * @subpackage Admin
 */
class Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Plugin basename.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_basename = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		$plugin = Plugin::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$this->version = $plugin->get_plugin_version();

		$this->plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
	}


	/**
	 * Handle WP actions and filters.
	 *
	 * @since 	1.0.0
	 */
	private function do_hooks() {
		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add plugin to WP Admin Bar
		add_action("wp_before_admin_bar_render", array( $this, 'add_plugin_admin_bar' ) );

		// Add plugin action link point to settings page
		add_filter( 'plugin_action_links_' . $this->plugin_basename, array( $this, 'add_action_links' ) );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug . '-style', plugins_url( 'assets/css/admin.css', dirname( __FILE__ ) ), array(), $this->version );
		}
	}

	/**
	 * Register and enqueue admin-specific javascript
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {

			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', dirname( __FILE__ ) ), array( 'jquery' ), $this->version );

			wp_localize_script( $this->plugin_slug . '-admin-script', 'wpr_object', array(
				'api_nonce'   => wp_create_nonce( 'wp_rest' ),
				'api_url'	  => rest_url( $this->plugin_slug . '/v1/' ),
				)
			);
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the Settings menu.
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'WP Reactivate', $this->plugin_slug ),
			__( 'WP Reactivate', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		?><div id="wp-reactivate-admin"></div><?php
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {
		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>',
			),
			$links
		);
	}

		/**
	 * Add WP Admin Bar
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_bar() {
			$local_class = getenv("SHIFTER_LOCAL") ? "disable_shifter_operation" : "";
			global $wp_admin_bar;
			$shifter_support = array(
				"id" => "shifter_support",
				"title" => '<span id="shifter-support-top-menu">Shifter</span>'
			);
			$shifter_support_back_to_shifter_dashboard = array(
				"id"    => "shifter_support_back_to_shifter_dashboard",
				"title" => "Back to Shifter Dashboard",
				"parent" => "shifter_support",
				"href" => $api->shifter_dashboard_url
			);
			$shifter_support_terminate = array(
				"id"    => "shifter_support_terminate",
				"title" => "Terminate app",
				"parent" => "shifter_support",
				"href" => "#",
				"meta" => array("class" => $local_class)
			);
			$shifter_support_generate = array(
				"id"    => "shifter_support_generate",
				"title" => "Generate artifact",
				"parent" => "shifter_support",
				"href" => "#",
				"meta" => array("class" => $local_class)
			);

			$wp_admin_bar->add_menu($shifter_support);
			$wp_admin_bar->add_menu($shifter_support_back_to_shifter_dashboard);
			$wp_admin_bar->add_menu($shifter_support_terminate);
			$wp_admin_bar->add_menu($shifter_support_generate);
	}



} // The End
