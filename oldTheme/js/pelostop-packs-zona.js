jQuery( function ( $ ) {
									
									
									
									
								
									
									
									
									
									
									function init(){
										
										$("ul.var_0 li").on('click',function(e){
											
												$(".ps-add-to-cart .precios div.box_price").html(init_price);										
												$("ul.var_0 li").removeClass('active');
												$(this).addClass('active');
												$("a.add-to-cart").addClass('disabled');
											
											
											
												$(".ps-add-to-cart .precios div.box_price").html(init_price);										
												var url =cart_url+"?add-to-cart="+$(this).data('pid');
												url+="&variation_id="+$(this).data('varid');
												url+="&attribute_pa_zona="+$(this).data('zona');
												$("a.add-to-cart").attr('href',url);
												$("a.add-to-cart").removeClass('disabled');
												var pvp = '<span class="woocommerce-Price-amount amount">'+$(this).data('pvp')+'<span class="woocommerce-Price-currencySymbol">€</span></span>';    
												$(".ps-add-to-cart .precios div.box_price").html(pvp);

											
											
											
										});
																								
									}
									
									init();
									
									
									
									
									
									
									
});