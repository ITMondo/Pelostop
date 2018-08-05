<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="woocommerce-customer-details">

	<h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>

	<table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
    
        
     
        
        

		<?php if ( $order->get_customer_note() ) : ?>
			<tr>
				<th><?php _e( 'Note:', 'woocommerce' ); ?></th>
				<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
			</tr>
		<?php endif; ?>
        
        <?php if ( $order->get_billing_first_name() ) : ?>
			<tr>
				<th><?php _e( 'Customer:', 'woocommerce' ); ?></th>
				<td>			<?php echo esc_html( $order->get_billing_first_name() ).' '.esc_html( $order->get_billing_last_name() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<tr>
				<th><?php _e( 'Email:', 'woocommerce' ); ?></th>
				<td><?php echo esc_html( $order->get_billing_email() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<tr>
				<th><?php _e( 'Phone:', 'woocommerce' ); ?></th>
				<td><?php echo esc_html( $order->get_billing_phone() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

	</table>


   <?php
			$centro = getCentro( get_post_meta( $order->id, '_billing_centro_id', true ));
				
			if($centro){
		?>
        
        
    	<h2><?php _e( 'Datos del Centro', 'woocommerce' ); ?></h2>
   	<table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
<tr>
				<td class="text-left"><?php echo esc_html( $centro['nombre']); ?></td>
			</tr>
    </table>
     
        
  <?php
			}?>
        
    

	<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">

	

		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">

			<h3 class="woocommerce-column__title"><?php _e( 'Shipping address', 'woocommerce' ); ?></h3>

			<address>
				<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
			</address>

		</div><!-- /.col-2 -->

	</section><!-- /.col2-set -->

	<?php endif; ?>

</section>
