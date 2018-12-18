<?php

/* 
 * This is for iPay88 plugins for opencart
 * by HCN
 * 
 */
class ControllerPaymentIpay88 extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('payment/ipay88');

		//$this->document->title = $this->language->get('heading_title');
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->load->model('setting/setting');
			
            $this->model_setting_setting->editSetting('ipay88', $this->request->post);				
			
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
			
		$data['entry_vendor'] = $this->language->get('entry_vendor');
		$data['entry_password'] = $this->language->get('entry_password');
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

		$data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
		} else {
            $data['error_warning'] = '';
        }

 		if (isset($this->error['vendor'])) {
            $data['error_vendor'] = $this->error['vendor'];
        } else {
            $data['error_vendor'] = '';
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
            'href'      => $this->url->link('payment/ipay88', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('payment/ipay88', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['ipay88_vendor'])) {
            $data['ipay88_vendor'] = $this->request->post['ipay88_vendor'];
		} else {
            $data['ipay88_vendor'] = $this->config->get('ipay88_vendor');
        }
		
		if (isset($this->request->post['ipay88_password'])) {
            $data['ipay88_password'] = $this->request->post['ipay88_password'];
		} else {
            $data['ipay88_password'] = $this->config->get('ipay88_password');
		}

		
		if (isset($this->request->post['ipay88_order_status_id'])) {
            $data['ipay88_order_status_id'] = $this->request->post['ipay88_order_status_id'];
        } else {
            $data['ipay88_order_status_id'] = $this->config->get('ipay88_order_status_id'); 
        } 

		$this->load->model('localisation/order_status');
		
		
		if (isset($this->request->post['ipay88_geo_zone_id'])) {
            $data['ipay88_geo_zone_id'] = $this->request->post['ipay88_geo_zone_id'];
        } else {
            $data['ipay88_geo_zone_id'] = $this->config->get('ipay88_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['ipay88_status'])) {
            $data['ipay88_status'] = $this->request->post['ipay88_status'];
		} else {
            $data['ipay88_status'] = $this->config->get('ipay88_status');
		}
		
		if (isset($this->request->post['ipay88_sort_order'])) {
            $data['ipay88_sort_order'] = $this->request->post['ipay88_sort_order'];
        } else {
            $data['ipay88_sort_order'] = $this->config->get('ipay88_sort_order');
		}

		if (isset($this->request->post['ipay88_canceled_status_id'])) {
            $data['ipay88_canceled_status_id'] = $this->request->post['ipay88_canceled_status_id'];
	    } else {
            $data['ipay88_canceled_status_id'] = $this->config->get('ipay88_canceled_status_id');
	    }
		
		if (isset($this->request->post['ipay88_completed_status_id'])) {
            $data['ipay88_completed_status_id'] = $this->request->post['ipay88_completed_status_id'];
	    } else {
            $data['ipay88_completed_status_id'] = $this->config->get('ipay88_completed_status_id');
	    }

	    if (isset($this->request->post['ipay88_denied_status_id'])) {
            $data['ipay88_denied_status_id'] = $this->request->post['ipay88_denied_status_id'];
	    } else {
            $data['ipay88_denied_status_id'] = $this->config->get('ipay88_denied_status_id');
	    }

	    if (isset($this->request->post['ipay88_expired_status_id'])) {
            $data['ipay88_expired_status_id'] = $this->request->post['ipay88_expired_status_id'];
	    } else {
            $data['ipay88_expired_status_id'] = $this->config->get('ipay88_expired_status_id');
	    }

	    if (isset($this->request->post['ipay88_failed_status_id'])) {
            $data['ipay88_failed_status_id'] = $this->request->post['ipay88_failed_status_id'];
	    } else {
            $data['ipay88_failed_status_id'] = $this->config->get('ipay88_failed_status_id');
	    }

	    if (isset($this->request->post['ipay88_pending_status_id'])) {
            $data['ipay88_pending_status_id'] = $this->request->post['ipay88_pending_status_id'];
	    } else {
            $data['ipay88_pending_status_id'] = $this->config->get('ipay88_pending_status_id');
	    }

	    if (isset($this->request->post['ipay88_processed_status_id'])) {
            $data['ipay88_processed_status_id'] = $this->request->post['ipay88_processed_status_id'];
	    } else {
            $data['ipay88_processed_status_id'] = $this->config->get('ipay88_processed_status_id');
	    }

	    if (isset($this->request->post['ipay88_refunded_status_id'])) {
            $data['ipay88_refunded_status_id'] = $this->request->post['ipay88_refunded_status_id'];
	    } else {
            $data['ipay88_refunded_status_id'] = $this->config->get('ipay88_refunded_status_id');
	    }

	    if (isset($this->request->post['ipay88_reversed_status_id'])) {
            $data['ipay88_reversed_status_id'] = $this->request->post['ipay88_reversed_status_id'];
	    } else {
            $data['ipay88_reversed_status_id'] = $this->config->get('ipay88_reversed_status_id');
	    }

	    if (isset($this->request->post['ipay88_voided_status_id'])) {
            $data['ipay88_voided_status_id'] = $this->request->post['ipay88_voided_status_id'];
	    } else {
            $data['ipay88_voided_status_id'] = $this->config->get('ipay88_voided_status_id');
	    }

	    
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
	
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/ipay88.tpl', $data));
    }


    private function validate() {

        if (!$this->user->hasPermission('modify', 'payment/ipay88')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
		
		if (!$this->request->post['ipay88_vendor']) {
            $this->error['vendor'] = $this->language->get('error_vendor');
		}        

		if (!$this->request->post['ipay88_password']) {
            $this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->error) {
            return TRUE;
		} else {
            return FALSE;
		}	
    }
}