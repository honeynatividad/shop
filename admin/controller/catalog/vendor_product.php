<?php
class ControllerCatalogVendorProduct extends Controller {

	private $error = array();

	public function index(){
		$this->load->language('catalog/vendor_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/vendor_product');
		$this->load->model('catalog/vendor');
		$this->getList();
	}

	public function view(){
		$this->load->language('catalog/vendor_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/vendor_product');
		$this->load->model('catalog/vendor');

		if (isset($this->request->get['vendor_id'])) {
			$vendor_id = $this->request->get['vendor_id'];
		} else {
			$vendor_id = '';
		}

		$this->getProduct($vendor_id);
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
			'href' => $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/vendor_product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/vendor_product/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['vendors'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$vendor_total = $this->model_catalog_vendor_product->getTotalVendors();

		//$results = $this->model_catalog_vendor_product->getVendors($filter_data);
		$results = $this->model_catalog_vendor->getVendors();
		/*echo '<pre>';
		print_r($results);
		echo '</pre>';*/
		foreach ($results as $result) {
			$data['vendors'][] = array(
				'vendor_id' => $result['vendor_id'],
				//'price'		=>	$result['price'],
				'vendor_name'          => $result['vendor_name'],
				'sort_order'     => $result['sort_order'],
				'view'			=>	$this->url->link('catalog/vendor_product/view', 'token=' . $this->session->data['token'] . '&vendor_id=' . $result['vendor_id'] . $url, true),
				'edit'           => $this->url->link('catalog/vendor_product/edit', 'token=' . $this->session->data['token'] . '&vendor_id=' . $result['vendor_id'] . $url, true)
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
		$data['button_view'] = $this->language->get('button_view');
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

		$data['sort_title'] = $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);

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

		$this->response->setOutput($this->load->view('catalog/vendor_product', $data));
	}

	//===================================
	// List of products per vendor
	//===================================
	protected function getProduct($vendor_id) {
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
			'href' => $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/vendor_product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/vendor_product/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['vendors'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin'),
			'vendor_id'	=> $vendor_id
		);

		$vendor_total = $this->model_catalog_vendor_product->getTotalVendors();
		$vendor_detail = $this->model_catalog_vendor_product->getVendor($vendor_id);
		//$results = $this->model_catalog_vendor_product->getVendors($filter_data);
		$results = $this->model_catalog_vendor_product->getProductsByVendor($vendor_id);
		$data['vendor_name'] = $vendor_detail[0]['vendor_name'];
		/*echo '<pre>';
		print_r($vendor_detail[0]);
		echo '</pre>';*/
		foreach ($results as $result) {
			$data['vendors'][] = array(
				'vendor_id' => $result['vendor_id'],
				'price'		=>	$result['product_price'],
				'promo_code'	=>	$result['promo_code'],
				'vendor_name'          => $result['name'],
				'description'			=> $result['description'],

				'sort_order'     => $result['sort_order'],
				'view'			=>	$this->url->link('catalog/vendor_product/view', 'token=' . $this->session->data['token'] . '&vendor_id=' . $result['vendor_id'] . $url, true),
				'edit'           => $this->url->link('catalog/vendor_product/edit', 'token=' . $this->session->data['token'] . '&vendor_id=' . $result['vendor_id'] . '&vendor_checker_id=' . $result['vendor_checker_id'] . $url, true)
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
		$data['button_view'] = $this->language->get('button_view');
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

		$data['sort_title'] = $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);

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

		$this->response->setOutput($this->load->view('catalog/vendor_product_view', $data));
	}


	public function add() {
		$this->load->language('catalog/vendor_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/vendor_product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			//print_r($this->request->post);
			$data_form = array();
			$data_form = array(
				"vendor_id"		=>	$this->request->post['vendor_id'],		
				"product_id"	=>	$this->request->post['product_id'],	
				"product_price"	=>	$this->request->post['product_price'],
				"promo_code"	=> 	$this->request->post['promo_code'],
				"promo_price"	=>	$this->request->post['promo_price'],
				"status"		=>	$this->request->post['status'],
				"sort_order"	=>	$this->request->post['sort_order'],				
			);

			
			//echo '<pre>';
			//	print_r($data_form);
			//echo '</pre>';
			$this->model_catalog_vendor_product->addVendorProduct($data_form);

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
		$this->load->language('catalog/vendor_product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/vendor_product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_vendor_product->editVendorProduct($this->request->get['vendor_checker_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['vendor_product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_product_id'] = $this->language->get('entry_product_id');
		$data['entry_vendor_id'] = $this->language->get('entry_vendor_id');
		$data['entry_alias_url'] = $this->language->get('entry_alias_url');

		$data['entry_product_price'] = $this->language->get('entry_product_price');
		$data['entry_promo_code'] = $this->language->get('entry_promo_code');
		$data['entry_promo_price'] = $this->language->get('entry_promo_price');
		
		
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

		if (isset($this->error['vendor_id'])) {
			$data['error_vendor_id'] = $this->error['vendor_id'];
		} else {
			$data['error_vendor_id'] = array();
		}

		if (isset($this->error['product_id'])) {
			$data['error_product_id'] = $this->error['product_id'];
		} else {
			$data['error_product_id'] = array();
		}

		if (isset($this->error['product_price'])) {
			$data['error_product_price'] = $this->error['product_price'];
		} else {
			$data['error_product_price'] = array();
		}
		
		if (isset($this->error['promo_code'])) {
			$data['error_promo_code'] = $this->error['promo_code'];
		} else {
			$data['error_promo_code'] = array();
		}

		if (isset($this->error['promo_price'])) {
			$data['error_promo_price'] = $this->error['promo_price'];
		} else {
			$data['error_promo_price'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['vendor_product'])) {
			$url .= '&vendor_product=' . $this->request->get['vendor_product'];
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
			'href' => $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['vendor_checker_id'])) {
			$data['action'] = $this->url->link('catalog/vendor_product/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/vendor_product/edit', 'token=' . $this->session->data['token'] . '&vendor_checker_id=' . $this->request->get['vendor_checker_id'] . $url, true);
			//print_r($data['action']);
		}

		$data['cancel'] = $this->url->link('catalog/vendor_product', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['vendor_checker_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			//$vendor_info = $this->model_catalog_vendor_product->getVendor($this->request->get['vendor_checker_id']);
			$vendor_info = $this->model_catalog_vendor_product->getVendorProduct($this->request->get['vendor_checker_id']);
			$data['vendor_id'] = $this->request->get['vendor_id'];
			$product_id = $vendor_info[0]['product_id'];			
			$products = $this->model_catalog_vendor_product->getProduct($product_id);
			$vendors = $this->model_catalog_vendor_product->getVendor($this->request->get['vendor_id']);
			echo '<pre>';
			print_r($vendors);
			echo '</pre>';
			$data['vendors'] = $vendors;
			
		}else{
			$products = $this->model_catalog_vendor_product->getProducts();	
			$vendors = $this->model_catalog_vendor_product->getVendorsAll();
			$data['vendors'] = $vendors;
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['vendor_id'])) {
			$data['vendor_data'] = $this->request->post['vendor_id'];
		} elseif (isset($this->request->get['vendor_id'])) {

			$data['vendor_data'] = $this->model_catalog_vendor_product->getVendorId($this->request->get['vendor_id']);
			
		} else {
			$data['vendor_data'] = array();
		}

		$this->load->model('setting/store');

		/*$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['vendor_store'])) {
			$data['vendor_store'] = $this->request->post[' vendor_store'];
		} elseif (isset($this->request->get['vendor_id'])) {
			$data['vendor_store'] = $this->model_catalog_vendor->getVendorStores($this->request->get['vendor_id']);
		} else {
			$data['vendor_store'] = array(0);
		}*/
		
		//for products
			
		
		$data['products'] = $products;
		
		/*//for vendors
		$vendors = $this->model_catalog_vendor_product->getVendorsAll();
		$data['vendor_info'] = $vendor_info;*/
		
		if (isset($this->request->post['product_price'])) {
			$data['product_price'] = $this->request->post['product_price'];
		} elseif (!empty($vendor_info)) {
			$data['product_price'] = $vendor_info[0]['product_price'];
		} else {
			$data['product_price'] = '';
		}

		if (isset($this->request->post['promo_code'])) {
			$data['promo_code'] = $this->request->post['promo_code'];
		} elseif (!empty($vendor_info)) {
			$data['promo_code'] = $vendor_info[0]['promo_code'];
		} else {
			$data['promo_code'] = '';
		}

		if (isset($this->request->post['promo_price'])) {
			$data['promo_price'] = $this->request->post['promo_price'];
		} elseif (!empty($vendor_info)) {
			$data['promo_price'] = $vendor_info[0]['promo_price'];
		} else {
			$data['promo_price'] = '';
		}


		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($vendor_info)) {
			$data['status'] = $vendor_info[0]['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($vendor_info)) {
			$data['sort_order'] = $vendor_info[0]['sort_order'];
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
		
		$this->response->setOutput($this->load->view('catalog/vendor_product_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/vendor_product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

}