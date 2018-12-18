<?php 
// RegEx
define('EMAIL_PATTERN', '/^[^\@]+@.*\.[a-z]{2,6}$/i');
 
class ControllerBossthemesisitestimonial extends Controller {
	private $error = array(); 

	protected function str_split_unicode($str, $l = 0) {
	    if ($l > 0) {
	        $ret = array();
	        $len = mb_strlen($str, "UTF-8");
	        for ($i = 0; $i < $len; $i += $l) {
	            $ret[] = mb_substr($str, $i, $l, "UTF-8");
	        }
	        return $ret;
	    }
	    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
	}

	    
  	public function index() {
		$this->load->language('bossthemes/isitestimonial');
		$this->document->SetTitle( $this->language->get('heading_title'));
	   	$data['heading_title'] = $this->language->get('heading_title');
		//$data['ip'] = $this->request->server['REMOTE_ADDR'];

		$this->language->load('module/boss_testimonial');
		$data['show_all'] = $this->language->get('show_all');
		$data['showall_url'] = $this->url->link('bossthemes/boss_testimonial', '', true);
		$data['button_send'] = $this->language->get('button_send');

		$this->load->model('bossthemes/boss_testimonial');
 
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$data['data']=array();
			$data['data']['name'] = strip_tags(html_entity_decode($this->request->post['name']));
			$data['data']['city'] = strip_tags(html_entity_decode($this->request->post['city']));
			$data['data']['rating'] = $this->request->post['rating'];				
			$data['data']['email'] = strip_tags(html_entity_decode($this->request->post['email']));
			$data['data']['title'] = strip_tags(html_entity_decode($this->request->post['title']));

			$data['data']['description'] = strip_tags(html_entity_decode($this->request->post['description']));


			$descriptions = explode(" ", $data['data']['description']);
			$size = count($descriptions);
			for($i=0; $i<$size; $i++)
			{ 
				$w_arr = $this->str_split_unicode($descriptions[$i],14);
				$descriptions[$i] = implode(" ",$w_arr);

			}
			$data['data']['description'] = implode(" ",$descriptions);

			if (!$this->config->get('testimonial_admin_approved'))
				$this->model_bossthemes_boss_testimonial->addTestimonial($data['data'], 1);
			else
				$this->model_bossthemes_boss_testimonial->addTestimonial($data['data'], 0);

			$this->session->data['success'] = $this->language->get('text_add');
			

			// send email
			
			$this->response->redirect($this->url->link('bossthemes/isitestimonial/success', '', true));

			
		}
			
	
      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
	        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', true),
	        	'separator' => false
      	);

      	$data['breadcrumbs'][] = array(
	        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossthemes/isitestimonial', '', true),
	        	'separator' => $this->language->get('text_separator')
      	);			

	    	$data['entry_title'] = $this->language->get('entry_title');
	
	    	$data['entry_name'] = $this->language->get('entry_name');
	    	$data['entry_city'] = $this->language->get('entry_city');
	    	$data['entry_email'] = $this->language->get('entry_email');
	    	$data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['entry_bad'] = $this->language->get('entry_bad');
		$data['text_note'] = $this->language->get('text_note');
		$data['text_conditions'] = $this->language->get('text_conditions');


		if (isset($this->error['name'])) {
    		$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['title'])) {
    		$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}
		
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}		
			
		if (isset($this->error['enquiry'])) {
			$data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}		
		
 		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}	

    		$data['button_continue'] = $this->language->get('button_continue');
    
    		$data['action'] = $this->url->link('bossthemes/isitestimonial', '', true);

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = '';
		}
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} else {
			$data['title'] = '';
		}
		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} else {
			if ($this->config->get('testimonial_default_rating')=='')
				$data['rating'] = '3';
			else
				$data['rating'] = $this->config->get('testimonial_default_rating');

		}
		
		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} else {
			$data['description'] = '';
		}
		
		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}		
	
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
			$this->response->setOutput($this->load->view('bossthemes/isitestimonial', $data));
		
  	}

  	public function success() {
		$this->load->language('bossthemes/isitestimonial');

		$this->document->SetTitle($this->language->get('isi_testimonial')); 

	    $data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', true),
        		'separator' => false
      	);

      	$data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossthemes/isitestimonial', '', true),
        		'separator' => $this->language->get('text_separator')
      	);			
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_message');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home', '', true);

	
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
			$this->response->setOutput($this->load->view('common/success', $data));
		
	}

	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
  	private function validate() {

	    	if ((strlen(utf8_decode($this->request->post['description'])) < 1) || (strlen(utf8_decode($this->request->post['description'])) > 999)) {
	      		$this->error['enquiry'] = $this->language->get('error_enquiry');
	    	}
	
	    	if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
	      		$this->error['captcha'] = $this->language->get('error_captcha');
	    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  	  
  	}
}
?>
