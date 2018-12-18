<?php
class ControllerModuleBossZoom extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('module/boss_zoom');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_zoom', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_image_thumb'] = $this->language->get('text_image_thumb');
		$data['text_image_addition'] = $this->language->get('text_image_addition');
		$data['text_image_zoom'] = $this->language->get('text_image_zoom');
		$data['text_area_zoom'] = $this->language->get('text_area_zoom');
		$data['text_auto_size_area'] = $this->language->get('text_auto_size_area');
		$data['text_area_position'] = $this->language->get('text_area_position');
		$data['text_distance'] = $this->language->get('text_distance');
		$data['text_inner'] = $this->language->get('text_inner');
		$data['text_adjust'] = $this->language->get('text_adjust');		
		$data['text_title'] = $this->language->get('text_title');
		$data['text_title_opacity'] = $this->language->get('text_title_opacity');
		$data['text_tint'] = $this->language->get('text_tint');
		$data['text_tint_opacity'] = $this->language->get('text_tint_opacity');
		$data['text_soft_focus'] = $this->language->get('text_soft_focus');
		$data['text_opacity_lens'] = $this->language->get('text_opacity_lens');
		$data['text_smooth'] = $this->language->get('text_smooth');
		$data['text_right'] = $this->language->get('text_right');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
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
		
		if (isset($this->error['error_thumb_image'])) {
			$data['error_thumb_image'] = $this->error['error_thumb_image'];
		} else {
			$data['error_thumb_image'] = '';
		}
		
		if (isset($this->error['error_addition_image'])) {
			$data['error_addition_image'] = $this->error['error_addition_image'];
		} else {
			$data['error_addition_image'] = '';
		}
		
		if (isset($this->error['error_zoom_image'])) {
			$data['error_zoom_image'] = $this->error['error_zoom_image'];
		} else {
			$data['error_zoom_image'] = '';
		}
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/boss_zoom', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/boss_zoom', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_zoom', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_zoom', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['boss_zoom_thumb_image_width'])) {
			$data['boss_zoom_thumb_image_width'] = $this->request->post['boss_zoom_thumb_image_width'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_thumb_image_width'] = $module_info['boss_zoom_thumb_image_width'];
		} else {
			$data['boss_zoom_thumb_image_width'] = '380';
		}
		
		if (isset($this->request->post['boss_zoom_thumb_image_heigth'])) {
			$data['boss_zoom_thumb_image_heigth'] = $this->request->post['boss_zoom_thumb_image_heigth'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_thumb_image_heigth'] = $module_info['boss_zoom_thumb_image_heigth'];
		} else {
			$data['boss_zoom_thumb_image_heigth'] = '380';
		}
		
		if (isset($this->request->post['boss_zoom_addition_image_width'])) {
			$data['boss_zoom_addition_image_width'] = $this->request->post['boss_zoom_addition_image_width'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_addition_image_width'] = $module_info['boss_zoom_addition_image_width'];
		} else {
			$data['boss_zoom_addition_image_width'] = '100';
		}
		
		if (isset($this->request->post['boss_zoom_addition_image_heigth'])) {
			$data['boss_zoom_addition_image_heigth'] = $this->request->post['boss_zoom_addition_image_heigth'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_addition_image_heigth'] = $module_info['boss_zoom_addition_image_heigth'];
		} else {
			$data['boss_zoom_addition_image_heigth'] = '100';
		}
		
		if (isset($this->request->post['boss_zoom_zoom_image_width'])) {
			$data['boss_zoom_zoom_image_width'] = $this->request->post['boss_zoom_zoom_image_width'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_zoom_image_width'] = $module_info['boss_zoom_zoom_image_width'];
		} else {
			$data['boss_zoom_zoom_image_width'] = '500';
		}
		
		if (isset($this->request->post['boss_zoom_zoom_image_heigth'])) {
			$data['boss_zoom_zoom_image_heigth'] = $this->request->post['boss_zoom_zoom_image_heigth'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_zoom_image_heigth'] = $module_info['boss_zoom_zoom_image_heigth'];
		} else {
			$data['boss_zoom_zoom_image_heigth'] = '500';
		}
		
		if (isset($this->request->post['boss_zoom_zoom_area_width'])) {
			$data['boss_zoom_zoom_area_width'] = $this->request->post['boss_zoom_zoom_area_width'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_zoom_area_width'] = $module_info['boss_zoom_zoom_area_width'];
		} else {
			$data['boss_zoom_zoom_area_width'] = '228';
		}
		
		if (isset($this->request->post['boss_zoom_zoom_area_heigth'])) {
			$data['boss_zoom_zoom_area_heigth'] = $this->request->post['boss_zoom_zoom_area_heigth'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_zoom_area_heigth'] = $module_info['boss_zoom_zoom_area_heigth'];
		} else {
			$data['boss_zoom_zoom_area_heigth'] = '228';
		}
		
		if (isset($this->request->post['boss_zoom_position_zoom_area'])) {
			$data['boss_zoom_position_zoom_area'] = $this->request->post['boss_zoom_position_zoom_area'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_position_zoom_area'] = $module_info['boss_zoom_position_zoom_area'];
		} else {
			$data['boss_zoom_position_zoom_area'] = '';
		}
		
		if (isset($this->request->post['boss_zoom_adjustX'])) {
			$data['boss_zoom_adjustX'] = $this->request->post['boss_zoom_adjustX'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_adjustX'] = $module_info['boss_zoom_adjustX'];
		} else {
			$data['boss_zoom_adjustX'] = '0';
		}
		
		if (isset($this->request->post['boss_zoom_adjustY'])) {
			$data['boss_zoom_adjustY'] = $this->request->post['boss_zoom_adjustY'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_adjustY'] = $module_info['boss_zoom_adjustY'];
		} else {
			$data['boss_zoom_adjustY'] = '0';
		}
		
		if (isset($this->request->post['boss_zoom_title_image'])) {
			$data['boss_zoom_title_image'] = $this->request->post['boss_zoom_title_image'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_title_image'] = $module_info['boss_zoom_title_image'];
		} else {
			$data['boss_zoom_title_image'] = '';
		}
		
		if (isset($this->request->post['boss_zoom_title_opacity'])) {
			$data['boss_zoom_title_opacity'] = $this->request->post['boss_zoom_title_opacity'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_title_opacity'] = $module_info['boss_zoom_title_opacity'];
		} else {
			$data['boss_zoom_title_opacity'] = '0.5';
		}
		
		if (isset($this->request->post['boss_zoom_tint'])) {
			$data['boss_zoom_tint'] = $this->request->post['boss_zoom_tint'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_tint'] = $module_info['boss_zoom_tint'];
		} else {
			$data['boss_zoom_tint'] = '#FFF';
		}
		
		if (isset($this->request->post['boss_zoom_tint_opacity'])) {
			$data['boss_zoom_tint_opacity'] = $this->request->post['boss_zoom_tint_opacity'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_tint_opacity'] = $module_info['boss_zoom_tint_opacity'];
		} else {
			$data['boss_zoom_tint_opacity'] = '0.5';
		}
		
		if (isset($this->request->post['boss_zoom_softFocus'])) {
			$data['boss_zoom_softFocus'] = $this->request->post['boss_zoom_softFocus'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_softFocus'] = $module_info['boss_zoom_softFocus'];
		} else {
			$data['boss_zoom_softFocus'] = '';
		}
		
		if (isset($this->request->post['boss_zoom_lensOpacity'])) {
			$data['boss_zoom_lensOpacity'] = $this->request->post['boss_zoom_lensOpacity'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_lensOpacity'] = $module_info['boss_zoom_lensOpacity'];
		} else {
			$data['boss_zoom_lensOpacity'] = '0.7';
		}
		
		if (isset($this->request->post['boss_zoom_smoothMove'])) {
			$data['boss_zoom_smoothMove'] = $this->request->post['boss_zoom_smoothMove'];
		} elseif (!empty($module_info)) {
			$data['boss_zoom_smoothMove'] = $module_info['boss_zoom_smoothMove'];
		} else {
			$data['boss_zoom_smoothMove'] = '3';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_zoom', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_zoom')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (isset($this->request->post['boss_zoom_thumb_image_width'])) {
			$value = array();
			$value = $this->request->post['boss_zoom_thumb_image_width'];
			if (!$value) {
				$this->error['error_thumb_image'] = $this->language->get('error_image');
			}
		}
		
		if (isset($this->request->post['boss_zoom_thumb_image_heigth'])) {
			$value = array();
			$value = $this->request->post['boss_zoom_thumb_image_heigth'];
			if (!$value) {
				$this->error['error_thumb_image'] = $this->language->get('error_image');
			}
		}
		
		if (isset($this->request->post['boss_zoom_addition_image_width'])) {
			$value = array();
			$value = $this->request->post['boss_zoom_addition_image_width'];
			if (!$value) {
				$this->error['error_addition_image'] = $this->language->get('error_image');
			}
		}
		
		if (isset($this->request->post['boss_zoom_addition_image_heigth'])) {
			$value = array();
			$value = $this->request->post['boss_zoom_addition_image_heigth'];
			if (!$value) {
				$this->error['error_addition_image'] = $this->language->get('error_image');
			}
		}
		
		if (isset($this->request->post['boss_zoom_zoom_image_width'])) {
			$value = array();
			$value = $this->request->post['boss_zoom_zoom_image_width'];
			if (!$value) {
				$this->error['error_zoom_image'] = $this->language->get('error_image');
			}
		}
		
		if (isset($this->request->post['boss_zoom_zoom_image_heigth'])) {
			$value = array();
			$value = $this->request->post['boss_zoom_zoom_image_heigth'];
			if (!$value) {
				$this->error['error_zoom_image'] = $this->language->get('error_image');
			}
		}
		return !$this->error;
	}
	
	/*private function getIdLayout($layout_name) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE LOWER(name) = LOWER('".$layout_name."')");
		return (int)$query->row['layout_id'];
	}*/
	
	/*public function install() {
		$this->load->model('setting/setting');
		
		$boss_zoom = array('boss_zoom_status' => 1 'boss_zoom_module' => array ( '0' => array ( 'thumb_image_width' => 380 'thumb_image_heigth' => 380 'addition_image_width' => 100 'addition_image_heigth' => 100 'zoom_image_width' => 500 'zoom_image_heigth' => 500 'zoom_area_width' => 228 'zoom_area_heigth' => 228 'position_zoom_area' => inside 'adjustX' => 0 'adjustY' => 0 'title_image' => 1 'title_opacity' => 0.5 'tint' => '#FFFFFF' 'tintOpacity' => 0.5 'softfocus' => 1 'lensOpacity' => 0.7 'smoothMove' => 3 ) ) );
		
		$boss_zoom = array('boss_zoom_module' => array ( 
		0 => array ('thumb_image_width' => 480,'thumb_image_heigth' => 480,'addition_image_width' => 90,'addition_image_heigth' => 90,'zoom_image_width' => 700,'zoom_image_heigth' => 700,'zoom_area_width' => 480,'zoom_area_heigth' => 480,'position_zoom_area' => 'inside','adjustX' => 0,'adjustY' => 0,'title_image' => 'true', 'title_opacity' => 0.5, 'tint' => '#FFFFFF', 'tintOpacity' => 0.5, 'softfocus' => 'false', 'lensOpacity' => 0.7, 'smoothMove' => 3)
		),
		'boss_zoom_status'=> 1
		);
		
		$this->model_setting_setting->editSetting('boss_zoom', $boss_zoom);		
	}*/
	
}
?>