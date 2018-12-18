<?php
class ControllerDesignBossLayout extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('design/boss_layout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}
	public function apply(){
		$this->load->language('design/boss_layout');
		$json = array();
		$this->load->model('design/boss_layout');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()){
		
			if(isset($this->request->post['layout_id'])&&$this->request->post['layout_id']!=0){
				$this->model_design_boss_layout->editLayout($this->request->post['layout_id'], $this->request->post);
			}else{					
				$this->model_design_boss_layout->addLayout($this->request->post);
			}
			$json['success'] = $this->language->get('text_success');
		}else{
			if (isset($this->error['warning'])) {
				$json['error'] = $this->error['warning'];
			}
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function add() {
		$this->load->language('design/boss_layout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/boss_layout');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_boss_layout->addLayout($this->request->post);

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

			$this->response->redirect($this->url->link('design/boss_layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function edit() {
		$this->load->language('design/boss_layout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/boss_layout');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_boss_layout->editLayout($this->request->get['layout_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('design/boss_layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function delete() {
		$this->load->language('design/boss_layout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/boss_layout');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $layout_id) {
				$this->model_design_boss_layout->deleteLayout($layout_id);
			}

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

			$this->response->redirect($this->url->link('design/boss_layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
	
		$this->load->model('design/boss_layout');
		$this->load->model('setting/store');
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_layout.css');
		$this->document->addScript('view/javascript/bossthemes/ui/jquery-ui.min.js');
		$this->document->addScript('view/javascript/bossthemes/boss_layout.js');

		$layouts = array();
		
		$layouts = $this->model_design_boss_layout->getLayouts();

		foreach ($layouts as $layout) {
		
			$data['layouts'][] = array(
				'layout_id' => $layout['layout_id'],
				'name'      => $layout['name'],
				'edit'      => $this->url->link('design/boss_layout/edit', 'token=' . $this->session->data['token'] . '&layout_id=' . $layout['layout_id'] , 'SSL')
			);
		}

		$language_data = $this->load->language('design/boss_layout');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$data['module_manager'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('design/boss_layout', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		
		$data['layout_id'] = '';
		
		if (isset($this->request->get['layout_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$layout_info = $this->model_design_boss_layout->getLayout($this->request->get['layout_id']);			
			$data['layout_id'] = $this->request->get['layout_id'];
		}else{
			$data['layout_id'] = $layouts[0]['layout_id'];
		}	
		
		$data['action'] = $this->url->link('design/boss_layout/edit', 'token=' . $this->session->data['token'] . '&layout_id=' .$data['layout_id']. $url, 'SSL');

		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['add_module'] = $this->url->link('design/boss_layout/modules', 'token=' . $this->session->data['token'], 'SSL');
		$data['repair'] = $this->url->link('design/boss_layout', 'token=' . $this->session->data['token'], 'SSL');
		$data['stores'] = $this->model_setting_store->getStores();

		$data['layout_routes'] = array();
		
		if (isset($this->request->post['layout_route'])) {
			$data['layout_routes'] = $this->request->post['layout_route'];
		} else {
			$data['layout_routes'] = $this->model_design_boss_layout->getLayoutRoutes($data['layout_id']);
		}
		
		$data['modules'] = array();
		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('module');
				
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			$this->load->language('module/' . $code);
		
			$module_data = array();
			
			$modules = $this->model_extension_module->getModulesByCode($code);
			
			$setting_module = array();
			
			if(empty($modules)){
				$module_data[] = array(
					'name' => $this->language->get('heading_title'),
					'code' => $code,
					'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
					'status' => false
				);
			}else{
				foreach ($modules as $module) {
						$setting_module = json_decode($module['setting'], true);
						$module_data[] = array(
							'name' => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
							'code' => $code . '.' .  $module['module_id'],
							'edit'      => $this->url->link('module/' . $code, 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
							'status' => $setting_module['status']
						);
				}
			}
			if ($this->config->has($code . '_status') || $module_data) {
				$data['modules'][] = array(
					'name'   => $this->language->get('heading_title'),
					'code'   => $code,
					'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
					'module' => $module_data
				);
			}
		}
		
		$layout_modules_data = array();
		if (isset($this->request->post['layout_module'])) {
			$layout_modules_data = $this->request->post['layout_module'];
		} else {
			$layout_modules = $this->model_design_boss_layout->getLayoutModules($data['layout_id']);
			foreach ($layout_modules as $layout_module) {
				$arr_sort[] = $layout_module['sort_order'];
			}
			if(!empty($arr_sort)) {
				array_multisort($arr_sort,$layout_modules);
				foreach ($layout_modules as $layout_module) {
						$part = explode('.', $layout_module['code']);
						if(!isset($part[0])){
							$href = $this->url->link('module/' . $layout_module['code'], 'token=' . $this->session->data['token'], 'SSL');
						}elseif (isset($part[0]) && !isset($part[1])) {						
							$href = $this->url->link('module/' . $part[0], 'token=' . $this->session->data['token'], 'SSL');
						}else{						
							$href = $this->url->link('module/' . $part[0], 'token=' . $this->session->data['token'] . '&module_id=' . $part[1], 'SSL');
						}
						
						$layout_modules_data[] = array(
								'layout_id'	=>$layout_module['layout_id'],
								'name'		=>$this->module_name($layout_module['code']),
								'code'		=>$layout_module['code'],
								'href'		=>$href,
								'position'	=>$layout_module['position'],
								'sort_order'=>$layout_module['sort_order']
						);
				}
			}
		} 
		
		$data['layout_modules'] = 	$layout_modules_data;
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('design/bossthemes/layout_form.tpl', $data));
	}
	
	public function module_name($code){
		$return = '';
		$part = explode('.', $code);
		if (isset($part[0])){
			$this->load->language('module/' . $part[0]); 
		}else{
			$this->load->language('module/' . $code); 
		}
		if (isset($part[0]) && !isset($part[1])) {
			$return = $this->language->get('heading_title');
		}else{		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$part[1] . "'");
			if ($query->row) {
				$return = $this->language->get('heading_title') . ' &gt; ' . $query->row['name'];
			} 
		}
		return $return;
		
	}
	
	public function module_list(){
		$language_data = $this->load->language('design/boss_layout');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$data['position'] = 'content_top';
		if (isset($this->request->get['position'])) {
			$data['position'] = $this->request->get['position'];
		}
		
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		
		$data['modules'] = array();
		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('module');
				
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			$this->load->language('module/' . $code);
		
			$module_data = array();
			
			$modules = $this->model_extension_module->getModulesByCode($code);
			if(empty($modules)){
				$module_data[] = array(
					'name' => $this->language->get('heading_title'),
					'code' => $code,
					'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
				);
			}else{
				foreach ($modules as $module) {
						$module_data[] = array(
							'name' => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
							'code' => $code . '.' .  $module['module_id'],
							'edit'      => $this->url->link('module/' . $code, 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
						);
				}
			}
			if ($this->config->has($code . '_status') || $module_data) {
				$data['modules'][] = array(
					'name'   => $this->language->get('heading_title'),
					'code'   => $code,
					'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
					'module' => $module_data
				);
			}
		}
		$this->response->setOutput($this->load->view('design/bossthemes/module_list.tpl', $data));
		
	}
	
	public function modules() {		
		$this->document->addStyle('view/template/boss_layout/assets/layout.css');
		$this->document->addScript('view/template/boss_layout/assets/jquery-ui-1.10.4.custom.min.js');
		$this->document->addScript('view/template/boss_layout/assets/layout.js');
		
		$language_data = $this->load->language('design/boss_layout');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$data['position'] = 'content_top';
		if (isset($this->request->get['position'])) {
			$data['position'] = $this->request->get['position'];
		}
		
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		
		$data['modules'] = array();
		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('module');
				
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			$this->load->language('module/' . $code);
		
			$module_data = array();
			
			$modules = $this->model_extension_module->getModulesByCode($code);
			if(empty($modules)){
				$module_data[] = array(
					'name' => $this->language->get('heading_title'),
					'code' => $code,
					'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
				);
			}else{
				foreach ($modules as $module) {
						$module_data[] = array(
							'name' => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
							'code' => $code . '.' .  $module['module_id'],
							'edit'      => $this->url->link('module/' . $code, 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
						);
				}
			}
			if ($this->config->has($code . '_status') || $module_data) {
				$data['modules'][] = array(
					'name'   => $this->language->get('heading_title'),
					'code'   => $code,
					'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
					'module' => $module_data
				);
			}
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('boss_layout/modules.tpl', $data));
	}
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/boss_layout')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/boss_layout')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/information');

		foreach ($this->request->post['selected'] as $layout_id) {
			if ($this->config->get('config_layout_id') == $layout_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}

			$store_total = $this->model_setting_store->getTotalStoresByLayoutId($layout_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}

			$product_total = $this->model_catalog_product->getTotalProductsByLayoutId($layout_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}

			$category_total = $this->model_catalog_category->getTotalCategoriesByLayoutId($layout_id);

			if ($category_total) {
				$this->error['warning'] = sprintf($this->language->get('error_category'), $category_total);
			}

			$information_total = $this->model_catalog_information->getTotalInformationsByLayoutId($layout_id);

			if ($information_total) {
				$this->error['warning'] = sprintf($this->language->get('error_information'), $information_total);
			}
		}

		return !$this->error;
	}
	
	public function install() {
		//image_manager_status
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('visual_layout_composer_installed', array('visual_layout_composer_installed' => 1));
		/*Import XML*/ 
		$this->load->language('extension/installer');
		$error = array();

		$file = DIR_APPLICATION .  'view/template/boss_layout/install.xml';

		$this->load->model('extension/modification');
		
		// If xml file just put it straight into the DB
			$xml = file_get_contents($file);

			if ($xml) {
				try {
					$dom = new DOMDocument('1.0', 'UTF-8');
					$dom->loadXml($xml);
					
					$name = $dom->getElementsByTagName('name')->item(0);

					if ($name) {
						$name = $name->nodeValue;
					} else {
						$name = '';
					}
					
					$code = $dom->getElementsByTagName('code')->item(0);

					if ($code) {
						$code = $code->nodeValue;
						
						// Check to see if the modification is already installed or not.
						$modification_info = $this->model_extension_modification->getModificationByCode($code);
						
						if ($modification_info) {							
							$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%visual_layout_composer%'");
						}
					} else {
						$error['error'] = $this->language->get('error_code');
					}

					$author = $dom->getElementsByTagName('author')->item(0);

					if ($author) {
						$author = $author->nodeValue;
					} else {
						$author = '';
					}

					$version = $dom->getElementsByTagName('version')->item(0);

					if ($version) {
						$version = $version->nodeValue;
					} else {
						$version = '';
					}

					$link = $dom->getElementsByTagName('link')->item(0);

					if ($link) {
						$link = $link->nodeValue;
					} else {
						$link = '';
					}

					$modification_data = array(
						'name'    => $name,
						'code'    => $code,
						'author'  => $author,
						'version' => $version,
						'link'    => $link,
						'xml'     => $xml,
						'status'  => 1
					);
					
					if (!$error) {
						$this->model_extension_modification->addModification($modification_data);
					}
				} catch(Exception $exception) {
					$error['error'] = sprintf($this->language->get('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
				}
			}
	}
	
	public function uninstall() {			
		$this->db->query("DELETE FROM `" . DB_PREFIX. "setting` WHERE `key` = 'visual_layout_composer_installed'");			
		$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'visual_layout_composer'");	
		$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%visual_layout_composer%'");
	}

}