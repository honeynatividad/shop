<?php
class ControllerModuleBossNewMegamenu extends Controller {

	public function index($setting) {
		if(empty($setting)) return;
		$this->load->model('bossthemes/boss_newmegamenu');
		$this->load->model('tool/image');
		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/information');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		
		//$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_theme').'/stylesheet/bossthemes/boss_megamenu.css');
		
		$boss_setting = $setting['boss_newmegamenu_module'];
		$data['menus'] = array();
		
		$menusettings = array();
		$menusettings = $setting['boss_newmegamenu_module'];
		$menu_width = $menusettings['menu_width'];
		$data['menu_column'] = $menusettings['num_column'];
		
		$menus = $this->model_bossthemes_boss_newmegamenu->getMenusByModuleId($menusettings['module_id']);
		
		foreach($menus as $menu){
			$rows = array();
			$menurows = array();
			$rows = $this->model_bossthemes_boss_newmegamenu->getMenuRows($menu['menu_id']);
			foreach($rows as $row){
				$columns = array();
				$coldata = array();
				$columndatas = $this->model_bossthemes_boss_newmegamenu->getMenuColumns($row['row_id']);
				foreach($columndatas as $column){
					$type = $column['type'];
					$params = json_decode($column['params'], true);
					if (isset($type)) {
						if ($type == 'manufacturer') {
							$result = array();
							$coldata = array();
							foreach($params['manufacturer_id'] as $manufacturer_id){
								$result = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
								if(isset($result) && !empty($result)){
									$coldata[] = array(
										'name'    => $result['name'],
										'image'   => $this->model_tool_image->resize($result['image'], ($params['manufacturer_img_w']) ? $params['manufacturer_img_w'] : 45, ($params['manufacturer_img_h']) ? $params['manufacturer_img_h'] : 45),
										'href'	  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']),
										'show_name'  => $params['manufacturer_name'],
										'li_width'	 => ($menu_width/$column['num_column'])
									);
								}else{
									$coldata[] = array();
								}
							}
						}
						
						if ($type == 'information') {
							$result = array();
							$coldata = array();
							foreach($params['information_id'] as $information_id){
								$result = $this->model_catalog_information->getInformation($information_id);
								if(isset($result) && !empty($result)){
									$coldata[] = array(
										'title' => $result['title'],
										'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
									);
								}else{
									$coldata[] = array();
								}
							}
						}
						
						if ($type == 'product') {
							$result = array();
							$coldata = array();
							if(isset($params['product_ids']) && !empty($params['product_ids'])){
								foreach ($params['product_ids'] as $product_id) {
									$product_info = $this->model_catalog_product->getProduct($product_id);
									if (isset($product_info) && !empty($product_info)) {
										if ($product_info['image']) {
											$image = $this->model_tool_image->resize($product_info['image'], isset($params['product_img_w']) ? $params['product_img_w'] : 45, isset($params['product_img_h']) ? $params['product_img_h'] : 45);
										} else {
											$image = false;
										}

										if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
											$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
										} else {
											$price = false;
										}
										
										if ((float)$product_info['special']) {
											$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
										} else {
											$special = false;
										}	
										
										if ($this->config->get('config_tax')) {
											$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
										} else {
											$tax = false;
										}		
										
										$coldata[] = array(
											'thumb'   	 => $image,
											'name'    	 => isset($product_info['name'])?$product_info['name']:'',
											'price'   	 => $price,
											'special'     => $special,
											'li_width'	 => ($menu_width/$column['num_column']),
											'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
										);
									}
								}
							}
						}
						
						if ($type == 'category') {
							$result = array();
							$coldata = array();
							$category_id = $params['category_id'];
							if(isset($category_id) && ($category_id)){
								
								if ($category_id != 0) {
									$category_info = $this->model_catalog_category->getCategory($category_id);
									if(isset($category_info) && !empty($category_info)){
										$parent = array(
											'name'     		=> isset($category_info['name'])?$category_info['name']:'',
											'href'     		=> $this->url->link('product/category', 'path=' . $category_info['category_id'])
										);
									}else{
										$parent = array();
									}
								}else{
									$parent = array(
										'name'     		=> '',
										'href'     		=> ''
									);
								}
								
								$results = $this->model_catalog_category->getCategories($category_id);
								
								if (isset($results) && !empty($results)) {
									foreach ($results as $category) {
										$coldata[] = array(
											'name'     		=> isset($category['name'])?$category['name']:'',
											'children'		=> $this->getChildrenCategory($category, $category['category_id']),
											'href'     		=> $this->url->link('product/category', 'path=' . $category['category_id'])
										);
									}
								}
							}
						}
						
						if ($type == 'html') {
							$coldata = array();
							$coldata =  html_entity_decode($params['content_text'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');							
						}
					}
					$columns[] = array(
						'column_id' => $column['column_id'],
						'sub_title' => isset($params['sub_title'][$this->config->get('config_language_id')])?$params['sub_title'][$this->config->get('config_language_id')]:'',
						'status' => $column['status'],
						'num_column' => $column['num_column'],
						'type' => $column['type'],
						'coldata' => $coldata,
						'parent'  => (isset($parent) ? $parent : null),
					);
					
				}
				
				if (!empty($row['bg_image']) && file_exists(DIR_IMAGE . $row['bg_image'])) {
					$rowbg = 'image/'.$row['bg_image'];
				} else {
					$rowbg = false;
				}
				
				$menurows[] = array(
					'row_id' => $row['row_id'],
					'status' => $row['status'],
					'bg_image' => $rowbg,
					'bg_color' => $row['bg_color'],
					'columns' => $columns
				);
			}
			
			if ($menu['icon']) {
				$icon = $this->model_tool_image->resize($menu['icon'], 20,20);
			} else {
				$icon = false;
			}
			
			$data['menus'][] = array(
				'menu_id' => $menu['menu_id'],
				'url' => $menu['url'],
				'title' => $menu['title'],
				'label' => $menu['label'],
				'num_column' => $menu['num_column'],
				'sort_order' => $menu['sort_order'],
				'label_color' => $menu['label_color'],
				'icon' => $menu['icon'],
				'thumb' => $icon,
				'status' => $menu['status'],
				'icon_class_status' => $menu['icon_class_status'],
				'icon_class' => $menu['icon_class'],
				'menurow' => $menurows
			);
		}
	
		
		
			return $this->load->view('module/boss_newmegamenu', $data);
		
		
	}
	
	private function getChildrenCategory($category, $path){
		$children_data = array();
		$children = $this->model_catalog_category->getCategories($category['category_id']);
		
		foreach ($children as $child) {
			$data = array(
				'filter_category_id'  => $child['category_id'],
				'filter_sub_category' => true	
			);		
								
			$children_data[] = array(
				'name'  	=> $child['name'],
				'children' 	=> $this->getChildrenCategory($child, $path . '_' . $child['category_id']),
				'href'  => $this->url->link('product/category', 'path=' . $path . '_' . $child['category_id'])	
			);
			
		}
		return $children_data;
	}
}
?>