<?php 
global $post;

add_action( 'init', 'ps_remove_wc_breadcrumbs' );
function ps_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count',20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering',30);
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 10000;
  return $cols;
}




//Menu con mapa de Tratamientos

add_action('woocommerce_before_main_content',function(){global $pid,$post;$pid=$post->post_name;});

add_action('woocommerce_before_shop_loop','addMapa',1);
function addMapa(){
	add_menu_tratamientos();

	print mapaImagen(array('seccion'=>'tratamientos-'.$_SESSION['PS_SITE']));
	print '</div>';
	print '<script src="'.get_template_directory_uri().'/js/pelostop-tratamientos.js"></script>';
}

add_action( 'woocommerce_before_single_product_summary', 'add_menu_tratamientos',1 );
function add_menu_tratamientos() {
	
	global $post, $pid;

	$arr_html;
	

	if(!is_shop() && isPack($post->ID)){
		return;	
	}


		$terms = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'slug'=>$_SESSION['PS_SITE'],
			'parent'=>0
		) );	
		

		

	if($terms){
?>		
	<div class="col-md-4 menu_tratamientos" id="menu-tratamientos" >
	<aside>
    <h2>Qué quieres depilarte</h2>
    <div class="hr">    
    <hr>
    </div>

    <h4>Elije tu tratamiento</h4>
	<ul class="hidden-sm hidden-xs">

<?php
					
			$ps_category = $terms[0];
			
			$sub_categories = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent'=>$ps_category->term_id,
			) );	
			
			
			
			$count = 0;
			
			foreach($sub_categories as $sub_cat){
				
				
				
				if($sub_cat->slug != 'pack' && $sub_cat->slug != 'promocion' && $sub_cat->slug != 'pack-man' && $sub_cat->slug != 'promocion-man'){
			
					print '<li>'.$sub_cat->name;
					
					$arr_html[$count]['name'] = $sub_cat->name;
					$arr_html[$count]['items'] = array();
					
						print '<ul class="products">';
						$ps_products = get_posts(array(
						  'post_type' => 'product',
						  'numberposts' => -1,
						  'orderby'=>'menu_order',
						  'order'=>'ASC',
						  'tax_query' => array(
							array(
							  'taxonomy' => 'product_cat',
							  'field' => 'term_id',
							  'terms' => $sub_cat->term_id, // Where term_id of Term 1 is "1".
							  'include_children' => false
							)
						  )
						));
						
				
				
						foreach ( $ps_products as $ps_product ) {
							
							$class="";
							

							$selected = false;
							if($ps_product->post_name == $post->post_name){
								$class='class="current_page_item"';	
								$selected = true;
							}
							
							array_push($arr_html[$count]['items'],array('nombre'=>$ps_product->post_title,'url'=>get_the_permalink($ps_product->ID),'selected'=>$selected));
							
							print '<li '.$class.'><a class="product" data-id="'.$ps_product->post_name.'" href="'.get_the_permalink($ps_product->ID).'">'.$ps_product->post_title.'</a></li>';
						}
				
						print '</ul>';
				
				print '</li>';
				
				}
				
			$count++;	
			}
			
			

?>
    </ul>
    
 <select id="sel_tratamientos" class="hidden-md hidden-lg">   
 <?php
 
 	foreach($arr_html as $htmlCat){
		
		print '<optgroup label="'.$htmlCat['name'].'">';
		
			foreach($htmlCat['items'] as $htmlItem){
				
				if($htmlItem['selected']){
					$sel='selected="selected"';	
				}
				else
				{
					$sel = '';	
				}
				
				print '<option value="'.$htmlItem['url'].'" '.$sel.' >'.$htmlItem['nombre'].'</option>';
			}
		
		
		print '</optgroup>';

		
	}
 
 
 ?>   
 </select>
    
    
    
    
    </aside>
	</div>
    <div class="col-md-8 producto-detalles">

<?php		
	}

}








//Eliminaciones Woocomerce


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );








//Campos extra de producto



// Add Variation Settings
add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );

// Save Variation Settings
add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );

add_filter ('woocommerce_product_related_posts_relate_by_category', function () {
    return false;
});



function variation_settings_fields( $loop, $variation_data, $variation ) {
	
	// Number Field
	woocommerce_wp_text_input( 
		array( 
			'id'          => '_ps_precio_sesion[' . $variation->ID . ']', 
			'label'       => __( 'Precio por sesión (Solo bonos)', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Precio a mostrar por sesión para Bonos.', 'woocommerce' ),
			'value'       => get_post_meta( $variation->ID, '_ps_precio_sesion', true ),
			'custom_attributes' => array(
							'step' 	=> 'any',
							'min'	=> '0'
						) 
		)
	);
	woocommerce_wp_text_input( 
		array( 
			'id'          => '_ps_variacion_notaprecio[' . $variation->ID . ']', 
			'label'       => __( 'Nota precio', 'woocommerce' ), 
			'placeholder' => 'Nota aclaratoria precio',
			'desc_tip'    => 'true',
			'description' => __( 'Nota aclaratoria precio', 'woocommerce' ),
			'value'       => get_post_meta( $variation->ID, '_ps_variacion_notaprecio', true )
		)
	);

}

/**
 * Save new fields for variations
 *
*/
function save_variation_settings_fields( $post_id ) {

	
	
	// Number Field
	$_ps_precio_sesion = $_POST['_ps_precio_sesion'][ $post_id ];
	if( ! empty( $_ps_precio_sesion ) ) {
		update_post_meta( $post_id, '_ps_precio_sesion', esc_attr( $_ps_precio_sesion ) );
	}
	// Text Field
	$_ps_variacion_notaprecio = $_POST['_ps_variacion_notaprecio'][ $post_id ];
	if( ! empty( $_ps_variacion_notaprecio ) ) {
		update_post_meta( $post_id, '_ps_variacion_notaprecio', esc_attr( $_ps_variacion_notaprecio ) );
	}
}

// Add New Variation Settings
add_filter( 'woocommerce_available_variation', 'load_variation_settings_fields' );
/**
 * Add custom fields for variations
 *
*/
function load_variation_settings_fields( $variations ) {
	
	// duplicate the line for each field
	$variations['ps_variacion_titulo'] = get_post_meta( $variations[ 'variation_id' ], '_ps_variacion_titulo', true );
	$variations['ps_precio_sesion'] = get_post_meta( $variations[ 'variation_id' ], '_ps_precio_sesion', true );
	$variations['ps_variacion_notaprecio'] = get_post_meta( $variations[ 'variation_id' ], '_ps_variacion_notaprecio', true );
	
	return $variations;
}



//Metaboxes personalizados para producto


$arr_campos = array(
	array('id'=>'ps_tipoid','nombre'=>'Tipo ID/SKU', 'tipo'=>'texto'),

	array('id'=>'ps_subtitulo','nombre'=>'Subtitulo', 'tipo'=>'texto'),
	array('id'=>'ps_notaprecios','nombre'=>'Nota precios', 'tipo'=>'textarea'),
	array('id'=>'ps_descripcion_precio','nombre'=>'Descripción Precio', 'tipo'=>'texto'),
	array('id'=>'ps_condiciones','nombre'=>'Condiciones', 'tipo'=>'textarea'),
	array('id'=>'ps_pack_widget_subtitulo','nombre'=>'Pack Widget Subtitulo', 'tipo'=>'texto'),
	
);
	
add_action('init', 'productos_register_meta_fields');


function productos_register_meta_fields() {
	global $arr_campos;
	foreach($arr_campos as $item){
			register_meta('product',$item['id'],'sanitize_text_field', 'productos_custom_fields_auth_callback');
	}
}

function productos_meta_boxes() {
	add_meta_box('productos-meta-box', 'Otros datos del Producto', 'productos_meta_box_callback', 'product', 'normal','high',array('arg'=>'value'));
}
add_action('add_meta_boxes', 'productos_meta_boxes' );

function productos_meta_box_callback($post){
    
     global $wpdb, $post, $arr_campos;
	foreach($arr_campos as $item){
			if($item['tipo']=='texto'){
			print '<p><label class="label">'.$item['nombre'].'</label><br/>';
			print '<input name="'.$item['id'].'" id="'.$item['id'].'" type="text" value="'.htmlspecialchars(get_post_meta($post->ID, $item['id'], true)).'"></p>';
			}
			if($item['tipo']=='textarea'){
				
			print '<p><label class="label">'.$item['nombre'].'</label><br/>';
			 wp_editor( htmlspecialchars_decode( get_post_meta($post->ID, $item['id'] , true ) ), 'metabox_'. $item['id'], $settings = array('textarea_name'=>'txt_area_'.$item['id']) );	
				
			//print '<p><label class="label">'.$item['nombre'].'</label><br/>';
			//print '<textarea style="width:100%" name="'.$item['id'].'" id="'.$item['id'].'">'.htmlspecialchars(get_post_meta($post->ID, $item['id'], true)).'</textarea></p>';
			}
	}
}

add_action('save_post', 'guardar_producto');
add_action('publish_post', 'guardar_producto');

function guardar_producto() {
			 

	global $wpdb, $post, $arr_campos;
	
	$post_id = $_POST['post_ID'];
	if (!$post_id) return $post;


	foreach($arr_campos as $item){
			if($item['tipo']=='textarea'){
				
			update_post_meta($post_id, $item['id'], htmlspecialchars($_REQUEST['txt_area_'.$item['id']]));
			}
			else
			{
			update_post_meta($post_id, $item['id'], htmlspecialchars($_REQUEST[$item['id']]));
			}
	}
}






//Checkout campos

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

$arr_como_conociste = array('3'=>'Ns/nc',
		'1'=>'Revistas',
		'2'=>'Radio',
		'4'=>'Buzoneo',
		'9'=>'Escaparate',
		'26'=>'Tv',
		'44'=>'Exterior',
		'54'=>'Nsm@s',
		'56'=>'Referenciado',
		'62'=>'Cine',
		'64'=>'Redes Sociales',
		'65'=>'Cheque Regalo',
		'66'=>'Colectivos',
		'67'=>'Eventos/Ferias',
		'68'=>'Internet');
 
function custom_override_checkout_fields( $fields ) {
	
	
	global $arr_como_conociste;
     
unset($fields['billing']['billing_postcode']);

unset($fields['billing']['billing_company']);
unset($fields['billing']['billing_country']);
unset($fields['billing']['billing_address_1']);
unset($fields['billing']['billing_address_2']);

unset($fields['billing']['billing_city']);

unset($fields['billing']['billing_state']);

unset($fields['order']);




	


    $fields2['billing']['billing_first_name'] = $fields['billing']['billing_first_name'];
    $fields2['billing']['billing_last_name'] = $fields['billing']['billing_last_name'];
	$fields2['billing']['billing_documento_identificacion'] = array(
	 'type'=>'text',
    'label'     => __('NIF/DNI/Pasaporte', 'woocommerce'),
    'placeholder'   => _x('NIF/DNI/Pasaporte', 'placeholder', 'woocommerce'),
    'required'  => true,
    'class'     => array('form-group'),
    'clear'     => false
     );
		
	$fields2['billing']['billing_email'] = $fields['billing']['billing_email'];
	$fields2['billing']['billing_phone'] = $fields['billing']['billing_phone'];
	
	$fields2['billing']['billing_como_conociste'] = array(
	 'type'=>'select',
    'label'     => __('¿Como nos conociste?', 'woocommerce'),
    'required'  => true,
    'class'     => array('form-group'),
    'clear'     => false,
	'options' => $arr_como_conociste
     );
	$fields2['billing']['billing_centro_id'] = array(
	 'type'=>'hidden',
	    'label'     => __('Centro', 'woocommerce'),
 
    'required'  => true,
    'class'     => array('form-group'),
    'clear'     => false,
     );
	$fields2['account'] = $fields['account'];
	$fields2['account']['account_repassword'] = array(
	
	 'type'=>'password',
	 'label'     => __('Repetir contraseña', 'woocommerce'),
	 'placeholder'     => __('Repetir contraseña', 'woocommerce'),
    'required'  => true,
    'clear'     => false,
	
	
	);
	
	 foreach ($fields2 as &$fieldset) {
        foreach ($fieldset as $field) {
            // if you want to add the form-group class around the label and the input
            $field['class'][] = 'form-group'; 

            // add form-control to the actual input
            $field['input_class'][] = 'form-control';
        }
    }

//return $fields2;



return $fields2;
 
}


 add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

 function my_custom_checkout_field_update_order_meta($order_id) {
	 
	 
	 
	 
	 if(is_user_logged_in()){
		 
		 $order = new WC_Order( $order_id );
		 $user_id = $order->user_id;
		 
			update_usermeta( $user_id, 'ps_user_centro', $_POST['billing_centro_id'] );
			update_usermeta( $user_id, 'ps_user_como_conociste', $_POST['billing_como_conociste'] );
	 };
	 
	 
	 


	if (!empty($_POST['billing_documento_identificacion'])) {
		update_post_meta($order_id, 'billing_documento_identificacion', esc_attr($_POST['billing']['billing_documento_identificacion']));
	}
	if (!empty($_POST['billing_centro_id'])) {
		update_post_meta($order_id, 'billing_centro_id', esc_attr($_POST['billing']['billing_centro_id']));
	}
	if (!empty($_POST['billing_como_conociste'])) {
		update_post_meta($order_id, 'billing_como_conociste', esc_attr($_POST['billing']['billing_como_conociste']));
	}
 }

add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	
	global $arr_como_conociste;
	
    echo '<p><strong>'.__('DNI/NIF/Pasaporte').':</strong> ' . get_post_meta( $order->id, '_billing_documento_identificacion', true ) . '</p>';
	
	$centro = getCentro( get_post_meta( $order->id, '_billing_centro_id', true ));
	
	    echo '<p><strong>'.__('Centro').':</strong> ' . $centro['centro_id'].'<br/>'.$centro['calle'];
		
		if($centro['numero']!=''){
			print ', '.$centro['numero'];	
		}
		
		print '.<br/>'.$centro['cp'].' '.$centro['poblacion'].' ('.$centro['provincia'].')<br/>'.$centro['telefono'].'<br/>'.$centro['email'].'</p>';
	    echo '<p><strong>'.__('¿Como nos conociste?').':</strong> ' . $arr_como_conociste[get_post_meta( $order->id, '_billing_como_conociste', true )] . '</p>';
		echo '<p><strong>'.__('IDS Venta Pelostop').':</strong> ' . get_post_meta( $order->id, 'ps_ws_idventa', true ) . '</p>';
		echo '<p><strong>'.__('Transaction ID Realex').':</strong> ' . get_post_meta( $order->id, '_realex_payment_reference', true ) . '</p>';

}


// hide coupon field on cart page
function hide_coupon_field_on_checkout( $enabled ) {
if ( is_checkout() ) {
$enabled = false;
}
return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout');



//Checkout seleccion de centro
function checkout_seleccion_centro(){
	

	
	$provincias = getProvincias();

	$user_centro = false;
	$user_como_conociste = false;	
	
	if(is_user_logged_in()){
	 
		 
		if($user_id = get_current_user_id()){
		
			$user_meta =  get_user_meta( $user_id );
  			$user_centro = $user_meta['ps_user_centro'][0];
		  	$user_como_conociste = $user_meta['ps_user_como_conociste'][0];
			if($user_centro!=''){
			$user_centro = getCentro($user_centro);	
			}
	
			
		}
		
	}

	
    // check if we need to fix the centers
    $has_special_product = false;
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    foreach($items as $item => $values) { 
      $_product =  wc_get_product( $values['data']->get_id()); 
      $id = $_product->get_id();
      if ($id == 11097 or $id == 11098 or $id == 11102 or $id == 11106 or $id == 11110 or $id == 11118 or $id == 11114 or $id == 11346 or $id == 11346
          or $id == 11853 or $id == 11854 or $id == 11855 or $id == 11856 or $id == 11857 or $id == 11858 or $id == 12219 or $id == 12220 or $id == 12221
      or $id == 12222 or $id == 12223 or $id == 12224) {
        $has_special_product = true;
      }
    } 

    if($has_special_product) {

      $provinces = array();
      // array_push($provinces, "A CORUÑA");
      // array_push($provinces, "ASTURIAS");
      // array_push($provinces, "BARCELONA");
      // array_push($provinces, "CORDOBA");
      // array_push($provinces, "GUIPÚZCOA");
      // array_push($provinces, "JAÉN");
      // array_push($provinces, "MADRID");
      // array_push($provinces, "SALAMANCA");
      // array_push($provinces, "SEGOVIA");
      // array_push($provinces, "SEVILLA");
      // array_push($provinces, "TARRAGONA");
      // array_push($provinces, "ZARAGOZA");
      // 30.06.2018
      array_push($provinces, "OVIEDO");
      array_push($provinces, "SAN SEBASTIAN");
      array_push($provinces, "VIGO");
      array_push($provinces, "BURGOS");
      $provincias = $provinces;

      $centers = array();
      // array_push($centers, 154);
      // array_push($centers, 51);
      // array_push($centers, 146);
      // array_push($centers, 121);
      // array_push($centers, 99);
      // array_push($centers, 132);
      // array_push($centers, 144);
      // array_push($centers, 163);
      // array_push($centers, 175);
      // array_push($centers, 179);
      // array_push($centers, 147);
      // array_push($centers, 143);
      // array_push($centers, 101);
      // array_push($centers, 102);
      // array_push($centers, 151);

      // array_push($centers, 117);
      // array_push($centers, 124);
      // array_push($centers, 145);
      // array_push($centers, 97);
      // array_push($centers, 96);
      // array_push($centers, 137);
      // array_push($centers, 122);
      // array_push($centers, 98);
      // array_push($centers, 24);

      // 30.06.2018
      array_push($centers, 102);
      array_push($centers, 101);
      array_push($centers, 151);
      array_push($centers, 39);
      array_push($centers, 158);


    }

	
?>
<div class="checkout-item">
<h3>SELECCIONA TU CENTRO</h3>




<form class="form-inline">
    <div class="form-group">
    <select class="form-control" id="ps_provincia">
    <option value="">Provincia...</option>
            <?php
	
				foreach($provincias as $provincia){
					
					if($user_centro){
						$selected = false;
						if($user_centro['provincia']==$provincia){
							$selected = 'selected="selected"';	
						}
					}
					
					
					print '<option '.$selected.' value="'.$provincia.'">'.$provincia.'</option>';	
					
				}
    
			?>
        </select>
  </div>
   <div class="form-group">
  		<select class="form-control" id="ps_centro">
        	<option value="">Centro...</option>
            <?php
				if($user_centro){
					
					
					$centros = getCentrosByProvincia($user_centro['provincia']);
					

					
					foreach($centros as $centro){
                      if(!$has_special_product || in_array($centro['centro_id'], $centers)) {
							$selected = false;
							if($user_centro['centro_id']==$centro['centro_id']){
								$selected = 'selected="selected"';	
							}
						
						
						print '<option '.$selected.' value="'.$centro['centro_id'].'">'.$centro['nombre_web'].' ('.$centro['calle'];
						if($centro['numero']!=''){
						print ', '.$centro['numero'];		
						}
						print ')</option>';

                      }
					}

				}
			
			?>
            
            
            
        </select>
  </div> </form>



<script>
	
jQuery( function ( $ ) {
	
	
function updatePaymentsMethod(){
	
		var centro_seleccionado = $( "#ps_centro option:selected" ).val();
					
					//Obtenemos datos de pago de centro seleccionado
					$.ajax({
												type: "POST",
												url: base_url+"/wp-admin/admin-ajax.php", 
												data: {'action':'getCentroPagos', 'centro_id':centro_seleccionado },
												dataType: "json",
												success: function(respuesta){
													
													
														if(parseInt(respuesta['paypal'])==1){
															$(".payment_method_paypal").css("cssText", "display: block !important;");
															$("input#payment_method_paypal").prop('checked', true);

														}
														else
														{
															$(".payment_method_paypal").css("cssText", "display: none !important;");
															$("input#payment_method_paypal").prop('checked', false);

														}
													
													
														if(parseInt(respuesta['redsys'])==1){
															$(".payment_method_redsys").css("cssText", "display: block !important;");
															$("input#payment_method_redsys").prop('checked', true);

														}
														else
														{
															$(".payment_method_redsys").css("cssText", "display: none !important;");
															$("input#payment_method_redsys").prop('checked', false);

														}
													
														if(parseInt(respuesta['addons'])==1){
															$(".payment_method_realex_redirect").css("cssText", "display: block !important;");
															$("input#payment_method_realex_redirect").prop('checked', true);

														}
														else
														{
															$(".payment_method_realex_redirect").css("cssText", "display: none !important;");
															$("input#payment_method_realex_redirect").prop('checked', false);

														}
													
		
												},
												error: function(msg){
													console.log(msg.statusText);
												}
					 }); 
					
	
	
	
}	
	
	
	
	
	
	
	
	

			
	
	
				<?php
				if($user_centro){
					?>
					$("input#billing_centro_id").val('<?php print $user_centro['centro_id'];?>');
					$("select#billing_como_conociste").val('<?php print $user_meta['ps_user_como_conociste'][0];?>');
				<?php	
				}
				?>
	
	
				$( 'body' ).on( 'updated_checkout', function() {
					
					updatePaymentsMethod();
				
				});
				
				
	
	
							 $("select#ps_provincia").on('change',function(e){
								
										var	id_provincia =  $( "#ps_provincia option:selected" ).val();
										$("select#ps_centro").html('<option value="">Centro...</option>');	

										$("input#billing_centro_id").val('');
										if(id_provincia!=''){								
										
												$.ajax({
												type: "POST",
												url: base_url+"/wp-admin/admin-ajax.php", 
												data: {'action':'searchCentros', 'id_provincia':id_provincia },
												dataType: "json",
												success: function(centros){
													
														var html = '<option value="">Centro...</option>';

                                                        // var centers = ['154', '51', '146', '121', '99', '132', '144', '163', '175', '179', '147', '143', '101', '102', '151', '127', '124', '145', '97', '96', '137', '122', '98', '24', '102', '101', '151', '39', '158'];

                                                        var centers = ['102', '101', '151', '39', '158'];
														for (var i in centros) {

									 						var obj = centros[i];
                                                            // DIRK STFU
                                                            if( '<?php echo $has_special_product; ?>' == "" || centers.includes(obj.centro_id) ) {
                                                              html+='<option value="'+obj.centro_id+'">'+obj.nombre_web+' ('+obj.calle;
                                                              if(obj.numero!=''){
                                                                html+=', '+obj.numero;	
                                                              }
                                                              html+=')</option>';

                                                              $("select#ps_centro").html(html);	
                                                            }
														}
		
												},
												error: function(msg){
													console.log(msg.statusText);
												}
											 }); 
											 
										}
										else
										{
											$("select#ps_centro").html('<option value="">Centro...</option>');	
										}
								 
								 
							 });
							 
							 $("select#ps_centro").on('change',function(e){
								

										var	id_centro =  $( "#ps_centro option:selected" ).val();
 
										if(id_centro!=''){								
										
									
											$("input#billing_centro_id").val(id_centro);
											 
										}
										else
										{
											$("input#billing_centro_id").val('');
										}
								 
								 		//Actualizamos checkout al cambiar centro
								 		$( 'body' ).trigger( 'update_checkout' );

								 
								 
							 });
});
</script>





</div>	
	
<?php	
}


add_action('woocommerce_before_checkout_form','checkout_seleccion_centro',1);



function reduce_woocommerce_min_strength_requirement( $strength ) {
    return 2;
}
add_filter( 'woocommerce_min_password_strength', 'reduce_woocommerce_min_strength_requirement' );

add_action('woocommerce_checkout_process', 'ps_validate_chechout_fields');

function ps_validate_chechout_fields() {
	 
	 if(isset($_REQUEST['createaccount']) && (int)$_REQUEST['createaccount']==1){
		 
		 if($_REQUEST['account_password']!= $_REQUEST['account_repassword']){
	 	         wc_add_notice(__('<strong>Contraseña</strong> Los campos de contraseña no coinciden'), 'error');
		 }
		 
	 }
	 

}




//Datos de usuario extras
add_action( 'show_user_profile', 'ps_campos_extra_usuario' );
add_action( 'edit_user_profile', 'ps_campos_extra_usuario' );

function ps_campos_extra_usuario( $user ) { ?>

	<h3>Información adicional</h3>

	<table class="form-table">
    <tr>
			<th><label for="twitter">NIF/DNI/PASAPORTE</label></th>

			<td>
				<input type="text" name="ps_user_documento_identificacion" id="ps_user_documento_identificacion" value="<?php echo esc_attr( get_the_author_meta( 'billing_documento_identificacion', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="twitter">¿Cómo nos conociste?</label></th>

			<td>
				<input type="text" name="ps_user_como_conociste" id="ps_user_como_conociste" value="<?php echo esc_attr( get_the_author_meta( 'ps_user_como_conociste', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>

	</table>
    
    
	<h3>Centro</h3>

	<table class="form-table">
		<tr>
			<th><label for="twitter">Centro</label></th>

			<td>
				<input type="text" name="ps_user_centro" id="ps_user_centro" value="<?php echo esc_attr( get_the_author_meta( 'ps_user_centro', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>

	</table>
<?php }

add_action( 'personal_options_update', 'save_ps_campos_extra_usuario' );
add_action( 'edit_user_profile_update', 'save_ps_campos_extra_usuario' );

function save_ps_campos_extra_usuario( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'ps_user_centro', $_POST['ps_user_centro'] );
	update_usermeta( $user_id, 'ps_user_como_conociste', $_POST['ps_user_como_conociste'] );
	update_usermeta( $user_id, 'billing_documento_identificacion', $_POST['ps_user_documento_identificacion'] );
}


add_filter( 'woocommerce_paypal_args' , 'custom_override_paypal_email', 10, 2 );

function custom_override_paypal_email( $paypal_args, $order ) {
    
	$centro = getCentro( get_post_meta( $order->id, '_billing_centro_id', true ));

	if(count($centro)>0){
		      switch($centro['empresa']){
				case 'SDB ECI': $paypal_args['business'] = 'tesoreriacentros@pelostop.com';break;
				case 'SBD ECI': $paypal_args['business'] = 'tesoreriacentros@pelostop.com';break;
				default:  $paypal_args['business'] = 'tesoreria@pelostop.com';break;  
			  }
	}
	else
	{
		return false;	
	}

    return $paypal_args;
}




add_action('before_woocommerce_pay','html_antes_pago');

function html_antes_pago(){
	
	
		print '<div class="container cart-breadcrumb">';
		print'<div class="row">	
		<div class="col-md-4 step">
		1.RESUMEN
		</div>
		<div class="col-md-4 step">
		2. ACCESO
		</div>
		<div class="col-md-4 step">
		<strong>3. PAGO</strong>
		</div></div></div>
		<div class="text-center detail-payment col-md-9">
		';
			
		}
add_action('after_woocommerce_pay','html_despues_pago');

function html_despues_pago(){
	
		print '</div>';
		print '<div class="col-md-3 ps_woosidebar">';
				get_sidebar();
		print '</div>';		
}

add_filter( 'woocommerce_payment_complete_order_status', 'virtual_order_payment_complete_order_status', 10, 2 );
 
function virtual_order_payment_complete_order_status( $order_status, $order_id ) {
  $order = new WC_Order( $order_id );
 
  if ( 'processing' == $order_status &&
       ( 'on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status ) ) {
 
      return 'completed';
  }
 
}





//Emails woocomerce
function ps_display_customer_details($fields, $sent_to_admin, $order ) {
	
	
	
	
	$fields['nombre_cliente'] = array(
	'label' => __('Nombre y apellidos', 'woocommerce'),
	);
	$fields["nombre_cliente"]["value"] = esc_html( $order->get_billing_first_name() ).' '.esc_html( $order->get_billing_last_name() );

	$fields['nif_dni'] = array(
	'label' => __('NIF/DNI/Pasaporte', 'woocommerce'),
	);
	$fields["nif_dni"]["value"] = esc_html( get_post_meta( $order->id, '_billing_documento_identificacion', true ) );


	$centro = getCentro( get_post_meta( $order->id, '_billing_centro_id', true ));
	
	    
	
	
		$centro_value = $centro['calle'];
		
		if($centro['numero']!=''){
			$centro_value.= ', '.$centro['numero'];	
		}
		
		$centro_value.= '.<br/>'.$centro['cp'].' '.$centro['poblacion'].' ('.$centro['provincia'].')<br/>'.$centro['telefono'].'<br/>'.$centro['email'];
	
	
	$fields['centro'] = array(
	'label' => __('Centro Pelostop', 'woocommerce'),
	);
	$fields["centro"]["value"] = $centro_value;
	
	
	$fields2['nombre_cliente'] = $fields['nombre_cliente'];
	$fields2['nif_dni'] = $fields['nif_dni'];
	$fields2['billing_phone'] = $fields['billing_phone'];
	$fields2['billing_email'] = $fields['billing_email'];
	$fields2['centro'] = $fields['centro'];
	
	
	return $fields2;
	
}
add_filter( 'woocommerce_email_customer_details_fields', 'ps_display_customer_details', 40, 3);



function isPack($id){

global $post;
$is_pack = false;
$terms = get_the_terms( $post->ID, 'product_cat' );
	foreach ($terms as $term) {
		if($term->slug == 'pack' || $term->slug == 'promocion' || $term->slug == 'promocion-man'   || $term->slug == 'pack-man'){
				$is_pack = true;
		}
	}
	
	return $is_pack;
	
	
}




	
add_action( 'widgets_init', 'ps_sidebar_packs' );
function ps_sidebar_packs() {
    register_sidebar( array(
        'name' => __( 'Packs Sidebar', 'ps' ),
        'id' => 'sidebar-packs',
        'description' => __( 'Sidebar Especifico para Packs', 'ps' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '<div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</div>',
    ) );
}	




if ( ! function_exists( 'attribute_slug_to_title' ) ) {
	function attribute_slug_to_title( $attribute ,$slug ) {
		global $woocommerce;
		if ( taxonomy_exists( esc_attr( str_replace( 'attribute_', '', $attribute ) ) ) ) {
			$term = get_term_by( 'slug', $slug, esc_attr( str_replace( 'attribute_', '', $attribute ) ) );
			if ( ! is_wp_error( $term ) && $term->name )
				$value = $term->name;
		} else {
			$value = apply_filters( 'woocommerce_variation_option_name', $value );
		}
		return $value;
	}
}




//Cambio tasas para centro de Andorra
add_action( 'woocommerce_checkout_update_order_review', 'bbloomer_taxexempt_checkout_based_on_zip');
 
function bbloomer_taxexempt_checkout_based_on_zip( $post_data ) {
	
        global $woocommerce;
		
		parse_str($post_data);
		
		
	
		if($billing_centro_id==178){
        $woocommerce->customer->set_shipping_location( 'AD' );
		}
		else
		{
        $woocommerce->customer->set_shipping_location( 'ES' );
		}
        //if ( $billing_postcode == '32444' ) $woocommerce->customer->set_is_vat_exempt( true );
}

add_filter( 'woocommerce_adjust_non_base_location_prices', '__return_false' );


