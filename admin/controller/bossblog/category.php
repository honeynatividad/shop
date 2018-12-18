<?php 
class ControllerBossblogCategory extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('bossblog/category');
        
        $this->load->model('bossblog/category');

		$this->document->setTitle($this->language->get('heading_title'));
        
        //$this->document->addStyle('view/stylesheet/bossthemes/bossblog.css');
        
        $this->getList();
	}

	public function insert() {
		$this->load->language('bossblog/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true)); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('bossblog/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_category->editCategory($this->request->get['blog_category_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('bossblog/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/category');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_category_id) {
				$this->model_bossblog_category->deleteCategory($blog_category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true));
		}

		$this->getList();
	}

	private function getList() {
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
			'href'      => $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
									
		$data['insert'] = $this->url->link('bossblog/category/insert', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('bossblog/category/delete', 'token=' . $this->session->data['token'], true);
		$data['repair'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);
		/*  New Boss Blog */
         $data['heading_title'] = $this->language->get('heading_title');
         $data['text_boss_catalog'] = $this->language->get('text_boss_catalog');   
         $data['text_boss_category'] = $this->language->get('text_boss_category'); 
         $data['text_boss_articles'] = $this->language->get('text_boss_articles'); 
         $data['text_boss_comments'] = $this->language->get('text_boss_comments');   
         $data['text_boss_settings'] = $this->language->get('text_boss_settings');  
         $data['text_confirm'] = $this->language->get('text_confirm');  
         $data['button_edit'] = $this->language->get('button_edit');  
         $data['button_rebuild'] = $this->language->get('button_rebuild');  
         
         $data['boss_category'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);
         $data['boss_articles'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'], true);
         $data['boss_comments'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], true);
         $data['boss_settings'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
        /* End New Boss Blog */
		
		$data['categories'] = array();
		
		$results = $this->model_bossblog_category->getCategories(0);
		
		foreach ($results as $result) {
			
			$data['categories'][] = array(
				'blog_category_id' => $result['blog_category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'edit'        => $this->url->link('bossblog/category/update', 'token=' . $this->session->data['token'] . '&blog_category_id=' . $result['blog_category_id'] , true),
				'delete'      => $this->url->link('bossblog/category/delete', 'token=' . $this->session->data['token'] . '&blog_category_id=' . $result['blog_category_id'] , true)
			);
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/category_list', $data));
	}

	private function getForm() {
	   
       //$this->document->addStyle('view/stylesheet/bossthemes/bossblog.css');
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');		
		$data['text_enabled'] = $this->language->get('text_enabled');
    	$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');
				
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_image'] = $this->language->get('entry_image');		
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_layout'] = $this->language->get('entry_layout');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

    	$data['tab_general'] = $this->language->get('tab_general');
    	$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');
        
        /*  New Boss Blog */
         $data['heading_title'] = $this->language->get('heading_title');
         $data['text_boss_catalog'] = $this->language->get('text_boss_catalog');   
         $data['text_boss_category'] = $this->language->get('text_boss_category'); 
         $data['text_boss_articles'] = $this->language->get('text_boss_articles'); 
         $data['text_boss_comments'] = $this->language->get('text_boss_comments');   
         $data['text_boss_settings'] = $this->language->get('text_boss_settings');           
		 $data['text_add_blog_category'] = !isset($this->request->get['blog_category_id']) ? $this->language->get('text_add_blog_category') : $this->language->get('text_edit_blog_category');
         $data['help_keyword'] = $this->language->get('help_keyword');  
        
         
         $data['boss_category'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);
         $data['boss_articles'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'], true);
         $data['boss_comments'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], true);
         $data['boss_settings'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
        /* End New Boss Blog */
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
	
 		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
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
			'href'      => $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['blog_category_id'])) {
			$data['action'] = $this->url->link('bossblog/category/insert', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('bossblog/category/update', 'token=' . $this->session->data['token'] . '&blog_category_id=' . $this->request->get['blog_category_id'], true);
		}
		
		$data['cancel'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['blog_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$category_info = $this->model_bossblog_category->getCategory($this->request->get['blog_category_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['blog_category_description'])) {
			$data['blog_category_description'] = $this->request->post['blog_category_description'];
		} elseif (isset($this->request->get['blog_category_id'])) {
			$data['blog_category_description'] = $this->model_bossblog_category->getCategoryDescriptions($this->request->get['blog_category_id']);
		} else {
			$data['blog_category_description'] = array();
		}

		$categories = $this->model_bossblog_category->getCategories(0);

		// Remove own id from list
		if (!empty($category_info)) {
			foreach ($categories as $key => $category) {
				if ($category['blog_category_id'] == $category_info['blog_category_id']) {
					unset($categories[$key]);
				}
			}
		}

		$data['categories'] = $categories;

		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($category_info)) {
			$data['parent_id'] = $category_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}
						
		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['blog_category_store'])) {
			$data['blog_category_store'] = $this->request->post['blog_category_store'];
		} elseif (isset($this->request->get['blog_category_id'])) {
			$data['blog_category_store'] = $this->model_bossblog_category->getCategoryStores($this->request->get['blog_category_id']);
		} else {
			$data['blog_category_store'] = array(0);
		}			
		
		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($category_info)) {
			$data['keyword'] = $category_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$data['image'] = $category_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
				
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = 1;
		}
				
		if (isset($this->request->post['blog_category_layout'])) {
			$data['blog_category_layout'] = $this->request->post['blog_category_layout'];
		} elseif (isset($this->request->get['blog_category_id'])) {
			$data['blog_category_layout'] = $this->model_bossblog_category->getCategoryLayouts($this->request->get['blog_category_id']);
		} else {
			$data['blog_category_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
						
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/category_form', $data));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'bossblog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['blog_category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
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

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'bossblog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}
?>