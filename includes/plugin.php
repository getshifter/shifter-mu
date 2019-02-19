<?php

namespace Shifter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shifter.
 *
 * The main plugin handler class is responsible for initializing Shifter
 *
 * @since 1.0.0
 */
class Plugin {

		/**
		 * Instance.
		 *
		 * Holds the plugin instance.
		 *
		 * @since 1.0.0
		 * @access public
		 * @static
		 *
		 * @var Plugin
		 */
	public static $instance = null;

		/**
		 * Create tabs.
		 *
		 * Return the settings page tabs, sections and fields.
		 *
		 * @since 1.5.0
		 * @access protected
		 *
		 * @return array An array with the settings page tabs, sections and fields.
		 */
	protected function create_tabs() {

		return [
			self::TAB_GENERAL => [
				'label'    => __( 'General', 'elementor' ),
				'sections' => [
					'general' => [
						'fields' => [],
					],
				],
			],
		];
	}


		/**
	 * Get tabs.
	 *
	 * Retrieve the settings page tabs, sections and fields.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @return array Settings page tabs, sections and fields.
	 */
	final public function get_tabs() {
		$this->ensure_tabs();

		return $this->tabs;
	}

	/**
	 * Ensure tabs.
	 *
	 * Make sure the settings page has tabs before inserting any new sections or
	 * fields.
	 *
	 * @since 1.5.0
	 * @access private
	 */
	private function ensure_tabs() {
		if ( null === $this->tabs ) {
			$this->tabs = $this->create_tabs();
		}
	}

	/**
	 * Display settings page.
	 *
	 * Output the content for the settings page.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function display_settings_page() { ?>
<div class="wrap">
  <h1>Elementor</h1>
  <div id="elementor-settings-tabs-wrapper" class="nav-tab-wrapper">
    <a
      id="elementor-settings-tab-general"
      class="nav-tab nav-tab-active"
      href="#tab-general"
      >General</a
    ><a id="elementor-settings-tab-style" class="nav-tab" href="#tab-style"
      >Style</a
    >
  </div>
  <form
    id="elementor-settings-form"
    method="post"
    action="options.php#tab-general"
  >
    <input type="hidden" name="option_page" value="elementor" /><input
      type="hidden"
      name="action"
      value="update"
    /><input
      type="hidden"
      id="_wpnonce"
      name="_wpnonce"
      value="72456108aa"
    /><input
      type="hidden"
      name="_wp_http_referer"
      value="/wp-admin/admin.php?page=elementor"
    />
    <div id="tab-general" class="elementor-settings-form-page elementor-active">
      <table class="form-table">
        <tbody>
          <tr class="_elementor_settings_update_time">
            <th scope="row"></th>
            <td>
              <input
                type="hidden"
                id="_elementor_settings_update_time"
                name="_elementor_settings_update_time"
                value="1549931326"
                class="regular-text"
              />
            </td>
          </tr>
          <tr class="elementor_cpt_support">
            <th scope="row">Post Types</th>
            <td>
              <label>
                <input
                  type="checkbox"
                  name="elementor_cpt_support[]"
                  value="post"
                  checked="checked"
                />
                Posts </label
              ><br />
              <label>
                <input
                  type="checkbox"
                  name="elementor_cpt_support[]"
                  value="page"
                  checked="checked"
                />
                Pages </label
              ><br />
              <label>
                <input
                  type="checkbox"
                  name="elementor_cpt_support[]"
                  value="contribution"
                />
                Contributions </label
              ><br />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="tab-style" class="elementor-settings-form-page">
	  </div>
    <p class="submit">
      <input
        type="submit"
        name="submit"
        id="submit"
        class="button button-primary"
        value="Save Changes"
      />
    </p>
  </form>
</div>
		<?php
	}


	/**
	 * Register admin menu.
	 *
	 * Add new Elementor Settings admin menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_admin_menu() {
		global $menu;

		add_menu_page(
			__( 'Shifter', 'shifter' ),
			__( 'Shifter', 'shifter' ),
			'manage_options',
			'shifter',
			[ $this, 'display_settings_page' ]
		);
	}

		/**
		 * Instance.
		 *
		 * Ensures only one instance of the plugin class is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @access public
		 * @static
		 *
		 * @return Plugin An instance of the class.
		 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

		/**
		 * Settings page constructor.
		 *
		 * Initializing Elementor "Settings" page.
		 *
		 * @since 1.0.0
		 * @access public
		 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 20 );
	}
}

Plugin::instance();

