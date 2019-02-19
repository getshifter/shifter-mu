<?php
/**
 *
 * Must-use WordPress Plugins for Shifter
 *
 * @package   shifter_wp_mu
 * @author    DigitalCube
 * @license   GPL-3.0
 * @link      https://getshifter.io
 * @copyright DigitalCube
 *
 * @wordpress-plugin
 * Plugin Name:       Shifter
 * Plugin URI:        https://github.com/getshifter/shifter-wp-mu
 * Description:       Must-use WordPress Plugins for Shifter
 * Version:           0.1.2
 * Author:            Shifter
 * Author URI:        https://getshifter.io
 * Text Domain:       shifter-wp-mu
 * License:           GPL-2.0
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SHIFTER_WP_MU_VERSION', '0.1.2' );
define( 'SHIFTER_WP_MU__FILE__', __FILE__ );
define( 'SHIFTER_WP_MU_PATH', plugin_dir_path( SHIFTER_WP_MU__FILE__ ) );

require SHIFTER_WP_MU_PATH . 'includes/plugin.php';
