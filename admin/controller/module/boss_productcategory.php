<?php
class ControllerModuleBossProductCategory extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/boss_productcategory');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_productcategory', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_subproduct'] = $this->language->get('text_subproduct');
		$data['text_subcategory'] = $this->language->get('text_subcategory');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_clear'] = $this->language->get('text_clear');		
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_add_menu'] = $this->language->get('button_add_menu');
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
			'href'      => $this->url->link('module/boss_productcategory', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);
		
		$data['token'] = $this->session->data['token'];

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_productcategory', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_productcategory', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (isset($module_info['name'])) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($module_info['status'])) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (isset($module_info['title'])) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = array();
		}
		
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (isset($module_info['type'])) {
			$data['type'] = $module_info['type'];
		} else {
			$data['type'] = array();
		}
		
		if (isset($this->request->post['bgimage'])) {
			$data['bgimage'] = $this->request->post['bgimage'];
		} elseif (isset($module_info['bgimage'])) {
			$data['bgimage'] = $module_info['bgimage'];
		} else {
			$data['bgimage'] = '';
		}
		
		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (isset($module_info['image_width'])) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = 210;
		}
		
		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (isset($module_info['image_height'])) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = 210;
		}
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info['limit'])) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 6;
		}
		
		$this->load->model('tool/image');
		
		if (isset($data['bgimage']) && $data['bgimage']) {
			$data['thumbbgimage'] = $this->model_tool_image->resize($data['bgimage'], 100, 100);
		}
		
		if (isset($this->request->post['boss_productcategory_config'])) {
			$menus = $this->request->post['boss_productcategory_config'];
		} elseif (isset($module_info['boss_productcategory_config'])) {
			$menus = $module_info['boss_productcategory_config'];
		}else{
			$menus = array();
		}
		
		
		$data['menus'] = array();

		foreach ($menus as $key => $menu) {
			if (isset($menu['icon']) && file_exists(DIR_IMAGE . $menu['icon'])) {
				$icon = $this->model_tool_image->resize($menu['icon'], 50, 50);
			} else {
				$icon = $this->model_tool_image->resize('no_image.jpg', 50, 50);
			}

			if (isset($menu['bgimage']) && file_exists(DIR_IMAGE . $menu['bgimage'])) {
				$bgimage = $this->model_tool_image->resize($menu['bgimage'], 100, 100);
			} else {
				$bgimage = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			}	

			$data['menus'][] = array(
				'key' => $key,
				'title' => $menu['title'],
				'thumbicon'      => $icon,
				'icon'      => $menu['icon'],
				'category_id'      => $menu['category_id'],
				'per_row'      => $menu['per_row'],
				'status'   => $menu['status'],
				'sort_order'     => $menu['sort_order']
			);	
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);
		$data['bgplaceholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$this->load->model('catalog/category');
		
		$data['categories'] = array();
		
		$results = $this->model_catalog_category->getCategories(0);

		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name']
			);
		}	

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('module/boss_productcategory', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_productcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>