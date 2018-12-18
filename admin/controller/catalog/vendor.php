<?php
class ControllerCatalogVendor extends Controller {
	private $error = array();

	public function index(){
		$this->load->language('catalog/vendor');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/vendor');
		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/vendor');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/vendor');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			//print_r($this->request->post);
			$data_form = array();
			

			foreach($this->request->post['vendor_description'] as $t){
				
				$data_form = array(
					"vendor_name"	=>	$t['vendor_name'],
					"vendor_code"	=>	$t['vendor_code'],
					"alias_url"		=>	$this->request->post['alias_url'],
					"status"		=>	$this->request->post['status'],
					"sort_order"	=>	$this->request->post['sort_order']
				);
			}
			
			//echo '<pre>';
			//	print_r($data_form);
			//echo '</pre>';
			$this->model_catalog_vendor->addVendor($data_form);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			//$this->response->redirect($this->url->link('catalog/vendor', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/vendor');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/vendor');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data_form = array();			

			foreach($this->request->post['vendor_description'] as $t){
				
				$data_form = array(
					"vendor_name"	=>	$t['vendor_name'],
					"vendor_code"	=>	$t['vendor_code'],
					"alias_url"		=>	$this->request->post['alias_url'],
					"status"		=>	$this->request->post['status'],
					"sort_order"	=>	$this->request->post['sort_order']
				);
			}
			$this->model_catalog_vendor->editVendor($this->request->get['vendor_id'], $data_form);
			//$this->model_catalog_vendor->editVendor($this->request->get['vendor_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/vendor', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['information_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_vendor_name'] = $this->language->get('entry_vendor_name');
		$data['entry_vendor_code'] = $this->language->get('entry_vendor_code');
		$data['entry_alias_url'] = $this->language->get('entry_alias_url');
		
		
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_bottom'] = $this->language->get('help_bottom');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['vendor_name'])) {
			$data['error_vendor_name'] = $this->error['vendor_name'];
		} else {
			$data['error_vendor_name'] = array();
		}

		if (isset($this->error['vendor_code'])) {
			$data['error_vendor_code'] = $this->error['vendor_code'];
		} else {
			$data['error_vendor_code'] = array();
		}

		if (isset($this->error['alias_url'])) {
			$data['error_alias_url'] = $this->error['alias_url'];
		} else {
			$data['error_alias_url'] = array();
		}

		

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/vendor', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['vendor_id'])) {
			$data['action'] = $this->url->link('catalog/vendor/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/vendor/edit', 'token=' . $this->session->data['token'] . '&vendor_id=' . $this->request->get['vendor_id'] . $url, true);
			//print_r($data['action']);
		}

		$data['cancel'] = $this->url->link('catalog/vendor', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['vendor_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$vendor_info = $this->model_catalog_vendor->getVendor($this->request->get['vendor_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['vendor_description'])) {
			$data['vendor_description'] = $this->request->post['vendor_description'];
		} elseif (isset($this->request->get['vendor_id'])) {
			$data['vendor_description'] = $this->model_catalog_vendor->getVendorDescriptions($this->request->get['vendor_id']);
			
		} else {
			$data['vendor_description'] = array();
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['vendor_store'])) {
			$data['vendor_store'] = $this->request->post[' vendor_store'];
		} elseif (isset($this->request->get['vendor_id'])) {
			$data['vendor_store'] = $this->model_catalog_vendor->getVendorStores($this->request->get['vendor_id']);
		} else {
			$data['vendor_store'] = array(0);
		}
		
		
		if (isset($this->request->post['alias_url'])) {
			$data['alias_url'] = $this->request->post['alias_url'];
		} elseif (!empty($vendor_info)) {
			$data['alias_url'] = $vendor_info['alias_url'];
		} else {
			$data['alias_url'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($vendor_info)) {
			$data['status'] = $vendor_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($vendor_info)) {
			$data['sort_order'] = $vendor_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		//edited by HCN
		//use vendor form
		
		$this->response->setOutput($this->load->view('catalog/vendor_form', $data));
	}
	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id.vendor_name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/vendor', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/vendor/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/vendor/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['vendors'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$vendor_total = $this->model_catalog_vendor->getTotalVendors();

		$results = $this->model_catalog_vendor->getVendors($filter_data);

		foreach ($results as $result) {
			$data['vendors'][] = array(
				'vendor_id' => $result['vendor_id'],
				'vendor_name'          => $result['vendor_name'],
				'alias_url'				=>	$result['alias_url'],
				'sort_order'     => $result['sort_order'],
				'edit'           => $this->url->link('catalog/vendor/edit', 'token=' . $this->session->data['token'] . '&vendor_id=' . $result['vendor_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('catalog/vendor', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/vendor', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $vendor_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/information', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($vendor_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($vendor_total - $this->config->get('config_limit_admin'))) ? $vendor_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $vendor_total, ceil($vendor_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort; 
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/vendor_list', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/vendor')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['vendor_description'] as $language_id => $value) {
			if ((utf8_strlen($value['vendor_name']) < 3) || (utf8_strlen($value['vendor_name']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['vendor_code']) < 3) {
				$this->error['vendor_code'][$language_id] = $this->language->get('error_description');
			}

			
		}
		

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

}