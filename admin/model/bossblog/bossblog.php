<?php
class ModelBossblogBossblog extends Model {
    public function dropBlog(){
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article`, `" . DB_PREFIX . "blog_article_category`, `" . DB_PREFIX . "blog_article_description`, `" . DB_PREFIX . "blog_article_layout`, `" . DB_PREFIX . "blog_article_related`, `" . DB_PREFIX . "blog_article_store`, `" . DB_PREFIX . "blog_category`, `" . DB_PREFIX . "blog_category_description`, `" . DB_PREFIX . "blog_category_layout`, `" . DB_PREFIX . "blog_category_store`, `" . DB_PREFIX . "blog_comment`, `" . DB_PREFIX . "blog_product_related`");
    }
    public function checkBlogCode($type, $code) {	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE type = '" . $this->db->escape($type) . "'AND code = '" . $this->db->escape($code) . "'");
		
		if($query->rows) {
			return true;
		}else {
            return false;
		}
	}
    public function getKeyword($query){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($query) . "'");
        
        return $query->row;
    }
    public function editKeyword($query,$keyword){
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($query) . "'");
        
        if ($keyword) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '" . $this->db->escape($query) . "', keyword = '" . $this->db->escape($keyword) . "'");
		}
    }
}
?>