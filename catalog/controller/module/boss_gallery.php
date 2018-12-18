<?php  
class ControllerModuleBossGallery extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		$title = isset($setting['boss_gallery_title'])?$setting['boss_gallery_title']:'';
		$data['heading_title'] = isset($title[$this->config->get('config_language_id')])?$title[$this->config->get('config_language_id')]:'';
		
		$this->document->addScript('catalog/view/javascript/bossthemes/isotope.pkgd.js');	
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/isotope.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/isotope.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/isotope.css');
		}

		$this->load->model('tool/image');
		
		if ($setting['boss_gallery_image']) { 
			$gallery_images = $setting['boss_gallery_image'];
		} else {
			$gallery_images = array();
		}
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$data['gallery_images'] = array();
		
		foreach ($gallery_images as $gallery_image) {
			if ($gallery_image['image'] && file_exists(DIR_IMAGE . $gallery_image['image'])) { 
				$image = $gallery_image['image'];
			} else {
				$image = 'no_image.png';
			}			

			$data['gallery_images'][] = array(
				'gallery_image_description' => $gallery_image['gallery_image_description'][$this->config->get('config_language_id')],
				'link'                     => $gallery_image['link'],
				'class'                     => $gallery_image['class'],
				'image'                    => $server . 'image/' . $image
			);	
		} 

		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		
			return $this->load->view('module/boss_gallery', $data);
		
	}
}
?>