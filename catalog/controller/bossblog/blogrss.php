<?php  
class ControllerBossblogBlogrss extends Controller {
	public function index() {
		$this->load->language('bossblog/blogrss');
		$this->load->model('bossblog/article');
		
		if(!$this->model_bossblog_article->checkModule('bossblog')){
			$this->response->redirect($this->url->link('error/not_found'));
		}
		
    	$data['heading_title'] = $this->language->get('heading_title');    	
    	$data['text_rss_blog_categories'] = $this->language->get('text_rss_blog_categories');
        
        if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css')){
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/bossblog.css');
		}
		
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$data['blog_category_id'] = $parts[0];
		} else {
			$data['blog_category_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}
		
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);
        
        $data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_blogrss'),
			'href'      => $this->url->link('bossblog/blogrss'),
       		'separator' => $this->language->get('text_separator')
   		);	
		
		$this->load->model('bossblog/blogcategory');

		$this->load->model('bossblog/article');

		$data['categories'] = array();

		$categories = $this->model_bossblog_blogcategory->getBlogCategories(0);

		foreach ($categories as $category) {
			$total = $this->model_bossblog_article->getTotalArticles(array('filter_category_id'  => $category['blog_category_id']));

			$children_data = array();

			$children = $this->model_bossblog_blogcategory->getBlogCategories($category['blog_category_id']);

			foreach ($children as $child) {
				$data_sort = array(
					'filter_category_id'  => $child['blog_category_id'],
					'filter_sub_category' => true
				);

				$children_data[] = array(
					'blog_category_id' => $child['blog_category_id'],
					'name'        => $child['name'],
					'href'        => $this->url->link('bossblog/blogcategory&rss=blogcategory', 'path=' . $category['blog_category_id'] . '_' . $child['blog_category_id'])	
				);		
			}

			$data['categories'][] = array(
				'blog_category_id' => $category['blog_category_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('bossblog/blogcategory&rss=blogcategory', 'path=' . $category['blog_category_id'])
			);	
		}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		
			$this->response->setOutput($this->load->view('bossblog/blogrss', $data));
		
  	}

}
?>