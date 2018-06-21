<?php
/**
 * WP-Reactivate
 *
 *
 * @package   Shifter-MU
 * @author    Shifter
 * @license   GPL-3.0
 * @link      https://getshifter.io
 * @copyright DigitalCube, Co. Ltd.
 *
 * @wordpress-plugin
 * Plugin Name:       Shifter-MU
 * Plugin URI:        https://github.com/getshifter/shifter-mu
 * Description:       MU Functions for WordPress Sites on Shifter
 * Version:           1.0.0
 * Author:            Shifter
 * Author URI:        https://getshifter.io
 * Text Domain:       shifter-mu
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */


namespace Shifter\WPR;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_REACTIVATE_VERSION', '1.0.0' );


/**
 * Autoloader
 *
 * @param string $class The fully-qualified class name.
 * @return void
 *
 *  * @since 1.0.0
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = __NAMESPACE__;

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/includes/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

/**
 * Initialize Plugin
 *
 * @since 1.0.0
 */
function init() {
	$wpr = Plugin::get_instance();
	$wpr_shortcode = Shortcode::get_instance();
    $wpr_admin = Admin::get_instance();
    $wpr_diag = Diag::get_instance();
	$wpr_rest = Endpoint\Example::get_instance();
}
add_action( 'plugins_loaded', 'Shifter\\WPR\\init' );


/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, array( 'Shifter\\WPR\\Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Shifter\\WPR\\Plugin', 'deactivate' ) );

