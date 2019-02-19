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
	 * Settings page ID for Elementor settings.
	 */
	const PAGE_ID = '';

		/**
		 * Tabs.
		 *
		 * Holds the settings page tabs, sections and fields.
		 *
		 * @access private
		 *
		 * @var array
		 */
	private $tabs;

		/**
		 * Get settings page title.
		 *
		 * Retrieve the title for the settings page.
		 *
		 * @since 1.5.0
		 * @access protected
		 *
		 * @return string Settings page title.
		 */
	protected function get_page_title() {
		return __( 'Shifter', 'shifter' );
	}

		/**
	 * Settings page general tab slug.
	 */
	const TAB_GENERAL = 'general';

		/**
	 * Settings page style tab slug.
	 */
	const TAB_STYLE = 'style';

		/**
	 * Settings page advanced tab slug.
	 */
	const TAB_ADVANCED = 'advanced';

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
						'fields' => [
							'disable_typography_schemes' => [
								'label'      => __( 'Disable Default Fonts', 'elementor' ),
								'field_args' => [
									'type'     => 'checkbox',
									'value'    => 'yes',
									'sub_desc' => __( 'Checking this box will disable Elementor\'s Default Fonts, and make Elementor inherit the fonts from your theme.', 'elementor' ),
								],
							],
						],
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
	 * Display settings page.
	 *
	 * Output the content for the settings page.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function display_settings_page() {
		$tabs = $this->get_tabs();
		?>
		<div class="wrap">
			<h1><?php echo $this->get_page_title(); ?></h1>
			<div id="elementor-settings-tabs-wrapper" class="nav-tab-wrapper">
				<?php
				foreach ( $tabs as $tab_id => $tab ) {
					if ( empty( $tab['sections'] ) ) {
						continue;
					}

					$active_class = '';

					if ( 'general' === $tab_id ) {
						$active_class = ' nav-tab-active';
					}

					echo "<a id='elementor-settings-tab-{$tab_id}' class='nav-tab{$active_class}' href='#tab-{$tab_id}'>{$tab['label']}</a>";
				}
				?>
			</div>
			<form id="elementor-settings-form" method="post" action="options.php">
				<?php
				settings_fields( static::PAGE_ID );

				foreach ( $tabs as $tab_id => $tab ) {
					if ( empty( $tab['sections'] ) ) {
						continue;
					}

					$active_class = '';

					if ( 'general' === $tab_id ) {
						$active_class = ' elementor-active';
					}

					echo "<div id='tab-{$tab_id}' class='elementor-settings-form-page{$active_class}'>";

					foreach ( $tab['sections'] as $section_id => $section ) {
						$full_section_id = 'elementor_' . $section_id . '_section';

						if ( ! empty( $section['label'] ) ) {
							echo "<h2>{$section['label']}</h2>";
						}

						if ( ! empty( $section['callback'] ) ) {
							$section['callback']();
						}

						echo '<table class="form-table">';

						do_settings_fields( static::PAGE_ID, $full_section_id );

						echo '</table>';
					}

					echo '</div>';
				}

				submit_button();
				?>
			</form>
		</div><!-- /.wrap -->
		<?php
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

