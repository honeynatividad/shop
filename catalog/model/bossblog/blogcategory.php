<?php
class ModelBossblogBlogcategory extends Model {
	public function getBlogCategory($blog_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog_category bc LEFT JOIN " . DB_PREFIX . "blog_category_description bcd ON (bc.blog_category_id = bcd.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_store bcs ON (bc.blog_category_id = bcs.blog_category_id) WHERE bc.blog_category_id = '" . (int)$blog_category_id . "' AND bcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND bcs.store_id = '" . (int)$this->config->get('config_store_id') . "' AND bc.status = '1'");
		
		return $query->row;
	}
	
	public function getBlogCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category bc LEFT JOIN " . DB_PREFIX . "blog_category_description bcd ON (bc.blog_category_id = bcd.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_store bcs ON (bc.blog_category_id = bcs.blog_category_id) WHERE bc.parent_id = '" . (int)$parent_id . "' AND bcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND bcs.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND bc.status = '1' ORDER BY bc.sort_order, LCASE(bcd.name)");

		return $query->rows;
	}
		
	public function getBlogCategoriesByParentId($blog_category_id) {
		$category_data = array();

		$category_query = $this->db->query("SELECT blog_category_id FROM " . DB_PREFIX . "blog_category WHERE parent_id = '" . (int)$blog_category_id . "'");

		foreach ($category_query->rows as $category) {
			$category_data[] = $category['blog_category_id'];

			$children = $this->getBlogCategoriesByParentId($category['blog_category_id']);

			if ($children) {
				$category_data = array_merge($children, $category_data);
			}			
		}

		return $category_data;
	}
			
	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_category');
		}
	}
					
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
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