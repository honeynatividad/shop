<?php 
class ControllerBossthemesBossAdd extends Controller {
	public function cart() {
		
		$this->load->language('checkout/cart');
		$this->load->language('bossthemes/boss_add');


		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {
			if (isset($this->request->post['quantity'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}

			if (!$json) {
				$this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);
				
				$this->load->model('tool/image'); 
				$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_cart_width'), $this->config->get($this->config->get('config_theme').'_image_cart_height'));
				
				//$image = $this->model_tool_image->resize($product_info['image'],80,80);
        
				$json['title'] = $this->language->get('text_title_cart');
				$json['thumb'] = sprintf($this->language->get('text_thumb'), $image);
				$json['continue'] = $this->language->get('text_continue');
				$json['checkout'] = $this->language->get('text_checkout');

				$json['success'] = sprintf($this->language->get('text_success_cart'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);

				// Totals
				$this->load->model('extension/extension');

				$totals = array();
				$taxes = $this->cart->getTaxes();
				$total = 0;
		
				// Because __call can not keep var references so we put them into an array. 			
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get($this->config->get('config_theme').'_customer_price')) {
					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);

							// We have to put the totals in an array so that they pass by reference.
							$this->{'model_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}
				if(isset($this->session->data['certno'])){
					$json['url'] = $this->session->data['vendor_code'].'&id='.$this->session->data['certno'];
				}else{
					if(isset($this->session->data['vendor_name'])){
						$json['url'] = $this->session->data['vendor_name'];
					}else{

					}
					
				}
				$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']), $this->session->data['currency']);
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
	
	public function vendorcart() {
		
		$this->load->language('checkout/cart');
		$this->load->language('bossthemes/boss_add');


		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->post['vendor_id'])) {
			$vendor_id = (int)$this->request->post['vendor_id'];
		} else {
			$vendor_id = 0;
		}

		// $vendor_id = 2;
		// $product_id = 56;

		$this->load->model('catalog/product');
		$this->load->model('catalog/vendor');
		$product_info = $this->model_catalog_vendor->getProduct($product_id,$vendor_id);
		
		//print_r($vendor_id);
		if ($product_info) {

			if($product_info['model'] == "ERVPA40" || $product_info['model'] == "ERVPA60" || $product_info['model'] == "ERVPA80" || $product_info['model'] == "ERVPK40" || $product_info['model'] == "ERVPK60" || $product_info['model'] == "ERVPK80" || $product_info['model'] == "DACA" || $product_info['model'] == "ERS" || $product_info['model'] == "MDC65" || $product_info['model'] == "MDCA" || $product_info['model'] == "MDCK" || $product_info['model'] ==  "PEARLNP60A1" || $product_info['model'] ==  "EMERALDNP80A1" || $product_info['model'] ==  "DIAMONDNP100A1" || $product_info['model'] ==  "PEARLP60A1" || $product_info['model'] ==  "EMERALDP80A1" || $product_info['model'] ==  "DIAMONDP100A1" || $product_info['model'] ==  "PEARLNP60A2" || $product_info['model'] ==  "EMERALDNP80A2" || $product_info['model'] ==  "DIAMONDNP100A2" || $product_info['model'] ==  "PEARLP60A2" || $product_info['model'] ==  "EMERALDP80A2" || $product_info['model'] ==  "DIAMONDP100A2" || $product_info['model'] ==  "PEARLNP60K" || $product_info['model'] ==  "EMERALDNP80K" || $product_info['model'] ==  "DIAMONDNP100K" || $product_info['model'] ==  "PEARLP60K" || $product_info['model'] ==  "EMERALDP80K" || $product_info['model'] ==  "DIAMONDP100K" || $product_info['model'] ==  "PEARLNPW60A1" || $product_info['model'] ==  "EMERALDNPW80A1" ||
			$product_info['model'] ==  "DIAMONDNPW100A1" || $product_info['model'] ==  "PEARLPW60A1" || $product_info['model'] ==  "EMERALDPW80A1" || $product_info['model'] ==  "DIAMONDPW100A1" || $product_info['model'] ==  "PEARLNPW60A2" || $product_info['model'] ==  "EMERALDNPW80A2" || $product_info['model'] ==  "DIAMONDNPW100A2" || $product_info['model'] ==  "PEARLPW60A2" ||
			$product_info['model'] ==  "EMERALDPW80A2" || $product_info['model'] ==  "DIAMONDPW100A2" ||
			$product_info['model'] ==  "PEARLNPW60K" || $product_info['model'] ==  "EMERALDNPW80K" || $product_info['model'] ==  "DIAMONDNPW100K" || $product_info['model'] ==  "PEARLPW60K" || $product_info['model'] ==  "EMERALDPW80K" || $product_info['model'] ==  "DIAMONDPW100K"){



				

				$admin_fee = 1;
				
			}

			/*
			IF VENDOR CODE is TELETECH , admin fee = 0
			*/

			if(isset($this->session->data['certno'])){
				$admin_fee = 0;
			}

			if($vendor_id == 3){
				$admin_fee = 0;
			}

			if (isset($this->request->post['quantity'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($product_id);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}

			if (!$json) {
				$this->cart->add($product_id, $quantity, $option, $recurring_id);
				
				$this->load->model('tool/image'); 
				$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_cart_width'), $this->config->get($this->config->get('config_theme').'_image_cart_height'));
				
				//$image = $this->model_tool_image->resize($product_info['image'],80,80);
        
				$json['title'] = $this->language->get('text_title_cart');
				$json['thumb'] = sprintf($this->language->get('text_thumb'), $image);
				$json['continue'] = $this->language->get('text_continue');
				$json['checkout'] = $this->language->get('text_checkout');

				$json['success'] = sprintf($this->language->get('text_success_cart'), $this->url->link('product/product', 'product_id=' . $product_id), $product_info['name'], $this->url->link('checkout/cart'));

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);

				// Totals
				$this->load->model('extension/extension');

				$totals = array();
				$taxes = $this->cart->getTaxes();
				$total = 0;
		
				// Because __call can not keep var references so we put them into an array. 			
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get($this->config->get('config_theme').'_customer_price')) {
					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);
					
					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);

							if($admin_fee == 0){
								if($result['code'] == "customot"){
									
								}else{
									$this->{'model_total_' . $result['code']}->getTotal($total_data);		
								}
							}else{
								
								$this->{'model_total_' . $result['code']}->getTotal($total_data);
							}

							// We have to put the totals in an array so that they pass by reference.
							//$this->{'model_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}
				//print_r($totals);
				
				if(isset($this->session->data['certno'])){
					$json['url'] = $this->session->data['vendor_code'].'&id='.$this->session->data['certno'];
				}else{
					if(isset($this->session->data['vendor_name'])){
						$json['url'] =	'';	
					}else{
						$json['url'] = '';
					}
					
				}

				
				$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']), $this->session->data['currency']);
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
	
	public function wishlist() {
		$this->load->language('account/wishlist');
		$this->load->language('bossthemes/boss_add');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			$json['title'] = $this->language->get('text_title_wishlist');
			$json['continue'] = $this->language->get('text_continue');
			$json['wishlist'] = $this->language->get('text_wishlist');
			
			if ($this->customer->isLogged()) {
				// Edit customers cart
				$this->load->model('account/wishlist');

				$this->model_account_wishlist->addWishlist($this->request->post['product_id']);

				$this->load->model('tool/image'); 
				$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_cart_width'), $this->config->get($this->config->get('config_theme').'_image_cart_height'));
				
				$json['thumb'] = sprintf($this->language->get('text_thumb'), $image);
				
				$json['success'] = sprintf($this->language->get('text_success_wishlist'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

				$json['total'] = sprintf($this->language->get('entry_wishlist'), $this->model_account_wishlist->getTotalWishlist());
			} else {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}

				$this->session->data['wishlist'][] = $this->request->post['product_id'];

				$this->session->data['wishlist'] = array_unique($this->session->data['wishlist']);
				
				$json['info'] = sprintf($this->language->get('text_login_wishlist'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

				$json['total'] = sprintf($this->language->get('entry_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function compare() {
		$this->load->language('product/compare');
		
		$this->load->language('bossthemes/boss_add');

		$json = array();

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {
				if (count($this->session->data['compare']) >= 4) {
					array_shift($this->session->data['compare']);
				}

				$this->session->data['compare'][] = $this->request->post['product_id'];
			}
			
			$this->load->model('tool/image'); 
			$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_cart_width'), $this->config->get($this->config->get('config_theme').'_image_cart_height'));
      
			$json['title'] = $this->language->get('text_title_compare');
			$json['thumb'] = sprintf($this->language->get('text_thumb'), $image);
			$json['continue'] = $this->language->get('text_continue');
			$json['compare'] = $this->language->get('compare_text');

			$json['success'] = sprintf($this->language->get('text_success_compare'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('product/compare'));

			$json['total'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>