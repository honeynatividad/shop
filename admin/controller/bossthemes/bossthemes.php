<?php
class ControllerBossthemesBossthemes extends Controller {
	public function index() {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE layout_id = '9999'");
		$row = $query->row;
		if(isset($row['layout_id'])){
			$this->session->data['success'] = 'Your Layout did exists!';
			$this->response->redirect($this->url->link('design/layout', 'token=' . $this->session->data['token'], true));
		}else{
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET layout_id='9999', name = 'All Layout'");

			$this->session->data['success'] = 'You did create All Layout successful.';
			$this->response->redirect($this->url->link('design/layout', 'token=' . $this->session->data['token'], true));
		}
	}

	
}