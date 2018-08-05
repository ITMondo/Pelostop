<?php

/* 
Template Name: Primera Cita Gratuita 
*/


get_header(); 



?>

<div id="primary" class="content-area col-sm-12 col-md-12 single-title buscador">
  <main id="main" class="site-main" role="main">
  <?php
			while ( have_posts() ) : the_post();
			?>
  <h1 class="text-center">
    <?php the_title();?>
  </h1>
  <div class="hr center">
    <hr class="center"/>
  </div>
  <p class="text-center">Busca tu Pelostop más cercano, selecciona un día, rellena el formulario y te llamaremos para confirmar la cita</p>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script> 
  <script src="  https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script>
    <div class="ok-primera-cita col-md-12 text-center">
  <h3>¡Gracias, tu petición se ha enviado correctamente!</h3>

<h3>Nos pondremos en contacto en breve para confirmarte la cita.</h3>
  </div>

  <div class="primera-cita">
  
  
  
            <form action="" method="post" class="form">

    <div class="pantalla pantalla-1">
      <h3>Busca tu centro</h3>
      <div class="row caja">
      <span class="msjform"></span>

        <div class="col-md-7 col-sm-7 col-xs-12">
          <select class="selectpicker" id="ubicacion" ata-live-search="true">
            <option value="">Selecciona ubicación...</option>
            <option value="geo" data-icon="glyphicon-map-marker">Cercanas a ubicación actual</option>
            <?php
		$provincias = getProvincias();
		
		foreach($provincias as $provincia){
		
		print '<option  value="'.$provincia.'">'.$provincia.'</option>';	
			
		}
	
	?>
          </select>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
          <input class="fecha" name="fecha" id="fecha" placeholder="fecha" />
          <input type="hidden" name="latitude" id="latitude" val="0" />
          <input type="hidden" name="longitude" id="longitude" val="0" />
          <input type="hidden" name="centro" id="centro" val="" />
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 text-center">
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
          <a id="btn_buscar_centros" class="btn black">BUSCAR</a> </div>
      </div>
    </div>
    <!-- end pantalla 1 -->
    <div class="pantalla pantalla-2">
      <h3>Centro Pelostop</h3>
      <div class="row caja">
      	<span class="msj"></span>
        <ul class="col-md-12">
        </ul>
      </div>
      <a class="btn btn_nueva_busqueda" >< Realizar nueva búsqueda</a>
    </div>
    <!-- end pantalla 2-->
    <div class="pantalla pantalla-3">
      <h3>Tus datos</h3>
      <div class="row caja">
        <div class="item">
          <div class="col-md-6 mapa">
            <div id="map"></div>
            <h4>Centro</h4>
            <p class="direccion">Dirección</p>
          </div>
          <div class="col-md-4 col-md-offset-1 datos">
          <h4>Tus datos</h4>
                <span class="msjform"></span>

           <div class="form-group">
           <label>Nombre y apellidos</label>
           <input class="form-control" name="nombre"  id="nombre" value="" />
           </div>
             <div class="form-group">
           <label>Email</label>
                      <input class="form-control" name="email" id="email" value="" />

           </div>
              <div class="form-group">
           <label>Teléfono</label>
                                 <input class="form-control" name="telefono" id="telefono" value="" />

           </div>
             <div class="form-group">
           <label>¿A qué hora te llamamos para<br/> confirmar la cita?</label>
            <input class="form-control" name="hora_contacto" id="hora_contacto" value="" />

           </div>
           
             <div class="form-group">
           <label style="font-size:11px"><input type="checkbox" style="width:30px;float:left" name="acepto" id="acepto" value="1" /> He leido y acepto las condiciones del <a href="https://www.pelostop.es/aviso-legal/">Aviso Legal</a> y <a href="https://www.pelostop.es/politica-de-privacidad/">Política de Privacidad</a></label>
           </div>
           
           <div class="form-group">
           <a id="btn_send_form" class="btn black">Reservar</a>
           </div>
            
          </div>
        </div>
      </div>
    </div>
    <script>
	  
	  			   var icono = "<?php print get_template_directory_uri();?>/images/marker.png" ;

 					function initMap(obj) {
						console.log('INICIANDO MAPA');
                        map = new google.maps.Map(document.getElementById('map'), {
                          center: {lat: parseFloat(obj.latitud), lng: parseFloat(obj.longitud)},
                          zoom: 12
                        });
						
						addMarker(obj);
						
					  }
					  
					  function addMarker(obj){	
					  
					 		 var contentString = '<div id="content">'+
							  '<div id="siteNotice">'+
							  '</div>'+
							  '<h5 id="firstHeading" class="firstHeading">'+obj.nombre_web+'</h5>'+
							  '<div id="bodyContent">'+
							 '<p>'+obj.calle+', '+obj.numero+'. <br/>'+obj.cp+' '+obj.poblacion+' ('+obj.provincia+')<br/>Horarios: '+obj.horarios+'<br/><a href="mailto:'+obj.email+'">'+obj.email+'</a></p><div class="phone"><i class="fa fa-phone" aria-hidden="true"></i> '+obj.telefono+'</div></li>'+
							  '</div>'+
							  '</div>';
							  
							  console.log(contentString);
						
						  var infowindow = new google.maps.InfoWindow({
							content: contentString
						  });
							var marker = new google.maps.Marker({
							  position: {lat: parseFloat(obj.latitud), lng: parseFloat(obj.longitud)},
							  icon:icono,
							  map: map,
							  customInfo: "Marker A"
							});
							
							  marker.addListener('click', function() {
								infowindow.open(map, marker);
							});
						markers.push(marker);
                      }
					  
					  function setMapOnAll(map) {
						for (var i = 0; i < markers.length; i++) {
						  markers[i].setMap(map);
						}
					  }

					  
					  function resetMarkers(){
						setMapOnAll(null);
					  }	  
	  
	  
	  
	  
jQuery( function ( $ ) {
	
	var centros;
	var geo = false;
	
	$(".pantalla-1").show();
	
	    $('.fecha').datepicker({
      	language:'es',
		startDate: '+0d'
   		 });
		 
		 $("select#ubicacion").on('change',function(e){
			 
			var val = $("select#ubicacion option:selected").val();
			if(val=='geo'){
				get_loc();
			}
			 
		 });
		 
		 
		 $("a.btn_nueva_busqueda").on('click',function(e){
			 
			 $(".pantalla span.msjform").html('');
			 $(".pantalla").hide();
			 $(".pantalla-1").show();

			 
		 });
		 
		 $("a#btn_buscar_centros").on('click',function(e){
			 
			  $(".pantalla-1 span.msjform").html('');
			  	if($("#ubicacion").val()==''){
				 $(".pantalla-1 span.msjform").html('Selecciona una ubicación');
				 return;
			 }

			 if($("#fecha").val()==''){
				 $(".pantalla-1 span.msjform").html('Selecciona una fecha');
				 return;
			 }
			 
								  $(".pantalla-1 .loading_ps").css('display','flex');

										var ubicacion = $("select#ubicacion option:selected").val();
										if(ubicacion=='geo'){
										var	id_provincia = '';
										geo = true;
										}
										else
										{
										var	id_provincia =  $( "#ubicacion option:selected" ).val();
										}

										
									
										$.ajax({
									    type: "POST",
										url: base_url+"/wp-admin/admin-ajax.php", 
										data: {'action':'searchCentros', 'id_provincia':id_provincia},
										dataType: "json",
										success: function(msg){
											  centros = msg;
											  $(".pantalla-1 .loading_ps").fadeOut();
											  showCentros();

										},
										error: function(msg){
											console.log(msg.statusText);
										}
									 }); 
			 
			 
			 
			 
		 });
		 
		 
		 $("a#btn_send_form").on('click',function(e){
			 
			e.preventDefault();
			 
			if(!$("#acepto").is(':checked')) {  
					$(".pantalla-3 span.msjform").html('Es necesario aceptar las condiciones');
				return;
  
			} 
			
									$.ajax({
									    type: "POST",
										url: base_url+"/wp-admin/admin-ajax.php", 
										data: {'action':'reservaCita', 'id_centro':$("#centro").val(),'nombre':$("#nombre").val(),'telefono':$("#telefono").val(),'email':$("#email").val(),'fecha':$("#fecha").val(),'hora_contacto':$("#hora_contacto").val()},
										dataType: "json",
										success: function(msg){
											
										     console.log(msg);
											 if(msg.ok){
												 
												 $(".ok-primera-cita").show();
												 $(".primera-cita").html('<iframe style="width:1px;height:1px;border:none" src="'+base_url+'/gracias/?page=primera-cita-gratuita"></iframe>');
												 
											 }
											 else
											 {
												$(".pantalla-3 span.msjform").html(msg.message);
												 
											 }

										},
										error: function(msg){
											$(".pantalla-3 span.msjform").html('Error de conexión');

										}
									 });  
			 
		 });
		 




								function getKilometros(lat1,lon1,lat2,lon2)
							 {
							 rad = function(x) {return x*Math.PI/180;}
							var R = 6378.137; //Radio de la tierra en km
							 var dLat = rad( lat2 - lat1 );
							 var dLong = rad( lon2 - lon1 );
							var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
							 var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
							 var d = R * c;
							return d.toFixed(3); //Retorna tres decimales
							 } 



							function showCentros(){
								
								$(".pantalla").hide();
								$(".pantalla-2").show();
								
								
								//Geo
								
								if(geo){
									for (var i in centros) {
											 distance = getKilometros(centros[i].latitud,centros[i].longitud,$("#latitude").val(),$("#longitude").val()); 
											 centros[i].distance = distance;
									}
								
									centros.sort(function(a, b){
										return a.distance - b.distance;
									});
								}

								
								
								
								
								
								
								
								

								  var html = '';
								  if(centros.length>0){
									  for (var i in centros) {
										  
										  console.log(obj);
										  
										  var obj = centros[i];
										  
										  if(geo && i>5){
											break;  
										  }
										  
										html+= '<li>';
										html+=' <div class="col-md-10 centro"> ';
										html+='	<h4>'+obj.nombre_web+'</h4>';
										html+='	<p>'+obj.calle;
										 if(obj.numero!=''){
											html+=", "+obj.numero;
										  }
										html+='. ';  
										html+=obj.cp+' '+obj.poblacion+' ('+obj.provincia+')';
										html+='</p></div>';
	
										html+='<div class="col-md-2 btn_reserva"><a data-id="'+obj.centro_id+'" class="btn black btn-select-centro">Reservar</a></div>';
										html+='</li>';  
	
									  }
									  
									  
									
									  
									  html = '<ul class="col-md-12">'+html+'</ul>';
									
										$(".pantalla-2 .caja").html(html);
										
										
										 $("a.btn-select-centro").on('click',function(e){
											e.preventDefault();
											var centro = getObjCentroByID($(this).data('id'));
											if(centro){
												$(".pantalla-3").show();
												$(".pantalla-2").hide();

												$("#centro").val(centro.centro_id);
												$(".pantalla-3 .mapa h4").html(centro.nombre_web);
												
												html=centro.calle;
												 if(centro.numero!=''){
													html+=", "+centro.numero;
												  }
												html+='. ';  
												html+=centro.cp+' '+centro.poblacion+' ('+centro.provincia+')';
												
												$(".pantalla-3 .mapa p.direccion").html(html);

												initMap(centro);
											}
										 });
										
										
										
										
								}
								else
								{
										$(".pantalla-2 .caja").html('<p>No se han encontrado centros</p>');
								}
									
							}






		 					function get_loc() {
								
								
							   if (navigator.geolocation) {
								  navigator.geolocation.getCurrentPosition(setCoordenadas,errorLoc);
								  $(".pantalla-1 .loading_ps").css('display','flex');

							   }else{
								  alert('Ups!! no es posible obtener coordenadas, actualiza tu navegador');                  
								}
																
							
								
							}
							
							function errorLoc(error){
								
									$(".pantalla-1  .loading_ps").fadeOut();

							}
							
							function setCoordenadas(position){
								

								$("input#latitude").val(parseFloat(position.coords.latitude));
								$("input#longitude").val(parseFloat(position.coords.longitude));
								$(".pantalla-1  .loading_ps").fadeOut();
								return;
								
							
							
							}
							
							
							
							function getObjCentroByID(id){
								
								
								var centro = false;
								
										  for (var i in centros) {
										  
										  		var obj = centros[i];
												  if(parseInt(obj.centro_id) == parseInt(id)){
													  centro = obj;
												  }
										  
										  }
								return centro;
							}
	
});
	  
	  </script> 
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA24ZNepwcNP5SMpj6FaZmov5bsWOEg6gs"></script> 
              </form>  

  </div>
</div>
<?php
			endwhile; // End of the loop.
			?>
</main>
<!-- #main -->
</div>
<!-- #primary -->
</div>
<!-- #row -->
</div>
<!-- #container -->
<?php
$upload_dir = wp_upload_dir();
$upload_dir = $upload_dir['baseurl'];

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






