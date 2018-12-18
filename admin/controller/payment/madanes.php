<?php

/* 
 * Admin setup for Paypal Payment for Madanes
 * by HCN
 */

class ControllerPaymentMadanes extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('payment/madanes');

	   $this->document->setTitle($this->language->get('heading_title'));
		
	   $this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            
            $this->load->model('setting/setting');
			
            $this->model_setting_setting->editSetting('madanes', $this->request->post);				
			
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

        $data['entry_sandbox_account'] = $this->language->get('entry_sandbox_account');
        $data['entry_client_id'] = $this->language->get('entry_client_id');
        $data['entry_secret'] = $this->language->get('entry_secret');
    		
    	
    	
        
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

        if (isset($this->error['sandbox_account'])) {
                $data['error_sandbox_account'] = $this->error['sandbox_account'];
    	} else {
            $data['error_sandbox_account'] = '';
        }

        if (isset($this->error['client_id'])) {
                $data['error_client_id'] = $this->error['client_id'];
    	} else {
            $data['error_client_id'] = '';
        }

        if (isset($this->error['secret'])) {
                $data['error_secret'] = $this->error['secret'];
    	} else {
            $data['error_secret'] = '';
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
            'href'      => $this->url->link('payment/madanes', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
   	    );
		
	   $data['action'] = $this->url->link('payment/madanes', 'token=' . $this->session->data['token'], 'SSL');
		
	   $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
	
		if(isset($this->request->post['madanes_sandbox_account'])){
			$data['madanes_sandbox_account'] = $this->request->post['madanes_sandbox_account'];
		}else{
			$data['madanes_sandbox_account'] = $this->config->get('madanes_sandbox_account');
		}

		if(isset($this->request->post['madanes_client_id'])){
			$data['madanes_client_id'] = $this->request->post['madanes_client_id'];
		}else{
			$data['madanes_client_id'] = $this->config->get('madanes_client_id');
		}

		if(isset($this->request->post['madanes_secret'])){
			$data['madanes_secret'] = $this->request->post['madanes_secret'];
		}else{
			$data['madanes_secret'] =  $this->config->get('madanes_secret');
		}

		


		if(isset($this->request->post['madanes_order_status_id'])){
			$data['madanes_order_status_id'] = $this->request->post['madanes_order_status_id'];
		}else{
			$data['madanes_order_status_id'] = $this->config->get('madanes_order_status_id');
		}

		if(isset($this->request->post['madanes_order_status'])){
			$data['madanes_order_status'] = $this->request->post['madanes_order_status'];
		}else{
			$data['madanes_order_status'] = $this->config->get('madanes_order_status');
		}

		if(isset($this->request->post['madanes_sort_order'])){
			$data['madanes_sort_order'] =  $this->request->post['madanes_sort_order'];
		}else{
			$data['madanes_sort_order'] = $this->config->get('madanes_sort_order');
		}

		if(isset($this->request->post['madanes_canceled_reversal_status_id'])){
			$data['madanes_canceled_reversal_status_id'] = $this->request->post['madanes_canceled_reversal_status_id'];
		}else{
			$data['madanes_canceled_reversal_status_id'] = $this->config->get('madanes_canceled_reversal_status_id');
		}

		if(isset($this->request->post['madanes_completed_status_id'])){
			$data['madanes_completed_status_id'] = $this->request->post['madanes_completed_status_id'];
		}else{
			$data['madanes_completed_status_id'] = $this->config->get('madanes_completed_status_id');
		}

		if(isset($this->request->post['madanes_denied_status_id'])){
			$data['madanes_denied_status_id'] = $this->request->post['madanes_denied_status_id'];
		}else{
			$data['madanes_denied_status_id'] = $this->config->get('madanes_denied_status_id');
		}

		if(isset($this->request->post['madanes_expired_status_id'])){
			$data['madanes_expired_status_id'] = $this->request->post['madanes_expired_status_id'];
		}else{
			$data['madanes_expired_status_id'] = $this->config->get('madanes_expired_status_id');
		}

		if(isset($this->request->post['madanes_failed_status_id'])){
			$data['madanes_failed_status_id'] = $this->request->post['madanes_failed_status_id'];
		}else{
			$data['madanes_failed_status_id'] = $this->config->get('madanes_failed_status_id');
		}

		if(isset($this->request->post['madanes_pending_status_id'])){
			$data['madanes_pending_status_id'] = $this->request->post['madanes_pending_status_id'];
		}else{
			$data['madanes_pending_status_id'] =  $this->config->get('madanes_pending_status_id');
		}

		if(isset($this->request->post['madanes_processed_status_id'])){
			$data['madanes_processed_status_id'] = $this->request->post['madanes_processed_status_id'];
		}else{
			$data['madanes_processed_status_id'] =  $this->config->get('madanes_processed_status_id');
		}

		if(isset($this->request->post['madanes_refunded_status_id'])){
			$data['madanes_refunded_status_id'] = $this->reqest->post['madanes_refunded_status_id'];
		}else{
			$data['madanes_refunded_status_id'] = $this->config->get('madanes_refunded_status_id');
		}

		if(isset($this->request->post['madanes_reversed_status_id'])){
			$data['madanes_reversed_status_id'] = $this->request->post['madanes_reversed_status_id'];
		}else{
			$data['madanes_reversed_status_id'] = $this->config->get('madanes_reversed_status_id');
		}

		if(isset($this->request->post['madanes_voided_status_id'])){
			$data['madanes_voided_status_id'] = $this->request->post['madanes_voided_status_id'];
		}else{
			$data['madanes_voided_status_id'] =  $this->config->get('madanes_voided_status_id');
		}

                
	    $this->load->model('localisation/order_status');
		
	    $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
	    if (isset($this->request->post['madanes_geo_zone_id'])) {
            $data['madanes_geo_zone_id'] = $this->request->post['madanes_geo_zone_id'];
        } else {
            $data['madanes_geo_zone_id'] = $this->config->get('madanes_geo_zone_id'); 
	    } 
		
	    $this->load->model('localisation/geo_zone');
										
	    $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
	    if (isset($this->request->post['madanes_status'])) {
            $data['madanes_status'] = $this->request->post['madanes_status'];
	    } else {
            $data['madanes_status'] = $this->config->get('madanes_status');
	    }
		
	    
	
    	$data['header'] = $this->load->controller('common/header');
    	$data['column_left'] = $this->load->controller('common/column_left');
    	$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/madanes.tpl', $data));

    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/aurumpay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
		
	    if (!$this->request->post['madanes_sandbox_account']) {
            $this->error['sandbox_account'] = $this->language->get('error_sandbox_account');
	    }

	    if (!$this->request->post['madanes_client_id']) {
            $this->error['client_id'] = $this->language->get('error_client_id');
	    }

	    if (!$this->request->post['madanes_secret']) {
            $this->error['secret'] = $this->language->get('error_secret');
	    }

	            
        
	    if (!$this->error) {
            return TRUE;
	    } else {
            return FALSE;
	    }	
    }
}