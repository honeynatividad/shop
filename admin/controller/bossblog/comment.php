<?php
class ControllerBossblogComment extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('bossblog/comment');
        
        $this->load->model('bossblog/comment');

		$this->document->setTitle($this->language->get('heading_title'));
        
        //$this->document->addStyle('view/stylesheet/bossthemes/bossblog.css');
        
        $this->getList();
	} 

	public function insert() {
		$this->load->language('bossblog/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_comment->addComment($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->response->redirect($this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('bossblog/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_comment->editComment($this->request->get['blog_comment_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->response->redirect($this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() { 
		$this->load->language('bossblog/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/comment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_comment_id) {
				$this->model_bossblog_comment->deleteComment($blog_comment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
		}
		$this->response->redirect($this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, true));
		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'bc.date_added';
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
			'href'      => $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
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
		$data['insert'] = $this->url->link('bossblog/comment/insert', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('bossblog/comment/delete', 'token=' . $this->session->data['token'] . $url, true);	
		$data['repair'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token']. $url, true);
		$data['comments'] = array();

		$data_sort = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
        
        $this->load->model('bossblog/comment');
		
		$comment_total = $this->model_bossblog_comment->getTotalComments();
	
		$results = $this->model_bossblog_comment->getComments($data_sort);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('bossblog/comment/update', 'token=' . $this->session->data['token'] . '&blog_comment_id=' . $result['blog_comment_id'] . $url, true)
			);
						
			$data['comments'][] = array(
				'blog_comment_id'  => $result['blog_comment_id'],
				'name'       => $result['name'],
				'author'     => $result['author'],
                'text' => utf8_substr(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 0, 50) . '..',
				'email'     => $result['email'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['review_id'], $this->request->post['selected']),
				'action'     => $action,
				'edit'        => $this->url->link('bossblog/comment/update', 'token=' . $this->session->data['token'] . '&blog_comment_id=' . $result['blog_comment_id'] , true),
			);
		}	
	
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_article'] = $this->language->get('column_article');
		$data['column_author'] = $this->language->get('column_author');
		$data['column_email'] = $this->language->get('column_email');
        $data['column_comment'] = $this->language->get('column_comment');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_article'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bad.name' . $url, true);
		$data['sort_author'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.author' . $url, true);
		$data['sort_email'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.email' . $url, true);
		$data['sort_status'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.status' . $url, true);
		$data['sort_date_added'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.date_added' . $url, true);
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');		
		$pagination->url = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
				
		$data['pagination'] = $pagination->render();
		$data['text_pagination'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($comment_total - $this->config->get('config_limit_admin'))) ? $comment_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $comment_total, ceil($comment_total / $this->config->get('config_limit_admin')));
		
		$data['sort'] = $sort;
		$data['order'] = $order;

				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/comment_list', $data));
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
		 $data['text_add_blog_comment'] = !isset($this->request->get['blog_comment_id']) ? $this->language->get('text_add_blog_comment') : $this->language->get('text_edit_blog_comment');
         
		 
         $data['boss_category'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], true);
         $data['boss_articles'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'], true);
         $data['boss_comments'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], true);
         $data['boss_settings'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], true);
        /* End New Boss Blog */
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_select'] = $this->language->get('text_select');

		$data['entry_article'] = $this->language->get('entry_article');
		$data['entry_author'] = $this->language->get('entry_author');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_comment'] = $this->language->get('entry_comment');
		//$data['entry_good'] = $this->language->get('entry_good');
		//$data['entry_bad'] = $this->language->get('entry_bad');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
 		
		if (isset($this->error['article'])) {
			$data['error_article'] = $this->error['article'];
		} else {
			$data['error_article'] = '';
		}
		
 		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}
		
 		if (isset($this->error['text'])) {
			$data['error_text'] = $this->error['text'];
		} else {
			$data['error_text'] = '';
		}
		
 		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		$url = '';
			
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
			'href'      => $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, true),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['blog_comment_id'])) { 
			$data['action'] = $this->url->link('bossblog/comment/insert', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('bossblog/comment/update', 'token=' . $this->session->data['token'] . '&blog_comment_id=' . $this->request->get['blog_comment_id'] . $url, true);
		}
		
		$data['cancel'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['blog_comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$comment_info = $this->model_bossblog_comment->getComment($this->request->get['blog_comment_id']);
		}
		
		$data['token'] = $this->session->data['token'];
			
		$this->load->model('bossblog/articles');
		
		if (isset($this->request->post['blog_article_id'])) {
			$data['blog_article_id'] = $this->request->post['blog_article_id'];
		} elseif (!empty($comment_info)) {
			$data['blog_article_id'] = $comment_info['blog_article_id'];
		} else {
			$data['blog_article_id'] = '';
		}

		if (isset($this->request->post['article'])) {
			$data['article'] = $this->request->post['article'];
		} elseif (!empty($comment_info)) {
			$data['article'] = $comment_info['article'];
		} else {
			$data['article'] = '';
		}
				
		if (isset($this->request->post['author'])) {
			$data['author'] = $this->request->post['author'];
		} elseif (!empty($comment_info)) {
			$data['author'] = $comment_info['author'];
		} else {
			$data['author'] = '';
		}

		if (isset($this->request->post['text'])) {
			$data['text'] = $this->request->post['text'];
		} elseif (!empty($comment_info)) {
			$data['text'] = $comment_info['text'];
		} else {
			$data['text'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($comment_info)) {
			$data['email'] = $comment_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($comment_info)) {
			$data['status'] = $comment_info['status'];
		} else {
			$data['status'] = '';
		}

			
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('bossblog/comment_form', $data));
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'bossblog/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['blog_article_id']) {
			$this->error['article'] = $this->language->get('error_article');
		}
		
		if ((utf8_strlen($this->request->post['author']) < 3) || (utf8_strlen($this->request->post['author']) > 64)) {
			$this->error['author'] = $this->language->get('error_author');
		}

		if (utf8_strlen($this->request->post['text']) < 1) {
			$this->error['text'] = $this->language->get('error_text');
		}
        
		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'bossblog/comment')) {
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