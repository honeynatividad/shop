<?php 
class ControllerBossblogBlogcategory extends Controller {  
	public function index() { 
		$this->load->language('bossblog/blogcategory');
		
		$this->load->model('bossblog/blogcategory');
		
		$this->load->model('bossblog/article');
		
		$this->load->model('tool/image'); 
		
		if(!$this->model_bossblog_article->checkModule('bossblog')){
			$this->response->redirect($this->url->link('error/not_found'));
		}
		
		$data['button_continue'] = $this->language->get('button_continue');
		if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css')){
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/bossblog.css');
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ba.sort_order';
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
        
        if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_bossblog_limit');
		}
					
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);
        
        $data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_bossblog'),
			'href'      => $this->url->link('bossblog/bossblog'),
       		'separator' => $this->language->get('text_separator')
   		);	
			
		if (isset($this->request->get['path'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['path']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}
									
				$blogcategory_info = $this->model_bossblog_blogcategory->getBlogCategory($path_id);
				
				if ($blogcategory_info) {
	       			$data['breadcrumbs'][] = array(
   	    				'text'      => $blogcategory_info['name'],
						'href'      => $this->url->link('bossblog/blogcategory', 'path=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$blog_category_id = (int)array_pop($parts);
            
		} else {
			$blog_category_id = 0;
		}
                
		$blogcategory_info = $this->model_bossblog_blogcategory->getBlogCategory($blog_category_id);
	
		if ($blogcategory_info) {
	  		$this->document->setTitle($blogcategory_info['name']);
			$this->document->setDescription($blogcategory_info['meta_description']);
			$this->document->setKeywords($blogcategory_info['meta_keyword']);
			
			$data['heading_title'] = $blogcategory_info['name'];
			
			$data['text_empty'] = $this->language->get('text_empty');
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_limit'] = $this->language->get('text_limit');
            $data['text_sub_category'] = $this->language->get('text_sub_category');
            $data['text_display'] = $this->language->get('text_display');
            $data['text_list'] = $this->language->get('text_list');
            $data['text_grid'] = $this->language->get('text_grid');
			$data['text_postby'] = $this->language->get('text_postby');
            $data['text_comment'] = $this->language->get('text_comment');
			$data['text_readmore'] = $this->language->get('text_readmore');
					
			if ($blogcategory_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($blogcategory_info['image'], $this->config->get('config_bossblog_image_article_width'), $this->config->get('config_bossblog_image_article_height'));
			} else {
				$data['thumb'] = '';
			}
									
			$data['description'] = html_entity_decode($blogcategory_info['description'], ENT_QUOTES, 'UTF-8');
            
            $url = '';
								
			$data['blogcategories'] = array();
			
			$results = $this->model_bossblog_blogcategory->getBlogCategories($blog_category_id);
			
			foreach ($results as $result) {
				$data_sort = array(
					'filter_category_id'  => $result['blog_category_id'],
					'filter_sub_category' => true
				);
				
				$article_total = $this->model_bossblog_article->getTotalArticles($data_sort);				
				
				$data['blogcategories'][] = array(
					'name'  => $result['name'] . ($this->config->get('config_article_count') ? ' (' . $article_total . ')' : ''),
					'href'  => $this->url->link('bossblog/blogcategory', 'path=' . $this->request->get['path'] . '_' . $result['blog_category_id'] . $url)
				);
			}
            
			$url = '';
			
    		if (isset($this->request->get['sort'])) {
    		  $url .= '&sort=' . $this->request->get['sort'];
    		}	
    
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
    			}	
    			
            if (isset($this->request->get['limit'])) {
    				$url .= '&limit=' . $this->request->get['limit'];
    			}
            
            $data['articles'] = array();
            
            $data_sort = array(
                'filter_category_id' => $blog_category_id, 
                'sort'               => $sort,
                'order'              => $order,
    			'start' => ($page - 1) * $limit,
    			'limit' => $limit
    		);
					
			$article_total = $this->model_bossblog_article->getTotalArticles($data_sort); 
			
			$results = $this->model_bossblog_article->getArticles($data_sort);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_bossblog_image_category_width'), $this->config->get('config_bossblog_image_category_height'));
				} else {
					$image = false;
				}
                
                $this->load->model('bossblog/comment');
								
				$data['articles'][] = array(
					'blog_article_id'  => $result['blog_article_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
                    'date_modified'       => $result['date_modified'],
                    'comment'     => $this->model_bossblog_comment->getTotalCommentsByArticleId($result['blog_article_id']),
                    'author'          => $result['author'],
                    'title' => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')) . '..',
					'href'        => $this->url->link('bossblog/article','path=' . $this->request->get['path'] . '&blog_article_id=' . $result['blog_article_id'])
				);
			}
            
           $url = '';
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
							
			$data['sorts'] = array();
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'ba.sort_order-ASC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=ba.sort_order&order=ASC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'bad.name-ASC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=bad.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'bad.name-DESC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=bad.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'ba.date_added-ASC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=ba.date_added&order=ASC' . $url)
			); 

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'ba.date_added-DESC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=ba.date_added&order=DESC' . $url)
			); 
			
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_desc'),
					'value' => 'comment-DESC',
					'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=comment&order=DESC' . $url)
				); 
				
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_asc'),
					'value' => 'comment-ASC',
					'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=comment&order=ASC' . $url)
				);
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
						
			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_bossblog_limit'), 10, 15, 20, 30));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . $url . '&limit='. $value)
					
				);
			}
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			} 
            
                        
            /*************RSS FEED***************/ 
            
            $link_rss=$this->url->link('bossblog/blogcategory', 'path=' . $this->request->get['path']. '&rss=blogcategory');
            
            $data['link_rss'] = $link_rss;
            
            $rss = isset($this->request->get["rss"]) ? $this->request->get["rss"] : "";
            if ($rss=="blogcategory") {    
                $output = "<?xml version='1.0' encoding='UTF-8' ?>";
                $output .= "<rss version='2.0'>";
                $output .= "<channel>";
                $output .= '<title>' . $blogcategory_info['name'] . '</title>';
                $output .= '<description>' . html_entity_decode($blogcategory_info['description'], ENT_QUOTES, 'UTF-8') . '</description>';
                $output .= '<link>' . HTTP_SERVER . '</link>';
                foreach ($results as $result) {
                    $title = $result["name"];
                    $link = HTTP_SERVER . "?route=bossblog/article&blog_article_id=$result[blog_article_id]";
                    $image_url = $image;
                    $description = "";
                      $output .= "<item>";
                      $output .= '<title>' . $result['name'] . '</title>';
                      $output .= '<description>' . $result['title'] . '</description>';
                      $output .= '<link>' . $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id']) . '</link>';
                      $output .= "<pubDate>" . date("D, d M Y H:i:s O", strtotime($result["date_modified"])) . "</pubDate>";
                      $output .= "</item>";
                  }
                  $output .= "</channel>";
                  $output .= "</rss>";
        
                  header("Content-Type: application/rss+xml");
                  echo "$output"; die();
              
              } 
                       
            /************* END RSS FEED***************/
					
			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			
			$pagination->url = $this->url->link('bossblog/blogcategory', 'path=' . $this->request->get['path'] . $url . '&page={page}');
		
			$data['pagination'] = $pagination->render();
            $data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
            $data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			
				$this->response->setOutput($this->load->view('bossblog/blogcategory', $data));
			
    	} else {
			$url = '';
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('bossblog/blogcategory', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_theme') . '/template/error/not_found')) {
				$this->template = $this->config->get('config_theme') . '/template/error/not_found';
			} else {
				$this->template = 'error/not_found';
			}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			
				$this->response->setOutput($this->load->view('error/not_found', $data));
			
		}
  	}
}
?>