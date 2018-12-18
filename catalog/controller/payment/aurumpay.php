<?php

/* 
 * Aurumpay for Payment
 * by HCN
 */

class ControllerPaymentAurumpay extends Controller {
    
    public function index() {
        $this->language->load('payment/aurumpay');

    	$data['button_confirm'] = $this->language->get('button_confirm');
    	$data['button_back'] = $this->language->get('button_back');
            
        
        
        
        $data['action'] = $this->url->link('payment/aurumpay/process_payment', '', 'SSL');
        //print_r($responseFields);
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/aurumpay.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/payment/aurumpay.tpl', $data);
        } else {
            return $this->load->view('payment/aurumpay.tpl', $data);
        }
    }
    
    function process_payment(){
        $this->language->load('payment/aurumpay');
        $this->load->model('payment/aurumpay');
        $this->load->model('checkout/order');
        $data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

        
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        $data['products'] = array();
        //echo '<pre>';
        //print_r($order_info);
        //echo '</pre>';
        //die();
        
        //echo '<pre>';
        //print_r($this->cart->getProducts());
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

        $endpointId = $this->config->get('aurumpay_endpoint');
        $merchantControl = $this->config->get('aurumpay_control_key');
        $api = $this->config->get('aurumpay_api');
        $order_desc = "Order from PhilCare with invoice no ".$order_info['order_id'];
        $tmpAmount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
        $ordAmount = number_format($tmpAmount, 2, ".", "");
        
        $requestFields = array(
            'client_orderid' => $order_info['order_id'], 
            'order_desc' => $order_desc, 
            'first_name' => $order_info['payment_firstname'], 
            'last_name' => $order_info['payment_lastname'], 
            'address1' => $order_info['payment_address_1'], 
            'city' => $order_info['payment_city'], 
            'state' => $order_info['payment_zone_code'], 
            'zip_code' => $order_info['payment_postcode'], 
            'country' => $order_info['payment_iso_code_2'], 
            'phone' => $order_info['telephone'], 
            'cell_phone' => $order_info['telephone'], 
            'amount' => $ordAmount, 
            'email' => $order_info['email'], 
            'currency' => $order_info['currency_code'], 
            'ipaddress' => '65.153.12.232', 
            'site_url' => 'www.shop.philcare.com.ph', 
            'destination' => 'www.shop.philcare.com.ph/', 
            'redirect_url' => $this->url->link('payment/aurumpay/after_payment', '', 'SSL'),
            'server_callback_url' => $this->url->link('payment/aurumpay/process', '', 'SSL'),
            'merchant_data' => 'VIP customer', 

           // 'control' => '768eb8162fc361a3e14150ec46e9a6dd8fbfa483'
        );
        //echo '<pre>';
        //print_r($requestFields);
        //echo '</pre>';
        $requestFields['control'] = $this->signPaymentRequest($requestFields, $endpointId, $merchantControl);

        $responseFields = $this->sendRequest('https://gate.aurumpay.com/paynet/api/v2/sale-form/505', $requestFields);

        $red = $responseFields['redirect-url'];
        //print_r($red);
        header("Location: ".$red."");
	/*if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
            $data['base'] = HTTP_SERVER;
        } else {
            $data['base'] = HTTPS_SERVER;
	}
        
        if (isset($_POST['status'])) {
            return $this->load->view('payment/aurumpay-afterpayment.tpl', $data);
        }*/
    }
    
    public function after_payment(){
        
        $this->load->language('payment/aurumpay');
        $this->load->language('checkout/cart');

        $this->load->model('tool/image');
        $data['breadcrumbs'] = array();

    	$data['breadcrumbs'][] = array(
                'href' => $this->url->link('common/home'),
                'text' => $this->language->get('text_home')
    	);

    	$data['breadcrumbs'][] = array(
                'href' => $this->url->link('payment/aurumpay/after_payment'),
                'text' => $this->language->get('text_title')
    	);

        $data['status'] = "";
        $data['orderid']= "";
        $data['merchant_order'] = "";
	
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
            $data['status'] = $_POST['status'];
            $data['orderid']= $_POST['orderid'];
            
            $this->load->model('checkout/order');
					
            $data['merchant_order'] = $_POST['merchant_order'];
            
            //if($status == "approved"){
                switch($status) {
                    case 'approved':
                        $order_status_id = $this->config->get('aurumpay_completed_status_id');
			             break;
                    case 'declined':
                        $order_status_id = $this->config->get('aurumpay_denied_status_id');
                        break;
                    case 'error':
                        $order_status_id = $this->config->get('aurumpay_failed_status_id');
                        break;
                    case 'filtered':
                        $order_status_id = $this->config->get('aurumpay_processed_status_id');
                        break;
                    case 'processing':
                        $order_status_id = $this->config->get('aurumpay_processed_status_id');
                        break;
                    case 'unknown':
                        $order_status_id = $this->config->get('aurumpay_failed_status_id');
                        break;
                }
                //echo '<pre>';
                //print_r("StATUS==".$status." == ".$order_status_id);
                //echo '</pre>';
                $this->load->model('checkout/order');
                $order_id = $this->session->data['order_id'];
                //$order_status_id = $this->config->get('aurumpay_completed_status_id');
                //print_r("order id ==== ".$order_status_id);
                //$this->model_checkout_order->addOrderHistory($_POST['merchant_order'], $this->config->get('aurumpay_order_status_id'), "Transaction ID : " . $_POST['orderid'], TRUE);

                $data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
        
                $data['text_response'] = $this->language->get('text_response');
                $data['text_success'] = $this->language->get('text_success');
                $data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success', '', 'SSL'));
                $data['text_failure'] = $this->language->get('text_failure');
                $data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart'));

                $data['column_left'] = $this->load->controller('common/column_left');
                $data['column_right'] = $this->load->controller('common/column_right');
                $data['content_top'] = $this->load->controller('common/content_top');
                $data['content_bottom'] = $this->load->controller('common/content_bottom');
                $data['footer'] = $this->load->controller('common/footer');
                $data['header'] = $this->load->controller('common/header');
                $data['text_message'] = sprintf($this->language->get('text_description'), date($this->language->get('date_format_short')), $order_id,$this->language->get('text_title'));

                $order_info = $this->model_checkout_order->getOrder($order_id);
                if($status == "approved"){

                    foreach ($this->cart->getProducts() as $product) {

                        if($product['model']=="ERVPA40" || $product['model']=="ERVPK40" || $product['model']=="ERVPA60" || $product['model']=="ERVPK60" || $product['model']=="ERVPA80" || $product['model']=="ERVPK80" || $product['model']=="DACA"){
                            $url = "https://apps.philcare.com.ph/IPhilCareWS/Registration.svc/PurchasedPrePaidCard/?FirstName=".urlencode($order_info['firstname'])."&LastName=".urlencode($order_info['lastname'])."&MobileNo=".urlencode($order_info['telephone'])."&Email=".$order_info['email']."&CardType=".$product['model']."&OrderID=".$order_id."&Quantity=".$product['quantity'];
                            $string = file_get_contents($url,
                                false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
                            //$string = file_get_contents($url);
                            $json_a = json_decode($string, true);       

                        }
                        
                    }
                }

                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $order_status_id);
                
                $data['continue'] = $this->url->link('checkout/success', '', 'SSL');
					
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/aurumpay-afterpayment.tpl')) {
                    $this->template = $this->config->get('config_template') . '/payment/aurumpay-afterpayment.tpl';
                } else {
                    $this->template = 'payment/aurumpay-afterpayment.tpl';
                }   
        
            $this->response->setOutput($this->load->view($this->template, $data), $this->config->get('config_compression'));
                //$this->response->redirect($this->url->link('checkout/success'));
                //$this->response->setOutput($this->load->view('payment/aurumpay-afterpayment', $data));
                

            //}else{
            //    $data['continue'] = $this->url->link('checkout/cart');
            //    $data['msg'] = "Your transaction status is ".$status.". Transaction was not completed.";
            //    $this->response->setOutput($this->load->view('payment/aurumpay-failure', $data));
            //}
        }
        
        
        //$this->response->setOutput($this->load->view('payment/aurumpay-afterpayment', $data));
        
    }
    
    public function sendRequest($url, array $requestFields){
    //print_r($requestFields);
        $curl = curl_init($url);

        curl_setopt_array($curl, array
        (
            CURLOPT_HEADER         => 0,
            CURLOPT_USERAGENT      => 'PaynetEasy-Client/1.0',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST           => 1,
            CURLOPT_RETURNTRANSFER => 1
        ));
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestFields));

        $response = curl_exec($curl);

        if(curl_errno($curl))
        {
            $error_message  = 'Error occurred: ' . curl_error($curl);
            $error_code     = curl_errno($curl);
        }
        elseif(curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200)
        {
            $error_code     = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error_message  = "Error occurred. HTTP code: '{$error_code}'";
        }

        curl_close($curl);

        if (!empty($error_message))
        {
            throw new RuntimeException($error_message, $error_code);
        }

        if(empty($response))
        {
            throw new RuntimeException('Host response is empty');
        }

        $responseFields = array();

        parse_str($response, $responseFields);

        return $responseFields;
    }

    public function signString($s, $merchantControl){
        return sha1($s . $merchantControl);
    }

    /**
     * Signs payment (sale/auth/transfer) request
     *
     * @param 	array		$requestFields		request array
     * @param	string		$endpointOrGroupId	endpoint or endpoint group ID
     * @param	string		$merchantControl	merchant control key
     */
    public function signPaymentRequest($requestFields, $endpointOrGroupId, $merchantControl){
        $base = '';
        $base .= $endpointOrGroupId;
        $base .= $requestFields['client_orderid'];
        $base .= $requestFields['amount'] * 100;
        $base .= $requestFields['email'];

        return $this->signString($base, $merchantControl);
    }

    /**
     * Signs status request
     *
     * @param 	array		$requestFields		request array
     * @param	string		$login			merchant login
     * @param	string		$merchantControl	merchant control key
     */
    public function signStatusRequest($requestFields, $login, $merchantControl){
        $base = '';
        $base .= $login;
        $base .= $requestFields['client_orderid'];
        $base .= $requestFields['orderid'];

        return $this->signString($base, $merchantControl);
    }

}