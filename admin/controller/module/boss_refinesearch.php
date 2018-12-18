<?php
class ControllerModuleBossRefinesearch extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/boss_refinesearch');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('catalog/filter');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_refinesearch', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['add_link'] =  $this->url->link('catalog/boss_refinesearch_setting', 'token=' . $this->session->data['token'], true);
		$data['setting_link'] =  $this->url->link('module/boss_refinesearch', 'token=' . $this->session->data['token'], true);
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/boss_refinesearch', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('module/boss_refinesearch', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['boss_refinesearch_module'])) {
			$data['module'] = $this->request->post['boss_refinesearch_module'];
		} else {
			$data['module'] = $this->config->get('boss_refinesearch_module');
		}
		
		
		if (isset($this->request->post['boss_refinesearch_status'])) {
			$data['boss_refinesearch_status'] = $this->request->post['boss_refinesearch_status'];
		} else {
			$data['boss_refinesearch_status'] = $this->config->get('boss_refinesearch_status');
		}

		$data['filters'] = array();
		$filter_data = array(
			'sort'  => 'fg.sort_order',
			'order' => 'ASC',			
		);
		
		$filter_total = $this->model_catalog_filter->getTotalFilterGroups();

		$results = $this->model_catalog_filter->getFilterGroups($filter_data);

		foreach ($results as $result) {
			$data['filters'][] = array(
				'filter_group_id' => $result['filter_group_id'],
				'name'            => $result['name'],
				'sort_order'      => $result['sort_order'],				
			);
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_refinesearch', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_refinesearch')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$boss_refinesearch_module = $this->request->post['boss_refinesearch_module'];
		
		if (isset($boss_refinesearch_module)) { 			
			if (!$boss_refinesearch_module['width']) { 
				$this->error['width'] = $this->language->get('error_width');
			}
			if (!$boss_refinesearch_module['height']) { 
				$this->error['height'] = $this->language->get('error_height');
			}
			if (!$boss_refinesearch_module['image_width']) { 
				$this->error['image_width'] = $this->language->get('error_image_width');
			}
			if (!$boss_refinesearch_module['height']) { 
				$this->error['image_height'] = $this->language->get('error_image_height');
			}
		}
		return !$this->error;
	}
	public function install() {
        $this->load->model('catalog/boss_refinesearch');
		$this->load->model('user/user_group');
		
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/boss_refinesearch_setting');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/boss_refinesearch_setting');
        $this->model_catalog_boss_refinesearch->createdb();        
 	}
        
    public function uninstall() {        
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "filter_image`");
    }
}