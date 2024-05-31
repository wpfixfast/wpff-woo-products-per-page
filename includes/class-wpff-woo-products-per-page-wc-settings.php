<?php
/**
 * The admin-specific functionality of the plugin.
 * Extends WooCommerce settings page for Products per Page tab and settings
 *
 * @link       https://wpfixfast.com
 * @since      1.0.0
 *
 * @package    Wpff_Woo_Products_Per_Page
 * @subpackage Wpff_Woo_Products_Per_Page/admin
 * @author     Wp Fix Fast <support@wpfixfast.com> 
 */

class WC_Settings_Wpff_Woo_Products_Per_Page extends WC_Settings_Page 
{
	public function __construct() {
		$this->id    = 'wpff_woo_products_per_page';
		$this->label = __('Products per Page', 'wpff-woo-products-per-page');

		parent::__construct();
	}

	protected function get_settings_for_default_section() 
	{
		$settings = [
			[
				'type'  => 'title',
				'id'    => 'custom_ppp_fields',
				'title' => __('Products per Page', 'wpff-woo-products-per-page'),
				'desc'  => __('Set the default number of products per page displayed on WooCommerce Shop pages.', 'wpff-woo-products-per-page'),
			],
        [
          'type'     => 'number',
          'id'       => 'wpff_woo_products_per_page_items',
          'default'  => '30',
          'title'    => __('Default products per page', 'wpff-woo-products-per-page'),
          'desc_tip' => __('Number of products displayed per page in WooCommerce Shop pages (and product categories).', 'wpff-woo-products-per-page')
        ],
				[
					'type'     => 'checkbox',
					'id'       => 'wpff_woo_products_per_page_remove_data_on_uninstall',
					'default'  => '',
					'title'    => __('Remove plugin data when uninstalled', 'wpff-woo-products-per-page'),
					'desc'     => ''
				],
			['type'=>'sectionend','id'=>'custom_ppp_fields']
		];

		return apply_filters('woocommerce_userfields_settings', $settings);
	}

}

return new WC_Settings_Wpff_Woo_Products_Per_Page();