<?php





function getNewsletter($args=[]){	

$upload_dir = wp_upload_dir();
$upload_dir = $upload_dir['baseurl'];


	return '
	<div class="container-fluid newsletter">
  <div class="container">
    <div class="col-md-6 col-md-offset-3 text-center">
      <h2>Recibe nuestras novedades</h2>
      <p class="lead">Sé el primero en conocer las nuevas promociones y tarifas especiales.</p>
      <form id="newsletter" class="form" method="post">
        <div class="row">
                     <div class="errors text-center"></div>

          <div class="col-md-8">
            <input type="email" clas="form-control" value="" name="ns_email" id="ns_email" placeholder="Tu correo electrónico" />
          </div>
          <div class="col-md-4 text-left"><a class="btn black" id="btn_snd_newsletter">Suscribirme</a></div>
        </div>
        <div class="row">
          <div class="col-md-12 legend text-left">
            <input type="checkbox" value="1" name"ns_acepto" id="ns_acepto" />
            He leído y acepto la <a target="_blank" href="'.get_site_url().'/aviso-legal/">política de privacidad</a>.</div>
        </div>
      </form>
    </div>
  </div>
</div>
  <script src="'.get_template_directory_uri().'/js/pelostop-newsletter.js"></script> ';

}
add_shortcode('ps_newsletter', 'getNewsletter');



function getNewsletterSmall($args=[]){	

$upload_dir = wp_upload_dir();
$upload_dir = $upload_dir['baseurl'];


/*  <div class="col-md-6 col-md-offset-3 text-center">
      <p class="lead">Sé el primero en conocer las nuevas promociones y tarifas especiales.</p>
      <form id="newsletter" class="form" method="post">
        <div class="row">
                     <div class="errors text-center"></div>

          <div class="col-md-8">
            <input type="email" clas="form-control" value="" name="ns_email" id="ns_email" placeholder="Tu correo electrónico" />
			
          </div>
          <div class="col-md-4 text-left"><a class="btn black" id="btn_snd_newsletter">Suscribirme</a></div>
        </div>
        <div class="row">
          <div class="col-md-12 legend text-left">
            <input type="checkbox" value="1" name"ns_acepto" id="ns_acepto" />
            He leído y acepto la <a href="#">política de privacidad</a>.</div>
        </div>
      </form>
    </div>
	*/


	return '
	<div class="container-fluid newsletter small">
  		<div class="container">
		        <div class="row text-center">
							      <form id="newsletter" class="form" method="post">

  			<div class="col-md-3 text-right col-md-offset-1">
      		<p class="lead">Sé el primero en conocer las nuevas promociones y tarifas especiales.</p>
  			</div>
			<div class="col-md-5">

			                     <div class="errors text-center"></div>

            <input type="email" clas="form-control" value="" name="ns_email" id="ns_email" placeholder="Tu correo electrónico" />
			<p class="text-left">  <input type="checkbox" value="1" name"ns_acepto" id="ns_acepto" />
            He leído y acepto la <a target="_blank" href="'.get_site_url().'/aviso-legal/">política de privacidad</a>.</p>
			</div>
			<div class="col-md-2">
			<a class="btn black" id="btn_snd_newsletter">Suscribirme</a>
			</div>
			
			</div>
  
  			</form>

  		
  		</div>
	</div>
  <script src="'.get_template_directory_uri().'/js/pelostop-newsletter.js"></script> ';

}




add_shortcode('ps_newsletter_small', 'getNewsletterSmall');





function addNewsletter(){
	
	global $wpdb;
	
	$email = sanitize_text_field($_REQUEST['email']);
	$source = sanitize_text_field($_REQUEST['source']);
	
	
	if(is_email($email)){
				$wpdb->insert( 
					'ps_newsletter', 
					array( 
						'email' => $email, 
						'source' => $source ,
						'created_at'=> current_time('mysql')
					), 
					array( 
						'%s', 
						'%s',
						'%s'
					) 
				);
				
				
				
				
				$message = '<!doctype html>
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
    <td style="padding-bottom:20px;padding-left:10px;padding-right:10px;font-family:Arial, Helvetica, sans-serif;font-size:15px;"><p>¡Muchas gracias por tu suscripción!</p>
      <p>A partir de ahora recibirás nuestras noticias, promociones y descuentos. Esperamos que los disfrutes. </p>
      <p>Un saludo, </p>
      <p>El equipo de Pelostop </p></td>
  </tr>
  <tr>
    <td style="background:none; border:solid 1px #e1e1e1; border-width:1px 0 0 0; height:1px; width:100%; margin:0px 0px 0px 0px; padding-top:10px;padding-bottom:10px;"></td>
  </tr>
  <tr>
    <td><a href="'.get_site_url().'/tratamientos/woman/no-sin-mis-amigs/" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/banner.jpg" style="display:block;width:100%;height:auto" /></a></td>
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
          <td style="text-align:center"><a href="http://www.facebook.com/pages/Pelostop/138882672788719" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-facebook.jpg"  alt="Facebook"></a> 
          <a href="http://twitter.com/pelostop" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-twitter.jpg" width="35" height="23" alt="Twitter"></a> 
          <a href="https://es.linkedin.com/company/ochalgroup-2005-sl---pelostop" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-linkedin.jpg" width="35" height="23" alt="Linkedin"></a> 
          <a href="https://instagram.com/pelostop_oficial" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-instagram.jpg" width="35" height="23" alt="Instagram"></a> 
          <a href="https://www.youtube.com/channel/UClrJhSUlJdGYs6GSVsFtTrg" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-youtube.jpg" width="35" height="23" alt="Youtube"></a> 
          <a href="https://plus.google.com/+PelostopEspa%C3%B1a?hl=es" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-google-plus.jpg" width="35" height="23" alt="Google Plus"></a> <a href="https://www.pelostop.es/blog/" target="_blank"><img src="'.get_site_url().'/wp-content/themes/pelostop/images/mail/ico-blog.jpg" width="35" height="23" alt="Blog"></a></td>
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
				
				
				
				
				$messagePS = '<p>Nueva alta en Newsletter</p><p><strong>'.$email.'</strong></p>';
				
				wp_mail( $email, 'Confirmación suscripción a Pelostop', $message);
				wp_mail('idiez@pelostop.com','Alta en Newsletter',$messagePS);
				
				print 1;
	}
	else
	{
		print 0;
	}
	
	
	exit(); 
}
add_action('wp_ajax_addNewsletter', 'addNewsletter');
add_action('wp_ajax_nopriv_addNewsletter', 'addNewsletter'); 
