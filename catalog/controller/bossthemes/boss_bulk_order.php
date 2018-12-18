<?php  
class ControllerBossthemesBossBulkOrder extends Controller {
	public function index() {
		$setting = $this->config->get('boss_bulk_order');
		$this->load->model('bossthemes/boss_bulk_order');
		$this->load->language('bossthemes/boss_bulk_order');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if(isset($setting['status']) && $setting['status']){
			$this->load->model('catalog/product');
			$this->load->model('bossthemes/option');
			$this->document->addScript('catalog/view/javascript/bossthemes/ui/jquery-ui.min.js');
			$this->document->addStyle('catalog/view/javascript/bossthemes/ui/jquery-ui.min.css');
			if (isset($this->request->get['fc'])) {
				$filter_category_id = $this->request->get['fc'];
			} else {
				$filter_category_id = '';
			}
			if (isset($this->request->get['fn'])) {
				$filter_name = $this->request->get['fn'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['ft'])) {
				$filter_tag = $this->request->get['ft'];
			} else {
				$filter_tag = '';
			}

			if (isset($this->request->get['fm'])) {
				$filter_model = $this->request->get['fm'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['fmin'])) {
				$b_filter_price_min = $this->request->get['fmin'];
			} else {
				$b_filter_price_min = isset($setting['price_min'])?$setting['price_min']:1;
			}
			if (isset($this->request->get['fmax'])) {
				$b_filter_price_max = $this->request->get['fmax'];
			} else {
				$b_filter_price_max = isset($setting['price_max'])?$setting['price_max']:1200;
			}

			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.date_added';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'DESC';
			}

			if (isset($this->request->get['p'])) {
				$page = $this->request->get['p'];
			} else {
				$page = 1;
			}
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = (int)isset($setting['num_products'])?$setting['num_products']:20;
			}
			
			$image_width = (int)isset($setting['image_width'])?$setting['image_width']:40;
			$image_height = (int)isset($setting['image_height'])?$setting['image_height']:40;
			$data['search_product'] = isset($setting['search_product'])?$setting['search_product']:0;
			$data['search_category'] = isset($setting['search_category'])?$setting['search_category']:0;
			$data['search_model'] = isset($setting['search_model'])?$setting['search_model']:0;
			$data['search_tags'] = isset($setting['search_tags'])?$setting['search_tags']:0;
			$data['search_price'] = isset($setting['search_price'])?$setting['search_price']:0;
			$data['b_filter_price_min_d'] = isset($setting['price_min'])?$setting['price_min']:1;
			$data['b_filter_price_max_d'] = isset($setting['price_max'])?$setting['price_max']:1200;
			$code_currency = $this->session->data['currency'];
			$symbolLeft = $this->currency->getSymbolLeft($code_currency);
			$symbolRight = $this->currency->getSymbolRight($code_currency);
			$data['symbolLeft'] = $symbolLeft;
			$data['symbolRight'] = $symbolRight;
			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_heading_title'),
				'href' => $this->url->link('bossthemes/boss_bulk_order')
			);

			
			$data['products'] = array();

			$filter_data = array(
				'filter_category_id'	  => $filter_category_id,
				'filter_name'	  => $filter_name,
				'filter_model'	  => $filter_model,
				'b_filter_price_min'	  => $b_filter_price_min,
				'b_filter_price_max'	  => $b_filter_price_max,
				'filter_tag'	  => $filter_tag,
				'sort'            => $sort,
				'order'           => $order,
				'start'           => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$get_options = isset($setting['option'])?$setting['option']:'';
			$option_shows = array();
			$arr_sort = array();
			$option_id_show = array();
			if(!empty($get_options)){
				foreach($get_options as $key => $id_show){
					$option_info = $this->model_bossthemes_option->getOption($key);
					$option_shows[] = array(
						'option_id' => $option_info['option_id'],
						'option_name' => $option_info['name'],
						'option_type' => $option_info['type'],
						'sort_order' => $option_info['sort_order'],
					);
					$arr_sort[] = $option_info['sort_order'];
					$option_id_show[] = $option_info['option_id'];
				}
			}
			
			array_multisort($arr_sort,$option_shows);
			
			$data['option_id_show'] = $option_shows;
			$this->load->model('tool/image');

			$product_total = $this->model_bossthemes_boss_bulk_order->getTotalProducts($filter_data);
			$results = $this->model_bossthemes_boss_bulk_order->getProducts($filter_data);
			$data['products'] = array();
			if(!empty($results) && is_array($results)){
				foreach ($results as $result) {
					if (is_file(DIR_IMAGE . $result['image'])) {
						$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
					} else {
						$image = $this->model_tool_image->resize('no_image.png', $image_width, $image_height);
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
					$options = array();
					$product_info = $this->model_catalog_product->getProduct($result['product_id']);
					foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
						if (in_array($option['option_id'], $option_id_show)) {
							$product_option_value_data = array();

							foreach ($option['product_option_value'] as $option_value) {
								if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
									if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
										$price_p = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
									} else {
										$price_p = false;
									}

									$product_option_value_data[] = array(
										'product_option_value_id' => $option_value['product_option_value_id'],
										'option_value_id'         => $option_value['option_value_id'],
										'name'                    => $option_value['name'],
										'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
										'price'                   => $price_p,
										'price_prefix'            => $option_value['price_prefix'],										
									);
								}
							}

							$options[] = array(
								'product_option_id'    => $option['product_option_id'],
								'product_option_value' => $product_option_value_data,
								'option_id'            => $option['option_id'],
								'name'                 => $option['name'],
								'type'                 => $option['type'],
								'value'                => $option['value'],
								'required'             => $option['required']
							);
						}
					}
					$data['products'][] = array(
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'model'        => $result['model'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						'rating'      => $result['rating'],
						'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id']),
						'options' => $options
					);
					
				}
			}
			$data['heading_title'] = $this->language->get('heading_title');

			$data['entry_category'] = $this->language->get('entry_category');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_image'] = $this->language->get('entry_image');
			$data['entry_model'] = $this->language->get('entry_model');
			$data['entry_price'] = $this->language->get('entry_price');
			$data['entry_tag'] = $this->language->get('entry_tag');
			$data['text_category'] = $this->language->get('text_category');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_price_range'] = $this->language->get('text_price_range');
			$data['text_select'] = $this->language->get('text_select');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_filter'] = $this->language->get('text_filter');
			$data['text_price'] = $this->language->get('text_price');
			
			$data['button_filter'] = $this->language->get('button_filter');
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_upload'] = $this->language->get('button_upload');
			
			$this->load->model('catalog/category');
			// 3 Level Category Search
			$data['categories'] = array();

			$categories_1 = $this->model_catalog_category->getCategories(0);

			foreach ($categories_1 as $category_1) {
				$level_2_data = array();

				$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

				foreach ($categories_2 as $category_2) {
					$level_3_data = array();

					$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

					foreach ($categories_3 as $category_3) {
						$level_3_data[] = array(
							'category_id' => $category_3['category_id'],
							'name'        => $category_3['name'],
						);
					}

					$level_2_data[] = array(
						'category_id' => $category_2['category_id'],
						'name'        => $category_2['name'],
						'children'    => $level_3_data
					);
				}

				$data['categories'][] = array(
					'category_id' => $category_1['category_id'],
					'name'        => $category_1['name'],
					'children'    => $level_2_data
				);
			}
			
			
			$pagination = new PaginationAjax();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('bossthemes/boss_bulk_order',  '&page={page}', true);

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $pagination->limit) + 1 : 0, ((($page - 1) * $pagination->limit) > ($product_total - $pagination->limit)) ? $product_total : ((($page - 1) * $pagination->limit) + $pagination->limit), $product_total, ceil($product_total / $pagination->limit));

			$data['filter_name'] = $filter_name;
			$data['filter_model'] = $filter_model;
			$data['filter_category_id'] = $filter_category_id;
			$data['filter_tag'] = $filter_tag;
			$data['b_filter_price_min'] = $b_filter_price_min;
			$data['b_filter_price_max'] = $b_filter_price_max;
			
			$data['sort'] = $sort;
			$data['order'] = $order;

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			
				$this->response->setOutput($this->load->view('bossthemes/boss_bulk_order', $data));
			
		}else{
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('common/home')
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
	
	public function filter() { 
		$setting = $this->config->get('boss_bulk_order');
		$this->load->model('bossthemes/boss_bulk_order');
		$this->load->language('bossthemes/boss_bulk_order');
		if(isset($setting['status']) && $setting['status']){
			$this->load->model('catalog/product');
			$this->load->model('bossthemes/option');
			if (isset($this->request->get['fc'])) {
				$filter_category_id = $this->request->get['fc'];
			} else {
				$filter_category_id = '';
			}
			if (isset($this->request->get['fn'])) {
				$filter_name = $this->request->get['fn'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['ft'])) {
				$filter_tag = $this->request->get['ft'];
			} else {
				$filter_tag = '';
			}

			if (isset($this->request->get['fm'])) {
				$filter_model = $this->request->get['fm'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['fmin'])) {
				$b_filter_price_min = $this->request->get['fmin'];
			} else {
				$b_filter_price_min = '';
			}
			if (isset($this->request->get['fmax'])) {
				$b_filter_price_max = $this->request->get['fmax'];
			} else {
				$b_filter_price_max = '';
			}
				
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.date_added';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'DESC';
			}

			if (isset($this->request->get['p'])) {
				$page = $this->request->get['p'];
			} else {
				$page = 1;
			}
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = (int)isset($setting['num_products'])?$setting['num_products']:20;
			}
			

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_heading_title'),
				'href' => $this->url->link('bossthemes/boss_bulk_order')
			);

			$filter_data = array(
				'filter_category_id'	  => $filter_category_id,
				'filter_name'	  => $filter_name,
				'filter_model'	  => $filter_model,
				'b_filter_price_min'	  => $b_filter_price_min,
				'b_filter_price_max'	  => $b_filter_price_max,
				'filter_tag'	  => $filter_tag,
				'sort'            => $sort,
				'order'           => $order,
				'start'           => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$image_width = (int)isset($setting['image_width'])?$setting['image_width']:40;
			$image_height = (int)isset($setting['image_height'])?$setting['image_height']:40;
			$data['search_product'] = isset($setting['search_product'])?$setting['search_product']:0;
			$data['search_category'] = isset($setting['search_category'])?$setting['search_category']:0;
			$data['search_model'] = isset($setting['search_model'])?$setting['search_model']:0;
			$data['search_tags'] = isset($setting['search_tags'])?$setting['search_tags']:0;
			$data['search_price'] = isset($setting['search_price'])?$setting['search_price']:0;
			$this->load->model('tool/image');

			$get_options = $setting['option'];
			
			$option_shows = array();
			$arr_sort = array();
			$option_id_show = array();
			foreach($get_options as $key => $id_show){
				$option_info = $this->model_bossthemes_option->getOption($key);
				$option_shows[] = array(
					'option_id' => $option_info['option_id'],
					'option_name' => $option_info['name'],
					'option_type' => $option_info['type'],
					'sort_order' => $option_info['sort_order'],
				);
				$arr_sort[] = $option_info['sort_order'];
				$option_id_show[] = $option_info['option_id'];
			}
			
			array_multisort($arr_sort,$option_shows);
			
			$data['option_id_show'] = $option_shows;
			$this->load->model('tool/image');

			$product_total = $this->model_bossthemes_boss_bulk_order->getTotalProducts($filter_data);
			$results = $this->model_bossthemes_boss_bulk_order->getProducts($filter_data);
			$data['products'] = array();
			if(!empty($results)){
				foreach ($results as $result) {
					if (is_file(DIR_IMAGE . $result['image'])) {
						$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
					} else {
						$image = $this->model_tool_image->resize('no_image.png', $image_width, $image_height);
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
					$options = array();
					$get_product_options = $this->model_catalog_product->getProductOptions($result['product_id']); 
					$product_info = $this->model_catalog_product->getProduct($result['product_id']);
					foreach ($get_product_options as $option) { 
						if (in_array($option['option_id'], $option_id_show)) {
							$product_option_value_data = array();

							foreach ($option['product_option_value'] as $option_value) {
								if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
									if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
										$price_p = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
									} else {
										$price_p = false;
									}

									$product_option_value_data[] = array(
										'product_option_value_id' => $option_value['product_option_value_id'],
										'option_value_id'         => $option_value['option_value_id'],
										'name'                    => $option_value['name'],
										'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
										'price'                   => $price_p,
										'price_prefix'            => $option_value['price_prefix'],
										
									);
								}
							}

							$options[] = array(
								'product_option_id'    => $option['product_option_id'],
								'product_option_value' => $product_option_value_data,
								'option_id'            => $option['option_id'],
								'name'                 => $option['name'],
								'type'                 => $option['type'],
								'value'                => $option['value'],
								'required'             => $option['required']
							);
						}
					}
					$data['products'][] = array(
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'model'        => $result['model'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						'rating'      => $result['rating'],
						'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id']),
						'options' => $options,
					);
					
				}
			}
			$data['heading_title'] = $this->language->get('heading_title');

			$data['entry_category'] = $this->language->get('entry_category');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_image'] = $this->language->get('entry_image');
			$data['entry_model'] = $this->language->get('entry_model');
			$data['entry_price'] = $this->language->get('entry_price');
			$data['entry_tag'] = $this->language->get('entry_tag');
			$data['text_category'] = $this->language->get('text_category');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_select'] = $this->language->get('text_select');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_loading'] = $this->language->get('text_loading');
			
			$data['button_filter'] = $this->language->get('button_filter');
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_upload'] = $this->language->get('button_upload');
			
			$pagination = new PaginationAjax();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('bossthemes/boss_bulk_order/filter',  '&page={page}', true);

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $pagination->limit) + 1 : 0, ((($page - 1) * $pagination->limit) > ($product_total - $pagination->limit)) ? $product_total : ((($page - 1) * $pagination->limit) + $pagination->limit), $product_total, ceil($product_total / $pagination->limit));

			$data['filter_name'] = $filter_name;
			$data['filter_model'] = $filter_model;
			$data['filter_category_id'] = $filter_category_id;
			$data['filter_tag'] = $filter_tag;
			$data['b_filter_price_min'] = $b_filter_price_min;
			$data['b_filter_price_max'] = $b_filter_price_max;
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			$url = 'index.php?route=bossthemes/boss_bulk_order';
			if(!empty($filter_name)){
				$url .= '&fn=' . $filter_name;
			}
			if(!empty($filter_model)){
				$url .= '&fm=' . $filter_model;
			}
			if(!empty($filter_category_id)){
				$url .= '&fc=' . $filter_category_id;
			}
			if(!empty($filter_tag)){
				$url .= '&ft=' . $filter_tag;
			}
			if(!empty($b_filter_price_min)){
				$url .= '&fmin=' . $b_filter_price_min;
			}
			if(!empty($b_filter_price_max)){
				$url .= '&fmax=' . $b_filter_price_max;
			}
			//$url .= '&sort=' . $sort;
			//$url .= '&order=' . $order;
			$url .= '&p=' . $page;
			//$url .= '&limit=' . $limit;
						
			$json = array();
			$json['url'] =$url;
			$json['success'] = 'success';
			//$json['test'] = $b_filter_price_min;
			$json['output'] = $this->load->view('bossthemes/boss_bulk_order_ajax', $data);
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
		
	}
	public function autocomplete() {
		$setting = $this->config->get('boss_bulk_order');
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('bossthemes/boss_bulk_order');
			$this->load->language('bossthemes/boss_bulk_order');
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = (int)isset($setting['num_record'])?$setting['num_record']:10;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_bossthemes_boss_bulk_order->getProducts($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],					
					'price'      => $result['price']
				);
			}
			
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>