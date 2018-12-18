<?php
class ControllerCatalogBossTestimonialSetting extends Controller {
        private $error = array();
        private $_name = 'testimonial';
        public function index() { 
    	$this->load->language('catalog/boss_testimonial');
        
    	$this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('catalog/boss_testimonial');
        $this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		 
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);
            
            
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('catalog/boss_testimonial_setting', 'token=' . $this->session->data['token'], true));
		}
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
    	$data['heading_title'] = $this->language->get('heading_title_setting');
        
        $data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['module_settings_path'] = $this->url->link('catalog/boss_testimonial_setting', 'token=' . $this->session->data['token'], true);	
		$data['text_module_settings'] = $this->language->get('text_module_settings');
		$data['module_testimonial_path'] = $this->url->link('catalog/boss_testimonial', 'token=' . $this->session->data['token'] , true);	
		$data['text_module_testimonial'] = $this->language->get('text_module_testimonial');
        
        //button
        $data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        
        $data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');       
        //entry
        $data['entry_admin_approved'] = $this->language->get('entry_admin_approved');
        $data['entry_default_rating'] = $this->language->get('entry_default_rating');
        $data['entry_good'] = $this->language->get('entry_good');
        $data['entry_bad'] = $this->language->get('entry_bad');
        $data['entry_random'] = $this->language->get('entry_random');
        $data['entry_all_page_limit'] = $this->language->get('entry_all_page_limit');
        

		if (isset($this->error['all_page_limit'])) {
			$data['error_all_page_limit'] = $this->error['all_page_limit'];
		} else {
			$data['error_all_page_limit'] = '';
		}
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('catalog/boss_testimonial_setting', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('heading_title_setting'),
			'separator' => ' :: '
		);
        
                
        if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
        
        $data['action'] = $this->url->link('catalog/boss_testimonial_setting', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('catalog/boss_testimonial', 'token=' . $this->session->data['token'], true);
		
	
		if (isset($this->request->post['testimonial_admin_approved'])) {
			$data['testimonial_admin_approved'] = $this->request->post['testimonial_admin_approved'];
		} else {
			$data['testimonial_admin_approved'] = $this->config->get('testimonial_admin_approved');
		}
        
        if (isset($this->request->post['testimonial_default_rating'])) {
			$data['testimonial_default_rating'] = $this->request->post['testimonial_default_rating'];
		} else {
			$data['testimonial_default_rating'] = $this->config->get('testimonial_default_rating');
		}	
						
		if (isset($this->request->post['testimonial_random'])) {
			$data['testimonial_random'] = $this->request->post['testimonial_random'];
		} else {
			$data['testimonial_random'] = $this->config->get('testimonial_random');
		}
        	
		if (isset($this->request->post['testimonial_all_page_limit'])) {
			$data['testimonial_all_page_limit'] = $this->request->post['testimonial_all_page_limit'];
		} else {
			$data['testimonial_all_page_limit'] = $this->config->get('testimonial_all_page_limit');
		}
        
        
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/boss_testimonial_setting', $data));
  	}
          
    private function validate() {
		if (!$this->user->hasPermission('modify', 'catalog/boss_testimonial_setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['testimonial_all_page_limit']) {
			$this->error['all_page_limit'] = $this->language->get('error_all_page_limit');
		}	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
    
}
?>