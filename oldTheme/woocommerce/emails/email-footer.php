<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit">
                                                        
                                                        <?php
															if(COMPLETE_ORDER){
														?>
                                                                                                                	<p style="text-align:center;font-size:16px;font-weight:bold;padding-top:40px">Recuerda que ahora sólo tienes que pedir cita en tu centro.</p>
                                                                                                 <?PHP
																								 }
																								 ?>                   

															<p style="text-align:center">Para cualquier duda o incidencia ponte en contacto con atención al cliente de
                                                               <strong> www.pelostop.com</strong> en el 900 828 410 o en <a href="mailto:clientes@pelostop.com">clientes@pelostop.com</a></p>
<hr />
<p><strong>Pelostop</strong> - Especialistas en depilación láser</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
