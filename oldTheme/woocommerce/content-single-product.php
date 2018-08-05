<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

</div>
</div>
</div>
</div>


<?php

   
   	$is_pack = isPack(get_the_ID());
   
	
	if($is_pack==true){
		$class = 'bg-pack';	
	}
	else
	{
		$class = 'bg-single-producto';	
	}
   
          ?>

<div id="product-<?php the_ID(); ?>" <?php post_class($class); ?>>
	<div class="container">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
	<div class="summary entry-summary">
		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
<div class="col-md-12 text-right">
	<ul class="woocomerce-social">
    	<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php print urlencode(home_url(add_query_arg(array(),$wp->request)));?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
    	<li><a href="https://twitter.com/home?status=<?php print urlencode(home_url(add_query_arg(array(),$wp->request)));?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    	<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php print urlencode(home_url(add_query_arg(array(),$wp->request)));?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
    	<li><a href="https://plus.google.com/share?url=<?php print urlencode(home_url(add_query_arg(array(),$wp->request)));?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
    </ul>
</div>

<?php    
$is_pack = isPack($post->ID);
if($is_pack)
{
?>

<div class="condiciones hidden-lg hidden-md">
<?php
global $post;
$ps_condiciones = get_post_meta($post->ID,'ps_condiciones',true);
							if($ps_condiciones && $ps_condiciones!=''){
									print htmlspecialchars_decode(nl2br(($ps_condiciones)));
}
                            ?>
</div>
<?php
}
?>
</div><!-- .summary -->

<!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
	

</div>
</div>

<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

<?php
	if($is_pack){
		get_sidebar('packs');	
	}

?>


</div>
