<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('domaindirectorydata');
		$this->load->model('contactdata');
	}
	
	
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	header ("Location: ".base_url()."dashboard");
	    }else {
	    	$data['title'] = "Trackers.com - Contact Us";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$this->load->view('contact/index',$data);
	    }
	}
	
	public function ajaxsavecontact(){
		$name = $this->db->escape_str($this->input->post('name'));
		$email = $this->db->escape_str($this->input->post('email'));
		$subject = $this->db->escape_str($this->input->post('subject'));
		$message = $this->db->escape_str($this->input->post('message'));
		$status = false;
		
		$domain = $this->config->item('domain');
		
		$contactdata = array('name'=>$name,'email'=>$email,'subject'=>$subject,'message'=>$message);
		
		$this->contactdata->update(0,$contactdata);
		
		$data_inquiry = array(
				'name'=>$name,
				'email'=>$email,
				'contact_number'=>'11111111',
				'service'=>27,
				'datetime_created'=>date("Y-m-d H:i:s"),
				'inquiry_msg'=>$message,
				'domain_name'=>$this->config->item('domain')
				);
				
		$this->domaindirectorydata->update('service','id',0,$data_inquiry);		
		
		
		
	    
			$contactemail = "kjabellar@gmail.com,lucille2911@gmail.com,catherinesicuya@gmail.com";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			$headers .= "From: Contrib Registration<admin@contrib.com>\r\n".'X-Mailer: PHP/' . phpversion();
			$emailmessage = '
			This email submitted an inquiry form at '.ucwords($domain).'
			<br>				
			<br>Domain : '.ucwords($domain).'
			<br>Name : '.$name.'
			<br>Email : '.$email.'
			<br>Inquiry :'.$message.'
			<br>				
			';	
				//send mail through sendgrid
				require $this->config->item('sendgrid_path');
				$subject = ucwords($domain)." inquiry: ".$subject;
				$emailmessage = wordwrap($emailmessage);	
				$from = new SendGrid\Email("Trackers Support", "info@trackers.com");
				$adminmails = explode(',',$contactemail);
				foreach ($adminmails as $receiver_email){ 
					$to = new SendGrid\Email('Admin', $receiver_email);
					$reply_to = new SendGrid\Email('Trackers Support', 'admin@contrib.com');
					$content = new SendGrid\Content("text/html", $emailmessage);
					$mail = new SendGrid\Mail($from, $subject, $to, $content);
					$mail->setReplyTo($reply_to);
					$sg = new \SendGrid($this->config->item('sendgrid_key'));
					$response = $sg->client->mail()->send()->post($mail);
				
			}
			
			$status = true;
			$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status)));
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */