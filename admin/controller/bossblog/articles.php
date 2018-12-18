<?php 
class ControllerBossblogArticles extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('bossblog/articles');
        
        $this->load->model('bossblog/articles');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
        
        //$this->document->addStyle('view/stylesheet/bossthemes/bossblog.css');
        
        $this->getList();
  	}
  
  	public function insert() {
    	$this->load->language('bossblog/articles');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('bossblog/articles');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
    	   
			$this->model_bossblog_articles->addArticle($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
						
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, true));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('bossblog/articles');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/articles');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_articles->editArticle($this->request->get['blog_article_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, true));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('bossblog/articles');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/articles');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_bossblog_articles->deleteArticle($article_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, true));
		}

    	$this->getList();
  	}
	
  	private function getList() {				
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'bad.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		/*  New Boss Blog */
         $data['heading_title'] = $this->language->get('heading_title');
         $data['text_boss_catalog'] = $this->language->get('text_boss_catalog');   
         $data['text_boss_category'] = $this->language->get('text_boss_category'); 
         $data['text_boss_articles'] = $this->language->get('text_boss_articles'); 
         $data['text_boss_comments'] = $this->language->get('text_boss_comments');   
         $data['text_boss_settings'] = $this->language->get('text_boss_settings'); 
         $data['text_confirm'] = $this->language->get('text_confirm'); 
         $data['button_rebuild'] = $this->language->get('button_rebuild');  
         $data['button_edit'] = $this->language->get('button_edit');  
         
         $data['boss_category'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);
         $data['boss_articles'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'], true);
         $data['boss_comments'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], true);
         $data['boss_settings'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
        /* End New Boss Blog */
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
			'href'      => $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, true),       		
      		'separator' => ' :: '
   		);
		
		$data['insert'] = $this->url->link('bossblog/articles/insert', 'token=' . $this->session->data['token'] . $url, true);	
		$data['delete'] = $this->url->link('bossblog/articles/delete', 'token=' . $this->session->data['token'] . $url, true);
    	$data['repair'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, true);
		$data['articles'] = array();

		$data_sort = array(
			'filter_name'	  => $filter_name, 
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		
		$this->load->model('tool/image');
        
        $this->load->model('bossblog/articles');
		
		$article_total = $this->model_bossblog_articles->getTotalArticles($data_sort);
			
		$results = $this->model_bossblog_articles->getArticles($data_sort);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('bossblog/articles/update', 'token=' . $this->session->data['token'] . '&blog_article_id=' . $result['blog_article_id'] . $url, true)
			);
			
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
	
      		$data['articles'][] = array(
				'blog_article_id' => $result['blog_article_id'],
				'name'       => $result['name'],
				'date_added'      => $result['date_added'],
				'date_modified'      => $result['date_modified'],
				'image'      => $image,
				'sort_order'   => $result['sort_order'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['blog_article_id'], $this->request->post['selected']),
				'action'     => $action,
				'edit'       => $this->url->link('bossblog/articles/update', 'token=' . $this->session->data['token'] . '&blog_article_id=' . $result['blog_article_id'], true)
			);
    	}
		
		$data['heading_title'] = $this->language->get('heading_title');		
				
		$data['text_inherited'] = $this->language->get('text_inherited');	
        $data['text_enabled'] = $this->language->get('text_enabled');		
		$data['text_disabled'] = $this->language->get('text_disabled');		
		$data['text_no_results'] = $this->language->get('text_no_results');		
		$data['text_image_manager'] = $this->language->get('text_image_manager');		
			
		$data['column_image'] = $this->language->get('column_image');		
		$data['column_name'] = $this->language->get('column_name');		
		$data['column_date_added'] = $this->language->get('column_date_added');		
		$data['column_sort_oder'] = $this->language->get('column_sort_oder');		
		$data['column_date_modified'] = $this->language->get('column_date_modified');		
		$data['column_status'] = $this->language->get('column_status');		
		$data['column_action'] = $this->language->get('column_action');		
				
		$data['button_copy'] = $this->language->get('button_copy');		
		$data['button_add'] = $this->language->get('button_add');		
		$data['button_delete'] = $this->language->get('button_delete');		
		$data['button_filter'] = $this->language->get('button_filter');
		  
		 
 		$data['token'] = $this->session->data['token'];
		
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
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$data['sort_name'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=bad.name' . $url, true);
		$data['sort_date_added'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=ba.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=ba.date_modified' . $url, true);
		$data['sort_sort_order'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=ba.sort_order' . $url, true);
		$data['sort_status'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_model'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
		$data['sort_status'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');		
		$pagination->url = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
		$data['pagination'] = $pagination->render();
		$data['text_pagination'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($article_total - $this->config->get('config_limit_admin'))) ? $article_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $article_total, ceil($article_total / $this->config->get('config_limit_admin')));
	
		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;
		
		$data['sort'] = $sort;
		$data['order'] = $order;

		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/articles_list', $data));
  	}

  	private function getForm() {
  	 
        
        //$this->document->addStyle('view/stylesheet/bossthemes/bossblog.css');
        
        /*  New Boss Blog */
         $data['heading_title'] = $this->language->get('heading_title');
         $data['text_boss_catalog'] = $this->language->get('text_boss_catalog');   
         $data['text_boss_category'] = $this->language->get('text_boss_category'); 
         $data['text_boss_articles'] = $this->language->get('text_boss_articles'); 
         $data['text_boss_comments'] = $this->language->get('text_boss_comments');   
         $data['text_boss_settings'] = $this->language->get('text_boss_settings');  
		 $data['help_keyword'] = $this->language->get('help_keyword');
		 $data['text_add_blog_article'] = $this->language->get('text_add_blog_article');
		 $data['text_add_blog_article'] = !isset($this->request->get['blog_article_id']) ? $this->language->get('text_add_blog_article') : $this->language->get('text_edit_blog_article');
         
         $data['boss_category'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);
         $data['boss_articles'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'], true);
         $data['boss_comments'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], true);
         $data['boss_settings'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
        /* End New Boss Blog */
        
    	$data['heading_title'] = $this->language->get('heading_title');
 
    	$data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_inherited'] = $this->language->get('text_inherited');	
    	$data['text_disabled'] = $this->language->get('text_disabled');
    	$data['text_none'] = $this->language->get('text_none');
    	$data['text_yes'] = $this->language->get('text_yes');
    	$data['text_no'] = $this->language->get('text_no');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
        $data['entry_author'] = $this->language->get('entry_author');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_article_intro'] = $this->language->get('entry_article_intro');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_content'] = $this->language->get('entry_content');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
        $data['entry_date_available'] = $this->language->get('entry_date_available');
    	$data['entry_image'] = $this->language->get('entry_image');
        $data['entry_allow_comment'] = $this->language->get('entry_allow_comment');
        $data['entry_need_approval'] = $this->language->get('entry_need_approval');
    	$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_related'] = $this->language->get('entry_related');
        $data['entry_related_product'] = $this->language->get('entry_related_product');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_date_modified'] = $this->language->get('entry_date_modified');
				
    	$data['button_save'] = $this->language->get('button_save');
    	$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_image'] = $this->language->get('button_add_image');
		$data['button_remove'] = $this->language->get('button_remove');

    	$data['tab_general'] = $this->language->get('tab_general');
    	$data['tab_data'] = $this->language->get('tab_data');
        $data['tab_meta'] = $this->language->get('tab_meta');
        $data['tab_related'] = $this->language->get('tab_related');
        $data['tab_related_product'] = $this->language->get('tab_related_product');
		$data['tab_design'] = $this->language->get('tab_design');
		 
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
        
        if (isset($this->error['date_modified'])) {
			$data['date_modified'] = $this->error['date_modified'];
		} else {
			$data['date_modified'] = '';
		}

   		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}		
     	
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
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
			'href'      => $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, true),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['blog_article_id'])) {
			$data['action'] = $this->url->link('bossblog/articles/insert', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('bossblog/articles/update', 'token=' . $this->session->data['token'] . '&blog_article_id=' . $this->request->get['blog_article_id'] . $url, true);
		}
		
		$data['cancel'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, true);
		
		if (isset($this->request->get['blog_article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$article_info = $this->model_bossblog_articles->getArticle($this->request->get['blog_article_id']);
    	}

		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['article_description'])) {
			$data['article_description'] = $this->request->post['article_description'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$data['article_description'] = $this->model_bossblog_articles->getArticleDescriptions($this->request->get['blog_article_id']);
		} else {
			$data['article_description'] = array();
		}
        
       if (isset($this->request->post['date_modified'])) {
       		$data['date_modified'] = $this->request->post['date_modified'];
		} elseif (!empty($article_info)) {
			if($article_info['date_modified']!=''){
				$data['date_modified'] = date('Y-m-d', strtotime($article_info['date_modified']));
			}else{
				$data['date_modified'] = date('Y-m-d', time());
			}
		} else {
			$data['date_modified'] = date('Y-m-d', time() - 86400);
		}	
		
		if (isset($this->request->post['author'])) {
      		$data['author'] = $this->request->post['author'];
    	} elseif (!empty($article_info)) {
			$data['author'] = $article_info['author'];
		} else {
      		$data['author'] = '';
    	}

		$this->load->model('setting/store');
		
		$data['article_stores'] = $this->model_setting_store->getStores();
		$data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['article_store'])) {
			$data['article_store'] = $this->request->post['article_store'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$data['article_store'] = $this->model_bossblog_articles->getArticleStores($this->request->get['blog_article_id']);
		} else {
			$data['article_store'] = array(0);
		}	
        
       	if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($article_info)) {
			$data['keyword'] = $article_info['keyword'];
		} else {
			$data['keyword'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($article_info)) {
			$data['image'] = $article_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($article_info) && is_file(DIR_IMAGE . $article_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($article_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['sort_order'])) {
      		$data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($article_info)) {
      		$data['sort_order'] = $article_info['sort_order'];
    	} else {
			$data['sort_order'] = 0;
		}

        
        if (isset($this->request->post['allow_comment'])) {
      		$data['allow_comment'] = $this->request->post['allow_comment'];
    	} elseif (!empty($article_info)) {
			$data['allow_comment'] = $article_info['allow_comment'];
		} else {
      		$data['allow_comment'] = 2;
    	}
        
        if (isset($this->request->post['need_approval'])) {
      		$data['need_approval'] = $this->request->post['need_approval'];
    	} elseif (!empty($article_info)) {
			$data['need_approval'] = $article_info['need_approval'];
		} else {
      		$data['need_approval'] = 2;
    	}
				
    	if (isset($this->request->post['status'])) {
      		$data['status'] = $this->request->post['status'];
    	} elseif (!empty($article_info)) {
			$data['status'] = $article_info['status'];
		} else {
      		$data['status'] = 1;
    	}
        
		$this->load->model('bossblog/category');
				
		$data['article_categories'] = $this->model_bossblog_category->getCategories(0);
		
		if (isset($this->request->post['article_category'])) {
			$data['article_category'] = $this->request->post['article_category'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$data['article_category'] = $this->model_bossblog_articles->getArticleCategories($this->request->get['blog_article_id']);
		} else {
			$data['article_category'] = array();
		}		
		
		if (isset($this->request->post['article_related'])) { 
			$articles = $this->request->post['article_related'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$articles = $this->model_bossblog_articles->getArticleRelated($this->request->get['blog_article_id']);
		} else { 
			$articles = array();
		}
		
		$data['article_relateds'] = array();
		
		foreach ($articles as $article_id) {
			$related_info = $this->model_bossblog_articles->getArticle($article_id);
			
			if ($related_info) {
				$data['article_relateds'][] = array(
					'blog_article_id' => $related_info['blog_article_id'],
					'name'       => $related_info['name']
				);
			}
		}
       
        if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['blog_article_id'])) {		
			$products = $this->model_bossblog_articles->getBlogProductRelated($this->request->get['blog_article_id']);
		} else {
			$products = array();
		}
		$this->load->model('catalog/product');
        
        $data['product_relateds'] = array();
		
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}
        
		if (isset($this->request->post['article_layout'])) {
			$data['article_layout'] = $this->request->post['article_layout'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$data['article_layout'] = $this->model_bossblog_articles->getArticleLayouts($this->request->get['blog_article_id']);
		} else {
			$data['article_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
										
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/articles_form', $data));
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'bossblog/articles')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['article_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
    	if ((utf8_strlen($this->request->post['author']) < 1) || (utf8_strlen($this->request->post['author']) > 64)) {
      		$this->error['author'] = $this->language->get('error_author');
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
    	if (!$this->user->hasPermission('modify', 'bossblog/articles')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
    
    public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('bossblog/articles');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
			} else {
				$filter_category_id = '';
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$filter_sub_category = $this->request->get['filter_sub_category'];
			} else {
				$filter_sub_category = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'         => $filter_name,
				'filter_category_id'  => $filter_category_id,
				'filter_sub_category' => $filter_sub_category,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_bossblog_articles->getArticles($data);
			
			foreach ($results as $result) {	
				$json[] = array(
					'blog_article_id' => $result['blog_article_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
    
    public function productauto() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
				
			$data = array(
				'filter_name'         => $filter_name,
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			
			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);					
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
}
?>