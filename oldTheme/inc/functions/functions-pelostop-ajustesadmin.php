<?php
function my_custom_menu() {
	add_menu_page ( 'Ajustes Pelostop', 'Pelostop Ajustes', 'manage_options', 'pelostop-opciones', 'pelostop_settings_page', '', 101);
	add_menu_page ( 'Importar Usuarios', 'Pelostop Usuarios', 'manage_options', 'importar-usuarios', 'pelostop_importar_usuarios_page', '', 101);
	add_action( 'admin_init', 'register_pelostop_settings' );
}
add_action( 'admin_menu', 'my_custom_menu');
function register_pelostop_settings() {
	//register our settings
	register_setting( 'register_pelostop_settings_group', 'years_home' );
	register_setting( 'register_pelostop_settings_group', 'nota_home' );
	register_setting( 'register_pelostop_settings_group', 'clientes_home' );
	register_setting( 'register_pelostop_settings_group', 'fecha_home' );
	
	
}
function pelostop_settings_page(){
	?>
	<div class="wrap">
<h1>Your Plugin Name</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'register_pelostop_settings_group' ); ?>
    <?php do_settings_sections( 'register_pelostop_settings_group' ); ?>
    <h2>Home</h2>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Años depilación</th>
        <td><input type="text" name="years_home" value="<?php echo esc_attr( get_option('years_home') ); ?>" /></td>
        </tr>
         <tr valign="top">
        <th scope="row">Nota Clientes</th>
        <td><input type="text" name="nota_home" value="<?php echo esc_attr( get_option('nota_home') ); ?>" /></td>
        </tr>
         <tr valign="top">
        <th scope="row">Nº Clientes</th>
        <td><input type="text" name="clientes_home" value="<?php echo esc_attr( get_option('clientes_home') ); ?>" /></td>
        </tr>
          <tr valign="top">
        <th scope="row">Fecha datos</th>
        <td><input type="text" name="fecha_home" value="<?php echo esc_attr( get_option('fecha_home') ); ?>" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php	
}
//Insertar usuarios
function insertUsuarios(){
ini_set('auto_detect_line_endings', true);

$datos = array();
	
	$init = (int)$_REQUEST['init'];
	$total = (int)$_REQUEST['total'];
	$nombrearchivo = $_REQUEST['file'];
	$max = 100;
	
	$urlcsv = dirname(__FILE__)."/users/".$nombrearchivo;
	$file = fopen($urlcsv,'r');
		while (($line = fgetcsv($file, 0, ";", "\"", "\"")) !== FALSE) {
		  //$line is an array of the csv elements
		 array_push($datos,$line);
		}
		
		
	//Cuantos registros leeremos
	
	
	
	
	
	if($init==$total){
		
		$end_items = $init+1;
	}
	elseif($init<$total){
		
		$end_items = $init+$max;
		
		if($end_items>$total+1){
			$end_items = $total+1;	
		}
		
	}
	
	$arr_insertados = array();
	
	for($x=$init;$x<$end_items;$x++){
		
		array_push($arr_insertados,$datos[$x]);
		
		$obj = $datos[$x];
				$item['user_login'] = sanitize_text_field($obj[0]);
				$item['user_email'] = sanitize_email($obj[1]);
				$item['first_name'] = sanitize_text_field($obj[2]);
				$item['last_name'] = sanitize_text_field($obj[3]);
				$item['display_name'] = sanitize_text_field($obj[2]).' '.sanitize_text_field($obj[3]);
				$item['ps_user_documento_identificacion'] = sanitize_text_field($obj[4]);
				$item['ps_user_centro'] = (int)$obj[5];
				$item['billing_phone'] = sanitize_text_field($obj[6]);
				$item['ps_user_como_conociste'] = (int)$obj[7];
				$item['user_pass'] = sanitize_text_field($obj[8]);
				$item['role'] = 'customer';
				
				
				
					$user_id = username_exists($item['user_login'] );
					if ( !$user_id and email_exists($item['email']) == false && $creados <= $max_creados ) {
							
							  $user_id = wp_insert_user( $item ) ;
							  update_user_meta( $user_id, 'billing_documento_identificacion', $item['ps_user_documento_identificacion'], true );
							  update_user_meta( $user_id, 'ps_user_centro', $item['ps_user_centro'], true );
							  update_user_meta( $user_id, 'billing_phone', $item['billing_phone'], true );
							  update_user_meta( $user_id, 'ps_user_como_conociste', $item['ps_user_como_conociste'], true );
							 update_user_meta( $user_id, 'last_name', $item['last_name'], true );

					}
	}

	print json_encode(array('init'=>$x,'metidos'=>10));	
		
		
	fclose($file);	
	exit();

}
add_action('wp_ajax_insertUsuarios', 'insertUsuarios');
add_action('wp_ajax_nopriv_insertUsuarios', 'insertUsuarios'); 


function pelostop_importar_usuarios_page(){ ?>
<?php
ini_set('auto_detect_line_endings', true);
$error = false;
$upload = false;

	if(isset($_FILES['archivo'])){
		
		
		      $filename = $_FILES['archivo']['tmp_name'];
			  if($_FILES['archivo']['type']=='text/csv'){
				  
				  		$namefile = "ps_user_upload_".wp_generate_password(40,false,false).".csv";
				  		$nombre_archivo = dirname(__FILE__)."/users/".$namefile;
						

				  
						if (move_uploaded_file($_FILES['archivo']['tmp_name'], $nombre_archivo)){
						   $upload = true;
						}else{
						   print 'Error al guardar';
						   print $nombre_archivo;
						   $error = true;
						} 
				  
				  
			  }
			  else
			  {
				 print 'El archivo no es válido';
				 $error = true;
			  }
			  
			  
			  
			  if($upload){
				
				//Abrimos archivo y extraemos número de registros  
				$fp = file($nombre_archivo, FILE_SKIP_EMPTY_LINES);
				  
			  }
	}
?>

<?php
	if($upload){
?>
    <h2>Importar Usuarios</h2>
	<p><?php print count($fp)-1;?> Registros encontrados.</p>
	<span id="actualizados">0</span> Actualizados
	<p><button id="btn_actualizar_registros">INSERTAR</button></p>
    <script>
	var init = 1;
	var total = <?php print count($fp)-1;?>;




	jQuery( function ( $ ) {
		

		function callInsert(){

									$.ajax({
									   type: "POST",
										url: "<?php print get_site_url();?>/wp-admin/admin-ajax.php", 
										data: {'action':'insertUsuarios','init':init,'total':total,'file':'<?php print $namefile;?>'},
										dataType: "json",
										success: function(msg){
											init = parseInt(msg.init);
											$("span#actualizados").html(init-1);

											if(init<=total){
												callInsert();	
											}
											$("button#btn_actualizar_registros").prop( "disabled", false );

										},
										error: function(msg){
											console.log(msg.statusText);
														$("button#btn_actualizar_registros").prop( "disabled", false );

										}
									 }); 

	}




		
		$("button#btn_actualizar_registros").on('click',function(e){

			$(this ).prop( "disabled", true );
									
			callInsert();
									 
		});
									 
	});

	</script>


<?php
	}
	
	?>
<form method="post" action="" enctype="multipart/form-data">
    <h2>Importar Usuarios</h2>
    <input type="file" name="archivo" />
    <?php submit_button('Actualizar'); ?>

</form>
<?php } ?>
<?php
//Shortocodes ilustraciones
function getSettingPS($args) {
	
	if($args['key']!=''){
		
		return get_option($args['key']);
	}
	else
	{
			return 'invalid key';	
	}
	
	
}
add_shortcode('pelostop-settings', 'getSettingPS');
//Metaboxes presentacion paginas
//CREACION DE METABOX PAGINA
//Metaboxes personalizados


$arr_fields_page = array(
	array('id'=>'ps_promociones','nombre'=>'¿Mostrar promociones?'),
	array('id'=>'ps_newsletter','nombre'=>'¿Mostrar Newsletter?'),
	array('id'=>'ps_buscador','nombre'=>'¿Mostrar buscador?'),
);
	


add_action('init', 'page_register_meta_fields');


function page_register_meta_fields() {
	global $arr_fields_page;
	foreach($arr_fields_page as $item){
			register_meta('post',$item['id'],'sanitize_text_field', 'pages_custom_fields_auth_callback');
	}
}

function pages_meta_boxes() {
	add_meta_box('pages-meta-box', 'Visualización', 'pages_meta_box_callback', 'page', 'normal','high',array('arg'=>'value'));
}
add_action('add_meta_boxes', 'pages_meta_boxes' );

function pages_meta_box_callback($post){
    
     global $wpdb, $post, $arr_fields_page;
	foreach($arr_fields_page as $item){
			
			
			$val = (int)get_post_meta($post->ID,$item['id'],true);
			$check=false;
			if($val==1){
				$check = "checked";	
			}
			
			
			print '<p><label class="label" style="float:left">'.$item['nombre'].'</label><br/>';
			print '<input name="'.$item['id'].'" id="'.$item['id'].'" type="checkbox" value="1" '.$check.' ></p>';
	}
}

add_action('save_post', 'guardar_page');
add_action('publish_post', 'guardar_page');

function guardar_page() {
			 

	global $wpdb, $post, $arr_fields_page;
	
	$post_id = $_POST['post_ID'];
	if (!$post_id) return $post;


	foreach($arr_fields_page as $item){
		
			update_post_meta($post_id, $item['id'], $_REQUEST[$item['id']]);
	}
}