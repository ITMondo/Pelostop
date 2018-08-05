<?php
global $post;
//Paginas concretas
if( is_front_page()){
	$_SESSION['PS_SITE'] = 'woman';
}
else if($post->post_name == 'man'){
	$_SESSION['PS_SITE'] = 'man';
}
else if($post->post_name == 'promociones-man' || $post->post_name == 'promociones-2-2'){
		$_SESSION['PS_SITE'] = 'man';
}
else if($post->post_name == 'promociones' || $post->post_name == 'promociones-2'){
		$_SESSION['PS_SITE'] = 'woman';
}
//No hay session
if(!isset($_SESSION['PS_SITE'])){ //No hay sesión
	//print_r($post);
	$isman = false;
	$post_categories = get_the_category($post->ID );	
	foreach($post_categories as $category){
		if($category->slug == 'man'){
			$isman = true;
		}
	}
	if($isman){
		$_SESSION['PS_SITE'] = 'man';
	}
	else
	{
		$_SESSION['PS_SITE'] = 'woman';
	}
}
else //Hay session valoramos la categoría
{
	$post_categories = get_the_category($post->ID );	
	foreach($post_categories as $category){
		if($category->slug == 'man'){
				$_SESSION['PS_SITE'] = 'man';
		}
	}
	
}

//Request V
if(isset($_REQUEST['v']) && $_REQUEST['v']=='man'){
		$_SESSION['PS_SITE'] = 'man';
}

//HELPERS
function isMan(){
	if($_SESSION['PS_SITE'] == 'man')	{
		return true;	
	}
	else
	{
		return false;	
	}
}
		if(isMan()){
			$theme_primary = 'primary-man';	
			$theme_top_header = 'top-header-man';	
			$theme_footer = 'sobre-pelostop-footer-man';	
		}
		else
		{
			$theme_primary = 'primary';
			$theme_top_header = 'top-header';	
			$theme_footer = 'sobre-pelostop-footer';	
		}

//print '<!-- '.$_SESSION['PS_SITE'].' '.$post->post_name.' -->';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KTBLM8G');</script>
<!-- End Google Tag Manager -->

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php print get_template_directory_uri();?>/images/favicon.png" type="image/x-icon" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
<?php wp_head(); ?>
<link rel='stylesheet' id='wp-bootstrap-starter-bootstrap-css-css'  href='<?php print get_template_directory_uri();?>/css/bootstrap.min.css?ver=4.8' type='text/css' media='all' />
<link rel='stylesheet' id='wp-bootstrap-starter-font-awesome-css'  href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' media='all' />
<script>var base_url = '<?php print get_site_url();?>';</script>
<link rel="stylesheet" type="text/css" href="<?php print get_template_directory_uri();?>/css/styles.css" />
<!-- Scrip Google Llamadas -->
<script type="text/javascript">

(function(a,e,c,f,g,h,b,d){var k={ak:"990254839",cl:"ZnM5CP3L2msQ962Y2AM",autoreplace:"900 828 410"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[g]||(a[g]=k.ak);b=e.createElement(h);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(h)[0];d.parentNode.insertBefore(b,d);a[f]=function(b,d,e){a[c](2,b,k,d,null,new Date,e)};a[f]()})(window,document,"_googWcmImpl","_googWcmGet","_googWcmAk","script");

</script>
<!-- END Scrip Google Llamadas -->
<!-- Facebook Pixel Code -->

<script>

!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;

n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,

document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1682701535309718'); // Insert your pixel ID here.

fbq('track', 'PageView');

</script>

<noscript><img height="1" width="1" style="display:none"

src="https://www.facebook.com/tr?id=1682701535309718&ev=PageView&noscript=1"

/></noscript>

<!-- DO NOT MODIFY -->

<!-- End Facebook Pixel Code -->

<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/a1e5b9576075575dc1265d38a/e0faf25b07727e04c9ca78e38.js");</script>
</head>
<body id="<?php print $_SESSION['PS_SITE'];?>" <?php body_class(); ?>>
<?php
   
   //Woocomerce carrito
    global $woocommerce;
	
	$url_promociones = get_site_url().'/promociones';
	if(isMan()){
	$url_promociones = get_site_url().'/promociones-man';
	}
   
?>
<script>
		    function changeClass()
    {
		var dataattribute = document.getElementById("button-click-overlay").dataset.class;
        document.getElementById("button-click-overlay").className = "ult-overlay overlay-cornerbottomleft ult-open " + dataattribute;
		var children = document.querySelectorAll(".ult_modal .ult_modal-content");
		var tommy = document.getElementById(children[0].getAttribute("id"));
		tommy.className = "ult_modal-content";
    }
	</script>

<div id="botonhome"><button id="button_top_text" onclick="changeClass()" data-ultimate-target="#modal-trg-txt-wrap-4734 .btn-modal" data-responsive-json-new="{&quot;font-size&quot;:&quot;desktop:25px;&quot;,&quot;line-height&quot;:&quot;&quot;}" data-class-id="content-587cb9d75f1e1" data-overlay-class="overlay-cornerbottomleft">
<img src="https://pelostop.es/wp-content/uploads/2018/04/banner-financiación-home-alta.png"></img></button></div>

<div id="carrito"><a class="btn green btn-show-carrito"><div class="hidden-xs"><span><i class="fa fa-shopping-cart" aria-hidden="true"></i> MI CARRITO</span></div><div class="hidden-md hidden-lg hidden-sm"><i class="fa fa-shopping-bag" aria-hidden="true"></i></div></a>
  <div class="detalle">
    <p><?php print_r(WC()->cart->get_cart_contents_count());?> producto/s</p>
    <h3><?php print_r(WC()->cart->get_cart_total());?></h3>
    <a href="<?php print $url_promociones;?>">¡Aprovecha nuestras ofertas especiales! </a> <a class="btn green" href="<?php print_r(WC()->cart->get_cart_url());?>">Ir al Carrito</a> </div>
	<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
</div>


<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#content">
<?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?>
</a>
<header id="masthead" class="site-header navbar navbar-static-top" role="banner">
  <div class="container-fluid top-header" >
  
    <div class="container">
      <a href="/especialistas-en-depilacion-laser"><h2>Expertos en depilación láser</h2></a>
      <nav id="top-header-menu" role="navigation">
        <?php
		            wp_nav_menu( array(
		                'theme_location'    => $theme_top_header,
		                'depth'             => 3,
		                'container'         => '',
		                'container_class'   => '',
		                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		                'walker'            => new wp_bootstrap_navwalker())
		            );
		        ?>
      </nav>
      <ul class="contact">
        <li><a onClick="ga('send', 'event', 'Llamada', 'Boton', 'Llamada')" ><i class="fa fa-phone" aria-hidden="true"></i> 900 828 410</a></li>
        <li><a href="mailto:info@pelostop.es" onClick="ga('send', 'event', 'Email', 'Boton', 'Informacion')" ><i class="fa fa-envelope-o" aria-hidden="true"></i> info@pelostop.com</a></li>
      </ul>
      <ul class="login">
        <li><a class="btn_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</a>
          <div class="search-box">
            <form action="" method="get">
              <input type="text" name="s" value="" placeholder="Buscar..." />
            </form>
          </div>
        </li>
        <li>
          <?php if ( is_user_logged_in() ) { ?>
          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="Mi cuenta">Mi cuenta</a>
          <?php } 
 else { ?>
          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="Iniciar sesión">Iniciar sesión</a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </div>
 
  <div id="sticky">
  <div class="container"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header"> <a id="btn-menu-responsive"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
      <div id="menu-responsive"></div>
      <div class="navbar-brand">
        <ul>
          <li <?php if($_SESSION['PS_SITE']=='woman') print 'class="active"';?>><a href="<?php print get_site_url();?>"><img src="<?php print get_template_directory_uri();?>/images/pelostop-woman.png"></a></li>
          <li <?php if($_SESSION['PS_SITE']=='man') print 'class="active"';?>><a href="<?php print get_site_url();?>/man/"><img src="<?php print get_template_directory_uri();?>/images/pelostop-man.png"></a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-8">
      <nav id="social-links" role="navigation">
        <ul>
          <li><a href="http://www.facebook.com/pages/Pelostop/138882672788719" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
          <li><a href="http://twitter.com/pelostop" target="_blank"> <i class="fa fa-twitter" aria-hidden="true"></i></a></li>
			<li><a href="https://instagram.com/pelostop_oficial" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"></i></a></li>
          <li><a href="https://www.youtube.com/channel/UClrJhSUlJdGYs6GSVsFtTrg" target="_blank"> <i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <nav id="menu-principal" role="navigation">
        <?php
		
		
		
		            wp_nav_menu( array(
		                'theme_location'    => $theme_primary,
		                'depth'             => 3,
		                'container'         => '',
		                'container_class'   => '',
		        		'container_id'      => 'navbar-collapsed',
		                'menu_class'        => 'nav navbar-nav',
		                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		                'walker'            => new wp_bootstrap_navwalker())
		            );
		        ?>
      </nav>
    </div>
  </div>
  </div>
</header>
<!-- #masthead -->

<?php
	
	print '<!-- SITE URL'. get_site_url().'-->';
	
	
	?>


<div id="content" class="site-content ps-<?php print $post->post_name;?>">
<div class="container">
<div class="row">