<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product );

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	
    <div class="ps-add-to-cart">
    
    <div class="col-md-8 text-left precios">
    <?php
	
	$ps_descripcion_precio = get_post_meta($product->id,'ps_descripcion_precio',true);
	
	
	if($ps_descripcion_precio && $ps_descripcion_precio!=''){
		print '<span class="nota-precio">'.$ps_descripcion_precio.'</span>';
	}

	
	
	?>
    <?php print $product->get_price_html();?>
    </div>
    <?php
    					print '<div class="col-md-4">';
						$url = '<a class="add-to-cart btn" href="'.$woocommerce->cart->get_cart_url().'?add-to-cart='.$product->get_id().'"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>';
						print $url;
						print '</div>';
    
   
	?>
    </div>
    
    <?php
	 $notaprecios = get_post_meta($product->id,'ps_notaprecios',true);
	if($notaprecios && $notaprecios!=''){
		print '<div class="nota-precios col-md-12">'.htmlspecialchars_decode(nl2br(($notaprecios))).'</div>';
	}
	?>
    

    

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
    
    

<?php endif; ?>
