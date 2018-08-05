<?php

/* 
Template Name: Single with title 
*/


get_header(); 



?>

<div id="primary" class="content-area col-sm-12 col-md-12 single-title">
  <main id="main" class="site-main" role="main">
  
    <?php
			while ( have_posts() ) : the_post();
			?>
            <div class="col-md-8 col-md-offset-2">
			<h1><?php the_title();?></h1>
            <div class="hr">
            	<hr/>
            </div>
			<?php
            get_template_part( 'template-parts/content', 'page' );
			?>
			</div>
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
	print getNewsletter();
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




