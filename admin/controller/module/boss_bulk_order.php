<?php
class ControllerModuleBossBulkOrder extends Controller {
	private $error = array();
	
	public function index() {   
		$this->load->language('module/boss_bulk_order');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_bulk_order', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->version;
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_search_product'] = $this->language->get('text_search_product');
		$data['text_search_category'] = $this->language->get('text_search_category');
		$data['text_search_model'] = $this->language->get('text_search_model');
		$data['text_search_tags'] = $this->language->get('text_search_tags');
		$data['text_search_price'] = $this->language->get('text_search_price');
		$data['text_image_width'] = $this->language->get('text_image_width');
		$data['text_image_height'] = $this->language->get('text_image_height');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_num_products'] = $this->language->get('entry_num_products');
		$data['entry_num_record'] = $this->language->get('entry_num_record');
		$data['entry_search_type'] = $this->language->get('entry_search_type');
		$data['entry_image_size'] = $this->language->get('entry_image_size');
		$data['entry_option'] = $this->language->get('entry_option');
		
		$data['help_num_products'] = $this->language->get('help_num_products');
		$data['help_num_record'] = $this->language->get('help_num_record');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['setting_general'] = $this->language->get('setting_general');
		$data['setting_option'] = $this->language->get('setting_option');
		$data['option_name'] = $this->language->get('option_name');
		$data['option_show'] = $this->language->get('option_show');
		$data['display_status'] = $this->language->get('display_status');
		$data['text_price_min'] = $this->language->get('text_price_min');
		$data['text_price_max'] = $this->language->get('text_price_max');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['num_products'])) {
			$data['error_num_products'] = $this->error['num_products'];
		} else {
			$data['error_num_products'] = '';
		}
		
		if (isset($this->error['num_record'])) {
			$data['error_num_record'] = $this->error['num_record'];
		} else {
			$data['error_num_record'] = '';
		}
		
		if (isset($this->error['image_width'])) {
			$data['error_image_width'] = $this->error['image_width'];
		} else {
			$data['error_image_width'] = '';
		}
		
		if (isset($this->error['image_height'])) {
			$data['error_image_height'] = $this->error['image_height'];
		} else {
			$data['error_image_height'] = '';
		}
		if (isset($this->error['price_min'])) {
			$data['error_price_min'] = $this->error['price_min'];
		} else {
			$data['error_price_min'] = '';
		}
		if (isset($this->error['price_max'])) {
			$data['error_price_max'] = $this->error['price_max'];
		} else {
			$data['error_price_max'] = '';
		}
        
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_bulk_order', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['action'] = $this->url->link('module/boss_bulk_order', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['boss_bulk_order'] = array();
		
		if (isset($this->request->post['boss_bulk_order'])) {
			$data['boss_bulk_order'] = $this->request->post['boss_bulk_order'];
		} else {
			$data['boss_bulk_order'] = $this->config->get('boss_bulk_order');
		}
		
		//echo'<pre>';print_r($data['boss_bulk_order']);echo'</pre>';
		if (!empty($data['boss_bulk_order'])) {
			$data['status'] = $data['boss_bulk_order']['status'];
			$data['num_products'] = $data['boss_bulk_order']['num_products'];
			$data['num_record'] = $data['boss_bulk_order']['num_record'];
			$data['search_product'] = $data['boss_bulk_order']['search_product'];
			$data['search_category'] = $data['boss_bulk_order']['search_category'];
			$data['search_model'] = $data['boss_bulk_order']['search_model'];
			$data['search_tags'] = $data['boss_bulk_order']['search_tags'];
			$data['search_price'] = $data['boss_bulk_order']['search_price'];
			$data['image_width'] = $data['boss_bulk_order']['image_width'];
			$data['image_height'] = $data['boss_bulk_order']['image_height'];
			$data['price_min'] = $data['boss_bulk_order']['price_min'];
			$data['price_max'] = $data['boss_bulk_order']['price_max'];
			$bulk_option = isset($data['boss_bulk_order']['option'])?$data['boss_bulk_order']['option']:array();
		}else{
			$data['status'] = 1;
			$data['num_products'] = 15;
			$data['num_record'] = 5;
			$data['search_product'] = 1;
			$data['search_category'] = 0;
			$data['search_model'] = 0;
			$data['search_tags'] = 0;
			$data['search_price'] = 0;
			$data['image_width'] = 80;
			$data['image_height'] = 80;
			$data['price_min'] = 1;
			$data['price_max'] = 1200;
			$bulk_option = array();
		}

		$this->load->model('catalog/option');
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get($this->config->get('config_theme').'_limit_admin'),
			'limit' => $this->config->get($this->config->get('config_theme').'_limit_admin')
		);
		
		$results = $this->model_catalog_option->getOptions($filter_data);
		//echo'<pre>';print_r($results);echo'</pre>';die();
		foreach ($results as $result) {
			$select = 0;
			if(in_array($result['option_id'], $bulk_option)){
				$select = 1;
			}
			$data['options'][] = array(
				'option_id'  => $result['option_id'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'selected' 	 => $select,
			);
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_bulk_order.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_bulk_order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['boss_bulk_order']) && !empty($this->request->post['boss_bulk_order'])) {
			$boss_bulk_order = $this->request->post['boss_bulk_order'];
			
			if (utf8_strlen($boss_bulk_order['num_products']) < 1 || !is_numeric($boss_bulk_order['num_products']) || $boss_bulk_order['num_products'] < 1 ) {
				$this->error['num_products'] = $this->language->get('error_num_products');
			}
			
			if (utf8_strlen($boss_bulk_order['num_record']) < 1 || !is_numeric($boss_bulk_order['num_record']) || $boss_bulk_order['num_record'] < 1 ) {
				$this->error['num_record'] = $this->language->get('error_num_record');
			}
			
			if (utf8_strlen($boss_bulk_order['image_width']) < 1 || !is_numeric($boss_bulk_order['image_width']) || $boss_bulk_order['image_width'] < 1 ) {
				$this->error['image_width'] = $this->language->get('error_image_width');
			}
			
			if (utf8_strlen($boss_bulk_order['image_height']) < 1 || !is_numeric($boss_bulk_order['image_height']) || $boss_bulk_order['image_height'] < 1 ) {
				$this->error['image_height'] = $this->language->get('error_image_height');
			}
			if (!is_numeric($boss_bulk_order['price_max']) || $boss_bulk_order['price_max'] < 1 ) {
				$this->error['price_max'] = $this->language->get('error_price_max');
			}
			
			if (utf8_strlen($boss_bulk_order['price_min']) < 1 || !is_numeric($boss_bulk_order['price_min']) || $boss_bulk_order['price_min'] < 1 ) {
				$this->error['price_min'] = $this->language->get('error_price_min');
			}
		}
		return !$this->error;	
	}	
}