<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
	}
	
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	
		$array_items = array('name' => '', 'userid' => '', 'logged_in' => FALSE);
	    $this->session->unset_userdata($array_items);
	    $this->session->sess_destroy();
		header ("Location: ".base_url());
	    	
	    }else {
	    	header ("Location: ".base_url());
	    }
	}
	
	
}