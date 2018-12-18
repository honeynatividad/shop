<?php
class ControllerModuleBossFilterProduct extends Controller {
	public function index($setting) {
		if(empty($setting))	return;
		static $module = 0;
		
		$this->document->addScript('catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js');
		$this->document->addScript('catalog/view/javascript/bossthemes/getwidthbrowser.js');
		$this->document->addScript('catalog/view/javascript/bossthemes/boss_filterproduct/boss_filterproduct.js');
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/boss_filterproduct.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/boss_filterproduct.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_filterproduct.css');
		}
		
		$this->load->language('module/boss_filterproduct');
		
		//get config
		$data['use_scrolling_panel'] = $setting['boss_filterproduct_module']['use_scrolling_panel'];
		$data['use_tab'] = $setting['boss_filterproduct_module']['use_tab'];
		$data['num_row'] = $setting['boss_filterproduct_module']['numrow'];
		$data['per_row'] = $setting['boss_filterproduct_module']['perrow'];
		$data['width_column'] = $setting['boss_filterproduct_module']['column'];
		$data['class_css'] = $setting['boss_filterproduct_module']['class_css'];
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_detail'] = $this->language->get('button_detail');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['template'] = $this->config->get('config_theme');
		$data['image_width'] = $setting['boss_filterproduct_module']['image_width']; 
		$data['image_height'] = $setting['boss_filterproduct_module']['image_height'];
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		//load tab for module
		if(isset($setting['boss_filterproduct_module']['tabs']))
		{
			foreach ($setting['boss_filterproduct_module']['tabs'] as $tab) {
				//
				if (isset($tab['icon']) && file_exists(DIR_IMAGE . $tab['icon'])) {
					$icon = $this->model_tool_image->resize($tab['icon'], 39, 28);
				} else {
					$icon = $this->model_tool_image->resize('no_image.jpg', 39, 28);
				}
				//echo'<pre>';print_r($icon);echo'</pre>';
				$results = array();
				if ($tab['type_product'] == "popular") {
					$results = $this->model_catalog_product->getPopularProducts($setting['boss_filterproduct_module']['limit']);
				}
				if ($tab['type_product'] == "special") {
					$data_sort = array(
						'sort'  => 'pd.name',
						'order' => 'ASC',
						'start' => 0,
						'limit' => $setting['boss_filterproduct_module']['limit']
					);
					$results = $this->model_catalog_product->getProductSpecials($data_sort);
				}
				if ($tab['type_product'] == "best_seller") {
					$results = $this->model_catalog_product->getBestSellerProducts($setting['boss_filterproduct_module']['limit']);
				}
				if ($tab['type_product'] == "latest") {
					$results = $this->model_catalog_product->getLatestProducts($setting['boss_filterproduct_module']['limit']);
				}
				if ($tab['type_product'] == "category") {
					$data_sort = array(
						'filter_category_id' => $tab['filter_type_category'],
						'sort'  => 'pd.name',
						'order' => 'ASC',
						'start' => 0,
						'limit' => $setting['boss_filterproduct_module']['limit']
					);
					$results = $this->model_catalog_product->getProducts($data_sort);
				}
				
				if ($tab['type_product'] == "featured") {
					if(isset($tab['product_featured'])){
						$pros_id = $tab['product_featured'];
					}else{
						$pros_id = array();
					}
					foreach ($pros_id as $product_id) {
						$product_info = $this->model_catalog_product->getProduct($product_id);

						if ($product_info) {
							$results[$product_id] = $product_info;
						}
					}
				}
				
				$products = array();
				
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['boss_filterproduct_module']['image_width'], $setting['boss_filterproduct_module']['image_height']);
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
						'minimum' 	 => $result['minimum'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 140),
						'rating'     => $rating,
						'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
						'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					);
				}
				$data['tabs'][] = array(
						'title'	 		 =>	isset($tab['title'][$this->config->get('config_language_id')])?$tab['title'][$this->config->get('config_language_id')]:'',
						'icon' => $icon,
						'products'       => $products,
					);
				
			}
		} //end load tabs for module
		
		
		
		$data['module'] = $module++;
		
		
		
			return $this->load->view('module/boss_filterproduct', $data);
		
	}
}
?>