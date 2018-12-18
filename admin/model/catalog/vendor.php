<?php
class ModelCatalogVendor extends Model {


	public function getTotalVendors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM vendors");

		return $query->row['total'];
	}

	public function getVendor($vendor_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM vendors WHERE vendor_id = '" . (int)$vendor_id . "'");

		return $query->row;
	}

	public function getVendors($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM vendors id";

			$sort_data = array(
				'id.vendor_name',
				'id.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.vendor_name";
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
			$vendor_data = $this->cache->get('vendors.' . (int)$this->config->get('config_language_id'));

			if (!$vendor_data) {
				$query = $this->db->query("SELECT * FROM vendors id ORDER BY id.vendor_id");

				$vendor_data = $query->rows;

				$this->cache->set('vendors.' . (int)$this->config->get('config_language_id'), $vendor_data);
			}

			return $vendor_data;
		}
	}

	public function addVendor($data) {
		$this->db->query("INSERT INTO  oc_url_alias SET query='product/vendor',keyword='".$this->db->escape($data['alias_url'])."'");
		$alias_id = $this->db->getLastId();
		$this->db->query("INSERT INTO vendors SET sort_order = '" . (int)$data['sort_order'] . "', vendor_name = '" . $this->db->escape($data['vendor_name']) . "', vendor_code = '" . $this->db->escape($data['vendor_code']) . "', alias_url = '" . $this->db->escape($data['alias_url']) . "', alias_id='".$alias_id."', status = '" . (int)$data['status'] . "'");


		$vendor_id = $this->db->getLastId();

		
		$this->cache->delete('vendor');

		return $vendor_id;
	}

	public function getVendorDescriptions($vendor_id) {
		$vendor_description_data = array();

		$query = $this->db->query("SELECT * FROM vendors WHERE vendor_id = '" . (int)$vendor_id . "'");

		foreach ($query->rows as $result) {

			$vendor_description_data[] = array(
				'vendor_code'            => $result['vendor_code'],
				'vendor_name'      => $result['vendor_name']				
			);
		}

		return $vendor_description_data;
	}

	public function getVendorStores($vendor_id) {
		$vendor_store_data = array();

		$query = $this->db->query("SELECT * FROM vendors WHERE vendor_id = '" . (int)$vendor_id . "'");

		foreach ($query->rows as $result) {
			$vendor_store_data[] = $result['vendor_id'];
		}

		return $vendor_store_data;
	}


	public function editVendor($vendor_id, $data) {
		
		$this->db->query("UPDATE vendors SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', vendor_name= '". $this->db->escape($data['vendor_name']) ."', vendor_code= '". $this->db->escape($data['vendor_code']) ."',alias_url= '". $this->db->escape($data['alias_url']) ."' WHERE vendor_id = '" . (int)$vendor_id . "'");
		
		$query = $this->db->query("SELECT alias_id FROM vendors WHERE vendor_id='".$vendor_id."'");
		$alias = $query->row;
		echo $alias;

		$this->db->query("UPDATE oc_url_alias SET keyword='".$this->db->escape($data['alias_url']) ."' WHERE url_alias_id='".$alias['alias_id']."'");
		
		$this->cache->delete('vendors');
	}
}