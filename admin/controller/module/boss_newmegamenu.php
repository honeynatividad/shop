<?php
class ControllerModuleBossNewmegamenu extends Controller {
	private $error = array(); 

	public function index() {   
		$this->load->language('module/boss_newmegamenu');

		$this->document->setTitle($this->language->get('breadcrumb_title'));
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_newmegamenu.css');
		$this->document->addStyle('view/stylesheet/bossthemes/colorpicker.css');
 
		$this->document->addScript('view/javascript/bossthemes/colorpicker.js');
		$this->document->addScript('view/javascript/bossthemes/eye.js');
		
		$this->document->addScript('view/javascript/bossthemes/ui/jquery-ui.min.js');
		$this->document->addStyle('view/javascript/bossthemes/ui/jquery-ui.min.css');
		

		$this->load->model('extension/module');
		
		$this->load->model('bossthemes/boss_newmegamenu');
		
		$this->load->model('tool/image');
		//load layout
		$this->load->model('design/layout');
		// check tables created or not
		//$this->model_bossthemes_boss_newmegamenu->install();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//$this->model_setting_setting->editSetting('boss_newmegamenu', $this->request->post);
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_newmegamenu', $this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
				$this->response->redirect($this->url->link('module/boss_newmegamenu', 'token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true));
			}
			
			/*$data_module = $this->request->post["boss_newmegamenu_module"];			
			$data_layout['layout_module'][] = array(
				'code'  => 'boss_newmegamenu',
				'position'  => $this->request->post["boss_newmegamenu_module"][0]['position'],
				'status'  => $this->request->post["boss_newmegamenu_status"],
				'sort_order'  => $this->request->post["boss_newmegamenu_module"][0]['sort_order'],
			);				
			$this->model_design_layout->editLayout($data_module[0]['layout_id'], $data_layout);
			*/
			

			
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_title_default'] = $this->language->get('text_title_default');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_menu_width'] = $this->language->get('entry_menu_width');
		$data['entry_num_column'] = $this->language->get('entry_num_column'); 
		$data['entry_store'] = $this->language->get('entry_store');
		$data['menu_form'] = $this->language->get('menu_form');
		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_add_menu'] = $this->language->get('button_add_menu');
		$data['button_add_column'] = $this->language->get('button_add_column');
		$data['button_add_row'] = $this->language->get('button_add_row');
		$data['button_remove'] = $this->language->get('button_remove');
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		$data['positions'] = array(
			/*"content_top" => $this->language->get('text_content_top'),
			"content_bottom" => $this->language->get('text_content_bottom'),
			"column_left" => $this->language->get('text_column_left'),
			"column_right" => $this->language->get('text_column_right'),*/
			'mainmenu' => $this->language->get('text_mainmenu')
		);
		
		$menu_column = 6;
		$i = 1;
		for($i;$i <= $menu_column;$i++){
			$data['arrcolumns'][$i] =  $i.' '.$this->language->get('text_column');
		}

		if (isset($this->session->data['error_warning'])) {
			$data['error_warning'] = $this->session->data['error_warning'];
			unset($this->session->data['error_warning']);
		} 
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
			unset($this->session->data['error_warning']);
		}
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/boss_newmegamenu', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_newmegamenu', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_newmegamenu', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		$data['token'] = $this->session->data['token'];
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}	
		//echo "<pre>"; print_r($module_info); echo "</pre>"; die();
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['boss_newmegamenu_module'])) {
			$data['module'] = $this->request->post['boss_newmegamenu_module'];
		}elseif (!empty($module_info)) {
			$data['module'] = $module_info['boss_newmegamenu_module'];
			$data['module_id'] = $this->request->get['module_id'];
			$data['menus'] = array();
		
			$menus = $this->model_bossthemes_boss_newmegamenu->getMenusByModuleId($this->request->get['module_id']);
			
			foreach($menus as $menu){
				$rows = array();
				$menurows = array();
				$rows = $this->model_bossthemes_boss_newmegamenu->getMenuRows($menu['menu_id']);
				foreach($rows as $row){
					$columns = array();
					$columns = $this->model_bossthemes_boss_newmegamenu->getMenuColumns($row['row_id']);
					$menurows[] = array(
						'row_id' => $row['row_id'],
						'status' => $row['status'],
						'columns' => $columns
					);
				}
				
				$data['menus'][] = array(
					'menu_id' => $menu['menu_id'],
					'status' => $menu['status'],
					'title' => $menu['title'],
					'url' => $menu['url'],
					'icon' => $this->model_tool_image->resize($menu['icon'], 20, 20),
					'icon_class_status' => $menu['icon_class_status'],
					'icon_class' => $menu['icon_class'],
					'label' => $menu['label'],
					'num_column' => $menu['num_column'],
					'menurow' => $menurows
					
				);
			}
		} else {
			$data['menus'] = array();
		}	
		
		
		//load store
		$this->load->model('setting/store');
		
		$stores = $this->model_setting_store->getStores();
		
		$data['stores'][0] = $this->language->get('text_default');
		
		foreach($stores as $store){
			$data['stores'][$store['store_id']] = $store['name'];
		}

		
		$layouts = array();
		
		$layouts = $this->model_design_layout->getLayouts();
		$data['layouts'][9999] = $this->language->get('all_page');
		/*foreach($layouts as $layout){
			$data['layouts'][$layout['layout_id']] = $layout['name'];
		}*/
		
		//load languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_newmegamenu', $data));
	}
	
	public function saveMenu(){
			
		$this->load->model('bossthemes/boss_newmegamenu');
			
		$this->load->language('module/boss_newmegamenu');
			
		$menudata = array();
			
		$json = array();
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			if (isset($this->request->post)) {
				$menudata = $this->request->post;
			}
			if (isset($this->request->get['menu_id']) && !empty($this->request->get['menu_id'])) {
				$this->model_bossthemes_boss_newmegamenu->editMenu($this->request->get['menu_id'],$menudata);
						
				$json['success'] = $this->language->get('entry_edit_success');
				$this->session->data['success'] = $this->language->get('entry_edit_success');
			}else{
				$this->model_bossthemes_boss_newmegamenu->addMenu($this->request->get['module_id'],$menudata);
						
				$json['success'] = $this->language->get('entry_add_success');
				$this->session->data['success'] = $this->language->get('entry_add_success');
			}
		}else{
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		$json['redirect'] = $this->url->link('module/boss_newmegamenu&token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}
	
	public function saveMenuRow(){
			
		$this->load->model('bossthemes/boss_newmegamenu');
			
		$this->language->load('module/boss_newmegamenu');
			
		$rowdata = array();
			
		$json = array();
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){	
			if (isset($this->request->post)) {
				$rowdata = $this->request->post;
			}
			if (isset($this->request->get['row_id']) && !empty($this->request->get['row_id'])) {
				$this->model_bossthemes_boss_newmegamenu->editMenuRow($this->request->get['row_id'],$rowdata);
						
				$json['success'] = $this->language->get('entry_edit_success');
				$this->session->data['success'] = $this->language->get('entry_edit_success');
			}else{
				$this->model_bossthemes_boss_newmegamenu->addMenuRow($this->request->get['menu_id'],$rowdata);
						
				$json['success'] = $this->language->get('entry_add_success');
				$this->session->data['success'] = $this->language->get('entry_add_success');
			}
		}else{
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		$json['redirect'] = $this->url->link('module/boss_newmegamenu&token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function saveMenuColumn(){
			
		$this->load->model('bossthemes/boss_newmegamenu');
			
		$this->load->language('module/boss_newmegamenu');
			
		$columndata = array();
			
		$json = array();
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			if (isset($this->request->post)) {
				$columndata = $this->request->post;
				
			}
			
			//load languages
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
			foreach ($languages as $language) {
				if(isset($this->request->post['content_text_'.$language['language_id']])) {
					$columndata['params']['content_text'][$language['language_id']] = $this->request->post['content_text_'.$language['language_id']];				
				}
			}
			
			if (isset($this->request->get['column_id']) && !empty($this->request->get['column_id'])) {
				$this->model_bossthemes_boss_newmegamenu->editMenuColumn($this->request->get['column_id'],$columndata);
						
				$json['success'] = $this->language->get('entry_edit_success');
				$this->session->data['success'] = $this->language->get('entry_edit_success');
			}else{
				$this->model_bossthemes_boss_newmegamenu->addMenuColumn($this->request->get['row_id'],$columndata);
						
				$json['success'] = $this->language->get('entry_add_success');
				$this->session->data['success'] = $this->language->get('entry_add_success');
			}
		}else{
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		$json['redirect'] = $this->url->link('module/boss_newmegamenu&token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function deleteMenu(){
		$json = array();
		$this->language->load('module/boss_newmegamenu');
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			if (isset($this->request->get['menu_id']) && !empty($this->request->get['menu_id'])) {
				$this->load->model('bossthemes/boss_newmegamenu');
				$this->model_bossthemes_boss_newmegamenu->deleteMenu($this->request->get['menu_id']);
				$this->session->data['success'] = $this->language->get('entry_delete_success');
			}
		}else{
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		$json['redirect'] = $this->url->link('module/boss_newmegamenu&token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function deleteMenuRow(){
		$json = array();
		$this->language->load('module/boss_newmegamenu');
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			if (isset($this->request->get['row_id']) && !empty($this->request->get['row_id'])) {
				$this->load->model('bossthemes/boss_newmegamenu');
				$this->model_bossthemes_boss_newmegamenu->deleteMenuRow($this->request->get['row_id']);
				$this->session->data['success'] = $this->language->get('entry_delete_success');
			}
		}else{
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		$json['redirect'] = $this->url->link('module/boss_newmegamenu&token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function deleteMenuColumn(){
		$json = array();
		$this->language->load('module/boss_newmegamenu');
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			if (isset($this->request->get['column_id']) && !empty($this->request->get['column_id'])) {
				$this->load->model('bossthemes/boss_newmegamenu');
				$this->model_bossthemes_boss_newmegamenu->deleteMenuColumn($this->request->get['column_id']);
				$this->session->data['success'] = $this->language->get('entry_delete_success');
				
			}
		}else{
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		$json['redirect'] = $this->url->link('module/boss_newmegamenu&token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function addMenu(){
			
		$this->load->model('bossthemes/boss_newmegamenu');
		
		$this->load->model('tool/image');
		
		if (isset($this->request->get['menu_id']) && !empty($this->request->get['menu_id'])) {
			$menu_id = $this->request->get['menu_id'];
			$data['menu_description'] = $this->model_bossthemes_boss_newmegamenu->getMenuDescription($menu_id);
			$menus = $this->model_bossthemes_boss_newmegamenu->getMenu($menu_id);
		} else {
			$data['menu_description'] = array();
			$menus = array();
		}
		
		if(!empty($menus)){
			$data['menus'] = array(
				'menu_id' => $menus['menu_id'],
				'url' => $menus['url'],
				'sort_order' => $menus['sort_order'],
				'label_color' => $menus['label_color'],
				'num_column' => $menus['num_column'],
				'icon' => $menus['icon'],
				'thumb' => $this->model_tool_image->resize($menus['icon'], 100, 100),
				'status' => $menus['status'],
				'icon_class_status' => $menus['icon_class_status'],
				'icon_class' => $menus['icon_class'],
			);
		}else{
			$data['menus'] = array();
		}
	
		$json = array();
		
		$this->language->load('module/boss_newmegamenu');
		
		$data['text_menu_title'] = $this->language->get('text_menu_title');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_url'] = $this->language->get('entry_url');
		$data['entry_icon'] = $this->language->get('entry_icon');
		$data['entry_icon_class'] = $this->language->get('entry_icon_class');
		$data['icon_class_css'] = $this->language->get('icon_class_css');
		$data['entry_label_color'] = $this->language->get('entry_label_color');
		$data['text_menu_label'] = $this->language->get('text_menu_label');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_title_default'] = $this->language->get('text_title_default');
		$data['entry_num_column'] = $this->language->get('entry_num_column');
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		
		$menusettings = $this->config->get('boss_newmegamenu_module');
		$menu_column = isset($menusettings[0]['num_column'])?$menusettings[0]['num_column']:6;
		$i = 1;
		for($i;$i <= $menu_column;$i++){
			$data['arrcolumns'][$i] =  $i.' '.$this->language->get('text_column');
		}
		
		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		//load languages
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
	
		$json['output'] = $this->load->view('module/boss_newmegamenu_addmenu', $data);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function addMenuRow(){
			
		$this->load->model('bossthemes/boss_newmegamenu');
		
		$this->load->model('tool/image');
		
		if (isset($this->request->get['row_id']) && !empty($this->request->get['row_id'])) {
			$row_id = $this->request->get['row_id'];
			$rows = $this->model_bossthemes_boss_newmegamenu->getMenuRow($row_id);
		} else {
			$rows = array();
		}
		
		if(!empty($rows)){
			$data['rows'] = array(
				'row_id' => $rows['row_id'],
				'menu_id' => $rows['menu_id'],
				'height' => $rows['height'],
				'sort_order' => $rows['sort_order'],
				'bg_color' => $rows['bg_color'],
				'bg_image' => $rows['bg_image'],
				'thumb' => $this->model_tool_image->resize($rows['bg_image'], 100, 100),
				'status' => $rows['status']
			);
		}else{
			$data['rows'] = array();
		}
	
		$json = array();
		
		$this->load->language('module/boss_newmegamenu');
		
		//$data['text_menu_title'] = $this->language->get('text_menu_title');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_menu_parent'] = $this->language->get('text_menu_parent');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_bg_color'] = $this->language->get('entry_bg_color');
		$data['entry_bg_image'] = $this->language->get('entry_bg_image');
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		
		$data['arrmenuid'] = array();
		
		$menus = $this->model_bossthemes_boss_newmegamenu->getMenus();
		
		foreach($menus as $menu){
			$data['arrmenuid'][$menu['menu_id']] = $menu['title'];
		}
		
		
		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
	
		$json['output'] = $this->load->view('module/boss_newmegamenu_addrow', $data);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function addMenuColumn(){
			
		$this->load->model('bossthemes/boss_newmegamenu');
		
		$this->load->model('tool/image');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/information');
		$this->load->model('localisation/language');
		
		if (isset($this->request->get['column_id']) && !empty($this->request->get['column_id'])) {
			$column_id = $this->request->get['column_id'];
			$columns = $this->model_bossthemes_boss_newmegamenu->getMenuColumn($column_id);
		} else {
			$columns = array();
		}
		
		if(!empty($columns)){
			$data['columns'] = array(
				'row_id' => $columns['row_id'],
				'column_id' => $columns['column_id'],
				'num_column' => $columns['num_column'],
				'sort_order' => $columns['sort_order'],
				'type' => $columns['type'],
				'params' => $columns['params'],
				'status' => $columns['status']
			);
			$data['products_name'] = array();
			
			if(isset($columns['params'])){
				$params = json_decode($columns['params'], true);
			}else{
				$params = array();
			}
			if(isset($params['product_ids'])){
				foreach ($params['product_ids'] as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);
					if ($product_info) {
						$data['products_name'][$product_id] = $product_info['name'];
					}
				}
			}
		}else{
			$data['columns'] = array();
		}
	
		$json = array();
		
		$this->load->language('module/boss_newmegamenu');
		
		//$data['text_menu_title'] = $this->language->get('text_menu_title');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_menu_parent'] = $this->language->get('text_menu_parent');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_bg_color'] = $this->language->get('entry_bg_color');
		$data['entry_bg_image'] = $this->language->get('entry_bg_image');
		$data['entry_num_column'] = $this->language->get('entry_num_column');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['text_choose_category'] = $this->language->get('text_choose_category');
		$data['text_root_category'] = $this->language->get('text_root_category');
		$data['text_w_x_h'] = $this->language->get('text_w_x_h');
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);	
		
		if (isset($this->request->get['row_id']) && !empty($this->request->get['row_id'])) {
			$row_id = $this->request->get['row_id'];
			$rows = $this->model_bossthemes_boss_newmegamenu->getMenuRow($row_id);
		} else {
			$rows = array();
		}
		
		$menus = $this->model_bossthemes_boss_newmegamenu->getMenu($rows['menu_id']);
		
		$row_column = $menus['num_column'];
		$i = 1;
		for($i;$i <= $row_column;$i++){
			$data['arrcolumns'][$i] =  $i.' '.$this->language->get('text_column');
		}
		
		$data['arrtypes'] = array(
			'category' => $this->language->get('entry_type_category'),
			'information' => $this->language->get('entry_type_information'),
			'product' => $this->language->get('entry_type_product'),
			'manufacturer' => $this->language->get('entry_type_manufacturer'),
			'html'  => $this->language->get('entry_type_html')
		);
		
		$data['token'] = $this->session->data['token'];
		
		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['categories'] = $this->model_catalog_category->getCategories(0);
		
		$results = $this->model_catalog_manufacturer->getManufacturers();
		
		foreach ($results as $result) {
			$data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'name'       	  => $result['name']
			);
		}
		
		$data['informations'] = $this->model_catalog_information->getInformations();
		
		$json['output'] = $this->load->view('module/boss_newmegamenu_addcolumn', $data);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
		
	}

	public function updateSortMenu(){
	
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			$array	= $this->request->post;

			if ($array['update'] == "update"){
				
				$this->load->model('bossthemes/boss_newmegamenu');
				
				$this->model_bossthemes_boss_newmegamenu->updateSortMenu($array['menuorder']);
			
				echo '<div class="alert alert-success">All saved! refresh the page to see the changes</div>';
			}
		}else{
			echo '<div class="alert alert-danger">Warning: You do not have permission to modify this module!</div>';
		}
	}
	
	public function updateSortRow(){
	
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			$array	= $this->request->post;

			if ($array['update'] == "update"){
				
				$this->load->model('bossthemes/boss_newmegamenu');
				
				$this->model_bossthemes_boss_newmegamenu->updateSortRow($array['menuid'][0],$array['roworder']);
			
				echo '<div class="alert alert-success">All saved! refresh the page to see the changes</div>';
			}
		}else{
			echo '<div class="alert alert-danger">Warning: You do not have permission to modify this module!</div>';
		}
	}
	
	public function updateSortColumn(){
	
		if($this->user->hasPermission('modify', 'module/boss_newmegamenu')){
			$array	= $this->request->post;

			if ($array['update'] == "update"){
				
				$this->load->model('bossthemes/boss_newmegamenu');
				
				$this->model_bossthemes_boss_newmegamenu->updateSortColumn($array['rowid'][0],$array['columnorder']);
			
				echo '<div class="alert alert-success">All saved! refresh the page to see the changes</div>';
			}
		}else{
			echo '<div class="alert alert-danger">Warning: You do not have permission to modify this module!</div>';
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_newmegamenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;	
	}
	public function install(){
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu'";
		$query = $this->db->query( $sql );
		if( count($query->rows) > 0 ){
			
			$sql="delete from `".DB_PREFIX."megamenu`";
			$query = $this->db->query( $sql );
		}
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu_column'";
		$query = $this->db->query( $sql );
		if( count($query->rows) > 0 ){
			
			$sql="delete from `".DB_PREFIX."megamenu_column`";
			$query = $this->db->query( $sql );
		}
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu_description'";
		$query = $this->db->query( $sql );
		if( count($query->rows) > 0 ){
			
			$sql="delete from `".DB_PREFIX."megamenu_description`";
			$query = $this->db->query( $sql );
		}
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu_row'";
		$query = $this->db->query( $sql );
		if( count($query->rows) > 0 ){
			
			$sql="delete from `".DB_PREFIX."megamenu_row`";
			$query = $this->db->query( $sql );
		}
		$sql = array();
		$sql[]  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu` (
			  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `icon` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `label_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `num_column` int(2) unsigned DEFAULT '1',
			  `icon_class` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
			  `icon_class_status` tinyint(1) NOT NULL DEFAULT '1',
			  `module_id` int(11) NOT NULL,
			  PRIMARY KEY (`menu_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;";
		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_column` (
			`column_id` int(11) NOT NULL AUTO_INCREMENT,
			`row_id` int(11) NOT NULL,
			`sort_order` int(3) NOT NULL DEFAULT '0',
			`status` tinyint(1) NOT NULL,
			`num_column` int(2) unsigned NOT NULL DEFAULT '1',
			`type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			`params` text COLLATE utf8_unicode_ci,
			PRIMARY KEY (`column_id`,`row_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;";
		
		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_description` (
			`menu_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
		  PRIMARY KEY (`menu_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;";

		$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_row` (
			`row_id` int(11) NOT NULL AUTO_INCREMENT,
		  `menu_id` int(11) NOT NULL,
		  `sort_order` int(3) NOT NULL DEFAULT '0',
		  `status` tinyint(1) NOT NULL,
		  `height` decimal(10,0) DEFAULT NULL,
		  `bg_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `bg_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  PRIMARY KEY (`row_id`,`menu_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;";
		
		foreach( $sql as $q ){
			$query = $this->db->query( $q );
		}
			
	}
	public function uninstall() {
		$this->db->query("DROP TABLE `" . DB_PREFIX . "megamenu`, `" . DB_PREFIX . "megamenu_column`, `" . DB_PREFIX . "megamenu_description`, `" . DB_PREFIX . "megamenu_row`");
	}
}
?>