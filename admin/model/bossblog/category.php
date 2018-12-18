<?php
class ModelBossblogCategory extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");
	
		$blog_category_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		}
		
		foreach ($data['blog_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET blog_category_id = '" . (int)$blog_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if (isset($data['blog_category_store'])) {
			foreach ($data['blog_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_store SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['blog_category_layout'])) {
			foreach ($data['blog_category_layout'] as $store_id => $layout_id) {
				if ($layout_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_layout SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}
		}
						
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('blog_category');
	}
	
	public function editCategory($blog_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($data['blog_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET blog_category_id = '" . (int)$blog_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		
		if (isset($data['blog_category_store'])) {		
			foreach ($data['blog_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_store SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['blog_category_layout'])) {
			foreach ($data['blog_category_layout'] as $store_id => $layout_id) {
				if ($layout_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_layout SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_category_id=" . (int)$blog_category_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('blog_category');
	}
	
	public function deleteCategory($blog_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");
		
		$query = $this->db->query("SELECT blog_category_id FROM " . DB_PREFIX . "blog_category WHERE parent_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['blog_category_id']);
		}
		
		$this->cache->delete('blog_category');
	} 

	public function getCategory($blog_category_id) {
	   $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_category_id=" . (int)$blog_category_id . "') AS keyword FROM " . DB_PREFIX . "blog_category bc LEFT JOIN " . DB_PREFIX . "blog_category_description bcd ON (bc.blog_category_id = bcd.blog_category_id) WHERE bc.blog_category_id = '" . (int)$blog_category_id . "' AND bcd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
		return $query->row;
	} 
   
	public function getCategories($parent_id = 0) {
		$blog_category_data = $this->cache->get('blog_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id);
	
		if (!$blog_category_data) {
			$blog_category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category bc LEFT JOIN " . DB_PREFIX . "blog_category_description bcd ON (bc.blog_category_id = bcd.blog_category_id) WHERE bc.parent_id = '" . (int)$parent_id . "' AND bcd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bc.sort_order, bcd.name ASC");
		
			foreach ($query->rows as $result) {
				$blog_category_data[] = array(
					'blog_category_id' => $result['blog_category_id'],
					'name'        => $this->getPath($result['blog_category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$blog_category_data = array_merge($blog_category_data, $this->getCategories($result['blog_category_id']));
			}	
	
			$this->cache->set('blog_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id, $blog_category_data);
		}
		
		return $blog_category_data;
	}
	
	public function getPath($blog_category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "blog_category bc LEFT JOIN " . DB_PREFIX . "blog_category_description bcd ON (bc.blog_category_id = bcd.blog_category_id) WHERE bc.blog_category_id = '" . (int)$blog_category_id . "' AND bcd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bc.sort_order, bcd.name ASC");
		
		if ($query->row['parent_id']) {
			return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) . ' &gt; ' . $query->row['name'];
		} else {
			return $query->row['name'];
		}
	}
	
	public function getCategoryDescriptions($blog_category_id) {
		$blog_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		
		foreach ($query->rows as $result) {
			$blog_category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $blog_category_description_data;
	}	
	
	public function getCategoryStores($blog_category_id) {
		$blog_category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$blog_category_store_data[] = $result['store_id'];
		}
		
		return $blog_category_store_data;
	}

	public function getCategoryLayouts($blog_category_id) {
		$blog_category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		
		foreach ($query->rows as $result) {
			$blog_category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $blog_category_layout_data;
	}
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category");
		
		return $query->row['total'];
	}	
		
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
    
    public function checkBlogCategory() {       
		$create_blog_category = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_category` (
  `blog_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`blog_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;";
		$this->db->query($create_blog_category);
		$insert_blog_category = "INSERT INTO `".DB_PREFIX."blog_category` (`blog_category_id`, `status`, `parent_id`, `sort_order`, `image`, `date_added`, `date_modified`) VALUES
(1, 1, 0, 0, 'catalog/bossblog/blog_cat.jpg', '2014-12-22 09:45:55', '2014-12-22 09:45:55'),
(2, 1, 0, 0, 'catalog/bossblog/h55.jpg', '2014-12-22 09:47:19', '2014-12-22 09:47:19'),
(3, 1, 2, 0, 'catalog/bossblog/h10.jpg', '2014-12-22 09:48:12', '2014-12-22 09:50:58'),
(4, 1, 3, 0, 'catalog/bossblog/h12.jpg', '2014-12-22 09:50:35', '2014-12-22 09:51:12'),
(5, 1, 2, 0, '', '2014-12-22 10:03:53', '2014-12-22 10:03:53'),
(6, 1, 0, 1, '', '2014-12-22 10:06:16', '2014-12-22 10:06:42'),
(7, 1, 0, 2, '', '2014-12-22 10:08:08', '2014-12-22 10:08:08');";
		$this->db->query($insert_blog_category);
		
		//
		$create_blog_category_descriptions = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_category_description` (
  `blog_category_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`blog_category_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_category_descriptions);
		$insert_blog_category_descriptions = "INSERT INTO `".DB_PREFIX."blog_category_description` (`blog_category_id`, `language_id`, `name`, `meta_description`, `meta_keyword`, `description`) VALUES
(1, 1, 'Smart phone', 'boss blog', 'boss blog', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor.&lt;/p&gt;\r\n\r\n&lt;p&gt;vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec felis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. Maecenas convallis sapien non lorem semper quis convallis libero varius. Duis cursus nibh vel magna lobortis vehicula.&lt;br /&gt;\r\n&lt;br /&gt;\r\nFusce consectetur, velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus volutpat augue, semper varius velit enim quis leo. Cras lectus quam, vulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum elit ac risus.&lt;/p&gt;\r\n'),
(1, 2, 'Smart phone', 'boss blog', 'boss blog', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor.&lt;/p&gt;&lt;p&gt;vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec felis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. Maecenas convallis sapien non lorem semper quis convallis libero varius. Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;&lt;br&gt;Fusce consectetur, velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus volutpat augue, semper varius velit enim quis leo. Cras lectus quam, vulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum elit ac risus.&lt;/p&gt;'),
(2, 1, 'Technology', '', '', '&lt;p&gt;Microsoft tapped Tami Reller, the chief financial officer and head of marketing for Windows, to run business operations for the division, while Microsoft veteran Julie Larson-Green will take over responsibility for the technical features and product blueprints for Windows software and hardware such as the Surface tablet computer.&lt;/p&gt;\r\n'),
(2, 2, 'Technology', '', '', '&lt;p&gt;Microsoft tapped Tami Reller, the chief financial officer and head of marketing for Windows, to run business operations for the division, while Microsoft veteran Julie Larson-Green will take over responsibility for the technical features and product blueprints for Windows software and hardware such as the Surface tablet computer.&lt;/p&gt;\r\n'),
(3, 1, 'Digital Camera', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor.&lt;/p&gt;\r\n\r\n&lt;p&gt;vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec felis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. Maecenas convallis sapien non lorem semper quis convallis libero varius. Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;\r\n&lt;br&gt;\r\nFusce consectetur, velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus volutpat augue, semper varius velit enim quis leo. Cras lectus quam, vulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum elit ac risus.&lt;/p&gt;\r\n'),
(3, 2, 'Digital Camera', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor.&lt;/p&gt;\r\n\r\n&lt;p&gt;vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec felis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. Maecenas convallis sapien non lorem semper quis convallis libero varius. Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;\r\n&lt;br&gt;\r\nFusce consectetur, velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus volutpat augue, semper varius velit enim quis leo. Cras lectus quam, vulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum elit ac risus.&lt;/p&gt;\r\n'),
(4, 1, 'Sony', 'boss blog', 'boss blog', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor.&lt;/p&gt;\r\n\r\n&lt;p&gt;vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec felis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. Maecenas convallis sapien non lorem semper quis convallis libero varius. Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;\r\n&lt;br&gt;\r\nFusce consectetur, velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus volutpat augue, semper varius velit enim quis leo. Cras lectus quam, vulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum elit ac risus.&lt;/p&gt;\r\n'),
(4, 2, 'Sony', 'boss blog', 'boss blog', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor.&lt;/p&gt;\r\n\r\n&lt;p&gt;vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec felis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. Maecenas convallis sapien non lorem semper quis convallis libero varius. Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;\r\n&lt;br&gt;\r\nFusce consectetur, velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus volutpat augue, semper varius velit enim quis leo. Cras lectus quam, vulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum elit ac risus.&lt;/p&gt;\r\n'),
(5, 1, 'Smart phone', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum \r\nsagittis lectus tristique justo porta molestie. Donec venenatis nulla at\r\n libero dictum id placerat eros elementum. Aliquam dapibus adipiscing \r\nenim vitae tempor.&lt;br&gt;&lt;/p&gt;&lt;p&gt;vestibulum sagittis lectus tristique justo \r\nporta molestie. Donec venenatis nulla at libero dictum id placerat eros \r\nelementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at \r\nsemper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec \r\nfelis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a\r\n interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. \r\nMaecenas convallis sapien non lorem semper quis convallis libero varius.\r\n Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;&lt;br&gt;Fusce consectetur,\r\n velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus\r\n magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus \r\nvolutpat augue, semper varius velit enim quis leo. Cras lectus quam, \r\nvulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit\r\n et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum \r\nelit ac risus.&lt;br&gt;&lt;/p&gt;'),
(5, 2, 'Smart phone', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum \r\nsagittis lectus tristique justo porta molestie. Donec venenatis nulla at\r\n libero dictum id placerat eros elementum. Aliquam dapibus adipiscing \r\nenim vitae tempor.&lt;br&gt;&lt;/p&gt;&lt;p&gt;vestibulum sagittis lectus tristique justo \r\nporta molestie. Donec venenatis nulla at libero dictum id placerat eros \r\nelementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at \r\nsemper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec \r\nfelis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a\r\n interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. \r\nMaecenas convallis sapien non lorem semper quis convallis libero varius.\r\n Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;&lt;br&gt;Fusce consectetur,\r\n velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus\r\n magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus \r\nvolutpat augue, semper varius velit enim quis leo. Cras lectus quam, \r\nvulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit\r\n et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum \r\nelit ac risus.&lt;br&gt;&lt;/p&gt;'),
(6, 1, 'Business', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum \r\nsagittis lectus tristique justo porta molestie. Donec venenatis nulla at\r\n libero dictum id placerat eros elementum. Aliquam dapibus adipiscing \r\nenim vitae tempor.&lt;br&gt;&lt;/p&gt;&lt;p&gt;vestibulum sagittis lectus tristique justo \r\nporta molestie. Donec venenatis nulla at libero dictum id placerat eros \r\nelementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at \r\nsemper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec \r\nfelis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a\r\n interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. \r\nMaecenas convallis sapien non lorem semper quis convallis libero varius.\r\n Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;&lt;br&gt;Fusce consectetur,\r\n velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus\r\n magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus \r\nvolutpat augue, semper varius velit enim quis leo. Cras lectus quam, \r\nvulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit\r\n et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum \r\nelit ac risus.&lt;/p&gt;'),
(6, 2, 'Business', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum \r\nsagittis lectus tristique justo porta molestie. Donec venenatis nulla at\r\n libero dictum id placerat eros elementum. Aliquam dapibus adipiscing \r\nenim vitae tempor.&lt;br&gt;&lt;/p&gt;&lt;p&gt;vestibulum sagittis lectus tristique justo \r\nporta molestie. Donec venenatis nulla at libero dictum id placerat eros \r\nelementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at \r\nsemper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec \r\nfelis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a\r\n interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. \r\nMaecenas convallis sapien non lorem semper quis convallis libero varius.\r\n Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;&lt;br&gt;Fusce consectetur,\r\n velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus\r\n magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus \r\nvolutpat augue, semper varius velit enim quis leo. Cras lectus quam, \r\nvulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit\r\n et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum \r\nelit ac risus.&lt;/p&gt;'),
(7, 1, 'Sport', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum \r\nsagittis lectus tristique justo porta molestie. Donec venenatis nulla at\r\n libero dictum id placerat eros elementum. Aliquam dapibus adipiscing \r\nenim vitae tempor.&lt;br&gt;&lt;/p&gt;&lt;p&gt;vestibulum sagittis lectus tristique justo \r\nporta molestie. Donec venenatis nulla at libero dictum id placerat eros \r\nelementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at \r\nsemper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec \r\nfelis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a\r\n interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. \r\nMaecenas convallis sapien non lorem semper quis convallis libero varius.\r\n Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;&lt;br&gt;Fusce consectetur,\r\n velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus\r\n magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus \r\nvolutpat augue, semper varius velit enim quis leo. Cras lectus quam, \r\nvulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit\r\n et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum \r\nelit ac risus.&lt;/p&gt;'),
(7, 2, 'Sport', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum \r\nsagittis lectus tristique justo porta molestie. Donec venenatis nulla at\r\n libero dictum id placerat eros elementum. Aliquam dapibus adipiscing \r\nenim vitae tempor.&lt;br&gt;&lt;/p&gt;&lt;p&gt;vestibulum sagittis lectus tristique justo \r\nporta molestie. Donec venenatis nulla at libero dictum id placerat eros \r\nelementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at \r\nsemper mauris. Maecenas commodo tincidunt leo eget mattis. Aenean nec \r\nfelis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a\r\n interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. \r\nMaecenas convallis sapien non lorem semper quis convallis libero varius.\r\n Duis cursus nibh vel magna lobortis vehicula.&lt;br&gt;&lt;br&gt;Fusce consectetur,\r\n velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus\r\n magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus \r\nvolutpat augue, semper varius velit enim quis leo. Cras lectus quam, \r\nvulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit\r\n et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum \r\nelit ac risus.&lt;/p&gt;');";
		$this->db->query($insert_blog_category_descriptions);
		
		//
		$create_blog_category_store = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_category_store` (
  `blog_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_category_store);
		$insert_blog_category_store = "INSERT INTO `".DB_PREFIX."blog_category_store` (`blog_category_id`, `store_id`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0);";
		$this->db->query($insert_blog_category_store);
		
        $create_blog_category_layout = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."blog_category_layout` (
  `blog_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->db->query($create_blog_category_layout);
	}		
}
?>