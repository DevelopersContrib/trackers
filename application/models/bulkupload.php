<?php
class Bulkupload extends CI_Model {

private function CustomImplode($parts = null, $delimiter = "," ){
			$returnValue = "";
			foreach($parts as $key=>$value){
				if(strpos($value, ","))
					$parts[$key] = sprintf("\"%s\"", $value);
				else
					$parts[$key] = $value;
			}
			$returnValue = implode(",", $parts);
			return $returnValue;
		}
		
function str_getcsv($input, $delimiter=',', $enclosure='"', $escape=null, $eol=null) {
  $temp=fopen("php://memory", "rw");
  fwrite($temp, $input);
  fseek($temp, 0);
  $r = array();
  while (($data = fgetcsv($temp, 4096, $delimiter, $enclosure)) !== false) {
    $r[] = $data;
  }
  fclose($temp);
  return $r;
}

function ProcessRowResearch($line=null,$campaign_id){
    $returnValue = false;
    $exist = false;
    if (!empty($line)){
     $Data = $this->str_getcsv($line); //parse the rows
     foreach($Data as &$d){
     
     $name = trim($this->db->escape_str($d[0]));
     $email = trim($this->db->escape_str($d[1]));
     $socials = trim($this->db->escape_str($d[3]));
     $company = trim($this->db->escape_str($d[2]));
     $domain = "";
     if (isset($d[4])){
      $domain = trim($this->db->escape_str($d[4]));
     }
     
     $no_of_domains = 0;
     if ($domain != ''){
      $no_of_domains = 1;
     }
     
    }  
    
    if ($name != ""){
    	$owner_array = array('name'=>$name,'email'=>$email,'campaign_id'=>$campaign_id,'company'=>$company);
    	if ($email != ""){
    		if ($this->leadsdata->checkexist('email',$email)===false){
				$owner_id = $this->leadsdata->update(0,$owner_array);
				$returnValue = true;
			}else {
				$exist = true;
			}
    	}else {
	    	if ($this->leadsdata->checkexist('name',$name)===false){
				$owner_id = $this->leadsdata->update(0,$owner_array);
				 $returnValue = true;
			}else {
				$exist = true;
			}
    	}
    	
    	if ($exist){
    		if ($email != ""){
    			$owner_id = $this->leadsdata->getinfo('id','email',$email);
    		}else {
    			$owner_id = $this->leadsdata->getinfo('id','name',$name);
    		}
    		
    		$owner_id = $this->leadsdata->update($owner_id,$owner_array);
    		$returnValue = true;
    	}
    	
    	if ($returnValue){
    		if ($socials != ""){
    			$this->leadssocialdata->delete('lead_id',$owner_id);
    			$urls = explode(',',$socials);
    			foreach ($urls as $url){
    				$url = trim($url);
	    			$social_array = array('lead_id'=>$owner_id,'social_url'=>$url);
					$this->leadssocialdata->update(0,$social_array);
    			}
    		}
        
        if ($domain != ""){
        
                     $domain = strtolower(trim($domain));
                     $domain = str_replace('https://','',$domain);
                     $domain = str_replace('http://','',$domain);
                     $domain = str_replace('www.','',$domain);
                    
                     $userid = $this->session->userdata('userid');
            
					 $rd_array = array('domain'=>$domain,'member_id'=>$userid,'appraise_value'=>null,'registrar'=>null,'expire_date'=>null,'campaign_id'=>$campaign_id,'owner'=>$name,'lead_id'=>$owner_id);
					
					if ($this->leadsdomaindata->checkexist('domain',$domain)===false){
						$id = $this->leadsdomaindata->update(0,$rd_array); 
						
					}else {
						$id = $this->leadsdomaindata->getinfo('id','domain',$domain);
						$this->leadsdomaindata->update($id,$rd_array); 
					}
					
           }
        
    	}
	}
     
   
    } 
    return array('status'=>$returnValue,'name'=>$name);
}

function ProcessResearchCSV($filename=null,$campaign_id){
   	  $returnValue = false;
			if(!empty($filename)){
				$lineNumber = 0;
				$successful = 0;
				$error = array();
				$fh = fopen($filename, 'r');
				while (($line = fgetcsv($fh, 3000, ',')) !== FALSE) {
					
						
					       $processingResult = $this->ProcessRowResearch($this->CustomImplode($line),$campaign_id);
               
							if($processingResult['status'] === FALSE){
								array_push($error, array("Record"=>$lineNumber, "Error"=>"Name exists ".$processingResult['name']));
							}
							else
							{
								$successful++;
							}
						
					
					$lineNumber ++;
				}
				fclose($fh);
			}
			if ($lineNumber>0){
			$returnValue["Successful"] = $successful;
			$returnValue["Items"] = $lineNumber;
			$returnValue["Errors"] = $error;
			
		 }else {
		  	array_push($error, array("Record"=>0, "Error"=>"Empty Lines"));
            $returnValue["Successful"] = 0;
			$returnValue["Items"] = 0;
			$returnValue["Errors"] = $error;
     	}
		   return $returnValue;
    
   }

}