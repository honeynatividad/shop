<?php
class ControllerModuleBossProductCategory extends Controller {
	public function index($setting) {//echo'<pre>';print_r($setting);echo'</pre>';die();
		static $module = 0;
		
		$this->load->model('tool/image');
		
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
				
		$data['heading_title'] = isset($setting['title'][$this->config->get('config_language_id')])?$setting['title'][$this->config->get('config_language_id')]:'';
		$data['image_width'] = isset($setting['image_width'])?$setting['image_width']:210;
		
		$data['type'] = isset($setting['type'])?$setting['type']:0;
		$data['image_width'] = isset($setting['image_width'])?$setting['image_width']:270;
		$data['image_height'] = isset($setting['image_height'])?$setting['image_height']:320;
		
		$data['image'] = (isset($setting['bgimage'])&&$setting['bgimage'])? HTTP_SERVER . 'image/'.$setting['bgimage']:'';
		
		$menus = array();
		
		$menus = $setting['boss_productcategory_config'];
		
		$data['menus'] = array();
		
		if(isset($menus) && !empty($menus)){
		
			$sort_order = array(); 
			
			foreach ($menus as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			
			array_multisort($sort_order, SORT_ASC, $menus);
	
			foreach ($menus as $menu) {//echo'<pre>';print_r($menu);echo'</pre>';die();
				if($menu['status']){
					if (isset($menu['icon']) && file_exists(DIR_IMAGE . $menu['icon'])) {
						$icon = $this->model_tool_image->resize($menu['icon'], 20, 25);
					} else {
						$icon = $this->model_tool_image->resize('no_image.jpg', 20, 25);
					}
					
					$categories = array();
					
					if(isset($menu['category_id'])){
						$category_id = $menu['category_id'];
					}else{
						$category_id = '';
					}
					$products = array();
					if($category_id!=''){
					
						/*$results = $this->model_catalog_category->getCategories($category_id);
						
						foreach ($results as $category) {
							$categories[] = array(
								'name'     		=> $category['name'],
								'children'		=> $this->getChildrenCategory($category, $category['category_id']),
								'href'     		=> $this->url->link('product/category', 'path=' . $category['category_id'])
							);
						}*/
						
						$filter_data = array(
							'filter_category_id' => $category_id,
							'filter_filter'      => '',
							'sort'               => 'p.sort_order',
							'order'              => 'ASC',
							'start'              => '0',
							'limit'              => isset($setting['limit'])?$setting['limit']:'6',
						);
						
						$product_infos = $this->model_catalog_product->getProducts($filter_data);
						
						if (!empty($product_infos)) {
							foreach ($product_infos as $result) {
								if ($result['image']) {
									$image = $this->model_tool_image->resize($result['image'], $data['image_width'], $data['image_height']);
								} else {
									$image = $this->model_tool_image->resize('placeholder.png', $data['image_width'], $data['image_height']);
								}

								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
								} else {
									$price = false;
								}

								if ((float)$result['special']) {
									$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
								} else {
									$special = false;
								}

								if ($this->config->get('config_tax')) {
									$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
								} else {
									$tax = false;
								}

								if ($this->config->get('config_review_status')) {
									$rating = (int)$result['rating'];
								} else {
									$rating = false;
								}

								$products[] = array(
									'product_id'  => $result['product_id'],
									'thumb'       => $image,
									'name'        => $result['name'],
									'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 50) . '..',
									'price'       => $price,
									'special'     => $special,
									'tax'         => $tax,
									'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
									'rating'      => $result['rating'],
									'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
								);
							}
						}
					}	
//echo'<pre>';print_r($products);echo'</pre>';die();

					$data['menus'][] = array(
						'title' => $menu['title'][$this->config->get('config_language_id')],
						'icon'      => $icon,
						/*'categories' => $categories,*/
						'products' => $products,
						'category_id'      => $menu['category_id'],
						'per_row'      => $menu['per_row'],
						'sort_order'     => $menu['sort_order'],
						'href'     		=> $this->url->link('product/category', 'path=' . $menu['category_id'])
					);	
				}
			}
		
		}
		$data['module'] = $module++;
		//echo'<pre>';print_r($data['menus']);echo'</pre>';die();
		if ($data['menus']) {
			
				return $this->load->view('module/boss_productcategory', $data);
			
		}
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