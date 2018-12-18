<?php

/* 
 * Admin setup for Dragonpay Payment
 * by HCN
 */

class ControllerPaymentDragonpay extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('payment/dragonpay');

	$this->document->setTitle($this->language->get('heading_title'));
		
	$this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            
            $this->load->model('setting/setting');
			
            $this->model_setting_setting->editSetting('dragonpay', $this->request->post);				
			
            $this->session->data['success'] = $this->language->get('text_success'); 

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
	}
        
        $data['heading_title'] = $this->language->get('heading_title');

    	$data['text_edit'] = $this->language->get('text_edit');
    	$data['text_enabled'] = $this->language->get('text_enabled');
    	$data['text_disabled'] = $this->language->get('text_disabled');
    	$data['text_all_zones'] = $this->language->get('text_all_zones');
    	$data['text_sim'] = $this->language->get('text_sim');
    	$data['text_test'] = $this->language->get('text_test');
    	$data['text_live'] = $this->language->get('text_live');
    	$data['text_payment'] = $this->language->get('text_payment');
    	$data['text_defered'] = $this->language->get('text_defered');
    	$data['text_authenticate'] = $this->language->get('text_authenticate');
    		
    	$data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
    	$data['entry_merchant_password'] = $this->language->get('entry_merchant_password');
    	$data['entry_merchant_name'] = $this->language->get('entry_merchant_name');
    	$data['entry_merchant_url'] = $this->language->get('entry_merchant_url');
    	
    	
        
        $data['entry_test'] = $this->language->get('entry_test');
    	$data['entry_transaction'] = $this->language->get('entry_transaction');
    	$data['entry_order_status'] = $this->language->get('entry_order_status');		
    	$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
    	$data['entry_status'] = $this->language->get('entry_status');
    	$data['entry_sort_order'] = $this->language->get('entry_sort_order');
    		
    	$data['button_save'] = $this->language->get('button_save');
    	$data['button_cancel'] = $this->language->get('button_cancel');

	    $data['tab_general'] = $this->language->get('tab_general');
        
        
        $data['entry_canceled_reversal_status'] = $this->language->get('entry_canceled_reversal_status');
    	$data['entry_completed_status'] = $this->language->get('entry_completed_status');
    	$data['entry_denied_status'] = $this->language->get('entry_denied_status');
    	$data['entry_expired_status'] = $this->language->get('entry_expired_status');
    	$data['entry_failed_status'] = $this->language->get('entry_failed_status');
    	$data['entry_pending_status'] = $this->language->get('entry_pending_status');
    	$data['entry_processed_status'] = $this->language->get('entry_processed_status');
    	$data['entry_refunded_status'] = $this->language->get('entry_refunded_status');
    	$data['entry_reversed_status'] = $this->language->get('entry_reversed_status');
    	$data['entry_voided_status'] = $this->language->get('entry_voided_status');
        
        $data['tab_order_status'] = $this->language->get('tab_order_status');

     	if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
    	} else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['merchant_id'])) {
                $data['error_merchant_id'] = $this->error['merchant_id'];
    	} else {
            $data['error_merchant_id'] = '';
        }

        if (isset($this->error['merchant_password'])) {
                $data['error_merchant_password'] = $this->error['merchant_password'];
    	} else {
            $data['error_merchant_password'] = '';
        }

        if (isset($this->error['merchant_name'])) {
                $data['error_merchant_name'] = $this->error['merchant_name'];
    	} else {
            $data['error_merchant_name'] = '';
        }

        if (isset($this->error['merchant_url'])) {
                $data['error_merchant_url'] = $this->error['merchant_url'];
    	} else {
            $data['error_merchant_url'] = '';
        }
        
        if (isset($this->error['api'])) {
            $data['error_api'] = $this->error['api'];
        } else {
            $data['error_api'] = '';
        }

 	    if (isset($this->error['control_key'])) {
            $data['error_control_key'] = $this->error['control_key'];
        } else {
            $data['error_control_key'] = '';
        }
        
        if (isset($this->error['endpoint'])) {
            $data['error_endpoint'] = $this->error['endpoint'];
        } else {
            $data['error_endpoint'] = '';
        }
        
        if (isset($this->error['url'])) {
            $data['error_url'] = $this->error['url'];
        } else {
            $data['error_url'] = '';
        }
        
        if (isset($this->error['login'])) {
            $data['error_login'] = $this->error['login'];
        } else {
            $data['error_login'] = '';
        }

     	if (isset($this->error['password'])) {
                $data['error_password'] = $this->error['password'];
    	} else {
            $data['error_password'] = '';
        }

        $data['breadcrumbs'] = array();

   	    $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

   	    $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_payment'),
            'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
   	    );

   	    $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('payment/dragonpay', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
   	    );
		
	   $data['action'] = $this->url->link('payment/dragonpay', 'token=' . $this->session->data['token'], 'SSL');
		
	   $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
	
		if(isset($this->request->post['dragonpay_merchant_id'])){
			$data['dragonpay_merchant_id'] = $this->request->post['dragonpay_merchant_id'];
		}else{
			$data['dragonpay_merchant_id'] = $this->config->get('dragonpay_merchant_id');
		}

		if(isset($this->request->post['dragonpay_merchant_password'])){
			$data['dragonpay_merchant_password'] = $this->request->post['dragonpay_merchant_password'];
		}else{
			$data['dragonpay_merchant_password'] = $this->config->get('dragonpay_merchant_password');
		}

		if(isset($this->request->post['dragonpay_merchant_name'])){
			$data['dragonpay_merchant_name'] = $this->request->post['dragonpay_merchant_name'];
		}else{
			$data['dragonpay_merchant_name'] =  $this->config->get('dragonpay_merchant_name');
		}

		if(isset($this->request->post['dragonpay_merchant_url'])){
			$data['dragonpay_merchant_url'] = $this->request->post['dragonpay_merchant_url'];
		}else{
			$data['dragonpay_merchant_url'] = $this->config->get('dragonpay_merchant_url');
		}


		if(isset($this->request->post['dragonpay_order_status_id'])){
			$data['dragonpay_order_status_id'] = $this->request->post['dragonpay_order_status_id'];
		}else{
			$data['dragonpay_order_status_id'] = $this->config->get('dragonpay_order_status_id');
		}

		if(isset($this->request->post['dragonpay_order_status'])){
			$data['dragonpay_order_status'] = $this->request->post['dragonpay_order_status'];
		}else{
			$data['dragonpay_order_status'] = $this->config->get('dragonpay_order_status');
		}

		if(isset($this->request->post['dragonpay_sort_order'])){
			$data['dragonpay_sort_order'] =  $this->request->post['dragonpay_sort_order'];
		}else{
			$data['dragonpay_sort_order'] = $this->config->get('dragonpay_sort_order');
		}

		if(isset($this->request->post['dragonpay_canceled_reversal_status_id'])){
			$data['dragonpay_canceled_reversal_status_id'] = $this->request->post['dragonpay_canceled_reversal_status_id'];
		}else{
			$data['dragonpay_canceled_reversal_status_id'] = $this->config->get('dragonpay_canceled_reversal_status_id');
		}

		if(isset($this->request->post['dragonpay_completed_status_id'])){
			$data['dragonpay_completed_status_id'] = $this->request->post['dragonpay_completed_status_id'];
		}else{
			$data['dragonpay_completed_status_id'] = $this->config->get('dragonpay_completed_status_id');
		}

		if(isset($this->request->post['dragonpay_denied_status_id'])){
			$data['dragonpay_denied_status_id'] = $this->request->post['dragonpay_denied_status_id'];
		}else{
			$data['dragonpay_denied_status_id'] = $this->config->get('dragonpay_denied_status_id');
		}

		if(isset($this->request->post['dragonpay_expired_status_id'])){
			$data['dragonpay_expired_status_id'] = $this->request->post['dragonpay_expired_status_id'];
		}else{
			$data['dragonpay_expired_status_id'] = $this->config->get('dragonpay_expired_status_id');
		}

		if(isset($this->request->post['dragonpay_failed_status_id'])){
			$data['dragonpay_failed_status_id'] = $this->request->post['dragonpay_failed_status_id'];
		}else{
			$data['dragonpay_failed_status_id'] = $this->config->get('dragonpay_failed_status_id');
		}

		if(isset($this->request->post['dragonpay_pending_status_id'])){
			$data['dragonpay_pending_status_id'] = $this->request->post['dragonpay_pending_status_id'];
		}else{
			$data['dragonpay_pending_status_id'] =  $this->config->get('dragonpay_pending_status_id');
		}

		if(isset($this->request->post['dragonpay_processed_status_id'])){
			$data['dragonpay_processed_status_id'] = $this->request->post['dragonpay_processed_status_id'];
		}else{
			$data['dragonpay_processed_status_id'] =  $this->config->get('dragonpay_processed_status_id');
		}

		if(isset($this->request->post['dragonpay_refunded_status_id'])){
			$data['dragonpay_refunded_status_id'] = $this->reqest->post['dragonpay_refunded_status_id'];
		}else{
			$data['dragonpay_refunded_status_id'] = $this->config->get('dragonpay_refunded_status_id');
		}

		if(isset($this->request->post['dragonpay_reversed_status_id'])){
			$data['dragonpay_reversed_status_id'] = $this->request->post['dragonpay_reversed_status_id'];
		}else{
			$data['dragonpay_reversed_status_id'] = $this->config->get('dragonpay_reversed_status_id');
		}

		if(isset($this->request->post['dragonpay_voided_status_id'])){
			$data['dragonpay_voided_status_id'] = $this->request->post['dragonpay_voided_status_id'];
		}else{
			$data['dragonpay_voided_status_id'] =  $this->config->get('dragonpay_voided_status_id');
		}

                
	    $this->load->model('localisation/order_status');
		
	    $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
	    if (isset($this->request->post['dragonpay_geo_zone_id'])) {
            $data['dragonpay_geo_zone_id'] = $this->request->post['dragonpay_geo_zone_id'];
        } else {
            $data['dragonpay_geo_zone_id'] = $this->config->get('dragonpay_geo_zone_id'); 
	    } 
		
	    $this->load->model('localisation/geo_zone');
										
	    $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
	    if (isset($this->request->post['dragonpay_status'])) {
            $data['dragonpay_status'] = $this->request->post['dragonpay_status'];
	    } else {
            $data['dragonpay_status'] = $this->config->get('dragonpay_status');
	    }
		
	    
	
    	$data['header'] = $this->load->controller('common/header');
    	$data['column_left'] = $this->load->controller('common/column_left');
    	$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/dragonpay.tpl', $data));

    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/aurumpay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
		
	    if (!$this->request->post['dragonpay_merchant_id']) {
            $this->error['merchant_id'] = $this->language->get('error_merchant_id');
	    }

	    if (!$this->request->post['dragonpay_merchant_password']) {
            $this->error['merchant_password'] = $this->language->get('error_merchant_password');
	    }

	    if (!$this->request->post['dragonpay_merchant_name']) {
            $this->error['merchant_name'] = $this->language->get('error_merchant_name');
	    }

	    if (!$this->request->post['dragonpay_merchant_url']) {
            $this->error['merchant_url'] = $this->language->get('error_merchant_url');
	    }
        
        
        
	    if (!$this->error) {
            return TRUE;
	    } else {
            return FALSE;
	    }	
    }
}