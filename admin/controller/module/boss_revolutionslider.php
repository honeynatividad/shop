<?php
class ControllerModuleBossRevolutionSlider extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/boss_revolutionslider');
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_revolutionslider.css');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		$this->load->model('bossthemes/boss_revolutionslider');
		
		$this->load->model('extension/module');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		$data['modulesetting'] = $this->url->link('module/boss_revolutionslider/moduleSetting', 'token=' . $this->session->data['token'], true);
		
		$data['slider_list'] = $this->url->link('module/boss_revolutionslider/sliderlist', 'token=' . $this->session->data['token'], true);
		
		$module_info = array();
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		$data['token'] = $this->session->data['token'];

		$data['slider'] = array();
		
		
		
		if(!empty($module_info)){
		
			$total_slide = $this->model_bossthemes_boss_revolutionslider->getTotalslidesBySliderId($module_info['slider_id']);
			
			$settings = $this->model_setting_setting->getSetting('boss_revolutionslider'.$module_info['slider_id']);
			$data['status'] = $module_info['status'];
			$data['name'] = $module_info['name'];
			$data['slider'] = array(
				'slider_id' => $module_info['slider_id'],
				'edit_link' => $this->url->link('module/boss_revolutionslider/sliderlist', 'token=' . $this->session->data['token'] . '&slider_id=' . $module_info['slider_id'].'&module_id=' . $this->request->get['module_id'], true),
				'setting_link' => $this->url->link('module/boss_revolutionslider/moduleSetting', 'token=' . $this->session->data['token'] . '&slider_id=' . $module_info['slider_id'].'&module_id=' . $this->request->get['module_id'], true),
				'total' => $total_slide
			);
		
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_revolutionslider/boss_revolutionslider', $data));
	}
	
	public function moduleSetting(){
	
		$this->language->load('module/boss_revolutionslider');
		
		$this->load->model('setting/setting');
		
		$this->load->model('bossthemes/boss_revolutionslider');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_revolutionslider.css');
		
		$data['heading_title'] = $this->language->get('heading_title_setting');
		
		$this->load->model('extension/module');
		
		if(isset($this->request->get['slider_id'])){
			$slider_id = $this->request->get['slider_id'];
		}else{
			$slider_id = 0;
		}
		
		$data['slider_id'] = $slider_id;
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			if (!isset($this->request->get['module_id'])) {
			
				$newslider_id = $this->model_bossthemes_boss_revolutionslider->addSlider($this->request->post);
				$this->request->post['module']['slider_id'] = $newslider_id;
				$this->model_extension_module->addModule('boss_revolutionslider', $this->request->post['module']);
				
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post['module']);
				$this->model_bossthemes_boss_revolutionslider->editSlider($slider_id,$this->request->post);	
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
		
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_slider_width'] = $this->language->get('entry_slider_width');
		$data['entry_num_column'] = $this->language->get('entry_num_column'); 
		$data['entry_store'] = $this->language->get('entry_store');
		
		//config option
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_startWithSlide'] = $this->language->get('text_startWithSlide');
		$data['text_startWithSlide_des'] = $this->language->get('text_startWithSlide_des');
		$data['text_delay'] = $this->language->get('text_delay');
		$data['text_delay_option_des'] = $this->language->get('text_delay_option_des');
		$data['text_startheight_option'] = $this->language->get('text_startheight_option');
		$data['text_startheight_option_des'] = $this->language->get('text_startheight_option_des');
		$data['text_startwidth_option'] = $this->language->get('text_startwidth_option');
		$data['text_startwidth_option_des'] = $this->language->get('text_startwidth_option_des');
		$data['text_touchenabled'] = $this->language->get('text_touchenabled');
		$data['text_touchenabled_des'] = $this->language->get('text_touchenabled_des');
		$data['text_onhoverstop'] = $this->language->get('text_onhoverstop'); 		
		$data['text_onhoverstop_des'] = $this->language->get('text_onhoverstop_des');
		$data['text_fullwidth'] = $this->language->get('text_fullwidth');
		$data['text_fullwidth_des'] = $this->language->get('text_fullwidth_des');
		$data['text_timeline'] = $this->language->get('text_timeline');
		$data['text_timeline_des'] = $this->language->get('text_timeline_des');
		$data['text_timerlineposition'] = $this->language->get('text_timerlineposition');
		$data['text_timerlineposition_des'] = $this->language->get('text_timerlineposition_des');
		$data['text_shadow'] = $this->language->get('text_shadow');
		$data['text_shadow_des'] = $this->language->get('text_shadow_des');
		$data['text_onhoverstop_des'] = $this->language->get('text_onhoverstop_des');
		$data['text_navigation'] = $this->language->get('text_navigation');
		$data['text_navigation_type'] = $this->language->get('text_navigation_type');
		$data['text_navigation_type_des'] = $this->language->get('text_navigation_type_des');
		$data['text_navigation_arrow'] = $this->language->get('text_navigation_arrow');
		$data['text_navigation_arrow_des'] = $this->language->get('text_navigation_arrow_des');
		$data['text_navigation_style'] = $this->language->get('text_navigation_style');
		$data['text_navigation_style_des'] = $this->language->get('text_navigation_style_des');
		$data['text_navigationhalign'] = $this->language->get('text_navigationhalign');
		$data['text_navigationhalign_des'] = $this->language->get('text_navigationhalign_des');
		$data['text_navigationvalign'] = $this->language->get('text_navigationvalign');
		$data['text_navigationvalign_des'] = $this->language->get('text_navigationvalign_des');
		$data['text_navigationhoffset'] = $this->language->get('text_navigationhoffset'); 		
		$data['text_navigationhoffset_des'] = $this->language->get('text_navigationhoffset_des');
		$data['text_navigationvoffset'] = $this->language->get('text_navigationvoffset');
		$data['text_navigationvoffset_des'] = $this->language->get('text_navigationvoffset_des');
		$data['text_soloarrowlefthalign'] = $this->language->get('text_soloarrowlefthalign');
		$data['text_soloarrowlefthalign_des'] = $this->language->get('text_soloarrowlefthalign_des');
		$data['text_soloarrowleftvalign'] = $this->language->get('text_soloarrowleftvalign');
		$data['text_soloarrowleftvalign_des'] = $this->language->get('text_soloarrowleftvalign_des');
		$data['text_soloarrowlefthoffset'] = $this->language->get('text_soloarrowlefthoffset');
		$data['text_soloarrowlefthoffset_des'] = $this->language->get('text_soloarrowlefthoffset_des');
		$data['text_soloarrowleftvoffset'] = $this->language->get('text_soloarrowleftvoffset');
		$data['text_soloarrowleftvoffset_des'] = $this->language->get('text_soloarrowleftvoffset_des');
		$data['text_soloarrowrighthalign'] = $this->language->get('text_soloarrowrighthalign');
		$data['text_soloarrowrighthalign_des'] = $this->language->get('text_soloarrowrighthalign_des'); 		
		$data['text_soloarrowrightvalign'] = $this->language->get('text_soloarrowrightvalign');
		$data['text_soloarrowrightvalign_des'] = $this->language->get('text_soloarrowrightvalign_des');
		$data['text_soloarrowrighthoffset'] = $this->language->get('text_soloarrowrighthoffset');
		$data['text_soloarrowrighthoffset_des'] = $this->language->get('text_soloarrowrighthoffset_des');
		$data['text_soloarrowrightvoffset'] = $this->language->get('text_soloarrowleftvoffset');
		$data['text_soloarrowrightvoffset_des'] = $this->language->get('text_soloarrowleftvoffset_des');
		$data['text_thumbnails'] = $this->language->get('text_thumbnails');
		$data['text_timehidethumbnail'] = $this->language->get('text_timehidethumbnail');
		$data['text_timehidethumbnail_des'] = $this->language->get('text_timehidethumbnail_des');
		$data['text_thumbnailwidth'] = $this->language->get('text_thumbnailwidth');
		$data['text_thumbnailwidth_des'] = $this->language->get('text_thumbnailwidth_des');
		$data['text_thumbnailheight'] = $this->language->get('text_thumbnailheight');
		$data['text_thumbnailheight_des'] = $this->language->get('text_thumbnailheight_des'); 		
		$data['text_thumbamount'] = $this->language->get('text_thumbamount');
		$data['text_thumbamount_des'] = $this->language->get('text_thumbamount_des');
		$data['text_visibility'] = $this->language->get('text_visibility');
		$data['text_hidecapptionatlimit'] = $this->language->get('text_hidecapptionatlimit');
		$data['text_hidecapptionatlimit_des'] = $this->language->get('text_hidecapptionatlimit_des');
		$data['text_hideallcapptionatlimit'] = $this->language->get('text_hideallcapptionatlimit');
		$data['text_hideallcapptionatlimit_des'] = $this->language->get('text_hideallcapptionatlimit_des');
		$data['text_hideslideratlimit'] = $this->language->get('text_hideslideratlimit');
		$data['text_hideslideratlimit_des'] = $this->language->get('text_hideslideratlimit_des');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		$data['arronoff'] = array(
			"on" => $this->language->get('text_enabled'),
			"off" => $this->language->get('text_disabled')
		);
		$data['positions'] = array(
			"content_top" => $this->language->get('text_content_top'),
			"content_bottom" => $this->language->get('text_content_bottom'),
			"column_left" => $this->language->get('text_column_left'),
			"column_right" => $this->language->get('text_column_right'),
			'mainmenu' => $this->language->get('text_mainmenu')
		);
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_revolutionslider/moduleSetting', 'token=' . $this->session->data['token'].'&slider_id='.$slider_id, true);
		} else {
			$data['action'] = $this->url->link('module/boss_revolutionslider/moduleSetting', 'token=' . $this->session->data['token'].'&slider_id='.$slider_id.'&module_id='.$this->request->get['module_id'], true);
		}
		
		if (!isset($this->request->get['module_id'])) {
			$data['cancel'] = $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'], true);
		} else {
			$data['cancel'] = $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'].'&module_id=' . $this->request->get['module_id'], true);
		}
		
		$this->load->model('bossthemes/boss_revolutionslider');
		
		$data['slider_settings'] = array();
		
		
		
		$data['module'] = array();
		
		if($slider_id!=0){
			$data['slider_settings'] = $this->model_bossthemes_boss_revolutionslider->getSlider($slider_id);
			
			if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$data['module'] = $this->model_extension_module->getModule($this->request->get['module_id']);
			}
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_revolutionslider/boss_revolutionslider_setting', $data));
	}
	
	public function sliderlist(){
	
		$this->language->load('module/boss_revolutionslider');
		$this->load->model('bossthemes/boss_revolutionslider');
		
		$this->load->model('tool/image');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->document->addScript('view/javascript/bossthemes/ui/jquery-ui.min.js');
		$this->document->addStyle('view/javascript/bossthemes/ui/jquery-ui.min.css');
		$this->document->addStyle('view/stylesheet/bossthemes/boss_revolutionslider.css');
		
		$data['heading_title'] = $this->language->get('heading_title_manager');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
	
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);
		
		$data['action'] = $this->url->link('module/boss_revolutionslider/setting', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'].'&module_id=' . $this->request->get['module_id'], true);
		
		$data['slider_form'] = $this->url->link('module/boss_revolutionslider/sliderform', 'token=' . $this->session->data['token'], true);
		
		$data['modulesetting'] = $this->url->link('module/boss_revolutionslider/moduleSetting', 'token=' . $this->session->data['token'].'&slider_id='.$this->request->get['slider_id'].'&module_id=' . $this->request->get['module_id'], true);
		
		$data['new_slide'] = $this->url->link('module/boss_revolutionslider/sliderform', 'token=' . $this->session->data['token'].'&slider_id='.$this->request->get['slider_id'].'&slide_id=0'.'&module_id=' . $this->request->get['module_id'], true);
		
		$data['token'] = $this->session->data['token'];
		
		
		
		$data['slides'] = array();
		
		if (isset($this->request->get['slider_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$slides = $this->model_bossthemes_boss_revolutionslider->getSlides($this->request->get['slider_id']);
		}else{
			$slides = array();
		}
		
		foreach($slides as $slide){
			$data['slides'][] = array(
				'slide_id' => $slide['id'],
				'slider_id' => $slide['slider_id'],
				'module_id' => $this->request->get['module_id'],
				'status'	=> $slide['status'],
				'sort_order' => $slide['sort_order'],
				'slideset' => json_decode($slide['slideset'], true),
				'edit_link' => $this->url->link('module/boss_revolutionslider/sliderform', 'token=' . $this->session->data['token'] . '&slide_id=' . $slide['id'].'&slider_id=' . $slide['slider_id'].'&module_id=' . $this->request->get['module_id'], true),
				'delete_link' => $this->url->link('module/boss_revolutionslider/deleteSlide', 'token=' . $this->session->data['token'] . '&slide_id=' . $slide['id'].'&module_id=' . $this->request->get['module_id'], true)
			);
		}
		
		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 200, 100);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_revolutionslider/boss_revolutionslider_slider_list', $data));
	}
	
	public function sliderform(){
		
		$this->language->load('module/boss_revolutionslider');
		
		$this->load->model('tool/image');
		$this->load->model('bossthemes/boss_revolutionslider');
		
		$this->load->model('localisation/language');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->document->addScript('view/javascript/bossthemes/ui/jquery-ui.min.js');
		$this->document->addStyle('view/javascript/bossthemes/ui/jquery-ui.min.css');
		$this->document->addScript('view/javascript/bossthemes/boss_revolutionslider/colorpicker.js');
		$this->document->addScript('view/javascript/bossthemes/boss_revolutionslider/eye.js');
		$this->document->addScript('view/javascript/bossthemes/boss_revolutionslider/layout.js');
		$this->document->addScript('view/javascript/bossthemes/boss_revolutionslider/boss_revolutionslider.js');
		$this->document->addStyle('view/stylesheet/bossthemes/boss_revolutionslider.css');
		$this->document->addStyle('view/stylesheet/bossthemes/settings.css');
		$this->document->addStyle('view/stylesheet/bossthemes/colorpicker.css');
		
		$data['heading_title'] = $this->language->get('heading_title_edit');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$slide_id = $this->request->get['slide_id'];
		$slider_id = $this->request->get['slider_id'];
		
		$data['slide_id'] = $slide_id;
		$data['slider_id'] = $slider_id;
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$slidedata = $this->request->post;
			
			$slidedata_captions = isset($slidedata['caption'])?$slidedata['caption']:array();
			
			$languages = $this->model_localisation_language->getLanguages();
			
			if(!empty($slidedata_captions)){
				foreach($slidedata_captions as $key => $slidedata_caption){
					if(isset($slidedata_caption['text_caption'])) {
						foreach ($languages as $language) {
							$slidedata['caption'][$key]['text_caption'][$language['language_id']] = $slidedata_caption['text_caption'][$language['language_id']];
						}
					}
				}
			}else{
				$slidedata['caption'] = array();
			}
			
			if($slide_id!=0){
				$this->model_bossthemes_boss_revolutionslider->editSlide($slide_id,$slider_id,$slidedata);
			}else{
				$this->model_bossthemes_boss_revolutionslider->addSlide_New($slider_id,$slidedata);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('module/boss_revolutionslider/sliderlist', 'token=' . $this->session->data['token'].'&slider_id='.$slider_id.'&module_id=' . $this->request->get['module_id'], true));
		}
		
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		//load animation slide text
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_transition'] = $this->language->get('text_transition');
		$data['text_transition_des'] = $this->language->get('text_transition_des');
		$data['text_slot_amount'] = $this->language->get('text_slot_amount');
		$data['text_slot_amount_des'] = $this->language->get('text_slot_amount_des');
		$data['text_master_speed'] = $this->language->get('text_master_speed');
		$data['text_master_speed_des'] = $this->language->get('text_master_speed_des');
		$data['text_target'] = $this->language->get('text_target');
		$data['text_target_des'] = $this->language->get('text_target_des');
		$data['text_delay'] = $this->language->get('text_delay');
		$data['text_delay_des'] = $this->language->get('text_delay_des');
		$data['text_enable_link'] = $this->language->get('text_enable_link');
		$data['text_full_video'] = $this->language->get('text_full_video');
		$data['text_background'] = $this->language->get('text_background');
		$data['text_color'] = $this->language->get('text_color');
		$data['text_transparent'] = $this->language->get('text_transparent'); 		
		$data['text_url'] = $this->language->get('text_url');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		
		//add caption 
		$data['text_new_caption'] = $this->language->get('text_new_caption');
		$data['text_remove_caption'] = $this->language->get('text_remove_caption');
		$data['text_type_caption'] = $this->language->get('text_type_caption');
		$data['text_text_caption'] = $this->language->get('text_text_caption');
		$data['text_image_caption'] = $this->language->get('text_image_caption');
		$data['text_video_caption'] = $this->language->get('text_video_caption'); 	
		$data['text_text'] = $this->language->get('text_text');
		$data['text_image'] = $this->language->get('text_image');
		$data['text_video'] = $this->language->get('text_video');
		$data['text_video_type'] = $this->language->get('text_video_type');
		$data['text_video_id'] = $this->language->get('text_video_id');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_datax'] = $this->language->get('text_datax');
		$data['text_datax_des'] = $this->language->get('text_datax_des');
		$data['text_datay'] = $this->language->get('text_datay');
		$data['text_datay_des'] = $this->language->get('text_datay_des'); 	
		$data['text_class_css'] = $this->language->get('text_class_css'); 
		$data['text_class_css_des'] = $this->language->get('text_class_css_des'); 
		$data['text_data_speed'] = $this->language->get('text_data_speed');
		$data['text_data_speed_des'] = $this->language->get('text_data_speed_des');
		$data['text_data_start'] = $this->language->get('text_data_start');
		$data['text_data_start_des'] = $this->language->get('text_data_start_des');
		$data['text_data_end'] = $this->language->get('text_data_end');
		$data['text_data_end_des'] = $this->language->get('text_data_end_des');
		$data['text_data_after_speed'] = $this->language->get('text_data_after_speed');
		$data['text_data_after_speed_des'] = $this->language->get('text_data_after_speed_des');
		$data['text_incom_animation'] = $this->language->get('text_incom_animation'); 	
		$data['text_incom_animation_des'] = $this->language->get('text_incom_animation_des'); 
		$data['text_outgo_animation'] = $this->language->get('text_outgo_animation'); //
		$data['text_outgo_animation_des'] = $this->language->get('text_outgo_animation_des');
		$data['text_easing'] = $this->language->get('text_easing');
		$data['text_easing_des'] = $this->language->get('text_easing_des');
		$data['text_endeasing'] = $this->language->get('text_endeasing');
		$data['text_endeasing_des'] = $this->language->get('text_endeasing_des'); 	
		$data['text_under_width'] = $this->language->get('text_under_width'); 
		$data['text_under_width_des'] = $this->language->get('text_under_width_des'); 
		
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		$data['arronoff'] = array(
			"on" => $this->language->get('text_enabled'),
			"off" => $this->language->get('text_disabled')
		);
		
		//load confif for slide
		$data['transitions']= array("slideup","slidedown","slideright","slideleft","slidehorizontal","slidevertical","boxslide","slotslide-horizontal","slotslide-vertical","boxfade","slotfade-horizontal","slotfade-vertical","fadefromright","fadefromleft","fadefromtop","fadefrombottom","fadetoleftfadefromright","fadetorightfadefromleft","fadetotopfadefrombottom","fadetobottomfadefromtop","parallaxtoright","parallaxtoleft","parallaxtotop","parallaxtobottom","scaledownfromright","scaledownfromleft","scaledownfromtop","scaledownfrombottom","zoomout","zoomin","slotzoom-horizontal","slotzoom-vertical","fade","random-static","random","curtain-1","curtain-2","curtain-3","3dcurtain-horizontal","3dcurtain-vertical","cube","cube-horizontal","incube","incube-horizontal","turnoff","turnoff-vertical","papercut","flyin","random-premium","random");
		
		$data['class_css']= array("big_white","greenbox30","arrowicon","white_bold_bg_20","black_bold_bg_20","red_bold_bg_20","blue_bold_bg_20","grey_heavy_72","white_heavy_40","grey_regular_18","light_heavy_70","black_bold_40","light_heavy_40","black_heavy_60","black_heavy_70","black_thin_34","white_thin_34","middle_yellow","big_orange","big_black","medium_white","medium_black","small_text","medium_text","large_text","large_white_text","very_large_text","very_large_white_text","bold_red_text","bold_brown_text","bold_green_text","very_big_white","very_big_black","randomrotate");
		
		$data['incom_animation']= array("sft"=>"Short from Top","sfb"=>"Short from Bottom","sfr"=>"Short from Right","sfl"=>"Short from Left","lft"=>"Long from Top","lfb"=>"Long from Bottom","lfr"=>"Long from Right","lfl"=>"Long from Left","skewfromleft"=>"Skew from Left","skewfromright"=>"Skew from Right","skewfromleftshort"=>"Skew Short from Left","skewfromrightshort"=>"Skew Short from Right","fade"=>"fading","randomrotate"=>"Randomrotate","customin"=>"Custom Incoming Animation");
		
		$data['outgo_animation']= array("stt"=>"Short to Top","stb"=>"Short to Bottom","str"=>"Short to Right","stl"=>"Short to Left","ltt"=>"Long to Top","ltb"=>"Long to Bottom","ltr"=>"Long to Right","ltl"=>"Long to Left","skewtoleft"=>"Skew to Left","skewtoright"=>"Skew to Right","skewtoleftshort"=>"Skew Short to Left","skewtorightshort"=>"Skew Short to Right","fadeout"=>"fading","randomrotateout"=>"randomrotateout","customout"=>"Custom Outgoing Animation");
		
		$data['easing']= array("easeOutBack","easeInQuad","easeOutQuad","easeInOutQuad","easeInCubic","easeOutCubic","easeInOutCubic","easeInQuart","easeOutQuart","easeInOutQuart","easeInQuint","easeOutQuint","easeInOutQuint","easeInSine","easeOutSine","easeInOutSine","easeInExpo","easeOutExpo","easeInOutExpo","easeInCirc","easeOutCirc","easeInOutCirc","easeInElastic","easeOutElastic","easeInOutElastic","easeInBack","easeOutBack","easeInOutBack","easeInBounce","easeOutBounce","easeInOutBounce");
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_revolutionslider', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);
		
		if(isset($this->request->get['module_id'])){
			$data['action'] = $this->url->link('module/boss_revolutionslider/sliderForm', 'token=' . $this->session->data['token'].'&slide_id='.$slide_id.'&slider_id='.$slider_id.'&module_id=' . $this->request->get['module_id'], true);
		}else{
			$data['action'] = $this->url->link('module/boss_revolutionslider/sliderForm', 'token=' . $this->session->data['token'].'&slide_id='.$slide_id.'&slider_id='.$slider_id, true);
		}

		$data['cancel'] = $this->url->link('module/boss_revolutionslider/sliderlist', 'token=' . $this->session->data['token'].'&slider_id='.$slider_id.'&module_id=' . $this->request->get['module_id'], true);
		
		$data['token'] = $this->session->data['token'];
		
		$data['slides'] = array();
		
		if($slide_id!=0){
		
			$data['slides'] = $this->model_bossthemes_boss_revolutionslider->getSlide($slide_id);
		}
		
		$data['slider_settings'] = array();
		
		if($slider_id!=0){
			$data['slider_settings'] = $this->model_bossthemes_boss_revolutionslider->getSlider($slider_id);
		}
		
		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_revolutionslider/boss_revolutionslider_slider_form', $data));
	}
	
	public function deleteSlide(){
		$json = array();
		
		$this->language->load('module/boss_revolutionslider');
		
		if (isset($this->request->get['slide_id']) && !empty($this->request->get['slide_id'])) {
		
			$this->load->model('bossthemes/boss_revolutionslider');
			
			$this->model_bossthemes_boss_revolutionslider->deleteSlide($this->request->get['slide_id']);
			
			$this->session->data['success'] = $this->language->get('entry_delete_success');
			
			$json['redirect'] = $this->url->link('module/boss_revolutionslider/sliderlist&token=' . $this->session->data['token']. '&slider_id=' . $this->request->get['slider_id'].'&module_id=' . $this->request->get['module_id'], true);
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function copySlide(){
		$json = array();
		$this->language->load('module/boss_revolutionslider');
		
		if (isset($this->request->get['slide_id']) && !empty($this->request->get['slide_id'])) {
		
			$this->load->model('bossthemes/boss_revolutionslider');
			
			$this->model_bossthemes_boss_revolutionslider->copySlide($this->request->get['slide_id']);
			
			$this->session->data['success'] = $this->language->get('entry_copy_success');
			
			$json['redirect'] = $this->url->link('module/boss_revolutionslider/sliderlist&token=' . $this->session->data['token']. '&slider_id=' . $this->request->get['slider_id'].'&module_id=' . $this->request->get['module_id'], true);
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function updateSortSlide(){
	
		$array	= $this->request->post;

		if ($array['update'] == "update"){
			
			$this->load->model('bossthemes/boss_revolutionslider');
			
			$this->model_bossthemes_boss_revolutionslider->updateSortSlide($array['slideorder']);
		
			echo '<i class="fa fa-check-circle"></i> All saved! refresh the page to see the changes';
		}
	}
	
	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'module/boss_revolutionslider')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['module'])) {
			$temp = $this->request->post['module'];
			if ((utf8_strlen($temp['name']) < 3) || (utf8_strlen($temp['name']) > 64)) {
				$this->error['name'] = $this->language->get('error_name');
			}
		}
		
		if (isset($this->request->post['setting'])) {
		
			if (!$this->request->post['setting']['slider_width']) {
				$this->error['width'] = $this->language->get('error_width');
			}
			
			if (!$this->request->post['setting']['slider_height']) {
				$this->error['height'] = $this->language->get('error_height');
			}
		
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function install(){
	
		$this->load->model('bossthemes/boss_revolutionslider');
		
		$this->model_bossthemes_boss_revolutionslider->createdb();
		
	}
}
?>