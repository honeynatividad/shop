<?php
class ModelBossThemesBossThemes extends Model {
	public function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "'");

		return $query->rows;
	}
	public function getAllModules() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module ORDER BY sort_order");
		
		return $query->rows;
	}
	public function getLayoutModulesByPosition($position) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE position = '" . $this->db->escape($position) . "' ORDER BY sort_order");
		
		return $query->rows;
	}
}
?>