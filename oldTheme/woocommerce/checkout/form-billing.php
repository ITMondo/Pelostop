<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>
<div class="woocommerce-billing-fields checkout-item">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'REGÍSTRATE', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
			$fields = $checkout->get_checkout_fields( 'billing' );


			foreach ( $fields as $key => $field ) {
				if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
					$field['country'] = $checkout->get_value( $field['country_field'] );
				}
				
				 if($field['type']=='hidden'){
					  print '<input type="hidden" name="'.$key.'" id="'.$key.'" value="" />';
				  }
				  else
				  {

				
									print' <div class="form-group">
						<div class="row">
						  <div class="col-md-3 text-left">
							<label  for="'.$key.'">'.$field['label'].'</label>
						  </div>
						  <div class="col-md-4">';
						  
						  if($field['type']=='select'){
						  
								print '<select class="form-control" name="'.$key.'" id="'.$key.'">';
								print '<option value="">Selecciona una opción...</option>';
								
								foreach($field['options'] as $opt_key => $opt_value){
									print '<option value="'.$opt_key.'">'.$opt_value.'</option>';	
								}
		
								print '</select>';
						  }
						  else
						  {
							print '<input type="text" class="form-control" name="'.$key.'" id="'.$key.'" value="'.$checkout->get_value( $key ).'" />';
							  
						  }
						  
						  print'</div>
						</div>
					  </div>
									';
									
				  }
				
				
				
				//woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

		<div class="row">
		<div class="col-md-4 col-md-offset-3">
			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> 
                    type="checkbox" name="createaccount" value="1" /> <span><?php _e( 'Crear una cuenta', 'woocommerce' ); ?></span>
				</label>
                    <p>Registrarse en Pelostop tiene muchas ventajas: te informaremos puntualmente sobre nuestras promociones y las comprar será más fácil y rápida.</p>
                    <p><strong>¡Descuentos y promociones solo por ser socio!</strong></p>

			</p>
		</div>
        </div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>
		<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>
        </div>
        </div>    

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>
</div>
