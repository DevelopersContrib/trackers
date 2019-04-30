<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

   function __construct()
	{
		parent::__construct();
		$this->load->model('membersdata');
		$this->load->model('guestsearchdata');
		$this->load->model('vnocdata');
		$this->load->helper('cookie');
		$this->load->library('domainiqapi');
		$this->load->library('domainplexlib');
		
	}
	
 private function ValidateDomainName($domainName = null){
			if (filter_var(gethostbyname($domainName), FILTER_VALIDATE_IP)) {
      return (preg_match('/^www./', $domainName)) ? FALSE : TRUE;
  }
  return FALSE;
		}
	
	public function index()
	{
		if ($this->session->userdata('logged_in')){
	    	header ("Location: ".base_url()."dashboard");
	    }else {
	    	$data['title'] = $this->config->item('title');
	    	$data['description'] =  $this->config->item('description');
	    	$data['no_tracked'] = $this->vnocdata->GetCountResult('SELECT * FROM `research_domain_owner`');
	    	if(empty($_COOKIE['guest_session'])) {
		    	$cookie_name = "guest_session";
		    	if(!empty($_COOKIE['ci_session'])) {
			    	$string = $_COOKIE['ci_session'];
					$part = explode('s:32:"',$string);
						if (isset($part[1])){
						    $part2 = explode('";s:10:',$part[1]);
						    if (isset($part2[0])){
						    	$cookie_value = $part2[0];
						        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
						    }
						} 
		    	}
	    	}
		    $this->load->view('home/index',$data);
	    }
	}
	
	public function ajaxsearchwebsite(){
		$website = 	$this->input->post('website');
		$user_ip = $this->db->escape_str($this->input->post('user_ip'));
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
		
			if ($this->guestsearchdata->getcountbyattribute('ip_address',$user_ip,'session_id',$session_id) < $this->config->item('search_limit')){
				$data = array('ip_address'=>$user_ip,'session_id'=>$session_id);
				$this->guestsearchdata->update(0,$data);
				
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
				$message = "You already exceeded search limit.";
				$field = 'website';
			}
			
		}else {
			$message = "Invalid Domain Name";
			$field = 'website';
		}
			$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'message'=>$message,
                             'value'=>$appraise_value,'owner'=>$owner,'email'=>$owner_email,'phone'=>$phone,'expire'=>$expire,
                             'registrar'=>$registrar,'field'=>$field,'html'=>$html,'domain'=>$domain
                             )));
	}
	
	public function ajaxsearchname(){
		$name = 	$this->db->escape_str($this->input->post('name'));
		$user_ip = $this->db->escape_str($this->input->post('user_ip'));
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
		
		if ($this->guestsearchdata->getcountbyattribute('ip_address',$user_ip,'session_id',$session_id) < $this->config->item('search_limit')){
			$data = array('ip_address'=>$user_ip,'session_id'=>$session_id);
			$this->guestsearchdata->update(0,$data);
			
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
			        }else {
			            if (isset( $iqresult['summary_reg_email'])){
			                if (is_array( $iqresult['summary_reg_email'])){
			                    if (isset($iqresult['summary_reg_email'][0]['item'])){
			                        $email =  $iqresult['summary_reg_email'][0]['item'];
			                    }
			                }
			            }
			        }
			        
			        
			        if ($email != ""){
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
			                
			                $result = $fullcontact->doLookup($email);
			                if ((isset($result['status'])) && (isset($result['message']))){
			                    if (($result['status']==403) && ($result['message']!='')){
			                        $full_working = false;
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
		}else {
			$message = "You already exceeded search limit.";
			
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
		$user_ip = $this->db->escape_str($this->input->post('user_ip'));
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
		
		if ($this->guestsearchdata->getcountbyattribute('ip_address',$user_ip,'session_id',$session_id) < $this->config->item('search_limit')){
			$data = array('ip_address'=>$user_ip,'session_id'=>$session_id);
			$this->guestsearchdata->update(0,$data);
			
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
	
			        $result = $fullcontact->doLookup($email);
			        if ((isset($result['status'])) && (isset($result['message']))){
			            if (($result['status']==403) && ($result['message']!='')){
			                $full_working = false;
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
		}else {
			$message = "You already exceeded search limit.";
			
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
		$user_ip = $this->db->escape_str($this->input->post('user_ip'));
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
		
		if ($this->guestsearchdata->getcountbyattribute('ip_address',$user_ip,'session_id',$session_id) < $this->config->item('search_limit')){
			$data = array('ip_address'=>$user_ip,'session_id'=>$session_id);
			$this->guestsearchdata->update(0,$data);
			
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
		}else {
			$message = "You already exceeded search limit.";
			
		}
		$field = 'social';
			$this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status'=>$status,'message'=>$message,
                             'name'=>$name,'email'=>$email,'address'=>$address,'phone'=>$phone,'company'=>$company,
                             'notes'=>$notes,'field'=>$field,'socials'=>$socials
                             )));
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */