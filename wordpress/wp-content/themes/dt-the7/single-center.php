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

get_header();

while(have_posts()) {
  the_post();

  class Center {
    function __construct($post) {
      $this->title = $post->post_title;
    }

    public $title;
  }
  $center = new Center($post);

  ?>

  <ul>
    <li>
      <?php print $center->title ?>
    </li>
  </ul>

  <?php
}
// $args = array(
//     'post_type' => 'center',

// )


get_footer();
?>
