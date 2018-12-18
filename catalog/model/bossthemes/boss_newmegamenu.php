<?php
class ModelBossthemesBossNewMegamenu extends Model { 
	public function addMenu($data){
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "megamenu SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "',url = '" . $this->db->escape($data['url']) . "',icon = '" . $this->db->escape($data['icon']) . "',label_color = '" . $this->db->escape($data['label_color']) . "'");
		
		$menu_id = $this->db->getLastId();

		foreach ($data['menudes'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "megamenu_description SET menu_id = '" . (int)$menu_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "',label = '" . $this->db->escape($value['label']) . "'");
		}
	}
	
	public function addMenuRow($menu_id,$data){
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "megamenu_row SET menu_id = '" . (int)$menu_id . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', height = '" . (float)$data['height'] . "', bg_color = '" . $this->db->escape($data['bg_color']) . "', bg_image = '" . $this->db->escape($data['bg_image']) . "'");
	}
	
	public function addMenuColumn($row_id,$data){
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "megamenu_column SET row_id = '" . (int)$row_id . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', num_column = '" . (int)$data['num_column'] . "', type = '" . $this->db->escape($data['type']) . "', params = '" . json_encode($data['params']) . "'");
	}
	
	public function editMenu($menu_id,$data) {
		$this->db->query("UPDATE " . DB_PREFIX . "megamenu SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "',url = '" . $this->db->escape($data['url']) . "',icon = '" . $this->db->escape($data['icon']) . "',label_color = '" . $this->db->escape($data['label_color']) . "' WHERE menu_id = '" . (int)$menu_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "megamenu_description WHERE menu_id = '" . (int)$menu_id . "'");

		foreach ($data['menudes'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "megamenu_description SET menu_id = '" . (int)$menu_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "',label = '" . $this->db->escape($value['label']) . "'");
		}
	}
	
	public function editMenuRow($row_id,$data) {
		$this->db->query("UPDATE " . DB_PREFIX . "megamenu_row SET menu_id = '" . (int)$data['menu_id'] . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', height = '" . (float)$data['height'] . "', bg_color = '" . $this->db->escape($data['bg_color']) . "', bg_image = '" . $this->db->escape($data['bg_image']) . "' WHERE row_id = '" . (int)$row_id . "'");
	}
	
	public function editMenuColumn($column_id,$data) {
		$this->db->query("UPDATE " . DB_PREFIX . "megamenu_column SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', num_column = '" . (int)$data['num_column'] . "', type = '" . $this->db->escape($data['type']) . "', params = '" . json_encode($data['params']) . "' WHERE column_id = '" . (int)$column_id . "'");
	}
	
	public function deleteMenu($menu_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "megamenu WHERE menu_id = '" . (int)$menu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "megamenu_description WHERE menu_id = '" . (int)$menu_id . "'");
	}
	
	public function deleteMenuRow($row_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "megamenu_row WHERE row_id = '" . (int)$row_id . "'");
	}
	public function deleteMenuColumn($column_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "megamenu_column WHERE column_id = '" . (int)$column_id . "'");
	}
	
	public function getMenus(){
		$sql = "SELECT * FROM " . DB_PREFIX . "megamenu m LEFT JOIN " . DB_PREFIX . "megamenu_description md ON (m.menu_id = md.menu_id)";
		
		$sql .= " WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sql .= " GROUP BY m.menu_id";
		
		$sql .= " ORDER BY m.sort_order";
		
		$query = $this->db->query($sql);

		return $query->rows;
		
	}
	public function getMenusByModuleId($module_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "megamenu m LEFT JOIN " . DB_PREFIX . "megamenu_description md ON (m.menu_id = md.menu_id)";
		
		$sql .= " WHERE m.module_id = '" . (int)$module_id . "' and md.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sql .= " GROUP BY m.menu_id";
		
		$sql .= " ORDER BY m.sort_order";
		
		$query = $this->db->query($sql);

		return $query->rows;
		
	}
	public function getMenuRows($menu_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "megamenu_row mr WHERE mr.menu_id = '" . (int)$menu_id . "'";
		
		$sql .= " ORDER BY mr.sort_order";
		
		$query = $this->db->query($sql);

		return $query->rows;
		
	}
	
	public function getMenuColumns($row_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "megamenu_column mc WHERE mc.row_id = '" . (int)$row_id . "'";
		
		$sql .= " ORDER BY mc.sort_order";
		
		$query = $this->db->query($sql);

		return $query->rows;
		
	}
	
	public function getMenu($menu_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "megamenu m LEFT JOIN " . DB_PREFIX . "megamenu_description md ON (m.menu_id = md.menu_id) WHERE m.menu_id = '" . $menu_id . "' AND md.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
		
	}
	
	public function getMenuRow($row_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "megamenu_row mr WHERE mr.row_id = '" . (int)$row_id . "'");

		return $query->row;
		
	}
	
	public function getMenuColumn($column_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "megamenu_column mc WHERE mc.column_id = '" . (int)$column_id . "'");

		return $query->row;
		
	}
	
	public function getMenuDescription($menu_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "megamenu_description md WHERE md.menu_id = '" . $menu_id . "'");

		foreach ($query->rows as $result) {
			$menu_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'label'             => $result['label']
			);
		}

		return $menu_description_data;
		
	}
	
	public function updateSortMenu($data){
		$count = 1;
		foreach ($data as $menu_id) {
			$query = "UPDATE " . DB_PREFIX . "megamenu SET sort_order = " . $count . " WHERE menu_id = " . $menu_id;
			$this->db->query($query);
			$count ++;	
		}
	}
	public function updateSortRow($menu_id,$data){
		$count = 1;
		foreach ($data as $row_id) {
			$this->db->query("UPDATE " . DB_PREFIX . "megamenu_row SET sort_order = " . $count . " WHERE menu_id = " . $menu_id." AND row_id = ".$row_id);
			$count ++;	
		}
	}
	public function updateSortColumn($row_id,$data){
		$count = 1;
		foreach ($data as $column_id) {
			$this->db->query("UPDATE " . DB_PREFIX . "megamenu_column SET sort_order = " . $count . " WHERE row_id = " . $row_id." AND column_id = ".$column_id);
			$count ++;	
		}
	}
	
	public function install(){
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu'";
		$query = $this->db->query( $sql );
		if( count($query->rows) > 0 ){
			
			$sql="delete from `".DB_PREFIX."megamenu`";
			$query = $this->db->query( $sql );
			$sql = array();
			$sql[]  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu` (
			  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) NOT NULL DEFAULT '0',
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `width` varchar(255) DEFAULT NULL,
			  `item` varchar(255) DEFAULT NULL,
			  `colums` varchar(255) DEFAULT '1',
			  `type` varchar(255) NOT NULL,
			  `show_title` smallint(6) NOT NULL DEFAULT '1',
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
			  `position` int(11) unsigned NOT NULL DEFAULT '0',
			  `url` varchar(255) DEFAULT NULL,
			  `menu_class` varchar(25) DEFAULT NULL,
			  `params` text,
			  `content_text` text,
			  PRIMARY KEY (`menu_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_description` (
				`menu_id` int(11) NOT NULL, 
				`language_id` int(11) NOT NULL, 
				`title` varchar(255) NOT NULL, 
				PRIMARY KEY (`menu_id`,`language_id`), 
				KEY `name` (`title`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_row` (
				`row_id` int(11) NOT NULL, 
				`menu_id` int(11) NOT NULL, 
				`sort_order` int(3) NOT NULL DEFAULT '0',
				`status` tinyint(1) NOT NULL DEFAULT '0',
				PRIMARY KEY (`row_id`,`menu_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_column` (
				`column_id` int(11) NOT NULL, 
				`row_id` int(11) NOT NULL, 
				`sort_order` int(3) NOT NULL DEFAULT '0',
				`status` tinyint(1) NOT NULL DEFAULT '0',
				PRIMARY KEY (`column_id`,`row_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
		}else{ 
			$sql = array();
			$sql[]  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu` (
			  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) NOT NULL DEFAULT '0',
			  `width` varchar(255) DEFAULT NULL,
			  `item` varchar(255) DEFAULT NULL,
			  `colums` varchar(255) DEFAULT '1',
			  `type` varchar(255) NOT NULL,
			  `show_title` smallint(6) NOT NULL DEFAULT '1',
			  `status` smallint(6) NOT NULL DEFAULT '1',
			  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
			  `position` int(11) unsigned NOT NULL DEFAULT '0',
			  `url` varchar(255) DEFAULT NULL,
			  `menu_class` varchar(25) DEFAULT NULL,
			  `params` text,
			  `content_text` text,
			  PRIMARY KEY (`menu_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_description` (
				`menu_id` int(11) NOT NULL, 
				`language_id` int(11) NOT NULL, 
				`title` varchar(255) NOT NULL, 
				PRIMARY KEY (`menu_id`,`language_id`), 
				KEY `name` (`title`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_row` (
				`row_id` int(11) NOT NULL, 
				`menu_id` int(11) NOT NULL, 
				PRIMARY KEY (`row_id`,`menu_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_column` (
				`column_id` int(11) NOT NULL, 
				`row_id` int(11) NOT NULL, 
				PRIMARY KEY (`column_id`,`row_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
		}	
	}
}

?>