<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product,$woocommerce;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>


<div class="col-md-6">
<?php 


$image = wp_get_attachment_image_src($product->image_id,'full');
	

?>
<img src="<?php print $image[0];?>" class="image-product-crosselling" />

</div>
<div class="col-md-6 description">
<div class="info">
<?php print htmlspecialchars_decode(nl2br(($product->description)));
?>
<p>Precio Pack: <span class="regular"><?php print $product->regular_price;?>€</span>
<span class="price"><?php print $product->sale_price;?>€</span>
</div>

<?php
print '<a class="add-to-cart btn" href="'.$woocommerce->cart->get_cart_url().'?add-to-cart='.$product->get_id().'"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>';
?>

</div>
	
    
