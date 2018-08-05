<?php

/* 
Template Name: Single Title Center FullWidth 
*/


get_header(); 



?>

<div id="primary" class="content-area col-sm-12 col-md-12 single-title">
  <main id="main" class="site-main" role="main">
  
    <?php
			while ( have_posts() ) : the_post();
			?>
			<h1 class="text-center"><?php the_title();?></h1>
            <div class="hr center">
            	<hr class="center"/>
            </div>
			<?php
            get_template_part( 'template-parts/content', 'page' );
			?>
            <?php
			endwhile; // End of the loop.
			?>
  </main>
  <!-- #main --> 
</div>
<!-- #primary -->
</div>
<!-- #row -->
</div>
<!-- #container --> 
<?php
$upload_dir = wp_upload_dir();
$upload_dir = $upload_dir['baseurl'];

get_sidebar();
?>



<?php
$val = (int)get_post_meta($post->ID,'ps_promociones',true);
if($val==1){
	print getPromociones();
}
?>
<?php
$val = (int)get_post_meta($post->ID,'ps_newsletter',true);
if($val==1){
	
	if(is_home()){
	print getNewsletter();
	}
	else
	{
	print getNewsletterSmall();
	}
}
?>
<!-- CENTROS -->

<?php
$val = (int)get_post_meta($post->ID,'ps_buscador',true);
if($val==1){
		print getCentros();

}
?>

<?php
get_footer();




