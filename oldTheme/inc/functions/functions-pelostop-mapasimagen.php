<?php
//Shortocodes ilustraciones
function mapaImagen($args) {
	$route = false;

	switch($args['seccion']){
    case 'home-man':	$route = get_template_directory_uri().'/inc/mapas/home-man/';break;
    case 'home-woman':	$route = get_template_directory_uri().'/inc/mapas/home-woman/';break;
    case 'tratamientos-woman':	$route = get_template_directory_uri().'/inc/mapas/tratamientos-woman/';break;
    case 'tratamientos-man':	$route = get_template_directory_uri().'/inc/mapas/tratamientos-man/';break;
	}


	if($route){
		if($html = url_get_contents($route.'index.html')){
            $html = str_replace('src="','src="'.$route,$html);
            if($route == "https://pelostop.es/wp-content/themes/pelostop/inc/mapas/home-man/") {
                $html = str_replace('homemujer', 'homehombre', $html);
            }
            return $html;
		}
		else
		{
			return 'error';
		}
	}
	else
	{
        return 'ruta no definida';
	}
}
add_shortcode('mapa-imagen', 'mapaImagen');
