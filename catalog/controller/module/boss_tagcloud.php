<?php
class ControllerModuleBossTagCloud extends Controller {
	public function index($setting) {
		static $module = 0;
		
		$this->load->language('module/boss_tagcloud');

		if (isset($setting['title'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		
			$data['text_notags'] = $this->language->get('text_notags');
			
			$this->load->model('bossthemes/boss_tagcloud');
			
			$data['boss_tagcloud'] = $this->model_bossthemes_boss_tagcloud->getRandomTags(
				$setting['limit'],
				(int)$setting['min_font_size'],
				(int)$setting['max_font_size'],
				$setting['font_weight']
			);
			
			$data['module'] = $module++;

			
				return $this->load->view('module/boss_tagcloud', $data);
			
		}
	}
}
?>
