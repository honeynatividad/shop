<?php
class ControllerModuleBossMenucategory extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/boss_menucategory');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				//$this->model_extension_module->addModule('boss_menucategory', $this->request->post);
				$this->model_extension_module->addModule('boss_menucategory', $this->request->post);
				$module_id = $this->db->getLastId();
				$data_module = $this->request->post;
				$data_module['module_id'] = $module_id;
				$this->model_extension_module->editModule($module_id, $data_module);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
		$data['module_id'] = isset($this->request->get['module_id'])?$this->request->get['module_id']:'';
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_clear'] = $this->language->get('text_clear');		
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_alway_show'] = $this->language->get('entry_alway_show');
		$data['entry_label_alway_show'] = $this->language->get('entry_label_alway_show');
		$data['entry_fixed'] = $this->language->get('entry_fixed');
		$data['entry_label_fixed'] = $this->language->get('entry_label_fixed');

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
		if (isset($this->error['alway_show'])) {
			$data['error_alway_show'] = $this->error['alway_show'];
		} else {
			$data['error_alway_show'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_menucategory', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);
		
		$data['token'] = $this->session->data['token'];

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_menucategory', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_menucategory', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
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
		
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($module_info)) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = array();
		}
		if (isset($this->request->post['alway_show'])) {
			$data['alway_show'] = $this->request->post['alway_show'];
		} elseif (!empty($module_info['alway_show'])) {
			$data['alway_show'] = $module_info['alway_show'];
		} else {
			$data['alway_show'] = 10;
		}
		
		if (isset($this->request->post['menu_fixed'])) {
			$data['menu_fixed'] = $this->request->post['menu_fixed'];
		} elseif (!empty($module_info['menu_fixed'])) {
			$data['menu_fixed'] = $module_info['menu_fixed'];
		} else {
			$data['menu_fixed'] = 0;
		}
		$menus = array();

		if (isset($this->request->post['boss_menucategory_config'])) {
			$menus = $this->request->post['boss_menucategory_config'];
		} elseif (!empty($module_info)) {
			$menus = $module_info['boss_menucategory_config'];
		}
		
		$this->load->model('tool/image');
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
				'column'     => $menu['column'],
				'sub_width'     => $menu['sub_width'],
				'thumbbgimage'   => $bgimage,
				'bgimage'   => $menu['bgimage'],
				'status'   => $menu['status'],
				'sort_order'     => $menu['sort_order']
			);	
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);

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
		
		$this->response->setOutput($this->load->view('module/boss_menucategory', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_menucategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		if (!$this->request->post['alway_show']) { 
			$this->error['alway_show'] = $this->language->get('error_alway_show');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>