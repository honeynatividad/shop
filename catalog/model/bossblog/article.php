<?php 
class ModelBossblogArticle extends Model {
    
    public function updateViewed($blog_article_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_article SET viewed = (viewed + 1) WHERE blog_article_id = '" . (int)$blog_article_id . "'");
	}
    
    public function getArticle($blog_article_id) {
				
		$query = $this->db->query("SELECT DISTINCT *, bad.name AS name, ba.image, ba.sort_order, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment bc WHERE bc.blog_article_id = ba.blog_article_id AND bc.status = '1' GROUP BY bc.blog_article_id) AS comments FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_store bas ON (ba.blog_article_id = bas.blog_article_id) WHERE ba.blog_article_id = '" . (int)$blog_article_id . "' AND bad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ba.status = '1' AND bas.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return array(
				'blog_article_id'       => $query->row['blog_article_id'],
				'name'             => $query->row['name'],
				'content'      => $query->row['content'],
                'title'      => $query->row['title'],
                'author'      => $query->row['author'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'image'            => $query->row['image'],
				'comments'          => $query->row['comments'],
                'need_approval'          => $query->row['need_approval'],
                'allow_comment'          => $query->row['allow_comment'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}
    
    public function getArticles($data = array()) {
			$sql = "SELECT ba.blog_article_id,(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment bc WHERE bc.blog_article_id = ba.blog_article_id AND bc.status = '1' GROUP BY bc.blog_article_id) AS comment FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_store bas ON (ba.blog_article_id = bas.blog_article_id)"; 
						
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blog_article_category bac ON (ba.blog_article_id = bac.blog_article_id)";			
			}
			
			$sql .= " WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ba.status = '1' AND bas.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {					
					if (!empty($data['filter_content'])) {
						$sql .= "LCASE(bad.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%' OR MATCH(bad.content) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "')";
					} else {
						$sql .= "LCASE(bad.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$sql .= "MATCH(bad.tag) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "')";
				}
			
				$sql .= ")";					
			}
            
            if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_category_id'];
					
					$this->load->model('bossblog/blogcategory');
					
					$categories = $this->model_bossblog_blogcategory->getBlogCategoriesByParentId($data['filter_category_id']);
										
					foreach ($categories as $blog_category_id) {
						$implode_data[] = (int)$blog_category_id;
					}
								
					$sql .= " AND bac.blog_category_id IN (" . implode(', ', $implode_data) . ")";			
				} else {
					$sql .= " AND bac.blog_category_id = '" . (int)$data['filter_category_id'] . "'";
				}
			}
					
			$sql .= " GROUP BY ba.blog_article_id";
            
            	$sort_data = array(
				'bad.name',
                'comment',
				'ba.sort_order',
				'ba.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'bad.name') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY ba.sort_order";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(bad.name) DESC";
			} else {
				$sql .= " ASC, LCASE(bad.name) ASC";
			}
			
            if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 5;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
            
			$article_data = array();
			
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$article_data[$result['blog_article_id']] = $this->getArticle($result['blog_article_id']);
                
			}
		
		return $article_data;
	}
    
    public function getTotalArticles($data = array()) {
			
				
			$sql = "SELECT COUNT(DISTINCT ba.blog_article_id) AS total FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_store bas ON (ba.blog_article_id = bas.blog_article_id)";
	
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blog_article_category bac ON (ba.blog_article_id = bac.blog_article_id)";			
			}
						
			$sql .= " WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ba.status = '1' AND bas.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {					 
				    if (!empty($data['filter_content'])) {
						$sql .= "LCASE(bad.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%' OR MATCH(bad.content) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "')";
					} else {
						$sql .= "LCASE(bad.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$sql .= "MATCH(bad.tag) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "')";
				}
			
				$sql .= ")";				
			}
            
            if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_category_id'];
					
					$this->load->model('bossblog/blogcategory');
					
					$categories = $this->model_bossblog_blogcategory->getBlogCategoriesByParentId($data['filter_category_id']);
										
					foreach ($categories as $blog_category_id) {
						$implode_data[] = (int)$blog_category_id;
					}
								
					$sql .= " AND bac.blog_category_id IN (" . implode(', ', $implode_data) . ")";			
				} else {
					$sql .= " AND bac.blog_category_id = '" . (int)$data['filter_category_id'] . "'";
				}
			}
			
			$query = $this->db->query($sql);
			
			$article_data = $query->row['total']; 
			
		
		return $article_data;
	}
    
    public function getTotalBossblogArticles() {
			
		
		$query = $this->db->query("SELECT COUNT(DISTINCT ba.blog_article_id) AS total FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_store bas ON (ba.blog_article_id = bas.blog_article_id) WHERE ba.status = '1'");
		
		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;	
		}
	}
    
   	public function getArticleRelated($blog_article_id) {
		$article_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_related bar LEFT JOIN " . DB_PREFIX . "blog_article ba ON (bar.related_id = ba.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_store bas ON (ba.blog_article_id = bas.blog_article_id) WHERE bar.blog_article_id = '" . (int)$blog_article_id . "' AND ba.status = '1' AND bas.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		foreach ($query->rows as $result) { 
			$article_data[$result['related_id']] = $this->getArticle($result['related_id']);
		}
		
		return $article_data;
	}
    
    public function getBlogProductRelated($blog_article_id) {
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_product_related bpr LEFT JOIN " . DB_PREFIX . "product p ON (bpr.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "blog_article ba ON (bpr.product_id = ba.blog_article_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE bpr.blog_article_id = '" . (int)$blog_article_id . "' AND p.status = '1' AND p.date_available <= NOW() AND  p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        $this->load->model('catalog/product');
		
        foreach ($query->rows as $result) { 
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}
		
		return $product_data;
	}
    
    public function getRecentCommentArticles($limit) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_comment bc ON (ba.blog_article_id = bc.blog_article_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ba.status = '1' AND bc.status = '1' ORDER BY bc.date_added DESC LIMIT " . (int)$limit);
		
		return $query->rows;
	}
	public function getArticlesRandom($limit) {				
			$sql = "SELECT ba.blog_article_id,(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment bc WHERE bc.blog_article_id = ba.blog_article_id AND bc.status = '1' GROUP BY bc.blog_article_id) AS comment FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_store bas ON (ba.blog_article_id = bas.blog_article_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ba.status = '1' AND bas.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY rand() LIMIT " . (int)$limit; 	
			
			$article_data = array();
					
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$article_data[$result['blog_article_id']] = $this->getArticle($result['blog_article_id']);
                
			}
		
		return $article_data;
	}
	public function getArticlesPopular($limit) {				
			$sql = "SELECT ba.blog_article_id,(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment bc WHERE bc.blog_article_id = ba.blog_article_id AND bc.status = '1' GROUP BY bc.blog_article_id) AS comment FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_store bas ON (ba.blog_article_id = bas.blog_article_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ba.status = '1' AND bas.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY ba.viewed DESC LIMIT " . (int)$limit; 	
			
			$article_data = array();
					
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$article_data[$result['blog_article_id']] = $this->getArticle($result['blog_article_id']);
                
			}
		
		return $article_data;
	}
	public function getMinArticles() {
        $query = $this->db->query("SELECT min(blog_article_id) FROM " . DB_PREFIX . "blog_article");
		
		return $query->row;
	}
	public function getMaxArticles() {
        $query = $this->db->query("SELECT max(blog_article_id) FROM " . DB_PREFIX . "blog_article");
		
		return $query->row;
	}
	public function checkModule($code) {					
		$result = $this->db->query("Select *from " . DB_PREFIX . "extension where code = '" . $this->db->escape($code) . "'");
		if($result->num_rows)
			return true;
		return false;
   	}
}
?>