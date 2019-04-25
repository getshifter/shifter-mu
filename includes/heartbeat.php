<?php
/*
Plugin Name: Shifter – HeartBeat on SitePreview
Plugin URI: https://github.com/getshifter/shifter-heartbeat-on-sitepreview
Description: Send HeartBeat to detect editing.
Version: 1.0.3
Author: Shifter Team
Author URI: https://github.com/getshifter
License: GPLv2 or later
*/

namespace Shifter\MU\Heartbeat;

function shifter_heartbert_on_sitepreview_writeScript() {
  if (is_user_logged_in()) {
?>
<script>
function shifter_heartbert_getajax() {
  var xhr= new XMLHttpRequest();
  xhr.open("GET","/wp-admin/admin-ajax.php?action=nopriv_heartbeat");
  xhr.send();
}
setInterval("shifter_heartbert_getajax()",30000);
</script>
<?php
  }
}
add_action( 'wp_footer', 'shifter_heartbert_on_sitepreview_writeScript', 999 );
?>
