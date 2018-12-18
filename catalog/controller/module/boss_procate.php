<?php
class ControllerModuleBossProcate extends Controller {
	public function index($setting) {
		static $module = 0;
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['template'] = $this->config->get('config_theme');
		
		$data['heading_title'] = isset($setting['title'][$this->config->get('config_language_id')])?$setting['title'][$this->config->get('config_language_id')]:'';
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('tool/image');
		
		$mainproduct = array();
		
		$data['product_datas'] = array();
		
		if(isset($setting['limit'])){
			$limit = $setting['limit'];
		}else{
			$limit = 8;
		}
		
		if(isset($setting['category_id']) && !empty($setting['category_id'])){
		
			foreach($setting['category_id'] as $category_id){
			
				$results = array();
				
				$products = array();
				
				$category_info = $this->model_catalog_category->getCategory($category_id);
				
				$data_sort = array(
					'filter_category_id' => $category_id,
					'sort'  => 'pd.name',
					'order' => 'ASC',
					'start' => 0,
					'limit' => $limit
				);
				
				$results = $this->model_catalog_product->getProducts($data_sort);
				
				if(!empty($results)){
				
					if(isset($setting['show_pro_large']) && $setting['show_pro_large']){
					
					foreach ($results as $result) {
				
						$product_id = 42;
				
						$product_info = array();
						
						$product_info = $this->model_catalog_product->getProduct($product_id);
						
						if(isset($setting['img_width'])){
							$img_width = $setting['img_width'];
						}else{
							$img_width = 380;
						}
						
						if(isset($setting['img_height'])){
							$img_height = $setting['img_height'];
						}else{
							$img_height = 380;
						}
						
						if (!empty($product_info)) {
							if ($product_info['image']) {
								$image = $this->model_tool_image->resize($product_info['image'], $img_width, $img_height);
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
										
							if ($this->config->get('config_review_status')) {
								$rating = $product_info['rating'];
							} else {
								$rating = false;
							}
										
										
							$mainproduct = array(
								'product_id' => $product_info['product_id'],
								'thumb'   	 => $image,
								'name'    	 => $product_info['name'],
								'price'   	 => $price,
								'special' 	 => $special,
								'rating'     => $rating,
								'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
								'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
							);
						}
					}
					}
				
					if(isset($setting['image_width'])){
						$image_width = $setting['image_width'];
					}else{
						$image_width = 180;
					}
					
					if(isset($setting['image_height'])){
						$image_height = $setting['image_height'];
					}else{
						$image_height = 180;
					}
				
					foreach ($results as $result) {
					
						
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
						} else {
							$image = false;
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
									
						if ($this->config->get('config_review_status')) {
							$rating = $result['rating'];
						} else {
							$rating = false;
						}
									
									
						$products[] = array(
							'product_id' => $result['product_id'],
							'thumb'   	 => $image,
							'name'    	 => $result['name'],
							'price'   	 => $price,
							'special' 	 => $special,
							'rating'     => $rating,
							'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
							'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
						);
					}
				}
				
				
			
				$data['product_datas'][] = array(
					'title'     	 => isset($category_info['name'])?$category_info['name']:'',
					'products'       => $products,
					'mainproduct'    => $mainproduct
				);
		
			}
		}
	
		if(isset($image_width)){
			$data['image_width'] = $image_width;
		}else{
			$data['image_width'] = 200;
		}
		
		if(isset($setting['nav_type'])){
			$data['nav_type'] = $setting['nav_type'];
		}else{
			$data['nav_type'] = 0;
		}
		
		$data['column'] = '';
		
		if(isset($setting['type_display'])&& ($setting['type_display'] =='use_column')){
			$data['per_row'] = 1;
		}else if(isset($setting['per_row'])){
			$data['per_row'] = $setting['per_row'];
		}else {
			$data['per_row'] = 5;
		}
		
		if(isset($setting['type_display'])){
			$data['type_display'] = $setting['type_display'];
		}else{
			$data['type_display'] = 'block';
		}
		
		if(isset($setting['num_row'])){
			$data['num_row'] = $setting['num_row'];
		}else{
			$data['num_row'] = 1;
		}
		
		if(isset($setting['show_slider'])){
			$data['show_slider'] = $setting['show_slider'];
		}else{
			$data['show_slider'] = true;
		}
		
		$data['module'] = $module++;
				
				
		
			return $this->load->view('module/boss_procate', $data);
		
	}
}
?>