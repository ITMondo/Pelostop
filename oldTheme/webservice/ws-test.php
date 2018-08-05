<?php


function write_log_ws_test($cadena,$tipo)
{
	$route = get_template_directory() . '/webservice/logs/';
	$arch = fopen($route."pslog_".date("Y-m-d").".txt", "a+"); 
	fwrite($arch, "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." ".
                   $_SERVER['HTTP_X_FORWARDED_FOR']." - $tipo ] ".$cadena."\n");
	fclose($arch);
}





	
class WS_PS_TEST{
		
		

		
		var $_WDSLURL = 'http://gesstop.es/gestion/extranet2007/ecommerce/webservice_ecommerce.php?wsdl';
		var $_WDSLUSER = 'optimast';
		var $_WDSLPASS = 'StOptima2017';
		var $id_cliente = false;
		var $cod_operacion;
		var $produccion = false;
		var $centro_test = 17;

		
		
		
		
		   function __construct($order_id) {
			   
			   		$this->order =  new WC_Order($order_id);
					

   			}
		
		
		private function callWS($method,$params){
			$respuesta = array('ok'=>false,'message'=>'');
			$client = new nusoap_client($this->_WDSLURL);
			$client->charencoding = 'UTF-8';
			$client->soap_defencoding = 'UTF-8';
			$client->decode_utf8 = true;
			$err = $client->getError();
			if ($err) {	
				$respuesta = array('ok'=>false,'message'=>$err);
				return $respuesta;
			}
			else
			{
				
				
				
				
				$result = $client->call($method, $params);
				if ($err = $client->fault) {
							$respuesta = array('ok'=>false,'message'=>$result);
							return $respuesta;
				} else{
				// Check for errors
				$err = $client->getError();
					if ($err) {
							$respuesta = array('ok'=>false,'message'=>$err);
							return $respuesta;
					} else {
						
						$respuesta = array('ok'=>true,'message'=>$result);
						return $respuesta;
					}
				}
			}
		}
		
		
		public function get_client_ip() {
			$ipaddress = '';
			if (getenv('HTTP_CLIENT_IP'))
				$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			else if(getenv('HTTP_X_FORWARDED'))
				$ipaddress = getenv('HTTP_X_FORWARDED');
			else if(getenv('HTTP_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_FORWARDED_FOR');
			else if(getenv('HTTP_FORWARDED'))
			   $ipaddress = getenv('HTTP_FORWARDED');
			else if(getenv('REMOTE_ADDR'))
				$ipaddress = getenv('REMOTE_ADDR');
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
		}
		
		
		public function getSKU($sku,$zone){
		
		
				$codigo = false;
				
				$arr_codes = explode('|',$sku);
				
				
				foreach($arr_codes as $code){
					
					$pos = strpos($code, $zone.':');
					if($pos!==false){
						$codigo = substr($code,3);
					}
					
				}
				
				
				
				return $codigo;
		
		}

		
		
		
		public function buscaClienteNIF(){
					
					
			if($this->produccion){
				$centro = $this->order->billing_centro_id;
			}
			else
			{
				$centro = $this->centro_test;
			}
					
					
			$param = array(
			'user' => $this->_WDSLUSER, 
			'pass' => $this->_WDSLPASS, 
			'nif' => $this->order->billing_documento_identificacion, 
			'nombre'=>$this->order->billing_first_name, 
			'apellidos'=>$this->order->billing_last_name,
			'email'=>$this->order->billing_email,
			'comoconocio'=>$this->order->billing_como_conociste,
			'iddelegacion'=>$centro,
			'CP'=>'',
			'tlf'=>$this->order->billing_phone,
			'sexo'=>''
			);
			
			
			return $this->callWS('buscaClienteNIF',$param);
			
		}
		
		
		
		public function altaCompra(){
		
		
		
		global $woocommerce;
		$arr_codigos_venta = array();
		
		
			if($this->produccion){
				$centro = $this->order->billing_centro_id;
			}
			else
			{
				$centro = $this->centro_test;
			}
					
					
		$items = $this->order->get_items();
		
		
					foreach($items as $item) { 
					
					
					
				
					
							// Retrieve WC_Product object from the product-id:
						  $product_name = $item['name'];
						  $product_id = $item['product_id'];
						  $product_qty = $item['qty'];
						  $product_variation_id = $item['variation_id'];	
					  
					  
							 // Check if product has variation.
							  if ($product_variation_id) { 
								$product = wc_get_product($item['variation_id']);
			
							  } else {
								$product = wc_get_product($item['product_id']);
							  }
							  
							$product->tipoid = get_post_meta($item['product_id'], 'ps_tipoid', true);
							
					
						// Get SKU from the WC_Product object:
						$product_sku = $product->get_sku();
						
							if($item['subototal']<$item['total']){
								$descuento = (($item['subtotal']+$item['subtotal_tax'])-($item['total']+$item['total_tax']))/$product_qty;
								$tipo_descuento = '1';
								$descuento_unitario = $descuento;
			
							}
							else
							{
								$tipo_descuento = 0;
								$descuento_unitario = 0;
			
							}
							

							
							
							$forma_pago = 0;
							switch($this->order->get_payment_method()){
							
								case 'paypal':$forma_pago = '14';$txid=$this->order->get_transaction_id();break;	
								case 'redsys':$forma_pago = '13';$txid=$this->order->get_transaction_id();break;
								case 'realex_redirect':$forma_pago = '13';$txid=get_post_meta( $this->order->id, '_realex_payment_reference', true );break;
							}
						
						
						
							$param = array(
							'user' => $this->_WDSLUSER, 
							'pass' => $this->_WDSLPASS, 
							'id_cliente' => $this->id_cliente, 
							'id_articulo'=>$this->getSKU($product_sku,'ES'), 
							'unidades'=>$product_qty,
							'centro'=>$centro,
							'forma_pago'=>$forma_pago,
							'tipo_descuento'=>$tipo_descuento,
							'descuento_unitario'=>$descuento_unitario,
							'tipoid'=>$product->tipoid
							);
							
							
							
														
							
						write_log_ws_test(json_encode($param),'altaCompra');
						
							$res = $this->callWS('altaCompra',$param);
							
							if(isset($res['ok'])&&$res['ok']==1){
								$codigo_venta = $res['message']['descripcion'];
								array_push($arr_codigos_venta,$codigo_venta);
								
								
								$cupones = '';
								 if($coupons = $this->order->get_used_coupons() ) {
									 
									 
									 foreach($coupons as $coupon){
										 $cupones.=$coupon." ";
									 }
								 }
								
									
								
									$param = array(
									'user' => $this->_WDSLUSER, 
									'pass' => $this->_WDSLPASS, 
									'idVenta' => $codigo_venta, 
									'noperacion'=>$txid,
									'ip'=>$this->get_client_ip(),
									'ccupon'=>$cupones,
									);
					
									write_log_ws_test(json_encode($param),'detalleVenta');

					
									$res = $this->callWS('detalleVenta',$param);
									
									
									$param = array(
									'user' => $this->_WDSLUSER, 
									'pass' => $this->_WDSLPASS, 
									'idVenta' => $codigo_venta, 
									'CCNP'=>$this->order->billing_como_conociste, 
									);
					
									write_log_ws_test(json_encode($param),'altaCompra');
									$res = $this->callWS('encuestaVenta',$param);
									
									

							}
							
						
					}
			
					return $arr_codigos_venta;
			
					
			
			
		}
		
		
}
	
	
	
//add_action('before_woocommerce_pay','callWSPelostop');






function callWSPelostopTest($order_id){
	
	global $woocommerce, $post;
	
	$ws = new WS_PS_TEST($order_id);
	
	
	$res_buscaNif = $ws->buscaClienteNIF();
	
	
		if($res_buscaNif['ok']){
		$ws->id_cliente = $res_buscaNif['message']['id'];
		}
		else
		{
		logerror('RESPUESTA KO BUSCANIF');
	    exit();	
		}
	
	$res_altaCompra = $ws->altaCompra();
	
	$ids_compra = false;
	foreach($res_altaCompra as $compra){
		$ids_compra.=$compra.' ';	
	}
	update_post_meta($order_id, 'ps_ws_idventa', esc_attr($ids_compra));

}

