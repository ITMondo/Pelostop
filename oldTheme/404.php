<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>


			<section class="error-404 not-found">
			

				<div class="page-content text-center">


				<div class="row">
				<div class="col-md-12 text-center">
				<h1>Oops!</h1>
	
                    <h2>¡No encontramos la página que buscas!</h2>
                <p>Quizás quieras ir a una de estas páginas:</p>
    			</div>
                </div>
                
                <div class="row links">
                
                	<div class="col-md-2 col-md-offset-3 text-center">
                    	<a href="<?php print get_site_url();?>" class="btn gray">PÁGINA PRINCIPAL</a>
                    </div>
                    <div class="col-md-2 text-center">
                    	<a href="<?php print get_site_url();?>/tratamientos" class="btn gray">TRATAMIENTOS</a>
                    </div>
                    <div class="col-md-2 text-center">
                    	<a  href="href=<?php print get_site_url();?>/contacto" class="btn gray">CONTACTO</a>
                    </div>
                
                </div>
                
                
					

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
    

<?php
get_footer();
