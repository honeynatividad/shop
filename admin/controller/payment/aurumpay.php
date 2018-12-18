<?php

/* 
 * Admin setup for Aurumpay Payment
 * by HCN
 */

class ControllerPaymentAurumpay extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('payment/aurumpay');

	$this->document->setTitle($this->language->get('heading_title'));
		
	$this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            
            $this->load->model('setting/setting');
			
            $this->model_setting_setting->editSetting('aurumpay', $this->request->post);				
			
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
    		
    	$data['entry_endpoint'] = $this->language->get('entry_endpoint');
    	$data['entry_control_key'] = $this->language->get('entry_control_key');
    	$data['entry_api'] = $this->language->get('entry_api');
        $data['entry_url'] = $this->language->get('entry_url');
        //$data['entry_login'] = $this->language->get('entry_login');
        //$data['entry_password'] = $this->language->get('entry_password');
        
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
        
        //if (isset($this->error['login'])) {
        //    $data['error_login'] = $this->error['login'];
        //} else {
        //    $data['error_login'] = '';
        //}

     	//if (isset($this->error['password'])) {
        //        $data['error_password'] = $this->error['password'];
    	//} else {
        //    $data['error_password'] = '';
        //}

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
            'href'      => $this->url->link('payment/aurumpay', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
   	    );
		
	   $data['action'] = $this->url->link('payment/aurumpay', 'token=' . $this->session->data['token'], 'SSL');
		
	   $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
	
        if (isset($this->request->post['aurumpay_endpoint'])) {
            $data['aurumpay_endpoint'] = $this->request->post['aurumpay_endpoint'];
        } else {
            $data['aurumpay_endpoint'] = $this->config->get('aurumpay_endpoint');
        }
        
    	if (isset($this->request->post['aurumpay_control_key'])) {
                $data['aurumpay_control_key'] = $this->request->post['aurumpay_control_key'];
    	} else {
            $data['aurumpay_control_key'] = $this->config->get('aurumpay_control_key');
        }
		
    	if (isset($this->request->post['aurumpay_api'])) {
                $data['aurumpay_api'] = $this->request->post['aurumpay_api'];
    	} else {
            $data['aurumpay_api'] = $this->config->get('aurumpay_api');
	   }
        
        if (isset($this->request->post['aurumpay_url'])) {
            $data['aurumpay_url'] = $this->request->post['aurumpay_url'];
    	} else {
                $data['aurumpay_url'] = $this->config->get('aurumpay_url');
        }
        
        if (isset($this->request->post['aurumpay_login'])) {
            $data['aurumpay_login'] = $this->request->post['aurumpay_login'];
	    } else {
            $data['aurumpay_login'] = $this->config->get('aurumpay_login');
        }
        
        if (isset($this->request->post['aurumpay_password'])) {
            $data['aurumpay_password'] = $this->request->post['aurumpay_password'];
	    } else {
            $data['aurumpay_password'] = $this->config->get('aurumpay_password');
        }

		
	    if (isset($this->request->post['aurumpay_order_status_id'])) {
            $data['aurumpay_order_status_id'] = $this->request->post['aurumpay_order_status_id'];
        } else {
            $data['aurumpay_order_status_id'] = $this->config->get('aurumpay_order_status_id'); 
        } 

        if (isset($this->request->post['aurumpay_status'])) {
            $data['aurumpay_status'] = $this->request->post['aurumpay_status'];
	    } else {
            $data['aurumpay_status'] = $this->config->get('aurumpay_status');
	    }

	    if (isset($this->request->post['aurumpay_sort_order'])) {
            $data['aurumpay_sort_order'] = $this->request->post['aurumpay_sort_order'];
	    } else {
            $data['aurumpay_sort_order'] = $this->config->get('aurumpay_sort_order');
	    }

	    if (isset($this->request->post['aurumpay_canceled_reversal_status_id'])) {
            $data['aurumpay_canceled_reversal_status_id'] = $this->request->post['aurumpay_canceled_reversal_status_id'];
	    } else {
            $data['aurumpay_canceled_reversal_status_id'] = $this->config->get('aurumpay_canceled_reversal_status_id');
	    }

	    if (isset($this->request->post['aurumpay_completed_status_id'])) {
            $data['aurumpay_completed_status_id'] = $this->request->post['aurumpay_completed_status_id'];
        } else {
            $data['aurumpay_completed_status_id'] = $this->config->get('aurumpay_completed_status_id');
	    }

	    if (isset($this->request->post['aurumpay_denied_status_id'])) {
            $data['aurumpay_denied_status_id'] = $this->request->post['aurumpay_denied_status_id'];
        } else {
            $data['aurumpay_denied_status_id'] = $this->config->get('aurumpay_denied_status_id');
	    }

	    if (isset($this->request->post['aurumpay_expired_status_id'])) {
            $data['aurumpay_expired_status_id'] = $this->request->post['aurumpay_expired_status_id'];
	    } else {
            $data['aurumpay_expired_status_id'] = $this->config->get('aurumpay_expired_status_id');
	    }

	    if (isset($this->request->post['aurumpay_failed_status_id'])) {
            $data['aurumpay_failed_status_id'] = $this->request->post['aurumpay_failed_status_id'];
	    } else {
            $data['aurumpay_failed_status_id'] = $this->config->get('aurumpay_failed_status_id');
	    }

	    if (isset($this->request->post['aurumpay_pending_status_id'])) {
            $data['aurumpay_pending_status_id'] = $this->request->post['aurumpay_pending_status_id'];
	    } else {
            $data['aurumpay_pending_status_id'] = $this->config->get('aurumpay_pending_status_id');
	    }

	    if (isset($this->request->post['aurumpay_processed_status_id'])) {
            $data['aurumpay_processed_status_id'] = $this->request->post['aurumpay_processed_status_id'];
	    } else {
            $data['aurumpay_processed_status_id'] = $this->config->get('aurumpay_processed_status_id');
	    }

	    if (isset($this->request->post['aurumpay_refunded_status_id'])) {
            $data['aurumpay_refunded_status_id'] = $this->request->post['aurumpay_refunded_status_id'];
	    } else {
            $data['aurumpay_refunded_status_id'] = $this->config->get('aurumpay_refunded_status_id');
	    }

	    if (isset($this->request->post['aurumpay_reversed_status_id'])) {
            $data['aurumpay_reversed_status_id'] = $this->request->post['aurumpay_reversed_status_id'];
	    } else {
            $data['aurumpay_reversed_status_id'] = $this->config->get('aurumpay_reversed_status_id');
        }

	    if (isset($this->request->post['aurumpay_voided_status_id'])) {
            $data['aurumpay_voided_status_id'] = $this->request->post['aurumpay_voided_status_id'];
	    } else {
            $data['aurumpay_voided_status_id'] = $this->config->get('aurumpay_voided_status_id');
        }
                
	    $this->load->model('localisation/order_status');
		
	    $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
	    if (isset($this->request->post['aurumpay_geo_zone_id'])) {
            $data['aurumpay_geo_zone_id'] = $this->request->post['aurumpay_geo_zone_id'];
        } else {
            $data['aurumpay_geo_zone_id'] = $this->config->get('aurumpay_geo_zone_id'); 
	    } 
		
	    $this->load->model('localisation/geo_zone');
										
	    $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
	    if (isset($this->request->post['aurumpay_status'])) {
            $data['aurumpay_status'] = $this->request->post['aurumpay_status'];
	    } else {
            $data['aurumpay_status'] = $this->config->get('aurumpay_status');
	    }
		
	    if (isset($this->request->post['aurumpay_sort_order'])) {
            $data['aurumpay_sort_order'] = $this->request->post['aurumpay_sort_order'];
        } else {
            $data['aurumpay_sort_order'] = $this->config->get('aurumpay_sort_order');
	    }
		
	
    	$data['header'] = $this->load->controller('common/header');
    	$data['column_left'] = $this->load->controller('common/column_left');
    	$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/aurumpay.tpl', $data));

    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/aurumpay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
		
	    if (!$this->request->post['aurumpay_endpoint']) {
            $this->error['endpoint'] = $this->language->get('error_endpoint');
	    }
        
        if (!$this->request->post['aurumpay_control_key']) {
            $this->error['control_key'] = $this->language->get('error_control_key');
	    }
        
        if (!$this->request->post['aurumpay_api']) {
            $this->error['api'] = $this->language->get('error_api');
	    }
	
        if (!$this->request->post['aurumpay_url']) {
            $this->error['url'] = $this->language->get('error_url');
	    }
        
        //if (!$this->request->post['aurumpay_login']) {
        //    $this->error['login'] = $this->language->get('error_login');
	    //}
        
        //if (!$this->request->post['aurumpay_password']) {
        //    $this->error['password'] = $this->language->get('error_password');
	    //}

	    if (!$this->error) {
            return TRUE;
	    } else {
            return FALSE;
	    }	
    }
}