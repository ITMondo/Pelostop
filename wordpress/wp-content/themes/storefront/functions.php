<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version' => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce = require 'inc/woocommerce/class-storefront-woocommerce.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}


/**
 * Add a custom product tab.
 */
function custom_product_tabs( $tabs) {
	$tabs['giftcard'] = array(
		'label'		=> __( 'Gift Card', 'woocommerce' ),
		'target'	=> 'giftcard_options',
		'class'		=> array( 'show_if_simple', 'show_if_variable'  ),
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );
/**
 * Contents of the gift card options product tab.
 */
function giftcard_options_product_tab_content() {
	global $post;
	
	// Note the 'id' attribute needs to match the 'target' parameter set above
	?><div id='giftcard_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'><?php
			woocommerce_wp_checkbox( array(
				'id' 		=> '_allow_personal_message',
				'label' 	=> __( 'Allow the customer to add a personal message', 'woocommerce' ),
			) );
			woocommerce_wp_text_input( array(
				'id'				=> '_valid_for_days',
				'label'				=> __( 'Gift card validity (in days)', 'woocommerce' ),
				'desc_tip'			=> 'true',
				'description'		=> __( 'Enter the number of days the gift card is valid for.', 'woocommerce' ),
				'type' 				=> 'number',
				'custom_attributes'	=> array(
					'min'	=> '1',
					'step'	=> '1',
				),
			) );
		?></div>

	</div><?php
}
add_filter( 'woocommerce_product_data_panels', 'giftcard_options_product_tab_content' ); // WC 2.6 and up

/**
 * Save the custom fields.
 */
function save_giftcard_option_fields( $post_id ) {
	
	$allow_personal_message = isset( $_POST['_allow_personal_message'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_allow_personal_message', $allow_personal_message );
	
	if ( isset( $_POST['_valid_for_days'] ) ) :
		update_post_meta( $post_id, '_valid_for_days', absint( $_POST['_valid_for_days'] ) );
	endif;
	
}
add_action( 'woocommerce_process_product_meta_simple', 'save_giftcard_option_fields'  );
add_action( 'woocommerce_process_product_meta_variable', 'save_giftcard_option_fields'  );
