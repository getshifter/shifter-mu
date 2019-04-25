<?php

/*
Plugin Name: Shifter - Redis cache patch.
Plugin URI: https://github.com/getshifter/shifter-redis-cache-fix
Description: Fixes option updates.
Version: 0.1.0
Author: Shifter Team
Author URI: https://github.com/getshifter
License: GPLv2 or later
*/

namespace Shifter\MU\Redis;

class redis_cache_fix {
    public function __construct() {
        add_action( 'add_option',    array( $this, 'option_cache_flush' ) );
        add_action( 'update_option', array( $this, 'option_cache_flush' ) );
        add_action( 'delete_option', array( $this, 'option_cache_flush' ) );
    }

    // flush cache after update_option, delete_option.
    public function option_cache_flush($option, $old_value = '', $value = ''){
        if ( !empty( $option ) ) {
            wp_cache_delete( $option, 'options' );
            foreach (array('alloptions','notoptions') as $options_name) {
                $options = wp_cache_get( $options_name, 'options' );
                if ( ! is_array($options) ) {
                    $options = array();
                }
                if ( isset($options[$option]) ) {
                    unset($options[$option]);
                    wp_cache_set( $options_name, $options, 'options' );
                }
                unset($options);
            }
        }
        return;
    }
};
new redis_cache_fix();