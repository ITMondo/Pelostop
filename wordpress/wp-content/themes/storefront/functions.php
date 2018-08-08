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
	$tabs['centers'] = array(
		'label'		=> __( 'Centers', 'woocommerce' ),
		'target'	=> 'centers_options',
		//'class'		=> array( 'show_if_simple', 'show_if_variable'  ),
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
	?><div id='centers_options' class='panel woocommerce_options_panel'><?php
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


/**
   Center Post Type
 */
// var_dump(get_posts(array('post_type' => 'center')));



function create_post_type() {
  register_post_type( 'center',
                      array(
                          'labels' => array(
                              'name' => __( 'Centers' ),
                              'singular_name' => __( 'Center' )
                                            ),
                          'public' => true,
                          'has_archive' => true,
                          'supports' => array('title')
                            )
                      );
}
add_action( 'init', 'create_post_type' );

$arr_centros = array(
	array('id'=>'centro_id','nombre'=>'Centro ID'),
	array('id'=>'nombre_web','nombre'=>'Nombre Web'),
	array('id'=>'calle','nombre'=>'Calle'),
	array('id'=>'numero','nombre'=>'Número'),
	array('id'=>'puerta','nombre'=>'Puerta'),
	array('id'=>'cp','nombre'=>'Código Postal'),
	array('id'=>'poblacion','nombre'=>'Población'),
	array('id'=>'provincia','nombre'=>'Provincia'),
	array('id'=>'telefono','nombre'=>'Teléfono'),
	array('id'=>'email','nombre'=>'Email'),
	array('id'=>'horarios','nombre'=>'Horarios'),
	array('id'=>'latitud','nombre'=>'Latitud'),
	array('id'=>'longitud','nombre'=>'Longitud'),
	array('id'=>'empresa','nombre'=>'Grupo/Empresa'),
	array('id'=>'venta_paypal','nombre'=>'Paypal Disponible'),
	array('id'=>'venta_addons','nombre'=>'Addons Disponible'),
	array('id'=>'venta_redsys','nombre'=>'Redsys Disponible'),
                     );
function centros_register_meta_fields() {
  global $arr_centros;
  foreach($arr_centros as $centro){
    register_meta('post',$centro['id'],'sanitize_text_field');
  }
}
add_action('init', 'centros_register_meta_fields');

function centers_meta_boxes() {
  add_meta_box('centers-meta-box', 'Datos del Centro', 'centers_meta_box_callback', 'center', 'normal','high');
}
add_action('add_meta_boxes', 'centers_meta_boxes' );

function centers_meta_box_callback($post){
  global $wpdb, $post, $arr_centros;
  foreach($arr_centros as $centro){
    print '<p><label class="label">'.$centro['nombre'].'</label><br/>';
    print '<input name="'.$centro['id'].'" id="'.$centro['id'].'" type="text" value="'.htmlspecialchars(get_post_meta($post->ID, $centro['id'], true)).'"></p>';
  }
}

function save_center() {
  global $wpdb, $post, $arr_centros;
  $post_id = $_POST['post_ID'];
  if (!$post_id) return $post;


  foreach($arr_centros as $centro){
    update_post_meta($post_id, $centro['id'], $_REQUEST[$centro['id']]);
  }
}
add_action('save_post', 'save_center');
add_action('publish_post', 'save_center');

// single product page
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

function my_custom_action() {
  ?>
  <button>test</button>
  <?php
};
add_action( 'woocommerce_single_product_summary', 'my_custom_action', 30 );

