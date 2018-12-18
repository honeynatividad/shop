<?php
class ControllerModuleBlogRecentComment extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		$this->load->model('bossblog/article');
		$this->load->language('module/blogrecentcomment');
        $data['text_comment'] = $this->language->get('text_comment');
        if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css')){
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/bossblog.css');
		}
		
		$results = array();
		$results_data = $this->model_bossblog_article->getRecentCommentArticles($setting['limit']);
		$data['heading_title'] = isset($setting['title'][$this->config->get('config_language_id')])?$setting['title'][$this->config->get('config_language_id')]:'';
		$data['articles'] = array();
		foreach ($results_data as $dt) {
			$author = $dt['author'];
			$comment = mb_substr(strip_tags(html_entity_decode($dt['text'], ENT_QUOTES, 'UTF-8')), 0, 50) . '...';
            $date_added = $dt['date_added'];
			$result = $this->model_bossblog_article->getArticle($dt['blog_article_id']);	
			$data['articles'][] = array(
				'blog_article_id' => $result['blog_article_id'],
				'name'    	 => $result['name'],
                'author'     => $author,
                'comment'    => $comment,
                'date_added' => $date_added,
				'href'    	 => $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id']),
			);
		}

		
		
			return $this->load->view('module/blogrecentcomment', $data);
		
	}
}
?>