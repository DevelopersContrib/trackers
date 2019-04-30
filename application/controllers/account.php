<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('vnocdata');
		$this->load->library('domainiqapi');
		$this->load->library('domainplexlib');
		$this->load->model('apikeydata');
	}
	
	
		
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	$data['title'] = "Trackers.com - Account Settings";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$userid = $this->session->userdata('userid');
	    	$data['query'] = $this->membersdata->getbyattribute('member_id',$userid);
	    	$this->load->view('account/index',$data);
	    }else {
	    	header ("Location: ".base_url());
	    }
		
			
	}
	
	public function generateapi(){
	    	$userid = $this->session->userdata('userid');
	    	$email = $this->membersdata->getinfobyid('email',$userid);
	    	
	    	$api_key = substr(sha1($email.$userid.time()), -16);
	    	$api_array = array('member_id'=>$userid,'api_key'=>$api_key);
	    	
	    	if ($this->apikeydata->checkexist('member_id',$userid)===false){
	    		$this->apikeydata->update(0,$api_array);
	    	}else {
	    		$id = $this->apikeydata->getinfo('id','member_id',$userid);
	    		$this->apikeydata->update($id,$api_array);
	    	}
			
	    	$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'key'=>$api_key,'message'=>'')));
	   
	}
	
	public function savepersonal(){
		$userid = $this->session->userdata('userid');
		$firstname = $this->db->escape_str($this->input->post('firstname'));
		$lastname = $this->db->escape_str($this->input->post('lastname'));
		$occupation = $this->db->escape_str($this->input->post('occupation'));
		$website = $this->db->escape_str($this->input->post('website'));
		
		$account_array = array('firstname'=>$firstname,'lastname'=>$lastname,'occupation'=>$occupation,'website'=>$website);
		$this->membersdata->update($userid,$account_array);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'message'=>'')));
		
	}
	
	public function saveaddress(){
		$userid = $this->session->userdata('userid');
		$address = $this->db->escape_str($this->input->post('address'));
		$city = $this->db->escape_str($this->input->post('city'));
		$state = $this->db->escape_str($this->input->post('state'));
		$zipcode = $this->db->escape_str($this->input->post('zipcode'));
		
		$account_array = array('address'=>$address,'city'=>$city,'state'=>$state,'zipcode'=>$zipcode);
		$this->membersdata->update($userid,$account_array);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'message'=>'')));
	}
	
	public function changepassword(){
		if ($this->session->userdata('logged_in')){
	    	$data['title'] = "Trackers.com - Change Password Settings";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$userid = $this->session->userdata('userid');
	    	$data['query'] = $this->membersdata->getbyattribute('member_id',$userid);
	    	$this->load->view('account/change_password',$data);
	    }else {
	    	header ("Location: ".base_url());
	    }
	}
	
	public function savepassword(){
		$userid = $this->session->userdata('userid');
		$current_password = $this->db->escape_str($this->input->post('current_password'));
		$new_password = $this->db->escape_str($this->input->post('new_password'));
		$status = false;
		$message = '';
		
		if (md5($current_password) == $this->membersdata->getinfo('password','member_id',$userid)){
			
			$p_array = array('password'=>md5($new_password));
			$this->membersdata->update($userid,$p_array);
			$status = true;
		}else {
			$message = 'Invalid current password';
		}
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'message'=>$message)));
	}
	
	public function apisettings(){
		if ($this->session->userdata('logged_in')){
	    	$data['title'] = "Trackers.com - API Settings";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$userid = $this->session->userdata('userid');
	    	$data['query'] = $this->apikeydata->getbyattribute('member_id',$userid);
	    	$this->load->view('account/api_settings',$data);
	    }else {
	    	header ("Location: ".base_url());
	    }
		
	}
}