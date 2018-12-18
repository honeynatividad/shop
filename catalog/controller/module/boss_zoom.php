<?php
class ControllerModuleBossZoom extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
			$this->document->addScript('catalog/view/javascript/bossthemes/fancybox/jquery.fancybox.js');
			$this->document->addStyle('catalog/view/javascript/bossthemes/fancybox/jquery.fancybox.css');			
			if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/cloud-zoom.1.0.3.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/cloud-zoom.1.0.3.css');
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/cloud-zoom.1.0.3.css');
			}
			//echo "<pre>"; print_r($setting); echo "</pre>"; die();
			$this->load->language('module/boss_zoom');

			$data['text_view_zoom'] = $this->language->get('text_view_zoom');
			
			$data['thumb_image_width'] = $setting['boss_zoom_thumb_image_width'];
			$data['thumb_image_heigth'] = $setting['boss_zoom_thumb_image_heigth'];
			$data['zoom_image_width'] = $setting['boss_zoom_zoom_image_width'];
			$data['zoom_image_heigth'] = $setting['boss_zoom_zoom_image_heigth'];
			$data['zoom_area_width'] = $setting['boss_zoom_zoom_area_width'];
			$data['zoom_area_heigth'] = $setting['boss_zoom_zoom_area_heigth'];
			$data['addition_image_width'] = $setting['boss_zoom_addition_image_width'];
			$data['addition_image_heigth'] = $setting['boss_zoom_addition_image_heigth'];
			$data['position_zoom_area'] = $setting['boss_zoom_position_zoom_area'];
			$data['adjustX'] = $setting['boss_zoom_adjustX'];
			$data['adjustY'] = $setting['boss_zoom_adjustY'];
			$data['title_image'] = $setting['boss_zoom_title_image']; 
			$data['title_opacity'] = $setting['boss_zoom_title_opacity'];
			$data['tint'] = $setting['boss_zoom_tint'];
			$data['tintOpacity'] = $setting['boss_zoom_tint_opacity'];
			$data['softfocus'] = $setting['boss_zoom_softFocus'];
			$data['lensOpacity'] = $setting['boss_zoom_lensOpacity'];
			$data['smoothMove'] = $setting['boss_zoom_smoothMove'];
			
			if (isset($this->request->get['product_id'])) {
				$product_id = (int)$this->request->get['product_id'];
			} else {
				$product_id = 0;
			}
			//echo "<pre>"; print_r($product_id); echo "</pre>"; die();
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			$data['heading_title'] = $product_info['name'];
			
			$this->load->model('tool/image');
			$data['images'] = array();
			$results = $this->model_catalog_product->getProductImages($product_id);
			//Thumb Image
			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $data['zoom_image_width'] ,$data['zoom_image_heigth'] );
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $data['thumb_image_width'], $data['thumb_image_heigth']);
			} else {
				if($results){
					$data['popup'] = $this->model_tool_image->resize($results[0]['image'], $data['zoom_image_width'] ,$data['zoom_image_heigth'] );
					$data['thumb'] = $this->model_tool_image->resize($results[0]['image'], $data['thumb_image_width'], $data['thumb_image_heigth']);
					unset($results[0]);
				}else{
					$data['popup'] = '';
					$data['thumb'] = '';
				}
			}
			//addition image
			if ($product_info['image']) {
				$data['images'][] =  array(
					'popup' =>$this->model_tool_image->resize($product_info['image'], $data['zoom_image_width'] ,$data['zoom_image_heigth'] ),
					'addition' => $this->model_tool_image->resize($product_info['image'], $data['addition_image_width'], $data['addition_image_heigth']),
					'thumb'   => $this->model_tool_image->resize($product_info['image'], $data['thumb_image_width'], $data['thumb_image_heigth']),
				);
			}
			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $data['zoom_image_width'], $data['zoom_image_heigth']),
					'addition' => $this->model_tool_image->resize($result['image'], $data['addition_image_width'], $data['addition_image_heigth']),
					'thumb'   => $this->model_tool_image->resize($result['image'], $data['thumb_image_width'], $data['thumb_image_heigth']),
				);
			}
		
		
			return $this->load->view('module/boss_zoom', $data);
		
	}
}
?>