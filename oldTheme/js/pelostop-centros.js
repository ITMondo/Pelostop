// JavaScript Document
 					function initMap() {
                        map = new google.maps.Map(document.getElementById('map'), {
                          center: {lat: 40.4155565, lng: -3.7035703},
                          zoom: 5
                        });
						
						for (var i in centros) {
						  addMarker(centros[i]);
						}

					  
					  }
					  
					  
					  function initMapV2() {
                        map = new google.maps.Map(document.getElementById('map'), {
                          center: {lat: 40.4155565, lng: -7.7035703},
                          zoom: 6
                        });
						
						for (var i in centros) {
						  addMarker(centros[i]);
						}

					  
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
					 
					  
					  
					  
					  
					  
					  
					  //JQUERY FUNCTIONS
					  
					 jQuery( function ( $ ) {
						 
						 
						 
						  
						
						 
						  
						  $("button.get-coords").on('click',get_loc);
							
							
							
							
							function get_loc() {
								
							   if (navigator.geolocation) {
								  navigator.geolocation.getCurrentPosition(setCoordenadas,errorLoc);
								  $(".centros .loading_ps").css('display','flex');

							   }else{
								  alert('Ups!! no es posible obtener coordenadas, actualiza tu navegador');                  
								}
																
							
								
							}
							
							function errorLoc(error){
								
									$(".centros .loading_ps").fadeOut();

							}
							
							function setCoordenadas(position){
								

								
								var distance = [];
								 map.panTo({lat:parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)}); 
								 
								for (var i in centros_all) {
										 distance = getKilometros(centros_all[i].latitud,centros_all[i].longitud,position.coords.latitude,position.coords.longitude); 
										 centros_all[i].distance = distance;
								}
							
								centros_all.sort(function(a, b){
									return a.distance - b.distance;
								});
								
								map.panTo({lat:parseFloat(centros_all[0].latitud), lng: parseFloat(centros_all[0].longitud)}); 
								map.setZoom(15);

								$(".centros .loading_ps").fadeOut();
								centros = centros_all;
								printCentros();
							
							}
							
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
							 
							 function printCentros(){
						  
								  var html = '';
								  for (var i in centros) {
									  var obj = centros[i];
									  console.log(obj.empresa);
									  html+= '<li data-id="'+obj.post_id+'">';
									  
									  if(obj.empresa == 'SDB ECI'){
										html+='<img class="img-centro" src="'+base_url+'/wp-content/themes/pelostop/images/eci.png	" /><br/>';  
									  }
									  
									  
									  html+='<strong>'+obj.nombre_web+'</strong><p>'+obj.calle;
									  if(obj.numero!=''){
										html+=", "+obj.numero;
									  }
									  html+='.<br/> '+obj.cp+' '+obj.poblacion+' ('+obj.provincia+')<br/>Horarios: '+obj.horarios+'<br/><a href="mailto:'+obj.email+'">'+obj.email+'</a></p><div class="phone"><i class="fa fa-phone" aria-hidden="true"></i>'+obj.telefono+'</div></li>';
								  }
								  
								  
  								$("span#search_total_centros").html(Object.keys(centros).length);
								  
								$("div.listado ul").html(html);
									
										$("div.listado ul li").on('click',function(e){
												
											var id = $(this).data('id');
											for (var i in centros) {
												if(parseInt(centros[i].post_id) == parseInt(id)){
													 map.panTo({lat:parseFloat(centros[i].latitud), lng: parseFloat(centros[i].longitud)}); 
													 map.setZoom(15);
												}
											}
									  	});
							 }
							 
							 
							 
							 
							 
							 $("select#search_provincia").on('change',function(e){
								
									var id_provincia = $(this).val();
								
									if(id_provincia!=''){
										$.ajax({
									   type: "POST",
										url: base_url+"/wp-admin/admin-ajax.php", 
										data: {'action':'getPoblaciones','id_provincia':id_provincia},
										dataType: "json",
										success: function(msg){
											var html = '<option value="">Poblacion...</option>';
											$.each(msg, function(i, item) {
												html+='<option value="'+item.poblacion+'">'+item.poblacion+'</option>';
											});
											$("select#search_poblacion").html(html);

										},
										error: function(msg){
											console.log(msg.statusText);
										}
									 }); 
									}
									else
									{
											$("select#search_poblacion").html('<option value="">Población...</option>');
										
									}
								 
								 
							 });
							 
							 
							  $("a#btn_search_centros").on('click',function(e){
								
									
									if($("#geopos_active").length>0){
										
										if($("#geopos_active").is(':checked')){
										console.log('Geopos');	
										get_loc();
										return; 	
										}
									}
									
									
										$(".centros .loading_ps").css('display','flex');
									
										var	id_provincia =  $( "#search_provincia option:selected" ).val();
										var id_poblacion = $( "#search_poblacion option:selected" ).val();
										var id_cp = $( "#search_cp").val();
										
									
										$.ajax({
									    type: "POST",
										url: base_url+"/wp-admin/admin-ajax.php", 
										data: {'action':'searchCentros', 'id_provincia':id_provincia, 'id_poblacion':id_poblacion, 'id_cp':id_cp },
										dataType: "json",
										success: function(msg){
											  centros = msg;
											  printCentros();
											  $(".centros .loading_ps").fadeOut();


										},
										error: function(msg){
											console.log(msg.statusText);
										}
									 }); 
								 
								 
							 });
							 
							 
							 
							 
						  
						  
					printCentros();

						  
					 });
