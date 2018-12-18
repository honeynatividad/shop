<?php
class ControllerModuleBossSpecial extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/boss_special');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->document->addScript('view/javascript/bossthemes/ui/jquery-ui.min.js');
		$this->document->addStyle('view/javascript/bossthemes/ui/jquery-ui.min.css');
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_special', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_grid'] = $this->language->get('text_grid');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_fade'] = $this->language->get('text_fade');
		$data['text_scrollUp'] = $this->language->get('text_scrollUp');
		$data['text_shuffle'] = $this->language->get('text_shuffle');
		$data['text_edit'] = $this->language->get('text_edit');		
		
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_slider'] = $this->language->get('entry_slider');
		$data['entry_display'] = $this->language->get('entry_display');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_product_special'] = $this->language->get('entry_product_special');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_qty_color'] = $this->language->get('entry_qty_color');
		$data['entry_effects'] = $this->language->get('entry_effects');
		$data['entry_autoplay'] = $this->language->get('entry_autoplay');
		$data['entry_limit_product'] = $this->language->get('entry_limit_product');
		$data['entry_delay'] = $this->language->get('entry_delay');
		$data['entry_nav_nextprev'] = $this->language->get('entry_nav_nextprev');
		$data['entry_nav_thumb'] = $this->language->get('entry_nav_thumb');
		$data['entry_name'] = $this->language->get('entry_name');
		
		$data['entry_button_size'] = $this->language->get('entry_button_size');
		$data['entry_percent_color'] = $this->language->get('entry_percent_color');
		$data['entry_money_color'] = $this->language->get('entry_money_color');
		$data['entry_price_color'] = $this->language->get('entry_price_color');
		$data['entry_left_color'] = $this->language->get('entry_left_color');
		$data['entry_buynow_color'] = $this->language->get('entry_buynow_color');
		
		$data['entry_special_closed'] = $this->language->get('entry_special_closed');
		$data['label_money_saveoff'] = $this->language->get('label_money_saveoff');
		$data['label_price'] = $this->language->get('label_price');
		$data['label_left'] = $this->language->get('label_left');
		$data['label_buynow'] = $this->language->get('label_buynow');
		$data['label_qty'] = $this->language->get('label_qty');
		
		$data['tab_button_setting'] = $this->language->get('tab_button_setting');
		$data['tab_label_setting'] = $this->language->get('tab_label_setting');
		$data['tab_general_setting'] = $this->language->get('tab_general_setting');
		$data['tab_module_setting'] = $this->language->get('tab_module_setting');
		$data['tab_product_setting'] = $this->language->get('tab_product_setting');
		$data['tab_slider_setting'] = $this->language->get('tab_slider_setting');
		
		$data['column_image'] = $this->language->get('column_image');	
        $data['column_special_status'] = $this->language->get('column_special_status');		
		$data['column_name'] = $this->language->get('column_name');		
		$data['column_model'] = $this->language->get('column_model');		
		$data['column_price'] = $this->language->get('column_price');		
		$data['column_quantity'] = $this->language->get('column_quantity');		
		$data['column_status'] = $this->language->get('column_status');		
		$data['column_action'] = $this->language->get('column_action');
        $data['column_date_end'] = $this->language->get('column_date_end');		
		$data['column_date_start'] = $this->language->get('column_date_start');	
				
		$data['button_copy'] = $this->language->get('button_copy');		
		$data['button_insert'] = $this->language->get('button_insert');		
		$data['button_delete'] = $this->language->get('button_delete');		
		$data['button_filter'] = $this->language->get('button_filter');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_special', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		
		$data['token'] = $this->session->data['token'];
		
		$this->load->model('catalog/product');
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}
		
		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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
						
		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}		

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
        
        $data['products'] = array();

		$datadb = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		
		$this->load->model('tool/image');
		
		$product_total = $this->model_catalog_product->getTotalProducts($datadb);
			
		$results = $this->model_catalog_product->getProducts($datadb);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit_special'),
				'href' => $this->url->link('module/boss_special/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
	
			$special = false;
			
			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
			$date_start = '';
			$date_end = '';
			$special_status = '';
			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] <= date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
					$special = $product_special['price'];
					$date_start = $product_special['date_start'];
					$date_end = $product_special['date_end'];
					$special_status = 'Opening';
					break;
				}
				$date_start = $product_special['date_start'];
				$date_end = $product_special['date_end'];
				if($product_special['date_start'] > date('Y-m-d')){
					$special_status = 'Upcoming';
				}
				if($product_special['date_end'] <= date('Y-m-d')){
					$special_status = 'Closed';
				}	
			}
	
      		$data['products'][] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model'],
				'date_start'      => $date_start,
				'date_end'      => $date_end,
				'special_status'      => $special_status,
				'price'      => $result['price'],
				'special'    => $special,
				'image'      => $image,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
        
        $url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$data['sort_name'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
		$data['sort_status'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('module/boss_special', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
	
		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;
		
		$data['sort'] = $sort;
		$data['order'] = $order;
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($module_info)) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = array();
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = 1;
		}
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}	
				
		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (!empty($module_info)) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = 210;
		}	
			
		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (!empty($module_info)) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = 210;
		}
		
		if (isset($this->request->post['boss_special_product'])) {
			$special_products = $this->request->post['boss_special_product'];
		} elseif (!empty($module_info)) {
			$special_products = $module_info['boss_special_product'];
		} else {
			$special_products = array();
		}
		
		$data['special_products'] = array();
		
		if (!empty($special_products)){
			foreach ($special_products as $product_id) {
			
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info) {
					$data['special_products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}
		}
		
		if (isset($this->request->post['show_closed'])) {
			$data['show_closed'] = $this->request->post['show_closed'];
		} elseif (!empty($module_info)) {
			$data['show_closed'] = $module_info['show_closed'];
		} else {
			$data['show_closed'] = array();
		}
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/boss_special', $data));
	}
	
	public function getProductSpecials(){
		if($this->request->get['product_id']){
			$product_id = $this->request->get['product_id'];
			$this->load->model('catalog/product');
			$product_specials = $this->model_catalog_product->getProductSpecials($product_id);
			//
			$this->language->load('module/boss_special');
			
			$data['entry_customer_group'] = $this->language->get('entry_customer_group');
			$data['entry_date_start'] = $this->language->get('entry_date_start');
			$data['entry_date_end'] = $this->language->get('entry_date_end');
			$data['entry_priority'] = $this->language->get('entry_priority');
			$data['entry_price'] = $this->language->get('entry_price');
			$data['entry_quantity'] = $this->language->get('entry_quantity');
			
			$data['button_add_special'] = $this->language->get('button_add_special');
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_remove'] = $this->language->get('button_remove');
			
			$data['token'] = $this->session->data['token'];
			
			$this->load->model('sale/customer_group');
		
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
			
			$json = array();
			
			$data['product_specials'] = array();

			foreach ($product_specials as $product_special) {
				$data['product_specials'][] = array(
					'customer_group_id' => $product_special['customer_group_id'],
					'priority'          => $product_special['priority'],
					'price'             => $product_special['price'],
					'date_start'        => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
					'date_end'          => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
				);
			}
			
			$json['output'] = $this->load->view('module/boss_special_product', $data);
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function saveProductSpecials(){
		if($this->request->get['product_id']){
		
			$product_id = $this->request->get['product_id'];
			
			$this->load->model('module/boss_special');
			
			$this->language->load('module/boss_special');
			
			$product_specials = array();
			
			$json = array();
			
			if (isset($this->request->post['product_special'])) {
			
				$product_specials = $this->request->post['product_special'];
			}
				
			$this->model_module_boss_special->editProductSpecials($product_id,$product_specials);
				
			$json['success'] = $this->language->get('entry_save_success');
			
			
			$json['redirect'] = $this->url->link('module/boss_special&token=' . $this->session->data['token'], true);
		}
		$this->response->setOutput(json_encode($json));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_special')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!$this->request->post['image_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		
		if (!$this->request->post['image_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}			
						
			$data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => 20
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			
			
			foreach ($results as $result) {
				$special = false;
				
				$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
				
				foreach ($product_specials  as $product_special) {
					if ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] >= date('Y-m-d')) {
						$special = $product_special['price'];
				
						break;
					}					
				}
				if($special){
					$json[] = array(
						'product_id' => $result['product_id'],
						'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
					);	
				}
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
}
?>