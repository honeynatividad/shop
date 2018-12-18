<?php
class ModelBossblogComment extends Model {
	public function addComment($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_comment SET author = '" . $this->db->escape($data['author']) . "', blog_article_id = '" . $this->db->escape($data['blog_article_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "',  email = '" . $this->db->escape($data['email']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
	
		$this->cache->delete('blog_article');
	}
	
	public function editComment($blog_comment_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_comment SET author = '" . $this->db->escape($data['author']) . "', blog_article_id = '" . $this->db->escape($data['blog_article_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "',  email = '" . $this->db->escape($data['email']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blog_comment_id = '" . (int)$blog_comment_id . "'");
	
		$this->cache->delete('blog_article');
	}
	
	public function deleteComment($blog_comment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_comment WHERE blog_comment_id = '" . (int)$blog_comment_id . "'");
		
		$this->cache->delete('blog_article');
	}
	
	public function getComment($blog_comment_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT bad.name FROM " . DB_PREFIX . "blog_article_description bad WHERE bad.blog_article_id = bc.blog_article_id AND bad.language_id = '" . (int)$this->config->get('config_language_id') . "') AS article FROM " . DB_PREFIX . "blog_comment bc WHERE bc.blog_comment_id = '" . (int)$blog_comment_id . "'");
		
		return $query->row;
	}

	public function getComments($data = array()) {
		$sql = "SELECT bc.blog_comment_id, bad.name, bc.author, bc.email, bc.text, bc.status, bc.date_added FROM " . DB_PREFIX . "blog_comment bc LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (bc.blog_article_id = bad.blog_article_id) WHERE bad.language_id = '" . (int)$this->config->get('config_language_id') . "'";																																					  
		
		$sort_data = array(
			'bad.name',
			'bc.author',
			'bc.email',
            'bc.text',
			'bc.status',
			'bc.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY bc.date_added";	
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
	}
	
	public function getTotalComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment");
		
		return $query->row['total'];
	}
	
	public function getTotalCommentsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment WHERE status = '0'");
		
		return $query->row['total'];
	}	
    
    public function checkBlogComment() {       
		$create_blog_comment = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_comment` (
  `blog_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_article_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`blog_comment_id`,`blog_article_id`,`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;";
		$this->db->query($create_blog_comment);
		$insert_blog_comment = "INSERT INTO `" . DB_PREFIX . "blog_comment` (`blog_comment_id`, `blog_article_id`, `customer_id`, `author`, `email`, `text`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, 0, 'hhx', 'hhx@yopmail.com', 'Cras lectus quam, vulputate eget scelerisque at, sodales at turpis. Nulla tincidunt, velit et posuere pharetra, magna massa sagittis ligula, ac placerat ipsum elit ac risus.', 1, '2014-12-22 15:11:00', '2015-01-08 10:47:14'),
(2, 2, 0, 'hhx', 'hhx@yopmail.com', 'Duis cursus nibh vel magna lobortis vehicula. Fusce consectetur, velit eu pretium euismod, eros urna sollicitudin enim, eu ornare tellus magna quis justo. Etiam placerat, diam sed rutrum rutrum, orci risus volutpat augue, semper varius velit enim quis leo.', 1, '2014-12-22 16:47:26', NULL),
(3, 6, 0, 'qwerty', 'admin@admin.com', 'at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commod', 1, '2014-12-31 09:49:27', NULL),
(4, 6, 0, 'Zakutara', 'admin@admin.com', 'at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commod', 1, '2014-12-31 09:50:03', NULL),
(5, 5, 0, 'Admin', 'admin@admin.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Nullam at semper mauris. Maecenas commodo tincidunt leo eget mattis.', 1, '2015-01-20 14:45:26', NULL),
(6, 5, 0, 'Navida', 'admin@admin.com', 'Nullam at semper mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sagittis lectus tristique justo porta molestie. Donec venenatis nulla at libero dictum id placerat eros elementum. Aliquam dapibus adipiscing enim vitae tempor. Maecenas commodo tincidunt leo eget mattis.', 1, '2015-01-20 14:46:15', NULL),
(7, 5, 0, 'Admin', 'admin@admin.com', 'Nullam at semper mauris. Aenean nec felis eu velit interdum laoreet eget vitae purus. Donec vel sem sapien, a interdum ligula. Fusce convallis orci quis lorem bibendum ullamcorper. Maecenas convallis sapien non lorem semper quis convallis libero varius. Duis cursus nibh vel magna lobortis vehicula.', 1, '2015-01-20 14:47:30', NULL);";
		$this->db->query($insert_blog_comment);
	}	
}
?>