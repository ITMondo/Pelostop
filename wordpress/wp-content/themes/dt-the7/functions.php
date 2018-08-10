<?php
/**
 * The7 theme.
 * @package The7
 * @since   1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set the content width based on the theme's design and stylesheet.
 * @since 1.0.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 * @since 1.0.0
 */
require( trailingslashit( get_template_directory() ) . 'inc/init.php' );

// add bootstrap
function my_scripts() {
  wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
  wp_enqueue_style('pelostopCSS', get_template_directory_uri() . '/pelostop.css');
  wp_enqueue_script( 'boot3', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ),'',true );
  wp_enqueue_script( 'googleMaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBX883Unw_-pC7pFogMWdNzklp0GQEsa9U&callback=initMap','','',true );
}
add_action( 'wp_enqueue_scripts', 'my_scripts' );

// add google maps


/**
 * Add a custom product tab.
 */
function custom_product_tabs( $tabs) {
	$tabs['centers'] = array(
		'label'		=> __( 'Centers', 'woocommerce' ),
		'target'	=> 'centers_options',
		//'class'		=> array( 'show_if_simple', 'show_if_variable'  ),
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );
/**
 * Contents of the gift card options product tab.
 */
function giftcard_options_product_tab_content() {
	global $post;
	global $title;
    $centers = get_posts(array('post_type' => 'center'));

	// Note the 'id' attribute needs to match the 'target' parameter set above
	?><div id='centers_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'><?php
              foreach ($centers as $center) {
                $id = $center->ID;
                $title = $center->post_title;
                woocommerce_wp_checkbox( array(
                    'id' 		=> "center_$id",
                    'label' 	=> __( $title, 'woocommerce' ),
                                               ) );
              }
		?></div>

	</div><?php
}
add_filter( 'woocommerce_product_data_panels', 'giftcard_options_product_tab_content' ); // WC 2.6 and up

/**
 * Save the custom fields.
 */
function save_giftcard_option_fields( $post_id ) {
  $centers = get_posts(array('post_type' => 'center'));
  foreach($centers as $center) {
    $center_key = "center_" . $center->ID;
	$has_center = isset( $_POST[$center_key] ) ? 'yes' : 'no';
    echo $center->ID . " " . $has_center;
	update_post_meta($post_id, $center_key, $has_center);
  }
}
add_action( 'woocommerce_process_product_meta_simple', 'save_giftcard_option_fields'  );
add_action( 'woocommerce_process_product_meta_variable', 'save_giftcard_option_fields'  );


/**
   Center Post Type
 */
// var_dump(get_posts(array('post_type' => 'center')));


function create_post_type() {
  register_post_type( 'center',
                      array(
                          'labels' => array(
                              'name' => __( 'Centers' ),
                              'singular_name' => __( 'Center' )
                                            ),
                          'public' => true,
                          'has_archive' => true,
                          'supports' => array('title')
                            )
                      );
}
add_action( 'init', 'create_post_type' );

$center_fields = array(
	array('id'=>'latitude','name'=>'Latitud'),
	array('id'=>'longitude','name'=>'Longitud'),
);

function center_register_meta_fields() {
  global $center_fields;
  foreach($center_fields as $center){
    register_meta('post',$center['id'],'sanitize_text_field');
  }
}
add_action('init', 'center_register_meta_fields');

function centers_meta_boxes() {
  add_meta_box('centers-meta-box', 'Datos del Centro', 'centers_meta_box_callback', 'center', 'normal','high');
}
add_action('add_meta_boxes', 'centers_meta_boxes' );

function centers_meta_box_callback($post){
  global $post, $center_fields;
  foreach($center_fields as $center) {
    print '<p><label class="label">'.$center['name'].'</label><br/>';
    print '<input name="'.$center['id'].'" id="'.$center['id'].'" type="text" value="'.htmlspecialchars(get_post_meta($post->ID, $center['id'], true)).'"></p>';
  }
}

function save_center() {
  global $post, $center_fields;
  $post_id = $_POST['post_ID'];
  if (!$post_id) return $post;

  foreach($center_fields as $center){
    update_post_meta($post_id, $center['id'], $_POST[$center['id']]);
  }

  if ( $_POST['post_type'] === 'center' )
    wp_insert_term($_POST['post_title'], 'pa_centers', array('slug' => 'center_'.$post_id));
}
add_action('save_post', 'save_center');
add_action('publish_post', 'save_center');

// single product page
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

function my_custom_action() {
  global $product;
  global $wpdb;
  $product_variation_ids = $product->get_children();
  $variations_sql = substr(
      array_reduce($product_variation_ids,
                   function($carry, $item) {
                     return $carry . " OR wp_posts.ID = " . $item;
                   })
      , 4);
  $product_id = $product->get_id();
  // $querystr = "
  //   SELECT wp_termmeta.meta_key, wp_termmeta.meta_value, wp_posts.ID
  //   FROM wp_posts
  //   LEFT JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID
  //   LEFT JOIN wp_terms ON wp_terms.slug = wp_postmeta.meta_value
  //   LEFT JOIN wp_termmeta ON wp_termmeta.term_id = wp_terms.term_id
  //   WHERE wp_postmeta.meta_key = 'attribute_pa_centers' AND ($variations_sql)
  // ";
  // $querystr = "
  //   SELECT wp_postmeta.meta_value
  //   FROM wp_posts
  //   LEFT JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID
  //   WHERE ($variations_sql) AND (wp_postmeta.meta_key = 'attribute_pa_centers')
  // ";
  //
  // $center_ids = array_map(
  //                         function ($var) {
  //                           return substr($var[0], 7);
  //                         }, $wpdb->get_results($querystr, ARRAY_N));
  //
  // $center_sql = substr(
  //     array_reduce($center_ids,
  //                  function($carry, $item) {
  //                    return $carry . " OR wp_posts.ID = " . $item;
  //                  })
  //     , 4);
  // $querystr = "
  //   SELECT wp_postmeta.meta_key, wp_postmeta.meta_value, wp_posts.post_title
  //   FROM wp_posts
  //   LEFT JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID
  //   WHERE ( $center_sql )
  // ";
  // $raw_centers = $wpdb->get_results($querystr, ARRAY_N);


  $centers = array();
  foreach ($product_variation_ids as $variation_id) {
		$product_variation = new WC_Product_Variation( $variation_id );
		$center_id = substr($product_variation->get_variation_attributes()['attribute_pa_centers'], 7);

		$querystr = "
		  SELECT wp_postmeta.meta_key, wp_postmeta.meta_value, wp_posts.post_title
		  FROM wp_posts
		  LEFT JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID
		  WHERE wp_posts.ID = $center_id
		";
		$queried_centers = $wpdb->get_results($querystr, ARRAY_N);

		foreach($queried_centers as $center) {
			if ($center[0] === 'latitude') $latitude = $center[1];
			if ($center[0] === 'longitude') $longitude = $center[1];
		}

      $xCenter = array(
          'longitude' => $longitude,
          'latitude' => $latitude,
					'add_to_cart_url' => $product_variation->add_to_cart_url(),
					'add_to_cart_text' => $product_variation->add_to_cart_text(),
					'center_title' => $center[2],
					'price_html' =>  $product_variation ->get_price_html(),
					'product_title' => $product->get_title(),
					'product_short_description' => $product->get_short_description(),
					'product_image' => $product->get_image()
                       );
      array_push($centers, $xCenter);
  }

  $centers_json = json_encode($centers);

  ?>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Select center (add to cart)
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="map" style="width: 100%; height: 70vh;"></div>
          <script>
            function initMap() {
              var centers = <?php echo $centers_json . ";"; ?>
              console.log(centers);
              var map = new google.maps.Map(
                  document.getElementById('map'), {zoom: 14, center: { lat: 41.390205, lng: 2.154007 }}
              );
              var infowindow = new google.maps.InfoWindow()
              for ( center of centers ) {
                const position = { lat: parseFloat(center.latitude), lng: parseFloat(center.longitude) };
                const content = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h3 id="firstHeading" class="firstHeading"> '+center.center_title+' </h3>'+
            '<div id="bodyContent">'+
            '<p>'+center.product_title+'</p>'+
						'<p>Price: '+center.price_html+' </p>'+
						'<p>'+center.product_short_description+' </p>'+
						'<p>'+center.product_image+'</p>'+
						'<a href="'+center.add_to_cart_url+'">'+center.add_to_cart_text+'</a>'+
            '</div>'+
            '</div>';
						//
                const marker = new google.maps.Marker({ position, map: map, title: center.center_title });
                google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
                  return function() {
                    infowindow.setContent(content);
                    infowindow.open(map,marker);
                  };
                })(marker,content,infowindow));
              }
            }
          </script>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <?php
};
add_action( 'woocommerce_single_product_summary', 'my_custom_action', 30 );


// CUSTOM WOOCOMMERCE TAXONOMY
// $center_fields = array('center_latitude' => 'Latitud', 'center_longitude' => 'Longitud');

// REGISTER TERM META
// add_action( 'init', '___register_term_meta_text' );
// function ___register_term_meta_text() {
//     register_meta( 'term', '__term_meta_text', 'sanitize_text_field' );
// }


// GETTER (will be sanitized)
// function get_term_meta_value( $term_id, $meta_key ) {
//   $value = get_term_meta( $term_id, $meta_key, true );
//   $value = sanitize_text_field( $value );
//   return $value;
// }

/*
// ADD FIELD TO CATEGORY TERM PAGE
add_action( 'pa_centers_add_form_fields', '___add_form_field_term_meta_text' );
function ___add_form_field_term_meta_text() {
  wp_nonce_field( basename( __FILE__ ), 'term_meta_text_nonce' );
  global $center_fields;
  foreach($center_fields as $field => $name) {
    ?>
    <div class="form-field term-meta-text-wrap">
        <label for="<php echo $field; ?>"><?php _e( $name, 'text_domain' ); ?></label>
        <input type="text" name="<?php echo $field; ?>" id="<php echo $field; ?>" value="" />
    </div>
  <?php }
  }

// ADD FIELD TO CATEGORY EDIT PAGE
add_action( 'pa_centers_edit_form_fields', '___edit_form_field_term_meta_text' );
function ___edit_form_field_term_meta_text( $term ) {
  global $center_fields;
  foreach($center_fields as $field => $name) {
    $value = get_term_meta_value($term->term_id, $field);

    if ( ! $value ) $value = ""; ?>

    <tr class="form-field term-meta-text-wrap">
    <th scope="row"><label for="<?php echo $field; ?>"><?php _e( $name, 'text_domain' ); ?></label></th>
        <td>
          <?php wp_nonce_field( basename( __FILE__ ), 'term_meta_text_nonce' ); ?>
          <input type="text" name="<?php echo $field; ?>" id="term-meta-text" value="<?php echo esc_attr( $value ); ?>" />
        </td>
    </tr>
  <?php }
}

// SAVE TERM META (on term edit & create)
// add_action( 'edit_pa_centers',   '___save_term_meta_text' );
// add_action( 'create_pa_centers', '___save_term_meta_text' );
// function ___save_term_meta_text( $term_id ) {
//   global $center_fields;
//   // verify the nonce --- remove if you don't care
//   if ( ! isset( $_POST['term_meta_text_nonce'] ) || ! wp_verify_nonce( $_POST['term_meta_text_nonce'], basename( __FILE__ ) ) )
//     return;

//   foreach($center_fields as $field => $name) {
//     $old_value  = get_term_meta_value( $term_id, $field );
//     $new_value = isset( $_POST[$field] ) ? sanitize_text_field( $_POST[$field] ) : '';

//     if ( $old_value && '' === $new_value )
//       delete_term_meta( $term_id, $field );

//     else if ( $old_value !== $new_value )
//       update_term_meta( $term_id, $field, $new_value );
//   }
// }
*/


// Helpers
function dump($var) {

  echo "<div><pre>";
  var_dump($var);
  echo "</pre></div>";
}
