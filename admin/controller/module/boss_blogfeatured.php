<?php
class ControllerModuleBossBlogfeatured extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/boss_blogfeatured');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');
		$this->load->model('bossblog/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_blogfeatured', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_popular_article'] = $this->language->get('text_popular_article');
		$data['text_latest_article'] = $this->language->get('text_latest_article');
		$data['text_category_article'] = $this->language->get('text_category_article');
		$data['text_choose_article'] = $this->language->get('text_choose_article');
		$data['text_get_article'] = $this->language->get('text_get_article');
		
		$data['entry_article'] = $this->language->get('entry_article');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_limit_article'] = $this->language->get('entry_limit_article');
		$data['entry_limit_des'] = $this->language->get('entry_limit_des');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_use_slider'] = $this->language->get('entry_use_slider');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

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
		if (isset($this->error['limit'])) {
			$data['error_limit'] = $this->error['limit'];
		} else {
			$data['error_limit'] = '';
		}
		if (isset($this->error['limit_article'])) {
			$data['error_limit_article'] = $this->error['limit_article'];
		} else {
			$data['error_limit_article'] = '';
		}
		if (isset($this->error['limit_des'])) {
			$data['error_limit_des'] = $this->error['limit_des'];
		} else {
			$data['error_limit_des'] = '';
		}
		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = '';
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
			'href'      => $this->url->link('module/boss_blogfeatured', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_blogfeatured', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_blogfeatured', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
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
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info['limit'])) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}
		if (isset($this->request->post['limit_article'])) {
			$data['limit_article'] = $this->request->post['limit_article'];
		} elseif (!empty($module_info['limit_article'])) {
			$data['limit_article'] = $module_info['limit_article'];
		} else {
			$data['limit_article'] = 30;
		}
		if (isset($this->request->post['limit_des'])) {
			$data['limit_des'] = $this->request->post['limit_des'];
		} elseif (!empty($module_info['limit_des'])) {
			$data['limit_des'] = $module_info['limit_des'];
		} else {
			$data['limit_des'] = 50;
		}
				
		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (!empty($module_info['image_width'])) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = 200;
		}	
			
		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (!empty($module_info['image_height'])) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = 200;
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
		
		if (isset($this->request->post['useslider'])) {
			$data['useslider'] = $this->request->post['useslider'];
		} elseif (!empty($module_info)) {
			$data['useslider'] = $module_info['useslider'];
		} else {
			$data['useslider'] = 0;
		}
		if (isset($this->request->post['filter_blog'])) {
			$data['filter_blog'] = $this->request->post['filter_blog'];
		} elseif (!empty($module_info)) {
			$data['filter_blog'] = $module_info['filter_blog'];
		} else {
			$data['filter_blog'] = '';
		}
		
		$data['articles'] = array();
		
		$this->load->model('bossblog/articles');
		
		if (isset($this->request->post['article'])) {
			$articles = $this->request->post['article'];
		} elseif (!empty($module_info['article'])) {
			$articles = $module_info['article'];
		} else {
			$articles = array();
		}	
		
		if(!empty($articles)){
			foreach ($articles as $article_id) {
				$articles_info = $this->model_bossblog_articles->getArticle($article_id);

				if ($articles_info) {
					$data['articles'][] = array(
						'articles_id' => $articles_info['blog_article_id'],
						'name'       => $articles_info['name']
					);
				}
			}
		}
		
		if (isset($this->request->post['filter_type_category'])) {
			$data['filter_type_category'] = $this->request->post['filter_type_category'];
		} elseif (!empty($module_info['filter_type_category'])) {
			$data['filter_type_category'] = $module_info['filter_type_category'];
		} else {
			$data['filter_type_category'] = '';
		}
		
		$results = $this->model_bossblog_category->getCategories(0);

		foreach ($results as $result) {						
			$data['categories'][] = array(
				'blog_category_id' => $result['blog_category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				
			);
		}
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();	
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_blogfeatured', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/featured')) {
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
		if (!$this->request->post['limit']) {
			$this->error['limit'] = $this->language->get('error_limit');
		}
		if (!$this->request->post['limit_article']) {
			$this->error['limit_article'] = $this->language->get('error_limit_article');
		}
		if (!$this->request->post['limit_des']) {
			$this->error['limit_des'] = $this->language->get('error_limit_des');
		}
		if (isset($this->request->post['filter_blog']) && $this->request->post['filter_blog'] == 'category' && !isset($this->request->post['filter_type_category'])) {
			$this->error['category'] = $this->language->get('error_category');
		}
		return !$this->error;	
	}
	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('bossblog/articles');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			$limit = 20;				

			$data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_bossblog_articles->getArticles($data);

			foreach ($results as $result) {
				
				$json[] = array(
					'article_id' => $result['blog_article_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	
}
?>