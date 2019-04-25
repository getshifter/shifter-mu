<?php
/*
Plugin Name: Shifter – Dashboard Timer
Plugin URI: https://github.com/getshifter/shifter-dashboard-timer
Description: Notice before terminating Shifter Container
Version: 1.2.2
Author: Shifter Team
Author URI: https://getshifter.io
License: GPL2
*/

namespace Shifter\MU\Timer;

function notice_shifter_dashboard_timer() {
  $bootup_filename = '../.bootup';
  $hard_limit = 180;
  if (file_exists($bootup_filename)) {
  $unixtime = file_get_contents($bootup_filename, true);
  $shifter_remain = $hard_limit - round((time() - intval($unixtime)) / 60);
  if ( $shifter_remain < 3 ) {
?>
<div class="error"><ul>
Notice: Shifter will power down WordPress in few minutes. Please restart your from the Shifter Dashboard.
</ul></div>
<?php
  } elseif ( $shifter_remain < 30 ) {
?>
<div class="error"><ul>
Notice: Shifter will power down WordPress in <?php echo $shifter_remain ?> minutes. Please restart your from the Shifter Dashboard.
</ul></div>
<?php
}}
}
  add_action( 'admin_notices', __NAMESPACE__ . '\\notice_shifter_dashboard_timer' );
?>
