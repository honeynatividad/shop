<?php
class ControllerModuleBossListGridDeal extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->load->language('module/boss_listgriddeal');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->language('module/boss_deals');
		
		$this->document->addScript('view/javascript/bossthemes/ui/jquery-ui.min.js');
		$this->document->addStyle('view/javascript/bossthemes/ui/jquery-ui.min.css');
		
		$this->load->model('catalog/product');
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_listgriddeal', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
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
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_listgriddeal', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_listgriddeal', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/boss_listgriddeal', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['token'] = $this->session->data['token'];
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		
		//button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add_tab'] = $this->language->get('button_add_tab');
				
		//entry 
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_sub_title'] = $this->language->get('entry_sub_title');
		$data['entry_type_product'] = $this->language->get('entry_type_product');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_properrow'] = $this->language->get('entry_properrow');
		$data['entry_numrow'] = $this->language->get('entry_numrow');
		$data['entry_list_grid'] = $this->language->get('entry_list_grid');
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_product'] = $this->language->get('entry_product');
		
		//text
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		
		//tab
		$data['tab_stt'] = $this->language->get('tab_stt');
		$data['tab_title'] = $this->language->get('tab_title');
		$data['tab_sub_title'] = $this->language->get('tab_sub_title');
		$data['tab_get_product'] = $this->language->get('tab_get_product');
		$data['tab_get_products_from'] = $this->language->get('tab_get_products_from');
		
		$data['product_types'] = array(
			"all" =>$this->language->get('tab_all_products'),
			"featured" =>$this->language->get('tab_featured_products'),
			"category" =>$this->language->get('tab_choose_a_category'),
		);
			
		$data['type_list'] = $this->language->get('type_list');
		$data['type_grid'] = $this->language->get('type_grid');
		
		$data['column_full'] = $this->language->get('column_full');
		$data['column_half'] = $this->language->get('column_half');
		
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
		} elseif (isset($module_info['title'])) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = '';
		}
		
		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (!empty($module_info)) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = 200;
		}	
			
		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (!empty($module_info)) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = 200;
		}
		
		if (isset($this->request->post['column'])) {
			$data['column'] = $this->request->post['column'];
		} elseif (isset($module_info['column'])) {
			$data['column'] = $module_info['column'];
		} else {
			$data['column'] = 4;
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['class_label'])) {
			$data['class_label'] = $this->request->post['class_label'];
		} elseif (!empty($module_info['class_label'])) {
			$data['class_label'] = $module_info['class_label'];
		} else {
			$data['class_label'] = '';
		}
		
		if (isset($this->request->post['sort_product'])) {
			$data['sort_product'] = $this->request->post['sort_product'];
		} elseif (!empty($module_info['sort_product'])) {
			$data['sort_product'] = $module_info['sort_product'];
		} else {
			$data['sort_product'] = '';
		}
		if (isset($this->request->post['deals_filter'])) {
			$data['deals_filter'] = $this->request->post['deals_filter'];
		} elseif (!empty($module_info['deals_filter'])) {
			$data['deals_filter'] = $module_info['deals_filter'];
		} else {
			$data['deals_filter'] = '';
		}
		if (isset($this->request->post['show_countdown'])) {
			$data['show_countdown'] = $this->request->post['show_countdown'];
		} elseif (!empty($module_info['show_countdown'])) {
			$data['show_countdown'] = $module_info['show_countdown'];
		} else {
			$data['show_countdown'] = '';
		}
		if (isset($this->request->post['auto_repeat'])) {
			$data['auto_repeat'] = $this->request->post['auto_repeat'];
		} elseif (!empty($module_info['auto_repeat'])) {
			$data['auto_repeat'] = $module_info['auto_repeat'];
		} else {
			$data['auto_repeat'] = '';
		}
		
		//load module
		$data['module'] = array();
		$data['products'] = array();
		
		if (isset($this->request->post['boss_listgriddeal_module'])) {
			$data['module'] = $this->request->post['boss_listgriddeal_module'];
		} elseif (!empty($module_info)) {
			$data['module'] = $module_info['boss_listgriddeal_module'];
		} else {
			$data['module'] = array();
		}
		
		$this->load->model('catalog/product');
		//echo'<pre>';print_r($module_info);echo'</pre>';die();
		if(isset($data['module'])){
			foreach($data['module'] as $i => $tab){
				if($tab['type_product'] == 'featured'){
				
					if (isset($tab['deal_products'])) {
						$products = $tab['deal_products'];
					}else{
						$products = array();
					}
					
					foreach ($products as $product_id) {
						$product_info = $this->model_catalog_product->getProduct($product_id);

						if ($product_info) {
							$data['products'][$i][] = array(
								'product_id' => $product_info['product_id'],
								'name'       => $product_info['name']
							);
						}
					}
				}
			}
			
		}
		//echo'<pre>';print_r($data['products']);echo'</pre>';die();
		//load languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		//load categoriescatalog_product
		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories(0);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('module/boss_listgriddeal.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_listgriddeal')) {
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
		
		$boss_listgriddeal = $this->request->post['boss_listgriddeal'];
		
		if (isset($boss_listgriddeal)) {
			foreach ($boss_listgriddeal as $key => $valuetab) {
				if ($valuetab['type_product'] == 'category' && !isset($valuetab['listgrid_type_category'])) {
					$this->error['category'][$key] = $this->language->get('error_category');
					$this->error['warning'] = $this->language->get('error_category');
				}
			}
		}
		return !$this->error;
	}
}
?>