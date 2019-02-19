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
	const TAB_GENERATOR = 'generator';

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
			self::TAB_GENERAL   => [
				'label'    => __( 'General', 'shifter' ),
				'sections' => [
					'general' => [
						'fields' => [
							'generator_settings_card' => [
								'label'      => __( 'Generator Settings', 'shifter' ),
								'field_args' => [
									'target'   => '_blank',
									'rel'      => '',
									'sub_desc' => __( 'Customize your static site generator settings for faster build times.', 'shifter' ),
									'href'     => 'admin.php?page=shifter-settings',
								],
							],
							'support_card'            => [
								'label'      => __( 'Docs & Support', 'shifter' ),
								'field_args' => [
									'target'   => '',
									'rel'      => 'noopener noreferrer',
									'sub_desc' => __( 'Need help with something or have a question? Check out our documentation or contact support for more help.', 'shifter' ),
									'href'     => 'https://go.getshifter.io',
								],
							],
						],
					],
				],
			],
			self::TAB_GENERATOR => [
				'label'    => __( 'Generator', 'shifter' ),
				'sections' => [
					'generator' => [
						'fields' => [
							'generator_settings_card' => [
								'label'      => __( 'Generator Settings', 'shifter' ),
								'field_args' => [
									'target'   => '_blank',
									'rel'      => '',
									'sub_desc' => __( 'Customize your static site generator settings for faster build times.', 'shifter' ),
									'href'     => 'admin.php?page=shifter-settings',
								],
							],
							'support_card'            => [
								'label'      => __( 'Docs & Support', 'shifter' ),
								'field_args' => [
									'target'   => '',
									'rel'      => 'noopener noreferrer',
									'sub_desc' => __( 'Need help with something or have a question? Check out our documentation or contact support for more help.', 'shifter' ),
									'href'     => 'https://go.getshifter.io',
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

						foreach ( $section as $item_id => $item ) {
							foreach ( $item as $i ) {
								?>
								<div class='card'>
								<h2 class='title'><?php echo $i['label']; ?></h2>
								<span><?php echo $i['field_args']['sub_desc']; ?></span>
								<p class='submit'><a target='<?php echo $i['field_args']['target']; ?>' rel='<?php echo $i['field_args']['rel']; ?>' class='button button-primary' href='<?php echo $i['field_args']['href']; ?>'><?php echo $i['label']; ?></a></p>
								</div>
								<?php
							}
						}

						echo '</table>';
					}

					echo '</div>';
				}
				?>
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

