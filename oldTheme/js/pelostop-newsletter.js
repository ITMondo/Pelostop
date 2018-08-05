jQuery( function ( $ ) {
	
	
	
	$("a#btn_snd_newsletter").on('click',function(e){
		
		$("#newsletter .errors").html('');
		
		
		if($("input#ns_email").val()==''){
			$("#newsletter .errors").html('<p>El email no es válido.</p>');
					console.log('mail no válido');
			return;
		}
		if(!$("input#ns_acepto").is(':checked')){
			$("#newsletter .errors").html('<p>Es necesario aceptar las condiciones.</p>');
			return;
		}
		
			
			$.ajax({
			  	type: "POST",
			   	url: base_url+"/wp-admin/admin-ajax.php", 
			  	data: {'action':'addNewsletter','email':$("input#ns_email").val(), 'source':'HOM'},
				success: function(msg){
					if(parseInt(msg)==1){
							$("form#newsletter").html('<h3>¡Has sido dado de alta corectamente!</h3>');
							$("#thanks").html('<iframe style="width:1px;height:1px;border:none" src="https://pelostop.es/gracias/?page=newsletter"></iframe>');
							fbq('track', 'Lead', {
							value: 10.00,
							currency: 'EUR'
							});
							console.log('callFb');

					}
					else
					{
					$("form#newsletter .errors").html('<p>El mail no es válido.</p>');
					}
				},
				error: function(msg){
					$("#newsletter .errors").html('<p>Error de conexión.</p>');
				}
			}); 
		
	});
	
	
	
});



