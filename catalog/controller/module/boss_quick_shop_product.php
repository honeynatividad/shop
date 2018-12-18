<?php  
class ControllerModuleBossQuickShopProduct extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->load->language('product/product');
		$this->load->language('module/boss_quick_shop_product');	
		$data['text_hover_remove'] = $this->language->get('text_hover_remove');
		$this->load->model('catalog/category');	
		$this->load->model('catalog/manufacturer');	
			
		$data['config_theme']  = $this->config->get('config_theme');
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {						
			$this->document->setTitle($product_info['name']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
						
			$data['heading_title'] = $product_info['name'];
			
			$data['text_select'] = $this->language->get('text_select');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_points'] = $this->language->get('text_points');	
			$data['text_discount'] = $this->language->get('text_discount');
			$data['text_stock'] = $this->language->get('text_stock');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_discount'] = $this->language->get('text_discount');
			$data['text_option'] = $this->language->get('text_option');			
			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_or'] = $this->language->get('text_or');
			$data['text_write'] = $this->language->get('text_write');
			$data['text_note'] = $this->language->get('text_note');
			$data['text_share'] = $this->language->get('text_share');
			$data['text_wait'] = $this->language->get('text_wait');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_add_to_wish_list'] = $this->language->get('text_add_to_wish_list');
			$data['text_add_to_compare'] = $this->language->get('text_add_to_compare');
			$data['text_loading'] = $this->language->get('text_loading');
			
			
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_qty'] = $this->language->get('entry_qty');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['entry_good'] = $this->language->get('entry_good');
			$data['entry_bad'] = $this->language->get('entry_bad');
			$data['entry_captcha'] = $this->language->get('entry_captcha');
			
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');			
			$data['button_upload'] = $this->language->get('button_upload');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_viewdetail'] = $this->language->get('button_viewdetail');
			
			$this->load->model('catalog/review');

			$data['tab_description'] = $this->language->get('tab_description');
			$data['tab_attribute'] = $this->language->get('tab_attribute');
			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);
			$data['tab_related'] = $this->language->get('tab_related');
			
			$data['product_id'] = $this->request->get['product_id'];
			$data['product_href'] = $this->url->link('product/product', 'product_id='. $product_info['product_id']);
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];
			
			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get($this->config->get('config_theme').'_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}
			
			$this->load->model('tool/image');
		
			//Thumb Image
			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_popup_width'), $this->config->get($this->config->get('config_theme').'_image_popup_height'));
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_thumb_width'), $this->config->get($this->config->get('config_theme').'_image_thumb_height'));
			} else {
				if($results){
					$data['popup'] = $this->model_tool_image->resize($results[0]['image'], $this->config->get($this->config->get('config_theme').'_image_popup_width'), $this->config->get($this->config->get('config_theme').'_image_popup_height') );
					$data['thumb'] = $this->model_tool_image->resize($results[0]['image'], $this->config->get($this->config->get('config_theme').'_image_thumb_width'), $this->config->get($this->config->get('config_theme').'_image_thumb_height'));
					unset($results[0]);
				}else{
					$data['popup'] = '';
					$data['thumb'] = '';
				}
			}
			
			$data['images'] = array();
			
			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
			
			//addition image
			if ($product_info['image']) {
				$data['images'][] =  array(
					'popup' =>$this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_popup_width'), $this->config->get($this->config->get('config_theme').'_image_popup_height')),
					'addition' => $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_additional_width'), $this->config->get($this->config->get('config_theme').'_image_additional_height')),
					'thumb'   => $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme').'_image_thumb_width'), $this->config->get($this->config->get('config_theme').'_image_thumb_height')),
				);
			}
			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme').'_image_popup_width'), $this->config->get($this->config->get('config_theme').'_image_popup_height')),
					'addition' => $this->model_tool_image->resize($result['image'],  $this->config->get($this->config->get('config_theme').'_image_additional_width'), $this->config->get($this->config->get('config_theme').'_image_additional_height')),
					'thumb'   => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme').'_image_thumb_width'), $this->config->get($this->config->get('config_theme').'_image_thumb_height')),
				);
			}
			if (($this->config->get($this->config->get('config_theme').'_customer_price') && $this->customer->isLogged()) || !$this->config->get($this->config->get('config_theme').'_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get($this->config->get('config_theme').'_tax')), $this->session->data['currency']);
			} else {
				$data['price'] = false;
			}
						
			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get($this->config->get('config_theme').'_tax')), $this->session->data['currency']);
			} else {
				$data['special'] = false;
			}
			
			if ($this->config->get($this->config->get('config_theme').'_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}
			
			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
			
			$data['discounts'] = array(); 
			
			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get($this->config->get('config_theme').'_tax')), $this->session->data['currency'])
				);
			}
			
			$data['options'] = array();
			
			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get($this->config->get('config_theme').'_customer_price') && $this->customer->isLogged()) || !$this->config->get($this->config->get('config_theme').'_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get($this->config->get('config_theme').'_tax') ? 'P' : false), $this->session->data['currency']);
						} else {
							$price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}
							
			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}
			
			$data['review_status'] = $this->config->get($this->config->get('config_theme').'_review_status');
			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$data['rating'] = (int)$product_info['rating'];
			$data['description'] = utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 500) . '..';
			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
			
			$this->model_catalog_product->updateViewed($this->request->get['product_id']);
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
			$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);
			
			
			$json = array();
			
			
				$json['html'] = $this->load->view('module/boss_quick_shop_product', $data);
			




			//$json['html'] = $this->load->view($this->config->get('config_theme') . '/template/module/boss_quick_shop_product', $data);
			
			$this->response->addHeader('Content-Type: application/json');
			
			$this->response->setOutput(json_encode($json));
			
		} else {
					
      		$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

      		$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');

			
			$data['language'] = $this->load->controller('common/header');
			$data['currency'] = $this->load->controller('common/footer');
			
			
				 $json['html'] = $this->load->view('module/not_found', $data);
			
			
			
			
			//$json['html'] = '';//$this->render();
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
    	}
  	}
	
	public function review() {
    	$this->load->language('product/product');
		
		$this->load->model('catalog/review');

		$data['text_on'] = $this->language->get('text_on');
		$data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$data['reviews'] = array();
		
		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
			
		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$data['reviews'][] = array(
        		'author'     => $result['author'],
				'text'       => $result['text'],
				'rating'     => (int)$result['rating'],
        		'reviews'    => sprintf($this->language->get('text_reviews'), (int)$review_total),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
			
		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');
			
		$data['pagination'] = $pagination->render();
		
		
				 $this->load->view('product/review', $data);
			
	}
	
	public function write() {
		$this->load->language('product/product');
		
		$this->load->model('catalog/review');
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}
	
			if (empty($this->request->post['rating'])) {
				$json['error'] = $this->language->get('error_rating');
			}
	
			if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
				$json['error'] = $this->language->get('error_captcha');
			}
				
			if (!isset($json['error'])) {
				$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);
				
				$json['success'] = $this->language->get('text_success');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
	public function upload() {
		$this->load->language('product/product');
		
		$json = array();
		
		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
        		$json['error'] = $this->language->get('error_filename');
	  		}	  	

			// Allowed file extension types
			$allowed = array();
			
			$filetypes = explode("\n", $this->config->get($this->config->get('config_theme').'_file_extension_allowed'));
			
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			
			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
       		}	
			
			// Allowed file mime types		
		    $allowed = array();
			
			$filetypes = explode("\n", $this->config->get($this->config->get('config_theme').'_file_mime_allowed'));
			
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
							
			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
						
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		
		if (!$json && is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
			$file = basename($filename) . '.' . md5(mt_rand());
			
			// Hide the uploaded file name so people can not link to it directly.
			$json['file'] = $this->encryption->encrypt($file);
			
			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
						
			$json['success'] = $this->language->get('text_upload');
		}	
		
		$this->response->setOutput(json_encode($json));		
	}
}
?>