<?php 
class ControllerBossblogBossblog extends Controller {  
	private $error = array();
    
	public function index() { 
	   
       $this->load->language('bossblog/bossblog');
       
       $this->load->model('bossblog/article');
		
	   $this->load->model('tool/image');
	   
		if(!$this->model_bossblog_article->checkModule('bossblog')){
			$this->response->redirect($this->url->link('error/not_found'));
		}
	   //$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
	   
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
        	    	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$data['breadcrumbs'] = array();		

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
        
        $data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/bossblog'),			
			'separator' => $this->language->get('text_separator')
		);
               
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
        $data['text_display'] = $this->language->get('text_display');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_grid'] = $this->language->get('text_grid');
		$data['text_postby'] = $this->language->get('text_postby');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_readmore'] = $this->language->get('text_readmore');
        
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
            'sort'               => $sort,
            'order'              => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
        
        $article_total = $this->model_bossblog_article->getTotalBossblogArticles($data_sort);
        
        $results = $this->model_bossblog_article->getArticles($data_sort);
        
		$this->load->model('bossblog/comment');
        foreach ($results as $result) {
			if ($result['image']) { 
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_bossblog_image_category_width'), $this->config->get('config_bossblog_image_category_height'));
			} else {
				$image = false;
			}			
			$data['articles'][] = array(
				'blog_article_id'  => $result['blog_article_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
                'comment'     => $this->model_bossblog_comment->getTotalCommentsByArticleId($result['blog_article_id']),
                'date_modified'        => $result['date_modified'],
				'title' => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),
				'author'      => $result['author'],
				'href'        => $this->url->link('bossblog/article', $url . '&blog_article_id=' . $result['blog_article_id'])
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
				'href'  => $this->url->link('bossblog/bossblog', '&sort=ba.sort_order&order=ASC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'bad.name-ASC',
				'href'  => $this->url->link('bossblog/bossblog', '&sort=bad.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'bad.name-DESC',
				'href'  => $this->url->link('bossblog/bossblog','&sort=bad.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'ba.date_added-ASC',
				'href'  => $this->url->link('bossblog/bossblog','&sort=ba.date_added&order=ASC' . $url)
			); 

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'ba.date_added-DESC',
				'href'  => $this->url->link('bossblog/bossblog', '&sort=ba.date_added&order=DESC' . $url)
			); 
			
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_desc'),
					'value' => 'comment-DESC',
					'href'  => $this->url->link('bossblog/bossblog', '&sort=comment&order=DESC' . $url)
				); 
				
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_asc'),
					'value' => 'comment-ASC',
					'href'  => $this->url->link('bossblog/bossblog', '&sort=comment&order=ASC' . $url)
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
					'href'  => $this->url->link('bossblog/bossblog', $url . '&limit=' . $value)
					
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
        
        $pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		//$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bossblog/bossblog', $url . '&page={page}');
         
			
		$data['pagination'] = $pagination->render();
        $data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
		
		
        $data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;         
            
        /*************RSS FEED***************/ 
        $link_rss = $this->url->link('bossblog/blogrss');
        $data['link_rss'] = $link_rss;
        $data_sort = array(
            'sort'  => $sort,
            'order' => $order,
			'start' => ($page - 1) * 100,
			'limit' => 100
        );
        $results = $this->model_bossblog_article->getArticles($data_sort);
        $rss = isset($this->request->get["rss"]) ? $this->request->get["rss"] : "";
        if ($rss=="bossblog") {    
            $output = "<?xml version='1.0' encoding='UTF-8' ?>";
            $output .= "<rss version='2.0'>";
            $output .= "<channel>";
            $output .= '<title>' .'Boss Blog'. '</title>';
            $output .= '<description>' . 'Blog is a good instrument for everybody to get closer to each other, and so does your business. It keeps you acknowledge of what clients are thinking about your products, and service. Moreover, your sales program, such as promotion, store news, upcoming products and other news come much easier and friendlier. This extension also brings you a win-win situation. Customers have better products and services as your responses, and you gain more and more potential clients through word of mouth' . '</description>';
            $output .= '<link>' . HTTP_SERVER . '</link>';
            foreach ($results as $result) {
                $title = $result["name"];
                $link = HTTP_SERVER . "?route=bossblog/bossblog";
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
              echo "$output";die();
              
        }
                           
        /************* END RSS FEED***************/       
	   
       	   
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		
			$this->response->setOutput($this->load->view('bossblog/bossblog', $data));
		
  	}
}
?>