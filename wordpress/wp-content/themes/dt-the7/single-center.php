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

include 'config.php';

get_header( 'single' );


?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	class Center {
    private $fields = ['longitude', 'latitude', 'google_place_id', 'street', 'number', 'door', 'zipcode', 'town', 'province', 'telephone','email', 'opening_hours'];

		function __construct($post) {
			$post_meta = get_post_meta($post->ID);
			$this->title = $post->post_title;

			foreach($this->fields as $field){
				if (array_key_exists($field, $post_meta)) {
					$this->$field = $post_meta[$field][0];
				} else {
					$this->$field = '';
				}
			}
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

  $center = new Center($post);
?>

	<?php get_template_part( 'header-main' ) ?>


		<?php do_action( 'presscore_before_loop' ) ?>

		<div id="content" class="content" role="main">

			<iframe
  				width="600"
  				height="450"
  				frameborder="0" style="border:0"
  				src="https://www.google.com/maps/embed/v1/place?key=<?php echo $config["google_api_key"]; ?>&q=place_id:<?php echo $center->google_place_id; ?>" allowfullscreen>
			</iframe>

			<div id="center_meta">
				<ul>
				<li>
	        Dirección: <?php echo $center->street ;?>,
					<?php echo $center->number; ?>.
					<?php echo $center->zipcode; ?>
					<?php echo $center->town; ?>
					(<?php echo $center->province; ?>)
				</li>
				<li>
	        Horario: <?php echo $center->opening_hours;?>
				</li>
				<li>
	        Teléfono: <?php echo $center->telephone;?>
				</li>
				<li>
	        E-mail: <?php echo $center->email;?>
				</li>
			</ul>
			</div>
 <?php
endwhile;
endif;

get_footer();
?>
