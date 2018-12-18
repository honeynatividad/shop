<?php
class ControllerModuleBossFeatured extends Controller {
	private $error = array(); 
	
	public function index() {  
	
		$this->load->language('module/boss_featured');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product');
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_featured', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = array();
		}
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = array();
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
			'href'      => $this->url->link('module/boss_featured', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_featured', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_featured', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		
		$data['token'] = $this->session->data['token'];
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		
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
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_width_column'] = $this->language->get('entry_width_column');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_class'] = $this->language->get('entry_class');
		$data['entry_img_large'] = $this->language->get('entry_img_large');
		$data['entry_row'] = $this->language->get('entry_row');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_scrolling'] = $this->language->get('entry_scrolling');
		$data['entry_properrow'] = $this->language->get('entry_properrow');
		$data['entry_get_prolarge'] = $this->language->get('entry_get_prolarge');
		$data['entry_prolarge'] = $this->language->get('entry_prolarge');
		$data['entry_show_prolarge'] = $this->language->get('entry_show_prolarge');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_name'] = $this->language->get('entry_name');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		
		//tab  
		$data['tab_stt'] = $this->language->get('tab_stt');
		$data['text_title'] = $this->language->get('text_title');
		$data['tab_get_product'] = $this->language->get('tab_get_product');
		$data['tab_large_product'] = $this->language->get('tab_large_product');
		
		
		//load text type filter
		
		//load text position
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_center'] = $this->language->get('text_center');
		$data['text_left'] = $this->language->get('text_left');
		$data['text_right'] = $this->language->get('text_right');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_navarrow'] = $this->language->get('text_navarrow');
		$data['text_navpag'] = $this->language->get('text_navpag');
		$data['text_navboth'] = $this->language->get('text_navboth');
		$data['entry_nav'] = $this->language->get('entry_nav');
		
		$data['filter_types'] = array(
					"popular" =>$this->language->get('tab_popular_products'),
					"special" =>$this->language->get('tab_special_products'),
					"best_seller" =>$this->language->get('tab_best_seller_products'),
					"latest" =>$this->language->get('tab_latest_products'),
					"featured" =>$this->language->get('tab_featured_products'),
					"category" =>$this->language->get('tab_choose_a_category')
					);
		
		$data['positions'] = array(
					"content_top" => $this->language->get('text_content_top'),
					"content_bottom" => $this->language->get('text_content_bottom'),
					"column_left" => $this->language->get('text_column_left'),
					"column_right" => $this->language->get('text_column_right')
					);
		$data['arrstatus'] = array(
					"0" => $this->language->get('text_disabled'),
					"1" => $this->language->get('text_enabled')
					);
		
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
		
		if (isset($this->request->post['type_product'])) {
			$data['type_product'] = $this->request->post['type_product'];
		} elseif (!empty($module_info)) {
			$data['type_product'] = $module_info['type_product'];
		} else {
			$data['type_product'] = '';
		}
		
		$type_product = $data['type_product'];
		
		$data['product_larges'] = array();
		
		$this->load->model('catalog/product');
		
		if($type_product =='featured'){
		
			$data['products'] = array();
			
			if (isset($this->request->post['product_featured'])) {
				$products = $this->request->post['product_featured'];
			} elseif (!empty($module_info)) {
				$products = $module_info['product_featured'];
			} else {
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
		
		if($type_product =='category'){
		
			if (isset($this->request->post['category'])) {
				$data['category_name'] = $this->request->post['category'];
			} elseif (!empty($module_info)) {
				$data['category_name'] = $module_info['category'];
			} else {
				$data['category_name'] = '';
			}
			
			if (isset($this->request->post['category_id'])) {
				$data['category_id'] = $this->request->post['category_id'];
			} elseif (!empty($module_info)) {
				$data['category_id'] = $module_info['category_id'];
			} else {
				$data['category_id'] = '';
			}
			
		}
		
		if (isset($this->request->post['product_name'])) {
			$data['product_name'] = $this->request->post['product_name'];
		} elseif (!empty($module_info)) {
			$data['product_name'] = $module_info['product_name'];
		} else {
			$data['product_name'] = '';
		}
		
		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($module_info)) {
			$data['product_id'] = $module_info['product_id'];
		} else {
			$data['product_id'] = '';
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
		
		if (isset($this->request->post['img_width'])) {
			$data['img_width'] = $this->request->post['img_width'];
		} elseif (!empty($module_info)) {
			$data['img_width'] = $module_info['img_width'];
		} else {
			$data['img_width'] = 380;
		}	
			
		if (isset($this->request->post['img_height'])) {
			$data['img_height'] = $this->request->post['img_height'];
		} elseif (!empty($module_info)) {
			$data['img_height'] = $module_info['img_height'];
		} else {
			$data['img_height'] = 380;
		}
		
		if (isset($this->request->post['class_css'])) {
			$data['class_css'] = $this->request->post['class_css'];
		} elseif (!empty($module_info)) {
			$data['class_css'] = $module_info['class_css'];
		} else {
			$data['class_css'] = 'none-class';
		}
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}
		
		if (isset($this->request->post['show_slider'])) {
			$data['show_slider'] = $this->request->post['show_slider'];
		} elseif (!empty($module_info)) {
			$data['show_slider'] = $module_info['show_slider'];
		} else {
			$data['show_slider'] = 0;
		}
		
		if (isset($this->request->post['num_row'])) {
			$data['num_row'] = $this->request->post['num_row'];
		} elseif (!empty($module_info)) {
			$data['num_row'] = $module_info['num_row'];
		} else {
			$data['num_row'] = 1;
		}
		
		if (isset($this->request->post['per_row'])) {
			$data['per_row'] = $this->request->post['per_row'];
		} elseif (!empty($module_info)) {
			$data['per_row'] = $module_info['per_row'];
		} else {
			$data['per_row'] = 4;
		}
		
		if (isset($this->request->post['nav_type'])) {
			$data['nav_type'] = $this->request->post['nav_type'];
		} elseif (!empty($module_info)) {
			$data['nav_type'] = $module_info['nav_type'];
		} else {
			$data['nav_type'] = 0;
		}
		
		if (isset($this->request->post['show_pro_large'])) {
			$data['show_pro_large'] = $this->request->post['show_pro_large'];
		} elseif (!empty($module_info)) {
			$data['show_pro_large'] = $module_info['show_pro_large'];
		} else {
			$data['show_pro_large'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		
		
		//load languages
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('module/boss_featured', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_featured')) {
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
		
		return !$this->error;
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

}
?>