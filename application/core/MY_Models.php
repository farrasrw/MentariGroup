<?php

class MY_Models extends CI_Model {
	
	protected $DB;
	protected $TABLE;
	
	function __construct()
    {
		$this->load->database();
		parent::__construct();
		$this->DB    = $this->db;
		$this->TABLE = NULL;
    }
	
	public function DBDefault(){
		$this->DB = $this->db; 
	}
	
	/*
		di Gunakan Jika Menggunakan Multi Database 
		public function setDBTrans(){
			$this->DB = $this->dbtrans; 
		}
	*/
	
	public function __call($method, $params) {
		
		$db = $this->DB;
        if (method_exists($db, $method)) {
            call_user_func_array(array($db, $method), $params);
            return $this;
        }
		
    }
	
	public function setDB($objdb=array(), $strTable=''){
		
		if(!empty($objdb)) $this->DB 	= $objdb;
		if($strTable !='') $this->TABLE = $strTable;
		return $this;
		
	}
	
	function getFieldTable($db, $strTabelNm){
		
		
		$result = $db->list_fields($strTabelNm);
		foreach($result as $field){
			$data[$field] = "";
		}
		return $data;
		
	}
	
	public function getAllRecord($db, $strTabelNm, $arrOrder = array(), $arrWhere = array()){
		//Criteria
		$this->paramCriteria($db, $arrOrder, $arrWhere);
        $query = $db->get($strTabelNm);
		return $query->result();
	}
	
	public function getLimitRecord($db, $strTabelNm, $arrOrder = array(), $arrWhere = array(), $limit = 10, $offset = 0){
		$this->paramCriteria($db,$arrOrder,$arrWhere);
		if($limit==0){
			return $query = $db->get($strTabelNm)->result();
		}else{
			return $query = $db->get($strTabelNm, $limit, $offset)->result();
		}
	}
	
	public function getRecordRow($db, $strTabelNm, $arrOrder = array(), $arrWhere = array()){
        $this->paramCriteria($db,$arrOrder,$arrWhere);
		return $db->count_all_results($strTabelNm);
	}
	
	public function addData($db, $strTabelNm, $arrData){
		
		$arrSavingDb = array();
		$result 	 = $db->list_fields($strTabelNm);
		
		foreach($result as $field){
			
			//Insert Default Tracking data
			switch (strtolower($field)) {
				case 'createdate': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
                case 'createby' : $arrSavingDb[$field]  = $this->session->userdata('UserId').'-'.$this->session->userdata('UserInitial'); break;
			}
			
			if (isset($arrData[$field])){
				$arrSavingDb[$field] = $arrData[$field];
			}
			
		}

		$db->insert($strTabelNm, $arrSavingDb);
		
	}
	
	public function addBatchData($db, $strTabelNm, $arrData){
		
		
		$arrSavingDb = array();
		$result = $db->list_fields($strTabelNm);
		$dateCreate = date('Y-m-d H:i:s');
		foreach($arrData as $arrItem =>$arrItemValue ){
			$arrTemp = array();
			
			foreach($arrItemValue as $field=>$value){
				if(in_array($field,$result)) $arrTemp[$field] = $value;
			}
			
			//Insert Default Tracking data
			if(in_array('createdate', $result )) 	$arrTemp['createdate']=$dateCreate;
			if(in_array('createby', $result )) 		$arrTemp['createby']=$this->session->userdata('UserId').'-'.$this->session->userdata('UserInitial');

			array_push($arrSavingDb,$arrTemp);
		}
			
		$db->insert_batch($strTabelNm, $arrSavingDb); 
	}
	
	public function editData($db, $strTabelNm, $arrData, $arrWhere = array()){
		$arrSavingDb = array();
		$result = $db->list_fields($strTabelNm);
		$bolValidWhere = false;
		$bolDelete = false;
		
		if (count($arrData) == 1){
			if(isset($arrData["stsDelete"])){
				$bolDelete = true;
			}
		}
		
		//Data To Update
		foreach($result as $field){
			//Insert Default Tracking data
			if ($bolDelete){
				switch (strtolower($field)) {
					case 'deletedate': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
                    case 'deleteby': $arrSavingDb[$field]= $this->session->userdata('UserId');
				}
			}else{
				switch (strtolower($field)) {
					case 'updatedate': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
                    case 'updateby': $arrSavingDb[$field]= $this->session->userdata('UserId'); break;
				}
			}
			
			if (isset($arrData[$field])){
				$arrSavingDb[$field] = $arrData[$field];
			}
			
			if (isset($arrWhere[$field])){
				$bolValidWhere = true;
				
				if (is_array($arrWhere[$field])){
					$db->where_in($field, $arrWhere[$field]);
				}else{
					$db->where($field, $arrWhere[$field]);
				}
			}
		}
		
		if ($bolValidWhere){
			if (count($arrWhere) > 0){
				$db->update($strTabelNm, $arrSavingDb);
			}
		}
		
	}
	
	public function deleteData($db, $strTabelNm, $arrWhere = array()){
		$bolValidWhere = false;
		$result = $db->list_fields($strTabelNm);
		
		if (count($arrWhere) > 0){
			foreach($result as $field){
				if (isset($arrWhere[$field])){
					$bolValidWhere = true;
					
					if (is_array($arrWhere[$field])){
						$db->where_in($field, $arrWhere[$field]);
					}else{
						$db->where($field, $arrWhere[$field]);
					}
				}
			}
			
			if ($bolValidWhere){
				if (count($arrWhere) > 0){
					$db->delete($strTabelNm);
				}
			}
		}
		$db->affected_rows();
	}
	
	public function deleteAllData($db, $strTabelNm){
		$db->empty_table($strTabelNm); 
	}
	
	public function getTabelKey($strTabelNm){
		$intCode = 1;
		$intLength = 8;
		
		//Get KeyCode Value
		switch ($strTabelNm){
			case "User":
			  $strKeyCode = "UserId"; break;
			case "Distributor":
			  $strKeyCode = "CommId"; break;  
			case "Redeem":
			  $strKeyCode = "Redeem"; break;    
		}
		
		//Get Code
		$this->db->where("KeyCode", $strKeyCode);
		$query = $this->db->get("CodeCounter")->result();
		if (count($query) > 0){
			$intLength 	= (int)$query[0]->KeyLength;
			$intCode 	= (int)$query[0]->RunningNum + 1;
			$strKey		= $query[0]->KeyHead;
			
			$intLength -= strlen($strKey);
		}
		
		//Update Code
		$arrUpdateDb["RunningNum"] = $intCode;
		$this->db->where("KeyCode", $strKeyCode);
		$this->db->update("CodeCounter", $arrUpdateDb);
		
		$strNewCode = $strKey.substr("00000000000000".$intCode, $intLength * -1);

		return $strNewCode;
	
	}
    
    public function paramCriteria($db, $arrOrder=array(), $arrWhere=array(), $compiledSelect =false ){
		
		$db->flush_cache();
		
		$arrReturn = array();
		
		if(!empty($arrWhere)){
			
			/*  Sets WHERE :
     		
			 $where['{ _grpOr_ _like_ } MemberId'] => '0001'; 
			 Expresion Where Parameter
			 
				'{ _grpor_ _like_ } 	use Multi Expresion '	=> 'is null', 
				'{ _grpor_ } 			user Group with Or'		=> 'is not null',
				'{ _grp_  }				user Group With And'	=> 'Value of Field',
				'{ _grpend_  } 			end Of Group'			=> 'Value of Field',
				'{ _like_ } 			Filter With Like '		=> '% Value of Field %',
				'{ _orlike_ } 			Filter With Or Like'	=> '% Value of Field %'
				'{ _notin_ } 			Filter With Not In'		=> 'Array Value'
				'{ _or_ } 				Filter With Or'			=> 'Array Value'
				'{ _sql_ } 				Filter With Sql'		=> 'Sql Query '
				
			*/
			
			$protectField 	= true ;
			
			foreach ($arrWhere as $strField => $strValue){
				
				$strExpresion  = '_' ;
				//get MatchExpresion 
				preg_match("/\{(.*)\}/", $strField , $matchExpresion);
				
				if(count($matchExpresion)>0){
					
					$strExpresion = $matchExpresion[0];
					//update StrField
					$strField = str_replace($strExpresion,'',$strField);
					
				}
				
				$strField = trim($strField);
				
		
				//Expresion Group Start
				if(strpos($strExpresion, '_grp_')!==FALSE){
					$intTotal = (int)substr_count($strExpresion,'_grp_');
					for($i=0; $i<$intTotal;$i++){
						$db->group_start();
					}  
				}
				
				// Expresion Group Or
				if(strpos($strExpresion,'_grpor_')!==FALSE) $db->or_group_start(); 
				
				// Expresion use  _sql_ Where 
				if(strpos($strExpresion,'_sql_')!==FALSE){
					$strField 		= $strValue;
					$strValue 		= null;
					$protectField 	= FALSE;	
				}
				
				// WHERE IN & NOT IN 
				if (is_array($strValue)){
					
					if (strpos($strExpresion, "_notin_") !==FALSE) {
						$db->where_not_in($strField, $strValue);
					}else{
						$db->where_in($strField, $strValue);
					}
					
				}
				//Is NULL or IS NOT NULL VALUE
				else if (strpos(strtolower($strValue), "is null") !== FALSE || strpos(strtolower($strValue), "is not null") !== FALSE ) {
					$db->where($strField." ".$strValue);
				}
				//OR WHERE
				else if (strpos($strExpresion, "_or_") !==FALSE) {							
					$db->or_where($strField, $strValue, $protectField);
                }
				//LIKE WHERE
				else if (strpos($strExpresion, "_like_") !==FALSE || strpos($strExpresion, "_orlike_") !==FALSE  ) {
					
					if(strpos($strExpresion, "_orlike_") !==FALSE){
						$like ='or_like';
					}else{
						$like = 'like';
					}
					
					if(substr($strValue,0,1)=='%' And substr($strValue,-1)!='%' ){
						//Before LIKE	
						$db->$like($strField,trim(str_replace('%','',$strValue)),'before');
						
					}else if(substr($strValue,0,1)!='%' And substr($strValue,-1)=='%' ){
						
						//AFTER LIKE
						$db->$like($strField,trim(str_replace('%','',$strValue)),'after');
						
					}else{
						
						$db->$like($strField,trim(str_replace('%','',$strValue)));
					}
					
                }else{
					$db->where($strField, $strValue, $protectField);
				}
				
				//Group End 
				if(strpos($strExpresion,'_grpend_')!==FALSE){
					$intTotal = (int)substr_count($strExpresion,'_grpend_');
					for($i=0; $i<$intTotal;$i++){
						$db->group_end(); 
					} 
				}
			}
			
			if($compiledSelect){
				$sql = $this->db->get_compiled_select('CompileSelect');
				if($sql!='') $sql = substr($sql,strpos($sql,'WHERE'));
				$arrReturn['where'] =$sql;
				$db->flush_cache();
			}
		}

		//Order By
		if (count($arrOrder) > 0){
			foreach ($arrOrder as $strField => $strValue){
				$db->order_by($strField, $strValue);
			}
			
			if($compiledSelect){
				$sql = $this->db->get_compiled_select('CompileSelect');
				if($sql!='') $sql = substr($sql,strpos($sql,'ORDER'));
				$arrReturn['order'] = $sql;
				$db->flush_cache();
			}
		}
		
		return $arrReturn;
		
    }

}

