<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiv1 extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('apikeydata');
	}
	
	
	
	public function getcampaigns(){
		$api_key = $this->db->escape_str($this->input->get('api_key'));
		$status = 'failed';
		$message = '';
		$campaigns = array();
		
		if ($api_key != ''){
		
			if ($this->apikeydata->checkexist('api_key',$api_key)===true){
				$status = 'success';
                $member_id = $this->apikeydata->getinfo('member_id','api_key',$api_key);
                $query = $this->db->query("SELECT * FROM `tracker_campaigns` WHERE `member_id` = '$member_id' ORDER BY campaign_name ");
				if ($query->num_rows() > 0){
			        foreach ($query->result() as $row)
			         {
			           $campaigns[] =  array('id'=>$row->id,'campaign_name'=>$row->campaign_name,'date_added'=>$row->date_added);
			         }
		        }  
			            
			}else {
				$message = "Api key does not exist.";
				
			}
		}else {
			$message = "Api key is required.";
		}
		$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status,'message'=>$message,'campaigns'=>$campaigns)));
	}
	
	
	public function getleads(){
		$api_key = $this->db->escape_str($this->input->get('api_key'));
		$campaign_id = $this->db->escape_str($this->input->get('campaign_id'));
		$status = 'failed';
		$message = '';
		$leads = array();
		
		if ($api_key != ''){
			
			if ($campaign_id !=''){
		
				if ($this->apikeydata->checkexist('api_key',$api_key)===true){
					$status = 'success';
	                $member_id = $this->apikeydata->getinfo('member_id','api_key',$api_key);
	                $query = $this->db->query("SELECT * FROM `tracker_leads` WHERE campaign_id ='$campaign_id' AND `member_id` = '$member_id'");
					if ($query->num_rows() > 0){
				        foreach ($query->result() as $row)
				         {
				           $leads[] =  array('id'=>$row->id,'name'=>$row->name,'email'=>$row->email,'address'=>$row->address,'phone'=>$row->phone,'company'=>$row->company,'notes'=>$row->notes,'date_added'=>$row->date_added);
				         }
			        }  
				            
				}else {
					$message = "Api key does not exist.";
					
				}
			}else {
				$message = "Campaign id is required.";
			}
		}else {
			$message = "Api key is required.";
		}
		$this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('status'=>$status,'message'=>$message,'leads'=>$leads)));
	}
}