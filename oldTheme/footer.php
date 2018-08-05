<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
</div>
</div>


<?php
	if($_SESSION['PS_SITE'] == 'man')	{
		$theme_footer =  'sobre-pelostop-footer-man';	
	}
	else
	{
		$theme_footer =  'sobre-pelostop-footer';	
	}
?>

<footer class="container-fluid">
  <div class="container">
    <div class="col-md-8 col-sm-12">
      <div class="block">
        <h3>TRATAMIENTOS DEPILACIÓN MUJER</h3>
        
        
        <?php
		
		$terms = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent'=>0,
			'slug'=>'woman'
		) );	
		
		
		$ps_category = $terms[0];
			
		$sub_categories = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent'=>$ps_category->term_id,
		) );	
		
		foreach($sub_categories as $sub_cat){
				
				
				if($sub_cat->slug != 'pack' && $sub_cat->slug != 'promocion' ){				
			
					print '<h4>'.$sub_cat->name.'</h4>';

					
						print '<ul class="products">';
						$ps_products = get_posts(array(
						  'post_type' => 'product',
						  'numberposts' => -1,
						  'orderby'=>'menu_order',
						  'order'=>'ASC',
						  'tax_query' => array(
							array(
							  'taxonomy' => 'product_cat',
							  'field' => 'term_id',
							  'terms' => $sub_cat->term_id, // Where term_id of Term 1 is "1".
							  'include_children' => false
							)
						  )
						));
						
				
				
						foreach ( $ps_products as $ps_product ) {
							
							$class="";
							

							if($ps_product->post_name == $post->post_name){
								$class='class="current_page_item"';	
							}
							
							print '<li '.$class.'><a class="product" data-id="'.$ps_product->post_name.'" href="'.get_the_permalink($ps_product->ID).'">'.$ps_product->post_title.'</a></li>';
						}
				
						print '</ul>';
						
				}
				
			}
		
		
		?>
      </div>
      
      <div class="block">
        <h3>TRATAMIENTOS DEPILACIÓN HOMBRE</h3>
        <?php
		
		$terms = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent'=>0,
			'slug'=>'man'
		) );	
		
		
		$ps_category = $terms[0];
			
		$sub_categories = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent'=>$ps_category->term_id,
		) );	
		
		foreach($sub_categories as $sub_cat){
				
				
				if($sub_cat->slug != 'pack-man' && $sub_cat->slug != 'promocion-man' ){				
			
					print '<h4>'.$sub_cat->name.'</h4>';

					
						print '<ul class="products">';
						$ps_products = get_posts(array(
						  'post_type' => 'product',
						  'numberposts' => -1,
						  'orderby'=>'menu_order',
						  'order'=>'ASC',
						  'tax_query' => array(
							array(
							  'taxonomy' => 'product_cat',
							  'field' => 'term_id',
							  'terms' => $sub_cat->term_id, // Where term_id of Term 1 is "1".
							  'include_children' => false
							)
						  )
						));
						
				
				
						foreach ( $ps_products as $ps_product ) {
							
							$class="";
							

							if($ps_product->post_name == $post->post_name){
								$class='class="current_page_item"';	
							}
							
							print '<li '.$class.'><a class="product" data-id="'.$ps_product->post_name.'" href="'.get_the_permalink($ps_product->ID).'">'.$ps_product->post_title.'</a></li>';
						}
				
						print '</ul>';
						
				}
				
			}
		
		
		?>
      </div>
      
      <div class="block">
         <?php
		            wp_nav_menu( array(
		                'theme_location'    => $theme_footer,
		                'depth'             => 3,
		                'container'         => '',
		                'container_class'   => 'sobre-pelostop'
						)
		            );
		        ?>
      
      </div>
      
    </div>
    <div class="col-md-4 social">
    <h3>SÍGUENOS</h3>
        <ul>
    	<li><a href="http://www.facebook.com/pages/Pelostop/138882672788719" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
    	<li><a href="http://twitter.com/pelostop" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    	<li><a href="https://es.linkedin.com/company/ochalgroup-2005-sl---pelostop" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
      	<li><a href="https://instagram.com/pelostop_oficial" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    	<li><a href="https://www.youtube.com/channel/UClrJhSUlJdGYs6GSVsFtTrg" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
    	<li><a href="https://plus.google.com/+PelostopEspa%C3%B1a?hl=es" target="_blank" ><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
    </ul>

    
    </div>
    
    
  </div>
  <div class="container footer-legales">
  <div class="col-md-12 ">
  <span>&copy; 2018 Pelostop.es</span>
   <?php
		            wp_nav_menu( array(
		                'theme_location'    => 'legales-pelostop-footer',
		                'depth'             => 3,
		                'container'         => '',
		                'container_class'   => 'legales-pelostop'
						)
		            );
		        ?>
  </div>
  </div>
</footer>


<!-- #page -->

<!-- Tooltip HTML -->
<div id="ps_tooltip" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>
<div class="modal-body modal-acciona text-left">
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
</div>
     </div>
  </div>
</div>



<?php wp_footer(); ?>


<div id="thanks"></div>

<script src="<?php print get_template_directory_uri();?>/js/pelostop-global.js"></script>

<?php

if(is_order_received_page()){
	
					$order = new WC_Order(WCORDER);
					$OrderID = WCORDER;
					$products = false;
					
					$order_item = $order->get_items();

					foreach( $order_item as $product ) {
						if(!$products){
						
						$products = $product['product_id'];
						}
						else
						{
						$products.= "-".$product['product_id'];
						}
					}
					
					
?>	



<script>

var versaTag = {};
versaTag.id = "4289";
versaTag.sync = 0;
versaTag.dispType = "js";
versaTag.ptcl = "HTTPS";
versaTag.bsUrl = "bs.serving-sys.com/BurstingPipe";
//VersaTag activity parameters include all conversion parameters including custom parameters and Predefined parameters. Syntax: "ParamName1":"ParamValue1", "ParamName2":"ParamValue2". ParamValue can be empty.
versaTag.activityParams = {
//Predefined parameters:
"OrderID":"<?php print $OrderID;?>","Session":"","Value":"<?php print $order->total;?>","productid":"<?php print $products;?>","productinfo":"","Quantity":""
//Custom parameters:
};
//Static retargeting tags parameters. Syntax: "TagID1":"ParamValue1", "TagID2":"ParamValue2". ParamValue can be empty.
versaTag.retargetParams = {};
//Dynamic retargeting tags parameters. Syntax: "TagID1":"ParamValue1", "TagID2":"ParamValue2". ParamValue can be empty.
versaTag.dynamicRetargetParams = {};
// Third party tags conditional parameters and mapping rule parameters. Syntax: "CondParam1":"ParamValue1", "CondParam2":"ParamValue2". ParamValue can be empty.
versaTag.conditionalParams = {};
</script>
<script id="ebOneTagUrlId" src="https://secure-ds.serving-sys.com/SemiCachedScripts/ebOneTag.js"></script>
<noscript>
<iframe src="https://bs.serving-sys.com/BurstingPipe?
cn=ot&amp;
onetagid=4289&amp;
ns=1&amp;
activityValues=$$Value=[Value]&amp;OrderID=[OrderID]&amp;Session=[Session]&amp;ProductID=[ProductID]&amp;ProductInfo=[ProductInfo]&amp;Quantity=[Quantity]$$&amp;
retargetingValues=$$$$&amp;
dynamicRetargetingValues=$$$$&amp;
acp=$$$$&amp;"
style="display:none;width:0px;height:0px"></iframe>
</noscript>







<?php 
}
else
{

?>



<script>

var versaTag = {};
versaTag.id = "4289";
versaTag.sync = 0;
versaTag.dispType = "js";
versaTag.ptcl = "HTTPS";
versaTag.bsUrl = "bs.serving-sys.com/BurstingPipe";
//VersaTag activity parameters include all conversion parameters including custom parameters and Predefined parameters. Syntax: "ParamName1":"ParamValue1", "ParamName2":"ParamValue2". ParamValue can be empty.
versaTag.activityParams = {
//Predefined parameters:
"OrderID":"","Session":"","Value":"","productid":"","productinfo":"","Quantity":""
//Custom parameters:
};
//Static retargeting tags parameters. Syntax: "TagID1":"ParamValue1", "TagID2":"ParamValue2". ParamValue can be empty.
versaTag.retargetParams = {};
//Dynamic retargeting tags parameters. Syntax: "TagID1":"ParamValue1", "TagID2":"ParamValue2". ParamValue can be empty.
versaTag.dynamicRetargetParams = {};
// Third party tags conditional parameters and mapping rule parameters. Syntax: "CondParam1":"ParamValue1", "CondParam2":"ParamValue2". ParamValue can be empty.
versaTag.conditionalParams = {};
</script>
<script id="ebOneTagUrlId" src="https://secure-ds.serving-sys.com/SemiCachedScripts/ebOneTag.js"></script>
<noscript>
<iframe src="https://bs.serving-sys.com/BurstingPipe?
cn=ot&amp;
onetagid=4289&amp;
ns=1&amp;
activityValues=$$Value=[Value]&amp;OrderID=[OrderID]&amp;Session=[Session]&amp;ProductID=[ProductID]&amp;ProductInfo=[ProductInfo]&amp;Quantity=[Quantity]$$&amp;
retargetingValues=$$$$&amp;
dynamicRetargetingValues=$$$$&amp;
acp=$$$$&amp;"
style="display:none;width:0px;height:0px"></iframe>
</noscript>
<?php
}
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KTBLM8G"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<?php
	//PIXEL REGISTRO FACEBOOK
	if(isset($_REQUEST['newuser']) && $_REQUEST['newuser']=='true'){
?>		
		<script>

fbq('track', 'CompleteRegistration', {
value: 25.00,
currency: 'EUR'
});

</script>

		<?php		
	}

?>


</body>
</html>