<?php
class ControllerModuleBossSearchAutocomplete extends Controller {

    public function index() {
        $json = array();

        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
            $this->load->model('catalog/product');
            $this->load->model('tool/image');
			
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
			} else {
				$filter_category_id = 0;
			}
			
			if (isset($this->request->get['category_id'])) {
				$category_id = $this->request->get['category_id'];
			} else {
				$category_id = 0;
			}

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
                $limit = 5;
            }
			
			$this->load->model('setting/setting');
            $module_info = current($this->model_setting_setting->getSetting("search_autocomplete"));
            $width = !empty($module_info['width']) ? $module_info['width'] : 50;
            $height = !empty($module_info['height']) ? $module_info['height'] : 50;

            $filter_data = array(
                'filter_name' => $filter_name,
                'filter_model' => $filter_model,
				'filter_category_id'  => $category_id,
				'filter_sub_category' => true,
                'start' => 0,
                'limit' => $limit
            );

            $results = $this->model_catalog_product->getProducts($filter_data);
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'],$width, $height);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $width, $width);
                }

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}
                $json[] = array(
                    'product_id' => $result['product_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'model' => $result['model'],
                    'price' => $price,
                    'special' => $special,
                    'image' => $image,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
