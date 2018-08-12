<?php
/**
 * The Template for displaying all single posts.
 *
 * @package The7
 * @since   1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'single' );


?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	class Center {
    private $fields = ['longitude', 'latitude', 'google_place_id'];

		function __construct($post) {
			$post_meta = get_post_meta($post->ID);
			$this->title = $post->post_title;


			foreach($this->fields as $field){
				$this->$field = $post_meta[$field][0];
			}

			//$attributes_json = json_encode($attributes);
		}


		public $title;

		public function get_attributes_json(){
			$field_array = array();
			foreach($this->fields as $field) {
				$field_array[$field] = $this->$field;
			}
			return json_encode($field_array);
		}
	}

	//get_attributes($$field);

  $center = new Center($post);
?>
	adhs (above content)

	<?php get_template_part( 'header-main' ) ?>
joo (down)

	<?php if ( presscore_is_content_visible() ): ?>
hurn (down)
		<?php do_action( 'presscore_before_loop' ) ?>
hello (down)
		<div id="content" class="content" role="main">
content

				<iframe
  				width="600"
  				height="450"
  				frameborder="0" style="border:0"
  				src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCYd8IA-EXnP5i9eUGf3WeIJpj3nOFuVVA&q=place_id:<?php echo $center->google_place_id; ?>" allowfullscreen>
</iframe>
			</div>




			<?php if ( post_password_required() ): ?>
				steht nirgends
				<article id="post-<?php the_ID() ?>" <?php post_class() ?>>
steht nirgends
					<?php
					do_action( 'presscore_before_post_content' );

					the_content();

					do_action( 'presscore_after_post_content' );

					?>

				</article>

			<?php else: ?>

				<?php get_template_part( 'content-single', str_replace( 'dt_', '', get_post_type() ) ) ?>

				echo "content";

			<?php endif ?>

			<?php comments_template( '', true ) ?>

		</div><!-- #content -->

		<?php do_action( 'presscore_after_content' ) ?>

	<?php endif // content is visible ?>

<?php endwhile; endif; // end of the loop. ?>

<?php get_footer() ?>
