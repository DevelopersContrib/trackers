<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
	}
	
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	header ("Location: ".base_url()."dashboard");
	    }else {
	    	$data['title'] = "Trackers.com - Signup";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$this->load->view('signup/index',$data);
	    }
	}
	
	public function confirm(){
		$code = $this->uri->segment(3);
		$email = $this->uri->segment(4);
		$message = "";
		$success_message = "";
		if ($code != ""){
			if ($email != ""){
				
			    $email = base64_decode($email);
				if ($this->membersdata->checkexist('code',$code,'email',$email)===true){
					
					$verified = $this->membersdata->getinfo('is_verified','code',$code,'email',$email);
					$member_id = $this->membersdata->getinfo('member_id','code',$code,'email',$email);
					if ($verified == 0){
						$data = array('is_verified'=>1);
						$this->membersdata->update($member_id,$data);
						$success_message = "You successfully verified your account. You can login now.";
					}else {
						$message = "You already verified your email account";
					}
					
				}else {
					$message = "Verification link does not exist.";
				}
			}else {
				$message = "Invalid verification link - email is required";
			}
		}else {
			$message = "Invalid verification link - code is required";
		}
		$this->session->set_userdata(array('confirm_error'=>$message,'confirm_success'=>$success_message));
		header ("Location: ".base_url()."login");
	}
	
	public function ajaxsaveuser(){
			$firstname = $this->db->escape_str($this->input->post('first_name'));
			$lastname = $this->db->escape_str($this->input->post('last_name'));
			$email = $this->db->escape_str($this->input->post('email'));
			$password = $this->db->escape_str($this->input->post('password'));
			$domain = $this->db->escape_str($this->input->post('domain'));
			$user_ip = $this->db->escape_str($this->input->post('user_ip'));
			$message = "";
			$field = "";
			$status = false;
			
			if ($this->membersdata->checkexist('email',$email)===false){
				$code = md5(time());
				$data = array(
					'firstname'=>$firstname,
					'lastname'=>$lastname,
					'email'=>$email,
					'password'=>md5($password),
					'code'=> $code
				);
				
				$user_id = $this->membersdata->update(0,$data);
				$status = true;
				
				
				require $this->config->item('sendgrid_path');
				 $emldata = array('firstname' => $firstname,
				'code' => $code,
				'email' => $email
			);
			
			$msg = $this->load->view('signup/signup_template',$emldata,true);
			$html_content = wordwrap($msg);	
			$from = new SendGrid\Email("Trackers Info", "info@trackers.com");
			$to = new SendGrid\Email(null, $email);
			$reply_to = new SendGrid\Email('Trackers Info', "info@trackers.com");
			$content = new SendGrid\Content("text/html", $html_content);
			$mail = new SendGrid\Mail($from, 'Please activate your Trackers.com account', $to,  $content);
			$mail->setReplyTo($reply_to);
			$sg = new \SendGrid($this->config->item('sendgrid_key'));
			$response = $sg->client->mail()->send()->post($mail);	
				
			}else {
				$message = 'Email already exists.';
				$field = 'email';
			}
			
			$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status,'message'=>$message,'field'=>$field,'email'=>$email,'ip'=>$user_ip,'domain'=>$domain)));	
	}
}