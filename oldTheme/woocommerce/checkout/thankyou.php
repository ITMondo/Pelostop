<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="woocommerce-order col-md-9">

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>


		<?php
		
		define('WCORDER', $order->get_order_number());
		
		
		?>


		<div class="woocommerce-header-order">
			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">TU PEDIDO HA SIDO RECIBIDO<br/><span>¡Gracias por tu compra! Ahora sólo tienes que pedir hora en tu centro.</span> </p>
            
            
            
            
			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">


				<li class="woocommerce-order-overview__order order">
					<?php _e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php _e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
				</li>

				<li class="woocommerce-order-overview__total total">
					<?php _e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>

				<li class="woocommerce-order-overview__payment-method method">
					<?php _e( 'Payment method:', 'woocommerce' ); ?>
					<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
				</li>

				<?php endif; ?>

			</ul>
            
            
            
       </div> 
       
       <div class="msj-email">
            	<p>Recibirás por e-mail la confirmación con los detalles de tu compra. Si no lo ves en tu bandeja de entrada tras unos minutos, por favor, comprueba en la bandeja de correo no deseado-spam.</p>
            </div>    

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>
<div class="col-md-3">
<?php  get_sidebar();?>
</div>

<!-- TRADETRACKER PIXEL -->

<script type="text/javascript">

var ttConversionOptions = ttConversionOptions || [];

ttConversionOptions.push({

  type: 'sales',
  campaignID: '25456',
  productID: '37344',
  transactionID: '<?php print $order->get_id();?>',
  transactionAmount: '<?php print $order->get_total()-$order->get_total_tax();?>',
  quantity: '1',
  email: '',
  descrMerchant: '',
  descrAffiliate: '',
  currency: ''

});

</script>

<noscript>

<img src="//ts.tradetracker.net/?cid=25456&amp;pid=37344&amp;tid=<?php print $order->get_id();?>&amp;tam=<?php print $order->get_total()-$order->get_total_tax();?>&amp;data=&amp;qty=1&amp;eml=&amp;descrMerchant=&amp;descrAffiliate=&amp;event=sales&amp;currency=EUR" alt="" />

</noscript>

<script type="text/javascript">

// No editing needed below this line.

(function(ttConversionOptions) {

  var campaignID = 'campaignID' in ttConversionOptions ? ttConversionOptions.campaignID : ('length' in ttConversionOptions && ttConversionOptions.length ? ttConversionOptions[0].campaignID : null);

  var tt = document.createElement('script'); tt.type = 'text/javascript'; tt.async = true; tt.src = '//tm.tradetracker.net/conversion?s=' + encodeURIComponent(campaignID) + '&t=m';

  var s = document.getElementsByTagName('script'); s = s[s.length - 1]; s.parentNode.insertBefore(tt, s);

})(ttConversionOptions);

</script>

<!-- END TRADETRACKER PIXEL -->


<!--
Start of DoubleClick Floodlight Tag: Please do not remove
Activity name of this tag: PIXEL-IKIMEDIA-PELOSTOP-SALE
This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
Creation Date: 12/20/2017
-->
<img src="https://ad.doubleclick.net/ddm/activity/src=8310288;type=sales;cat=l3pux0vl;qty=[Quantity];cost=[Revenue];dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;ord=[OrderID]?" width="1" height="1" alt=""/>
<!-- End of DoubleClick Floodlight Tag: Please do not remove -->

<script>
fbq('track', 'Purchase', {
value: <?php print $order->get_total()-$order->get_total_tax();?>,
currency: 'EUR'
});
</script>



