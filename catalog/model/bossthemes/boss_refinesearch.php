<?php
class ModelBossthemesBossRefinesearch extends Model { 

	public function getFilterImage($filter_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_image WHERE filter_id = '" . (int)$filter_id . "'");

		return $query->row;
	}
	public function getFilterByProductId($product_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_filter` pf  LEFT JOIN " . DB_PREFIX . "filter_image fi ON (fi.filter_id = pf.filter_id) LEFT JOIN " . DB_PREFIX . "filter_description fd ON (fd.filter_id = pf.filter_id) WHERE pf.product_id = '" . (int)$product_id . "' and fd.language_id='".(int)$this->config->get('config_language_id')."'");

		return $query->rows;
	}
}
?>