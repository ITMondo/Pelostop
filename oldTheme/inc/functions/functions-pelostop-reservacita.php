<?php
function reservaCita(){
	
	
	global $wpdb;
	
	$id_centro = (int)$_REQUEST['id_centro'];
	$nombre = sanitize_text_field($_REQUEST['nombre']);
	$telefono = sanitize_text_field($_REQUEST['telefono']);
	$email = sanitize_text_field($_REQUEST['email']);
	$fecha = sanitize_text_field($_REQUEST['fecha']);
	$hora_contacto = sanitize_text_field($_REQUEST['hora_contacto']);
	
	
	if($id_centro=='' || $id_centro<=0){
		print json_encode(array('ok'=>0,'message'=>'El centro no es válido'));
		exit();
	}
	if($nombre==''){
		print json_encode(array('ok'=>0,'message'=>'El nombre no es válido'));
		exit();
	}
	if($telefono=='' || $telefono==0){
		print json_encode(array('ok'=>0,'message'=>'El teléfono no es válido'));
		exit();
	}
	if($email=='' || !is_email($email)){
		print json_encode(array('ok'=>0,'message'=>'El email no es válido'));
		exit();
	}
	if($hora_contacto==''){
		print json_encode(array('ok'=>0,'message'=>'La hora de contacto no es válida'));
		exit();
	}



	$centro = getCentro($id_centro,false);
	
	if($centro && $centro['email']!=''){
		
		
		
		

		$msj = '<p><strong>Centro:</strong> '.$centro['nombre'];
		$msj .= '<p><strong>Fecha:</strong> '.$fecha;	
		$msj .= '<p><strong>Nombre:</strong> '.$nombre;
		$msj .= '<p><strong>Teléfono:</strong> '.$telefono;
		$msj .= '<p><strong>Email:</strong> '.$email;
		$msj .= '<p><strong>Hora para contactar:</strong> '.$hora_contacto;
		
		add_filter( 'wp_mail_content_type', 'set_content_type' );
		function set_content_type( $content_type ) {
			return 'text/html';
		}
	
		wp_mail('clientes@pelostop.com','Solicitud de primera cita gratuita',$msj);
		
		 $msjcliente = '<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>
<body>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:20px;margin-bottom:20px;">
<tr>
<td ><a href="'.get_site_url().'" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/logo-pelostop-woman.png" /></a> <a href="'.get_site_url().'/man" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/logo-pelostop-man.png" /></a>
<p style="color:4e4e50;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;">Especialistas en depilación láser</p></td>
</tr>
<tr>
<td style="background:none; border:solid 1px #e1e1e1; border-width:1px 0 0 0; height:1px; width:100%; margin:0px 0px 0px 0px; padding-top:10px;padding-bottom:10px;"></td>
</tr>
<tr>
<td style="padding-bottom:20px;padding-left:10px;padding-right:10px;font-family:Arial, Helvetica, sans-serif;font-size:15px;"><p>¡Tu solicitud de cita ha sido recibida correctamente!</p>
<p>Nos pondremos en contacto en breve para confirmarte la cita. </p>
<p><strong>IMPORTANTE:</strong> La cita aún no está confirmada. Te llamaremos a la hora que nos has indicado en el formulario para confirmar centro, día y hora. La llamada la recibirás a través del número 900 828 410.</p>
<p>Un saludo, </p>
<p>El equipo de Pelostop </p></td>
</tr>
<tr>
<td style="background:none; border:solid 1px #e1e1e1; border-width:1px 0 0 0; height:1px; width:100%; margin:0px 0px 0px 0px; padding-top:10px;padding-bottom:10px;"></td>
</tr>
<tr>
<td><a href="'.get_site_url().'tratamientos/woman/no-sin-mis-amigs/" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/banner.jpg" style="display:block;width:100%;height:auto" /></a></td>
</tr>
<tr>
<td style="background:none;  height:2px; width:100%; margin:0px 0px 0px 0px; padding-top:10px;padding-bottom:10px;"></td>
</tr>
<tr>
<td style="background:none; border:solid 2px #e1e1e1; border-width:2px 0 0 0; height:2px; width:100%; margin:0px 0px 0px 0px; padding-top:10px;padding-bottom:10px;"></td>
</tr>
<tr>
<td><table width="600" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="color:4f4e50;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;text-align:center">#depilaciónláser</td>
<td style="text-align:center"><a href="http://www.facebook.com/pages/Pelostop/138882672788719" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-facebook.jpg"  alt="Facebook"></a> <a href="http://twitter.com/pelostop" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-twitter.jpg" width="35" height="23" alt="Twitter"></a> <a href="" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-linkedin.jpg" width="35" height="23" alt="Linkedin"></a> <a href="https://instagram.com/pelostop_oficial" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-instagram.jpg" width="35" height="23" alt="Instagram"></a> <a href="https://www.youtube.com/channel/UClrJhSUlJdGYs6GSVsFtTrg" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-youtube.jpg" width="35" height="23" alt="Youtube"></a> <a href="" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-google-plus.jpg" width="35" height="23" alt="Google Plus"></a> <a href="https://www.pelostop.es/blog/" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-blog.jpg" width="35" height="23" alt="Blog"></a></td>
<td style="color:4f4e50;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;text-align:center">#Siempreapunto</td>
</tr>
</table></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td style="background:none; border:solid 2px #e1e1e1; border-width:2px 0 0 0; height:2px; width:100%; margin:0px 0px 0px 0px; padding-top:10px;padding-bottom:10px;"></td>
</tr>
<tr>
<td><table width="600" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="width:33%;text-align:center;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;color:#4f4e50"><a style="text-decoration:none;color:#4f4e50" href="'.get_site_url().'/buscador-de-centros/" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-centro.jpg" /><br/>
ENCUENTRA <br/>
TU CENTRO</a></td>
<td style="width:33%;text-align:center;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;color:#4f4e50"><a style="text-decoration:none;color:#4f4e50" href="tel:900 828 410" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-telefono.jpg" /><br/>
¿TE AYUDAMOS? <br/>
900 828 410</a></td>
<td style="width:33%;text-align:center;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;color:#4f4e50"><a style="text-decoration:none;color:#4f4e50" href="mailto:info@pelostop.com" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-email.jpg" /><br/>
¿TE AYUDAMOS? <br/>
info@pelostop.com</a></td>
</tr>
</table></td>
</tr>
</table>
</body>
</html>';
		
		
				wp_mail($email,'Gracias por contactar con Pelostop',$msjcliente);

		
		
		
		
		
		print json_encode(array('ok'=>1));
	
	}
	else
	{
			print json_encode(array('ok'=>0,'message'=>'El centro no existe'));
		exit();
	
	}
	
	/*
		$id_provincia = sanitize_text_field($_REQUEST['id_provincia']);
		$id_poblacion = sanitize_text_field($_REQUEST['id_poblacion']);
		$id_cp = sanitize_text_field($_REQUEST['id_cp']);
	*/

exit();

}
add_action('wp_ajax_reservaCita', 'reservaCita');
add_action('wp_ajax_nopriv_reservaCita', 'reservaCita'); 