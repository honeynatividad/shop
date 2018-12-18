<?php
class ModelCatalogVendorProduct extends Model {


	public function getTotalVendors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM vendors");

		return $query->row['total'];
	}

	public function getProductsByVendor($vendor_id){
		//$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$sql = "SELECT * FROM vendor_checker a LEFT JOIN " . DB_PREFIX . "product p ON (a.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE a.vendor_id=".$vendor_id."";
		$query = $this->db->query($sql);

		return $query->rows;

	}

	public function getVendor($vendor_id){
		$sql = "SELECT * FROM vendors WHERE vendor_id='$vendor_id'";
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getVendorProduct($id){
		$sql = "SELECT * FROM vendor_checker WHERE vendor_checker_id='$id'";
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getVendors($data){
		if ($data) {
			//$sql = "SELECT * FROM vendor_checker id";

			//new SQL
			$sql = "SELECT * FROM vendor_checker a INNER JOIN vendors b on a.vendor_id = b.vendor_id";
			$sort_data = array(
				//'id.vendor_name',
				'a.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY a.vendor_id";
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
			$vendor_data = $this->cache->get('vendor_products.' . (int)$this->config->get('config_language_id'));

			if (!$vendor_data) {
				$query = $this->db->query("SELECT * FROM vendor_checker id ORDER BY id.vendor_id");

				$vendor_data = $query->rows;

				$this->cache->set('vendor_products.' . (int)$this->config->get('config_language_id'), $vendor_data);
			}

			return $vendor_data;
		}
	}

	public function getVendorId($vendor_product_id) {
		$vendor_id_data = array();

		$query = $this->db->query("SELECT * FROM vendor_checker WHERE vendor_checker_id = '" . (int)$vendor_product_id . "'");

		foreach ($query->rows as $result) {

			$vendor_description_data[] = array(
				'vendor_id'            => $result['vendor_id'],
				'product_id'      => $result['product_id']				
			);
		}

		return $vendor_description_data;
	}

	public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
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

	public function getProduct($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . $product_id . "'";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getVendorsAll() {		

		$query = $this->db->query("SELECT * FROM vendors WHERE status='1'");
		return $query->rows;
	}

	public function addVendorProduct($data) {

		$this->db->query("INSERT INTO vendor_checker SET sort_order = '" . (int)$data['sort_order'] . "', vendor_id = '" . $this->db->escape($data['vendor_id']) . "', product_id = '" . $this->db->escape($data['product_id']) . "',product_price = '" . $this->db->escape($data['product_price']) . "', promo_code = '" . $this->db->escape($data['promo_code']) . "', promo_price ='" . $this->db->escape($data['promo_price']) . "', status = '" . (int)$data['status'] . "'");

		$vendor_id = $this->db->getLastId();

		
		$this->cache->delete('vendor_product');

		return $vendor_id;
	}

	public function editVendorProduct($vendor_checker_id,$data) {
		
		$this->db->query("UPDATE vendor_checker SET product_price = '" .$this->db->escape($data['product_price']). "', promo_code = '" . $this->db->escape($data['promo_code']) . "', promo_code = '" . $this->db->escape($data['promo_code']) . "' WHERE vendor_checker_id = '" . $this->db->escape($vendor_checker_id) . "' ");

		
		
		$this->cache->delete('vendor_product');
	}
}