<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('vnocdata');
		$this->load->model('campaigndata');
		$this->load->library('datatables');
	}
	
	
		
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	$data['title'] = "Trackers.com - Campaigns";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$this->load->view('campaigns/index',$data);
	    }else {
	    	header ("Location: ".base_url());
	    }
		
			
	}
	
public function campaignlist(){
		  $select = 'id,campaign_name,date_added';
		  $sWhere = '';
		  $aColumns = explode(',' , $select);
		if (isset($_GET['search'])){
			
		      $search = $_GET['search'];
		      $sSearch = $this->db->escape_like_str(trim($search['value']));
		      
		      $sWhere = "(";

				for ( $i=0 ; $i<count($aColumns) ; $i++ ){
					if (!empty($sSearch)){
						if(strpos($aColumns[$i],'.')){
							$sWhere .= "".$aColumns[$i]." LIKE '%".$sSearch."%' OR ";
						}else{
							$sWhere .= "`".$aColumns[$i]."` LIKE '%".$sSearch."%' OR ";
						}
					}
				}
				$sWhere .= ')';
		      
		}
		
	if($sWhere!="()"){
		$sWhere = str_replace("OR )",")",$sWhere);
		$this->datatables->where($sWhere);
    }

    if (isset($_GET['order'])){
    	$order = $_GET['order'];
    	$index = $order[0]['column'];
    	$this->datatables->order_by($aColumns[$index],$order[0]['dir']); 
    }
		$this->datatables
			->select($select)
			->from('tracker_campaigns')
			->where('member_id',$this->session->userdata('userid'));
		echo $this->datatables->generate(); 
	}
	
	public function editform(){
		$id =  $this->db->escape_str($this->input->post('id'));
		
		if ($id != ''){
			$data['campaign_name'] = $this->campaigndata->getinfobyid('campaign_name',$id);
			$data['campaign_id'] = $id;
		}else {
			$data['campaign_name'] = '';
			$data['campaign_id'] = '';
		}
		$html =  $this->load->view('campaigns/edit_campaign',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
	}
	
	public function savecampaign(){
		$id =  $this->db->escape_str($this->input->post('id'));
		$campaign_name = $this->db->escape_str($this->input->post('campaign_name'));
		$userid = $this->session->userdata('userid');
		
		if ($id == ''){
			$id = 0;
		}
		
		$carray = array('campaign_name'=>$campaign_name,'member_id'=>$userid);
		$this->campaigndata->update($id,$carray);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true)));
	}
	
	public function deletecampaigns(){
		$entries =  $this->db->escape_str($this->input->post('entries'));
		if (count($entries)>0){
			foreach ($entries as $id){
				$this->campaigndata->delete('id',$id);
			}
		}
		
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true)));
	}
	
}