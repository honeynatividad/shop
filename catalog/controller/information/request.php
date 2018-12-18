<?php
class ControllerInformationRequest extends Controller {

	public function index() {
		$this->load->language('information/request');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//print_r("test");
			$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
	
				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				//$mail->setHtml($this->load->view('mail/order', $data));
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

			$mail->setText($sendMessage);
			$mail->send();
			echo 'hello';
			//$this->response->redirect($this->url->link('information/contact/success'));
		}

		//init
		echo 'ELSE';
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/request')
		);

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
		$data['entry_contact_number']		= $this->language->get('entry_contact_number');
		$data['entry_nature_of_business']	= $this->language->get('entry_nature_of_business');
		$data['entry_total_employees']		= $this->language->get('entry_total_employees');
		$data['entry_total_dependents']		= $this->language->get('entry_total_dependents');
		$data['entry_annual_budget']		= $this->language->get('entry_annual_budget');
		$data['entry_message']				= $this->language->get('entry_message');

		$data['button_map'] = $this->language->get('button_map');

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('information/request', '', true);
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



		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/request', $data));

	}

	private function validate() {

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
    	    $this->error['name'] = $this->language->get('error_name');
	    }
	}

	public function download_form(){

		//Assume that $filename and $filePath are correclty set.
		$file = "http://shop.philcare.com.ph/image/philcare/download/Health360HealthProHealthLuxe-ApplicationForm.pdf";
		//$file = $this->url->link('information/request/download_form');
		//$file = "location of file to download"
		$content = file_get_contents($file);
		header('Content-Type: application/pdf');
		header('Content-Length: '.strlen( $content ));
		header('Content-disposition: inline; filename="' . $file . '"');
		header('Cache-Control: public, must-revalidate, max-age=0');
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 2027 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		echo $content;
		
	}
	public function download_forms(){

		//Assume that $filename and $filePath are correclty set.
		$filename = "http://shop.philcare.com.ph/image/philcare/download/HV Registration form.pdf";
		$filePath = $this->url->link('information/request/download_forms');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		// header('Content-Type: application/force-download'); Non-standard MIME-Type, incompatible with Samsung C3050 for example. Let it commented
		readfile($filePath);
		
	}
}