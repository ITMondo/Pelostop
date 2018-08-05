<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $wpdb, $post, $woocommerce;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><strong>Cómpralo en tu centro o llama al 900 828 410</strong></p>
	<?php else : ?>
    
    
    				<?php
					
					//Para Packs
						if(isPack($product->id)){
							
							
							$isVariationZona = false;
							$isRegalo = false;
							$isProducto = false;

							print '<!--';
							
							
							
							
						
							$available_variations = $product->get_variation_attributes();
						
						
							$count = 0;
							foreach($available_variations as $key => $variation){
								
								
		
								if($key=='pa_zona'){
									
									$isVariationZona = true;
									
								}
								if($key=='pa_grupo-regalo'){
									
									$isRegalo = true;
									
								}
								if($key=='pa_producto'){
									
									$isProducto = true;
									
								}
							
							}
							
							
							
							print '-->';
							
							
							
							
						?>
                       
                       
                       <?php
							
							if(!$isVariationZona && !$isRegalo &!$isProducto){
							
							?>
                        <div class="ps-add-to-cart">
   						 	<div class="col-md-8 text-left precios">
                         		<div class="title"><?php print $product->get_title();?></div>
                       			 <div class="box_price"><?php print $product->get_price_html( );?></div>
                        	</div>
                        	<div class="col-md-4 call-to-action">
                        	<a class="add-to-cart btn disabled" href=""><i class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>
                       		 </div>
                        </div>
                        
                        
                        
                        
                        <?php	




						print '<div id="pack-selector">';
						$available_variations = $product->get_variation_attributes();
						
						
							$count = 0;
							foreach($available_variations as $key => $variation){
								
								
		
									switch($key){
										
										case 'pa_grupo':$title='Grupo';break;
										case 'pa_bono':$title='Bono';break;
										case 'pa_producto':$title='Producto';break;
	
										default:$title=$key;break;
									}
					
									
									
									
									if($count>0){
										
										print '<div class="variations_'.$count.'">';
									}
									
									print '<h5 class="variation-title">Selecciona '.$title.'</h5>';
		
									print '<ul class="variations var_'.$count.'">';
									
										
										
									if($count>0){
										
										print '</div>';
									}	
									
									$count++;
									print '</ul>';
									
								
								
								
							}
						
                        print '</div>';
						
						//End pack selector
                        
                      
		
							$all_available_variations = $product->get_available_variations();
							
							
							$arr_variaciones = array();
							foreach($all_available_variations as $item_variacion){
								
								
								
								if($item_variacion['variation_is_active']==1 && $item_variacion['variation_is_visible']==1){
									
								$taxonomy = 'pa_bono';
								$meta = get_post_meta($item_variacion['variation_id'], 'attribute_'.$taxonomy, true);
								$bono = get_term_by('slug', $meta, $taxonomy);
								
								$taxonomy = 'pa_grupo';
								$meta = get_post_meta($item_variacion['variation_id'], 'attribute_'.$taxonomy, true);
								$grupo = get_term_by('slug', $meta, $taxonomy);
								
								$var = array(
									'id'=>(int)$item_variacion['variation_id'],
									'product_id'=>(int)$product->get_id(),
									'grupo'=> $item_variacion['attributes']['attribute_pa_grupo'],
									'grupo_name'=>$grupo->name,
									'bono'=> $item_variacion['attributes']['attribute_pa_bono'],
									'bono_name'=>$bono->name,
									'precio'=>$item_variacion['display_price'],
								
								
								);
								
								array_push($arr_variaciones,$var);			
								}
								
								
							}
							
							
							?>
                            <script>
							var variations = <?php print json_encode($arr_variaciones);?>;
							var init_price = '<?php print $product->get_price_html( );?>';
							var cart_url = '<?php print $woocommerce->cart->get_cart_url();?>';
							</script>
  							<script src="<?php print get_template_directory_uri();?>/js/pelostop-packs.js"></script> 
                              
                      
                      
                      
                      
                      
                      
                            
                            <?php
							
							$notaprecios = get_post_meta($post->ID,'ps_notaprecios',true);
							if($notaprecios && $notaprecios!=''){
									print '<div class="nota-precios">'.htmlspecialchars_decode(nl2br(($notaprecios))).'</div>';
							}
							?>
							
							
							<?php
								
							}
							else if($isVariationZona && !$isRegalo) //Es variacion de zona
							{
							?>
							
								
								
								
						<div class="ps-add-to-cart">
   						 	<div class="col-md-8 text-left precios">
                         		<div class="title"><?php print $product->get_title();?></div>
                       			 <div class="box_price"><?php print $product->get_price_html( );?></div>
                        	</div>
                        	<div class="col-md-4 call-to-action">
                        	<a class="add-to-cart btn disabled" href=""><i class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>
                       		 </div>
                        </div>

						
						  
                        <?php	




						print '<div id="pack-selector">';
						$available_variations = $product->get_variation_attributes();
						
						
							$count = 0;
							foreach($available_variations as $key => $variation){
								
								
		
									switch($key){
										
										case 'pa_zona':$title='Zona';break;
										default:$title=$key;break;
									}
					
									
									
									
									if($count>0){
										
										print '<div class="variations_'.$count.'">';
									}
									
									print '<h5 class="variation-title">Selecciona '.$title.'</h5>';
		
									print '<ul class="variations var_'.$count.'">';
								
								
								
										$all_available_variations = $product->get_available_variations();
							
							
										$arr_variaciones = array();
										foreach($all_available_variations as $item_variacion){



											if($item_variacion['variation_is_active']==1 && $item_variacion['variation_is_visible']==1){
												$taxonomy = 'pa_zona';
												$meta = get_post_meta($item_variacion['variation_id'], 'attribute_'.$taxonomy, true);
												$grupo = get_term_by('slug', $meta, $taxonomy);
												print '<li class="variation" data-pvp="'.$item_variacion['display_price'].'" data-pid="'.(int)$product->get_id().'"  data-varid="'.$item_variacion['variation_id'].'" data-zona="'.$item_variacion['attributes']['attribute_pa_zona'].' ">'.$grupo->name.'</li>';
												
											
												
											}


										}
								
								
									
										
										
									if($count>0){
										print '</div>';
									}	
									
									$count++;
									print '</ul>';
									
								
								
								
							}
						
                        print '</div>';
								
							?>
    <script>
							var init_price = '<?php print $product->get_price_html( );?>';
							var cart_url = '<?php print $woocommerce->cart->get_cart_url();?>';
							</script>
  							<script src="<?php print get_template_directory_uri();?>/js/pelostop-packs-zona.js"></script> 							   <?php
							
							$notaprecios = get_post_meta($post->ID,'ps_notaprecios',true);
							if($notaprecios && $notaprecios!=''){
									print '<div class="nota-precios">'.htmlspecialchars_decode(nl2br(($notaprecios))).'</div>';
							}
							?>	
								
								
							<?php
								
							}
							else if($isRegalo) //Es variacion de regalo
							{
							?>
							
								
								
								
						<div class="ps-add-to-cart">
   						 	<div class="col-md-8 text-left precios">
                         		<div class="title"><?php print $product->get_title();?></div>
                       			 <div class="box_price"><?php print $product->get_price_html( );?></div>
                        	</div>
                        	<div class="col-md-4 call-to-action">
                        	<a class="add-to-cart btn disabled" href=""><i class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>
                       		 </div>
                        </div>
                        
                        
                        
                        
                        <?php	




						print '<div id="pack-selector">';
						$available_variations = $product->get_variation_attributes();
						
						
							$count = 0;
							foreach($available_variations as $key => $variation){
								
								
		
									switch($key){
										
										case 'pa_grupo':$title='Grupo';break;
										case 'pa_grupo-regalo':$title='Grupo de Regalo';break;
										default:$title=$key;break;
									}
					
									
									
									
									if($count>0){
										
										print '<div class="variations_'.$count.'">';
									}
									
									print '<h5 class="variation-title">Selecciona '.$title.'</h5>';
		
									print '<ul class="variations var_'.$count.'">';
									
										
										
									if($count>0){
										
										print '</div>';
									}	
									
									$count++;
									print '</ul>';
									
								
								
								
							}
						
                        print '</div>';
						
						//End pack selector
                        
                      
		
							$all_available_variations = $product->get_available_variations();
							
							
							$arr_variaciones = array();
							foreach($all_available_variations as $item_variacion){
								
								
								
								if($item_variacion['variation_is_active']==1 && $item_variacion['variation_is_visible']==1){
									
								$taxonomy = 'pa_grupo';
								$meta = get_post_meta($item_variacion['variation_id'], 'attribute_'.$taxonomy, true);
								$grupo = get_term_by('slug', $meta, $taxonomy);
								
								$taxonomy = 'pa_grupo-regalo';
								$meta = get_post_meta($item_variacion['variation_id'], 'attribute_'.$taxonomy, true);
								$grupo_regalo = get_term_by('slug', $meta, $taxonomy);
								
								$var = array(
									'id'=>(int)$item_variacion['variation_id'],
									'product_id'=>(int)$product->get_id(),
									'grupo'=> $item_variacion['attributes']['attribute_pa_grupo'],
									'grupo_name'=>$grupo->name,
									'regalo'=> $item_variacion['attributes']['attribute_pa_grupo-regalo'],
									'regalo_name'=>$grupo_regalo->name,
									'precio'=>$item_variacion['display_price'],
								
								
								);
								
								array_push($arr_variaciones,$var);			
								}
								
								
							}
							
							
							?>
                            <script>
							var variations = <?php print json_encode($arr_variaciones);?>;
							var init_price = '<?php print $product->get_price_html( );?>';
							var cart_url = '<?php print $woocommerce->cart->get_cart_url();?>';
							</script>
  							<script src="<?php print get_template_directory_uri();?>/js/pelostop-packs-grupo-regalo.js"></script> 
                              
                      
                      
                      
                      
                      
                      
                            
                            <?php
							
							$notaprecios = get_post_meta($post->ID,'ps_notaprecios',true);
							if($notaprecios && $notaprecios!=''){
									print '<div class="nota-precios">'.htmlspecialchars_decode(nl2br(($notaprecios))).'</div>';
							}
							?>
								
								
							<?php			
							} //END Variacion COMIENZO DE PRODUCTO
							elseif($isProducto){?>
							
							<ul class="ps_variaciones">
    
    				<?php 
					
					
					$available_variations = $product->get_available_variations();
					
					
					foreach($available_variations as $variacion){
						
						
						
						
						
						
						$title_slug = $variacion['attributes']['attribute_pa_producto'];
						
						
					
						
						$res = $wpdb->get_results("SELECT * FROM wp_terms WHERE slug = '".$title_slug."'");
					
					
						
						print '<li>';
						print '<div class="col-md-8 detail-variation">';
						
						

						print '<h2>'.$variacion['variation_description'].'</h2>';
						print '<span class="price">'.wc_price($variacion['display_price']).'</span>';
						
						
						print '</div>';
						print '<div class="col-md-4">';
						$url = '<a class="add-to-cart btn" href="'.$woocommerce->cart->get_cart_url().'?add-to-cart='.$product->get_id().'&variation_id='.$variacion['variation_id'].'&attribute_pa_producto='.$variacion['attributes']['attribute_pa_producto'].'"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>';
						print $url;
						print '</div>';

						print '</li>';
					}
					
					
					
					$notaprecios = get_post_meta($post->ID,'ps_notaprecios',true);
					if($notaprecios && $notaprecios!=''){
							print '<li>'.htmlspecialchars_decode(nl2br(($notaprecios))).'</li>';
					}
					
					?>
                    
                    
					
                    </ul>
						
						
						
						
						
						
						
						
						
						
						
						
						
							<!-- End producto -->
							<?php
							}
							?>
							
							
						<?php	

						}
						//End Packs
						else
						{
					?>
    
    
    				<ul class="ps_variaciones">
    
    				<?php 
					
					
					$available_variations = $product->get_available_variations();
					
					
					foreach($available_variations as $variacion){
						
						
						
						
						
						$title_slug = $variacion['attributes']['attribute_pa_tipo-pack'];
						
						
					
						
						$res = $wpdb->get_results("SELECT * FROM wp_terms WHERE slug = '".$title_slug."'");
					
					
						
						print '<li>';
						print '<div class="col-md-8 detail-variation">';
						
						

						print '<h2>'.$res[0]->name.'</h2>';
						if($variacion['ps_precio_sesion']!='' && $variacion['ps_precio_sesion']>0){
						print '<span class="price">'.wc_price($variacion['ps_precio_sesion']).'  / sesión ';
							if($variacion['ps_variacion_notaprecio']!=''){
								print $variacion['ps_variacion_notaprecio'];
							}
							print '</span>';
							print '<br/><span class="nota-precio">'.$variacion['price_html'].' '.$res[0]->name.'</span>';
						}
						else
						{
						print $variacion['price_html'].'  <span class="price">/ sesión</span> ';
							if($variacion['ps_variacion_notaprecio']!=''){
							print $variacion['ps_variacion_notaprecio'];
							}	
						}
						print '</div>';
						print '<div class="col-md-4">';
						$url = '<a class="add-to-cart btn" href="'.$woocommerce->cart->get_cart_url().'?add-to-cart='.$product->get_id().'&variation_id='.$variacion['variation_id'].'&attribute_pa_tipo-pack='.$variacion['attributes']['attribute_pa_tipo-pack'].'"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Comprar</a>';
						print $url;
						print '</div>';

						print '</li>';
					}
					
					
					
					$notaprecios = get_post_meta($post->ID,'ps_notaprecios',true);
					if($notaprecios && $notaprecios!=''){
							print '<li>'.htmlspecialchars_decode(nl2br(($notaprecios))).'</li>';
					}
					
					?>
                    
                    
					
                    </ul>
                    
                    <?php
						}
						//End Product variation
						?>
    
    
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
			
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				//do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				//do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				//do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
