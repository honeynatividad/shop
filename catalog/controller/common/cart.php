<?php
class ControllerCommonCart extends Controller {
	public function index() {
		$this->load->language('common/cart');

		// Totals
		$this->load->model('extension/extension');

		$admin_fee = 0;//added by HCN

		$totals = array();
		$taxes = $this->cart->getTaxes();
		$total = 0;

		// Because __call can not keep var references so we put them into an array.
		$total_data = array(
			'totals' => &$totals,
			'taxes'  => &$taxes,
			'total'  => &$total
		);
			
		

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_remove'] = $this->language->get('button_remove');

		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();
		
		$data['totals'] = array();
		// echo '<pre>';
		// print_r($this->cart->getProducts());
		// echo '</pre>';
		if (isset($this->request->post['vendor_id'])) {
			$vendor_id = (int)$this->request->post['vendor_id'];
		} else {
			$vendor_id = 0;
		}
		foreach ($this->cart->getProducts() as $product) {

			/**
			Added by HCN
			**/
			
			if($product['model'] == "ERVPA40" || $product['model'] == "ERVPA60" || $product['model'] == "ERVPA80" || $product['model'] == "ERVPK40" || $product['model'] == "ERVPK60" || $product['model'] == "ERVPK80" || $product['model'] == "DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCA" || $product['model'] == "MDCK" || $product['model'] ==  "PEARLNP60A1" || $product['model'] ==  "EMERALDNP80A1" || $product['model'] ==  "DIAMONDNP100A1" || $product['model'] ==  "PEARLP60A1" || $product['model'] ==  "EMERALDP80A1" || $product['model'] ==  "DIAMONDP100A1" || $product['model'] ==  "PEARLNP60A2" || $product['model'] ==  "EMERALDNP80A2" || $product['model'] ==  "DIAMONDNP100A2" || $product['model'] ==  "PEARLP60A2" || $product['model'] ==  "EMERALDP80A2" || $product['model'] ==  "DIAMONDP100A2" || $product['model'] ==  "PEARLNP60K" || $product['model'] ==  "EMERALDNP80K" || $product['model'] ==  "DIAMONDNP100K" || $product['model'] ==  "PEARLP60K" || $product['model'] ==  "EMERALDP80K" || $product['model'] ==  "DIAMONDP100K" || $product['model'] ==  "PEARLNPW60A1" || $product['model'] ==  "EMERALDNPW80A1" ||
			$product['model'] ==  "DIAMONDNPW100A1" || $product['model'] ==  "PEARLPW60A1" || $product['model'] ==  "EMERALDPW80A1" || $product['model'] ==  "DIAMONDPW100A1" || $product['model'] ==  "PEARLNPW60A2" || $product['model'] ==  "EMERALDNPW80A2" || $product['model'] ==  "DIAMONDNPW100A2" || $product['model'] ==  "PEARLPW60A2" || $product['model'] ==  "EMERALDPW80A2" || $product['model'] ==  "DIAMONDPW100A2" || $product['model'] ==  "PEARLNPW60K" || $product['model'] ==  "EMERALDNPW80K" || $product['model'] ==  "DIAMONDNPW100K" || $product['model'] ==  "PEARLPW60K" || $product['model'] ==  "EMERALDPW80K" || $product['model'] ==  "DIAMONDPW100K"){
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

			//**********************************************end*****************************//


			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
			} else {
				$image = '';
			}

			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']);
			} else {
				$total = false;
			}

			$data['products'][] = array(
				'cart_id'   => $product['cart_id'],
				'thumb'     => $image,
				'name'      => $product['name'],
				'model'     => $product['model'],
				'option'    => $option_data,
				'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
				'quantity'  => $product['quantity'],
				'price'     => $price,
				'total'     => $total,
				'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
			);
		}



		// Display prices
		if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
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

					//added by HCN

					if($admin_fee == 0){
						if($result['code'] == "customot"){
							
						}else{
							$this->{'model_total_' . $result['code']}->getTotal($total_data);		
						}
					}else{
						
						$this->{'model_total_' . $result['code']}->getTotal($total_data);
					}
					//edited by HCN ; REMOVE comment for the original code
					//$this->{'model_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			
			array_multisort($sort_order, SORT_ASC, $totals);
		}



		// Gift Voucher
		$data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
				);
			}
		}

		

		$z=0;
		$total_emp = 0;
		foreach ($totals as $total) {
			$data['totals'][] = array(
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
			);
			$total_emp = $total['value'];
		}

		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total_emp, $this->session->data['currency']));

		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);

		return $this->load->view('common/cart', $data);
	}

	public function info() {
		$this->response->setOutput($this->index());
	}
}
