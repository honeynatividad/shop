<?php  
class ControllerModuleBossTestimonial extends Controller {

	public function index($setting) {
		static $module = 0;
		$this->language->load('module/boss_testimonial');
		
		$this->document->addScript('catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js');
		
		$data['testimonial_title'] = html_entity_decode(isset($setting['boss_testimonial_module']['title'][$this->config->get('config_language_id')])?$setting['boss_testimonial_module']['title'][$this->config->get('config_language_id')]:'', ENT_QUOTES, 'UTF-8');

      	$data['show_name'] = isset($setting['boss_testimonial_module']['show_name'])?$setting['boss_testimonial_module']['show_name']:1;
      	$data['show_subject'] = isset($setting['boss_testimonial_module']['show_subject'])?$setting['boss_testimonial_module']['show_subject']:1;
      	$data['show_message'] = isset($setting['boss_testimonial_module']['show_message'])?$setting['boss_testimonial_module']['show_message']:1;
      	$data['show_city'] = isset($setting['boss_testimonial_module']['show_city'])?$setting['boss_testimonial_module']['show_city']:1;
      	$data['show_rating'] = isset($setting['boss_testimonial_module']['show_rating'])?$setting['boss_testimonial_module']['show_rating']:1;
		$data['show_image'] = isset($setting['boss_testimonial_module']['show_image'])?$setting['boss_testimonial_module']['show_image']:1;
		$data['show_date'] = isset($setting['boss_testimonial_module']['show_date'])?$setting['boss_testimonial_module']['show_date']:1;
      	$data['show_all_link'] = isset($setting['boss_testimonial_module']['show_all'])?$setting['boss_testimonial_module']['show_all']:1;
      	$data['show_write'] = isset($setting['boss_testimonial_module']['show_write'])?$setting['boss_testimonial_module']['show_write']:1;
      	$data['auto_scroll'] = isset($setting['boss_testimonial_module']['auto_scroll'])?$setting['boss_testimonial_module']['auto_scroll']:1;
		
		
      	$data['heading_title'] = $this->language->get('heading_title');
      	$data['text_more'] = $this->language->get('text_more');
      	$data['text_more2'] = $this->language->get('text_more2');
		$data['isi_testimonial'] = $this->language->get('isi_testimonial');
		$data['show_all'] = $this->language->get('show_all');
		$data['showall_url'] = $this->url->link('bossthemes/boss_testimonial', '', true); 
		$data['more'] = $this->url->link('bossthemes/boss_testimonial', 'testimonial_id=' , true); 
		$data['isitesti'] = $this->url->link('bossthemes/isitestimonial', '', true);

		$this->load->model('bossthemes/boss_testimonial');
		
		$data['testimonials'] = array();
		
		$data['total'] = $this->model_bossthemes_boss_testimonial->getTotalTestimonials();
		$results = $this->model_bossthemes_boss_testimonial->getTestimonials(0, $setting['boss_testimonial_module']['limit'], (isset($setting['boss_testimonial_module']['random']))?true:false);

		
		foreach ($results as $result) {
			
			
			$result['description'] = trim($result['description']);
			$result['description'] = str_replace('<p>', '', $result['description']);
			$result['description'] = str_replace('</p>', '', $result['description']);


			if (!isset($setting['boss_testimonial_module']['limit_character']))
				$setting['boss_testimonial_module']['limit_character'] = 0;

			if ($setting['boss_testimonial_module']['limit_character']>0)
			{
				$lim = $setting['boss_testimonial_module']['limit_character'];

				if (mb_strlen($result['description'],'UTF-8')>$lim) 
					$result['description'] = mb_substr($result['description'], 0, $lim-3, 'UTF-8'). ' ' .'<a href="'.$data['more']. $result['testimonial_id'] .'" title="'.$data['text_more2'].'">'. $data['text_more'] . '</a>';

			}



			$data['testimonials'][] = array(
				'id'			=> $result['testimonial_id'],											  
				'title'		=> $result['title'],
				'description'	=> $result['description'],
				'rating'		=> $result['rating'],
				'name'		=> $result['name'],
				'date_added'	=> $result['date_added'],
				'city'		=> $result['city'],
				'date_added'		=> $result['date_added'],

			);
		}

		

		$this->id = 'testimonial';
		$data['module'] = $module++;
		
			return $this->load->view('module/boss_testimonial', $data);
		
	}
}
?>