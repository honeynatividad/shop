<?php  
class ControllerBossblogArticle extends Controller {
	private $error = array(); 
	
	public function index() { 
		$this->load->model('bossblog/article');
		if(!$this->model_bossblog_article->checkModule('bossblog')){
			$this->response->redirect($this->url->link('error/not_found'));
		}
       	if (!$this->customer->isLogged()) {
	  		$data['login'] = 0;
    	} else{
			$data['login'] = 1;
            $data['email']=$this->customer->getEmail();
            $data['username']=$this->customer->getFirstName().' '.$this->customer->getLastName();
    	}
       
       $this->language->load('bossblog/article');
       $this->language->load('product/product');
	    $this->load->model('tool/image');
	   if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css')){
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/bossblog.css');
		}
       
   		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
        
        $data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_bossblog'),
			'href'      => $this->url->link('bossblog/bossblog'),			
			'separator' => $this->language->get('text_separator')
		);
        
        
       $this->load->model('bossblog/blogcategory');
       
       if (isset($this->request->get['path'])) {
			$path = '';
				
			foreach (explode('_', $this->request->get['path']) as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				$category_info = $this->model_bossblog_blogcategory->getBlogCategory($path_id);
				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('bossblog/blogcategory', 'path=' . $path),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		}
        
        $comment_status = $this->config->get('config_bossblog_comment_status');
        
        $approval_status = $this->config->get('config_bossblog_approval_status');
	
        		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
						
			if (isset($this->request->get['filter_content'])) {
				$url .= '&filter_content=' . $this->request->get['filter_content'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}	
						
			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_search'),
				'href'      => $this->url->link('bossblog/blogsearch', $url),
				'separator' => $this->language->get('text_separator')
			); 	
		}
		
		if (isset($this->request->get['blog_article_id'])) {
			$blog_article_id = (int)$this->request->get['blog_article_id'];
		} else {
			$blog_article_id = 0;
		}
		
        $data['capcha']=1;
        
        
		$this->load->model('bossblog/article');
		
		$article_info = $this->model_bossblog_article->getArticle($blog_article_id);
		
		if ($article_info) {
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			
			if (isset($this->request->get['filter_content'])) {
				$url .= '&filter_content=' . $this->request->get['filter_content'];
			}	
						
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
												
			$data['breadcrumbs'][] = array(
				'text'      => $article_info['name'],
				'href'      => $this->url->link('bossblog/article', $url . '&blog_article_id=' . $this->request->get['blog_article_id']),
				'separator' => $this->language->get('text_separator')
			);			
			
			$this->document->setTitle($article_info['name']);
			$this->document->setDescription($article_info['meta_description']);
			$this->document->setKeywords($article_info['meta_keyword']);
			$this->document->addLink($this->url->link('bossblog/article', 'blog_article_id=' . $this->request->get['blog_article_id']), 'canonical');
			
			if ($this->config->get('config_google_captcha_status')) {
				$this->document->addScript('https://www.google.com/recaptcha/api.js');

				$data['site_key'] = $this->config->get('config_google_captcha_public');
			} else {
				$data['site_key'] = '';
			}
			
			if (isset($this->error['captcha'])) {
				$data['error_captcha'] = $this->error['captcha'];
			} else {
				$data['error_captcha'] = '';
			}
			
			$data['heading_title'] = $article_info['name'];
			
			$data['text_select'] = $this->language->get('text_select');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['text_username'] = $this->language->get('text_username');	
			$data['text_email'] = $this->language->get('text_email');
			$data['text_required'] = $this->language->get('text_required');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_write'] = $this->language->get('text_write');
			$data['text_note'] = $this->language->get('text_note');
			$data['text_wait'] = $this->language->get('text_wait');
			$data['text_comment'] = $this->language->get('text_comment');			
            $data['text_postby'] = $this->language->get('text_postby');
            $data['text_comments'] = $this->language->get('text_comments');
            $data['text_readmore'] = $this->language->get('text_readmore');
            $data['text_share'] = $this->language->get('text_share');
            $data['text_prev'] = $this->language->get('text_prev');
            $data['text_next'] = $this->language->get('text_next');
            $data['text_product_related'] = $this->language->get('text_product_related');
            $data['text_article_related'] = $this->language->get('text_article_related');
            $data['text_add_to_wish_list'] = $this->language->get('text_add_to_wish_list');
            $data['text_add_to_compare'] = $this->language->get('text_add_to_compare');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_comment'] = $this->language->get('entry_comment');
			$data['entry_email'] = $this->language->get('entry_email');
	    	$data['entry_comment'] = $this->language->get('entry_comment');
			$data['entry_captcha'] = $this->language->get('entry_captcha');
            $data['view_comment'] = $this->language->get('view_comment');

			$data['button_submit'] = $this->language->get('button_submit');
            $data['button_cart'] = $this->language->get('button_cart');			
			$data['button_upload'] = $this->language->get('button_upload');
			$data['button_continue'] = $this->language->get('button_continue');
            $data['public_key'] = $this->language->get('public_key');
            $data['article_related'] = $this->language->get('article_related');            
			
			$this->load->model('bossblog/comment');
			//echo'<pre>';print_r($article_info);echo'<pre>';die();
			$data['blog_article_id'] = $this->request->get['blog_article_id'];
			$data['date_modified'] = $article_info['date_modified'];
            $data['comment_status'] = $comment_status;
            $data['approval_status'] = $approval_status;
			$data['comments'] = (int)$article_info['comments'];
            $data['allow_comment'] = (int)$article_info['allow_comment'];
            $data['need_approval'] = (int)$article_info['need_approval'];
			$data['content'] = html_entity_decode($article_info['content'], ENT_QUOTES, 'UTF-8');
            $data['title'] = html_entity_decode($article_info['title'], ENT_QUOTES, 'UTF-8');
            $data['thumb'] = $this->model_tool_image->resize($article_info['image'], $this->config->get('config_bossblog_image_article_width'), $this->config->get('config_bossblog_image_article_height'));
            $data['name'] = html_entity_decode($article_info['name'], ENT_QUOTES, 'UTF-8');
            $data['author'] = html_entity_decode($article_info['author'], ENT_QUOTES, 'UTF-8');
            $data['href']  = $this->url->link('bossblog/article', 'blog_article_id=' . $article_info['blog_article_id']);
			
			$data['articles'] = array();
			
			$results = $this->model_bossblog_article->getArticleRelated($this->request->get['blog_article_id']);
            
           	foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_bossblog_image_article_width'), $this->config->get('config_bossblog_image_article_height'));
				} else {
					$image = false;
				}
				
				$data['articles'][] = array(
					'blog_article_id' => $result['blog_article_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
                    'content'    	 => $result['content'],
                    'date_modified'    	 => $result['date_modified'],
					'date_added' =>$result['date_added'],
                    'title'    	 => $result['title'],
					'href'    	 => $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id']),
				);
			}
            
            $this->load->model('catalog/product');
            
            $data['products'] = array();
			
			$results = $this->model_bossblog_article->getBlogProductRelated($this->request->get['blog_article_id']);
			$data['related_width'] = $this->config->get($this->config->get('config_theme').'_image_related_width');
			$data['related_height'] = $this->config->get($this->config->get('confg_theme').'_image_related_height');
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme').'_image_related_width'), $this->config->get($this->config->get('config_theme').'_image_related_height'));
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
							
				$data['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}	
			
			$data['tags'] = array();
			$pos = strrpos($article_info['tag'], ",");	
			if($pos){
				$tags = explode(',', $article_info['tag']);
				
				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('bossblog/blogsearch', 'filter_tag=' . trim($tag))
					);
				}
			}
			
			
			$this->model_bossblog_article->updateViewed($this->request->get['blog_article_id']);
			
						
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			
				$this->response->setOutput($this->load->view('bossblog/article', $data));
			
		} else {
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}	
					
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
							
			if (isset($this->request->get['filter_content'])) {
				$url .= '&filter_content=' . $this->request->get['filter_content'];
			}
					
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
								
      		$data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('bossblog/article', $url . '&blog_article_id=' . $blog_article_id),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

      		$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');
							
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			
				$this->response->setOutput($this->load->view('error/not_found', $data));
			
    	}     
    }
    
    public function comment() {
    	$this->load->language('bossblog/article');
		
		$this->load->model('bossblog/comment');

		$data['text_on'] = $this->language->get('text_on');
		$data['text_no_comments'] = $this->language->get('text_no_comments');
        $data['view_comment'] = $this->language->get('view_comment');
        $data['text_comment_by'] = $this->language->get('text_comment_by');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$data['comments'] = array();
		
		$comment_total = $this->model_bossblog_comment->getTotalCommentsByArticleId($this->request->get['blog_article_id']);
			
		$results = $this->model_bossblog_comment->getCommentsByArticleId($this->request->get['blog_article_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$data['comments'][] = array(
        		'author'     => $result['author'],
				'text'       => $result['text'],
				'email'      => $result['email'],
        		'date_added' => $result['date_added']
        	);
      	}			
			
		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$limit = 5;
		//$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bossblog/article/comment', 'blog_article_id=' . $this->request->get['blog_article_id'] . '&page={page}');
			
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($comment_total - $limit)) ? $comment_total : ((($page - 1) * $limit) + $limit), $comment_total, ceil($comment_total / $limit));
        
		$data['comment_total'] =$comment_total;		
    			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_theme') . '/template/bossblog/comment')) {
			$this->response->setOutput($this->load->view($this->config->get('config_theme') . '/template/bossblog/comment', $data));
		} else {
			$this->response->setOutput($this->load->view('bossblog/comment', $data));
		}
	}
    
    public function write() {
		$this->load->language('bossblog/article');
		
		$this->load->model('bossblog/comment');
        
        $approval_status = $this->request->get['approval_status'];
        $need_approval = $this->request->get['need_approval'];
            if($need_approval!=0){
                if($approval_status==1||$need_approval==1){
                    $status = 0;
                } else {
                    $status = 1;
                }
            } else {
                $status = 1;
            }
        
		$json = array();                 
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            
			if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['comment_content']) < 25) || (utf8_strlen($this->request->post['comment_content']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}
            
            if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		    $json['error'] = $this->language->get('error_email');
	        }
            
            if ($this->config->get('config_google_captcha_status')) {
				$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('config_google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

				$recaptcha = json_decode($recaptcha, true);

				if (!$recaptcha['success']) {
					$json['error'] = $this->language->get('error_captcha');
				}
			}
			
			if (!isset($json['error'])) {
				$this->model_bossblog_comment->addComment($this->request->get['blog_article_id'],$status, $this->request->post);
				if($status==1){
					$json['success'] = $this->language->get('text_success');
                } else {
                    $json['success'] = $this->language->get('text_approval');
                }
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}
    
   
 }
 ?>