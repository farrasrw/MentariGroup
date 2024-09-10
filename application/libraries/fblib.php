<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Autoload the required files
require_once( APPPATH . 'third_party/Facebook/autoload.php' );

class Fblib
{
  public $ci;
  public $fb;
  public $appId;
  public $appSecret;
  public $redirectUrl;
  public $permissions = array();
	
  public function __construct()
  {
	  
    // Get CI object.
    $this->ci 	 		= & get_instance();
	  
 	$this->appId 		 = $this->ci->config->item('api_id', 'facebook');
	$this->appSecret	 = $this->ci->config->item('app_secret', 'facebook');
	$this->redirectUrl   = $this->ci->config->item('redirect_url', 'facebook');
	$this->permissions   = $this->ci->config->item('permissions', 'facebook');

	$this->fb 	 =  new Facebook\Facebook([
					  'app_id'                =>$this->appId ,
					  'app_secret'            =>$this->appSecret,
					  'default_graph_version' => 'v2.4',
					]); 
  }
	
	
  public function getUser($strToken=''){
	  
	$arrRes = array(
		'valid'=>true,
		'data'=>array()
	); 
	  
	if(!empty($strToken)){  
		$fb = $this->fb;
		try {
		  // Returns a `Facebook\FacebookResponse` object
		  $response = $fb->get('/me?fields=id,name', $strToken);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  
		  $arrRes['valid'] = false;
		  //echo 'Graph returned an error: ' . $e->getMessage();
		  //exit;
			
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			
		  $arrRes['valid'] = false;	
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
			
		}
		if($arrRes['valid']){
			
			$user = $response->getGraphUser();
			$fb->setDefaultAccessToken($strToken);

			$response = $fb->get('/me?locale=en_US&fields=first_name,last_name,email,gender,age_range,birthday,picture');
			$userNode = $response->getGraphUser();

			$arrRes['data'] = $userNode;
			
		}
		
		return $arrRes;
		
	}else{
		$arrRes['valid'] = false;	
		return $arrRes;
	}
 }
	
	
 
	
  public function getLoginUrl(){
	  
	$fb 		 = $this->fb;
	$helper		 = $fb->getRedirectLoginHelper();
	$loginUrl    = $helper->getLoginUrl($this->redirectUrl,$this->permissions);
	//$this->ci->session->set_userdata('FbState',$_SESSION['FBRLH_state']);
	//$this->bb();
	  
	  //$loginUrl = $helper->getLogoutUrl('67155bc0001c5414c762d596936f73be', 'http://siadhy.esy.es/jagapat');

	
	return $loginUrl;
	  
  }
  
  public function getToken(){
	   //die($this->ci->session->userdata('FbState').'<br>'.$this->ci->session->userdata('bubu'));
	   	$fb 				     = $this->fb;
		$helper 				 = $fb->getRedirectLoginHelper();
	  
	  	if(empty($this->ci->input->get('state'))) redirect(base_url());
	  
	  	$_SESSION['FBRLH_state'] = $this->ci->input->get('state');
	  
	  	$arrRes['valid']  		 = true;
	  	$errMessage		  		 = '';
	  
		try {
			if (!empty($this->ci->session->userdata('facebook_access_token'))) {
				//$accessToken = $_SESSION['facebook_access_token'];
				$accessToken = $this->ci->session->userdata('facebook_access_token');
			} else {
				$accessToken = $helper->getAccessToken();
			}
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
			$arrRes['valid']  = false;
			$errMessage = $e->getMessage();
			
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
			$arrRes['valid']  = false;
			$errMessage = $e->getMessage();
			
		 }
	 

		if (isset($accessToken)) {
			
			if (!empty($this->ci->session->userdata('facebook_access_token'))) {
				
				$fb->setDefaultAccessToken($this->ci->session->userdata('facebook_access_token'));
				
			} else {
				 
				// getting short-lived access token
				//$_SESSION['facebook_access_token'] = (string) $accessToken;
				$this->ci->session->set_userdata('facebook_access_token',(string) $accessToken);

				// OAuth 2.0 client handler
				$oAuth2Client = $fb->getOAuth2Client();

				// Exchanges a short-lived access token for a long-lived one
				$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($this->ci->session->userdata('facebook_access_token'));

				//$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
				$this->ci->session->set_userdata('facebook_access_token',(string) $longLivedAccessToken);


				// setting default access token to be used in script
				$fb->setDefaultAccessToken($this->ci->session->userdata('facebook_access_token'));
				
			}

			
			// printing $profile array on the screen which holds the basic info about user
			$arrRes['valid']  = true;
			$arrRes['token'] = (string) $accessToken;	
			return  $arrRes;
			// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
			
		} else {
			
			// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
			$arrRes['valid']  = false;
			$errMessage = $errMessage;
			return $arrRes;
			
			
		}
  }
	
	


 
  
 

}