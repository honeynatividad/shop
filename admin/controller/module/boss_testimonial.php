<?php
class ControllerModuleBossTestimonial extends Controller {
	private $error = array(); 
	private $_name = 'testimonial';
	public function index() {   
		$this->load->language('module/boss_testimonial');

		$this->document->SetTitle( $this->language->get('heading_title'));

		$data['testimonial_version'] = "2.0 (OpenCart 2.0.x.x)";
		
		$this->load->model('extension/module');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {					
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_testimonial', $this->request->post);				
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_bedwords'] = $this->language->get('entry_bedwords');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['text_required_field'] = $this->language->get('text_required_field');
		$data['text_help'] = $this->language->get('text_help');
				
		$data['text_edit_testimonials'] = $this->language->get('text_edit_testimonials');
		

		$data['tab_module'] = $this->language->get('tab_module');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_left'] = $this->language->get('text_left');
		$data['text_right'] = $this->language->get('text_right');
		
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_character_limit'] = $this->language->get('entry_character_limit');
		

		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['entry_badwords'] = $this->language->get('entry_badwords');
		$data['entry_blockedip'] = $this->language->get('entry_blockedip');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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
		
		if (isset($this->error['limit_character'])) {
			$data['error_limit_character'] = $this->error['limit_character'];
		} else {
			$data['error_limit_character'] = '';
		}
		$data['token'] = $this->session->data['token'];

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
		
   		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/boss_testimonial', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_testimonial', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_testimonial', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		$data['edit_testimonials_path'] = $this->url->link('catalog/boss_testimonial', 'token=' . $this->session->data['token'], true);
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
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		//module
		$data['modules'] = array();
		
		if (isset($this->request->post['boss_testimonial_module'])) {
			$data['modules'] = $this->request->post['boss_testimonial_module'];
		} elseif (!empty($module_info)) { 
			$data['modules'] = $module_info['boss_testimonial_module'];
		}else{
			$data['modules'] = array();
		}	
		
		//print_r($this->config->get('config_bossblog_limit'));
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_testimonial', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_testimonial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		$boss_testimonial = $this->request->post['boss_testimonial_module'];
		
		if (isset($boss_testimonial)) { 			
			if (!$boss_testimonial['limit']) { 
				$this->error['limit'] = $this->language->get('error_limit');
			}
			
			if (!$boss_testimonial['limit_character']) { 
				$this->error['limit_character'] = $this->language->get('error_limit_character');
			}
		}
		return !$this->error;	
	}


	public function install() { 
		$this->load->model('catalog/boss_testimonial');
		$this->load->model('user/user_group');
		
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/boss_testimonial');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/boss_testimonial');
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/boss_testimonial_setting');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/boss_testimonial_setting');
		
		$data = array(
            
            'testimonial_admin_approved'                  =>1,
			'testimonial_default_rating'             =>3,
			'testimonial_all_page_limit'             =>20,
			                   
        );
        
        $this->load->model('setting/setting');        
        $this->model_setting_setting->editSetting($this->_name, $data);
		$this->model_catalog_boss_testimonial->createDatabaseTables();
	}

	public function uninstall() {
		$this->load->model('catalog/boss_testimonial');
		$this->model_catalog_boss_testimonial->dropDatabaseTables();
	}
}
?>