<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'?>">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="header_ps">
                        <tr>
                        	<td align="left" style="padding-bottom:15px;">
                        	<span style="font-size:40px;font-weight:bold;margin-left:30px">
								
                           <img style="width: 166px; height: 100px;" alt="Logo Pelostop Woman y Man" src="http://pelostop.es/wp-content/themes/pelostop/images/mail/logo_woman_man.gif">
                           
                           
                           </span></td>
                            <td align="right" style="padding-bottom:15px;"><span style="font-size:16px;margin-right:30px">ESPECIALISTAS EN DEPILACIÓN LÁSER</span></td>
                        </tr>
                        </table>
                        
                        
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
							<tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header_ps" style="background-color: #eeeeee; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; 
                                    vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif">
										<tr>
											<td id="header_wrapper_ps" style="padding-top: 40px;padding-left: 30px;padding-bottom: 30px;padding-right: 30px;">
												<h1 style="color: #000000; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #333333; -webkit-font-smoothing: antialiased"><?php echo $email_heading; ?></h1>
											</td>
										</tr>
									</table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
										<tr>
											<td valign="top" id="body_content">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tr>
														<td valign="top">
															<div id="body_content_inner">
