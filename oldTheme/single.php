<?php
/* 
Template Name: Single Title Center FullWidth 
*/
get_header(); 
?>
<div class="navigation-wrap">
<nav class="navigation below light" data-sticky-bar="1">
<?php wp_nav_menu( array( 'theme_location' => 'new-menu' ) ); ?>
</nav>	
</div>
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
<?php comments_template(); ?>
</div>
<!-- #primary -->
<?php
$upload_dir = wp_upload_dir();
$upload_dir = $upload_dir['baseurl'];
get_sidebar();
?>
</div>
<!-- #row -->
</div>
<!-- #container --> 

<?php
	print getPromociones();
?>
<?php
	print getNewsletterSmall();
?>
<!-- CENTROS -->
<?php
		print getCentros();
?>
<?php
get_footer();




