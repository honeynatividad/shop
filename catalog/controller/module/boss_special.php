<?php
class ControllerModuleBossSpecial extends Controller {
	public function index($setting) {
	//echo'<pre>';print_r($setting);echo'</pre>';die();
		static $module = 0;
		
		$this->load->language('module/boss_special');
		
		$data['text_hours'] = $this->language->get('text_hours');
		$data['text_days'] = $this->language->get('text_days');
		$data['text_minutes'] = $this->language->get('text_minutes');
		$data['text_seconds'] = $this->language->get('text_seconds');
		$data['text_your_save'] = $this->language->get('text_your_save');
		
		$data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
		
		$data['slider_setting'] = array();
		$data['show_closed'] = $setting['show_closed'];
		$data['slider_setting'] = $this->config->get('slider_setting');
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		
		$label_setting = array();
		
		$label_setting = $this->config->get('boss_special_label_setting');
		
		$data['button_cart'] = $this->language->get('button_cart');
		
		$label_opening = $this->language->get('label_opening');
		$label_upcoming = $this->language->get('label_upcoming');
		$label_closed = $this->language->get('label_closed');
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/boss_special.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/boss_special.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_special.css');
		}
		
		$this->load->model('module/boss_special'); 
		
		$this->load->model('tool/image');

		$data['products'] = array();

		$products = $setting['boss_special_product'];		

		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		
		$limit = (int)$setting['limit'];
		
		$products = array_slice($products, 0, $limit);
		
		foreach ($products as $product_id) {
			$product_info = $this->model_module_boss_special->getProduct($product_id);
			
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price_original = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
					$special_original = $price_original;
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				if ((float)$product_info['special']) {
					
					$special_original = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
					
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					
				} else {
					$special = false;
				}
				
				$money_save_original = $price_original-$special_original;
				
				$money_save = $this->currency->format($money_save_original);
				
				$percent_original = round((float)($money_save_original/$price_original*100),0);
				
				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}
				
				$product_specials = $this->model_module_boss_special->getProductSpecials($product_id);
				
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
					$data['products'][] = array(
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
						'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				
				}
				
			}
		}
		//echo'<pre>';print_r($data['products']);echo'</pre>';die();
		$image_width = $setting['image_width'];
		$data['module'] = $module++; 
		
		
			return $this->load->view('module/boss_special', $data);
		
	}
	
	public function specialProduct(){
		
		$product_id = $this->request->get['product_id'];
		
		$this->load->model('module/boss_special'); 
		$this->load->model('catalog/product'); 
		
		$this->language->load('module/boss_special');
		
		$data['text_hours'] = $this->language->get('text_hours');
		$data['text_days'] = $this->language->get('text_days');
		$data['text_minutes'] = $this->language->get('text_minutes');
		$data['text_seconds'] = $this->language->get('text_seconds');
		$data['text_time_offer'] = $this->language->get('text_time_offer');
		$data['text_expires'] = $this->language->get('text_expires');
		
		$label_opening = $this->language->get('label_opening');
		$label_upcoming = $this->language->get('label_upcoming');
		$label_closed = $this->language->get('label_closed');
			
		$product_specials = $this->model_module_boss_special->getProductSpecialDetails($product_id);
		$product_info = $this->model_catalog_product->getProduct($product_id);
		//echo'<pre>';print_r($product_info);echo'</pre>';die();
		$data['devi_special'] = 0;
		if (isset($product_info['price']) && $product_info['price'] != 0)
		{
			$data['devi_special'] = $product_info['special']/$product_info['price']*100;
		}
		if(!empty($product_specials)){
		
			if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/boss_special.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/boss_special.css');
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/boss_special.css');
			}			
		
			$date_end = '1970-01-01';
			
			$special_status = $label_upcoming;
			
			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] <= date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] >= date('Y-m-d'))) {
					$special_status = $label_opening;
					$date_end = $product_special['date_end'];
					break;
				}else{
					if($product_special['date_start'] > date('Y-m-d')){
						$special_status = $label_upcoming.' <span class="small">('.$product_special['date_start'].')</span>';
						$date_end = $product_special['date_start'];
					}
					if($product_special['date_end'] < date('Y-m-d')){
						$special_status = $label_closed.' <span class="small">('.$product_special['date_end'].')</span>';
						$date_end = '';
					}
				}	
			}
			
			$data['special_status'] = $special_status;
			$data['date_end'] = $date_end;
			//echo'<pre>';print_r($special_status);echo'</pre>';die();
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_theme') . '/template/module/boss_special_product')) {
				return $this->load->view($this->config->get('config_theme') . '/template/module/boss_special_product', $data);
			} else {
				return $this->load->view('module/boss_special_product', $data);
			}
		}
	}
}
?>