<?php
class ControllerModuleBlogTagCloud extends Controller {
	private $error = array();
    
	public function index() {
		$this->load->language('module/blogtagcloud');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
				
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('blogtagcloud', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_normal'] = $this->language->get('text_normal');
		$data['text_bold'] = $this->language->get('text_bold');
		$data['text_limit'] = $this->language->get('text_limit');
		$data['text_module_settings'] = $this->language->get('text_module_settings');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_yes'] = $this->language->get('entry_yes'); 
		$data['entry_no']	= $this->language->get('entry_no');
		
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_min_font_size'] = $this->language->get('entry_min_font_size');
		$data['entry_max_font_size'] = $this->language->get('entry_max_font_size');
		$data['entry_font_weight'] = $this->language->get('entry_font_weight');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['limit'])) {
			$data['error_limit'] = $this->error['limit'];
		} else {
			$data['error_limit'] = '';
		}
		if (isset($this->error['min_font_size'])) {
			$data['error_min_font_size'] = $this->error['min_font_size'];
		} else {
			$data['error_min_font_size'] = '';
		}
		if (isset($this->error['max_font_size'])) {
			$data['error_max_font_size'] = $this->error['max_font_size'];
		} else {
			$data['error_max_font_size'] = '';
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
		
   		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/blogtagcloud', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/blogtagcloud', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/blogtagcloud', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
   		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
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
        
        $data['font_weights'] = array();
			
		$data['font_weights'][] = array(
			'font_weight' => 'normal',
			'title'    => $this->language->get('text_normal')
		);

		$data['font_weights'][] = array(
			'font_weight' => 'bold',
			'title'    => $this->language->get('text_bold')
		);
		
		
        //module
		$data['modules'] = array();
		
		if (isset($this->request->post['blogtagcloud_module'])) {
			$data['modules'] = $this->request->post['blogtagcloud_module'];
		} elseif (!empty($module_info)) { 
			$data['modules'] = $module_info['blogtagcloud_module'];
		}else{
			$data['modules'] = array();
		}			
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/blogtagcloud', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/blogtagcloud')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		$boss_blogrecentpost = isset($this->request->post['blogtagcloud_module'])?$this->request->post['blogtagcloud_module']:'';
		
		if ($boss_blogrecentpost) { 			
			if (!$boss_blogrecentpost['limit']) { 
				$this->error['limit'] = $this->language->get('error_limit');
			}
			if (!$boss_blogrecentpost['min_font_size']) { 
				$this->error['min_font_size'] = $this->language->get('error_min_font_size');
			}
			if (!$boss_blogrecentpost['max_font_size']) { 
				$this->error['max_font_size'] = $this->language->get('error_max_font_size');
			}			
		}
		return !$this->error;	
	}
    
    
}
?>
