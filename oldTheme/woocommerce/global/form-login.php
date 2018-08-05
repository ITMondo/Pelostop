<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
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
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="form woocomerce-form woocommerce-form-login login" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; ?>
	<div class="form-group">
    	<div class="row">
    	<div class="col-md-3 text-left">
		<label  for="username">Email</label>
        </div>
        <div class="col-md-4">
		<input type="text" class="form-control" name="username" id="username" />
        </div>
        </div>
    </div>
    <div class="form-group">
    	<div class="row">
    	<div class="col-md-3 text-left">
		<label  for="password">Contraseña</label>
        </div>
        <div class="col-md-4">
		<input class="form-control" type="password" name="password" id="password" />
        </div>
        </div>
    </div>
    <div class="form-group">
    	<div class="row">
        <div class="col-md-6 col-md-offset-3">
		<?php do_action( 'woocommerce_login_form' ); ?>
        <?php wp_nonce_field( 'woocommerce-login' ); ?>
		<input type="submit" class="btn black" name="login" value="<?php esc_attr_e( 'ACCEDER', 'woocommerce' ); ?>" />
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
        		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( '¿Has olvidado tu contraseña?', 'woocommerce' ); ?></a>
		<p>
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'woocommerce' ); ?></span>
		</label>
        </p>
        </div>
        </div>
    </div>
    
    
    
    
    
	

	

	


	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
