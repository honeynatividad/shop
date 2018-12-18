<?php

/**
TEST
by HCN
**/
class ControllerModuleRequestForm extends Controller {
	
	public function index($setting) {
		if(empty($setting)) return;
		$this->load->language('module/requestform');
		
    	$data['heading_title'] = $this->language->get('heading_title');
        
        if (file_exists('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css')){
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_theme') . '/stylesheet/bossthemes/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossthemes/bossblog.css');
		}


		

		
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
        
		if (isset($parts[0])) {
			$data['request_form_id'] = $parts[0];
		} else {
			$data['request_form_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}
							
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_location'] = $this->language->get('text_location');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_open'] = $this->language->get('text_open');

		$data['text_name'] 					= $this->language->get('text_name');
		$data['text_designation'] 			= $this->language->get('text_designation');
		$data['text_email']					= $this->language->get('text_email');
		$data['text_contact_number']		= $this->language->get('text_contact_number');
		$data['text_nature_of_business']	= $this->language->get('text_nature_of_business');
		$data['text_total_employees']		= $this->language->get('text_total_employees');
		$data['text_total_dependents']		= $this->language->get('text_total_dependets');
		$data['text_annual_budget']			= $this->language->get('text_annual_budget');
		$data['text_messsage']				= $this->language->get('text_message');

		$data['entry_name'] 				= $this->language->get('entry_name');
		$data['entry_designation']			= $this->language->get('entry_designation');
		$data['entry_email']				= $this->language->get('entry_email');
		$data['entry_company'] 				= $this->language->get('entry_company');
		$data['entry_contact_number']		= $this->language->get('entry_contact_number');
		$data['entry_nature_of_business']	= $this->language->get('entry_nature_of_business');
		$data['entry_total_employees']		= $this->language->get('entry_total_employees');
		$data['entry_total_dependents']		= $this->language->get('entry_total_dependents');
		$data['entry_annual_budget']		= $this->language->get('entry_annual_budget');
		$data['entry_existing_hmo']				= $this->language->get('entry_existing_hmo');
		$data['entry_message']				= $this->language->get('entry_message');

		//$data['error_designation']			= $this->language->get('error_designation');

		$data['button_map'] = $this->language->get('button_map');

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['designation'])) {
			$data['error_designation'] = $this->error['designation'];
		} else {
			$data['error_designation'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['contact_number'])) {
			$data['error_contact_number'] = $this->error['contact_number'];
		} else {
			$data['error_contact_number'] = '';
		}

		if (isset($this->error['company'])) {
			$data['error_company'] = $this->error['company'];
		} else {
			$data['error_company'] = '';
		}

		if (isset($this->error['nature_of_business'])) {
			$data['error_nature_of_business'] = $this->error['nature_of_business'];
		} else {
			$data['error_nature_of_business'] = '';
		}

		if (isset($this->error['total_employees'])) {
			$data['error_total_employees'] = $this->error['total_employees'];
		} else {
			$data['error_total_employees'] = '';
		}

		if (isset($this->error['total_dependents'])) {
			$data['error_total_dependents'] = $this->error['total_dependents'];
		} else {
			$data['error_total_dependents'] = '';
		}

		if (isset($this->error['annual_budget'])) {
			$data['error_annual_budget'] = $this->error['annual_budget'];
		} else {
			$data['error_annual_budget'] = '';
		}

		if (isset($this->error['existing_hmo'])) {
			$data['error_existing_hmo'] = $this->error['existing_hmo'];
		} else {
			$data['error_existing_hmo'] = '';
		}

		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = '';
		}

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('module/requestform/sendmail', '', true);
		$data['store'] = $this->config->get('config_name');
		$data['address'] = nl2br($this->config->get('config_address'));
		$data['geocode'] = $this->config->get('config_geocode');
		$data['geocode_hl'] = $this->config->get('config_language');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['fax'] = $this->config->get('config_fax');
		$data['open'] = nl2br($this->config->get('config_open'));
		
		$this->load->model('tool/image');

		if ($this->config->get('config_image')) {
			$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
		} else {
			$data['image'] = false;
		}



		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}

		
		
		return $this->load->view('module/requestform', $data);
			
  	}

  	public function sendmail(){

  		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
            $this->load->model('setting/setting');
			//print_r("test");
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
	
				$mail->setTo($this->request->post['email']);
				$mail->setFrom($this->config->get('config_email'));
				//$mail->setBcc("honeynatividad@gmail.com");
				$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode("Business Request Form", ENT_QUOTES, 'UTF-8'));
				
				//$mail->setText($text);
				//$mail->send();

			

			$name = $this->request->post['name'];
			$designation = $this->request->post['designation'];
			$email = $this->request->post['email'];
			$contact_number = $this->request->post['contact_number'];
			$company = $this->request->post['company'];
			$nature_of_business =$this->request->post['nature_of_business'];
			$total_employees = $this->request->post['total_employees'];
			$total_dependents = $this->request->post['total_dependents'];
			$annual_budget = $this->request->post['annual_budget'];
			$existing_hmo = $this->request->post['existing_hmo'];
			$message = $this->request->post['message'];

			$sendMessage = '<p>Full Name: '.$name.'</p>';
			$sendMessage .= '<p>Designation: '.$designation.'</p>';
			$sendMessage .= '<p>Email Address: '.$email.'</p>';
			$sendMessage .= '<p>Contact Number: '.$contact_number.'</p>';
			$sendMessage .= '<p>Company Name : '.$company.'</p>';
			$sendMessage .= '<p>Nature of Business: '.$nature_of_business.'</p>';
			$sendMessage .= '<p>Total Number of Employees: '.$total_employees.'</p>';
			$sendMessage .= '<p>Annual Budget per head : '.$annual_budget.'</p>';
			$sendMessage .= '<p>Do you have existing HMO: '.$existing_hmo.'</p>';
			$sendMessage .= '<p>Message: '.$message.'</p>';

			$data['name'] = $name;
			$data['designation'] = $designation;
			$data['email'] = $email;
			$data['contact_number'] = $contact_number;
			$data['company'] = $company;
			$data['nature_of_business'] = $nature_of_business;
			$data['total_employees'] = $total_employees;
			$data['total_dependents'] = $total_dependents;
			$data['annual_budget'] = $annual_budget;
			$data['existing_hmo'] = $existing_hmo;
			$data['message'] = $message;

			$mail->setHtml($this->load->view('mail/business', $data));
			$mail->setText("TEST");
			$mail->send();
			//echo 'hello';
			if ($this->config->get('config_order_mail')) {
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
	
				$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->config->get('config_email'));
				//$mail->setBcc("honeynatividad@gmail.com");
				$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode("Business Request Form", ENT_QUOTES, 'UTF-8'));
				
				//$mail->setText($text);
				//$mail->send();

			

				$name = $this->request->post['name'];
				$designation = $this->request->post['designation'];
				$email = $this->request->post['email'];
				$contact_number = $this->request->post['contact_number'];
				$company = $this->request->post['company'];
				$nature_of_business =$this->request->post['nature_of_business'];
				$total_employees = $this->request->post['total_employees'];
				$total_dependents = $this->request->post['total_dependents'];
				$annual_budget = $this->request->post['annual_budget'];
				$existing_hmo = $this->request->post['existing_hmo'];
				$message = $this->request->post['message'];

				$sendMessage = '<p>Full Name: '.$name.'</p>';
				$sendMessage .= '<p>Designation: '.$designation.'</p>';
				$sendMessage .= '<p>Email Address: '.$email.'</p>';
				$sendMessage .= '<p>Contact Number: '.$contact_number.'</p>';
				$sendMessage .= '<p>Company Name : '.$company.'</p>';
				$sendMessage .= '<p>Nature of Business: '.$nature_of_business.'</p>';
				$sendMessage .= '<p>Total Number of Employees: '.$total_employees.'</p>';
				$sendMessage .= '<p>Annual Budget per head : '.$annual_budget.'</p>';
				$sendMessage .= '<p>Do you have existing HMO: '.$existing_hmo.'</p>';
				$sendMessage .= '<p>Message: '.$message.'</p>';

				$data['name'] = $name;
				$data['designation'] = $designation;
				$data['email'] = $email;
				$data['contact_number'] = $contact_number;
				$data['company'] = $company;
				$data['nature_of_business'] = $nature_of_business;
				$data['total_employees'] = $total_employees;
				$data['total_dependents'] = $total_dependents;
				$data['annual_budget'] = $annual_budget;
				$data['existing_hmo'] = $existing_hmo;
				$data['message'] = $message;

				$mail->setHtml($this->load->view('mail/business', $data));
				$mail->setText("TEST");
				$mail->send();
			}
			
			$this->response->redirect($this->url->link('module/requestform/success'));
		}
		//echo 'ELSE';
  	}

  	private function validate() {

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
    	    $this->error['name'] = $this->language->get('error_name');
	    }
	}

	public function success() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/success', $data));
	}

}
?>