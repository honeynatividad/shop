<?php
class ModelBossblogArticles extends Model {
	public function addArticle($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article SET author = '" . $this->db->escape($data['author']) . "', status = '" . (int)$data['status'] . "', allow_comment = '" . (int)$data['allow_comment'] . "', need_approval = '" . (int)$data['need_approval'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");
		
		$blog_article_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_article SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		}
		
		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_description SET blog_article_id = '" . (int)$blog_article_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', title = '" . $this->db->escape($value['title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', content = '" . $this->db->escape($value['content']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}
		
		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_store SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		
		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_category SET blog_article_id = '" . (int)$blog_article_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}
		
		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$blog_article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$related_id . "', related_id = '" . (int)$blog_article_id . "'");
			}
		}
        
        if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND product_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$blog_article_id . "', product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$product_id . "' AND product_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$product_id . "', product_id = '" . (int)$blog_article_id . "'");
			}
		}

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout_id) {
				if ($layout_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_layout SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}
		}
        
        if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_article_id=" . (int)$blog_article_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
						
	}
	
	public function editArticle($blog_article_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_article SET author = '" . $this->db->escape($data['author']) . "', status = '" . (int)$data['status'] . "', allow_comment = '" . (int)$data['allow_comment'] . "', need_approval = '" . (int)$data['need_approval'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = '" . $this->db->escape($data['date_modified']) . "' WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_article SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_description WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_description SET blog_article_id = '" . (int)$blog_article_id . "', language_id = '" . (int)$language_id . "',  name = '" . $this->db->escape($value['name']) . "', title = '" . $this->db->escape($value['title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', content = '" . $this->db->escape($value['content']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_store WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_store SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
	
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_category WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_category SET blog_article_id = '" . (int)$blog_article_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE related_id = '" . (int)$blog_article_id . "'");
		
        if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$blog_article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_related SET blog_article_id = '" . (int)$related_id . "', related_id = '" . (int)$blog_article_id . "'");
			}
		}

        $this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE product_id = '" . (int)$blog_article_id . "'");

        if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "' AND product_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$blog_article_id . "', product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$product_id . "' AND product_id = '" . (int)$blog_article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_product_related SET blog_article_id = '" . (int)$product_id . "', product_id = '" . (int)$blog_article_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_layout WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout_id) {
				if (isset($layout_id) && $layout_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_article_layout SET blog_article_id = '" . (int)$blog_article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}
		}
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_article_id=" . (int)$blog_article_id. "'");
        if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_article_id=" . (int)$blog_article_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
										
		$this->cache->delete('blog_article');
	}
	
	public function deleteArticle($blog_article_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_description WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_related WHERE related_id = '" . (int)$blog_article_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_product_related WHERE product_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_category WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_layout WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_article_store WHERE blog_article_id = '" . (int)$blog_article_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_article_id=" . (int)$blog_article_id. "'");	
		$this->cache->delete('blog_article');
	}
	
	public function getArticle($blog_article_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_article_id=" . (int)$blog_article_id . "') AS keyword FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) WHERE ba.blog_article_id = '" . (int)$blog_article_id . "' AND bad.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getArticles($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id)";
			
			if (!empty($data['filter_blog_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blog_article_category bac ON (ba.blog_article_id = bac.blog_article_id)";			
			}
					
			$sql .= " WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(bad.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND ba.status = '" . (int)$data['filter_status'] . "'";
			}
					
			if (!empty($data['filter_blog_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = "blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
					
					$this->load->model('bossblog/articles');
					
					$categories = $this->model_bossblog_category->getCategories($data['filter_blog_category_id']);
					
					foreach ($categories as $category) {
						$implode_data[] = "bac.blog_category_id = '" . (int)$category['blog_category_id'] . "'";
					}
					
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND bac.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
				}
			}
			
			$sql .= " GROUP BY ba.blog_article_id";
						
			$sort_data = array(
				'bad.name',
				'ba.status',
				'ba.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY bad.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
		
			return $query->rows;
		} else {
			$article_data = $this->cache->get('article.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));
		
			if (!$article_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bad.name ASC");
	
				$article_data = $query->rows;
			
				$this->cache->set('article.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $article_data);
			}	
	
			return $article_data;
		}
	}
    
	public function getArticleDescriptions($blog_article_id) {
		$article_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_description WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
                'title'            => $result['title'],
				'content'      => $result['content'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'tag'              => $result['tag']
			);
		}
		
		return $article_description_data;
	}

	public function getArticleStores($blog_article_id) {
		$article_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_store WHERE blog_article_id = '" . (int)$blog_article_id . "'");

		foreach ($query->rows as $result) {
			$article_store_data[] = $result['store_id'];
		}
		
		return $article_store_data;
	}

	public function getArticleLayouts($blog_article_id) {
		$article_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_layout WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $article_layout_data;
	}
		
	public function getArticleCategories($blog_article_id) {
		$article_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_category WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_category_data[] = $result['blog_category_id'];
		}

		return $article_category_data;
	}

	public function getArticleRelated($blog_article_id) {
		$article_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_article_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_data[] = $result['related_id'];
		}
		
		return $article_related_data;
	}
    
   	public function getBlogProductRelated($blog_article_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_product_related WHERE blog_article_id = '" . (int)$blog_article_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['product_id'];
		}
		
		return $product_related_data;
	}
	
	public function getTotalArticles($data = array()) {
		$sql = "SELECT COUNT(DISTINCT ba.blog_article_id) AS total FROM " . DB_PREFIX . "blog_article ba LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id)";

		if (!empty($data['filter_blog_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "blog_article_category bac ON (ba.blog_article_id = bac.blog_article_id)";			
		}
		 
		$sql .= " WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(bad.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND ba.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_blog_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "bac.<strong>blog_category_id</strong> = '" . (int)$data['filter_blog_category_id'] . "'";
				
				$this->load->model('bossblog/articles');
				
				$categories = $this->model_bossblog_category->getCategories($data['filter_blog_category_id']);
				
				foreach ($categories as $category) {
					$implode_data[] = "bac.blog_category_id = '" . (int)$category['blog_category_id'] . "'";
				}
				
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND bac.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
			}
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	

	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_article_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
    
    public function checkBlogArticle() {
		$create_blog_article = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_article` (
  `blog_article_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `allow_comment` tinyint(1) NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `need_approval` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`blog_article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;";
		$this->db->query($create_blog_article);
		$insert_blog_article = "INSERT INTO `".DB_PREFIX."blog_article` (`blog_article_id`, `status`, `allow_comment`, `author`, `need_approval`, `sort_order`, `viewed`, `image`, `date_added`, `date_modified`) VALUES
(1, 1, 2, 'Admin', 2, 4, 13, 'catalog/boss_blog/b4.jpg', '2014-12-22 10:13:00', '2014-12-22 00:00:00'),
(2, 1, 2, 'Admin', 2, 0, 91, 'catalog/boss_blog/b5.jpg', '2014-12-22 10:19:54', '2014-12-22 00:00:00'),
(3, 1, 2, 'Admin', 2, 2, 9, 'catalog/boss_blog/b7.jpg', '2014-12-22 10:28:33', '2014-12-22 00:00:00'),
(4, 1, 2, 'Admin', 2, 0, 55, 'catalog/boss_blog/b2.jpg', '2014-12-22 10:32:20', '2014-12-22 00:00:00'),
(5, 1, 2, 'Admin', 2, 0, 35, 'catalog/boss_blog/b6.jpg', '2014-12-22 10:35:15', '2014-12-31 00:00:00'),
(6, 1, 2, 'Admin', 2, 0, 88, 'catalog/boss_blog/b1.jpg', '2014-12-22 10:37:47', '2014-12-31 00:00:00'),
(7, 1, 2, 'Admin', 2, 0, 137, 'catalog/boss_blog/b3.jpg', '2014-12-22 10:39:39', '2014-12-22 00:00:00');";
		$this->db->query($insert_blog_article);
		
		//
		$create_blog_article_descriptions = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_article_description` (
  `blog_article_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tag` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`blog_article_id`,`language_id`),
  FULLTEXT KEY `tag` (`tag`,`content`),
  FULLTEXT KEY `tag_2` (`tag`),
  FULLTEXT KEY `tag_3` (`tag`),
  FULLTEXT KEY `tag_4` (`tag`),
  FULLTEXT KEY `content` (`content`),
  FULLTEXT KEY `content_2` (`content`),
  FULLTEXT KEY `tag_5` (`tag`),
  FULLTEXT KEY `tag_6` (`tag`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_descriptions);
		$add_fulltext ="ALTER TABLE `" . DB_PREFIX . "blog_article_description` ADD FULLTEXT(`tag`,`content`)";
        $this->db->query($add_fulltext);
		$insert_blog_article_descriptions = "INSERT INTO `".DB_PREFIX."blog_article_description` (`blog_article_id`, `language_id`, `name`, `title`, `meta_description`, `meta_keyword`, `content`, `tag`) VALUES
(1, 1, 'Powder blue collarless playsuit ', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'dignissimos,ducimus,quiblanditiis,praesentium'),
(1, 2, 'Powder blue collarless playsuit ', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'dignissimos,ducimus,quiblanditiis,praesentium'),
(2, 2, 'social challenges community workers volunteer', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', '', '', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'dolorese,tquas'),
(2, 1, 'social challenges community workers volunteer', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', '', '', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'dolorese,tquas'),
(3, 1, 'Playsuit black razor pleats', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'tristiqueu,stoporta'),
(3, 2, 'Playsuit black razor pleats', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'tristiqueu,stoporta'),
(4, 1, 'Agriculture, fighting poverty beneficiaries', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'aliquam,dapibus'),
(4, 2, 'Agriculture, fighting poverty beneficiaries', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'aliquam,dapibus'),
(5, 2, 'Human being, transform diver potential best practices', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'risus,volutpa'),
(5, 1, 'Human being, transform diver potential best practices', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'risus,volutpa'),
(6, 1, 'fighting poverty beneficiaries social challenges', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'nsectetur,adipiscing'),
(6, 2, 'fighting poverty beneficiaries social challenges', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'nsectetur,adipiscing'),
(7, 1, 'Braid slipper dress dungaree ', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'deserunt,moll'),
(7, 2, 'Braid slipper dress dungaree ', 'Spearmint ecru denim cashmere clutch holographic indigo Prada Saffiano washed out. Rings leather tote playsuit crop button up So-Cal Maison Martin Margiela center part la marinière. Shoe print plaited knot ponytail vintage luxe chambray lilac black.', 'bossblog', 'bossblog', '&lt;p&gt;Spearmint ecru denim cashmere clutch holographic indigo Prada \r\nSaffiano washed out. Rings leather tote playsuit crop button up So-Cal \r\nMaison Martin Margiela center part la marinière. Statement chunky sole \r\ncotton texture boots pastel navy blue Paris sneaker. Shoe print plaited \r\nknot ponytail vintage luxe chambray lilac black.&amp;nbsp; Dove grey cami \r\nmetallic bomber gold collar midi vintage Levi slipper minimal. Relaxed \r\nsandal Saint Laurent slip dress bandeau Jil Sander Vasari Hermès. Denim \r\nshorts cuff skirt Lanvin braid seam leggings. Tortoise-shell sunglasses \r\nsilhouette round sunglasses razor pleats chignon tee grunge. Plaited \r\nknitwear collarless denim Céline relaxed silhouette denim shorts. Lanvin\r\n floral slipper cuff Furla. Chunky sole ecru A.P.C. oversized sweatshirt\r\n rings loafer leggings skirt Hermès. Minimal Givenchy holographic ribbed\r\n seam crop Acne.&lt;/p&gt;&lt;p&gt;Texture sandal center part braid maxi powder \r\nblue. Pastel clutch Paris vintage chignon metallic sneaker flats skinny \r\njeans vintage Levi. Maison Martin Margiela shoe print razor pleats dress\r\n Jil Sander Vasari cotton cami. Oxford leather envelope clutch navy blue\r\n round sunglasses Cara D. slip dress. 90s bomber statement black button \r\nup spearmint gold collar tucked t-shirt sports luxe tortoise-shell \r\nsunglasses. Tee bandeau Saint Laurent luxe street style playsuit Prada \r\nSaffiano skort. Midi strong eyebrows white dungaree lilac chambray white\r\n shirt. Cashmere washed out boots cable knit indigo dove grey grunge \r\nSo-Cal.&lt;/p&gt;&lt;p&gt;Pastel spearmint holographic A.P.C. Hermès collarless \r\nwashed out. Tee denim shorts collarless chunky sole Jil Sander Vasari \r\nchambray skort. Maison Martin Margiela washed out clutch cashmere Hermès\r\n playsuit. Cami sneaker dungaree grunge 90s shoe leggings skirt \r\noversized sweatshirt. Silhouette round sunglasses strong eyebrows \r\nneutral slip dress flats crop button up skort Lanvin. Hermès braid \r\ncenter part vintage Levi chunky sole cashmere indigo white shirt sports \r\nluxe. Cuff playsuit Furla denim shorts razor pleats dove grey tee \r\ngrunge. Sandal black relaxed Paris knitwear bomber. Clutch slipper maxi \r\nloafer Acne. Street style dungaree oversized sweatshirt gold collar \r\nchambray metallic 90s collarless. Leather sneaker ribbed Céline chignon \r\nboots luxe. Skinny jeans Saint Laurent statement cami tucked t-shirt Jil\r\n Sander Vasari print So-Cal. ports luxe relaxed flats black Cara D. \r\ndenim shorts. Paris skirt sandal oversized sweatshirt envelope clutch \r\ncenter part. Gold collar knot ponytail grunge lilac vintage boots cotton\r\n leggings braid cashmere.&lt;/p&gt;', 'deserunt,moll');";
		$this->db->query($insert_blog_article_descriptions);
		
		//
        $create_blog_article_category = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_article_category` (
  `blog_article_id` int(11) NOT NULL,
  `blog_category_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_article_id`,`blog_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_category);
		$insert_blog_article_category = "INSERT INTO `".DB_PREFIX."blog_article_category` (`blog_article_id`, `blog_category_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(1, 6),
(1, 7),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(2, 6),
(2, 7),
(3, 1),
(3, 2),
(3, 3),
(3, 5),
(3, 6),
(3, 7),
(4, 1),
(4, 2),
(4, 3),
(4, 5),
(4, 6),
(4, 7),
(5, 1),
(5, 2),
(5, 3),
(5, 5),
(5, 6),
(5, 7),
(6, 1),
(6, 2),
(6, 3),
(6, 5),
(6, 6),
(6, 7),
(7, 1),
(7, 2),
(7, 3),
(7, 5),
(7, 6),
(7, 7);";
		$this->db->query($insert_blog_article_category);
		
		//
		$create_blog_article_store = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_article_store` (
  `blog_article_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_article_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_store);
		$insert_blog_article_store = "INSERT INTO `".DB_PREFIX."blog_article_store` (`blog_article_id`, `store_id`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0);";
		$this->db->query($insert_blog_article_store);
		
		//
        $create_blog_article_layout = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_article_layout` (
  `blog_article_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_article_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_layout);
		
		//
        $create_blog_article_related = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_article_related` (
  `blog_article_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_article_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_article_related);
		$insert_blog_article_related = "INSERT INTO `".DB_PREFIX."blog_article_related` (`blog_article_id`, `related_id`) VALUES
(1, 2),
(1, 5),
(1, 6),
(1, 7),
(2, 1),
(2, 3),
(2, 5),
(2, 7),
(3, 2),
(3, 5),
(3, 6),
(3, 7),
(4, 5),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 7),
(6, 1),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(7, 5);";
		$this->db->query($insert_blog_article_related);
		$create_blog_product_related = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_product_related` (
  `blog_article_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_article_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_product_related);
		$insert_blog_product_related = "INSERT INTO `".DB_PREFIX."blog_product_related` (`blog_article_id`, `product_id`) VALUES
(1, 34),
(1, 35),
(1, 41),
(1, 42),
(1, 47),
(2, 34),
(2, 41),
(3, 30),
(3, 36),
(3, 42),
(3, 43),
(4, 29),
(4, 31),
(4, 32),
(4, 44),
(5, 29),
(5, 41),
(5, 48),
(6, 28),
(6, 29),
(6, 34),
(6, 45),
(7, 30),
(7, 32),
(7, 40),
(7, 48),
(28, 6),
(29, 4),
(29, 5),
(29, 6),
(30, 3),
(30, 7),
(31, 4),
(32, 4),
(32, 7),
(34, 1),
(34, 2),
(34, 6),
(35, 1),
(36, 3),
(40, 7),
(41, 1),
(41, 2),
(41, 5),
(42, 1),
(42, 3),
(43, 3),
(44, 4),
(45, 6),
(47, 1),
(48, 5),
(48, 7);";
		$this->db->query($insert_blog_product_related);
	}
}
?>