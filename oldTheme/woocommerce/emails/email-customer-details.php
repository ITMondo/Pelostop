<?php
/**
 * Additional Customer Details
 *
 * This is extra customer data which can be filtered by plugins. It outputs below the order item table.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-customer-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<?php if ( ! empty( $fields ) ) : ?>
	<h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>
	<ul style="list-style:none">
		<?php 
		
		$centro = false;
		foreach ( $fields as $key => $field ) : ?>
        	
            <?php
				if($key=='centro'){
					$centro = $field;
				}
				else
				{
			?>
			<li><strong><?php echo wp_kses_post( $field['label'] ); ?>:</strong> <span class="text"><?php echo wp_kses_post( $field['value'] ); ?></span></li>
		<?php 
				}
		endforeach; ?>
	</ul>
    
    <?php
		if($centro){
	?>
	<h2><?php _e( 'Datos del centro', 'woocommerce' ); ?></h2>
	<ul style="list-style:none">
    	<li><?php print $centro['value'];?></li>
    
    </ul>

   
    <?php
		}

		?>
      
  
    
<?php endif; ?>
