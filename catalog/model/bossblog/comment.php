<?php
class ModelBossblogComment extends Model {
    
    public function addComment($blog_article_id,$status,$data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_comment SET author = '" . $this->db->escape($data['username']) . "', customer_id = '" . (int)$this->customer->getId() . "', blog_article_id = '" . (int)$blog_article_id . "', text = '" . $this->db->escape($data['comment_content']) . "', email = '" . $this->db->escape($data['email']) . "', status = '".(int)$status."' , date_added = NOW()");
	}
    
    public function getCommentsByArticleId($blog_article_id, $start = 0, $limit = 5) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 5;
		}		
		
		$query = $this->db->query("SELECT bc.blog_comment_id, bc.author, bc.email, bc.text, ba.blog_article_id, bad.name, ba.image, bc.date_added FROM " . DB_PREFIX . "blog_comment bc LEFT JOIN " . DB_PREFIX . "blog_article ba ON (bc.blog_article_id = ba.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) WHERE ba.blog_article_id = '" . (int)$blog_article_id . "' AND ba.status = '1' AND bc.status = '1' AND bad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bc.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
			
		return $query->rows;
	}

    public function getTotalComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment bc LEFT JOIN " . DB_PREFIX . "blog_article ba ON (bc.blog_article_id = ba.blog_article_id) WHERE ba.status = '1' AND bc.status = '1'");
		
		return $query->row['total'];
	}
    
    public function getTotalCommentsByArticleId($blog_article_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment bc LEFT JOIN " . DB_PREFIX . "blog_article ba ON (bc.blog_article_id = ba.blog_article_id) LEFT JOIN " . DB_PREFIX . "blog_article_description bad ON (ba.blog_article_id = bad.blog_article_id) WHERE ba.blog_article_id = '" . (int)$blog_article_id . "' AND ba.status = '1' AND bc.status = '1' AND bad.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}
	public function checkModule($code) {					
		$result = $this->db->query("Select *from " . DB_PREFIX . "extension where code = '" . $this->db->escape($code) . "'");
		if($result->num_rows)
			return true;
		return false;
   	}

}    
?>