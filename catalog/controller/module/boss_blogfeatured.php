<?php
class ControllerModuleBossBlogfeatured extends Controller {
	public function index($setting) {
		$this->load->model('bossblog/article'); 
		if(!$this->model_bossblog_article->checkModule('bossblog')){
			return;
		}
		$this->document->addScript('catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js');
		$this->language->load('module/boss_blogfeatured');
		static $module = 0;
		$data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['text_read_more'] = $this->language->get('text_read_more');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_by'] = $this->language->get('text_by');
		
		$data['use_slider'] = $setting['useslider'];	
		
		
		$this->load->model('tool/image');			

		if (!isset($setting['limit']) || empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		if (!isset($setting['limit_article']) || empty($setting['limit_article'])) {
			$setting['limit_article'] = 30;
		}
		if (!isset($setting['limit_des']) || empty($setting['limit_des'])) {
			$setting['limit_des'] = 50;
		}
		$data['articles'] = array();
		$filter_blog = $setting['filter_blog'];
		$results = array();
		switch($filter_blog)
		{
		case "popular":
			$results = $this->model_bossblog_article->getArticlesPopular($setting['limit']);
			break;
		
		case "latest":
			$data_sort = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
			);
			$results = $this->model_bossblog_article->getArticles($data_sort);
			break;
		case "category":				
			if(isset($setting['filter_type_category']) && $setting['filter_type_category'] !=''){				
				$data_sort = array(
				'filter_category_id' => $setting['filter_type_category'],
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $setting['limit']
				);
				$results = $this->model_bossblog_article->getArticles($data_sort);
			}				
			break;
		case "article":		
			$articles = $setting['article'];
			foreach ($articles as $article) {
				if(isset($article) && $article != ''){
					$results[] = $this->model_bossblog_article->getArticle($article);
				}
			}					
			break;
		}					
		foreach ($results as $result) {				
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
			$this->load->model('bossblog/comment');
			 
			$data['articles'][] = array(
				'article_id' => $result['blog_article_id'],
				'thumb'   	 => $image,
				'content' => utf8_substr(strip_tags(html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8')), 0, $setting['limit_des']),
				'name'    	 => utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, $setting['limit_article']),
				'comment'     => $this->model_bossblog_comment->getTotalCommentsByArticleId($result['blog_article_id']),
				'date_added' => $result['date_added'],
				'author'     => $result['author'],
				'href'    	 => $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id'])
			);				
		}		
		
		$data['module'] = $module++; 
		
		
			return $this->load->view('module/boss_blogfeatured', $data);
		
	}
}
?>