<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fund extends CI_Controller {

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
	    	$data['title'] = "Trackers.com - Fund";
	    	$data['description'] =  $this->config->item('description');
	    	$data['fund_campaigns'] =  get_fund_campaigns();
	    	$data['domain'] =  $this->config->item('domain');
	    	$data['logo'] =  'https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png';
	    	$data['domainid'] = 41;
	   	    $this->load->view('fund/index',$data);
	    }
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */