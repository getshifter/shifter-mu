<?php

/**
 * Helper functions for sitemap WordPress Plugins on Shifter
 *
 * @package Shifter_WordPress_Sitemaps
 * Plugin Name: Shifter WP Sitemaps
 * Plugin URI: https://github.com/getshifter/shifter-wp-sitemaps
 * Description: Helper functions for sitemap WordPress Plugins on Shifter
 * Version: 0.1.3
 * Author: DigitalCube
 * Author URI: https://getshifter.io
 * License: GPL-2.0
 */

namespace Shifter\MU\Sitemaps;

add_action(
	'plugins_loaded',
	function() {
		if ( ! function_exists( 'surbma_yoast_seo_sitemap_to_robotstxt_init' ) ) {
			add_filter(
				'robots_txt',
				function( $output ) {
					$options = get_option( 'wpseo_xml' );

					if ( class_exists( 'WPSEO_Sitemaps' ) && true === $options['enablexmlsitemap'] ) {
						$home_url = get_home_url();
						$output  .= "Sitemap: {$home_url}/sitemap_index.xml\n";
					}

					return $output;
				},
				9999,
				1
			);
		}
	}
);
