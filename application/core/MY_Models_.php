<?php

class MY_Models extends CI_Model {
	public $hrdb;
	
	function __construct()
    {
        parent::__construct();
		//$this->hrdb = $this->load->database('hrdb', true);
        //$this->dbtrans = $this->load->database('dbtrans', true);
		//$this->dbvendor = $this->load->database('dbvendor', true);

    }    
	
	//transaction db 
	/*function db_transBegin(){
		$this->db->trans_begin();
	}
	
	function db_transCommit(){
		$this->db->trans_commit();
	}
	
	function db_transRollBack(){
		$this->db->trans_rollback();
	}
	
	function db_transStatus(){
		$this->db->trans_status();
	}
	
	//transaction dbTrans 
	function dbtrans_transBegin(){
		$this->dbtrans->trans_begin();
	}
	function dbtrans_transCommit(){
		$this->dbtrans->trans_commit();
	}
	function dbtrans_transRollBack(){
		$this->dbtrans->trans_rollback();
	}
	function dbtrans_transStatus(){
		$this->dbtrans->trans_status();
	}*/
	
	
	
	function getFieldTable($db, $strTabelNm){
		$result = $db->list_fields($strTabelNm);
		foreach($result as $field){
			$data[$field] = "";
		}
		return $data;
	}
	
	public function getAllRecord($db, $strTabelNm, $arrOrder = array(), $arrWhere = array()){
		//Flush Param
		$db->flush_cache();
		
		//Criteria
		$this->paramCriteria($db,$arrOrder,$arrWhere);
        $query = $db->get($strTabelNm)->result();
		
		return $query;
	}
        
	public function getLimitRecord($db, $strTabelNm, $arrOrder = array(), $arrWhere = array(), $limit = 10, $offset = 0){
        //Flush Param
		$db->flush_cache();
		//$this->dbtrans->flush_cache();
		$this->db->flush_cache();
		
		$this->paramCriteria($db,$arrOrder,$arrWhere);
		if($limit==0){
			return $query = $db->get($strTabelNm)->result();
		}else{
			return $query = $db->get($strTabelNm, $limit, $offset)->result();
		}
	}
	
	public function getLimitRow($db, $strTabelNm, $arrOrder = array(), $arrWhere = array(), $limit = 10, $offset = 0){
		
		//Flush Param
		$db->flush_cache();
		
        $this->paramCriteria($db,$arrOrder,$arrWhere);
		
		if($limit==0){
		
		}else{
		
		}
		return $db->count_all_results($strTabelNm);
	}
	
	public function addData($db, $strTabelNm, $arrData){
		$arrSavingDb = array();
		$result = $db->list_fields($strTabelNm);
		
		foreach($result as $field){
			//Insert Default Tracking data
			switch (strtolower($field)) {
				case 'createdate': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
                case 'createby' : $arrSavingDb[$field] = $this->session->userdata('UserId'); break;
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
			if(in_array('createby', $result )) 		$arrTemp['createby']=$this->session->userdata('UserId');

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
    
    
    
    public function paramCriteria($db, $arrOrder=array(),$arrWhere=array(), $queryResult = false ){
		
		//use Group  Query =   select * from Table ( ( Name = value && age= value  ) || useradmin=true ) ;
		//   _grpstr  For  (
		//   _grpend  For  )
						
		
		$db->flush_cache();
		$arrRes = array(
			'where'=>'',
			'order'=>''
		);
		$multiWhere = false ; 
		
		
        //Criteria
		if (count($arrWhere) > 0){
			

			foreach ($arrWhere as $strField => $strValue){
				
					
					if (is_array($strValue)){
						if (strpos($strField, "not in") > 0) {
							$db->where_not_in(trim(str_replace("not in", "", $strField)), $strValue);
						}else{
							$db->where_in($strField, $strValue);
						}
					}else if (strpos($strValue, "is null") > 0 || strpos($strValue, "is not null") > 0) {
						$db->where($strField." ".$strValue);
					}else if(substr($strField,0,3)=='or '){
						
						$db->or_where(trim(str_replace('or ','',$strField)), $strValue);
					}else if(substr($strValue,0,1)=='%' ){
						
						$db->like($strField, str_replace('%','',$strValue));
						
					}else if(strpos($strField, "_sql")!==FALSE ){
						
						if(strpos($strField, " or")!==FALSE){
							$db->or_where($strValue,'',false);
						}else{
							$db->where($strValue,'',false);
						} 
						
					}else{
						
						$db->where($strField, $strValue);
						
					}	
				
				
			}
			
			/*
			if($queryResult && !$multiWhere){
				
				$query =  $db->get_compiled_select();
				$query = substr($query, strpos($query,'WHERE'));
				$arrRes['where'] = $query;
				$db->flush_cache();

			}*/
			
		}
		
		//Order By
		if (count($arrOrder) > 0){
			foreach ($arrOrder as $strField => $strValue){
				if(is_array($strValue)){
					$db->_protect_identifiers = FALSE;
					$db->order_by("FIELD (".$strField.", '".implode("','",$strValue)."') Desc");
					$db->_protect_identifiers = TRUE;
				}else{
				    $db->order_by($strField, $strValue);
				}
			}
			/*
			if($queryResult){
				
				$query =  $db->get_compiled_select();
				$query = substr($query, strpos($query,'ORDER'));
				$arrRes['order'] = $query;
				$db->flush_cache();
			}*/
		}
		return $arrRes;
						   
    }
						   
	public function paramCriteriaNativ($db, $arrOrder=array(),$arrWhere=array()){
		
		$arrRes = array('where'=>'','order'=>'');
		$sqle = '';
		foreach($arrWhere as $strField=>$strValue){
			
			//using multi Where with field name is where(Any) & Value Is Array
			if(substr($strField,0,5)=='where' && is_array($strValue)){
				
				$multiWhere = true ;  
				$query      = $this->paramCriteriaNativ($db, array(), $strValue); 
				$arrRes['where'][$strField] = $query['where'];
				
				
			}else{
			
				$field = trim(str_replace('_grpstr','', $strField));
				$field = trim(str_replace('_grpend','', $field));

				$arrWhereTemp=array($field => $strValue);

				$sql = $this->paramCriteria( $db, array(), $arrWhereTemp ); 
				$query =  $db->get_compiled_select();
				$query = substr($query, strpos($query,'WHERE'));
				$db->flush_cache();	

				$query = str_replace('WHERE','',$query);
				if(strpos($field,'or ') !== FALSE  ){ $query = ' OR '. $query;}
				else if($sqle!='' && substr_count($strField,'_grpstr')==0 ){ $query = ' AND '.$query; }

				if(substr_count($strField,'_grpstr')>0){ 
					$bolsql = true ;  
					$query = str_repeat('(',substr_count($strField,'_grpstr')).$query;

					if(substr_count($strField,'_grpor')>0){ $bolsql = true ;  $query = ' OR '.$query; }
					else if($sqle!=''){ $query = ' AND '.$query;  } 
				}

				if(substr_count($strField,'_grpend')>0){ $bolsql = true ;  $query = $query.str_repeat(')',substr_count($strField,'_grpend'));} 			

				$sqle.=$query;
				$arrRes['where'] = 'WHERE '.$sqle;
			}
		}
		
		if(!empty($arrOrder)){
			$this->paramCriteria( $db, $arrOrder );
			$query =  $db->get_compiled_select();
			$query = substr($query, strpos($query,'ORDER'));
			$arrRes['order'] = $query;
			$db->flush_cache();
		}				
		
		return $arrRes;
	 
	}
    	
    
		
	
}

?>