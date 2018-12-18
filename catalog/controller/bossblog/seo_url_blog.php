<?php
class ControllerBossblogSeoUrlBlog extends Controller {
	public function index() {
			// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
			
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					
					if ($url[0] == 'blog_article_id') {
						$this->request->get['blog_article_id'] = $url[1];
					}
					
					if ($url[0] == 'blog_category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}	
					
				} else {
					$this->request->get['route'] = 'error/not_found';	
				}
			}
			
			if (isset($this->request->get['blog_article_id'])) {
				$this->request->get['route'] = 'bossblog/article';
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'bossblog/blogcategory';
			}elseif (isset($this->request->get['filter_tag'])) {
				$this->request->get['route'] = 'bossblog/blogsearch';
			} else {
			 $this->request->get['route'] = 'bossblog/bossblog';
			}	
			if (isset($this->request->get['route'])) {				
				return new Action($this->request->get['route']);
			}
		}
	}
	
	public function rewrite($link) {
		if ($this->config->get('config_seo_url')) {
			$url_data = parse_url(str_replace('&amp;', '&', $link));
		
			$url = ''; 
			
			$data = array();
            if(stripos( $link,'index.php')) {
                parse_str($url_data['query'], $data);
            }
        
			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					if ($data['route'] == 'bossblog/article' && $key == 'blog_article_id') {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
							
							unset($data[$key]);
						}else{
						  $url .= '/index.php?route=bossblog/bossblog&blog_article_id=' . $value;
				            unset($data[$key]);
						}
                        					
					} if (($data['route'] == 'bossblog/bossblog'&& $value='bossblog/bossblog')  || ($data['route'] == 'bossblog/blogsearch'&& $value='bossblog/blogsearch')) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'bossblog'");
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
							unset($data[$key]);
						}					
					}
                    
                   
                    
                    elseif ($key == 'path') {
						$categories = explode('_', $value);
						
						foreach ($categories as $category) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'blog_category_id=" . (int)$category . "'");
					
							if ($query->num_rows) {
								$url .= '/' . $query->row['keyword'];
							}							
						}
						
						unset($data[$key]);
					}
				}
			}
			if ($url) {
				unset($data['route']);
			
				$query = '';
			
				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . $key . '=' . $value;
					}
					
					if ($query) {
						$query = '?' . trim($query, '&');
					}
				}

				return $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query;
			} else {
				return $link;
			}
		} else {
			return $link;
		}		
	}	
}
?>