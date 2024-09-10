<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Csv
{
	var $CI;
	
	function __construct(){
		$this->CI =& get_instance();
		
		$this->CI->load->helper('download');
		
	}
	
	public function generateCsvFile($strFileName, $arrData, $strDelimiter = ",", $strNewLine = "\n", $strEnclosure = '"'){
		
		//---------------------- Example Data ----------------------//
		/*
		$arrData = array();
		$arrTemp = array("Name" => "A", "Address" => "Address A", "Value" => 3.4);
		array_push($arrData, $arrTemp);
		$arrTemp = array("Name" => "B", "Address" => "Address B", "Value" => 5.4);
		array_push($arrData, $arrTemp);
		$arrTemp = array("Name" => "C", "Address" => "Address C", "Value" => 6.4);
		array_push($arrData, $arrTemp);
		$arrTemp = array("Name" => "D", "Address" => "Address D", "Value" => 7.4);
		array_push($arrData, $arrTemp);
		$arrTemp = array("Name" => "E", "Address" => "Address E", "Value" => 8.4);
		array_push($arrData, $arrTemp);
		
		//StdClass Array
		$arrData = json_decode(json_encode($arrData));

		//Single Array
		$arrData = array("Name" => "E", "Address" => "Address E", "Value" => 8.4);
		*/
		
		$strHeader = "";
		$strResult = "";
				
		if (is_array($arrData)){
			$bolMulti = false;
			
			foreach (array_values($arrData) as $i => $value) {
				if (is_array($value) || is_object($value)){
					$bolMulti = true;
				}
			}
		
			if ($bolMulti){
				//---------------------- Header File ----------------------//
				$arrHeader = $arrData[0];
				if (!is_array($arrHeader) && is_object($arrHeader)){
					$arrHeader = json_decode(json_encode($arrHeader), true);
				}
				
				foreach (array_keys($arrHeader) as $FieldName){
					$strHeader .= rtrim($strEnclosure.str_replace($strEnclosure, $strEnclosure.$strEnclosure, $FieldName).$strEnclosure).$strDelimiter;
				}
				$strHeader = rtrim($strHeader);
				$strResult = $strHeader.$strNewLine;
			
				//---------------------- Detail File ----------------------//
				foreach ($arrData as $arrValue){
					foreach ($arrValue as $strKey => $strValue){
						$strResult .= $strEnclosure.str_replace($strEnclosure, $strEnclosure.$strEnclosure, $strValue).$strEnclosure.$strDelimiter;
					}
					$strResult = rtrim($strResult);
					$strResult .= $strNewLine;
				}
			}else{
				foreach ($arrData as $strKey => $strValue){
					$strHeader .= $strEnclosure.str_replace($strEnclosure, $strEnclosure.$strEnclosure, $strKey).$strEnclosure.$strDelimiter;
					$strResult .= $strEnclosure.str_replace($strEnclosure, $strEnclosure.$strEnclosure, $strValue).$strEnclosure.$strDelimiter;
				}
				$strHeader = rtrim($strHeader);
				$strResult = rtrim($strResult);
				$strResult = $strHeader.$strNewLine.$strResult;
			}
		}
		
		force_download($strFileName, $strResult);
	}
}