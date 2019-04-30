<?php
function createApiCall($url, $method, $headers, $data = array(),$user=null,$pass=null)
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

if ( ! function_exists('get_privacy'))
{
	function get_privacy()
	{
    $domain='trackers.com';
    $headers = array('Accept: application/json');
    $api_content_url = "http://api3.contrib.co/announcement/";                 //get terms
		$url = $api_content_url.'GetFooterContents?domain='.$domain.'&key=5c1bde69a9e783c7edc2e603d8b25023&page=privacy';
		$result =  createApiCall($url, 'GET', $headers, array());
		$data_domain = json_decode($result,true);
		if (isset($data_domain['data']['content'])){
		$privacy =   $data_domain['data']['content'];
		}else {
		$privacy = "";
		}
    return $privacy;
	}
}

if ( ! function_exists('get_terms'))
{
	function get_terms()
	{
    $domain='trackers.com';
    $headers = array('Accept: application/json');
    $api_content_url = "http://api3.contrib.co/announcement/";                 //get terms
	$url = $api_content_url.'GetFooterContents?domain='.$domain.'&key=5c1bde69a9e783c7edc2e603d8b25023&page=terms';
	$result =  createApiCall($url, 'GET', $headers, array());
	$data_domain = json_decode($result,true);
	if (isset($data_domain['data']['content'])){
		$privacy =   $data_domain['data']['content'];
		}else {
		$privacy = "";
	}
     return $privacy;
	}
}

if ( ! function_exists('get_cookie_policy'))
{
	function get_cookie_policy()
	{
    $domain='trackers.com';
    $headers = array('Accept: application/json');
    $api_content_url = "http://api3.contrib.co/announcement/";                 //get terms
	$url = $api_content_url.'GetFooterContents?domain='.$domain.'&key=5c1bde69a9e783c7edc2e603d8b25023&page=cookie';
	$result =  createApiCall($url, 'GET', $headers, array());
	$data_domain = json_decode($result,true);
	if (isset($data_domain['data']['content'])){
		$privacy =   $data_domain['data']['content'];
		}else {
		$privacy = "";
	}
     return $privacy;
	}
}

if ( ! function_exists('get_programs'))
{
	function get_programs()
	{
    $domain='trackers.com';
    $headers = array('Accept: application/json');
    $api_url = "http://api2.contrib.co/request/";
    $key = md5('vnoc.com');
    $domain_affiliate_id = 30;
    $url = $api_url.'getReferralBanners?domain='.$domain.'&key='.$key.'&affiliate_id='.$domain_affiliate_id;
	$result = createApiCall($url, 'GET', $headers, array());
	$program_result = json_decode($result,true);
	$programs = array();  
	if ($program_result['success']){
			$programs = $program_result['data'];
	}else {
		$programs = array();
	}	
     return $programs;
	}
}

if ( ! function_exists('get_fund_campaigns'))
{
	function get_fund_campaigns()
	{
	$campaigns = array();
	$headers = array('Accept: application/json');
	$api_url = "http://api2.contrib.co/request/";
	$url = $api_url.'getfundcampaigns';
	$result = createApiCall($url, 'GET', $headers, array()); 
    $items = json_decode($result,true);
	if ($items['success']){
    		$campaigns = $items['data'];
    }
     return $campaigns;
	}
}
