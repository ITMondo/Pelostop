<?php
/**
 * 
 *
 */

function dt_add_CPT_to_microsite_metabox() {

	global $DT_META_BOXES;

	if ( $DT_META_BOXES ) {
        foreach($DT_META_BOXES  as $id => $metabox) {
	        if ( isset( $metabox['id'] ) && ( $metabox['id'] == 'dt_page_box-microsite' ) ||  ( $metabox['id'] == 'dt_page_box-microsite_logo' ) ) {
		        $DT_META_BOXES[$id]['pages'][] = 'centro';
		        break;
	        }
        }
	}
}

add_action( 'admin_init', 'dt_add_CPT_to_microsite_metabox', 30 );

function add_dt_metaboxes_custom( $pages ) {
 $pages[] = 'centro';
 return $pages;
 }
 
 add_filter( 'presscore_pages_with_basic_meta_boxes', 'add_dt_metaboxes_custom' );