<?php
class ControllerModuleBossContactMe extends Controller {
	public function index() {
		$this->load->language('module/boss_contactme');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_msg'] = $this->language->get('entry_msg');
		$data['entry_send_msg'] = $this->language->get('entry_send_msg');

		
			return $this->load->view('module/boss_contactme', $data);
		
	}
	
	public function contact(){
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->language->load('module/boss_contactme');
			if ((utf8_strlen($this->request->post['contact_msg']) < 10) || (utf8_strlen($this->request->post['contact_msg']) > 3000)) {
				$json['error'] = $this->language->get('error_enquiry');
			}
			if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['contact_mail'])) {
				$json['error'] = $this->language->get('error_email');
			}
			if ((utf8_strlen($this->request->post['contact_name']) < 3) || (utf8_strlen($this->request->post['contact_name']) > 32)) {
				$json['error'] = $this->language->get('error_name');
			}
			if (!isset($json['error'])) {
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');			
				
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->request->post['contact_mail']);
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(sprintf($this->language->get('email_subject'), $this->request->post['contact_name']));
				$mail->setText($this->request->post['contact_msg']);
				$mail->send();
				
				/*if(isset($this->request->post['contact_copy'])){
					$mail->setTo($this->request->post['contact_mail']);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($this->request->post['contact_name']);
					$mail->setSubject(sprintf($this->language->get('email_subject'), $this->request->post['contact_name']));
					$mail->setText($this->request->post['contact_msg']);
					$mail->send();
				}*/
				$json['success'] = $this->language->get('text_success');
			}
		} 
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));	
	}
}