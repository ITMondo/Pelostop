<?php
//Helpers centros
function getProvincias(){
	
	global $wpdb;
		$r = $wpdb->get_col( $wpdb->prepare( "
				SELECT pm.meta_value AS provincia FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE pm.meta_key = 'provincia' 
				AND p.post_status = 'publish' 
				AND p.post_type = 'centro'
				GROUP BY pm.meta_value
				ORDER BY provincia ASC
			",array()) );	
			return $r;
}

function ps_ajax_getProvincias(){
	
	global $wpdb;
		$r = $wpdb->get_col( $wpdb->prepare( "
				SELECT pm.meta_value AS provincia FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE pm.meta_key = 'provincia' 
				AND p.post_status = 'publish' 
				AND p.post_type = 'centro'
				GROUP BY pm.meta_value
				ORDER BY provincia ASC
			",array()) );	
			

		print_r(json_encode($r));
		exit();

}




add_action('wp_ajax_getProvincias', 'ps_ajax_getProvincias');
add_action('wp_ajax_nopriv_getProvincias', 'ps_ajax_getProvincias'); 


//Llamadas ajax
function getPoblaciones(){
	
	global $wpdb;
	$arr_poblaciones = array();
	
	//$id_provincia = absint($_POST['id_provincia']);
	$id_provincia = sanitize_text_field($_REQUEST['id_provincia']);

	$r = $wpdb->get_results("SELECT wp_postmeta.meta_value AS poblacion
				FROM wp_postmeta
				WHERE wp_postmeta.meta_key = 'poblacion'
				AND wp_postmeta.post_id IN
				(SELECT ID
				FROM wp_posts
				LEFT JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID
				WHERE wp_posts.post_status = 'publish'
				AND wp_posts.post_type = 'centro'
				AND wp_postmeta.meta_key = 'provincia'
				AND wp_postmeta.meta_value = '".$id_provincia."')
				GROUP BY poblacion
				");
	print json_encode($r);
	exit(); 
}
add_action('wp_ajax_getPoblaciones', 'getPoblaciones');
add_action('wp_ajax_nopriv_getPoblaciones', 'getPoblaciones'); 



function getCentroPagos(){
	
	global $wpdb;
	
	$centro_id = (int)$_REQUEST['centro_id'];
	
	
	 $args = array(
	  'numberposts' => 1000,
	  'post_type'   => 'centro',
	  'orderby'   => 'meta_value',
      'meta_key'  => 'nombre_web',
      'order' => 'ASC',
	  'meta_query'=>array()
	);
	
	
	array_push($args['meta_query'],array('key'=>'centro_id','value'=>$centro_id));
	$centros = get_posts( $args );
	
	

	foreach($centros as $centro){
		
		$cen = array();
		$cen['paypal'] = get_post_meta( $centro->ID, 'venta_paypal', true );
		$cen['redsys'] = get_post_meta( $centro->ID, 'venta_redsys', true );
		$cen['addons'] = get_post_meta( $centro->ID, 'venta_addons', true );
		print json_encode($cen);
		exit(); 
	}

}
add_action('wp_ajax_getCentroPagos', 'getCentroPagos');
add_action('wp_ajax_nopriv_getCentroPagos', 'getCentroPagos'); 



function getCentro($centro_id,$ajax=true){
	
	
	global $wpdb;
	
		
	
	 $args = array(
	  'numberposts' => 1000,
	  'post_type'   => 'centro',
	  'orderby'   => 'meta_value',
      'meta_key'  => 'nombre_web',
      'order' => 'ASC',
	  'meta_query'=>array()
	);
	
	
	array_push($args['meta_query'],array('key'=>'centro_id','value'=>$centro_id));
	$centros = get_posts( $args );
	
	
	$arr_centros = array();

	foreach($centros as $centro){
		
		$cen = array();
		$cen['nombre'] = $centro->post_title;
		$cen['post_id'] = $centro->ID;
		$cen['centro_id'] = get_post_meta( $centro->ID, 'centro_id', true );
		$cen['nombre_web'] = get_post_meta( $centro->ID, 'nombre_web', true );
		$cen['calle'] = get_post_meta( $centro->ID, 'calle', true );
		$cen['numero'] = get_post_meta( $centro->ID, 'numero', true );
		$cen['cp'] = get_post_meta( $centro->ID, 'cp', true );
		$cen['poblacion'] = get_post_meta( $centro->ID, 'poblacion', true );
		$cen['provincia'] = get_post_meta( $centro->ID, 'provincia', true );
		$cen['telefono'] = get_post_meta( $centro->ID, 'telefono', true );
		$cen['email'] = get_post_meta( $centro->ID, 'email', true );
		$cen['horarios'] = get_post_meta( $centro->ID, 'horarios', true );	
		$cen['latitud'] = get_post_meta( $centro->ID, 'latitud', true );
		$cen['longitud'] = get_post_meta( $centro->ID, 'longitud', true );
		$cen['empresa'] = get_post_meta( $centro->ID, 'empresa', true );
		
		
		
		
		

		array_push($arr_centros,$cen);
		
		
	}

	
	return $arr_centros[0];
if($ajax){
exit();
}

}



function getCentrosByProvincia($provincia){
	
	
	global $wpdb;
	
	
	 $args = array(
	  'numberposts' => 1000,
	  'post_type'   => 'centro',
	  'orderby'   => 'meta_value',
      'meta_key'  => 'nombre_web',
      'order' => 'ASC',
	  'meta_query'=>array()
	);
	
	
		array_push($args['meta_query'],array('key'=>'provincia','value'=>$provincia));
	 
	$centros = get_posts( $args );
	
	
	$arr_centros = array();

	foreach($centros as $centro){
		
		$cen = array();
		$cen['nombre'] = $centro->post_title;
		$cen['post_id'] = $centro->ID;
		$cen['centro_id'] = get_post_meta( $centro->ID, 'centro_id', true );
		$cen['nombre_web'] = get_post_meta( $centro->ID, 'nombre_web', true );
		$cen['calle'] = get_post_meta( $centro->ID, 'calle', true );
		$cen['numero'] = get_post_meta( $centro->ID, 'numero', true );
		$cen['cp'] = get_post_meta( $centro->ID, 'cp', true );
		$cen['poblacion'] = get_post_meta( $centro->ID, 'poblacion', true );
		$cen['provincia'] = get_post_meta( $centro->ID, 'provincia', true );
		$cen['telefono'] = get_post_meta( $centro->ID, 'telefono', true );
		$cen['email'] = get_post_meta( $centro->ID, 'email', true );
		$cen['horarios'] = get_post_meta( $centro->ID, 'horarios', true );	
		$cen['latitud'] = get_post_meta( $centro->ID, 'latitud', true );
		$cen['longitud'] = get_post_meta( $centro->ID, 'longitud', true );
		$cen['empresa'] = get_post_meta( $centro->ID, 'empresa', true );

		array_push($arr_centros,$cen);
		
		
	}

	
	return $arr_centros;

exit();

}




function updateCentrosPago(){
	
	global $wpdb;
	$args = array(
	  'numberposts' => 10000,
	  'post_type'   => 'centro',
	  'orderby'   => 'meta_value',
      'meta_key'  => 'nombre_web',
      'order' => 'ASC',
	);
	
		$centros = get_posts( $args );
	
		foreach($centros as $centro){

				update_post_meta($centro->ID, 'venta_paypal', 1);
				update_post_meta($centro->ID, 'venta_redsys', 0);
				update_post_meta($centro->ID, 'venta_addons', 1);
			
		}
	
	
}

//updateCentrosPago();




function searchCentros(){
	
	
	global $wpdb;
	
		$id_provincia = sanitize_text_field($_REQUEST['id_provincia']);
		$id_poblacion = sanitize_text_field($_REQUEST['id_poblacion']);
		$id_cp = sanitize_text_field($_REQUEST['id_cp']);
	
	 $args = array(
	  'numberposts' => 1000,
	  'post_type'   => 'centro',
	  'orderby'   => 'meta_value',
      'meta_key'  => 'nombre_web',
      'order' => 'ASC',
	  'meta_query'=>array()
	);
	
	
	 if($id_provincia!=''){
		array_push($args['meta_query'],array('key'=>'provincia','value'=>$id_provincia));
	 }
	 
	
	 if($id_poblacion!=''){
		array_push($args['meta_query'],array('key'=>'poblacion','value'=>$id_poblacion));
	 }
	 
	
	 if($id_cp!=''){
		array_push($args['meta_query'],array('key'=>'cp','value'=>$id_cp));
	 }
	$centros = get_posts( $args );
	
	
	$arr_centros = array();

	foreach($centros as $centro){
		
		$cen = array();
		$cen['nombre'] = $centro->post_title;
		$cen['post_id'] = $centro->ID;
		$cen['centro_id'] = get_post_meta( $centro->ID, 'centro_id', true );
		$cen['nombre_web'] = get_post_meta( $centro->ID, 'nombre_web', true );
		$cen['calle'] = get_post_meta( $centro->ID, 'calle', true );
		$cen['numero'] = get_post_meta( $centro->ID, 'numero', true );
		$cen['cp'] = get_post_meta( $centro->ID, 'cp', true );
		$cen['poblacion'] = get_post_meta( $centro->ID, 'poblacion', true );
		$cen['provincia'] = get_post_meta( $centro->ID, 'provincia', true );
		$cen['telefono'] = get_post_meta( $centro->ID, 'telefono', true );
		$cen['email'] = get_post_meta( $centro->ID, 'email', true );
		$cen['horarios'] = get_post_meta( $centro->ID, 'horarios', true );	
		$cen['latitud'] = get_post_meta( $centro->ID, 'latitud', true );
		$cen['longitud'] = get_post_meta( $centro->ID, 'longitud', true );
		$cen['empresa'] = get_post_meta( $centro->ID, 'empresa', true );
		
		array_push($arr_centros,$cen);
		
		
	}

	
	print json_encode($arr_centros);

exit();

}
add_action('wp_ajax_searchCentros', 'searchCentros');
add_action('wp_ajax_nopriv_searchCentros', 'searchCentros'); 



//CREACION DE TIPO Y METABOX CENTROS
// La función no será utilizada antes del 'init'.
add_action( 'init', 'create_type_centros' );


function create_type_centros() {
        $labels = array(
        'name' => _x( 'Centros', 'post type general name' ),
        'singular_name' => _x( 'Centro', 'post type singular name' ),
        'add_new' => _x( 'Añadir nuevo', 'book' ),
        'add_new_item' => __( 'Añadir nuevo centro' ),
        'edit_item' => __( 'Editar centro' ),
        'new_item' => __( 'Nuevo centro' ),
        'view_item' => __( 'Ver centro' ),
        'search_items' => __( 'Buscar Centros' ),
        'not_found' =>  __( 'No se han encontrado Centros' ),
        'not_found_in_trash' => __( 'No se han encontrado Centros en la papelera' ),
        'parent_item_colon' => ''
    );
 
    // Creamos un array para $args
    $args = array( 'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );
 
    register_post_type( 'centro', $args ); 
}









//Metaboxes personalizados


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
	


add_action('init', 'centros_register_meta_fields');


function centros_register_meta_fields() {
	global $arr_centros;
	foreach($arr_centros as $centro){
			register_meta('post',$centro['id'],'sanitize_text_field', 'centros_custom_fields_auth_callback');
	}
}

function centros_meta_boxes() {
	add_meta_box('centros-meta-box', 'Datos del Centro', 'centros_meta_box_callback', 'centro', 'normal','high',array('arg'=>'value'));
}
add_action('add_meta_boxes', 'centros_meta_boxes' );

function centros_meta_box_callback($post){
    
     global $wpdb, $post, $arr_centros;
	foreach($arr_centros as $centro){
			
			print '<p><label class="label">'.$centro['nombre'].'</label><br/>';
			print '<input name="'.$centro['id'].'" id="'.$centro['id'].'" type="text" value="'.htmlspecialchars(get_post_meta($post->ID, $centro['id'], true)).'"></p>';
	}
}

add_action('save_post', 'guardar_centros');
add_action('publish_post', 'guardar_centros');

function guardar_centros() {
			 

	global $wpdb, $post, $arr_centros;
	
	$post_id = $_POST['post_ID'];
	if (!$post_id) return $post;


	foreach($arr_centros as $centro){
		
			update_post_meta($post_id, $centro['id'], $_REQUEST[$centro['id']]);
	}
}




function getCentros(){

	

 $args = array(
  'numberposts' => 1000,
  'post_type'   => 'centro',
 	'orderby'   => 'meta_value',
	'meta_key'  => 'nombre_web',
	'order' => 'ASC'
);
 
$centros = get_posts( $args );
$arr_centros = array();

foreach($centros as $centro){
	
	$cen = array();
	$cen['nombre'] = $centro->post_title;
	$cen['post_id'] = $centro->ID;
	$cen['nombre_web'] = get_post_meta( $centro->ID, 'nombre_web', true );
	$cen['calle'] = get_post_meta( $centro->ID, 'calle', true );
	$cen['numero'] = get_post_meta( $centro->ID, 'numero', true );
	$cen['cp'] = get_post_meta( $centro->ID, 'cp', true );
	$cen['poblacion'] = get_post_meta( $centro->ID, 'poblacion', true );
	$cen['provincia'] = get_post_meta( $centro->ID, 'provincia', true );
	$cen['telefono'] = get_post_meta( $centro->ID, 'telefono', true );
	$cen['email'] = get_post_meta( $centro->ID, 'email', true );
	$cen['horarios'] = get_post_meta( $centro->ID, 'horarios', true );	
	$cen['latitud'] = get_post_meta( $centro->ID, 'latitud', true );
	$cen['longitud'] = get_post_meta( $centro->ID, 'longitud', true );
	$cen['empresa'] = get_post_meta( $centro->ID, 'empresa', true );

	array_push($arr_centros,$cen);
}
?>
<div class="container-fluid centros">
  <div class="container">
    <div class="col-md-8 col-sm-12 buscador">
      <div class="row">
        <div class="col-md-12">
          <h4 class="pull-left">Localiza el Pelostop más cercano a tu posición actual</h4>
          <button class="btn black get-coords">Encontrar <i class="fa fa-map-marker" aria-hidden="true"></i></button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h4 class="gray-line">O si lo prefieres busca tu centro en la localidad que quieras</h4>
        </div>
        <div class="col-md-12">
          <form class="form-inline" id="centros_search">
            <div class="form-group">
              <select class="form-control" name="provincia" id="search_provincia">
                <option value="">Provincia...</option>
                <?php
				
					$r = getProvincias();
					foreach($r as $item){
						print '<option value="'.$item.'">'.$item.'</option>';	
					}
				
				?>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control" name="poblacion" id="search_poblacion">
                <option value="">Poblacion...</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Código Postal" id="search_cp"  />
            </div>
            <a class="btn black search" id="btn_search_centros"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
          </form>
        </div>
      </div>
      <div class="row resultados">
        <div class="loading_ps">
          <div id="circularG">
            <div id="circularG_1" class="circularG"></div>
            <div id="circularG_2" class="circularG"></div>
            <div id="circularG_3" class="circularG"></div>
            <div id="circularG_4" class="circularG"></div>
            <div id="circularG_5" class="circularG"></div>
            <div id="circularG_6" class="circularG"></div>
            <div id="circularG_7" class="circularG"></div>
            <div id="circularG_8" class="circularG"></div>
          </div>
        </div>
        <div class="listado col-md-5">
          <h5><span id="search_total_centros"><?php print count($centros);?></span> centro/s</h5>
          <ul>
       
          </ul>
        </div>
        <div class="mapa col-md-7">
          <div id="map"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-12 banner-atencion-cliente">
      <h2>¿Tienes alguna duda?</h2>
      <div class="caption">
        <p> Infórmate sin compromiso <strong>llamando<br/>
          o escribiendo un correo electrónico<br/>
          900 907 800 - calidad@pelostop.com</strong> </p>
        <a class="btn" href="<?php print get_site_url().'/departamento-de-calidad';?>">DEPARTAMENTO DE CALIDAD</a>
        <p class="legend"></p>
      </div>
    </div>
  </div>
 <script>
					  var map;
					  var icono = "<?php print get_template_directory_uri();?>/images/marker.png" ;
					  var markers = [];
					  var centros = <?php print json_encode($arr_centros);?>;
					  var centros_all = centros;
</script> 
  <script src="<?php print get_template_directory_uri();?>/js/pelostop-centros.js"></script> 
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA24ZNepwcNP5SMpj6FaZmov5bsWOEg6gs&callback=initMap">
    </script> 
</div>
	
<?php
}

add_shortcode('ps_centros','getCentros');
?>