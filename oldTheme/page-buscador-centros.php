<?php

/* 
Template Name: Buscador Centros 
*/


get_header(); 



?>

</div>
<!-- #row -->
</div>
<!-- #container --> 
<?php

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
	array_push($arr_centros,$cen);
}
?>




<div class="container-fluid centros full">
<div class="mapa"><div id="map"></div></div>
<!-- inicio buscador -->

<div class="col-md-4 buscador">
      <div class="row">
      	<div class="col-md-12">
      	<h2>Busca tu centro más cercano</h2>
        </div>
        <div class="col-md-12">
          <h4><input name="get_loc" id="geopos_active" type="checkbox" value="1" /> Localiza el Pelostop más cercano a tu posición actual</h4>
         
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
            <div class="form-group">
            <a class="btn black search" id="btn_search_centros"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
            </div>
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
        <div class="listado col-md-12">
          <h5><span id="search_total_centros"><?php print count($centros);?></span> centro/s</h5>
          <ul>
            <?php          
		if ( $centros ) {
			foreach ( $centros as $post ) :
				setup_postdata( $post ); ?>
            <li data-id="<?php print $post->ID;?>"> <strong><?php print get_post_meta( $post->ID, 'wpcf-nombre-web', true );?></strong>
              <p><?php print get_post_meta( $post->ID, 'wpcf-calle', true );?>, <?php print get_post_meta( $post->ID, 'wpcf-numero', true );?>.<br/>
                <?php print get_post_meta( $post->ID, 'wpcf-codigo-postal', true );?> <?php print get_post_meta( $post->ID, 'wpcf-provincia', true );?> (<?php print get_post_meta( $post->ID, 'wpcf-poblacion', true );?>)<br/>
                Horario: <?php print get_post_meta( $post->ID, 'wpcf-horarios', true );?><br/>
                <?php print get_post_meta( $post->ID, 'wpcf-email', true );?></p>
              <div class="phone"><i class="fa fa-phone" aria-hidden="true"></i> <?php print get_post_meta( $post->ID, 'wpcf-telefono', true );?></div>
            </li>
            <?php
			endforeach; 
			wp_reset_postdata();
		}
?>
          </ul>
        </div>
        
      </div>
    </div>



<!-- fin del buscadr -->










</div>

<script>
					  var map;
					  var icono = "<?php print get_template_directory_uri();?>/images/marker.png" ;
					  var markers = [];
					  var centros = <?php print json_encode($arr_centros);?>;
					  var centros_all = centros;
</script> 
<script src="<?php print get_template_directory_uri();?>/js/pelostop-centros.js"></script> 
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA24ZNepwcNP5SMpj6FaZmov5bsWOEg6gs&callback=initMapV2"></script> 
<?php
get_sidebar();
?>



<?php
$val = (int)get_post_meta($post->ID,'ps_promociones',true);
if($val==1){
	print getPromociones();
}
?>
<?php
$val = (int)get_post_meta($post->ID,'ps_newsletter',true);
if($val==1){
	print getNewsletter();
}
?>
<!-- CENTROS -->

<?php
$val = (int)get_post_meta($post->ID,'ps_buscador',true);
if($val==1){
		print getCentros();

}
?>

<?php
get_footer();




