<?php
class ControllerModuleBossFaceComments extends Controller {
	private $error = array();
	
	public function index() {   
		$this->load->language('module/boss_facecomments');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_facecomments', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
				
		$data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->version;
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_light'] = $this->language->get('text_light');
		$data['text_dark'] = $this->language->get('text_dark');
		$data['text_social'] = $this->language->get('text_social');
		$data['text_reverse_time'] = $this->language->get('text_reverse_time');
		$data['text_time'] = $this->language->get('text_time');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_app_id'] = $this->language->get('entry_app_id');
		$data['entry_color_scheme'] = $this->language->get('entry_color_scheme');
		$data['entry_num_posts'] = $this->language->get('entry_num_posts');
		$data['entry_order_by'] = $this->language->get('entry_order_by');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['help_app_id'] = $this->language->get('help_app_id');
		$data['help_color_scheme'] = $this->language->get('help_color_scheme');
		$data['help_num_posts'] = $this->language->get('help_num_posts');
		$data['help_order_by'] = $this->language->get('help_order_by');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['app_id'])) {
			$data['error_app_id'] = $this->error['app_id'];
		} else {
			$data['error_app_id'] = '';
		}	

		if (isset($this->error['app_id'])) {
			$data['error_app_id'] = $this->error['app_id'];
		} else {
			$data['error_app_id'] = '';
		}

		if (isset($this->error['num_posts'])) {
			$data['error_num_posts'] = $this->error['num_posts'];
		} else {
			$data['error_num_posts'] = '';
		}
        
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true)
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_facecomments', 'token=' . $this->session->data['token'], true)
   		);
		
		$data['action'] = $this->url->link('module/boss_facecomments', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		$data['boss_facecomments'] = array();
		
		if (isset($this->request->post['boss_facecomments'])) {
			$data['boss_facecomments'] = $this->request->post['boss_facecomments'];
		} else {
			$data['boss_facecomments'] = $this->config->get('boss_facecomments');
		}
		
		if (!empty($data['boss_facecomments'])) {
			$data['status'] = $data['boss_facecomments']['status'];
			$data['app_id'] = $data['boss_facecomments']['app_id'];
			$data['color_scheme'] = $data['boss_facecomments']['color_scheme'];
			$data['num_posts'] = $data['boss_facecomments']['num_posts'];
			$data['order_by'] = $data['boss_facecomments']['order_by'];
		}else{
			$data['status'] = 1;
			$data['app_id'] = '1679538022274729';
			$data['color_scheme'] = 'light';
			$data['num_posts'] = 5;
			$data['order_by'] = 'reverse_time';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_facecomments', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_facecomments')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['boss_facecomments']) && !empty($this->request->post['boss_facecomments'])) {
			$boss_facecomments = $this->request->post['boss_facecomments'];
			if (utf8_strlen($boss_facecomments['app_id']) < 3) {
			$this->error['app_id'] = $this->language->get('error_app_id');
			}

			if (utf8_strlen($boss_facecomments['num_posts']) < 1 || !is_numeric($boss_facecomments['num_posts']) || $boss_facecomments['num_posts'] < 1 ) {
				$this->error['num_posts'] = $this->language->get('error_num_posts');
			}
		}
		
		return !$this->error;	
	}	
}