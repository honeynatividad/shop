<?php
class ControllerModuleBossRefinesearch extends Controller {
	public function index() {
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		$setting = $this->config->get('boss_refinesearch_module');
//echo '<pre>';print_r($setting);echo '</pre>';
		$category_id = end($parts);

		$this->load->model('catalog/category');
		
		$this->load->model('bossthemes/boss_refinesearch');

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$this->load->language('module/boss_refinesearch');

			$data['heading_title'] = $this->language->get('heading_title');

			$data['button_filter'] = $this->language->get('button_filter');

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

			$data['action'] = str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url));

			if (isset($this->request->get['filter'])) {
				$data['filter_category'] = explode(',', $this->request->get['filter']);
			} else {
				$data['filter_category'] = array();
			}

			$this->load->model('catalog/product');

			$data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {
						$filter_data = array(
							'filter_category_id' => $category_id,
							'filter_filter'      => $filter['filter_id']
						);
						
						$result = $this->model_bossthemes_boss_refinesearch->getFilterImage($filter['filter_id']);
						
						if(!empty($result)){
							$image = $this->model_tool_image->resize($result['image'], isset($setting['image_width'])?$setting['image_width']:20,isset($setting['image_height'])?$setting['image_height']:20);
						}else{
							$image = '';
						}

						$childen_data[] = array(
							'filter_id' => $filter['filter_id'],
							'image' 	=> $image,
							'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')
						);
					}

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'show_image'      => isset($setting[$filter_group['filter_group_id']]['display'])?$setting[$filter_group['filter_group_id']]['display']:'image',
						'show_product'    => isset($setting[$filter_group['filter_group_id']]['under'])?$setting[$filter_group['filter_group_id']]['under']:0,
						'filter'          => $childen_data
					);
				}
				
				//echo '<pre>';print_r($data['filter_groups']);echo '</pre>';

				
					return $this->load->view('module/boss_refinesearch', $data);
				
			}
		}
	}
}