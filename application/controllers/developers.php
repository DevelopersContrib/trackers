<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developers extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	header ("Location: ".base_url()."dashboard");
	    }else {
	    	$data['title'] = "Trackers.com - Developers";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$this->load->view('developers/index',$data);
	    }
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */