<?php

/**
 *
 * @link    https://www.getshifter.io
 * @since   0.1.0
 * @package Shifter Cache Helper
 *
 * @wordpress-plugin
 * Plugin Name:       Shifter Cache Helper
 * Plugin URI:        https://github.com/getshifter/shifter-cache-helper
 * Description:       Helper tool for caching plugins on Shifter.
 * Version:           0.1.0
 * Author:            DigitalCube
 * Author URI:        https://www.getshifter.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shifter-cache-helper
 * Domain Path:       /languages
 */

function shifter_cache_helper() {
  
  // Path to bootup file.
  $bootup = ABSPATH . '/.bootup';
  
  // Check if bootup file exists.
  if ( file_exists( $bootup ) ) {
    
    // Get time from bootup file.
    $time = file_get_contents( $bootup, true );
    
    // If the current time is newer.
    if ( $time > get_option('shifter_bootup_time') ) {
      
      // Update time.
      update_option('shifter_bootup_time', $time);
      
      // Run => Shifter Clear Plugin Cache.
      add_action('init', 'shifter_clear_plugin_cache');
    }
  }
}

/**
 * Shifter Clear Plugin Cache.
 * Clear the cache of commonly used plugins.
 */
function shifter_clear_plugin_cache() {

  /**
   * Autoptomize
   * @link  https://wordpress.org/plugins/autoptimize/
   * @since 2.5.1
   */
  if (class_exists('\autoptimizeCache')) {
    \autoptimizeCache::clearall();
  }

  /**
   * Beaver Builder Plugin
   * @link  https://www.wpbeaverbuilder.com
   * @since 2.2.6.1
   */
  if (class_exists('\FLBuilderModel')) {
    \FLBuilderModel::delete_asset_cache_for_all_posts();
  }
  
}

add_action('init', 'shifter_cache_helper');