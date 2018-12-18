<?php

/* 
 * For iPay88 payment
 * by HCN
 */

class ControllerPaymentIpay88 extends Controller {
    
    public function index() {

        $this->language->load('payment/ipay88');

		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['button_back'] = $this->language->get('button_back');

    	//$data['action'] = 'https://sandbox.ipay88.com.ph/epayment/entry.asp';
    	$data['action'] = 'https://payment.ipay88.com.ph/epayment/entry.asp';
		
		$vendor = $this->config->get('ipay88_vendor');
		$password = $this->config->get('ipay88_password');		
		$support_currency = $this->config->get('entry_currency');
			
		$this->load->model('checkout/order');
			
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			// Lets start define iPay88 parameters here
		//print_r($order_info);
		$totalAmount = ""	;
		$data['products'] = array();
		//echo '<pre>';
		//	print_r("TEST == ".$this->config->get('ipay88_completed_status_id'));
		//echo '</pre>';

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


		$data['discount_amount_cart'] = 0;

		$total = $this->currency->format($order_info['total'] - $this->cart->getSubTotal(), $order_info['currency_code'], false, false);

		if ($total > 0) {
            $data['products'][] = array(
                'name'     => $this->language->get('text_total'),
				'model'    => '',
				'price'    => $total,
				'quantity' => 1,
				'option'   => array(),
				'weight'   => 0
            );
		} else {
            $data['discount_amount_cart'] -= $total;
		}

		//print_r($data);
		// Let's Generate Digital Signature  
		
		$ipaySignature ='';	
		
        $merId = $this->config->get('ipay88_vendor');
        $ikey = $this->config->get('ipay88_password');		
		$tmpAmount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
        $ordAmount = number_format($tmpAmount, 2, ".", "");
        
		$ipaySignature ='';
		$HashAmount = str_replace(".","",str_replace(",","",$ordAmount));	
	//$str = sha1($ikey  . $merId . $this->session->data['order_id'] . $HashAmount . $order_info['currency_code']);
        $str = $ikey  . $merId . $this->session->data['order_id'] . $HashAmount . $order_info['currency_code'];
		
	//for ($i=0;$i<strlen($str);$i += 2){
        //    $ipaySignature .= chr(hexdec(substr($str,$i,2)));
        //}
     
	//$ipaySignature = base64_encode(sha1($ipaySignature));
        //print_r($str);
        $ipaySignature = $this->iPay88_signature($str);
		
	// Signature generating done !
		
	// Assign values for form post
        $totalAmount = str_replace(',', '', $totalAmount);
        $totalAmount = str_replace('.', '', $totalAmount);
        //print_r("user=".$merId.", pass=".$ikey);
		$data['MerchantCode'] = $this->config->get('ipay88_vendor');
		$data['PaymentId'] = '1';
		$data['RefNo'] = $this->session->data['order_id'];
		$data['Amount'] = $ordAmount;
		$data['Currency'] = $order_info['currency_code'];
			//$data['ProdDesc'] = $product['name'];
		$data['ProdDesc'] = $this->config->get('config_name') . ' - #' . $order_info['order_id'];
		$data['UserName'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
		$data['UserEmail'] = $order_info['email'];
		$data['UserContact'] = $order_info['telephone'];
		$data['Remark'] = sprintf($this->language->get('text_description'), date($this->language->get('date_format_short')), $this->session->data['order_id']);
		$data['Lang'] = "UTF-8";
		$data['Signature'] = $ipaySignature;
		$data['ResponseURL'] = 'http://shop.philcare.com.ph/payment-gateway/callback.php';
	    //$data['ResponseURL'] = $this->url->link('payment/ipay88/callback', '', 'SSL');
		$data['BackendURL'] = $this->url->link('payment/ipay88/backendcallback', '', 'SSL');
	
		
        $data['back'] = $this->url->link('checkout/payment', '', 'SSL');
		
		$this->id       = 'payment';

    
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/ipay88.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/payment/ipay88.tpl', $data);
        } else {
            return $this->load->view('payment/ipay88.tpl', $data);
        }
    	
    }
    
    public function iPay88_signature($source){
        return base64_encode($this->hex2bin(sha1($source)));
    }
    
    public function hex2bin($hexSource){
    	$bin = "";
        for ($i=0;$i<strlen($hexSource);$i=$i+2){
            $bin .= chr(hexdec(substr($hexSource,$i,2)));
        }
        return $bin;
    }
	
    public function callback() {
        $this->language->load('payment/ipay88');
	
		$data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
	            $data['base'] = HTTP_SERVER;
	        } else {
	            $data['base'] = HTTPS_SERVER;
		}
	
		$data['charset'] = $this->language->get('charset');
		$data['language'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		
		$data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
			
		$data['text_response'] = $this->language->get('text_response');
		$data['text_success'] = $this->language->get('text_success');
		$data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success', '', 'SSL'));
		$data['text_failure'] = $this->language->get('text_failure');
		$data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart'));

        $expected_sign = $_POST['Signature'];
        
		$merId = $this->config->get('ipay88_vendor');
        $ikey = $this->config->get('ipay88_password');	

		$check_sign = "";
		$ipaySignature = "";
		$str = "";
		$HashAmount = "";
			
		$HashAmount = str_replace(array(',','.'), "", $_POST['Amount']);
		$str = $ikey . $merId . $_POST['PaymentId'].trim(stripslashes($_POST['RefNo'])). $HashAmount . $_POST['Currency'] . $_POST['Status'];
		
	
	//$str = sha1($str);
	   
		for ($i=0;$i<strlen($str);$i += 2){
            $ipaySignature .= chr(hexdec(substr($str,$i,2)));
        }
       
		$check_sign = base64_encode(sha1($ipaySignature));


		if ($_POST['Status']=="1" && $check_sign==$expected_sign){
	
            $this->load->model('checkout/order');
		
            //$this->model_checkout_order->addOrderHistory($_POST['RefNo'], $this->config->get('ipay88_order_status_id'), "Transaction ID : " . $_POST['TransId'], TRUE);	

            //trying to change status of transaction  
            //$this->model_checkout_order->addOrderHistory($_POST['RefNo'], $this->config->get('ipay88_completed_status_id'), "Transaction ID : " . $_POST['TransId'], TRUE);	  
            $order_status_id = $this->config->get('ipay88_completed_status_id');
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $order_status_id);

            $data['continue'] = $this->url->link('checkout/success', '', 'SSL');
					
		
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/ipay88_success.tpl')) {
                $this->template = $this->config->get('config_template') . '/payment/ipay88_success_backend.tpl';
            } else {
                $this->template = 'payment/ipay88_failure.tpl';
            }	
		
            $this->response->setOutput($this->load->view($this->template, $data), $this->config->get('config_compression'));

        }else{				
            $data['continue'] = $this->url->link('checkout/cart');
		
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/ipay88_failure.tpl')) {
                $this->template = $this->config->get('config_template') . '/payment/ipay88_failure.tpl';
            } else {
                $this->template = 'payment/ipay88_failure.tpl';
            }
				
            $this->response->setOutput($this->load->view($this->template, $data), $this->config->get('config_compression'));	

		}
		
    }
	
    public function backendcallback(){
        $this->language->load('payment/ipay88');
	
		$data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

        if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
            $data['base'] = HTTP_SERVER;
        } else {
            $data['base'] = HTTPS_SERVER;
        }
	
		// $data['charset'] = $this->language->get('charset');
		// $data['language'] = $this->language->get('code');
		// $data['direction'] = $this->language->get('direction');
	
		// $data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
		
		// $data['text_response'] = $this->language->get('text_response');
		// $data['text_success'] = $this->language->get('text_success');
		// $data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success', '', 'SSL'));
		// $data['text_failure'] = $this->language->get('text_failure');
		// $data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart'));


		$expected_sign = $_SESSION['Signature'];
		$merId = $this->config->get('ipay88_vendor');
	    $ikey = $this->config->get('ipay88_password');	

		$check_sign = "";
		$ipaySignature = "";
		$str = "";
		$HashAmount = "";
			
		$HashAmount = str_replace(array(',','.'), "", $_SESSION['Amount']);
		$str = $ikey . $merId . $_SESSION['PaymentId'].trim(stripslashes($_SESSION['RefNo'])). $HashAmount . $_SESSION['Currency'] . $_SESSION['Status'];
	
	
		$str = sha1($str);
	   
		for ($i=0;$i<strlen($str);$i=$i+2){
            $ipaySignature .= chr(hexdec(substr($str,$i,2)));
        }
       
		$check_sign = base64_encode($ipaySignature);

		$data['text_success'] = $this->language->get('text_success');
		$data['text_success_wait'] = $this->language->get('text_success_wait');
		$data['text_failure'] = $this->language->get('text_failure');
		$data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart'));
		if ($_SESSION['Status']=="1" && $check_sign==$expected_sign){

			$this->load->model('checkout/order');
			
			$order_info = $this->model_checkout_order->getOrder($_SESSION['RefNo']);
			//print_r($order_info);
			foreach ($this->cart->getProducts() as $product) {
				if($product['model']=="ERVPA40" || $product['model']=="ERVPK40" || $product['model']=="ERVPA60" || $product['model']=="ERVPK60" || $product['model']=="ERVPA80" || $product['model']=="ERVPK80" || $product['model']=="DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCK" || $product['model'] == "MDCA"){

					$url = "https://apps.philcare.com.ph/IPhilCareWS/Registration.svc/PurchasedPrePaidCard/?FirstName=".urlencode($order_info['firstname'])."&LastName=".urlencode($order_info['lastname'])."&MobileNo=".urlencode($order_info['telephone'])."&Email=".$order_info['email']."&CardType=".$product['model']."&OrderID=".$_SESSION['RefNo']."&Quantity=".$product['quantity'];
					$string = file_get_contents($url,
								false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
					//$string = file_get_contents($url);
					$json_a = json_decode($string, true);		
				}
			}

		
            //$this->model_checkout_order->addOrderHistory($_SESSION['RefNo'], $this->config->get('ipay88_completed_status_id'), "Transaction ID : " . $_SESSION['TransId'], TRUE);	  
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('ipay88_completed_status_id'));	  
            
            $data['continue'] = $this->url->link('checkout/success', '', 'SSL');
					
			
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/ipay88_success_backend.tpl')) {
                $this->template = $this->config->get('config_template') . '/payment/ipay88_success_backend.tpl';
            } else {
                $this->template = 'payment/ipay88_success_backend.tpl';
            }	
		
            $this->response->setOutput($this->load->view($this->template, $data), $this->config->get('config_compression'));

		}else{				
            $data['continue'] = $this->url->link('checkout/cart');
            $this->load->model('checkout/order');
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('ipay88_failed_status_id'));	  
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/ipay88_failure.tpl')) {
                $this->template = $this->config->get('config_template') . '/payment/ipay88_failure.tpl';
            } else {
                $this->template = 'payment/ipay88_failure.tpl';
            }
				
            $this->response->setOutput($this->load->view($this->template, $data), $this->config->get('config_compression'));	
		}
		
    }

    public function after_payment(){

    	$this->template = $this->config->get('config_template') . '/payment/ipay88_failure.tpl';
    }
}