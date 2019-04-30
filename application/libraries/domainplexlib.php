<?php 
class DomainPlexLib
{
	
	private $user = 'ECORP';
	private $pw = 'CGYX96KRBN';
	private $api_url = 'http://api.domainplex.com/';
	
	
	
	private function createApiCall($url, $method, $headers, $data = array(),$user=null,$pass=null)
{
        if (($method == 'PUT') || ($method=='DELETE'))
        {
            $headers[] = 'X-HTTP-Method-Override: '.$method;
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

  public function appraise($domain){
  	$headers = array(
	        'Accept: application/json'
	    );
	    
  	$url = $this->api_url."?a=get&u=".$this->user."&p=".$this->pw."&d=appraise&t=".$domain."&xml_standard=1";
	$result = $this->createApiCall($url, 'GET', $headers);
	$xml = @simplexml_load_string($result);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	return $array;
	
  }
  
  public function whois($domain){
  	$headers = array(
	        'Accept: application/json'
	    );
	    
	 $array = array();   
  	$url = $this->api_url."?a=get&u=".$this->user."&p=".$this->pw."&d=whois&t=".$domain."&xml_standard=1";
  	$result = trim($this->createApiCall($url, 'GET', $headers));
  	//echo $url."<br>";

  	$pos = strpos($result, '<ns_1>');
  	if ($pos === false){
  		
  	}else {
    	$xml = @simplexml_load_string($result);
	  	$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		//var_dump($array);
	}
	return $array;
  }
  
public function whois2($domain){
  	$headers = array(
	        'Accept: application/json'
	    );
	    
	 $array = array();   
  	$url = $this->api_url."?a=get&u=".$this->user."&p=".$this->pw."&d=whois&t=".$domain."&xml_standard=1";
  	$result = trim($this->createApiCall($url, 'GET', $headers));
  	//echo $url."<br>";

  	$pos = strpos($result, '<ns_1>');
  	if ($pos === false){
  		
  	}else {
    	$xml = @simplexml_load_string($result);
	  	$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		//var_dump($array);
	}
	return $array;
  }
  
public function whoistest($domain){
  	$headers = array(
	        'Accept: application/json'
	    );
	    
	$array = array();   
  	$url = $this->api_url."?a=get&u=".$this->user."&p=".$this->pw."&d=whois&t=".$domain."&xml_standard=1";
  	$result = trim($this->createApiCall($url, 'GET', $headers));
    $xml = @simplexml_load_string($result);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	return $array;
  	
	
  }
	
}
?>