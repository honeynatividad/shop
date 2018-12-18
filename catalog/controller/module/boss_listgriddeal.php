<?php
class ControllerModuleBossListGridDeal extends Controller {
	public function index($setting) {//echo'<pre>';print_r($setting);echo'</pre>';
		static $module = 0;
		
		$data['heading_title'] = isset($setting['title'][$this->config->get('config_language_id')])?$setting['title'][$this->config->get('config_language_id')]:'';
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['template'] = $this->config->get('config_template');
		
		$this->load->language('module/boss_deals');
		
		$data['text_hours'] = $this->language->get('text_hours');
		$data['text_days'] = $this->language->get('text_days');
		$data['text_minutes'] = $this->language->get('text_minutes');
		$data['text_seconds'] = $this->language->get('text_seconds');
		$data['text_your_save'] = $this->language->get('text_your_save');
		
		$data['deals_filter'] = isset($setting['deals_filter'])?$setting['deals_filter']:'all';
		$data['show_countdown'] = isset($setting['show_countdown'])?$setting['show_countdown']:0;
		$data['auto_repeat'] = isset($setting['auto_repeat'])?$setting['auto_repeat']:1;
		$data['repeat_day'] = isset($setting['repeat_day'])?$setting['repeat_day']:1;
		$data['repeat_week'] = isset($setting['repeat_week'])?$setting['repeat_week']:1;
		$data['repeat_month'] = isset($setting['repeat_month'])?$setting['repeat_month']:1;
		$data['repeat_year'] = isset($setting['repeat_year'])?$setting['repeat_year']:1;
		$data['class_label'] = isset($setting['class_label'])?$setting['class_label']:'';
		
		$label_opening = $this->language->get('label_opening');
		$label_upcoming = $this->language->get('label_upcoming');
		$label_closed = $this->language->get('label_closed');
		
		$this->load->model('bossthemes/boss_deals');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$products = array();
	
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
		
		if(isset($setting['column'])){
			$data['column'] = $setting['column'];
		}else{
			$data['column'] = 4;
		}
		
		$data['listgridproducts'] = array();
		
		if (!empty($setting['boss_listgriddeal_module'])) {
			foreach($setting['boss_listgriddeal_module'] as $listgridproduct) {
				$title = (isset($listgridproduct['title'][$this->config->get('config_language_id')]) && $listgridproduct['title'][$this->config->get('config_language_id')])?$listgridproduct['title'][$this->config->get('config_language_id')]:'';
				
				$type_product = $listgridproduct['type_product'];
				$limit = isset($listgridproduct['limit'])?$listgridproduct['limit']:2;
				
				$deal_products = array();
				
				if ($type_product == "featured") {
					if(isset($listgridproduct['deal_products'])){
						$products = $listgridproduct['deal_products'];
					}else{
						$products = array();
					}
					
					if(!empty($products)){
						$products = array_slice($products, 0, $limit);
						foreach ($products as $product_id) {
							$product_info = $this->model_bossthemes_boss_deals->getProduct($product_id);
							$percent_p = false;
							if ($product_info) {
								if($product_info['special']){
									if ($product_info['image']) {
										//$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
										$module_label = $this->config->get('boss_label_products_setting');
										if(isset($module_label['deals_module']) && $module_label['deals_module'] == 1){	
											$this->load->model('bosslabelproducts/bossimage');
											$checklabel = $this->model_bosslabelproducts_bossimage->checkLabel($product_info['product_id']);
											if($checklabel == 1){
												$image = $this->model_bosslabelproducts_bossimage->label_resize($product_info['image'], $setting['image_width'], $setting['image_height'],$product_info['product_id']);					
											}else{
												$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
											}
										}else{
											$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
										}
										if(isset($module_label['deals_module_percent']) && $module_label['deals_module_percent'] == 1){ 
											$price_percent_p = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
											if ((float)$product_info['special']) { 
												$results_special_p = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')); 
											} else {
												$results_special_p = false;
											}
											if($results_special_p){ 
												if($price_percent_p!=0){
													$percent_p = round(abs($price_percent_p-$results_special_p)/$price_percent_p*100);
												}
											}
										}
									} else {
										$image = false;
									}

									if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
										$price_original = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
										$special_original = $price_original;
										$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
									} else {
										$price_original = 1 ;
										$special_original = 1;
										$price = false;
									}
									
									if ((float)$product_info['special']) {
										
										$special_original = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
										
										$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
										
									} else {
										$special_original = 1;
										$special = false;
									}
									
									$money_save_original = $price_original-$special_original;
									
									$money_save = $this->currency->format($money_save_original);
									
									$percent_original = round((float)($money_save_original/$price_original*100),2);
									
									if ($this->config->get('config_review_status')) {
										$rating = $product_info['rating'];
									} else {
										$rating = false;
									}
									
									$product_specials = $this->model_bossthemes_boss_deals->getProductSpecials($product_id);
									
									if(!empty($product_specials)){
										$date_end = '1970-01-01';
										$special_qty = 0;
										$special_status = $label_upcoming;
										foreach ($product_specials  as $product_special) {
											if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] <= date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
											
												$special_status = $label_opening;
												$date_end = $product_special['date_end'];
												$special = $this->currency->format($this->tax->calculate($product_special['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
												break;
											}else{
												if($product_special['date_start'] > date('Y-m-d')){
													$special_status = $label_upcoming.' <span class="small">('.$product_special['date_start'].')</span>';
													$date_end = $product_special['date_start'];
												}
												if($product_special['date_end'] <= date('Y-m-d')){
													$special_status = $label_closed.' <span class="small">('.$product_special['date_end'].')</span>';
													$date_end = '0000-00-00';
												}
												
												$special = $this->currency->format($this->tax->calculate($product_special['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
											}	
											
										}
										$countSell = $this->model_bossthemes_boss_deals->getCountSell($product_info['product_id']);
										if(isset($countSell['total']) && $countSell['total']){
											$numSell = $countSell['total'];
										}else{
											$numSell = 0;
										}
										$deal_products[] = array(
											'product_id' => $product_info['product_id'],
											'thumb'   	 => $image,
											'name'    	 => $product_info['name'],
											'price'   	 => $price,
											'special'   => $special,
											'minimum'   => $product_info['minimum'],
											'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200),
											'special_status' => $special_status,
											'date_end'   => $date_end,
											'special_qty'   => $special_qty,
											'money_save' 	 => $money_save,
											'percent_save' 	 => $percent_original,
											'rating'     => $rating,
											'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
											'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
											'percent'     => $percent_p,
											'count_sell'     => $numSell,
										);
									
									}
								}
								
							}
						}
					}
				}else if($type_product=='all' || $type_product=='category'){ 
					$products = array();
					$sort_product = isset($setting['sort_product'])?$setting['sort_product']:'';
					$sort = '';
					$order = 'ASC';
					if($sort_product == 'price_low'){
						$sort = 'ps.price';
						$order = 'ASC';
					}else if($sort_product == 'price_hight'){
						$sort = 'ps.price';
						$order = 'DESC';
					}else if($sort_product == 'p.sort_order'){
						$sort = 'p.sort_order';
						$order = 'ASC';
					}else{
						$sort = $sort_product;
						$order = 'DESC';
					}
					$filter_data = array();
					if($type_product == 'all'){
						$filter_data = array(
							'sort'  => $sort,
							'order' => $order,
							'start' => 0,
							'limit' => $limit
						);
						$products = $this->model_bossthemes_boss_deals->getAllProductSpecials($filter_data);	
					}else if($type_product == 'category'){ 
						$filter_data = array(
							'sort'  => $sort,
							'order' => $order,
							'start' => 0,
							'limit' => $limit,
							'category_id' => isset($listgridproduct['listgrid_type_category'])?$listgridproduct['listgrid_type_category']:0,
						);
						$products = $this->model_bossthemes_boss_deals->getAllProductSpecials($filter_data);
					}
					if(!empty($products)){
						foreach ($products as $product_info) {
							$percent_p = false;
							if ($product_info) {
								if($product_info['special']){
									if ($product_info['image']) {
										//$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
										$module_label = $this->config->get('boss_label_products_setting');
										if(isset($module_label['deals_module']) && $module_label['deals_module'] == 1){	
											$this->load->model('bosslabelproducts/bossimage');
											$checklabel = $this->model_bosslabelproducts_bossimage->checkLabel($product_info['product_id']);
											if($checklabel == 1){
												$image = $this->model_bosslabelproducts_bossimage->label_resize($product_info['image'], $setting['image_width'], $setting['image_height'],$product_info['product_id']);					
											}else{
												$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
											}
										}else{
											$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
										}
										if(isset($module_label['deals_module_percent']) && $module_label['deals_module_percent'] == 1){
											$price_percent_p = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
											if ((float)$product_info['special']) {
												$results_special_p = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
											} else {
												$results_special_p = false;
											}
											if($results_special_p){
												if($price_percent_p!=0){
													$percent_p = round(abs($price_percent_p-$results_special_p)/$price_percent_p*100);	
												}
											}
										}
									} else {
										$image = false;
									}

									if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
										$price_original = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
										$special_original = $price_original;
										$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
									} else {
										$price_original = 1 ;
										$special_original = 1;
										$price = false;
									}
									
									if ((float)$product_info['special']) {
										
										$special_original = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
										
										$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
										
									} else {
										$special_original = 1;
										$special = false;
									}
									
									$money_save_original = $price_original-$special_original;
									
									$money_save = $this->currency->format($money_save_original);
									
									$percent_original = round((float)($money_save_original/$price_original*100),2);
									
									if ($this->config->get('config_review_status')) {
										$rating = $product_info['rating'];
									} else {
										$rating = false;
									}
									
									$product_specials = $this->model_bossthemes_boss_deals->getProductSpecials($product_info['product_id']);
									
									if(!empty($product_specials)){
										$date_end = '1970-01-01';
										$special_qty = 0;
										$special_status = $label_upcoming;
										foreach ($product_specials  as $product_special) {
											if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] <= date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
											
												$special_status = $label_opening;
												$date_end = $product_special['date_end'];
												$special = $this->currency->format($this->tax->calculate($product_special['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
												break;
											}else{
												if($product_special['date_start'] > date('Y-m-d')){
													$special_status = $label_upcoming.' <span class="small">('.$product_special['date_start'].')</span>';
													$date_end = $product_special['date_start'];
												}
												if($product_special['date_end'] <= date('Y-m-d')){
													$special_status = $label_closed.' <span class="small">('.$product_special['date_end'].')</span>';
													$date_end = '0000-00-00';
												}
												
												$special = $this->currency->format($this->tax->calculate($product_special['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
											}	
											
										}
										$countSell = $this->model_bossthemes_boss_deals->getCountSell($product_info['product_id']);
										if(isset($countSell['total']) && $countSell['total']){
											$numSell = $countSell['total'];
										}else{
											$numSell = 0;
										}
										$deal_products[] = array(
											'product_id' => $product_info['product_id'],
											'thumb'   	 => $image,
											'name'    	 => $product_info['name'],
											'price'   	 => $price,
											'special'   => $special,
											'minimum'   => $product_info['minimum'],
											'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200),
											'special_status' => $special_status,
											'date_end'   => $date_end,
											'special_qty'   => $special_qty,
											'money_save' 	 => $money_save,
											'percent_save' 	 => $percent_original,
											'rating'     => $rating,
											'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
											'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
											'percent'     => $percent_p,
											'count_sell'     => $numSell,
										);
									
									}
								}
							}
						}
					}

				}
				$data['listgridproducts'][] = array(
					'title'	=> $title,
					'limit'	=> $limit,
					'per_row'	=> isset($listgridproduct['per_row'])?$listgridproduct['per_row']:2,
					'list_grid'	=> isset($listgridproduct['list_grid'])?$listgridproduct['list_grid']:0,
					'products'	=> $deal_products,
				);
				
			}
		}
		//echo'<pre>';print_r($data['listgridproducts']);echo'</pre>';die();
				
		$data['module'] = $module++;
		
		if ($data['listgridproducts']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_listgriddeal.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/boss_listgriddeal.tpl', $data);
			} else {
				return $this->load->view('default/template/module/boss_listgriddeal.tpl', $data);
			}
		}
	}
}
?>