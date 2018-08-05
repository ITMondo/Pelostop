<?php
//Shortocodes ilustraciones


function getPromociones($args=[]){	

	global $post;
	
	if(isMan($post->ID)){
			
			$slug = 'pack-man';
	}
	else
	{
			$slug = 'pack';
	}
	
	
	if(isset($args['tam']) && $args['tam']=='small'){
		
		$args_pack = array( 'post_type' => 'product',  	'orderby' => 'menu_order title', 'order' => 'ASC', 'posts_per_page' => 2, 'product_cat' => $slug,     'exclude'          => $post->ID, );
    	$packs = get_posts( $args_pack );

		
	?>
    <div class="promociones-widget">
    <div class="col-md-12">
    <h4>Otros packs especiales</h4>
    </div>
    <?php
		foreach($packs as $pack){
			
			print '<div class="item small col-md-6">';
			
			print '<a href="'.get_the_permalink($pack->ID).'"><img src="'.get_the_post_thumbnail_url($pack->ID).'" /></a>';
			
			print ' <div class="detalle">
			<a class="rose" href="'.get_the_permalink($pack->ID).'"><h4>'.$pack->post_title.'</h4></a>
      	<p>'.get_post_meta($pack->ID,'ps_pack_widget_subtitulo',true).'</p>
		</div>';
    		
			
			print '</div>';
			
		}
	?>
    
    </div>
    
    <?php
	}
	else //Pack Grande
	{?>
    
    	<div class="container promociones-widget">

    
    <?php
		
			$args_pack = array( 'post_type' => 'product', 'orderby' => 'menu_order title', 'order' => 'ASC','posts_per_page' => 3, 'product_cat' => $slug );
    		$packs = get_posts( $args_pack );

				foreach($packs as $pack){

		?>
        

  <div class="col-md-4 col-sm-12 item">
  	<a href="<?php print get_the_permalink($pack->ID);?>"><img class="background" src="<?php print get_the_post_thumbnail_url($pack->ID);?>" /></a>
    <div class="caption"> <a href="<?php print get_the_permalink($pack->ID);?>" class="btn"><?php print $pack->post_title;?></a>
      <h3><?php print get_post_meta($pack->ID,'ps_pack_widget_subtitulo',true);?></h3>
    </div>
  </div>
  
  <?php
  
				}
				?>
  

   </div>
        
        
        
        
        
        
        <?php
	}
	?>



<?php

}
add_shortcode('ps_packs', 'getPromociones');