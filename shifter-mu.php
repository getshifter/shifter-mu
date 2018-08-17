<?php
/**
 *
 * @package   Shifter-MU
 * @author    Shifter
 * @license   GPL-3.0
 * @link      https://getshifter.io
 * @copyright DigitalCube
 *
 * @wordpress-plugin
 * Plugin Name:       Shifter-MU
 * Plugin URI:        https://github.com/getshifter/shifter-mu
 * Description:       Shifter MU Wrapper Plugin
 * Version:           0.1.0
 * Author:            Shifter
 * Author URI:        https://getshifter.io
 * Text Domain:       shifter-mu
 * License:           GPL-2.0
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */


namespace Shifter\MU;

function shifter_mu_admin_bar() {
  
  global $wp_admin_bar;

  $shifter_top_menu = '
    <span class="ab-icon">
      <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4QUQCAwVRk5ANwAAAeFJREFUOMu9lEFIVEEYx38zs7LiQSja7BAaHcIoaqGDslFIyEadYusU0cki6yAaBV0FD8kSBGlLeVEwIcgkKMukDmEYLLXtJamI7dihQ0Qs+t73psM+t0V9vidI32mGmfl98/2/+Y/Cj9nMSN6IHIiJgxEHI+6ftplrW9hgxGrGFqgLWIscmk2OWqDajGS1ZS0A5RpwGeBDR7824hITB+05Xut8llLystKeKCNuRW/XVUpZ2fZlogKczYzQOdl1LiBpCYgD9aAO+vMe4Ea1Mq0KWDkO2BhA52QXr07dw3jSqj25YMTJp6Z7J/wDiQoMwC7L0ABs93lvEp/H06t0OjZ1EavUDNAHPHiXzu6PINnXHQujR3/sPR8ofKL6hpRKhMB+WaP3ATR9GgsAWo4Aj4Du9hdXX68D+yi6fuvO4v2l9bpMx5NLeeAMwNsTt0hN961J21UYflpKXtnYww6C/YMO/R+nRPHruO/xOuB32OaVdmPu5G2lrBf3fxyMuN6yU4y4uuoOcW1zMbcY5YaNvg3jIRf5BhyKAiz7TmgMqe5hpKYcftazhGUwBOY1F3M3I3c59bx3AMvjtVkWqzgN8D3ZHQ04n87S9vJ6BjgLzAGLFn4COWDP7vd3pgBaCndXnf0LIlef9HGSOIAAAAAASUVORK5CYII=" alt="Shifter Icon" />
    </span>
    <span class="ab-label">Shifter</span>';

	$wp_admin_bar->add_menu(
    array(
      'id'    => 'shifter-mu-admin',
      'title' => $shifter_top_menu,
      'href'  => admin_url() . 'admin.php?page=shifter-mu-admin'
    )
  );
}

function shifter_mu_admin_page() {
  add_menu_page(
    __('Shifter', 'shifter-mu-admin'),
    __('Shifter', 'shifter-mu-admin'),
    'manage_options',
    'shifter-mu-admin',
    'Shifter\\MU\\shifter_mu_admin'
  );
  
}

function shifter_mu_admin() {
  echo "<div class='wrap'>";
  echo "<h1>" . __( 'Shifter', 'shifter-mu-admin' ) . "</h1>";
  echo "<p>If you have posts or comments in another system, WordPress can import those into this site. To get started, choose a system to import from below:</p>";
  echo "<div class='card'>
    <h2 class='title'>Generator Settings</h2>
    <span>Customize Shifter's static site generator settings for faster build times.</span>
    <p class='submit'><a class='button button-primary' href='admin.php?page=shifter-settings'>Customize</a></p>
  </div>";
  echo "</div>";
}

add_action('admin_menu', 'Shifter\\MU\\shifter_mu_admin_page');
add_action( 'wp_before_admin_bar_render', 'Shifter\\MU\\shifter_mu_admin_bar' );
