<?php 
class ControllerBossblogBlogSearch extends Controller { 	
	public function index() { 
    	$this->load->language('bossblog/blogsearch');
		
		$this->load->model('bossblog/blogcategory');
		
		$this->load->model('bossblog/article');
		
		$this->load->model('tool/image'); 
		
			
		if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css')){
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/bossblog.css');
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		} 
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} elseif (isset($this->request->get['filter_name'])) {
			$filter_tag = $this->request->get['filter_name'];
		} else {
			$filter_tag = '';
		} 
				
		if (isset($this->request->get['filter_content'])) {
			$filter_content = $this->request->get['filter_content'];
		} else {
			$filter_content = '';
		} 
        
        if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		} 

		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
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
			$limit = 5;//$this->config->get('config_bossblog_limit');
		}
		
		if (isset($this->request->get['filter_name'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['filter_name']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
        
        $data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_blog'),
			'href'      => $this->url->link('bossblog/bossblog'),
       		'separator' => $this->language->get('text_separator')
   		);
		
		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
		}
				
		if (isset($this->request->get['filter_content'])) {
			$url .= '&filter_content=' . $this->request->get['filter_content'];
		}
				
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		
		if (isset($this->request->get['filter_sub_category'])) {
			$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
		}
						
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('article/search', $url),
      		'separator' => $this->language->get('text_separator')
   		);
		
		if (isset($this->request->get['filter_name'])) {
    		$data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['filter_name'];
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}
		
		$data['text_empty'] = $this->language->get('text_empty');
    	$data['text_critea'] = $this->language->get('text_critea');
    	$data['text_search'] = $this->language->get('text_search');
		$data['text_keyword'] = $this->language->get('text_keyword');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_sub_category'] = $this->language->get('text_sub_category');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_display'] = $this->language->get('text_display');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_grid'] = $this->language->get('text_grid');		
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
		$data['text_postby'] = $this->language->get('text_postby');
        $data['text_comments'] = $this->language->get('text_comments');
        $data['text_readmore'] = $this->language->get('text_readmore');
		
		$data['entry_search'] = $this->language->get('entry_search');
    	$data['entry_description'] = $this->language->get('entry_description');
		  
    	$data['button_search'] = $this->language->get('button_search');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		//$data['compare'] = $this->url->link('article/compare');
		
		$this->load->model('bossblog/blogcategory');
        $this->load->model('bossblog/comment');
		
		// 3 Level Category Search
		$data['categories'] = array();
					
		$categories_1 = $this->model_bossblog_blogcategory->getBlogCategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_bossblog_blogcategory->getBlogCategories($category_1['blog_category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_bossblog_blogcategory->getBlogCategories($category_2['blog_category_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'blog_category_id' => $category_3['blog_category_id'],
						'name'        => $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'blog_category_id' => $category_2['blog_category_id'],	
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);					
			}
			
			$data['categories'][] = array(
				'blog_category_id' => $category_1['blog_category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}
		
		$data['articles'] = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
			$data_sort = array(
				'filter_name'         => $filter_name, 
				'filter_tag'          => $filter_tag, 
				'filter_content'      => $filter_content,
				'filter_category_id'  => $filter_category_id, 
				'filter_sub_category' => $filter_sub_category, 
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);
			
			$article_total = $this->model_bossblog_article->getTotalArticles($data_sort);
								
			$results = $this->model_bossblog_article->getArticles($data_sort);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_bossblog_image_article_width'), $this->config->get('config_bossblog_image_article_height'));
				} else {
					$image = false;
				}
			
				$data['articles'][] = array(
					'blog_article_id'  => $result['blog_article_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
                    'date_modified'        => $result['date_modified'],
                    'author'        => $result['author'],
                    'comment'     => $this->model_bossblog_comment->getTotalCommentsByArticleId($result['blog_article_id']),
					'title' => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),
					'href'        => $this->url->link('bossblog/article', $url . '&blog_article_id=' . $result['blog_article_id'])
				);
			}
			
			$data['sorts'] = array();
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'ba.sort_order-ASC',
				'href'  => $this->url->link('bossblog/blogsearch','&sort=ba.sort_order&order=ASC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'bad.name-ASC',
				'href'  => $this->url->link('bossblog/blogsearch','&sort=bad.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'bad.name-DESC',
				'href'  => $this->url->link('bossblog/blogsearch','&sort=bad.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'ba.date_added-ASC',
				'href'  => $this->url->link('bossblog/blogsearch','&sort=ba.date_added&order=ASC' . $url)
			); 

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'ba.date_added-DESC',
				'href'  => $this->url->link('bossblog/blogsearch','&sort=ba.date_added&order=DESC' . $url)
			); 
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_comment_desc'),
				'value' => 'comment-DESC',
				'href'  => $this->url->link('bossblog/blogsearch','&sort=comment&order=DESC' . $url)
			); 
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_comment_asc'),
				'value' => 'comment-ASC',
				'href'  => $this->url->link('bossblog/blogsearch','&sort=comment&order=ASC' . $url)
			);
			
			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_bossblog_limit'), 10, 15, 20, 30));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('bossblog/blogsearch', $url . '&limit='. $value)
					
				);
			}
					
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}
					
			if (isset($this->request->get['filter_content'])) {
				$url .= '&filter_content=' . $this->request->get['filter_content'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
			}
			
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
			
			$pagination->url = $this->url->link('bossblog/blogsearch', $url . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
		}
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;
		
		$data['filter_name'] = $filter_name;
		$data['filter_content'] = $filter_content;
		$data['filter_category_id'] = $filter_category_id;
		$data['filter_sub_category'] = $filter_sub_category;

			
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		
			$this->response->setOutput($this->load->view('bossblog/blogsearch', $data));
		
  	}
}
?>