jQuery( function ( $ ) {
    
	
	
	function createResponsiveMenu(){
		
		var html = '<ul>';
		
		$( "ul#menu-menu-principal li, ul#menu-menu-principal-man li" ).each(function( index ) {
		  html+='<li>'+$(this).html()+'</li>';
		});
		
		
		$( "ul#menu-top-header li, ul#menu-top-header-man li" ).each(function( index ) {
		  html+='<li>'+$(this).html()+'</li>';
		});

		
		html+="</ul>";
		
		$("div#menu-responsive").html(html);
		
		
		$("a#btn-menu-responsive").on('click',function(e){
			e.preventDefault();
			if($("div#menu-responsive").is(':visible')){
			$("div#menu-responsive").addClass('hide-menu').removeClass('show-menu');
			}
			else
			{
			$("div#menu-responsive").addClass('show-menu').removeClass('hide-menu');
			}
		});
		
	}
	
	
	createResponsiveMenu();
	
	
	//Tratamientos
	$("select#sel_tratamientos").on('change',function(e){
		
		
		var val = $("select#sel_tratamientos option:selected").val();
		if(val!=''){
			
			top.location.href = val;
			
		}
		
	});
	
	
	//Carrito
	$("div#carrito a.btn-show-carrito").on('click',function(e){
		e.preventDefault();
					if($("#carrito div.detalle").is(':visible')){
						$("div#carrito a.btn-show-carrito i.status").html('-');
						$("#carrito div.detalle").slideUp();
					}
					else
					{
						$("div#carrito a.btn-show-carrito i.status").html('X');
						$("#carrito div.detalle").slideDown();
					}

		
		
	});
	
	
	//Tooltip
			$("a.tt").on('click',function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			$('#ps_tooltip .modal-body').html('');
			$('#ps_tooltip').find('.modal-body').load(url);
			$('#ps_tooltip').modal('show');
			});
	
	
	
	//Mapas de animacion home
	$(function(){
		
		$(".mapa-animacion.home area").on('mouseenter',function(e){
			e.preventDefault();
			e.stopPropagation();
			$(".mapa-animacion.home .zona").hide();
			
			var image = $(this).attr('alt');
			if(image!=''){
			$(".mapa-animacion.home ."+image).show();
			}
		}).on('mouseleave',function(e){
			var image = $(this).attr('alt');
			if(image!=''){
			$(".mapa-animacion.home ."+image).hide();
			}
	
		}).on('click',function(e){
			var image = $(this).attr('alt');
			if(image!=''){
			top.location.href = base_url+'/tratamientos/'+image;
			}
	
		});
		
		
		
		
	
	});
	
	
	//Galería
	$("a.btn_gallery").on('click',function(e){
		 e.preventDefault();
		 var image = $(this).attr('href');
		 console.log(image);
		 $("div.woocommerce-product-gallery__image img").attr('src',image);
		 $("a.btn_gallery").removeClass('active');
		 $(this).addClass('active');
		
		
	});
	
	
	
	
	if($(".provincia_ajax").length>0){
	
									$.ajax({
									   type: "POST",
										url: base_url+"/wp-admin/admin-ajax.php", 
										data: {'action':'getProvincias'},
										dataType: "json",
										success: function(msg){
											
											var html = '<option value="">Selecciona...</option>';
											$.each(msg, function(i, item) {
												html+='<option value="'+item+'">'+item+'</option>';
											});
											$("select.provincia_ajax").html(html);
											
											
												if($(".centro_ajax").length>0){
													
													$("select.provincia_ajax").on('change',function(e){
														
														if($(this).val()!=''){
															var id_provincia = $(this).val();
																					
																$.ajax({
															   type: "POST",
																url: base_url+"/wp-admin/admin-ajax.php", 
																data: {'action':'searchCentros','id_provincia':id_provincia},
																dataType: "json",
																success: function(msg){
																	
																
																	var html = '<option value="">Selecciona...</option>';
																	$.each(msg, function(i, item) {
																		html+='<option value="'+item.centro_id+' '+item.nombre_web+'. '+item.calle+'">'+item.nombre_web+'. '+item.calle+'</option>';
																	});
																	
																$("select.centro_ajax").html(html);
						
																},
																error: function(msg){
																	console.log(msg.statusText);
																}
															 }); 
														}
														
														
													});
												};
										},
										error: function(msg){
											console.log(msg.statusText);
										}
									 }); 
		
	}



	$("a.btn_buscar").on('click',function(e){
		
		$("div.search-box").toggle();
		
		
	});
	
	 $('#exampleModal').modal('show');
	
	
	
	
	
});
