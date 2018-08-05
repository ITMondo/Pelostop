jQuery( function ( $ ) {
    
	
	
	
	
	//Mapas de animacion home
	$(function(){
	
	$(".mapa-animacion.tratamientos area").on('mouseenter',function(e){
		e.preventDefault();
		e.stopPropagation();
		$(".mapa-animacion.tratamientos .zona").hide();
		
		var image = $(this).attr('alt');
		if(image!=''){
		$(".mapa-animacion.tratamientos ."+image).show();
		}
	}).on('mouseleave',function(e){
		var image = $(this).attr('alt');
		if(image!=''){
		$(".mapa-animacion.tratamientos ."+image).hide();
		}

	});
	
	
	$(".mapa-animacion.tratamientos area").on('click',function(e){
			
			var alt = $(this).attr('alt');
			
			$("ul.products li a").each(function(){
        	  if($(this).data('id')==alt){
				location.href = $(this).attr('href');
			  }
        	});
	})
	
	
		$("div.menu_tratamientos ul.products li a").on('mouseenter',function(e){
		e.preventDefault();
		e.stopPropagation();
		$(".mapa-animacion.tratamientos .zona").hide();
		
		var image = $(this).data('id');
		if(image!=''){
		$(".mapa-animacion.tratamientos ."+image).fadeIn();
		}
		}).on('mouseleave',function(e){
			var image = $(this).data('id');
			if(image!=''){
			$(".mapa-animacion.tratamientos ."+image).hide();
			}

		});

	
	
	
	
	
	
	
});

	
	
	
	
	
});
