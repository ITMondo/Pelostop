<?php
/**
 * WP Bootstrap Starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Bootstrap_Starter
 */
if ( ! function_exists( 'wp_bootstrap_starter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wp_bootstrap_starter_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WP Bootstrap Starter, use a find and replace
	 * to change 'wp-bootstrap-starter' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wp-bootstrap-starter', get_template_directory() . '/languages' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wp-bootstrap-starter' ),
		'primary-man' => esc_html__( 'Primary Man', 'wp-bootstrap-starter' ),

	    'top-header' => 'Top Header Menu',
		'top-header-man' => 'Top Header Menu Man',

		'sobre-pelostop-footer' => 'Sobre Pelostop Footer',
		'sobre-pelostop-footer-man' => 'Sobre Pelostop Footer Man',
		
		'legales-pelostop-footer' => 'Legales Pelostop Footer',
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wp_bootstrap_starter_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'wp_bootstrap_starter_setup' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_bootstrap_starter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_bootstrap_starter_content_width', 1170 );
}
add_action( 'after_setup_theme', 'wp_bootstrap_starter_content_width', 0 );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_bootstrap_starter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wp-bootstrap-starter' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-starter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'wp_bootstrap_starter_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_starter_scripts() {
	// load bootstrap css
	// load AItheme styles
	// load WP Bootstrap Starter styles
	wp_enqueue_style( 'wp-bootstrap-starter-style', get_stylesheet_uri() );
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery-ui','https://code.jquery.com/ui/1.12.1/jquery-ui.js' );
	wp_enqueue_style( 'jquery-ui-style', 'https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css');

    // Internet Explorer HTML5 support
    wp_enqueue_script( 'html5hiv',get_template_directory_uri().'/js/html5.js', array(), '3.7.0', false );
    wp_script_add_data( 'html5hiv', 'conditional', 'lt IE 9' );

	// load bootstrap js
	wp_enqueue_script('wp-bootstrap-starter-bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array() );
    wp_enqueue_script('wp-bootstrap-starter-themejs', get_template_directory_uri() . '/js/theme-script.js', array() );
	wp_enqueue_script( 'wp-bootstrap-starter-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_starter_scripts' );
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
    require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_filter('widget_text','do_shortcode');
add_action('admin_init', 'reg_tax');
function reg_tax() {
register_taxonomy_for_object_type('category', 'page');
add_post_type_support('page', 'category');
}


function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function pp_override_mce_options($initArray) {
   $opts = '*[*]';
   $initArray['valid_elements'] = $opts;
   $initArray['extended_valid_elements'] = $opts;
   return $initArray;
   } 
add_filter('tiny_mce_before_init', 'pp_override_mce_options');


require get_template_directory() . '/inc/functions/functions-pelostop-newsletter.php';
require get_template_directory() . '/inc/functions/functions-pelostop-promociones.php';
require get_template_directory() . '/inc/functions/functions-pelostop-mapasimagen.php';

require get_template_directory() . '/inc/functions/functions-pelostop-centros.php';

require get_template_directory() . '/inc/functions/functions-pelostop-ajustesadmin.php';

require get_template_directory() . '/inc/functions/functions-pelostop-woocomerce.php';
require get_template_directory() . '/inc/functions/functions-pelostop-reservacita.php';
/* Woocomerce */
require get_template_directory() . '/webservice/ws.php';

/*
function pelostop_woocommerce_test() {
   	callWSPelostop(1450);
}
add_action( 'admin_init', 'pelostop_woocommerce_test', 10, 1 );
*/


remove_filter( 'the_excerpt', 'wpautop' );

function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

function wpb_sender_email( $original_email_address ) {
    return 'noreply@pelostop.com';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'Pelostop';
}


// After registration, logout the user and redirect to home page
function custom_registration_redirect() {
    return get_permalink( get_option('woocommerce_myaccount_page_id') ).'?newuser=true';
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);

 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );
add_filter( 'send_email_change_email', '__return_false' );

add_filter('wc_realex_redirect_form_params','filter_realex_params');

function filter_realex_params($realex_args){
	
	global $wp;
    $order_id = $wp->query_vars['order-pay'];
    $order = new WC_Order( $order_id );

	$centro = getCentro( get_post_meta( $order->id, '_billing_centro_id', true ));
	
						if(count($centro)>0){

							  switch($centro['empresa']){
								case 'SDB ECI':$realex_args['ACCOUNT'] = 'SCBECIecommerce';break; 
								  case 'SBD ECI':$realex_args['ACCOUNT'] = 'SCBECIecommerce';break;
								case 'OCHAL LEVANTE':$realex_args['ACCOUNT'] = 'SCBecommerce';;break;
								case 'OCHAL SUR':$realex_args['ACCOUNT'] = 'SCBecommerce';break;
								case 'OCHAL MESETA':$realex_args['ACCOUNT'] = 'SCBecommerce';break;
								case 'OCHAL NORTE':$realex_args['ACCOUNT'] = 'SCBecommerce';break;
								default: $realex_args['ACCOUNT'] = 'SCBecommerce';break;
							  }
																					/*

							  switch($centro['empresa']){
								case 'SDB ECI':$realex_args['ACCOUNT'] = 'SBDECI';break; 
								case 'OCHAL LEVANTE':$realex_args['ACCOUNT'] = 'BVALENCIA0';;break;
								case 'OCHAL SUR':$realex_args['ACCOUNT'] = 'BVALENCIA0';break;
								case 'OCHAL MESETA':$realex_args['ACCOUNT'] = 'BVALENCIA0';break;
								case 'OCHAL NORTE':$realex_args['ACCOUNT'] = 'BVALENCIA0';break;
								default: $realex_args['ACCOUNT'] = 'BVALENCIA0';break;
							  }
				 	
							 switch($centro['empresa']){
								case 'SDB ECI':$realex_args['ACCOUNT'] = 'SBDECI';break; 
								case 'OCHAL LEVANTE':$realex_args['ACCOUNT'] = 'OLEVANTE';;break;
								case 'OCHAL SUR':$realex_args['ACCOUNT'] = 'OSUR';break;
								case 'OCHAL MESETA':$realex_args['ACCOUNT'] = 'OMESETA';break;
								case 'OCHAL NORTE':$realex_args['ACCOUNT'] = 'ONORTE';break;
								default: $realex_args['ACCOUNT'] = '';
							  }
							  */
							  
					}


	
	//print_r($realex_args);
	//$realex_args['ACCOUNT'] = '';
	return $realex_args;
	
	
	
}

function change_pay_icon( $gateways ) {
	
	
	
	if ( isset( $gateways['realex_redirect'] ) ) {
		$gateways['realex_redirect']->icon = wc_realex_redirect()->get_plugin_url() . '/assets/images/cards.png';
	}
	return $gateways;
}
add_filter( 'woocommerce_available_payment_gateways', 'change_pay_icon' );	

function register_my_menu() {
  register_nav_menu('new-menu',__( 'New Menu' ));
}
add_action( 'init', 'register_my_menu' );




//Limita las compras a 1 grupo por usuario registrado en base a variations ID
function pelostop_disable_repeat_purchase( $purchasable, $product ) {
	
	
	
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();





			// Get the ID for the current product (passed in)
			$product_id = $product->is_type( 'variation' ) ? $product->variation_id : $product->id;



			$groups = array(

			'groupIV'=>array(8558,8557,8559,8568,8569),
			'groupIII'=>array(8571,8570),
			'groupII'=>array(8574),
			'groupIIV'=>array(8573),
			'groupIIa'=>array(8572),
			'groupIVm'=>array(8587,8588,8589,8590,8591),
			'groupIIIm'=>array(8585,8586),
			'groupIIm'=>array(8582),
			'groupIIVm'=>array(8583),
			'groupIIma'=>array(8584),
				
			'feb3IV'=>array(9989),		
	    'feb3III'=>array(9990),		
	    'feb3IImm'=>array(9991),		
	    'feb3IIm'=>array(9992),		
	    'feb3II'=>array(9993),		
	    'feb3I'=>array(9994),
				
				'feb3IVman'=>array(10011),		
	    'feb3IIIman'=>array(10012),		
	    'feb3IImmman'=>array(10013),		
	    'feb3IImman'=>array(10014),		
	    'feb3IIman'=>array(10015),		
	    'feb3Iman'=>array(10016),	
			

			);


			//Comprobamos sobre producto comprado anteriormente
				foreach($groups as $clave=>$valor){
					foreach($groups[$clave] as $item){
						if($product_id==$item){ //Determinamos si está dentro de algún grupo
							//Comprobación de variación grupo comprado
							foreach($groups[$clave] as $id_variacion_grupo){
								if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $id_variacion_grupo ) ) {
									$purchasable = false;
									return $purchasable;
									break;
								}


							}
						}
					}
				}


				// Double-check for variations: if parent is not purchasable, then variation is not
				if ( $purchasable && $product->is_type( 'variation' ) ) {
					$purchasable = $product->parent->is_purchasable();
				}
	}
    return $purchasable;
}



function validacion_carrito($pass, $product_id, $quantity, $variation_id = 0) {
	global $woocommerce;
	
	
	
		$groups = array(
	
		'groupIV'=>array(8558,8557,8559,8568,8569),
		'groupIII'=>array(8571,8570),
		'groupII'=>array(8574),
		'groupIIV'=>array(8573),
		'groupIIa'=>array(8572),
		'groupIVm'=>array(8587,8588,8589,8590,8591),
		'groupIIIm'=>array(8585,8586),
		'groupIIm'=>array(8582),
		'groupIIVm'=>array(8583),
		'groupIIma'=>array(8584),
			
		'feb3IV'=>array(9989),		
	    'feb3III'=>array(9990),		
	    'feb3IImm'=>array(9991),		
	    'feb3IIm'=>array(9992),		
	    'feb3II'=>array(9993),		
	    'feb3I'=>array(9994),
			
		'feb3IVman'=>array(10011),		
	    'feb3IIIman'=>array(10012),		
	    'feb3IImmman'=>array(10013),		
	    'feb3IImman'=>array(10014),		
	    'feb3IIman'=>array(10015),		
	    'feb3Iman'=>array(10016),	
			
		);


	
	//Comprobamos sobre producto comprado anteriormente
			
	//Si está logado también comprobamos que no lo haya comprado con anterioridad
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			
			foreach($groups as $clave=>$valor){
				foreach($groups[$clave] as $item){
					if($variation_id==$item){ //Determinamos si está dentro de algún grupo
						//Comprobación de variación grupo comprado
						foreach($groups[$clave] as $id_variacion_grupo){
							if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $id_variacion_grupo ) ) {
								$pass = false;
							}
						}
					}
				}
			}
		}
	
	
	
	
	
	


	//Recorremos carrito
		foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$_product_cesta = $values;
				$_id_variacion_cesta  = $_product_cesta['variation_id'];
			
				
				//Recorremos grupo
				foreach($groups as $clave=>$valor){
					
					
					foreach($groups[$clave] as $item){
							
						
						
						if($variation_id==$item){ //Determinamos si está dentro de algún grupo
							
							
							//Comprobación de variación grupo comprado
							foreach($groups[$clave] as $id_variacion_grupo){

									if($_id_variacion_cesta==$id_variacion_grupo){
										$pass = false;
									}
								
								
									


							}
						}
					}
				}
	
								
		}
	
	
	
		if(!$pass){
			wc_add_notice('Lo sentimos, este producto no se puede comprar ya que la compra de esta promoción está limitada a un bono de cada grupo por persona. Puedes realizar una compra de cualquier otro grupo si lo deseas','error');

		}
	
		return $pass;
}


function limitar_cantidades($data, $product){
	
		
		$groups = array(
	
		'groupIV'=>array(8558,8557,8559,8568,8569),
		'groupIII'=>array(8571,8570),
		'groupII'=>array(8574),
		'groupIIV'=>array(8573),
		'groupIIa'=>array(8572),
		'groupIVm'=>array(8587,8588,8589,8590,8591),
		'groupIIIm'=>array(8585,8586),
		'groupIIm'=>array(8582),
		'groupIIVm'=>array(8583),
		'groupIIma'=>array(8584),
			
	    'feb3IV'=>array(9989),		
	    'feb3III'=>array(9990),		
	    'feb3IImm'=>array(9991),		
	    'feb3IIm'=>array(9992),		
	    'feb3II'=>array(9993),		
	    'feb3I'=>array(9994),		
		);

	
	 if (is_cart() && isset($product->variation_id)) {
				
					foreach($groups as $clave=>$valor){
							foreach($groups[$clave] as $item){
								if($item==$product->variation_id)$data['max_value']=1;
							}
					}
	 }
	
	return $data;
	
}


if(is_cart()){
add_filter('woocommerce_add_to_cart_validation', 'validacion_carrito', 10, 4);
add_filter( 'woocommerce_quantity_input_args', 'limitar_cantidades', 10, 2 ); 
}
else
{
	add_filter( 'woocommerce_variation_is_purchasable', 'pelostop_disable_repeat_purchase', 10, 2 );
	add_filter( 'woocommerce_is_purchasable', 'pelostop_disable_repeat_purchase', 10, 2 );
}
