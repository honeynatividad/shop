<?php
class ControllerModuleBossFeatured extends Controller {
	public function index($setting) {
		$this->load->language('module/boss_featured');
		$this->document->addScript('catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js');
		
		static $module = 0;
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['template'] = $this->config->get('config_theme');
		
		$data['title'] = isset($setting['title'][$this->config->get('config_language_id')])?$setting['title'][$this->config->get('config_language_id')]:'';
		
		$data['text_most_popular'] = $this->language->get('text_most_popular');
		
		$data['box_class_css'] = isset($setting['class_css'])?$setting['class_css']:'none-class';
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$mainproduct = array();
		$data['images'] = array();
		
		$products = array();
		
		if(isset($setting['show_pro_large']) && $setting['show_pro_large']){
		
			if (isset($setting['product_id'])) {
				$product_id = $setting['product_id'];
			}
			
			$product_info = array();
			
			$results = $this->model_catalog_product->getProductImages($product_id);
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
			
			foreach ($results as $result) {
				$data['images'][] = array(
					'thumb' => $this->model_tool_image->resize($result['image'], $img_width, $img_height)
				);
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
					'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'   	 => $price,
					'special' 	 => $special,
					'minimum' 	 => $product_info['minimum'],
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
				);
			}
		}
	
		if(isset($setting['limit'])){
			$limit = $setting['limit'];
		}else{
			$limit = 8;
		}
				
		if ($setting['type_product'] == "popular") {
			$results = $this->model_catalog_product->getPopularProducts($limit);
		}
		
		if ($setting['type_product'] == "special") {
			$data_sort = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $limit
			);
			$results = $this->model_catalog_product->getProductSpecials($data_sort);
		}
		if ($setting['type_product'] == "best_seller") {
			$results = $this->model_catalog_product->getBestSellerProducts($limit);
		}
		if ($setting['type_product'] == "latest") {
			$results = $this->model_catalog_product->getLatestProducts($limit);
		}
		if ($setting['type_product'] == "category") {
			$data_sort = array(
				'filter_category_id' => $setting['category_id'],
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $limit
			);
			$results = $this->model_catalog_product->getProducts($data_sort);
		}
		
		if ($setting['type_product'] == "featured") {
			if(isset($setting['product_featured'])){
				$pros_id = $setting['product_featured'];
			}else{
				$pros_id = array();
			}
			
			if(!empty($pros_id)){
				foreach ($pros_id as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {
						$results[$product_id] = $product_info;
					}
				}
			}
		}
		
		if(!empty($results)){
		
			if(isset($setting['image_width'])){
				$image_width = $setting['image_width'];
			}else{
				$image_width = 200;
			}
			
			if(isset($setting['image_height'])){
				$image_height = $setting['image_height'];
			}else{
				$image_height = 200;
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
					
					$money_save_original = $result['price'] - $result['special'];
					$percent = round((float)($money_save_original/$result['price']*100),0);
				} else {
					$special = false;
					$percent = false;
				}
							
				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}
					
				$products[] = array(
					'product_id' => $result['product_id'],
					'percent' 	 => $percent,
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'   	 => $price,
					'special' 	 => $special,
					'minimum' 	 => $result['minimum'],
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}
		}
		
		if(isset($image_width)){
			$data['image_width'] = $image_width;
		}else{
			$data['image_width'] = 200;
		}
		
		if(isset($setting['num_row'])){
			$data['num_row'] = $setting['num_row'];
		}else{
			$data['num_row'] = 2;
		}
		
		if(isset($setting['nav_type'])){
			$data['nav_type'] = $setting['nav_type'];
		}else{
			$data['nav_type'] = 0;
		}
		
		$data['num_row'] = $setting['num_row'];
		
		/*if($this->config->get('boss_featured'.$setting.'_position')=='column_left'||$this->config->get('boss_featured'.$setting.'_position')=='column_right'){
			$data['column'] = 'column';
		}else{
			$data['column'] = '';
		}*/
		
		$data['column'] = '';
		
		if(isset($setting['per_row'])){
			if(((int)$setting['per_row']) > 8){
				$data['per_row'] = 5;
			}else{
				$data['per_row'] = $setting['per_row'];
			}
		}else{
			$data['per_row'] = 5;
		}
		
		if(isset($setting['show_slider'])){
			$data['show_slider'] = $setting['show_slider'];
		}else{
			$data['show_slider'] = true;
		}
		
		$data['product_data'] = array();
		
		$data['product_data'] = array(
			'products'       => $products,
			'mainproduct'    => $mainproduct
		);
				
		$data['module'] = $module++;
				
		
		
			return $this->load->view('module/boss_featured', $data);
		
	}
}
?>