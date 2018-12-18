<?php
class ControllerModuleBossGallery extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/boss_gallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');
		
		$this->load->model('tool/image');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_gallery', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_class'] = $this->language->get('entry_class');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');		
		$data['button_add_banner'] = $this->language->get('button_add_banner');
		$data['button_remove'] = $this->language->get('button_remove');
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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/boss_gallery', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_gallery', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('module/boss_gallery', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
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
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		if (isset($this->request->post['boss_gallery_title'])) {
			$data['boss_gallery_title'] = $this->request->post['boss_gallery_title'];
		}elseif (!empty($module_info)) {
			$data['boss_gallery_title'] = $module_info['boss_gallery_title'];
		} else {
			$data['boss_gallery_title'] = $this->config->get('boss_gallery_title');
		}
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['boss_gallery_image'])) {
			$data['boss_gallery_images'] = $this->request->post['boss_gallery_image'];
		} elseif (!empty($module_info)) { 
			$boss_gallery_images = $module_info['boss_gallery_image'];
			foreach ($boss_gallery_images as $boss_gallery_image) {
				if ($boss_gallery_image['image'] && file_exists(DIR_IMAGE . $boss_gallery_image['image'])) {
					$image = $boss_gallery_image['image'];
				} else {
					$image = '';
				}			
				if ($image!='' && is_file(DIR_IMAGE . $image)) {
					$thumb = $this->model_tool_image->resize($image, 100, 100);
				} else {
					$thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
				$data['boss_gallery_images'][] = array(
					'gallery_image_description' => $boss_gallery_image['gallery_image_description'],
					'link'                     => $boss_gallery_image['link'],
					'class'                     => $boss_gallery_image['class'],
					'image'                    => $image,
					'thumb'                    => $thumb
				);	
			} 
			//$data['modules'] = $module_info['boss_gallery_image'];
		}else{
			$data['boss_gallery_images'] = array();
		}
		
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/boss_gallery', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;	
	}
	
	
}
?>