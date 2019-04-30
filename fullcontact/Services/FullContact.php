<?php

/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

function Services_FullContact_autoload($className) {
    $library_name = 'Services_FullContact';

    if (substr($className, 0, strlen($library_name)) != $library_name) {
        return false;
    }
    $file = str_replace('_', '/', $className);
    $file = str_replace('Services/', '', $file);
    return include dirname(__FILE__) . "/$file.php";
}

spl_autoload_register('Services_FullContact_autoload');

/**
 * This class handles the actually HTTP request to the FullContact endpoint.
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact
{
    const USER_AGENT = 'caseysoftware/fullcontact-php-0.9.0';

    protected $_baseUri = 'https://api.fullcontact.com/';
    protected $_version = 'v2';

    protected $_apiKey = null;
    protected $_webhookUrl = null;
    protected $_webhookId = null;

    public $response_obj  = null;
    public $response_code = null;
    public $response_json = null;

    /**
     * The base constructor needs the API key available from here:
     * http://fullcontact.com/getkey
     *
     * @param type $api_key
     */
    public function __construct($api_key)
    {
        $this->_apiKey = $api_key;
    }

    /**
     * This sets the webhook url for all requests made for this service 
     * instance. To unset, just use setWebhookUrl(null).
     *
     * @author  David Boskovic <me@david.gs> @dboskovic
     * @param   string $url
     * @param   string $id
     * @return  object
     */
    public function setWebhookUrl($url, $id = null) {
        $this->_webhookUrl = $url;
        $this->_webhookId  = $id;
        return $this;
    }

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
    /**
     * This is a pretty close copy of my work on the Contactually PHP library
     *   available here: http://github.com/caseysoftware/contactually-php
     *
     * @author  Keith Casey <contrib@caseysoftware.com>
     * @author  David Boskovic <me@david.gs> @dboskovic
     * @param   array $params
     * @return  object
     * @throws  Services_FullContact_Exception_NotImplemented
     */
    protected function _execute($params = array())
    {
        if(!in_array($params['method'], $this->_supportedMethods)){
            throw new Services_FullContact_Exception_NotImplemented(__CLASS__ .
                    " does not support the [" . $params['method'] . "] method");
        }

        $params['apiKey'] = $this->_apiKey;

        if($this->_webhookUrl) {
            $params['webhookUrl'] = $this->_webhookUrl;
        }

        if($this->_webhookId) {
            $params['webhookId'] = $this->_webhookId;
        }

        $fullUrl = $this->_baseUri . $this->_version . $this->_resourceUri .
                '?' . http_build_query($params);

        //open connection
        $connection = curl_init($fullUrl);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connection, CURLOPT_USERAGENT, self::USER_AGENT);

        //var_dump( curl_exec($connection));
        //exit;
        //execute request
        $result = curl_exec($connection);
        $res = json_decode($result,true);
        if (isset($res['status'])){
          if (($res['status']==403)){
          	$name = "";
          	$location = "";
          	$facebook = "";
          	$github = "";
          	$twitter = "";
          	$linkedin = "";
          	$googleplus = "";
          	
          	if (isset($params['email'])){
  	        	$headers = array('Accept: application/json');
  		   	    $url = 'https://liverep.contrib.com:8081/test?email='.$params['email'];
  		   	    $result =  $this->createApiCall($url, 'GET', $headers, array());
  		   	    $res = json_decode($result,true);
  		   	    
  		   	    $socials = array();
  		   	    
  		   	    if (isset($res['name'])){
  		   	    	$name = $res['name'];
  		   	    	
  		   	    	if ($res['location']!=null){
  		   	    		$location =$res['location']; 
  		   	    	}
  		   	    	
  		   	    	if ($res['facebook']!=null){
  		   	    		$facebook = 'https://www.facebook.com/'.$res['facebook'];
  		   	    		$socials[] = array('typeName'=>'facebook','url'=>$facebook);
  		   	    	}
  		   	    	
  		   	        if ($res['github']!=null){
  		   	    		$github = 'https://github.com/'.$res['github'];
  		   	    		$socials[] = array('typeName'=>'github','url'=>$github);
  		   	    	}
  		   	    	
  		   	       if ($res['twitter']!=null){
  		   	    		$twitter = 'https://twitter.com/'.$res['twitter'];
  		   	    		$socials[] = array('typeName'=>'twitter','url'=>$twitter);
  		   	    	}
  		   	    
  		   	    	if ($res['linkedin']!=null){
  		   	    		$linkedin = 'https://www.linkedin.com/'.$res['linkedin'];
  		   	    		$socials[] = array('typeName'=>'linkedin','url'=>$linkedin);
  		   	    	}
  		   	    	
  		   	    	if ($res['googleplus']!=null){
  		   	    		$googleplus = 'https://plus.google.com/'.$res['googleplus'];
  		   	    		$socials[] = array('typeName'=>'googleplus','url'=>$googleplus);
  		   	    	}
  		   	    	
  		   	    	
  		   	    	
  		   	    }
          	}
  	   	
          	
          	
          	
          	$array = array('status'=>403,'message'=>'Usage limits for the provided API Key have been exceeded. Please try again later or contact support to increase your limits',
          	'contactInfo'=>array('fullName'=>$name),
          	'demographics'=>array('locationGeneral'=>$location),
          	'socialProfiles'=>$socials
          	
          	);
          	$this->response_json = json_encode($array);
          	
          }else {
          	$this->response_json = curl_exec($connection);
          }
        
        }else {
        
        }
        
        $this->response_code = curl_getinfo($connection, CURLINFO_HTTP_CODE);
        $this->response_obj  = json_decode($this->response_json);

       

        return $this->response_obj;
    }
}