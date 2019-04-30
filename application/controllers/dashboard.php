<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('vnocdata');
		$this->load->model('campaigndata');
		$this->load->model('leadsdata');
		$this->load->model('leadssocialdata');
		$this->load->model('leadsdomaindata');
		$this->load->library('domainiqapi');
		$this->load->library('domainplexlib');
	}
	
	private function ValidateDomainName($domainName = null){
			/*if (filter_var(gethostbyname($domainName), FILTER_VALIDATE_IP)) {
      return (preg_match('/^www./', $domainName)) ? FALSE : TRUE;
  }
  return FALSE;*/
		if(!preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domainName)) {
    return false;
    }
return true;
		}
	
		
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	$data['title'] = "Trackers.com - Dashboard";
	    	$data['description'] =  $this->config->item('description');
	    	$data['domain'] =  $this->config->item('domain');
	    	$userid = $this->session->userdata('userid');
			$data['no_tracked'] = $this->vnocdata->GetCountResult('SELECT * FROM `research_domain_owner`');
	    	$data['campaigns'] = $this->campaigndata->getbyattribute('member_id',$userid);
	    	$this->load->view('dashboard/index',$data);
	    }else {
	    	header ("Location: ".base_url());
	    }
	}
	
public function ajaxsearchwebsite(){
		$website = 	trim($this->input->post('domain'));
		$cnt = $this->db->escape_str($this->input->post('cnt'));
		$field = "";
		$message = "";
		$appraise_value="";
		$owner = "";
		$owner_email = "";
		$phone = "";
		$expire = "";
		$registrar = "";
		$html = "";
	    $domain = "";
		$session_id = $_COOKIE['guest_session'];
		
		$status = false;
		
		
		if ($this->ValidateDomainName($website)===true){
		
				$string = 	$website;
				$result = array();
			
			   if (preg_match_all('/\w+\.(com|net|org|biz|tv|co|us|de|ventures|holdings|club|design|website|photography|tips|io|me|ca|asia|eu|ac|academy|co\.uk)/', $string, $matches)){
		           $result = $matches[0];
		        }
	         
	           $result = implode("\n",$result);
	           $domain = $result;
	           
	           if ($this->vnocdata->CheckFieldExists('research_domains','domain',$domain)===true){
	           	  
	           	  $query = $this->vnocdata->GetQueryResult("SELECT `research_domains`.*, `research_domain_owner`.`email`, `research_domain_owner`.`name`,`research_domain_owner`.phone FROM `research_domains` INNER JOIN `research_domain_owner` ON (`research_domain_owner`.`id` = `research_domains`.`owner_id`) WHERE `research_domains`.`domain` = '$domain'");
	           	  $appraise_value= $query->row()->appraise_value;
				  $owner = $query->row()->name;
				  $owner_email =$query->row()->email;
				  $phone = $query->row()->phone;
				  $expire = $query->row()->expire_date;
				  $registrar =$query->row()->registrar;
				  $status = true;
			   }else {
				   	$res = $this->domainiqapi->report($domain);
				
					if (isset($res['whois']['registrant'])){
						$owner = $res['whois']['registrant'];
					}
					
					if (isset($res['whois']['emails'])){
						if (is_array($res['whois']['emails'])){
							$email = implode(',',$res['whois']['emails']);
						}
					}
					
					if (isset($res['whois']['phones'])){
						if (is_array($res['whois']['phones'])){
						  $phone = implode(',',$res['whois']['phones']);
						}else {
							$phone = $res['whois']['phones'];
						}
					}
					
					if (isset($res['whois']['expire_date'])){
						$expire =$res['whois']['expire_date'];
					}
					
					if (isset($res['whois']['registrar'])){
						$registrar = $res['whois']['registrar'];
					}
					
			   		$result = $this->domainplexlib->appraise($domain);
	
				    if (isset($result['appraisal']['sales_history']['sold'][0]['price'])){
					 	$appraise_value = $result['appraisal']['sales_history']['sold'][0]['price'];
					 }
		           	$status = true;
	           }
	           
	      
		}else {
			$message = "Invalid Domain Name";
			$field = 'website';
		}
			$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'message'=>$message,
                             'value'=>$appraise_value,'owner'=>$owner,'email'=>$owner_email,'phone'=>$phone,'expire'=>$expire,
                             'registrar'=>$registrar,'field'=>$field,'html'=>$html,'domain'=>$domain,'cnt'=>$cnt,
                             )));
	}
	
	public function ajaxsearchname(){
		$name = 	$this->db->escape_str($this->input->post('name'));
		$field = "";
		$message = "";
		
		$email = "";
		$address = "";
		$phone = "";
		$company = "";
		$notes = "";
		$socials = "";
		$html = "";
		$domain ="";
	    
		$session_id = $_COOKIE['guest_session'];
		
		$status = false;
		$full_working = true;
		
			
		   	$query = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner` WHERE `name` LIKE '%$name%' LIMIT 1");
           	
            if ($query->num_rows() > 0){
	           	$name= $query->row()->name;
				$email = $query->row()->email;
				$address = $query->row()->address;
				$phone = $query->row()->phone;
				$company = $query->row()->company;
				$notes = $query->row()->notes;
				$owner_id = $query->row()->id;
				
				$squery = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner_socials` WHERE owner_id = '$owner_id'");
				if ($squery->num_rows() > 0){
				 	 foreach ($squery->result() as $row){
				 	 	$socials .= $row->social_name.'=<a href="'.$row->social_url.'" target="_blank">'.$row->social_url.'</a>,<br>';
				 	 }
				}
				
				$status = true;
		  
           	 }else {
	           	 	require $this->config->item('fullcontact_path');
			        $fullcontact = new Services_FullContact_API($this->config->item('fullcontact_key'));
	
			        $data = $this->domainiqapi->reportregistrant($name);
				      if (isset($data['data'])){
					    $iqresult = $data['data'];
					  }
					  if (isset( $iqresult['emails'])){
					  	  if (is_array( $iqresult['emails'])){
					  	  	if (isset($iqresult['emails'][0]['name'])){
					  	  		$email =  $iqresult['emails'][0]['name'];
					  	  	}
					  	  }
					  }
					  
	           	    if ($email != ""){
						  
							$result = $fullcontact->doLookup($email);
							
							if ((isset($result['status'])) && (isset($result['message']))){
					        	if (($result['status']==403) && ($result['message']!='')){
					        		$full_working = false;
					        		$message = $result['message'];
					        	}
	                        }
			
	           	      if ($full_working === true){
					   if (isset($result['contactInfo']['fullName'])){
							$name = $result['contactInfo']['fullName'];
						}
						
						if (isset($result['demographics']['locationGeneral'])){
							$address = $result['demographics']['locationGeneral'];
						}
						
			  			if (isset($result['organizations'][0]['name'])){
							$company = $result['organizations'][0]['name'];
						}
					
						if (isset($result['organizations'][0]['title'])){
							$notes = $result['organizations'][0]['title'];
						}
					
					
					
						  
						  if (isset($iqresult['related_domains'])){
							if (is_array($iqresult['related_domains'])){
								if (isset($iqresult['related_domains'][0]['domain'])){
					  	  	 	 $domain = $iqresult['related_domains'][0]['domain'];
								}
			                    $related_domains = $iqresult['related_domains'];
					  	  	}
			             }
			         
						  
						if ($domain != ""){
						
							$res = $this->domainiqapi->report($domain);
							
							if (isset($res['whois']['phones'])){
								if (is_array($res['whois']['phones'])){
								  $phone = $res['whois']['phones'][0];
								}else {
									$phone = $res['whois']['phones'];
								}
							}
						}
					  	  	
					     if (isset($result['socialProfiles'])){
								    	if (count($result['socialProfiles'])>0){
								    		foreach ($result['socialProfiles'] as $profile){
								    			if ((isset($profile['typeName'])) &&(isset($profile['url']))){
								    				
								    				$socials .= $profile['typeName'].'=<a href="'.$profile['url'].'" target="_blank">'.$profile['url'].'</a>,<br>';
								    				
								    			}
								    		}
								    	}
						}
						
			      
				$status = true;
	         }
	           	    
					  
					  
	           	 }
           	 }
		
		$field = 'name';
			$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'message'=>$message,
                             'name'=>$name,'email'=>$email,'address'=>$address,'phone'=>$phone,'company'=>$company,
                             'notes'=>$notes,'field'=>$field,'socials'=>$socials
                             )));
	}
	
	
public function ajaxsearchemail(){
		$email = 	$this->db->escape_str($this->input->post('email'));
		$field = "";
		$message = "";
		
		$name = "";
		$address = "";
		$phone = "";
		$company = "";
		$notes = "";
		$socials = "";
		$html = "";
		$domain ="";
	    
		$session_id = $_COOKIE['guest_session'];
		
		$status = false;
		$full_working = true;
		
			
		   	$query = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner` WHERE `email` = '$email' LIMIT 1");
           	
            if ($query->num_rows() > 0){
	           	$name= $query->row()->name;
				$email = $query->row()->email;
				$address = $query->row()->address;
				$phone = $query->row()->phone;
				$company = $query->row()->company;
				$notes = $query->row()->notes;
				$owner_id = $query->row()->id;
				
				$squery = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner_socials` WHERE owner_id = '$owner_id'");
				if ($squery->num_rows() > 0){
				 	 foreach ($squery->result() as $row){
				 	 	$socials .= $row->social_name.'=<a href="'.$row->social_url.'" target="_blank">'.$row->social_url.'</a>,<br>';
				 	 }
				}
				
				$status = true;
		  
           	 }else {
	           	 	require $this->config->item('fullcontact_path');
			        $fullcontact = new Services_FullContact_API($this->config->item('fullcontact_key'));
	
	           	 	$data = $this->domainiqapi->reportemail($email);
					if (isset($data['data'])){
					  $iqresult = $data['data'];
					}
					  
	           	    if ($email != ""){
						  
							$result = $fullcontact->doLookup($email);
							
							if ((isset($result['status'])) && (isset($result['message']))){
					        	if (($result['status']==403) && ($result['message']!='')){
					        		$full_working = false;
					        		$message = $result['message'];
					        	}
	                        }
			
	           	      if ($full_working === true){
					   if (isset($result['contactInfo']['fullName'])){
							$name = $result['contactInfo']['fullName'];
						}
						
						if (isset($result['demographics']['locationGeneral'])){
							$address = $result['demographics']['locationGeneral'];
						}
						
			  			if (isset($result['organizations'][0]['name'])){
							$company = $result['organizations'][0]['name'];
						}
					
						if (isset($result['organizations'][0]['title'])){
							$notes = $result['organizations'][0]['title'];
						}
					
					
					
						  
						  if (isset($iqresult['related_domains'])){
							if (is_array($iqresult['related_domains'])){
								if (isset($iqresult['related_domains'][0]['domain'])){
					  	  	 	 $domain = $iqresult['related_domains'][0]['domain'];
								}
			                    $related_domains = $iqresult['related_domains'];
					  	  	}
			             }
			         
						  
						if ($domain != ""){
						
							$res = $this->domainiqapi->report($domain);
							
							if (isset($res['whois']['phones'])){
								if (is_array($res['whois']['phones'])){
								  $phone = $res['whois']['phones'][0];
								}else {
									$phone = $res['whois']['phones'];
								}
							}
						}
					  	  	
					     if (isset($result['socialProfiles'])){
								    	if (count($result['socialProfiles'])>0){
								    		foreach ($result['socialProfiles'] as $profile){
								    			if ((isset($profile['typeName'])) &&(isset($profile['url']))){
								    				
								    				$socials .= $profile['typeName'].'=<a href="'.$profile['url'].'" target="_blank">'.$profile['url'].'</a>,<br>';
								    				
								    			}
								    		}
								    	}
						}
						
			      
				$status = true;
	         }
	           	    
					  
					  
	           	 }
           	 }
		
		$field = 'email';
			$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'message'=>$message,
                             'name'=>$name,'email'=>$email,'address'=>$address,'phone'=>$phone,'company'=>$company,
                             'notes'=>$notes,'field'=>$field,'socials'=>$socials
                             )));
	}
	
public function ajaxsearchsocial(){
		$social = 	$this->db->escape_str($this->input->post('social'));
		$field = "";
		$message = "";
		$email = "";
		$name = "";
		$address = "";
		$phone = "";
		$company = "";
		$notes = "";
		$socials = "";
		$html = "";
		$domain ="";
	    
		$session_id = $_COOKIE['guest_session'];
		
		$status = false;
		$full_working = true;
		
		  	$query = $this->vnocdata->GetQueryResult("SELECT `research_domain_owner`.* FROM `research_domain_owner_socials` INNER JOIN `research_domain_owner` ON (`research_domain_owner`.`id` = `research_domain_owner_socials`.`owner_id`) WHERE social_url = '$social' LIMIT 1");
           	if ($query->num_rows() > 0){
	           	$name= $query->row()->name;
				$email = $query->row()->email;
				$address = $query->row()->address;
				$phone = $query->row()->phone;
				$company = $query->row()->company;
				$notes = $query->row()->notes;
				$owner_id = $query->row()->id;
				
				$squery = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner_socials` WHERE owner_id = '$owner_id'");
				if ($squery->num_rows() > 0){
				 	 foreach ($squery->result() as $row){
				 	 	$socials .= $row->social_name.'=<a href="'.$row->social_url.'" target="_blank">'.$row->social_url.'</a>,<br>';
				 	 }
				}
				
				$status = true;
		  
           	 }else {
	           	 	require $this->config->item('fullcontact_path');
			        $fullcontact = new Services_FullContact_API($this->config->item('fullcontact_key'));
	
	           	 	$pos = strpos($social, 'twitter.com');
	           	 	
		           	if ($pos === false) {
					    
					} else {
						    $pieces = explode("twitter.com/", $social);
						    if (isset($pieces[1])){
								$rex = $fullcontact->doLookup($pieces[1],'twitter');
					
								$fresult = array();
							    $this->displayArrayRecursively($rex, null,$fresult);
							    if (count($fresult)>0){
							    	if (isset($fresult[0])){
							    		$email = $fresult[0];
							    	}
							    }
						    }
					}
					
					
					  
	           	    if ($email != ""){
						  
							$result = $fullcontact->doLookup($email);
							
							if ((isset($result['status'])) && (isset($result['message']))){
					        	if (($result['status']==403) && ($result['message']!='')){
					        		$full_working = false;
					        		$message = $result['message'];
					        	}
	                        }
			
	           	      if ($full_working === true){
					   if (isset($result['contactInfo']['fullName'])){
							$name = $result['contactInfo']['fullName'];
						}
						
						if (isset($result['demographics']['locationGeneral'])){
							$address = $result['demographics']['locationGeneral'];
						}
						
			  			if (isset($result['organizations'][0]['name'])){
							$company = $result['organizations'][0]['name'];
						}
					
						if (isset($result['organizations'][0]['title'])){
							$notes = $result['organizations'][0]['title'];
						}
					
					
					
						  
						  if (isset($iqresult['related_domains'])){
							if (is_array($iqresult['related_domains'])){
								if (isset($iqresult['related_domains'][0]['domain'])){
					  	  	 	 $domain = $iqresult['related_domains'][0]['domain'];
								}
			                    $related_domains = $iqresult['related_domains'];
					  	  	}
			             }
			         
						  
						if ($domain != ""){
						
							$res = $this->domainiqapi->report($domain);
							
							if (isset($res['whois']['phones'])){
								if (is_array($res['whois']['phones'])){
								  $phone = $res['whois']['phones'][0];
								}else {
									$phone = $res['whois']['phones'];
								}
							}
						}
					  	  	
					     if (isset($result['socialProfiles'])){
								    	if (count($result['socialProfiles'])>0){
								    		foreach ($result['socialProfiles'] as $profile){
								    			if ((isset($profile['typeName'])) &&(isset($profile['url']))){
								    				
								    				$socials .= $profile['typeName'].'=<a href="'.$profile['url'].'" target="_blank">'.$profile['url'].'</a>,<br>';
								    				
								    			}
								    		}
								    	}
						}
						
			      
				$status = true;
	         }
	           	    
					  
					  
	           	 }
           	 }
		
		$field = 'social';
			$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'message'=>$message,
                             'name'=>$name,'email'=>$email,'address'=>$address,'phone'=>$phone,'company'=>$company,
                             'notes'=>$notes,'field'=>$field,'socials'=>$socials
                             )));
	}
	
	public function refreshcampaigns(){
		$userid = $this->session->userdata('userid');
		$data['campaigns'] = $this->campaigndata->getbyattribute('member_id',$userid);
	    $html = $this->load->view('dashboard/select_campaigns',$data,true);
	    
	   $this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('html'=>$html
                             ))); 
	}
	
private function displayArrayRecursively($array, $keysString = '',&$fresult)
{
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $this->displayArrayRecursively($value, $keysString . $key . '.',$fresult);
        }
    } else {
    	$string = $array;
		$pattern	=	"/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
		 
		preg_match_all($pattern, $string, $matches);
		 
		foreach($matches[0] as $email){
			$fresult[] = $email;
		}
		
	  }
}
	
	public function savewebsitesearch(){
			$entries = $this->db->escape_str($this->input->post('entries'));
			$campaign_id = $this->db->escape_str($this->input->post('campaign_id'));
			$campaign_name = $this->db->escape_str($this->input->post('campaign_name'));
			$option = $this->db->escape_str($this->input->post('option'));
			
			$userid = $this->session->userdata('userid');
			$status = false;
			$msg = '';
			
			if ($option == 'create'){
				$carray = array('member_id'=>$userid,'campaign_name'=>$campaign_name);
				$campaign_id = $this->campaigndata->update(0,$carray);
			}
			
			$count = count($entries);
			$number = 0;
			if (count($entries)>0){
					foreach ($entries as $entry){
						$domain = "";
						$value ="";
						$owner = "";
						$owner_email = "";
						$phone = "";
						$expire = "";
						$registrar = "";
						$company = "";
						$notes = "";
						
						if (isset($entry['domain'])){
							$domain = $entry['domain'];
						}
						
						if (isset($entry['value'])){
							$value = $entry['value'];
						}
						
						if (isset($entry['owner'])){
							$owner = $entry['owner'];
						}
						
						if (isset($entry['email'])){
							$owner_email = $entry['email'];
						}
						
						if (isset($entry['phone'])){
							$phone = $entry['phone'];
						}
						
						if (isset($entry['expire'])){
							$expire = $entry['expire'];
						}
						
						if (isset($entry['registrar'])){
							$registrar = $entry['registrar'];
						}
						
						$owner_id = $this->leadsdata->getinfo('id','email',$owner_email);
						if ($owner_id == ''){
							$owner_id = 0;
						}
						
						if ($owner_email != ''){
							$query = $this->vnocdata->GetQueryResult("Select * from research_domain_owner where email='$owner_email'");
							
							if ($query->num_rows() > 0){
								foreach ($query->result() as $row)
								 {
								   $company =  $row->company;
								   $notes =  $row->notes;
								 }
							 }else {
							 	
							 		$result = $fullcontact->doLookup($owner_email);
								 	if (isset($result['organizations'][0]['name'])){
										$company = $result['organizations'][0]['name'];
									}
						
									if (isset($result['organizations'][0]['title'])){
										$notes = $result['organizations'][0]['title'];
									}
							 }
						}
						
						$owner_array = array('name'=>$owner,'email'=>$owner_email,'campaign_id'=>$campaign_id,'company'=>$company,'notes'=>$notes,'phone'=>$phone,'member_id'=>$userid);
						$this->leadsdata->update($owner_id,$owner_array);
						
						$number++;
					}
			}
			
		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'count'=>$count,'number'=>$number,'message'=>''
                             )));	
	}
	
	
	public function ajaxsearchpeople(){
		$val = $this->db->escape_str($this->input->post('val'));
  		$by = $this->db->escape_str($this->input->post('by'));
		$cnt = $this->db->escape_str($this->input->post('cnt'));
		
		$name = "";
		$email = "";
		$address = "";
		$phone = "";
		$socials = "";
		$domains = "";
		$domain = "";
		$company = "";
		$notes = "";
		
        $related_domains = array();
		$msg = "";
		$status = false;
		$full_working = true;
		$iqresult = array();
		
		
		$in_db = false;
		$has_error = false;
		
		
		switch ($by){
			case 'name':
				$name = $val;
					$data = $this->domainiqapi->reportregistrant($name);
					if (isset($data['data'])){
				    	$iqresult = $data['data'];
				  	}
				$query = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner` WHERE `name` LIKE '%$name%' LIMIT 1");
				if ($query->num_rows() > 0){
						$name= $query->row()->name;
						$email = $query->row()->email;
						$address = $query->row()->address;
						$phone = $query->row()->phone;
						$company = $query->row()->company;
						$notes = $query->row()->notes;
				 		$owner_id = $query->row()->id;
				 		
						$squery = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner_socials` WHERE owner_id = '$owner_id'");
						if ($squery->num_rows() > 0){
						 	 foreach ($squery->result() as $row){
						 	 	if (($row->social_name == '') || ($row->social_name == null)){
							 	 		$parse = parse_url($row->social_url);
                                        $social_name =  explode('.',$parse['host']);
                                        $social_name = ucfirst($social_name[0]); 
							 	 	}else {
							 	 		$social_name = $row->social_name;
							 	 }
						 	 	$socials .= $social_name.'=<a href="'.$row->social_url.'" target="_blank">'.$row->social_url.'</a>,<br>';
						 	 }
						}
				   $in_db = true;		
				   $status = true;
				}else {
					if (isset( $iqresult['emails'])){
					  	  if (is_array( $iqresult['emails'])){
					  	  	if (isset($iqresult['emails'][0]['name'])){
					  	  		$email =  $iqresult['emails'][0]['name'];
					  	  	}
					  	  }
					 }
				}
				
					
				
			break;
			
			case 'email':
				$email = $val;
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				    $msg = "Invalid email format"; 
				    $has_error = true;
                 }else {
                    $data = $this->domainiqapi->reportemail($email);
					if (isset($data['data'])){
					  $iqresult = $data['data'];
					}
					
	                 $query = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner` WHERE `email` LIKE '%$email%' LIMIT 1");
					 if ($query->num_rows() > 0){
							$name= $query->row()->name;
							$email = $query->row()->email;
							$address = $query->row()->address;
							$phone = $query->row()->phone;
							$company = $query->row()->company;
							$notes = $query->row()->notes;
					 		$owner_id = $query->row()->id;
					 		
							$squery = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner_socials` WHERE owner_id = '$owner_id'");
							if ($squery->num_rows() > 0){
							 	 foreach ($squery->result() as $row){
							 	 	if (($row->social_name == '') || ($row->social_name == null)){
							 	 		$parse = parse_url($row->social_url);
                                        $social_name =  explode('.',$parse['host']);
                                        $social_name = ucfirst($social_name[0]); 
							 	 	}else {
							 	 		$social_name = $row->social_name;
							 	 	}
							 	 	$socials .= $social_name.'=<a href="'.$row->social_url.'" target="_blank">'.$row->social_url.'</a>,<br>';
							 	 }
							}
						   $in_db = true;		
						   $status = true;
						}
					
                 }
			break;
			
			case 'twitter':
				$twitter_username = $val;
				
				$query =  $this->vnocdata->GetQueryResult("SELECT `research_domain_owner`.* FROM `research_domain_owner` INNER JOIN `research_domain_owner_socials` ON (`research_domain_owner_socials`.`owner_id` = `research_domain_owner`.`id`) WHERE `social_url` LIKE 'https://twitter.com/$twitter_username' LIMIT 1");;
		 		if ($query->num_rows() > 0){
							$name= $query->row()->name;
							$email = $query->row()->email;
							$address = $query->row()->address;
							$phone = $query->row()->phone;
							$company = $query->row()->company;
							$notes = $query->row()->notes;
					 		$owner_id = $query->row()->id;
					 		
							$squery = $this->vnocdata->GetQueryResult("SELECT * FROM `research_domain_owner_socials` WHERE owner_id = '$owner_id'");
							if ($squery->num_rows() > 0){
							 	 foreach ($squery->result() as $row){
							 	 	if (($row->social_name == '') || ($row->social_name == null)){
							 	 		$parse = parse_url($row->social_url);
                                        $social_name =  explode('.',$parse['host']);
                                        $social_name = ucfirst($social_name[0]); 
							 	 	}else {
							 	 		$social_name = $row->social_name;
							 	 	}
							 	 	$socials .= $social_name.'=<a href="'.$row->social_url.'" target="_blank">'.$row->social_url.'</a>,<br>';
							 	 }
							}
						   $in_db = true;		
						   $status = true;
				}else {
						$rex = $fullcontact->doLookup($val,'twitter');
						
						$fresult = array();
				        $this->displayArrayRecursively($rex, null,$fresult);
					    if (count($fresult)>0){
					    	if (isset($fresult[0])){
					    		$email = $fresult[0];
					    	}
					    }
				}
		 		
				if ($email != ''){
					$data = $this->domainiqapi->reportemail($email);
						if (isset($data['data'])){
						  $iqresult = $data['data'];
					}
				}
				
			break;			
		}
		
		
		if (!$has_error){
		
			if (isset($iqresult['total_count'])){
						       $domains =  $iqresult['total_count'];
			}
						
						  
			if (isset($iqresult['related_domains'])){
								if (is_array($iqresult['related_domains'])){
									if (isset($iqresult['related_domains'][0]['domain'])){
						  	  	 	 $domain = $iqresult['related_domains'][0]['domain'];
									}
				                    $related_domains = $iqresult['related_domains'];
						  	  	}
				             }
				         
			
			if ($in_db === false){
				require $this->config->item('fullcontact_path');
				$fullcontact = new Services_FullContact_API($this->config->item('fullcontact_key'));
			
				if ($email != ''){
					$result = $fullcontact->doLookup($email);
				}
				
				if ((isset($result['status'])) && (isset($result['message']))){
		        	if (($result['status']==403) && ($result['message']!='')){
		        		$full_working = false;
		        		$msg = $result['message'];
		        	}
		        }
		        
			          	      if ($full_working === true){
						   if (isset($result['contactInfo']['fullName'])){
								$name = $result['contactInfo']['fullName'];
							}
							
							if (isset($result['demographics']['locationGeneral'])){
								$address = $result['demographics']['locationGeneral'];
							}
							
				  			if (isset($result['organizations'][0]['name'])){
								$company = $result['organizations'][0]['name'];
							}
						
							if (isset($result['organizations'][0]['title'])){
								$notes = $result['organizations'][0]['title'];
							}
						
						
						
							  
							  
							  
							if ($domain != ""){
							
								$res = $this->domainiqapi->report($domain);
								
								if (isset($res['whois']['phones'])){
									if (is_array($res['whois']['phones'])){
									  $phone = $res['whois']['phones'][0];
									}else {
										$phone = $res['whois']['phones'];
									}
								}
							}
						  	  	
						     if (isset($result['socialProfiles'])){
									    	if (count($result['socialProfiles'])>0){
									    		foreach ($result['socialProfiles'] as $profile){
									    			if ((isset($profile['typeName'])) &&(isset($profile['url']))){
									    				
									    				$socials .= $profile['typeName'].'=<a href="'.$profile['url'].'" target="_blank">'.$profile['url'].'</a>,<br>';
									    				
									    			}
									    		}
									    	}
							}
							
				      
					$status = true;
		         }
		        
			}
			
				if(count($related_domains)>0){
			      	  $newrel = array();
			      	  foreach ($related_domains as $d){
			      	  	$newrel[] = $d['domain'];
			      	  }
			          $related_domains = implode(',',$newrel);
			      }else {
			          $related_domains = "";
			      }
			      
			      $this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'msg'=>$msg,'cnt'=>$cnt,
                             'name'=>$name,'email'=>$email,'address'=>$address,'phone'=>$phone,'socials'=>$socials,'domains'=>$domains,'related_domains'=>$related_domains,'company'=>$company,'notes'=>$notes
                             )));
		
		}else {
			$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'msg'=>$msg,'cnt'=>$cnt
                             )));
		}     
		
	}
	
	public function getrdomains(){
        $domains = $this->db->escape_str($this->input->post('domains'));
        $cnt = $this->db->escape_str($this->input->post('cnt'));
        $owner_name = $this->db->escape_str($this->input->post('owner_name'));
        $data['domains'] = explode(',',$domains);
        $data['owner_name'] = $owner_name;
        $data['count'] = $cnt;
        $html =  $this->load->view('dashboard/r_domains',$data,true);
	     	$this->output
		->set_content_type('application/json')
		->set_output(json_encode(array('status'=>true,'html'=>$html)));
  }
  
  public function savepeople(){
 		$entries = $this->db->escape_str($this->input->post('entries'));
		$campaign_id = $this->db->escape_str($this->input->post('campaign_id'));
		$campaign_name = $this->db->escape_str($this->input->post('campaign_name'));
		$option = $this->db->escape_str($this->input->post('option'));
		$by = $this->db->escape_str($this->input->post('by'));
			
		$userid = $this->session->userdata('userid');
		$status = false;
		$msg = '';
			
		if ($option == 'create'){
			$carray = array('member_id'=>$userid,'campaign_name'=>$campaign_name);
			$campaign_id = $this->campaigndata->update(0,$carray);
		}
		
		$count = count($entries);
		$number = 0;
		 $scount = 0;
		
		if (count($entries)>0){
			foreach ($entries as $entry){
				$name = "";
				$email = "";
				$address = "";
				$phone = "";
				$company = "";
				$notes = "";
				$socials = "";
				$domains = "";
				$owner_id = 0;
				
				if (isset($entry['name'])){
					$name = $entry['name'];
				}
				
				if (isset($entry['email'])){
					$email = $entry['email'];
				}
				
				if (isset($entry['address'])){
					$address = $entry['address'];
				}
				
				if (isset($entry['phone'])){
					$phone = $entry['phone'];
				}
				
				if (isset($entry['company'])){
					$company = $entry['company'];
				}
				
				if (isset($entry['notes'])){
					$notes = $entry['notes'];
				}
				
				if (isset($entry['socials'])){
					$socials = $entry['socials'];
				}		
				
				if (isset($entry['domains'])){
					$domains = $entry['domains'];
				}	
				
				switch ($by){
					case 'name':
						if ($this->leadsdata->checkexist('name',$name,'member_id',$userid)===true){
							$query =  $this->leadsdata->getbyattribute('name',$name,'member_id',$userid);
							$owner_id = $query->row()->id;
						}
					break;
					case 'email':
						if ($this->leadsdata->checkexist('email',$email,'member_id',$userid)===true){
							$query =  $this->leadsdata->getbyattribute('email',$email,'member_id',$userid);
							$owner_id = $query->row()->id;
						}
					break;	
					case 'social':
						$twitter_url = $entry['twitter'];
						$sql = "SELECT `tracker_leads`.* FROM `tracker_leads` INNER JOIN `tracker_leads_socials` ON (`tracker_leads_socials`.`lead_id` = `tracker_leads`.`id`) WHERE social_url = '$twitter_url'";
						$query = $this->db->query($sql);
						if ($query->num_rows() > 0){
					        foreach ($query->result() as $row)
					         {
					           $owner_id =  $row->id;
					         }
			            }
						
						
					break;
				}
				
				
				$owner_array = array('name'=>$name,'email'=>$email,'phone'=>$phone,'address'=>$address,'campaign_id'=>$campaign_id,'company'=>$company,'notes'=>$notes,'member_id'=>$userid);
				$lead_id = $this->leadsdata->update($owner_id,$owner_array);
						
				
				if ($socials != ''){
								$socials = str_replace('<br>','',$socials);
								$socials = explode(',',$socials);
								if (count($socials)>0){
									foreach ($socials as $social){
										$profile = explode("=",$social);
										if (isset($profile[0])){
											
											$social_name = $profile[0]; 
											
											if ($social_name != ""){
												$matches = array();
												preg_match_all('/<a .*?>(.*?)<\/a>/',$social,$matches);
												if (isset($matches[1][0])){
													    $social_url = $matches[1][0];
														if ($this->leadssocialdata->checkexist('lead_id',$lead_id,'social_name',$social_name)===false){
															$social_array = array('lead_id'=>$lead_id,'social_name'=>$social_name,'social_url'=>$social_url);
															$this->leadssocialdata->update(0,$social_array);
														}
													}
												}
											}
										}
									}
								
					}
					
					
					if ($domains != ''){
								$darray = explode(',',$domains);
								if (count($darray)>0){
									foreach ($darray as $domain){
										$expire="";
										$registrar =null;
										$value = null;
										$domain = strtolower(trim($domain));
										
										
										$rd_array = array('domain'=>$domain,'member_id'=>$userid,'appraise_value'=>$value,'registrar'=>$registrar,'expire_date'=>$expire,'campaign_id'=>$campaign_id,'owner'=>$name,'lead_id'=>$lead_id);
										if ($this->leadsdomaindata->checkexist('domain',$domain,'member_id',$userid)===false){
											$id = $this->leadsdomaindata->update(0,$rd_array); 

										}else {
											$id = $this->leadsdomaindata->getinfo('id','domain',$domain,'member_id',$userid);
											$this->leadsdomaindata->update($id,$rd_array); 
										}
								

									}
								}
					} 
				
				   $number++;
			}
		}

		$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>true,'count'=>$count,'number'=>$number,'message'=>''
                             )));
  }
}