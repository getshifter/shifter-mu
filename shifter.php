<?php
/**
 *
 * @package   Shifter
 * @author    Shifter
 * @license   GPL-3.0
 * @link      https://getshifter.io
 * @copyright DigitalCube
 *
 * @wordpress-plugin
 * Plugin Name:       Shifter
 * Plugin URI:        https://github.com/getshifter/shifter-mu
 * Description:       Shifter MU-Plugin Wrapper
 * Version:           0.1.2
 * Author:            Shifter
 * Author URI:        https://getshifter.io
 * Text Domain:       shifter-mu
 * License:           GPL-2.0
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */


namespace Shifter\MU;

 /** Shifter Admin */
require_once __DIR__ . '/admin/shifter-admin.php';

/** Shifter Cron */
require_once __DIR__ . '/includes/shifter-cron.php';