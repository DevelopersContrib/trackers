<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Domains extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('vnocdata');
		$this->load->model('campaigndata');
		$this->load->model('leadsdata');
		$this->load->model('leadsdomaindata');
		$this->load->model('leadssocialdata');
		$this->load->library('domainiqapi');
		$this->load->library('domainplexlib');
		$this->load->library('datatables');
		$this->load->database();
	}
	
	
		
	
	public function domainlist(){
		 $campaign_id = $this->db->escape_str($this->input->get('campaign_id'));
		 $select = 'tracker_leads_domains.id,tracker_leads_domains.domain,tracker_leads_domains.appraise_value,tracker_leads_domains.owner, tracker_leads_domains.registrar,tracker_leads_domains.expire_date,tracker_campaigns.campaign_name';
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
    
	if(!empty($campaign_id)){
			$this->datatables->where('tracker_campaigns.id',$campaign_id);
		}
		
		$this->datatables
			->select($select)
			->from('tracker_leads_domains')
			->join('tracker_campaigns','tracker_campaigns.id = tracker_leads_domains.campaign_id')
			->where('tracker_campaigns.member_id',$this->session->userdata('userid'));
		echo $this->datatables->generate(); 
	}
	
   public function movecampaignform(){
    	$entries = $this->input->post('entries');
    	$userid = $this->session->userdata('userid');
    	$data['campaigns'] =  $this->campaigndata->getallbyuser($userid);
    	$data['entries'] = implode(',',$entries);
		$html =  $this->load->view('domains/move_campaign_form',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
    }
    
 public function savedomainnewcampaign(){
    	$entries = $this->input->post('entries');
    	$campaign_id = $this->db->escape_str($this->input->post('campaign_id'));
    	
    	$domains = explode(',',$entries);
    	
    	foreach ($domains as $id){
    		$l_array = array('campaign_id'=>$campaign_id);
    		$this->leadsdomaindata->update($id,$l_array);
    	}
    	$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'message'=>'')));
    	
    }
    
  public function deletedomainconfirm(){
    	$entries = $this->input->post('entries');
    	$data['entries'] = implode(',',$entries);
		$html =  $this->load->view('domains/delete_domain_confirm',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
    }
    
    public function deletedomain(){
    	$entries = $this->input->post('entries');
    	$domains = explode(',',$entries);
        foreach ($domains as $id){
        	$this->leadsdomaindata->delete('id',$id);
       }
    	
    	$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'message'=>'')));
    }
    
public function sendemailform(){
    	$entries = $this->input->post('entries');
    	$data['entries'] = implode(',',$entries);
    	$userid = $this->session->userdata('userid');
    	$data['from_name'] = $this->membersdata->getinfobyid('firstname',$userid).' '.$this->membersdata->getinfobyid('lastname',$userid);
    	$data['from_email'] = $this->membersdata->getinfobyid('email',$userid);
		$html =  $this->load->view('domains/send_email_form',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
    }
    
public function sendmaildomain(){
    	$entries = $this->input->post('entries');
    	$subject = $this->db->escape_str($this->input->post('subject'));
    	$from_name = $this->db->escape_str($this->input->post('from_name'));
    	$from_email = $this->db->escape_str($this->input->post('from_email'));
    	$message = $this->db->escape_str($this->input->post('message'));
    	$domains = explode(',',$entries);
    	 require $this->config->item('sendgrid_path');
   		foreach ($domains as $id){
        	$to_email = "";
        	$to_name = "";
        	
   			$query = $this->db->query("SELECT `tracker_leads`.* FROM `tracker_leads` INNER JOIN `tracker_leads_domains` ON (`tracker_leads_domains`.`lead_id` = `tracker_leads`.`id`)
WHERE `tracker_leads_domains`.id = '$id'");
	   		if ($query->num_rows() > 0){
		        foreach ($query->result() as $row)
		         {
		           $to_email =  $row->email;
		           $to_name =  $row->name;
		         }
	       }
	       
	      $to_email = 'kjcastanos@gmail.com';
	      if ($to_email != ''){
	      	
				 $emldata = array('to_name' => $to_name,
				'message' => $message,
				'from_email' => $from_email,
				'from_name' => $from_name,
			);
			
			$msg = $this->load->view('leads/mail_template',$emldata,true);
			$html_content = wordwrap($msg);	
			$from = new SendGrid\Email("Trackers - $from_name", "$from_email");
			$to = new SendGrid\Email($to_name, $to_email);
			$reply_to = new SendGrid\Email("Trackers - $from_name", "$from_email");
			$content = new SendGrid\Content("text/html", $html_content);
			$mail = new SendGrid\Mail($from, $subject, $to,  $content);
			$mail->setReplyTo($reply_to);
			$sg = new \SendGrid($this->config->item('sendgrid_key'));
			$response = $sg->client->mail()->send()->post($mail);	
	      }
        	
    	}
    	
    	$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true)));
    }
}