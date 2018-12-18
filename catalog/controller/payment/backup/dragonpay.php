<?php

/* 
 * DragobnPay for Payment
 * by HCN
 */

class ControllerPaymentDragonpay extends Controller {

	public function index() {
        $this->language->load('payment/dragonpay');
        $this->load->model('payment/dragonpay');
        $this->load->model('checkout/order');


    	$data['button_confirm'] = $this->language->get('button_confirm');
    	$data['button_back'] = $this->language->get('button_back');
            
        
        $data['action'] = $this->url->link('payment/dragonpay/process_payment', '', 'SSL');

        
        
        $data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

        
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        $data['products'] = array();

        foreach ($this->cart->getProducts() as $product) {
            $option_data = array();
            
            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['value'];
		        } else {
                    $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
						
                    if ($upload_info) {
                        $value = $upload_info['name'];
                    } else {
                        $value = '';
                    }
		        }

		        $option_data[] = array(
                    'name'  => $option['name'],
                    'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
		        );
            }

            $data['products'][] = array(
                'name'     => htmlspecialchars($product['name']),
        		'model'    => htmlspecialchars($product['model']),
        		'price'    => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
        		'quantity' => $product['quantity'],
        		'option'   => $option_data,
        		'weight'   => $product['weight']
            );
	    }

	    //print_r($order_info);
	    $merchantID = $this->config->get('dragonpay_merchant_id');
	    $merchantPassword = $this->config->get('dragonpay_merchant_password');
	    $merchantName = $this->config->get('dragonpay_merchant_name');
	    $merchantURL = $this->config->get('dragonpay_merchant_url');
	    $order_desc = "Order from PhilCare with invoice no ".$order_info['order_id'];
	    $tmpAmount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
        $ordAmount = number_format($tmpAmount, 2, ".", "");

        $data['MerchantID'] = $this->config->get('dragonpay_merchant_id');
        $data['MerchantPassword'] = $this->config->get('dragonpay_merchant_password');
        $data['MerchantName'] = $this->config->get('dragonpay_merchant_name');
        $data['MerchantURL'] = $this->config->get('dragonpay_merchant_url');
        $data['CCY'] = $order_info['currency_code'];
        $data['Email'] = $order_info['email'];
        $data['TransactionID'] = $order_info['order_id'];
        $data['Description'] = $order_desc;
        $data['Amount'] = $ordAmount;
	    $parameters = array(
			'merchantid' => $merchantID,
		    'txnid' => $order_info['order_id'],
		    'amount' => $ordAmount,
		    'ccy' => $order_info['currency_code'],
		    'description' => $order_desc,
		    'email' => $order_info['email'],
		);

  		$fields = array(
			'txnid' => array(
		    	'label' => 'Transaction ID',
		        'type' => 'text',
		        'attributes' => array(),
		        'filter' => FILTER_SANITIZE_STRING,
		        'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
		    ),
		    'amount' => array(
		    	'label' => 'Amount',
		        'type' => 'number',
		        'attributes' => array('step="0.01"'),
		        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
		        'filter_flags' => array(FILTER_FLAG_ALLOW_THOUSAND, FILTER_FLAG_ALLOW_FRACTION),
		    ),
		    'description' => array(
		    	'label' => 'Description',
		        'type' => 'text',
		        'attributes' => array(),
		        'filter' => FILTER_SANITIZE_STRING,
		        'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
		    ),
		    'email' => array(
		    	'label' => 'Email',
		        'type' => 'email',
		        'attributes' => array(),
		        'filter' => FILTER_SANITIZE_EMAIL,
		        'filter_flags' => array(),
		    ),
		);

        //print_r($responseFields);
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/dragonpay.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/payment/dragonpay.tpl', $data);
        } else {
            return $this->load->view('payment/dragonpay.tpl', $data);
        }
    }

    public function process_payment(){
    	$this->language->load('payment/dragonpay');
    	$this->load->model('payment/dragonpay');
	    $this->load->model('checkout/order');

    	//print_r("TEST".$this->config->get('dragonpay_merchant_url'));
  		
		if (isset($_POST['email'])) {
			$this->language->load('payment/dragonpay');
    	    $this->load->model('payment/dragonpay');
	        $this->load->model('checkout/order');

			if (empty($errors)) {
				$merchant = urlencode($this->config->get('dragonpay_merchant_id'));
				$tnxid = urlencode($_POST['tnxid']);
				$amount = urlencode($_POST['Amount']);
				$ccy = urlencode($_POST['ccy']);
				$description = $_POST['Description'];
				$email = $_POST['email'];
				$password = urlencode($this->config->get('dragonpay_merchant_password'));
				$digest_str = "$merchant:$tnxid:$amount:$ccy:$description:$email:$password";
				$digest = sha1($digest_str);

				$parameters = array(
					'merchantid' => $merchant ,
				    'txnid' => $tnxid,
				    'amount' => $amount,
				    'ccy' => $ccy,
				    'description' => $description,
				    'email' => $email,

				);

				
			// Transform amount to correct format. (2 decimal places,
			// decimal separated by period, no thousands separator)
				
			  // Unset later from parameter after digest.
				$parameters['key'] = $this->config->get('dragonpay_merchant_password');
				$digest_string = implode(':', $parameters);
				unset($parameters['key']);
			  // NOTE: To check for invalid digest errors,
			  // uncomment this to see the digest string generated for computation.
			  // var_dump($digest_string); $is_link = true;
				$parameters['digest'] = sha1($digest_string);
				$parameters['param1'] = "v2";
				$url = $this->config->get('dragonpay_merchant_url');
				//rint_r($parameters);
				$url .= http_build_query($parameters, '', '&');
				//print_r($url);
			//	print_r($is_link);
				echo "<script>window.top.location='".$url."';</script>";  
				//if ($is_link) {
				//	echo '<br><a href="' . $url . '">' . $url . '</a>';
				//}else {
				//header("Location: $url");
					
				//	echo "<script>window.location='".$url."';</script>";  
				//}
			}
    
		}

    }

    public function dragonpay_status(){
    	$this->language->load('payment/dragonpay');
    	$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_title'),
			'href' => $this->url->link('checkout/cart', '', true)
		);


    	if(isset($this->request->get['stat'])){
    		$stat = $this->request->get['stat'];
    		$txnid = $this->request->get['txnid'];


    		$this->load->model('checkout/order');
    		$this->language->load('payment/dragonpay');

    		$data['charset'] = $this->language->get('charset');
			$data['language'] = $this->language->get('code');
			$data['direction'] = $this->language->get('direction');
		
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_response'] = $this->language->get('text_response');
			$data['text_success'] = $this->language->get('text_success');
			$data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success', '', 'SSL'));
			$data['text_failure'] = $this->language->get('text_failure');
			$data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart'));
			
			//edited this part. to use txnid
			//$data['text_message'] = sprintf($this->language->get('text_description'), date($this->language->get('date_format_short')), $this->session->data['order_id'],$this->language->get('text_title'));

			$data['text_message'] = sprintf($this->language->get('text_description'), date($this->language->get('date_format_short')), $txnid,$this->language->get('text_title'));


			//testing GET['txnid']
			//$order_id = $this->session->data['order_id'];
			$order_id = $txnid;
			
			$order_info = $this->model_checkout_order->getOrder($order_id);
			$order_info['subtotal'] = $this->cart->getSubTotal();
			

			$tmpAmount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
        	$ordAmount = number_format($tmpAmount, 2, ".", "");
        	$order_info['total'] = $ordAmount;

			$data['orders'] = $order_info;
			$data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
				//echo '<pre>';
				//print_r($product);
				//echo '</pre>';
            	$option_data = array();

	            foreach ($product['option'] as $option) {
	                if ($option['type'] != 'file') {
	                    $value = $option['value'];
					} else {
			            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
									
			            if ($upload_info) {
			            	$value = $upload_info['name'];
			            } else {
			            	$value = '';
			            }
					}

					$option_data[] = array(
			            'name'  => $option['name'],
			            'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
	   			}

	            $data['products'][] = array(
	                'name'     => htmlspecialchars($product['name']),
					'model'    => htmlspecialchars($product['model']),
					'price'    => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
					'quantity' => $product['quantity'],
					'option'   => $option_data,
					'weight'   => $product['weight'],
					'total'	   => $product['total']
			    );
			}


			if($stat == "S"){
				$status = $this->config->get('dragonpay_completed_status_id');
			}else if($stat == "F"){
				$status = $this->config->get('dragonpay_failed_status_id');
			}else if($stat == "P"){
				$status = $this->config->get('dragonpay_pending_status_id');
			}else if($stat == "R"){
				$status = $this->config->get('dragonpay_refunded_status_id');
			}else if($stat == "V"){
				$status = $this->config->get('dragonpay_voided_status_id');
			}else{
				$status = $this->config->get('dragonpay_processed_status_id');
			}
			//echo '<pre>';
			//print_r("StATUS==".$status);
			//echo '</pre>';
			
			if($status == "S"){
			
				foreach ($this->cart->getProducts() as $product) {

					if($product['model']=="ERVPA40" || $product['model']=="ERVPK40" || $product['model']=="ERVPA60" || $product['model']=="ERVPK60" || $product['model']=="ERVPA80" || $product['model']=="ERVPK80" || $product['model']=="DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCK" || $product['model'] == "MDCA"){
						$url = "https://apps.philcare.com.ph/IPhilCareWS/Registration.svc/PurchasedPrePaidCard/?FirstName=".urlencode($order_info['firstname'])."&LastName=".urlencode($order_info['lastname'])."&MobileNo=".urlencode($order_info['telephone'])."&Email=".$order_info['email']."&CardType=".$product['model']."&OrderID=".$order_id."&Quantity=".$product['quantity'];

						//$string = file_get_contents($url);
						$string = file_get_contents($url,
								false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
						$json_a = json_decode($string, true);		

					}
					
				}
			}

		
            
			$this->model_checkout_order->addOrderHistory($order_id, $status);	  
            
            $data['continue'] = $this->url->link('checkout/success', '', 'SSL');
			$data['product_price'] = $ordAmount;		
			
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/dragonpay_success.tpl')) {
                $this->template = $this->config->get('config_template') . '/payment/dragonpay_success.tpl';
            } else {
                $this->template = 'payment/dragonpay_success.tpl';
            }	
		
            $this->response->setOutput($this->load->view($this->template, $data), $this->config->get('config_compression'));
    	}else{

    	}
    	
    	
    }


    public function dragonpay_postback(){

    	if(isset($this->request->get['stat'])){
    		$stat = $this->request->get['stat'];
    		$txnid = $this->request->get['txnid'];


    		$this->load->model('checkout/order');
    		$this->language->load('payment/dragonpay');
		
			$order_id = $txnid;
			
			$order_info = $this->model_checkout_order->getOrder($order_id);
			$order_info['subtotal'] = $this->cart->getSubTotal();
			

			$tmpAmount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
        	$ordAmount = number_format($tmpAmount, 2, ".", "");
        	$order_info['total'] = $ordAmount;

			$data['orders'] = $order_info;
			$data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
				
            	$option_data = array();

	            foreach ($product['option'] as $option) {
	                if ($option['type'] != 'file') {
	                    $value = $option['value'];
					} else {
			            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
									
			            if ($upload_info) {
			            	$value = $upload_info['name'];
			            } else {
			            	$value = '';
			            }
					}

					$option_data[] = array(
			            'name'  => $option['name'],
			            'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
	   			}

	            $data['products'][] = array(
	                'name'     => htmlspecialchars($product['name']),
					'model'    => htmlspecialchars($product['model']),
					'price'    => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
					'quantity' => $product['quantity'],
					'option'   => $option_data,
					'weight'   => $product['weight'],
					'total'	   => $product['total']
			    );
			}


			if($stat == "S"){
				$status = $this->config->get('dragonpay_completed_status_id');
			}else if($stat == "F"){
				$status = $this->config->get('dragonpay_failed_status_id');
			}else if($stat == "P"){
				$status = $this->config->get('dragonpay_pending_status_id');
			}else if($stat == "R"){
				$status = $this->config->get('dragonpay_refunded_status_id');
			}else if($stat == "V"){
				$status = $this->config->get('dragonpay_voided_status_id');
			}else{
				$status = $this->config->get('dragonpay_processed_status_id');
			}
			$this->load->model('account/order');
			$products = $this->model_account_order->getOrderProducts($order_id); 

			if($stat == "S"){
				
				foreach ($products as $product) {

					if($product['model']=="ERVPA40" || $product['model']=="ERVPK40" || $product['model']=="ERVPA60" || $product['model']=="ERVPK60" || $product['model']=="ERVPA80" || $product['model']=="ERVPK80" || $product['model']=="DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCK" || $product['model'] == "MDCA"){
						$url = "https://apps.philcare.com.ph/IPhilCareWS/Registration.svc/PurchasedPrePaidCard/?FirstName=".urlencode($order_info['firstname'])."&LastName=".urlencode($order_info['lastname'])."&MobileNo=".urlencode($order_info['telephone'])."&Email=".$order_info['email']."&CardType=".$product['model']."&OrderID=".$order_id."&Quantity=".$product['quantity'];
						$string = file_get_contents($url,
								false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
						//$string = file_get_contents($url);
						$json_a = json_decode($string, true);		

					}
					
				}
			}
			$data['product_price'] = $ordAmount;
			$this->model_checkout_order->addOrderHistory($order_id, $status,'',1);	  
            
    	}
    }

}