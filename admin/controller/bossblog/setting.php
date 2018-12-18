<?php
class ControllerBossblogSetting extends Controller {
        private $error = array();
        private $_name = 'config_bossblog';
        public function index() { 
    	$this->load->language('bossblog/setting');
        
        $this->load->model('bossblog/bossblog');
 
    	$this->document->setTitle($this->language->get('heading_title'));
        
        //$this->document->addStyle('view/stylesheet/bossthemes/bossblog.css');
        
       	$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		  
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);
            
            if (isset($this->request->post['config_bossblog_keyword'])) {
                
                $this->model_bossblog_bossblog->editKeyword('bossblog/bossblog',$this->request->post['config_bossblog_keyword']);
    		} 
            
			/*if ($this->config->get('config_currency_auto')) {
				$this->load->model('localisation/currency');
		
				$this->model_localisation_currency->updateCurrencies();
			}*/
            
            	
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true));
		}

    	$data['heading_title'] = $this->language->get('heading_title');
        
        /*  New Boss Blog */
         $data['heading_title'] = $this->language->get('heading_title');
         $data['text_boss_catalog'] = $this->language->get('text_boss_catalog');   
         $data['text_boss_category'] = $this->language->get('text_boss_category'); 
         $data['text_boss_articles'] = $this->language->get('text_boss_articles'); 
         $data['text_boss_comments'] = $this->language->get('text_boss_comments');   
         $data['text_boss_settings'] = $this->language->get('text_boss_settings');  
         
         $data['boss_category'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);
         $data['boss_articles'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'], true);
         $data['boss_comments'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], true);
         $data['boss_settings'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
        /* End New Boss Blog */
        
        //text
        $data['text_items'] = $this->language->get('text_items');
        $data['text_article'] = $this->language->get('text_article');
        $data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
        
		//help
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_bossblog_limit'] = $this->language->get('help_bossblog_limit');
		$data['help_blog_admin_limit'] = $this->language->get('help_blog_admin_limit');
		$data['help_article_count'] = $this->language->get('help_article_count');
		$data['help_comment'] = $this->language->get('help_comment');
		$data['help_approval'] = $this->language->get('help_approval');
		
        //button
        $data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        
        //tab
        $data['tab_general'] = $this->language->get('tab_general');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_image'] = $this->language->get('tab_image');
        
        //entry
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_image_category'] = $this->language->get('entry_image_category');
		$data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$data['entry_image_article'] = $this->language->get('entry_image_article');
		$data['entry_image_title'] = $this->language->get('entry_image_title');
		$data['entry_image_related'] = $this->language->get('entry_image_related');
        $data['entry_bossblog_limit'] = $this->language->get('entry_bossblog_limit');
		$data['entry_blog_admin_limit'] = $this->language->get('entry_blog_admin_limit');
        $data['entry_comment'] = $this->language->get('entry_comment');
        $data['entry_approval'] = $this->language->get('entry_approval');
        $data['entry_article_count'] = $this->language->get('entry_article_count');
        $data['entry_keyword'] = $this->language->get('entry_keyword');

		//$data['text_not_found'] = $this->language->get('text_not_found');
        
        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['blog_name'])) {
			$data['error_blog_name'] = $this->error['blog_name'];
		} else {
			$data['error_blog_name'] = '';
		}
        
        if (isset($this->error['blog_image_category'])) {
			$data['error_blog_image_category'] = $this->error['blog_image_category'];
		} else {
			$data['error_blog_image_category'] = '';
		}
				
 		if (isset($this->error['blog_image_article'])) {
			$data['error_blog_image_article'] = $this->error['blog_image_article'];
		} else {
			$data['error_blog_image_article'] = '';
		}
		
 		if (isset($this->error['blog_image_related'])) {
			$data['error_blog_image_related'] = $this->error['blog_image_related'];
		} else {
			$data['error_blog_image_related'] = '';
        }
        
        if (isset($this->error['bossblog_limit'])) {
			$data['error_bossblog_limit'] = $this->error['bossblog_limit'];
		} else {
			$data['error_bossblog_limit'] = '';
		}
		
		if (isset($this->error['blog_admin_limit'])) {
			$data['error_blog_admin_limit'] = $this->error['blog_admin_limit'];
		} else {
			$data['error_blog_admin_limit'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('module/bossblog', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('heading_bossblog'),
			'separator' => ' :: '
		);
        
        $data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
        
        if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
        
        $data['action'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
		
	//	$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['config_bossblog_name'])) {
			$data['config_bossblog_name'] = $this->request->post['config_bossblog_name'];
		} else {
			$data['config_bossblog_name'] = $this->config->get('config_bossblog_name');
		}
        
        if (isset($this->request->post['config_bossblog_limit'])) {
			$data['config_bossblog_limit'] = $this->request->post['config_bossblog_limit'];
		} else {
			$data['config_bossblog_limit'] = $this->config->get('config_bossblog_limit');
		}	
						
		if (isset($this->request->post['config_bossblog_admin_limit'])) {
			$data['config_bossblog_admin_limit'] = $this->request->post['config_bossblog_admin_limit'];
		} else {
			$data['config_bossblog_admin_limit'] = $this->config->get('config_bossblog_admin_limit');
		}
        	
		if (isset($this->request->post['config_bossblog_comment_status'])) {
			$data['config_bossblog_comment_status'] = $this->request->post['config_bossblog_comment_status'];
		} else {
			$data['config_bossblog_comment_status'] = $this->config->get('config_bossblog_comment_status');
		}
        
        if (isset($this->request->post['config_bossblog_approval_status'])) {
			$data['config_bossblog_approval_status'] = $this->request->post['config_bossblog_approval_status'];
		} else {
			$data['config_bossblog_approval_status'] = $this->config->get('config_bossblog_approval_status');
		}
        
        $keyword = $this->model_bossblog_bossblog->getKeyword('bossblog');
        
        if (isset($this->request->post['config_bossblog_keyword'])) { 
			$data['config_bossblog_keyword'] = $this->request->post['config_bossblog_keyword'];
		} elseif (isset($keyword['keyword'])) { 
			$data['config_bossblog_keyword'] = $keyword['keyword'];
		} else {
			$data['config_bossblog_keyword'] = '';
		}

        $this->load->model('tool/image');
        
        $data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['config_bossblog_image_category_width'])) {
			$data['config_bossblog_image_category_width'] = $this->request->post['config_bossblog_image_category_width'];
		} else {
			$data['config_bossblog_image_category_width'] = $this->config->get('config_bossblog_image_category_width');
		}
		
		if (isset($this->request->post['config_bossblog_image_category_height'])) {
			$data['config_bossblog_image_category_height'] = $this->request->post['config_bossblog_image_category_height'];
		} else {
			$data['config_bossblog_image_category_height'] = $this->config->get('config_bossblog_image_category_height');
		}
        		
		if (isset($this->request->post['config_bossblog_image_article_width'])) {
			$data['config_bossblog_image_article_width'] = $this->request->post['config_bossblog_image_article_width'];
		} else {
			$data['config_bossblog_image_article_width'] = $this->config->get('config_bossblog_image_article_width');
		}
		
		if (isset($this->request->post['config_bossblog_image_article_height'])) {
			$data['config_bossblog_image_article_height'] = $this->request->post['config_bossblog_image_article_height'];
		} else {
			$data['config_bossblog_image_article_height'] = $this->config->get('config_bossblog_image_article_height');
		}
		
		if (isset($this->request->post['config_bossblog_image_title_width'])) {
			$data['config_bossblog_image_title_width'] = $this->request->post['config_bossblog_image_title_width'];
		} else {
			$data['config_bossblog_image_title_width'] = $this->config->get('config_bossblog_image_title_width');
		}
		
		if (isset($this->request->post['config_bossblog_image_title_height'])) {
			$data['config_bossblog_image_title_height'] = $this->request->post['config_bossblog_image_title_height'];
		} else {
			$data['config_bossblog_image_title_height'] = $this->config->get('config_bossblog_image_title_height');
		}
		
		if (isset($this->request->post['config_bossblog_image_related_width'])) {
			$data['config_bossblog_image_related_width'] = $this->request->post['config_bossblog_image_related_width'];
		} else {
			$data['config_bossblog_image_related_width'] = $this->config->get('config_bossblog_image_related_width');
		}
		
		if (isset($this->request->post['config_bossblog_image_related_height'])) {
			$data['config_bossblog_image_related_height'] = $this->request->post['config_bossblog_image_related_height'];
		} else {
			$data['config_bossblog_image_related_height'] = $this->config->get('config_bossblog_image_related_height');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/setting', $data));
  	}
          
    private function validate() {
		if (!$this->request->post['config_bossblog_name']) {
			$this->error['blog_name'] = $this->language->get('error_blog_name');
		}	
	
		if (!$this->request->post['config_bossblog_image_category_height'] || !$this->request->post['config_bossblog_image_category_width']) {
			$this->error['blog_image_category'] = $this->language->get('error_blog_image_category');
		}	
		
		if (!$this->request->post['config_bossblog_image_article_height'] || !$this->request->post['config_bossblog_image_article_width']) {
			$this->error['blog_image_article'] = $this->language->get('error_blog_image_article');
		}			
		
		if (!$this->request->post['config_bossblog_image_title_height'] || !$this->request->post['config_bossblog_image_title_width']) {
			$this->error['blog_image_related'] = $this->language->get('error_blog_image_title');
		}
		
		if (!$this->request->post['config_bossblog_image_related_height'] || !$this->request->post['config_bossblog_image_related_width']) {
			$this->error['blog_image_related'] = $this->language->get('error_blog_image_related');
		}
		
		
		if (!$this->request->post['config_bossblog_admin_limit']) {
			$this->error['blog_admin_limit'] = $this->language->get('error_limit');
		}
		
		if (!$this->request->post['config_bossblog_limit']) {
			$this->error['bossblog_limit'] = $this->language->get('error_limit');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
    
}
?>