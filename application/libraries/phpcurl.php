<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Phpcurl
{
	public $CI;
	public $values;
	
	public function __construct()
    {
        
    }
	
	function fCurl($strUrl, $fields = array(), $bolDebug = false){
		$fields_string = "";
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { 
			if (is_array($value)){
				$fields_string .= $key.'='.json_encode($value).'&'; 
			}else{
				$fields_string .= $key.'='.$value.'&'; 
			}
		}
		$fields_string = rtrim($fields_string, '&');
		
		//echo $fields_string."<hr>";
		//open connection
		$objCurl = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($objCurl, CURLOPT_URL, $strUrl);
		curl_setopt($objCurl, CURLOPT_POST, count($fields));
		curl_setopt($objCurl, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($objCurl, CURLOPT_TIMEOUT_MS, 3600000); //in miliseconds
		
		$strResult = curl_exec($objCurl);
		if($strResult === false){
			echo 'Curl error: ' . curl_error($objCurl);
			die();
		}

		//close connection
		curl_close($objCurl);
		
		//Debug Option
		if ($bolDebug){
			echo $strResult."<hr>";
			die();
		}
		
		$objResult = null;
		if ($strResult != ""){
			//Result to array
			$arrResult = json_decode($strResult, true);
			
			//Result to object
			$objResult = json_decode($strResult);
		}

		return $objResult;
	}
	
	function fCurlJson($strUrl, $fields = array(), $bolDebug = false){
		//open connection
		$objCurl = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($objCurl, CURLOPT_URL, $strUrl);
		curl_setopt($objCurl, CURLOPT_HEADER, false);
		curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($objCurl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($objCurl, CURLOPT_POST, true);
		curl_setopt($objCurl, CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($objCurl, CURLOPT_SSL_VERIFYPEER, false);
		
		//execute post
		$strResult = curl_exec($objCurl);
		if($strResult === false){
			echo 'Curl error: ' . curl_error($objCurl);
			die();
		}

		//close connection
		curl_close($objCurl);
		
		//Debug Option
		if ($bolDebug){
			echo "Debug : <br>".$strResult."<hr>";
			die();
		}
		
		$arrResult = array();
		if ($strResult != ""){
			$arrResult = json_decode($strResult, true);
		}
		
		return $arrResult;
	}
}