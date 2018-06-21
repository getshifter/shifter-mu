<?php
/**
 * Shifter-MU: Diag Widget
 *
 *
 * @package   Shifter-MU-Diag
 * @author    Shifter
 * @license   GPL-3.0
 * @link      https://getshifter.io
 * @copyright DigitalCube, Co. Ltd.
 */

namespace Shifter\WPR;

/**
 * @subpackage Diag
 */
class Diag {

			/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @var      object
		 */
		protected static $instance = null;

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
	 * Initialize the widget
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$plugin = Plugin::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$this->version = $plugin->get_plugin_version();

		$widget_ops = array(
			'description' => esc_html__( 'WP Reactivate demo widget.', $this->plugin_slug ),
		);
	}

		/**
	 * Handle WP actions and filters.
	 *
	 * @since 	1.0.0
	 */
	private function do_hooks() {
		add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ) );
	}

	// Function that outputs the contents of the dashboard widget
	public function dashboard_widget_function( $post, $callback_args ) {
		include("diag/diag.php");
	}

	// Function used in the action hook
	public function add_dashboard_widgets() {
		wp_add_dashboard_widget('dashboard_widget', 'Shifter', array( $this, 'dashboard_widget_function' ) );
	}
	
}







