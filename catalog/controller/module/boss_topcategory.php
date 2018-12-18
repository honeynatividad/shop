<?php
class ControllerModuleBossTopcategory extends Controller {
    public function index($setting) {
		$this->document->addScript('catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js');
		
		$this->load->language('module/boss_manager');
		$data['entry_product'] = $this->language->get('entry_product');
		
		if(empty($setting)) return;
        static $module = 0;
		
		$data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$data['categories'] = array();
	
		
		if (isset($setting['boss_topcategory_check'])) {
			$categories = $setting['boss_topcategory_check'];
			
			foreach($categories as $category_id){
                $children_data = array();
				$filter_data = array(
				'filter_category_id'  => $category_id,
				'filter_sub_category' => true
				);

    			$children = $this->model_catalog_category->getCategories($category_id);
    
    			foreach ($children as $child) {
    
    				$children_data[] = array(
    					'category_id' => $child['category_id'],
    					'name'        => $child['name'],
    					'href'        => $this->url->link('product/category', 'path=' . $category_id . '_' . $child['category_id'])	
    				);		
    			}
                
				$catagory_name = array();
				
				$catagory_name = $this->model_catalog_category->getCategory($category_id);
				
				if (isset($catagory_name['image']) && $catagory_name['image']) {
					$image = $this->model_tool_image->resize($catagory_name['image'], isset($setting['image_width'])?$setting['image_width']:80, isset($setting['image_height'])?$setting['image_height']:80);
				} else {
					$image = false;
				}
				$data['categories'][] = array(
						'title'	 		 =>	isset($catagory_name['name'])?$catagory_name['name']:'',
						'count'		=> $this->model_catalog_product->getTotalProducts($filter_data),
						'href'        => $this->url->link('product/category', 'path=' . $category_id),	
						'image'       => $image,
                        'children_data'     => $children_data
				);
			}
		}
		//echo '<pre>'; print_r($setting); die(); echo '</pre>';
		if(isset($setting['per_row'])){
			if(((int)$setting['per_row']) > 8){
				$data['per_row'] = 5;
			}else{
				$data['per_row'] = $setting['per_row'];
			}
		}else{
			$data['per_row'] = 5;
		}
		if(isset($setting['image_width'])){
			$data['image_width'] = $setting['image_width'];
		}else{
			$data['image_width'] = 200;
		}
		
		if(isset($setting['image_height'])){
			$data['image_height'] = $setting['image_height'];
		}else{
			$data['image_height'] = 200;
		}
		
		if(isset($setting['show_slider'])){
			$data['show_slider'] = $setting['show_slider'];
		}else{
			$data['show_slider'] = true;
		}
		$data['module'] = $module++; 
       
	  
		
			return $this->load->view('module/boss_topcategory', $data);
		
    }
}

?>