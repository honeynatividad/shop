<?php
class ControllerProductVendor extends Controller {

	public function index() {		
		
		$this->load->model('catalog/vendor');

        if (isset($this->request->get['_route_'])) {
        	$url = $this->request->get['_route_'];
        }else{
        	if (isset($this->request->get['name'])) {
			$url = $this->request->get['name'];
			} else {
				$url = '';
			}
        	
        }
        /*echo '<pre>';
        print_r("VENDOR ".$this->request->get['_route_']);
        echo '</pre>';*/

        if (isset($this->request->get['id'])) {
        	$certno = $this->request->get['id'];
        	$this->session->data['certno'] = $certno;
        }else{
        	$certno = "";
        	$this->session->data['certno'] = $certno;
        }
        
    	$vendors = $this->model_catalog_vendor->getVendor($url);

    	$vendor_id = $vendors['vendor_id'];
    	$vendor_image = $vendors['image'];
    	$vendor_name = $vendors['vendor_name'];
    	$vendor_code = $vendors['vendor_code'];
    	
    	$data['vendor_id'] = $vendor_id;
    	$data['vendor_code'] = $vendor_code;
    	$data['certno'] = $certno;

    	$this->session->data['vendor_name'] = $vendor_name;
    	$this->session->data['vendor_id'] = $vendor_id;
    	$this->session->data['vendor_code'] = $vendor_code;

    	if (isset($this->request->get['name'])) {
			$name = $this->request->get['name'];
		} else {
			$name = $vendor_name;
		}
		

    //start of product/category

    	$this->load->language('product/vendor');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');
		$this->load->model('catalog/vendor');

		$this->load->model('tool/image');
		//print_r("ipay".$this->config->get('ipay88_completed_status_id'));
		//print_r("aurumpay".$this->config->get('aurumpay_completed_status_id'));
		//print_r("TEST");

		
		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		$data['breadcrumbs'] = array();



		if(isset($this->session->data['certno'])){
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => 'https://shop.philcare.com.ph/'.$this->session->data['vendor_code'].'&id='.$this->session->data['certno']
			);
		}else{
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => 'https://shop.philcare.com.ph/'.$this->session->data['vendor_code']
			);
		}
		//Checking if there is an existing certno
		if (isset($this->request->get['id'])) {
			
		}else{
			$data['breadcrumbs'] = array();
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => 'https://shop.philcare.com.ph/'.urlencode($this->session->data['vendor_name'])
			);	
		}

		if (isset($this->request->get['name'])) {

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['name']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'name=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);
		
		if ($vendors) {



			$this->document->setTitle($vendor_name);
			$this->document->setDescription($url);
			$this->document->setKeywords($url);

			$data['heading_title'] = $vendor_name;

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			$data['vendor_name'] = $vendor_name;
			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $vendor_name,
				'href' => urlencode($this->url->link($vendor_name))
			);

			if ($vendor_image) {
				$data['thumb'] = $this->model_tool_image->resize($vendor_image, $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($url, ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare');
			if (isset($this->request->get['name'])) {
				$name = $this->request->get['name'];
			} else {
				$name = $vendor_name;
			}
			/*echo '<pre>';
			print_r($name);
			echo '</pre>';*/
			$url = '&name='.urlencode($name);

			

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);
			
			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/vendor/view', '&product_id=' . $result['category_id'] . $url)
				);
			}

			if($vendor_name=="Madanes"){
				$category_id = 0;
			}
			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit,
				'vendor_id'			=>	$vendor_id
			);

			//$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
			$product_total = $this->model_catalog_vendor->getTotalProducts($vendor_id);
			
			//$results = $this->model_catalog_product->getProducts($filter_data);
			
		
			/*if(isset($this->request->get['name'])){

				$results = $this->model_catalog_vendor->getProductMadanes($filter_data);
				
			}else{
				
			}*/
			
			$results = $this->model_catalog_vendor->getProducts($filter_data);
			// ADDED ON JAN 15, 2018
			// THIS IS TO IDENTIFY IF USER IS ACCESSING MADANES OR NOT
			// CHANGE MODEL TO CALL PRODUCTS
			
			
			if($vendor_name=="Madanes"){
				$results = $this->model_catalog_vendor->getProductMadanes($filter_data);

			}

			/*echo '<pre>';
			print_r($results);
			echo '</pre>';*/
			
			$currency = $this->session->data['currency'];
			foreach ($results as $result) {
				

				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {

					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$raw_orig_price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
					
				} else {
					$price = false;
					$raw_orig_price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$new_price = $this->currency->format($this->tax->calculate($result['new_price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$raw_price = $this->tax->calculate($result['new_price'], $result['tax_class_id'], $this->config->get('config_tax'));
				} else {
					$new_price = false;
					$raw_price;
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
				

				//===============================
				// START of CONVERSION
				//===============================
				if($currency == "USD"){
 
					//From Currency
					$from_currency ="PHP";
					 
					//To Currency
					$to_currency ="USD";
					$raw_orig_price = $this->convert('PHP', 'USD', $raw_orig_price);
					$raw_orig_price = round($raw_orig_price,2);
					$price = $this->currency->format($this->tax->calculate($raw_orig_price, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					//echo "Code: $this->convert('USD', 'THB', 1);<br>";
					
					$raw_price = $this->convert('PHP', 'USD', $raw_price);
					$raw_price = round($raw_price,2);
					/*echo '<pre>';
					print_r($raw_price);
					echo '</pre>';*/
					$raw_price = $this->currency->format($this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$new_price = $raw_price;
				}else{
					
				}
				$orig_image = "https://shop.philcare.com.ph/image/".$result['image'];
				
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $orig_image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'new_price'		=> $new_price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/vendor/view'. '&product_id=' . $result['product_id'] . $url)
				);


			}
			/*echo '<pre>';
				print_r($data['products']);
			echo '</pre>';*/
			//echo 'test - '.$this->url->link('product/vendor/view');
			if (isset($this->request->get['name'])) {
				$name_vendor = urlencode($this->request->get['name']);
			} else {
				$name_vendor = urlencode($vendor_name);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= 'filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= 'limit=' . $this->request->get['limit'];
			}

			
			$data['sorts'] = array();
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/vendor', 'sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/vendor', 'sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/vendor', 'sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/vendor', 'sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/vendor', 'sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/vendor', 'sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/vendor', 'sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/vendor', 'sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/vendor', 'sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					//'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= 'name='.$name_vendor.'&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= 'name='.$name_vendor.'&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= 'name='.$name_vendor.'&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= 'name='.$name_vendor.'&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			if (isset($this->request->get['id'])) {
				$pagination->url = $this->session->data['vendor_code']. '&id=' . $this->request->get['id'] . $url . '&page={page}';
			}else{
				$pagination->url = $this->session->data['vendor_name'].   $url . '&page={page}';
			}
			

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			/*if ($page == 1) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1), true), 'next');
			}*/

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			//$data['continue'] = $this->url->link('common/home');

			if(isset($this->session->data['certno'])){
				$data['continue'] = $this->session->data['vendor_code'].'&id='.$this->session->data['certno'].$url;
			}else{
				$data['continue'] = $this->session->data['vendor_name'].$url;
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header2');


			//==========
			// If Madanes show diff template
			//==========
			/*echo '<pre>';
			print_r($vendor_name);
			echo '</pre>';*/
			if($vendor_name=="Madanes"){
				$data['footer'] = $this->load->controller('common/footer_madanes');
				$data['content_top'] = $this->load->controller('common/content_top_madanes');
				$this->response->setOutput($this->load->view('product/vendor_for_madanes', $data));
			}else{
				$data['content_top'] = $this->load->controller('common/content_top_teletech');
				$this->response->setOutput($this->load->view('product/vendor', $data));	
			}
			
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}


	}


	public function view(){		
		
		$this->load->model('catalog/product');

		$this->load->model('catalog/vendor');

    	$this->load->language('product/vendor');

		$this->load->model('catalog/category');		

		$this->load->model('tool/image');


    	//$this->session->data['vendor_name'] = $vendor_name;    	


    	if (isset($this->request->get['_route_'])) {
        	$name = $this->request->get['_route_'];
        }else{
        	if (isset($this->request->get['name'])) {
				$name = $this->request->get['name'];
				$this->session->data['vendor_name'] = $name;
			} else {
				$name = $this->session->data['vendor_name'];
			}

			if(isset($this->request->get['id'])){
				$certno = $this->request->get['id'];
			}else{
				$certno = 0;
			}

        }
       
        $vendors = $this->model_catalog_vendor->getVendorName($name);
        /*echo '<pre>';
        print_r($vendors);
        echo '</pre>';*/
        $vendor_id = $vendors['vendor_id'];
    	$vendor_image = $vendors['image'];
    	$vendor_name = $vendors['vendor_name'];
    	$vendor_code = $vendors['vendor_code'];
    	$data['vendor_name'] = $vendor_code;
    	$data['vendor_code'] = $vendor_code;

        $data['vendor_id']	= $vendor_id;
        $data['certno']		= $certno;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('catalog/category');

		
		if (isset($this->request->get['product_id'])) {
			$path = '';
		}
        
        if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_vendor->getProduct($product_id,$vendor_id);
		/*echo '<pre>';
		print_r($product_info);
		echo '</pre>';*/
		if ($product_info) {
			$url = 'name='.urlencode($name);

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/vendor/view', $url . '&name='.$name.'product_id=' . $this->request->get['product_id'])
			);
			//$data['vendor_name'] = 'TEST';
			$this->document->setTitle($product_info['meta_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/vendor/view', 'name='.$name.'product_id=' . $this->request->get['product_id']), 'canonical');
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

			$data['heading_title'] = $product_info['name'];

			$data['text_select'] = $this->language->get('text_select');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_stock'] = $this->language->get('text_stock');
			$data['text_discount'] = $this->language->get('text_discount');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_write'] = $this->language->get('text_write');
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
			$data['text_note'] = $this->language->get('text_note');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_related'] = $this->language->get('text_related');
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
			$data['text_loading'] = $this->language->get('text_loading');
			//HCN
			$data['text_custom_desc'] = $this->language->get('text_custom_desc');
			

			$data['entry_qty'] = $this->language->get('entry_qty');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['entry_good'] = $this->language->get('entry_good');
			$data['entry_bad'] = $this->language->get('entry_bad');
			$data['entry_bad'] = $this->language->get('entry_bad');
			//HCN
			$data['entry_custom_desc'] = $this->language->get('entry_custom_desc');


			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_upload'] = $this->language->get('button_upload');
			$data['button_continue'] = $this->language->get('button_continue');

			$this->load->model('catalog/review');

			$data['tab_description'] = $this->language->get('tab_description');
			$data['tab_attribute'] = $this->language->get('tab_attribute');
			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$this->request->get['product_id'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			//HCN
			$data['custom_desc'] = html_entity_decode($product_info['custom_desc'], ENT_QUOTES, 'UTF-8');
			$data['help_without_pre_existing'] = "Pre-Existing Coverage – is an illness or condition is considered pre-existing if prior to the effective date of health coverage the pathogenesis such illness or condition has started, whether the member is aware or not";
			$data['help_pre_existing'] = "
			Pre-Existing Coverage – is an illness or condition is considered pre-existing if prior to the effective date of health coverage the pathogenesis such illness or condition has started, whether the member is aware or not.
			Annual Benefit Limit (ABL) – refers to the total limit of the card regardless of illness";

			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($product_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}
			$data['madanes_image'] = $product_info['image'];
			$data['images'] = array();

			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
				);
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$raw_orig_price = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
			} else {
				$data['price'] = false;
				$raw_orig_price = false;
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$new_price = $this->currency->format($this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$raw_price = $this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
				$data['new_price'] = $new_price;
			} else {
				$new_price = false;
				$raw_price = false;
			}


			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}

			$data['options'] = array();

			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
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

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$data['rating'] = (int)$product_info['rating'];

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$data['share'] = $this->url->link('product/vendor/view', 'name='.$name.'&product_id=' . (int)$this->request->get['product_id']);

			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

			$data['products'] = array();

			//===============================
			// START of CONVERSION
			//===============================
			$currency = $this->session->data['currency'];
			if($currency == "USD"){

				//From Currency
				$from_currency ="PHP";
				 
				//To Currency
				$to_currency ="USD";
				$raw_orig_price = $this->convert('PHP', 'USD', $raw_orig_price);
				$raw_orig_price = round($raw_orig_price,2);
				$price = $this->currency->format($this->tax->calculate($raw_orig_price, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				//echo "Code: $this->convert('USD', 'THB', 1);<br>";
				
				$raw_price = $this->convert('PHP', 'USD', $raw_price);
				$raw_price = round($raw_price,2);
				/*echo '<pre>';
				print_r($raw_price);
				echo '</pre>';*/
				$raw_price = $this->currency->format($this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$new_price = $raw_price;
			}else{
				$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$new_price = $this->currency->format($this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			}

			$data['new_price'] = $new_price;
			$data['price'] = $price;

			//$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
			//original
		
			$results = $this->model_catalog_vendor->getProductRelated($this->request->get['product_id'],$vendor_id);

			$currency = $this->session->data['currency'];
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$raw_orig_price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
				} else {
					$price = false;
					$raw_orig_price = false;
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



				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,

					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'new_price'		=> $new_price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'custom_desc' => $result['custom_desc'],
					'href'        => $this->url->link('product/vendor/view', 'name='.$name.'&product_id=' . $result['product_id'])
				);
			}

			$data['tags'] = array();

			if ($product_info['tag']) {
				$tags = explode(',', $product_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}

			$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);

			$this->model_catalog_product->updateViewed($this->request->get['product_id']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header3');
			
			//==========
			// If Madanes show diff template
			//==========

			

			if($vendor_name=="Madanes"){
				$data['product_type'] = $product_info['model'];
				$data['continue'] = $vendor_name;
				$data['footer'] = $this->load->controller('common/footer_madanes');
				$data['content_top'] = $this->load->controller('common/content_top_madanes');
				$this->response->setOutput($this->load->view('product/vendor_madanes', $data));
			}else{
				$data['content_top'] = $this->load->controller('common/content_top_teletech');
				$data['continue'] = $vendor_code.''.$certno;
				$this->response->setOutput($this->load->view('product/vendor_other', $data));	
			}
			
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header3');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}

	}

	public function madanes_test(){
		$json = array();		
		if (isset($this->request->post['product_type'])) {
			$product_type = $this->request->post['product_type'];
		} else {
			$product_type = '';
		}

		if (isset($this->request->post['age_option'])) {
			$age_option = $this->request->post['age_option'];
			$age_description = "";
			if($age_option == "kids"){
				$age_description = "15 days to 17 years old";
			}else if($age_option == "adult1"){
				$age_description = "18 years to 40 years old";
			}else if($age_option == "adult2"){
				$age_description = "41 years to 65 years old";
			}
		} else {
			$age_option = '';
			$age_description = "";
		}

		if (isset($this->request->post['preexisting'])) {
			$preexisting = $this->request->post['preexisting'];
			$preexisting_description = "";
			if($preexisting == "with_preexisting"){
				$preexisting_description = "With Pre-Existing Coverage";
			}else if($preexisting == "without_preexisting"){
				$preexisting_description = "Without Pre-Existing Coverage";
			}

		} else {
			$preexisting = '';
			$preexisting_description = "";
		}

		if (isset($this->request->post['consultation'])) {
			$consultation = $this->request->post['consultation'];
			$consultation_description = "";
			if($consultation == "with_consultation"){
				$consultation_description = "With Unli Consultation";
			}else if($consultation == "without_consultation"){
				$consultation_description = "Without Unli Consultation";
			}
		} else {
			$consultation = '';
			$consultation_description = "";
		}

		if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLNP60A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDNP80A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDNP100A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLP60A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDP80A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDP100A1";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLNP60A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDNP80A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDNP100A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLP60A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDP80A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDP100A2";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLNP60K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDNP80K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDNP100K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLP60K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDP80K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDP100K";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLNPW60A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDNPW80A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDNPW100A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLPW60A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDPW80A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDPW100A1";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLNPW60A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDNPW80A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDNPW100A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLPW60A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDPW80A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDPW100A2";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLNPW60K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDNPW80K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDNPW100K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "pearl"){
			$card_model = "PEARLPW60K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "emerald"){
			$card_model = "EMERALDPW80K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "diamond"){
			$card_model = "DIAMONDPW100K";
		}else{
			$card_model = "TEST";
		}

		$json['test'] = "test - ".$product_type."=".$age_option."=".$preexisting."==".$consultation."--".$card_model;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function madanes_computation(){
		$this->load->language('product/product');
		$this->load->model('catalog/product');
		$this->load->model('catalog/vendor');

		$json = array();
		
		if (isset($this->request->post['product_type'])) {
			$product_type = $this->request->post['product_type'];
		} else {
			$product_type = '';
		}

		if (isset($this->request->post['age_option'])) {
			$age_option = $this->request->post['age_option'];
			$age_description = "";
			if($age_option == "kids"){
				$age_description = "15 days to 17 years old";
			}else if($age_option == "adult1"){
				$age_description = "18 years to 40 years old";
			}else if($age_option == "adult2"){
				$age_description = "41 years to 65 years old";
			}
		} else {
			$age_option = '';
			$age_description = "";
		}

		if (isset($this->request->post['preexisting'])) {
			$preexisting = $this->request->post['preexisting'];
			$preexisting_description = "";
			if($preexisting == "with_preexisting"){
				$preexisting_description = "With Pre-Existing Coverage";
			}else if($preexisting == "without_preexisting"){
				$preexisting_description = "Without Pre-Existing Coverage";
			}

		} else {
			$preexisting = '';
			$preexisting_description = "";
		}

		if (isset($this->request->post['consultation'])) {
			$consultation = $this->request->post['consultation'];
			$consultation_description = "";
			if($consultation == "with_consultation"){
				$consultation_description = "With Unli Consultation";
			}else if($consultation == "without_consultation"){
				$consultation_description = "Without Unli Consultation";
			}
		} else {
			$consultation = '';
			$consultation_description = "";
		}

		if (isset($this->request->post['quantity'])) {
			$quantity = $this->request->post['quantity'];
		} else {
			$quantity = 1;
		}

		/*$age_option = "kids";
		$preexisting = "with_preexisting";
		$consultation = "with_consultation";*/
		//=========================
		// ADULT1 without unli consult without pre
		//=========================

		if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLNP60A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDNP80A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDNP100A1";
		}else

		//=========================
		// ADULT1 without unli consult with pre
		//=========================

		if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLP60A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDP80A1";
		}else if($age_option == "adult1" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDP100A1";
		}else

		//=========================
		// ADULT2 without unli consult without pre
		//=========================
		if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLNP60A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDNP80A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDNP100A2";
		}else
		//=========================
		// ADULT2 without unli consult with pre
		//=========================
		if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLP60A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDP80A2";
		}else if($age_option == "adult2" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDP100A2";
		}else


		//=========================
		// KIDS without unli consult without pre
		//=========================
		if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLNP60K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDNP80K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "without_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDNP100K";
		}else
		//=========================
		// KIDS without unli consult with pre
		//=========================
		if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLP60K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDP80K";
		}else if($age_option == "kids" && $consultation == "without_consultation" && $preexisting == "with_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDP100K";
		}else

		//=========================
		// ADULT1 with unli consult without pre
		//=========================
		if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLNPW60A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDNPW80A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDNPW100A1";
		}else

		//=========================
		// ADULT1 with unli consult with pre
		//=========================
		if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLPW60A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDPW80A1";
		}else if($age_option == "adult1" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDPW100A1";
		}else

		//=========================
		// ADULT2 with unli consult without pre
		//=========================
		if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLNPW60A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDNPW80A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDNPW100A2";
		}else


		//=========================
		// ADULT2 with unli consult with pre
		//=========================
		if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLPW60A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDPW80A2";
		}else if($age_option == "adult2" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDPW100A2";
		}else


		//=========================
		// KIDS with unli consult without pre
		//=========================
		if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLNPW60K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDNPW80K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "without_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDNPW100K";
		}else


		//=========================
		// KIDS with unli consult with pre
		//=========================
		if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "PEARL"){
			$card_model = "PEARLPW60K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "EMERALD"){
			$card_model = "EMERALDPW80K";
		}else if($age_option == "kids" && $consultation == "with_consultation" && $preexisting == "with_preexisting" && $product_type == "DIAMOND"){
			$card_model = "DIAMONDPW100K";
		}


		if (isset($this->request->post['recurring_id'])) {
			$recurring_id = $this->request->post['recurring_id'];
		} else {
			$recurring_id = 0;
		}
		$vendor_id = 3;

		$product_id = $this->model_catalog_vendor->getProductId($card_model);
		$product_info = $this->model_catalog_vendor->getProduct($product_id,$vendor_id);
		//$recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

		$json['test'] = "test - ".$card_model." - ".$product_id;		

		if ($product_info) {
			
			$json['product_name'] = '<h2>'.$product_info['name'].'</h2>';
			$json['description'] = htmlspecialchars_decode($product_info['description']);
			
			$price = $this->currency->format($this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			$json['price'] = '<span class="price-new">'.$price.'</span>';
			$this->load->model('tool/image');
			if ($product_info['image']) {
				$popup = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$popup = '';
			}

			$image_div = '
				
		        	<div class="bt-product-zoom">
		          		<ul class="thumbnails">		         
		            	<?php if ('.$product_info["image"].') { ?>
		            		<li><a class="thumbnail" href="'.$popup.'" title="Bayani Family Care"><img src="https://shop.philcare.com.ph/image/'.$product_info["image"].'" /></a></li>
		            	<?php } ?>
				  		</ul>
				  	</div>
				
			';
			$json['image'] = $image_div;

			$madanes_rates = "
			<div>
				<div>
				<a class='btn btn-success' href='https://shop.philcare.com.ph/index.php?route=product/vendor/view_madanes&product_id=".$product_info['product_id']."''>Bayani Family Care Product Overview</a>
			  
          		</div>
				<table class='cart-info table'>
					<tr>
						<td>RATES PER CLASSIFICATION</td>
						<td>".$product_info['name']."</td>
					</tr>
					<tr>
						<td>".$age_description."</td>
						<td colspan='3'>".$price."</td>
					</tr>
					<tr>
						<td>".$consultation_description."</td>
					</tr>
					<tr>
						<td>".$preexisting_description."</td>
					</tr>
				</table>
			</div>";
			$json['madanes_rates'] = $madanes_rates;

			$t = "btadd.vendorcart('0','" .$vendor_id."', '".$product_info['product_id']."', '".$quantity."');";

			$string = '
			<div class="button-group">
				<a class="btn-cart" href="https://shop.philcare.com.ph/index.php?route=product/vendor/view_madanes&product_id='.$product_info['product_id'].'">VIEW PRODUCT</a>
			  
          	</div>
			';

			$cart_des = '
			<div class="cart">
		  		<div class="quantily_info">
					<div class="title_text"><span>Qty</span></div>
            		<div class="select_number">
			  			<input type="text" name="quantity" value="" size="2" id="input-quantity" class="form-control" />
              			<button onclick="changeQty(1); return false;" class="increase"><i class="fa fa-angle-up"></i></button>
              			<button onclick="changeQty(0); return false;" class="decrease"><i class="fa fa-angle-down"></i></button>
            		</div>
            		<input type="hidden" name="product_id" size="2" value="'.$product_info['product_id'].'" />
					
          		</div>
		  
		  <div class="button-group">
        <button type="button" id="button-cart" data-loading-text="loading" class="btn-cart" onclick="'.$t.'"><i class="fa fa-shopping-cart"></i>ADD TO CART</button>
      
        <button class="btn-wishlist" type="button" title="ADD TO WISHLIST" onclick="btadd.wishlist("'.$product_info['product_id'].'");"><i class="fa fa-heart"></i></button>
        
            
        <button class="btn-compare" type="button" title="COMPARE THIS PRODUCT" onclick="btadd.compare("'.$product_info['product_id'].'");"><i class="fa fa-retweet"></i> </button>
          </div>
		  
		  </div>
			';
			
			$cart_btn = '<div class=\"button-group button-grid\"><button class=\"btn-cart\" type=\"button\" onclick='.$t.'><i class=\"fa fa-shopping-cart\"></i>ADD TO CART</button><button class=\"btn-wishlist\" type=\"button\" onclick=\"btadd.wishlist("'.$product_info['product_id'].'");\"><i class=\"fa fa-heart\"></i></button><button class=\"btn-compare\" type=\"button\" onclick=\"btadd.compare("'.$product_info['product_id'].'");\"><i class=\"fa fa-retweet\"></i></button>'.$product_info['product_id'].'</div>';
			
			$s = '<div class="button-group">
        <button type="button" id="button-cart" data-loading-text="loading" class="btn-cart" onclick="'.$t.'"><i class="fa fa-shopping-cart"></i>ADD TO CART</button>
      
        <button class="btn-wishlist" type="button" title="ADD TO WISHLIST" onclick="btadd.wishlist("'.$product_info['product_id'].'");"><i class="fa fa-heart"></i></button>
        
            
        <button class="btn-compare" type="button" title="COMPARE THIS PRODUCT" onclick="btadd.compare("'.$product_info['product_id'].'");"><i class="fa fa-retweet"></i> </button>
          </div>';
			//$json['btn'] =$s;
        $help_pre_existing = "Pre-Existing Coverage – is an illness or condition is considered pre-existing if prior to the effective date of health coverage the pathogenesis such illness or condition has started, whether the member is aware or not";
        $json['help_pre_existing'] = $help_pre_existing;
		$json['btn'] =$string;
		$json['addcart'] = $s;
			/*if (!$json) {
				$frequencies = array(
					'day'        => $this->language->get('text_day'),
					'week'       => $this->language->get('text_week'),
					'semi_month' => $this->language->get('text_semi_month'),
					'month'      => $this->language->get('text_month'),
					'year'       => $this->language->get('text_year'),
				);

				if ($recurring_info['trial_status'] == 1) {
					$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
				} else {
					$trial_text = '';
				}

				$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

				if ($recurring_info['duration']) {
					$text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				} else {
					$text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				}
				print_r($text);
				$json['success'] = $text;
			}*/
		}
		
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function cart_test(){
		$string = '
			<div class="button-group">
				<a class="btn-cart" href="https://shop.philcare.com.ph/index.php?route=product/product&product_id='.$product_id.'"></a>
			  
          	</div>
		';
		$json['test'] = $string;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function test(){
		$certno = $this->session->data['certno'];
			$url_link = "https://apps.philcare.com.ph/PhilcareWatson/Members.svc/MembersInfo/?CertNo=".$certno;

			$getxml = @file_get_contents($url_link);
         
            if(!$getxml){
                $info = "";
                
            }else{
                $xml = simplexml_load_string($getxml);
                $data = $xml->MembersInfoResult;
                $namespaces = $data->getNameSpaces(true);
                $info = $data->children($namespaces['a']);  
                echo '<pre>';
	                print_r($info);
	                echo '</pre>';
                
                print_r($info->Address);
            }
	}

	// this is for conversion of PESO TO USD vice versa
	public function convert($convertFrom, $convertTo, $amount){

		/*$string_url = "https://finance.google.com/finance/converter?a=".$amount."&from=".$convertFrom."&to=".$convertTo;
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $string_url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        
        $output = curl_exec($ch);   
        echo $output;
		$get = explode("<span class=bld>",$output);
  		$get = explode("</span>",$get[0]);  
  		$converted_currency = preg_replace("/[^0-9\.]/", null, $get[0]);

  		print_r($string_url."-".$output);*/
        
        //print_r($url);

        $amount    = urlencode($amount);
		$from    = urlencode($convertFrom);
		$to        = urlencode($convertTo);
		$url    = "https://finance.google.com/finance/converter?a=".$amount."&from=".$convertFrom."&to=".$convertTo;
		


		$ch     = curl_init();
		$timeout= 0;
		 
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		 
		$rawdata = curl_exec($ch);
		curl_close($ch);
		print_r($rawdata);
		/*$data = explode('"', $rawdata);
		$data = explode(' ', $data['1']);
		$converted_currency = $data['0'];*/
		$converted_currency = $rawdata;

	    /*$rawHTML = file_get_contents("https://finance.google.com/finance/converter?a=$amount&from=$convertFrom&to=$convertTo");
	    preg_match_all("/bld>([0-9\.]+) ([A-Z]+)<\//", $rawHTML, $output_array);

	    $get = explode("<span class=bld>",$rawHTML);
		$get = explode("</span>",$get[1]);
		$converted_currency = preg_replace("/[^0-9\.]/", null, $get[0]);*/

	    /*echo '<pre>';
	    //print_r($amount);
	    print_r($converted_currency);
	    echo '</pre>';*/
	    return $converted_currency;
	}




	public function view_madanes(){		
		
		$this->load->model('catalog/product');

		$this->load->model('catalog/vendor');

    	$this->load->language('product/vendor');

		$this->load->model('catalog/category');		

		$this->load->model('tool/image');


    	//$this->session->data['vendor_name'] = $vendor_name;    	


    	if (isset($this->request->get['_route_'])) {
        	$name = $this->request->get['_route_'];
        }else{
        	if (isset($this->request->get['name'])) {
				$name = $this->request->get['name'];
				$this->session->data['vendor_name'] = $name;
			} else {
				$name = $this->session->data['vendor_name'];
			}

			if(isset($this->request->get['id'])){
				$certno = $this->request->get['id'];
			}else{
				$certno = 0;
			}

        }
       
        $vendors = $this->model_catalog_vendor->getVendorName($name);
       /* echo '<pre>';
        print_r($vendors);
        echo '</pre>';*/
        $vendor_id = $vendors['vendor_id'];
    	$vendor_image = $vendors['image'];
    	$vendor_name = $vendors['vendor_name'];
    	$vendor_code = $vendors['vendor_code'];
    	$data['vendor_name'] = $vendor_code;
    	$data['vendor_code'] = $vendor_code;

        $data['vendor_id']	= $vendor_id;
        $data['certno']		= $certno;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('catalog/category');

		
		if (isset($this->request->get['product_id'])) {
			$path = '';
		}
        
        if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_vendor->getProduct($product_id,$vendor_id);
		/*echo '<pre>';
		print_r($product_info);
		echo '</pre>';*/
		if ($product_info) {
			$url = 'name='.urlencode($name);

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/vendor/view', $url . '&name='.$name.'product_id=' . $this->request->get['product_id'])
			);
			//$data['vendor_name'] = 'TEST';
			$this->document->setTitle($product_info['meta_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/vendor/view', 'name='.$name.'product_id=' . $this->request->get['product_id']), 'canonical');
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

			$data['heading_title'] = $product_info['name'];

			$data['text_select'] = $this->language->get('text_select');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_stock'] = $this->language->get('text_stock');
			$data['text_discount'] = $this->language->get('text_discount');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_write'] = $this->language->get('text_write');
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
			$data['text_note'] = $this->language->get('text_note');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_related'] = $this->language->get('text_related');
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
			$data['text_loading'] = $this->language->get('text_loading');
			//HCN
			$data['text_custom_desc'] = $this->language->get('text_custom_desc');
			

			$data['entry_qty'] = $this->language->get('entry_qty');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['entry_good'] = $this->language->get('entry_good');
			$data['entry_bad'] = $this->language->get('entry_bad');
			$data['entry_bad'] = $this->language->get('entry_bad');
			//HCN
			$data['entry_custom_desc'] = $this->language->get('entry_custom_desc');


			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_upload'] = $this->language->get('button_upload');
			$data['button_continue'] = $this->language->get('button_continue');

			$this->load->model('catalog/review');

			$data['tab_description'] = $this->language->get('tab_description');
			$data['tab_attribute'] = $this->language->get('tab_attribute');
			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$this->request->get['product_id'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			//HCN
			$data['custom_desc'] = html_entity_decode($product_info['custom_desc'], ENT_QUOTES, 'UTF-8');
			

			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($product_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['images'] = array();
			$data['madanes_image'] = $product_info['image'];
			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
				);
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$raw_orig_price = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
			} else {
				$data['price'] = false;
				$raw_orig_price = false;
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$new_price = $this->currency->format($this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$raw_price = $this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
				$data['new_price'] = $new_price;
			} else {
				$new_price = false;
				$raw_price = false;
			}


			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}

			$data['options'] = array();

			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
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

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$data['rating'] = (int)$product_info['rating'];

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$data['share'] = $this->url->link('product/vendor/view', 'name='.$name.'&product_id=' . (int)$this->request->get['product_id']);

			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

			$data['products'] = array();

			//===============================
			// START of CONVERSION
			//===============================
			$currency = $this->session->data['currency'];
			if($currency == "USD"){

				//From Currency
				$from_currency ="PHP";
				 
				//To Currency
				$to_currency ="USD";
				
				
				$url    = "https://finance.google.com/finance/converter?a=100&from=PHP&to=USD";
				
				print_r($url);

				$ch     = curl_init();
				$timeout= 0;
				 
				curl_setopt ($ch, CURLOPT_URL, $url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				 
				$rawdata = curl_exec($ch);
				curl_close($ch);
				print_r($rawdata);

				$raw_orig_price = "10000";
				///$raw_orig_price = $this->convert('PHP', 'USD', $raw_orig_price);
				$raw_orig_price = round($raw_orig_price,2);
				$price = $this->currency->format($this->tax->calculate($raw_orig_price, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				//echo "Code: $this->convert('USD', 'THB', 1);<br>";
				
				$raw_price = $this->convert('PHP', 'USD', $raw_price);
				$raw_price = round($raw_price,2);
				/*echo '<pre>';
				print_r($raw_price);
				echo '</pre>';*/
				$raw_price = $this->currency->format($this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$new_price = $raw_price;
			}else{
				$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$new_price = $this->currency->format($this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			}

			$data['new_price'] = $new_price;
			$data['price'] = $price;

			//$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
			//original
		
			$results = $this->model_catalog_vendor->getProductRelated($this->request->get['product_id'],$vendor_id);

			$currency = $this->session->data['currency'];
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$raw_orig_price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
				} else {
					$price = false;
					$raw_orig_price = false;
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



				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'new_price'		=> $new_price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'custom_desc' => $result['custom_desc'],
					'href'        => $this->url->link('product/vendor/view', 'name='.$name.'&product_id=' . $result['product_id'])
				);
			}

			$data['tags'] = array();

			if ($product_info['tag']) {
				$tags = explode(',', $product_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}

			$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);

			$this->model_catalog_product->updateViewed($this->request->get['product_id']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header3');
			
			//==========
			// If Madanes show diff template
			//==========

			
				$data['product_type'] = $product_info['model'];
				$data['continue'] = $vendor_name;
				$this->response->setOutput($this->load->view('product/vendor_madanes_view', $data));
			
			
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header3');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}

	}

	public function madanes_php(){
		//===============================
		// START of CONVERSION
		//===============================

		$redirect = '';

		if ($this->cart->hasShipping()) {
			// Validate if shipping address has been set.
			if (!isset($this->session->data['shipping_address'])) {
				$redirect = $this->url->link('checkout/checkout', '', true);
			}

			// Validate if shipping method has been set.
			if (!isset($this->session->data['shipping_method'])) {
				$redirect = $this->url->link('checkout/checkout', '', true);
			}
		} else {
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}

		// Validate if payment address has been set.
		if (!isset($this->session->data['payment_address'])) {
			$redirect = $this->url->link('checkout/checkout', '', true);
		}

		// Validate if payment method has been set.
		if (!isset($this->session->data['payment_method'])) {
			$redirect = $this->url->link('checkout/checkout', '', true);
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();
		
		//$this->session->data['madanes_currency'] = "PHP";

		$admin_fee = 0;//added by HCN
		foreach ($products as $product) {
			$product_total = 0;

			/**
			Added by HCN
			**/
			if($product['model'] == "ERVPA40" || $product['model'] == "ERVPA60" || $product['model'] == "ERVPA80" || $product['model'] == "ERVPK40" || $product['model'] == "ERVPK60" || $product['model'] == "ERVPK80" || $product['model'] == "DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCA" || $product['model'] == "MDCK" || $product['model'] ==  "PEARLNP60A1" || $product['model'] ==  "EMERALDNP80A1" || $product['model'] ==  "DIAMONDNP100A1" || $product['model'] ==  "PEARLP60A1" || $product['model'] ==  "EMERALDP80A1" || $product['model'] ==  "DIAMONDP100A1" || $product['model'] ==  "PEARLNP60A2" || $product['model'] ==  "EMERALDNP80A2" || $product['model'] ==  "DIAMONDNP100A2" || $product['model'] ==  "PEARLP60A2" || $product['model'] ==  "EMERALDP80A2" || $product['model'] ==  "DIAMONDP100A2" || $product['model'] ==  "PEARLNP60K" || $product['model'] ==  "EMERALDNP80K" || $product['model'] ==  "DIAMONDNP100K" || $product['model'] ==  "PEARLP60K" || $product['model'] ==  "EMERALDP80K" || $product['model'] ==  "DIAMONDP100K" || $product['model'] ==  "PEARLNPW60A1" || $product['model'] ==  "EMERALDNPW80A1" || $product['model'] ==  "DIAMONDNPW100A1" || $product['model'] ==  "PEARLPW60A1" || $product['model'] ==  "EMERALDPW80A1" || $product['model'] ==  "DIAMONDPW100A1" || $product['model'] ==  "PEARLNPW60A2" || $product['model'] ==  "EMERALDNPW80A2" || $product['model'] ==  "DIAMONDNPW100A2" || $product['model'] ==  "PEARLPW60A2" || $product['model'] ==  "EMERALDPW80A2" || $product['model'] ==  "DIAMONDPW100A2" || $product['model'] ==  "PEARLNPW60K" || $product['model'] ==  "EMERALDNPW80K" || $product['model'] ==  "DIAMONDNPW100K" || $product['model'] ==  "PEARLPW60K" || $product['model'] ==  "EMERALDPW80K" || $product['model'] ==  "DIAMONDPW100K" ){
			
		/*	if($product['model'] == "ERVPA40" || $product['model'] == "ERVPA60" || $product['model'] == "ERVPA80" || $product['model'] == "ERVPK40" || $product['model'] == "ERVPK60" || $product['model'] == "ERVPK80" || $product['model'] == "DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCA" || $product['model'] == "MDCK"){*/
				$admin_fee = 1;
				
			}
			/*
			IF VENDOR CODE is TELETECH , admin fee = 0
			*/
			if(isset($this->session->data['certno'])){
				$admin_fee = 0;
			}
			if(isset($this->session->data['vendor_name'])){
				if($this->session->data['vendor_name']=="Madanes"){
					$admin_fee = 0;
				}
				
			}
			
			//**********************************************end*****************************//
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$redirect = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!$redirect) {
			$order_data = array();

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array. 
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
			
			$this->load->model('extension/extension');

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
					
					if($admin_fee == 0){
						if($result['code'] == "customot"){
							
						}else{
							$this->{'model_total_' . $result['code']}->getTotal($total_data);		
						}
					}else{
						
						$this->{'model_total_' . $result['code']}->getTotal($total_data);
					}
					//$this->{'model_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			//echo '<pre>';
			//print_r($totals);
			//echo '</pre>';
			
			array_multisort($sort_order, SORT_ASC, $totals);

			$order_data['totals'] = $totals;

			$this->load->language('checkout/checkout');

			$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$order_data['store_id'] = $this->config->get('config_store_id');
			$order_data['store_name'] = $this->config->get('config_name');

			if ($order_data['store_id']) {
				$order_data['store_url'] = $this->config->get('config_url');
			} else {
				$order_data['store_url'] = HTTP_SERVER;
			}

			if ($this->customer->isLogged()) {
				$this->load->model('account/customer');

				$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

				$order_data['customer_id'] = $this->customer->getId();
				$order_data['customer_group_id'] = $customer_info['customer_group_id'];
				$order_data['firstname'] = $customer_info['firstname'];
				$order_data['lastname'] = $customer_info['lastname'];
				$order_data['email'] = $customer_info['email'];
				$order_data['telephone'] = $customer_info['telephone'];
				$order_data['fax'] = $customer_info['fax'];
				$order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
			} elseif (isset($this->session->data['guest'])) {
				$order_data['customer_id'] = 0;
				$order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
				$order_data['firstname'] = $this->session->data['guest']['firstname'];
				$order_data['lastname'] = $this->session->data['guest']['lastname'];
				$order_data['email'] = $this->session->data['guest']['email'];
				$order_data['telephone'] = $this->session->data['guest']['telephone'];
				$order_data['fax'] = $this->session->data['guest']['fax'];
				$order_data['custom_field'] = $this->session->data['guest']['custom_field'];
			}
			//edited by HCN
			$order_data['first_time'] = $this->session->data['guest']['first_time'];

			$order_data['payment_firstname'] = $this->session->data['payment_address']['firstname'];
			$order_data['payment_lastname'] = $this->session->data['payment_address']['lastname'];
			$order_data['payment_company'] = $this->session->data['payment_address']['company'];
			$order_data['payment_address_1'] = $this->session->data['payment_address']['address_1'];
			$order_data['payment_address_2'] = $this->session->data['payment_address']['address_2'];
			$order_data['payment_city'] = $this->session->data['payment_address']['city'];
			$order_data['payment_postcode'] = $this->session->data['payment_address']['postcode'];
			$order_data['payment_zone'] = $this->session->data['payment_address']['zone'];
			$order_data['payment_zone_id'] = $this->session->data['payment_address']['zone_id'];
			$order_data['payment_country'] = $this->session->data['payment_address']['country'];
			$order_data['payment_country_id'] = $this->session->data['payment_address']['country_id'];
			$order_data['payment_address_format'] = $this->session->data['payment_address']['address_format'];
			$order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']) ? $this->session->data['payment_address']['custom_field'] : array());

			if (isset($this->session->data['payment_method']['title'])) {
				$order_data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$order_data['payment_method'] = '';
			}

			if (isset($this->session->data['payment_method']['code'])) {
				$order_data['payment_code'] = $this->session->data['payment_method']['code'];
			} else {
				$order_data['payment_code'] = '';
			}

			if ($this->cart->hasShipping()) {
				$order_data['shipping_firstname'] = $this->session->data['shipping_address']['firstname'];
				$order_data['shipping_lastname'] = $this->session->data['shipping_address']['lastname'];
				$order_data['shipping_company'] = $this->session->data['shipping_address']['company'];
				$order_data['shipping_address_1'] = $this->session->data['shipping_address']['address_1'];
				$order_data['shipping_address_2'] = $this->session->data['shipping_address']['address_2'];
				$order_data['shipping_city'] = $this->session->data['shipping_address']['city'];
				$order_data['shipping_postcode'] = $this->session->data['shipping_address']['postcode'];
				$order_data['shipping_zone'] = $this->session->data['shipping_address']['zone'];
				$order_data['shipping_zone_id'] = $this->session->data['shipping_address']['zone_id'];
				$order_data['shipping_country'] = $this->session->data['shipping_address']['country'];
				$order_data['shipping_country_id'] = $this->session->data['shipping_address']['country_id'];
				$order_data['shipping_address_format'] = $this->session->data['shipping_address']['address_format'];
				$order_data['shipping_custom_field'] = (isset($this->session->data['shipping_address']['custom_field']) ? $this->session->data['shipping_address']['custom_field'] : array());

				if (isset($this->session->data['shipping_method']['title'])) {
					$order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
				} else {
					$order_data['shipping_method'] = '';
				}

				if (isset($this->session->data['shipping_method']['code'])) {
					$order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
				} else {
					$order_data['shipping_code'] = '';
				}
			} else {
				$order_data['shipping_firstname'] = '';
				$order_data['shipping_lastname'] = '';
				$order_data['shipping_company'] = '';
				$order_data['shipping_address_1'] = '';
				$order_data['shipping_address_2'] = '';
				$order_data['shipping_city'] = '';
				$order_data['shipping_postcode'] = '';
				$order_data['shipping_zone'] = '';
				$order_data['shipping_zone_id'] = '';
				$order_data['shipping_country'] = '';
				$order_data['shipping_country_id'] = '';
				$order_data['shipping_address_format'] = '';
				$order_data['shipping_custom_field'] = array();
				$order_data['shipping_method'] = '';
				$order_data['shipping_code'] = '';
			}

			$order_data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();

				foreach ($product['option'] as $option) {
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'option_value_id'         => $option['option_value_id'],
						'name'                    => $option['name'],
						'value'                   => $option['value'],
						'type'                    => $option['type']
					);
				}

				$order_data['products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'download'   => $product['download'],
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
					'reward'     => $product['reward'],
					'product_type'	=>	$product['product_type']	//edited by HCN
				);
			}

			// Gift Voucher
			$order_data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$order_data['vouchers'][] = array(
						'description'      => $voucher['description'],
						'code'             => token(10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],
						'amount'           => $voucher['amount']
					);
				}
			}

			$order_data['comment'] = $this->session->data['comment'];
			$order_data['total'] = $total_data['total'];

			if (isset($this->request->cookie['tracking'])) {
				$order_data['tracking'] = $this->request->cookie['tracking'];

				$subtotal = $this->cart->getSubTotal();

				// Affiliate
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

				if ($affiliate_info) {
					$order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
				} else {
					$order_data['affiliate_id'] = 0;
					$order_data['commission'] = 0;
				}

				// Marketing
				$this->load->model('checkout/marketing');

				$marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

				if ($marketing_info) {
					$order_data['marketing_id'] = $marketing_info['marketing_id'];
				} else {
					$order_data['marketing_id'] = 0;
				}
			} else {
				$order_data['affiliate_id'] = 0;
				$order_data['commission'] = 0;
				$order_data['marketing_id'] = 0;
				$order_data['tracking'] = '';
			}

			$order_data['language_id'] = $this->config->get('config_language_id');
			$order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
			$order_data['currency_code'] = $this->session->data['currency'];
			$order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
			$order_data['ip'] = $this->request->server['REMOTE_ADDR'];

			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
			} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
			} else {
				$order_data['forwarded_ip'] = '';
			}

			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
			} else {
				$order_data['user_agent'] = '';
			}

			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
			} else {
				$order_data['accept_language'] = '';
			}

			$this->load->model('checkout/order');
			/*echo '<pre>';
			print_r($order_data);
			echo '</pre>';*/
			//================================
			// ADD vendor id in order table
			//================================
			if(isset($this->session->data['vendor_id'])){
				$order_data['vendor_id'] = $this->session->data['vendor_code'];	
			}else{
				$order_data['vendor_id']	= '6CA6708E-C5AC-40E9-9152-38D4ABB6664F';
				//$order_data['vendor_id']	= '';
			}
			
			if(isset($this->session->data['certno'])){
				$order_data['certno'] = $this->session->data['certno'];	
			}else{
				$order_data['certno']	= '0';
			}

			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$this->load->model('tool/upload');

			$data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
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
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}

				/*if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$new_price = $this->currency->format($this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$raw_price = $this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
					$data['new_price'] = $new_price;
				} else {
					$new_price = false;
					$raw_price = false;
				}*/


				$to_currency ="PHP";
				if($this->session->data['currency'] == $to_currency){
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), 'PHP');
					$raw_orig_price  = $product['price'];
				}else{
					$raw_orig_price = $this->convert('USD', 'PHP', $product['price']);
					$raw_orig_price = round($raw_orig_price,2);

					

					$price = $this->currency->format($this->tax->calculate($raw_orig_price, $product['tax_class_id'], $this->config->get('config_tax')), 'PHP');
				}
				
				//echo "Code: $this->convert('USD', 'THB', 1);<br>";
				
				
				//print_r('PHP - '.$price);


				$data['products'][] = array(
					'cart_id'    => $product['cart_id'],
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'recurring'  => $recurring,
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $price,
					'total'      => $this->currency->format($this->tax->calculate($raw_orig_price, $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], 'PHP'),
					'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
					);
				}
			}

			$data['totals'] = array();
			
			foreach ($order_data['totals'] as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
				);
			}

			$data['payment'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);
			
		} else {
			$data['redirect'] = $redirect;
		}

		$this->response->setOutput($this->load->view('checkout/confirm', $data));
	}


	public function madanes_usd(){
		//===============================
		// START of CONVERSION
		//===============================

		$redirect = '';

		if ($this->cart->hasShipping()) {
			// Validate if shipping address has been set.
			if (!isset($this->session->data['shipping_address'])) {
				$redirect = $this->url->link('checkout/checkout', '', true);
			}

			// Validate if shipping method has been set.
			if (!isset($this->session->data['shipping_method'])) {
				$redirect = $this->url->link('checkout/checkout', '', true);
			}
		} else {
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}

		// Validate if payment address has been set.
		if (!isset($this->session->data['payment_address'])) {
			$redirect = $this->url->link('checkout/checkout', '', true);
		}

		// Validate if payment method has been set.
		if (!isset($this->session->data['payment_method'])) {
			$redirect = $this->url->link('checkout/checkout', '', true);
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();
		
		//$this->session->data['madanes_currency'] = "PHP";

		$admin_fee = 0;//added by HCN
		foreach ($products as $product) {
			$product_total = 0;

			/**
			Added by HCN
			**/
			if($product['model'] == "ERVPA40" || $product['model'] == "ERVPA60" || $product['model'] == "ERVPA80" || $product['model'] == "ERVPK40" || $product['model'] == "ERVPK60" || $product['model'] == "ERVPK80" || $product['model'] == "DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCA" || $product['model'] == "MDCK" || $product['model'] ==  "PEARLNP60A1" || $product['model'] ==  "EMERALDNP80A1" || $product['model'] ==  "DIAMONDNP100A1" || $product['model'] ==  "PEARLP60A1" || $product['model'] ==  "EMERALDP80A1" || $product['model'] ==  "DIAMONDP100A1" || $product['model'] ==  "PEARLNP60A2" || $product['model'] ==  "EMERALDNP80A2" || $product['model'] ==  "DIAMONDNP100A2" || $product['model'] ==  "PEARLP60A2" || $product['model'] ==  "EMERALDP80A2" || $product['model'] ==  "DIAMONDP100A2" || $product['model'] ==  "PEARLNP60K" || $product['model'] ==  "EMERALDNP80K" || $product['model'] ==  "DIAMONDNP100K" || $product['model'] ==  "PEARLP60K" || $product['model'] ==  "EMERALDP80K" || $product['model'] ==  "DIAMONDP100K" || $product['model'] ==  "PEARLNPW60A1" || $product['model'] ==  "EMERALDNPW80A1" || $product['model'] ==  "DIAMONDNPW100A1" || $product['model'] ==  "PEARLPW60A1" || $product['model'] ==  "EMERALDPW80A1" || $product['model'] ==  "DIAMONDPW100A1" || $product['model'] ==  "PEARLNPW60A2" || $product['model'] ==  "EMERALDNPW80A2" || $product['model'] ==  "DIAMONDNPW100A2" || $product['model'] ==  "PEARLPW60A2" || $product['model'] ==  "EMERALDPW80A2" || $product['model'] ==  "DIAMONDPW100A2" || $product['model'] ==  "PEARLNPW60K" || $product['model'] ==  "EMERALDNPW80K" || $product['model'] ==  "DIAMONDNPW100K" || $product['model'] ==  "PEARLPW60K" || $product['model'] ==  "EMERALDPW80K" || $product['model'] ==  "DIAMONDPW100K" ){
			
		/*	if($product['model'] == "ERVPA40" || $product['model'] == "ERVPA60" || $product['model'] == "ERVPA80" || $product['model'] == "ERVPK40" || $product['model'] == "ERVPK60" || $product['model'] == "ERVPK80" || $product['model'] == "DACA" || $product['model'] == "ERS" || $product['model'] == "MDC65" || $product['model'] == "MDCA" || $product['model'] == "MDCK"){*/
				$admin_fee = 1;
				
			}
			/*
			IF VENDOR CODE is TELETECH , admin fee = 0
			*/
			if(isset($this->session->data['certno'])){
				$admin_fee = 0;
			}
			if(isset($this->session->data['vendor_name'])){
				if($this->session->data['vendor_name']=="Madanes"){
					$admin_fee = 0;
				}
				
			}
			
			//**********************************************end*****************************//
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$redirect = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!$redirect) {
			$order_data = array();

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array. 
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
			
			$this->load->model('extension/extension');

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
					
					if($admin_fee == 0){
						if($result['code'] == "customot"){
							
						}else{
							$this->{'model_total_' . $result['code']}->getTotal($total_data);		
						}
					}else{
						
						$this->{'model_total_' . $result['code']}->getTotal($total_data);
					}
					//$this->{'model_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			//echo '<pre>';
			//print_r($totals);
			//echo '</pre>';
			
			array_multisort($sort_order, SORT_ASC, $totals);

			$order_data['totals'] = $totals;

			$this->load->language('checkout/checkout');

			$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$order_data['store_id'] = $this->config->get('config_store_id');
			$order_data['store_name'] = $this->config->get('config_name');

			if ($order_data['store_id']) {
				$order_data['store_url'] = $this->config->get('config_url');
			} else {
				$order_data['store_url'] = HTTP_SERVER;
			}

			if ($this->customer->isLogged()) {
				$this->load->model('account/customer');

				$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

				$order_data['customer_id'] = $this->customer->getId();
				$order_data['customer_group_id'] = $customer_info['customer_group_id'];
				$order_data['firstname'] = $customer_info['firstname'];
				$order_data['lastname'] = $customer_info['lastname'];
				$order_data['email'] = $customer_info['email'];
				$order_data['telephone'] = $customer_info['telephone'];
				$order_data['fax'] = $customer_info['fax'];
				$order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
			} elseif (isset($this->session->data['guest'])) {
				$order_data['customer_id'] = 0;
				$order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
				$order_data['firstname'] = $this->session->data['guest']['firstname'];
				$order_data['lastname'] = $this->session->data['guest']['lastname'];
				$order_data['email'] = $this->session->data['guest']['email'];
				$order_data['telephone'] = $this->session->data['guest']['telephone'];
				$order_data['fax'] = $this->session->data['guest']['fax'];
				$order_data['custom_field'] = $this->session->data['guest']['custom_field'];
			}
			//edited by HCN
			$order_data['first_time'] = $this->session->data['guest']['first_time'];

			$order_data['payment_firstname'] = $this->session->data['payment_address']['firstname'];
			$order_data['payment_lastname'] = $this->session->data['payment_address']['lastname'];
			$order_data['payment_company'] = $this->session->data['payment_address']['company'];
			$order_data['payment_address_1'] = $this->session->data['payment_address']['address_1'];
			$order_data['payment_address_2'] = $this->session->data['payment_address']['address_2'];
			$order_data['payment_city'] = $this->session->data['payment_address']['city'];
			$order_data['payment_postcode'] = $this->session->data['payment_address']['postcode'];
			$order_data['payment_zone'] = $this->session->data['payment_address']['zone'];
			$order_data['payment_zone_id'] = $this->session->data['payment_address']['zone_id'];
			$order_data['payment_country'] = $this->session->data['payment_address']['country'];
			$order_data['payment_country_id'] = $this->session->data['payment_address']['country_id'];
			$order_data['payment_address_format'] = $this->session->data['payment_address']['address_format'];
			$order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']) ? $this->session->data['payment_address']['custom_field'] : array());

			if (isset($this->session->data['payment_method']['title'])) {
				$order_data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$order_data['payment_method'] = '';
			}

			if (isset($this->session->data['payment_method']['code'])) {
				$order_data['payment_code'] = $this->session->data['payment_method']['code'];
			} else {
				$order_data['payment_code'] = '';
			}

			if ($this->cart->hasShipping()) {
				$order_data['shipping_firstname'] = $this->session->data['shipping_address']['firstname'];
				$order_data['shipping_lastname'] = $this->session->data['shipping_address']['lastname'];
				$order_data['shipping_company'] = $this->session->data['shipping_address']['company'];
				$order_data['shipping_address_1'] = $this->session->data['shipping_address']['address_1'];
				$order_data['shipping_address_2'] = $this->session->data['shipping_address']['address_2'];
				$order_data['shipping_city'] = $this->session->data['shipping_address']['city'];
				$order_data['shipping_postcode'] = $this->session->data['shipping_address']['postcode'];
				$order_data['shipping_zone'] = $this->session->data['shipping_address']['zone'];
				$order_data['shipping_zone_id'] = $this->session->data['shipping_address']['zone_id'];
				$order_data['shipping_country'] = $this->session->data['shipping_address']['country'];
				$order_data['shipping_country_id'] = $this->session->data['shipping_address']['country_id'];
				$order_data['shipping_address_format'] = $this->session->data['shipping_address']['address_format'];
				$order_data['shipping_custom_field'] = (isset($this->session->data['shipping_address']['custom_field']) ? $this->session->data['shipping_address']['custom_field'] : array());

				if (isset($this->session->data['shipping_method']['title'])) {
					$order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
				} else {
					$order_data['shipping_method'] = '';
				}

				if (isset($this->session->data['shipping_method']['code'])) {
					$order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
				} else {
					$order_data['shipping_code'] = '';
				}
			} else {
				$order_data['shipping_firstname'] = '';
				$order_data['shipping_lastname'] = '';
				$order_data['shipping_company'] = '';
				$order_data['shipping_address_1'] = '';
				$order_data['shipping_address_2'] = '';
				$order_data['shipping_city'] = '';
				$order_data['shipping_postcode'] = '';
				$order_data['shipping_zone'] = '';
				$order_data['shipping_zone_id'] = '';
				$order_data['shipping_country'] = '';
				$order_data['shipping_country_id'] = '';
				$order_data['shipping_address_format'] = '';
				$order_data['shipping_custom_field'] = array();
				$order_data['shipping_method'] = '';
				$order_data['shipping_code'] = '';
			}

			$order_data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();

				foreach ($product['option'] as $option) {
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'option_value_id'         => $option['option_value_id'],
						'name'                    => $option['name'],
						'value'                   => $option['value'],
						'type'                    => $option['type']
					);
				}

				$order_data['products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'download'   => $product['download'],
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
					'reward'     => $product['reward'],
					'product_type'	=>	$product['product_type']	//edited by HCN
				);
			}

			// Gift Voucher
			$order_data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$order_data['vouchers'][] = array(
						'description'      => $voucher['description'],
						'code'             => token(10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],
						'amount'           => $voucher['amount']
					);
				}
			}

			$order_data['comment'] = $this->session->data['comment'];
			$order_data['total'] = $total_data['total'];

			if (isset($this->request->cookie['tracking'])) {
				$order_data['tracking'] = $this->request->cookie['tracking'];

				$subtotal = $this->cart->getSubTotal();

				// Affiliate
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

				if ($affiliate_info) {
					$order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
				} else {
					$order_data['affiliate_id'] = 0;
					$order_data['commission'] = 0;
				}

				// Marketing
				$this->load->model('checkout/marketing');

				$marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

				if ($marketing_info) {
					$order_data['marketing_id'] = $marketing_info['marketing_id'];
				} else {
					$order_data['marketing_id'] = 0;
				}
			} else {
				$order_data['affiliate_id'] = 0;
				$order_data['commission'] = 0;
				$order_data['marketing_id'] = 0;
				$order_data['tracking'] = '';
			}

			$order_data['language_id'] = $this->config->get('config_language_id');
			$order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
			$order_data['currency_code'] = $this->session->data['currency'];
			$order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
			$order_data['ip'] = $this->request->server['REMOTE_ADDR'];

			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
			} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
			} else {
				$order_data['forwarded_ip'] = '';
			}

			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
			} else {
				$order_data['user_agent'] = '';
			}

			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
			} else {
				$order_data['accept_language'] = '';
			}

			$this->load->model('checkout/order');
			/*echo '<pre>';
			print_r($order_data);
			echo '</pre>';*/
			//================================
			// ADD vendor id in order table
			//================================
			if(isset($this->session->data['vendor_id'])){
				$order_data['vendor_id'] = $this->session->data['vendor_code'];	
			}else{
				$order_data['vendor_id']	= '6CA6708E-C5AC-40E9-9152-38D4ABB6664F';
				//$order_data['vendor_id']	= '';
			}
			
			if(isset($this->session->data['certno'])){
				$order_data['certno'] = $this->session->data['certno'];	
			}else{
				$order_data['certno']	= '0';
			}

			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$this->load->model('tool/upload');

			$data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
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
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}

				/*if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$new_price = $this->currency->format($this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$raw_price = $this->tax->calculate($product_info['new_price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
					$data['new_price'] = $new_price;
				} else {
					$new_price = false;
					$raw_price = false;
				}*/


				//CONVERT PESO TO USD
				$to_currency ="USD";
				
				$data['usd_value'] = "";
				$this->session->data['usd_value'] = $data['usd_value'];
				$results = $this->model_localisation_currency->getCurrencies();   
				$usd = "";
				foreach ($results as $result) {					
				     
				    
				    if($result['code'] == "USD"){
				    	
				     	$data['usd_value'] = $result['value'];
				     	$this->session->data['usd_value'] = $data['usd_value'];
				     	$usd = $result['value'];
				    }
				           
				    
				 }
				
				$raw_orig_price = ($product['price']/$usd);

				//$raw_orig_price = $product['price'];
				/*$raw_orig_price = $this->convert('PHP', 'USD', $product['price']);*/
				$raw_orig_price = round($raw_orig_price,2);

				

				//$price = $this->currency->format($this->tax->calculate($raw_orig_price, $product['tax_class_id'], $this->config->get('config_tax')), 'USD');
				$price = "$".$raw_orig_price;
				//echo "Code: $this->convert('USD', 'THB', 1);<br>";
								
				$data['products'][] = array(
					'cart_id'    => $product['cart_id'],
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'recurring'  => $recurring,
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $price,
					'total'      => "$".($raw_orig_price * $product['quantity']),
					'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
					);
				}
			}

			$data['totals'] = array();
			
			foreach ($order_data['totals'] as $total) {
				
				//ORIGINAL SCRIPT FOR CONVERTION
				// $raw_orig_value = $this->convert('PHP', 'USD', $total['value']);
				// $raw_orig_value = round($raw_orig_price,2);

				$raw_orig_price = round($total['value']/$usd,2);
				

				/*$price_value = $this->currency->format($this->tax->calculate($raw_orig_price, $product['tax_class_id'], $this->config->get('config_tax')), 'USD');*/
				$price_value = "$".$raw_orig_price;


				$data['totals'][] = array(
					'title' => $total['title'],
					//'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
					'text'  => $price_value
				);
			}

			$data['payment'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);
			
		} else {
			$data['redirect'] = $redirect;
		}

		$this->response->setOutput($this->load->view('checkout/confirm', $data));
	}
}