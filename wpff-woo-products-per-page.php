<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also initiates the plugin and contains necessary functions for WooCommerce filters.
 *
 * @link              https://wpfixfast.com
 * @since             1.0.0
 * @package           Wpff_Woo_Products_Per_Page
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Products per Page - WP Fix Fast
 * Plugin URI:        https://wpfixfast.com
 * Description:       Enables you to set a default number of products per page on your WooCommerce store.
 * Version:           1.0.0
 * Author:            WP Fix Fast
 * Author URI:        https://wpfixfast.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpff-woo-products-per-page
 * Domain Path:       /languages
 */


defined('ABSPATH') || exit;

define( 'PREFIX_BASE_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Init plugin
 */
add_action( 'plugins_loaded', 'wpff_load_plugin' );

function wpff_load_plugin() {

  // Set plugin locale
  $plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages';
  load_plugin_textdomain( 'wpff-woo-products-per-page', false, $plugin_rel_path );

  if (wpff_check_requirements()) {

    /**
     * Add settings link to plugins list
     */
    function plugin_add_settings_link( $links ) {
      $settings_link = '<a href="admin.php?page=wc-settings&tab=wpff_woo_products_per_page">' . __( 'Settings' ) . '</a>';
      array_unshift( $links, $settings_link );
      return $links;
    }
    $plugin = plugin_basename( __FILE__ );
    add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

    /**
     * Extend WooCommerce settings pages with custom settings tab
     */
    if( is_admin() ) {
      if ( class_exists('WC_Settings_Wpff_Woo_Products_Per_Page', false) ) {
        return new WC_Settings_Userfields();
      }
      
      add_filter('woocommerce_get_settings_pages', function($settings) {
        $settings[] = include_once PREFIX_BASE_PATH . 'includes/class-wpff-woo-products-per-page-wc-settings.php';
        return $settings;
      });
    }

    /**
     * Change the number of products displayed per page
     */
    add_filter( 'loop_shop_per_page', 'wpff_new_loop_shop_per_page', 99 );

    function wpff_new_loop_shop_per_page( $items ) {
      $wpff_products_per_page_items = (int)get_option('wpff_woo_products_per_page_items');
      if ($wpff_products_per_page_items > 0) {
        $items = $wpff_products_per_page_items;
      }

      return $items;
    }    

  }
}



/**
 * Check requirements
 */
function wpff_check_requirements() {
  if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
      return true;
  } else {
      add_action( 'admin_notices', 'wpff_missing_wc_notice' );
      return false;
  }
}

function wpff_missing_wc_notice() { 
  $class = 'notice notice-error';
  $message = __( 'WooCommerce Products per Page requires WooCommerce to be installed and active.', 'wpff-woo-products-per-page' );

  printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}
