<?php
class ControllerModuleBlogSearch extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		//$data['heading_title'] = html_entity_decode($setting['heading'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		$this->load->language('module/blogsearch');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		
			return $this->load->view('module/blogsearch', $data);
		
	}
}