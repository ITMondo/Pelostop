jQuery( function ( $ ) {
									
									
									
									
									function loadBonos(grupo){
									
									var bonos = [];
										$("ul.var_1").html('');
										for(var i in variations) {
											
											if(grupo == variations[i].grupo){
											
											
												bonos.push(variations[i]);	
											}
											
										}
										
										var li_bonos = '';
										
										bonos.sort(function(a, b) {
											return parseInt(a.bono_name) - parseInt(b.bono_name);
										});
										
										if(parseInt(bonos.length)>1){
										
											for(var b in bonos) {
											li_bonos +='<li class="variation" data-pvp="'+bonos[b]['precio']+'" data-pid="'+bonos[b]['product_id']+'" data-varid="'+bonos[b]['id']+'" data-grupo="'+grupo+'" data-bono="'+bonos[b]['bono']+'">'+bonos[b]['bono_name']+'</li>';
											}
											
											
											
											$("ul.var_1").html(li_bonos);
											$("div.variations_1").show();
											
											
											$("ul.var_1 li").on('click',function(e){
												$(".ps-add-to-cart .precios div.box_price").html(init_price);										
												$("ul.var_1 li").removeClass('active');
												$(this).addClass('active');
												var url =cart_url+"?add-to-cart="+parseInt($(this).data('pid'));
												url+="&variation_id="+parseInt($(this).data('varid'));
												url+="&attribute_pa_grupo="+$(this).data('grupo');
												url+="&attribute_pa_bono="+$(this).data('bono');
												$("a.add-to-cart").attr('href',url);
												$("a.add-to-cart").removeClass('disabled');
												
												var pvp = '<span class="woocommerce-Price-amount amount">'+$(this).data('pvp')+'<span class="woocommerce-Price-currencySymbol">€</span></span>';                       
												$(".ps-add-to-cart .precios div.box_price").html(pvp);
											
											});
										}
										else //Only one bono
										{
												$(".ps-add-to-cart .precios div.box_price").html(init_price);										
												var url =cart_url+"?add-to-cart="+parseInt(bonos[0]['product_id']);
												url+="&variation_id="+parseInt(bonos[0]['id']);
												url+="&attribute_pa_grupo="+grupo;
												url+="&attribute_pa_bono="+bonos[0]['bono'];										
												$("a.add-to-cart").attr('href',url);
												$("a.add-to-cart").removeClass('disabled');
												var pvp = '<span class="woocommerce-Price-amount amount">'+bonos[0]['precio']+'<span class="woocommerce-Price-currencySymbol">€</span></span>';                       
												$(".ps-add-to-cart .precios div.box_price").html(pvp);
										}
									
									}
									
									
									
									
									
									
									
									
									function getNumber(text){
										
										switch(text){
										
											case 'i': return 1;break;
											case 'ii': return 2;break;
											case 'iim': return 3;break;
											case 'iimm': return 4;break;
											case 'iii': return 5;break;
											case 'iv': return 6;break;
											case 'v': return 7;break;	
											case 'ocho': return 8;break;	
											case 'cinco': return 5;break;	
											case 'diez': return 10;break;	
										}
										
									}
									
									
									
									function init(){
										
										
										$("ul.var_0").html('');
										var li_grupos = '';
										var grupos = [];
										for(var i in variations) {
											
											
											existe = false;
											for(g in grupos){
												if(grupos[g].slug == variations[i]['grupo']){
													existe = true;	
												}
											}
											
											if(!existe){
												var grupo = {
													'name':variations[i]['grupo_name'],
													'slug':variations[i]['grupo'],
													'order':getNumber(variations[i]['grupo'])
												}
												grupos.push(grupo);
												
											}
										}
										
										
										console.log(grupos);
										
										grupos.sort(function(a, b) {
											return parseInt(a.order) - parseInt(b.order);
										});
										
										for(var i in grupos) {
											
											li_grupos+= '<li class="variation grupo" data-item="'+grupos[i].slug+'">'+grupos[i].name+'</li>';
											
										}
										$("ul.var_0").html(li_grupos);				
											$("ul.var_0 li").on('click',function(e){
											$(".ps-add-to-cart .precios div.box_price").html(init_price);										
											
											var grupo = $(this).data('item');
											$("ul.var_0 li").removeClass('active');
											$(this).addClass('active');
											$("a.add-to-cart").addClass('disabled');
											loadBonos(grupo);
										});
																								
									}
									
									init();
									
									
									
									
									
									
									
});