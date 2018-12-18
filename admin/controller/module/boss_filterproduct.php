<?php
class ControllerModuleBossFilterProduct extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/boss_filterproduct');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_filterproduct', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
		//load data
		
		
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
		if (isset($this->error['limit'])) {
			$data['error_limit'] = $this->error['limit'];
		} else {
			$data['error_limit'] = '';
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
		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = array();
		}
		
		if (isset($this->error['error_perrow'])) {
			$data['error_perrow'] = $this->error['error_perrow'];
		} else {
			$data['error_perrow'] = array();
		}
		
		if (isset($this->error['error_numrow'])) {
			$data['error_numrow'] = $this->error['error_numrow'];
		} else {
			$data['error_numrow'] = array();
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
		
   		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/boss_filterproduct', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_filterproduct', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_filterproduct', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
   		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];	
			
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);
		//button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_add_tab'] = $this->language->get('button_add_tab');
		
		//module
		$data['module_stt'] = $this->language->get('module_stt');
		$data['module_setting'] = $this->language->get('module_setting');
		$data['module_tab'] = $this->language->get('module_tab');
		$data['text_module'] = $this->language->get('text_module');
		
		//entry 
		$data['entry_numrow'] = $this->language->get('entry_numrow');
		$data['entry_perrow'] = $this->language->get('entry_perrow');
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_class_css'] = $this->language->get('entry_class_css');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');		
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_scroll'] = $this->language->get('entry_scroll');
		$data['entry_use_scrolling_panel'] = $this->language->get('entry_use_scrolling_panel');
		$data['entry_tab'] = $this->language->get('entry_tab');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_description'] = $this->language->get('entry_description');
		
		//tab  
		$data['tab_stt'] = $this->language->get('tab_stt');
		$data['tab_title'] = $this->language->get('tab_title');
		$data['tab_icon'] = $this->language->get('tab_icon');
		$data['tab_icon_hover'] = $this->language->get('tab_icon_hover');
		$data['tab_get_product'] = $this->language->get('tab_get_product');
		
		
		//load text type filter
		$data['filter_types'] = array(
			"popular" =>$this->language->get('tab_popular_products'),
			"special" =>$this->language->get('tab_special_products'),
			"best_seller" =>$this->language->get('tab_best_seller_products'),
			"latest" =>$this->language->get('tab_latest_products'),
			"featured" =>$this->language->get('tab_featured'),
			"category" =>$this->language->get('tab_choose_a_category')
		);
					
		$data['columns'] = array("1","2","3","4","5","6","7","8","9","10","11","12");
					
		$data['class_csss'] = array(
			"bt-product-list" =>$this->language->get('class_product_list'),
			"column" =>$this->language->get('class_column'),
			"column-noimage" =>$this->language->get('class_column_no_image'),
			"bt-default" =>$this->language->get('class_none')
		);
		
		//load modules
		$data['module'] = array();
		
		if (isset($this->request->post['boss_filterproduct_module'])) {
			$data['module'] = $this->request->post['boss_filterproduct_module'];
		} elseif (!empty($module_info)) { 
			$data['module'] = $module_info['boss_filterproduct_module'];
		}else{
			$data['module'] = array();
		}
		$data['products'] = array();
		
		$this->load->model('catalog/product');
		//echo'<pre>';print_r($data_filters);echo'</pre>';die();
		if(isset($data['module']['tabs'])){
			foreach($data['module']['tabs'] as $i => $tab){
				if (isset($tab['icon']) && file_exists(DIR_IMAGE . $tab['icon'])) {
					$data['module']['tabs'][$i]['thumb'] = $this->model_tool_image->resize($tab['icon'], 50, 50);
				} else {
					$data['module']['tabs'][$i]['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
				}
				
				if($tab['type_product'] == 'featured'){
				
					if (isset($tab['product_featured'])) {
						$products = $tab['product_featured'];
					}else{
						$products = array();
					}
					
					foreach ($products as $product_id) {
						$product_info = $this->model_catalog_product->getProduct($product_id);

						if ($product_info) {
							$data['products'][] = array(
								'product_id' => $product_info['product_id'],
								'name'       => $product_info['name']
							);
						}
					}
				}
			}
			//echo'<pre>';print_r($data['module']);echo'</pre>';die();
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		//load languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		//load categoriescatalog_product
		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories(0);
		
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_filterproduct', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_filterproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		$boss_filterproduct_module = $this->request->post['boss_filterproduct_module'];
		
		if (isset($boss_filterproduct_module)) { 			
			if (!$boss_filterproduct_module['limit']) { 
				$this->error['limit'] = $this->language->get('error_limit');
			}
			if (!$boss_filterproduct_module['image_height']) { 
				$this->error['image_height'] = $this->language->get('error_image_height');
			}
			if (!$boss_filterproduct_module['image_width']) { 
				$this->error['image_width'] = $this->language->get('error_image_width');
			}
			if (!$boss_filterproduct_module['numrow']) { 
				$this->error['error_numrow'] = $this->language->get('error_numrow');
			}
			if (!$boss_filterproduct_module['perrow']) { 
				$this->error['error_perrow'] = $this->language->get('error_perrow');
			}
			if(isset($boss_filterproduct_module['tabs'])){
				foreach ($boss_filterproduct_module['tabs'] as $key => $valuetab) {
					if ($valuetab['type_product'] == 'category' && !isset($valuetab['filter_type_category'])) {
						$this->error['category'][$key] = $this->language->get('error_category');
						$this->error['warning'] = $this->language->get('error_category');
					}
				}
			}
		}
				
		return !$this->error;	
	}

	
}
?>