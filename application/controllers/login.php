<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
	    	$data['title'] = "Trackers.com - Login";
	    	$data['description'] =  $this->config->item('description');
	    	$data['confirm_error'] =  $this->session->userdata('confirm_error');
	    	$data['confirm_success'] =  $this->session->userdata('confirm_success');
	    	$this->session->set_userdata(array('confirm_error'=>'','confirm_success'=>''));
	   	    $this->load->view('login/index',$data);
	    }
	}
	
	public function ajaxlogin(){
		$email = $this->db->escape_str($this->input->post('email'));
		$password = $this->db->escape_str($this->input->post('password'));
		$message = "";
		$field = "";
		$status = false;
		$password = md5($password);
		if ($this->membersdata->checkexist('email',$email,'password',$password)===true){
			 $newdata = array(
                   'name'  => $this->membersdata->getinfo('firstname','email',$email),
                   'userid'     =>  $this->membersdata->getinfo('member_id','email',$email),
                   'logged_in' => TRUE	
               );

         $this->session->set_userdata($newdata);
        $status = true; 
		}else {
			$message = "Account does not exist.";
			$field = "email";
		}
		$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status,'message'=>$message,'field'=>$field)));
	}
}