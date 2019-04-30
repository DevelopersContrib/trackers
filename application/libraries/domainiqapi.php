<?php 
class DomainIqApi
{
	private $api_url = "http://www.domainiq.com/api";
	private $user = 'chad@ecorp.com';
	private $password = 'School30';
	private $key = '2s4yi75fdcedlq96e4l04tozh44ley2m';
	
    public static function createApiCall($url, $method, $headers, $data = array(),$user=null,$pass=null)
    {
        if ($method == 'PUT')
        {
            $headers[] = 'X-HTTP-Method-Override: PUT';
        }

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        if ($user){
         curl_setopt($handle, CURLOPT_USERPWD, $user.':'.$pass);
        } 

        switch($method)
        {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'PUT':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'DELETE':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $response = curl_exec($handle);
        return $response;
    }
    
   public function getkeywords($domain){
		$headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?a=get&email=".$this->user."&password=".$this->password."&c=appraise&t=$domain";
		$result = $this->createApiCall($url, 'GET', $headers);
		$xml = simplexml_load_string($result);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		$res = $array['appraisal'];
		if (isset($res['words'])){
		  return $res['words'];	
		}else {
			return "";
		}
  }
  
  public function researchdomain($domain){
  	$headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?a=get&email=".$this->user."&password=".$this->password."&c=appraise&t=$domain";
		$result = $this->createApiCall($url, 'GET', $headers);
		$xml = simplexml_load_string($result);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		return $array;
  }
    
  
  public function report($domain){          
  	$headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?key=".$this->key.'&service=domain_report&domain='.$domain.'&output_mode=json';
		$result = @file_get_contents($url);//$this->createApiCall($url, 'GET', $headers); 
		
	  $array = json_decode($result,TRUE);
	  if (isset($array['data'])){
     
    }else {
        $array['data'] = array();
    }
     return $array['data'];
  }
  
 public function reportemail($email){ 
  	$headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?key=".$this->key.'&service=email_report&email='.$email.'&output_mode=json';
		$result = @file_get_contents($url);//$this->createApiCall($url, 'GET', $headers);
		$array = json_decode($result,TRUE);
		return $array;
  }
  
  
  public function reportregistrant($name){
  	$headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?key=".$this->key.'&service=name_report&name='.urlencode($name).'&output_mode=json';
		$result = @file_get_contents($url);
		$array = json_decode($result,TRUE);
		return $array;
  }
  
  public function domainwhois($domain){
  	  	$headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?key=".$this->key.'&service=bulk_dns&domains='.$domain.'&output_mode=json';
		$result = @file_get_contents($url);
		$result = explode(',',$result);
		if ((isset($result[3])) && (isset($result[4]))){
			if (strlen($result[3])>5){
		        $result = array('dns_1'=>str_replace('"','', $result[3]),'dns_2'=>str_replace('"','', $result[4]));
			}else {
				$result = array('dns_1'=>'','dns_2'=>'');
			}	
		}else {
		  $result = array('dns_1'=>'','dns_2'=>'');
		} 
		
		return $result;
  }
  
  public function getmonitors(){
  	  $headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?key=".$this->key.'&service=monitor&action=list&output_mode=json';
		$result = @file_get_contents($url);
		$array = json_decode($result,TRUE);
		return $array;
  }
  
  public function getmonitorlist($report){
  	   $headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?key=".$this->key.'&service=monitor&action=report_items&report='.$report.'&output_mode=json';
		$result = @file_get_contents($url);
		$array = json_decode($result,TRUE);
		return $array;
  }
  
  public function getmonitorsummary($report){
  	  $headers = array(
		        'Accept: application/json'
		    );
		    
		$url = $this->api_url."?key=".$this->key.'&service=monitor&action=report_summary&report='.$report.'&output_mode=json';
		$result = @file_get_contents($url);
		$array = json_decode($result,TRUE);
		return $array;
  }
  
  
  
    
}
?>