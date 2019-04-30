<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('resetpassworddata');
		
	}
	
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	header ("Location: ".base_url()."dashboard");
	    }else {
	    	$data['title'] = "Trackers.com - Forgot Password";
	    	$data['description'] =  $this->config->item('description');
	   	    $this->load->view('forgot/index',$data);
	    }
	}
	
	public function ajaxsendreset(){
		$email = $this->db->escape_str($this->input->post('email'));
		$status = false;
		$message = "";
		if ($this->membersdata->checkexist('email',$email)===true){
			
			$this->resetpassworddata->delete('email',$email);
		
			$code = md5(time());
			$data = array(
					'email'=>$email,
					'code'=>$code
				);
				
				$this->resetpassworddata->update(0,$data);
				$this->sendresetemail($email,$code);
				$status = true;
				
		}else {
			$message = "Email doest not exist.";
		}
		$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status,'message'=>$message,'code'=>$code)));
	}
	
   public function reset()
	{
		if ($this->session->userdata('logged_in')){
	    	header ("Location: ".base_url()."dashboard");
	    }else {
	    	$data['title'] = "Trackers.com - Reset Password";
	    	$data['description'] =  $this->config->item('description');
	    	$code = $this->uri->segment(3);
	    	$error_message = "";
	    	
	    	if ($code != ""){
				if ($this->resetpassworddata->checkexist('code',$code)===true){
					
				}else {
					$error_message = 'Password reset request does not exist.';
				}
	    		
	    	}else {
	    		$error_message = 'Password reset request does not exist.';
	    	}
	    	$data['code'] = $code;
	    	$data['error_message'] = $error_message;
	    	
	   	    $this->load->view('forgot/reset',$data);
	    }
	}
	
	public function resend(){
		$code = $this->db->escape_str($this->input->post('code'));
		$status = true;
		
		$email = $this->resetpassworddata->getinfo('email','code',$code);
		$this->sendresetemail($email,$code);
		$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status)));
	}
	
	public function ajaxupdatepassword(){
		$code = $this->db->escape_str($this->input->post('code'));
		$password = $this->db->escape_str($this->input->post('password'));
		$status = true;
		
		$email = $this->resetpassworddata->getinfo('email','code',$code);
		$user_id = $this->membersdata->getinfo('member_id','email',$email);
		$data = array(
					'password'=>md5($password)
				);
		$user_id = $this->membersdata->update($user_id,$data);
		$this->resetpassworddata->delete('email',$email);
		$this->session->set_userdata(array('confirm_error'=>'','confirm_success'=>'You successfully updated your password. You can now login.'));
		
		$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status)));		
	}
    
	private function sendresetemail($email,$code){
		
	   $firstname = $this->membersdata->getinfo('firstname','email',$email);
		require $this->config->item('sendgrid_path');
				 $emldata = array('firstname' => $firstname,
				'code' => $code,
				'email' => $email
			);
			
			$msg = $this->load->view('forgot/forgot_template',$emldata,true);
			$html_content = wordwrap($msg);	
			$from = new SendGrid\Email("Trackers Info", "info@trackers.com");
			$to = new SendGrid\Email(null, $email);
			$reply_to = new SendGrid\Email('Trackers Info', "info@trackers.com");
			$content = new SendGrid\Content("text/html", $html_content);
			$mail = new SendGrid\Mail($from, 'Password reset request from Trackers.com', $to,  $content);
			$mail->setReplyTo($reply_to);
			$sg = new \SendGrid($this->config->item('sendgrid_key'));
			$response = $sg->client->mail()->send()->post($mail);	
		
		
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */