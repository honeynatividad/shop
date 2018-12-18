<?php  
class ControllerModuleNewslettersubscribe extends Controller {
  	private $error = array();
	
	public function index($setting){
	   $data['title'] = $setting['title'][$this->config->get('config_language_id')]?$setting['title'][$this->config->get('config_language_id')]:'';
	   
	   $data['sub_title'] = $setting['sub_title'][$this->config->get('config_language_id')]?$setting['sub_title'][$this->config->get('config_language_id')]:'';
	   
	   $this->load->language('module/newslettersubscribe');

      	$data['heading_title'] = $this->language->get('heading_title');	
		
      	$data['entry_name'] = $this->language->get('entry_name');	
      	$data['entry_email'] = $this->language->get('entry_email');	
		
      	$data['entry_button'] = $this->language->get('entry_button');	
		
      	$data['entry_unbutton'] = $this->language->get('entry_unbutton');	
		
      	$data['option_unsubscribe'] = $this->config->get('option_unsubscribe');	
		
      	$data['option_fields'] = $this->config->get('newslettersubscribe_option_field');	
		
		$data['option_fields1'] = $this->config->get('newslettersubscribe_option_field1');	
		$data['option_fields2'] = $this->config->get('newslettersubscribe_option_field2');	
		$data['option_fields3'] = $this->config->get('newslettersubscribe_option_field3');	
		$data['option_fields4'] = $this->config->get('newslettersubscribe_option_field4');	
		$data['option_fields5'] = $this->config->get('newslettersubscribe_option_field5');	
		$data['option_fields6'] = $this->config->get('newslettersubscribe_option_field6');
		
		$data['text_subscribe'] = $this->language->get('text_subscribe');	
		$data['text_email'] = $this->language->get('text_email');
		
		$this->load->model('account/newslettersubscribe');
	   //check db
	    $this->model_account_newslettersubscribe->check_db();
		
		$this->id = 'newslettersubscribe';
		
		
			return $this->load->view('module/newslettersubscribe', $data);
		
	}
	
	public function subscribe(){
	
	if($this->config->get('newslettersubscribe_thickbox')){
	  $prefix_eval = "";
	}else{
	  $prefix_eval = "";
	}
	  
	  $this->language->load('module/newslettersubscribe');
	  
	  $this->load->model('account/newslettersubscribe');
	  
	  if(isset($this->request->post['subscribe_email']) and filter_var($this->request->post['subscribe_email'],FILTER_VALIDATE_EMAIL)){
           
		   if($this->config->get('newslettersubscribe_registered') and $this->model_account_newslettersubscribe->checkRegisteredUser($this->request->post)){
			   
			   
			    $this->model_account_newslettersubscribe->UpdateRegisterUsers($this->request->post,1);
				
			echo('$("'.$prefix_eval.' #subscribe_result").html("'.$this->language->get('subscribe').'");$("'.$prefix_eval.' #subscribe")[0].reset();');
			   
		    
		   }else if(!$this->model_account_newslettersubscribe->checkmailid($this->request->post)){
			 
			 $this->model_account_newslettersubscribe->subscribe($this->request->post);
		     echo('$("'.$prefix_eval.' #subscribe_result").html("'.$this->language->get('subscribe').'");$("'.$prefix_eval.' #subscribe")[0].reset();');
			 
			 
				 if($this->config->get('newslettersubscribe_mail_status')){
			   
			    $subject = $this->language->get('mail_subject');	
				
				$message = '<table width="60%" cellpadding="2"  cellspacing="1" border="0"> 
				  	         <tr>
							   <td> Email Id </td>
							   <td> '.$this->request->post['subscribe_email'].' </td>
							 </tr>
				  	         <tr>
							   <td> Name  </td>
							   <td> '.$this->request->post['subscribe_name'].' </td>
							 </tr>';
				if(isset($this->request->post['option1'])) {
				   $message .= '<tr> <td>'.$this->config->get('newslettersubscribe_option_field1').'</td> <td>'.$this->request->post['option1'].'</td> </tr>';  
				}
				if(isset($this->request->post['option2'])) {
				   $message .= '<tr> <td>'.$this->config->get('newslettersubscribe_option_field2').'</td> <td>'.$this->request->post['option2'].'</td> </tr>';  
				}
				if(isset($this->request->post['option3'])) {
				   $message .= '<tr> <td>'.$this->config->get('newslettersubscribe_option_field3').'</td> <td>'.$this->request->post['option3'].'</td> </tr>';  
				}
				if(isset($this->request->post['option4'])) {
				   $message .= '<tr> <td>'.$this->config->get('newslettersubscribe_option_field4').'</td> <td>'.$this->request->post['option4'].'</td> </tr>';  
				}
				if(isset($this->request->post['option5'])) {
				   $message .= '<tr> <td>'.$this->config->get('newslettersubscribe_option_field5').'</td> <td>'.$this->request->post['option5'].'</td> </tr>';  
				}
				if(isset($this->request->post['option6'])) {
				   $message .= '<tr> <td>'.$this->config->get('newslettersubscribe_option_field6').'</td> <td>'.$this->request->post['option6'].'</td> </tr>';  
				} 
				 $message .= '</table>';
	 
				$mail = new Mail($this->config->get('config_mail'));							
				$mail->setTo($this->request->post['subscribe_email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject($subject);
				$mail->setHtml($message);
				$mail->send();
			}
			 
		   }else{
				  echo('$("'.$prefix_eval.' #subscribe_result").html("<span class=\"error\">'.$this->language->get('alreadyexist').'</span>");$("'.$prefix_eval.' #subscribe")[0].reset();');	 
		   }
		   
	  }else{
	    echo('$("'.$prefix_eval.' #subscribe_result").html("<span class=\"error\">'.$this->language->get('error_invalid').'</span>")');
	  }
	}

	public function unsubscribe(){
	  
	  if($this->config->get('newslettersubscribe_thickbox')){
		  $prefix_eval = "#TB_ajaxContent ";
	  }else{
	      $prefix_eval = "";
	  }
	  
	  $this->language->load('module/newslettersubscribe');
	  
	  $this->load->model('account/newslettersubscribe');
	  
	  if(isset($this->request->post['subscribe_email']) and filter_var($this->request->post['subscribe_email'],FILTER_VALIDATE_EMAIL)){
            
		    if($this->config->get('newslettersubscribe_registered') and $this->model_account_newslettersubscribe->checkRegisteredUser($this->request->post)){
			   
			    $this->model_account_newslettersubscribe->UpdateRegisterUsers($this->request->post,0);
				
			echo('$("'.$prefix_eval.' #subscribe_result").html("'.$this->language->get('unsubscribe').'");$("'.$prefix_eval.' #subscribe")[0].reset();');
			   
		    
		   }else if(!$this->model_account_newslettersubscribe->checkmailid($this->request->post)){
			 
		     echo('$("'.$prefix_eval.' #subscribe_result").html("'.$this->language->get('notexist').'");$("'.$prefix_eval.' #subscribe")[0].reset();');
			 
		   }else{
			   
			  if($this->config->get('option_unsubscribe')) {
				 $this->model_account_newslettersubscribe->unsubscribe($this->request->post);
				 echo('$("'.$prefix_eval.' #subscribe_result").html("'.$this->language->get('unsubscribe').'");$("'.$prefix_eval.' #subscribe")[0].reset();');
			  }
		   }
		   
	  }else{
	    echo('$("'.$prefix_eval.' #subscribe_result").html("<span class=\"error\">'.$this->language->get('error_invalid').'</span>")');
	  }
	}
}
?>