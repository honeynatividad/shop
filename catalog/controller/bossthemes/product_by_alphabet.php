<?php  
class ControllerBossthemesProductByAlphabet extends Controller {
	public function index() { 
			
		$this->language->load('bossthemes/product_by_alphabet');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image'); 
							
		if (isset($this->request->get['c'])) {
			$char = $this->request->get['c'];
		} else {
			$char = "0";
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
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme').'_product_limit');
		}

		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
		if (isset($char)) {
			$this->document->setTitle(sprintf($this->language->get('heading_title'), $char));
			
			$url = '';
			
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
       			'text'      => sprintf($this->language->get('heading_title'), $char),
				'href'      => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . $url),
      			'separator' => $this->language->get('text_separator')
   			);
		
			$data['heading_title'] = sprintf($this->language->get('heading_title'), strtoupper($char));
			
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));	$data['text_display'] = $this->language->get('text_display');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');			
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');
			  
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			
			$data['compare'] = $this->url->link('product/compare');
			
			$data['products'] = array();
			
			$data_sort = array(
				'alphabet' 				 => $char, 
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);
					
			$product_total = $this->myGetTotalProducts($data_sort);
								
			$results = $this->myGetProducts($data_sort);
					
			foreach ($results as $result) {
				if ($result['image']) {					
					$module_label = $this->config->get('boss_label_products_setting');
					if(isset($module_label) && $module_label['alphabet_page'] == 1){							
						$this->load->model('bosslabelproducts/bossimage');					
						$checklabel = $this->model_bosslabelproducts_bossimage->checkLabel($result['product_id']);					
						if($checklabel == 1){
							$image = $this->model_bosslabelproducts_bossimage->label_resize($result['image'], $this->config->get($this->config->get('config_theme').'_image_product_width'), $this->config->get($this->config->get('config_theme').'_image_product_height'), $result['product_id']);					
						}else{
							$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme').'_image_product_width'), $this->config->get($this->config->get('config_theme').'_image_product_height'));
						}
					}else{
						$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme').'_image_product_width'), $this->config->get($this->config->get('config_theme').'_image_product_height'));
					}
				} else {
					$image = false;
				}
				
				if (($this->config->get($this->config->get('config_theme').'_customer_price') && $this->customer->isLogged()) || !$this->config->get($this->config->get('config_theme').'_customer_price')) {
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
				
				if ($this->config->get($this->config->get('config_theme').'_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
			
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', $url . '&product_id=' . $result['product_id'])
				);
			}
					
			$url = '';
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
						
			$data['sorts'] = array();
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=p.sort_order&order=ASC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=pd.name&order=ASC' . $url)
			); 
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=pd.name&order=DESC' . $url)
			);
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=p.price&order=ASC' . $url)
			); 
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=p.price&order=DESC' . $url)
			); 
			
			if ($this->config->get($this->config->get('config_theme').'_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=rating&order=DESC' . $url)
				); 
				
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=rating&order=ASC' . $url)
				);
			}
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=p.model&order=ASC' . $url)
			); 
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . '&sort=p.model&order=DESC' . $url)
			);
	
			$url = '';
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			
			$data['limits'] = array();

			$limits = array_unique(array($this->config->get($this->config->get('config_theme').'_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,					
					'href'  => $this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . $url . '&limit=' . $value)
				);
			}		
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
			/*		
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('bossthemes/product_by_alphabet','c=' . $this->request->get['c'] .  $url . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			*/
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('bossthemes/product_by_alphabet','c=' . $this->request->get['c'] .  $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$this->document->addLink($this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . $url . '&page=' . $pagination->page), 'canonical');

			if ($pagination->limit && ceil($pagination->total / $pagination->limit) > $pagination->page) {
				$this->document->addLink($this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . $url . '&page=' . ($pagination->page + 1)), 'next');
			}

			if ($pagination->page > 1) {
				$this->document->addLink($this->url->link('bossthemes/product_by_alphabet', 'c=' . $this->request->get['c'] . $url . '&page=' . ($pagination->page - 1)), 'prev');
			}
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			
			$data['continue'] = $this->url->link('common/home');
			
			//$this->response->setOutput($this->render());
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');			
			
						
				$this->response->setOutput($this->load->view('bossthemes/product_by_alphabet', $data));		
			
		} 
		else { 
			$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

      		$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');

			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');			
			
							
				$this->response->setOutput($this->load->view('error/not_found', $data));		
			
			
		}										
  	}
	
	private function myGetProducts($data = array()) {
		
			$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)"; 
			
			$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
			
			if (isset($data['alphabet'])) {
				$sql .= " AND (";
			
				$word = $data['alphabet'];
				if ($word == "0")
					$sql .= "UPPER(LEFT(pd.name,1)) NOT BETWEEN 'A' AND 'Z'";
				else
					$sql .= "LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($word)) . "%'";
				
				$sql .= ")";
			}
			
			$sql .= " GROUP BY p.product_id";
			
			$sort_data = array(
				'pd.name',
				'p.model',
				'p.quantity',
				'p.price',
				'rating',
				'p.sort_order',
				'p.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$product_data = array();
					
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
			}
			
		return $product_data;
	}
	
	private function myGetTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";

		$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (isset($data['alphabet'])) {
			$sql .= " AND (";					
			$word = $data['alphabet'];
			if ($word == "0")
				$sql .= "UPPER(LEFT(pd.name,1)) NOT BETWEEN 'A' AND 'Z'";
			else
				$sql .= "LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($word)) . "%'";
			
			$sql .= ")";
		}
		
		$query = $this->db->query($sql);
		//echo'<pre>';print_r($query);echo'</pre>';die();
		return $query->row['total'];
	}
}
?>