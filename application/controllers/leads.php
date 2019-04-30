<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leads extends CI_Controller {

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
	
	
		
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	$data['title'] = "Trackers.com - My Leads";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$userid = $this->session->userdata('userid');
	    	$data['campaigns'] =  $this->campaigndata->getallbyuser($userid);
	    	$data['import_error'] =  $this->session->userdata('import_error');
	    	$data['import_success'] =  $this->session->userdata('import_success');
	    	 $this->session->set_userdata(array('import_error'=>'','import_success'=>''));
	    	$this->load->view('leads/index',$data);
	    }else {
	    	header ("Location: ".base_url());
	    }
	}
	
	public function leadslist(){
		 $campaign_id = $this->db->escape_str($this->input->get('campaign_id'));
		 $select = 'tracker_leads.id,tracker_leads.name,tracker_leads.email,tracker_campaigns.campaign_name,tracker_leads.status,tracker_leads.company, tracker_leads.notes,tracker_leads.date_added';
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
			$this->datatables->where('tracker_leads.campaign_id',$campaign_id);
		}
		$this->datatables
			->select($select)
			->from('tracker_leads')
			->join('tracker_campaigns','tracker_campaigns.id=tracker_leads.campaign_id')
			->where('tracker_campaigns.member_id',$this->session->userdata('userid'));
		echo $this->datatables->generate(); 
	}
	
	
   public function showsocials(){
			$owner_id = $this->db->escape_str($this->input->post('owner_id')); 
			$socials = "";
			$query = $this->db->query("SELECT GROUP_CONCAT(tracker_leads_socials.social_url SEPARATOR '<br>') AS socials FROM `tracker_leads_socials` WHERE tracker_leads_socials.lead_id = '$owner_id' ");
			if ($query->num_rows() > 0){
	        foreach ($query->result() as $row)
	         {
	           $socials =  $row->socials;
	         }
	     	}
	     echo $socials;
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
	
	public function importpeopleform(){
		$userid = $this->session->userdata('userid');
	    $data['campaigns'] =  $this->campaigndata->getallbyuser($userid);
		$html =  $this->load->view('leads/import_form',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
	}
	
public function processimportcsv(){
	    $config['upload_path'] = './uploads/import';
	    $config['allowed_types'] = 'csv';
  	    $this->load->library('upload', $config);
    	$this->load->model('bulkupload');
    	$campaign_id = $this->db->escape_str($this->input->post('modal_people_campaign'));
    	$error = "";
    	$success="";
    	
    	 if ( ! $this->upload->do_upload('csv_file'))
		{
			$error =  $this->upload->display_errors();
			
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
	  		 	 foreach ($this->upload->data('csv_file') as $item => $value){
	            if ($item=="full_path"){
	              $fullpath = $value;
	            }
	          }
	          $result = $this->bulkupload->ProcessResearchCSV($fullpath,$campaign_id);
		      $content = "";
	          if($result["Successful"]>0){
			  	$success = 'You successfully saved "'.$result["Successful"].'" out of "'.$result["Items"].'" leads';
					
			  }
		    if(!empty($result["Errors"])){

		     		foreach($result["Errors"] as $key=>$value){
						$error .= 'Error '.$value["Record"].' - '.$value["Error"].'<br>'; 
					}
					
			  }
		    }  
            
		    
		   $this->session->set_userdata(array('import_error'=>$error,'import_success'=>$success));
		   header ("Location: ".base_url().'leads');
    }
    
    public function editleadform(){
    	$lead_id = $this->db->escape_str($this->input->post('lead_id'));
    	$data['campaign_id'] = '';
    	$data['name'] = '';
    	$data['email'] = '';
    	$data['address'] = '';
    	$data['phone'] = '';
    	$data['company'] = '';
    	$data['notes'] = '';
    	$data['domains'] = '';
    	$data['socials'] = '';
    	$data['lead_id'] = $lead_id;
    	
    	if ($lead_id != ''){
	    	$lquery = $this->leadsdata->getbyattribute('id',$lead_id);
	    	$dquery = $this->leadsdomaindata->getbyattribute('lead_id',$lead_id);
	    	$squery = $this->leadssocialdata->getbyattribute('lead_id',$lead_id);
	    	$socials_array = array();
	    	$domains_array = array();
	    	
	    	$data['campaign_id'] = $lquery->row()->campaign_id;
	    	$data['name'] = $lquery->row()->name;
	    	$data['email'] = $lquery->row()->email;
	    	$data['address'] = $lquery->row()->address;
	    	$data['phone'] = $lquery->row()->phone;
	    	$data['company'] = $lquery->row()->company;
	    	$data['notes'] = $lquery->row()->notes;
	    	
	    	
	    	
	    	if ($dquery->num_rows() > 0){
	    		foreach ($dquery->result() as $row){
	    			$domains_array[] = $row->domain;
	    		} 	
	    	}
	    	
	    	if ($squery->num_rows() > 0){
	    		foreach ($squery->result() as $row){
	    			$socials_array[] = $row->social_url;
	    		} 	
	    	}
	    	
	    	if (count($domains_array)>0){
	    		$data['domains'] = implode("\n",$domains_array);
	    	}else {
	    		$data['domains'] = "";
	    	}
	    	
	    	if (count($socials_array)>0){
	    		$data['socials'] = implode("\n",$socials_array);
	    	}else {
	    		$data['socials'] = "";
	    	}
    	}
    	
    	$userid = $this->session->userdata('userid');
	    $data['campaigns'] =  $this->campaigndata->getallbyuser($userid);
    	$html =  $this->load->view('leads/edit_lead_form',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
    }
    
    public function savelead(){
    	$lead_id = $this->db->escape_str($this->input->post('lead_id'));
    	$lead_campaign = $this->db->escape_str($this->input->post('lead_campaign'));
    	$lead_name = $this->db->escape_str($this->input->post('lead_name'));
    	$lead_email = $this->db->escape_str($this->input->post('lead_email'));
    	$lead_address = $this->db->escape_str($this->input->post('lead_address'));
    	$lead_phone = $this->db->escape_str($this->input->post('lead_phone'));
    	$lead_company = $this->db->escape_str($this->input->post('lead_company'));
    	$lead_notes = $this->db->escape_str($this->input->post('lead_notes'));
		$lead_domains = $this->input->post('lead_domains');
		$lead_socials = $this->input->post('lead_socials');
		$userid = $this->session->userdata('userid');
		$message = 'You successfully updated this lead';
		
		if ($lead_id == ''){
			$lead_id = 0;
			$message = 'You successfully added a new lead';
		}
		
		$lead_array = array('campaign_id'=>$lead_campaign,'name'=>$lead_name,'email'=>$lead_email,'address'=>$lead_address,'phone'=>$lead_phone,'company'=>$lead_company,'notes'=>$lead_notes);
		$lead_id = $this->leadsdata->update($lead_id,$lead_array);
		
		if (is_array($lead_domains)){
			 if (count($lead_domains)>0){
			 	foreach ($lead_domains as $domain){
			 		$expire= "";
			        $registrar = "";
			        $keyword = "";
			        $value = null;
			        if ($this->leadsdomaindata->checkexist('domain',$domain)===false){
			        	$rd_array = array('domain'=>$domain,'member_id'=>$userid,'appraise_value'=>$value,'registrar'=>$registrar,'expire_date'=>$expire,'campaign_id'=>$lead_campaign,'owner'=>$lead_name,'lead_id'=>$lead_id);
						$id = $this->leadsdomaindata->update(0,$rd_array); 
			        }
			 	}
			 }
		}
		
    	if (is_array($lead_socials)){
		   	 if (count($lead_socials)>0){
		   	 	foreach ($lead_socials as $social){
		   	 			if ($this->leadssocialdata->checkexist('lead_id',$lead_id,'social_url',$social)===false){
						   $social_array = array('lead_id'=>$lead_id,'social_name'=>'','social_url'=>$social);
						   $this->leadssocialdata->update(0,$social_array);
						}
		   	 	}
		   	 }
	   	 }
		
		 $this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('status'=>true,'message'=>$message)));		
    }
    
    public function movecampaignform(){
    	$entries = $this->input->post('entries');
    	$userid = $this->session->userdata('userid');
    	$data['campaigns'] =  $this->campaigndata->getallbyuser($userid);
    	$data['entries'] = implode(',',$entries);
		$html =  $this->load->view('leads/move_campaign_form',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
    }
    
    public function savepeoplenewcampaign(){
    	$entries = $this->input->post('entries');
    	$campaign_id = $this->db->escape_str($this->input->post('campaign_id'));
    	
    	$leads = explode(',',$entries);
    	
    	foreach ($leads as $lead_id){
    		$l_array = array('campaign_id'=>$campaign_id);
    		$this->leadsdata->update($lead_id,$l_array);
    	}
    	$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'message'=>'')));
    	
    }
    
    public function deletepeopleconfirm(){
    	$entries = $this->input->post('entries');
    	$data['entries'] = implode(',',$entries);
		$html =  $this->load->view('leads/delete_people_confirm',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
    }
    
    public function deletepeople(){
    	$entries = $this->input->post('entries');
    	$leads = explode(',',$entries);
        foreach ($leads as $lead_id){
        	$this->leadsdomaindata->delete('lead_id',$lead_id);
        	$this->leadssocialdata->delete('lead_id',$lead_id);
    		$this->leadsdata->delete('id',$lead_id);
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
		$html =  $this->load->view('leads/send_email_form',$data,true);
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'html'=>$html)));
    }
    
    public function sendmailpeople(){
    	$entries = $this->input->post('entries');
    	$subject = $this->db->escape_str($this->input->post('subject'));
    	$from_name = $this->db->escape_str($this->input->post('from_name'));
    	$from_email = $this->db->escape_str($this->input->post('from_email'));
    	$message = $this->db->escape_str($this->input->post('message'));
    	$leads = explode(',',$entries);
    	 require $this->config->item('sendgrid_path');
   		foreach ($leads as $lead_id){
        	$to_email = "";
        	$to_name = "";
        	
   			$query = $this->leadsdata->getbyattribute('id',$lead_id);
	   		if ($query->num_rows() > 0){
		        foreach ($query->result() as $row)
		         {
		           $to_email =  $row->email;
		           $to_name =  $row->name;
		         }
	       }
	       
	      
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