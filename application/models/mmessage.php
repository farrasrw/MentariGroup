<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MMessage extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	/*public function getListMessage($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0 ){
		
		
		if($limit==0) $result =  $this->getAllRecord($this->db, 'message', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'message', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowMessage($arrOrder=array(), $arrWhere = array()){
		
		$result = $this->getRecordRow($this->db, 'message', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addMessage($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'message' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'message' , $arrData);
	}
	
	public function editMessage($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'message', $arrData, $arrWhere);
	}
	
	public function deleteMessage($arrWhere = array()){
		
		$this->deleteData($this->db, 'message', $arrWhere);
	}*/
    
    public function getFieldMessage(){
		return $this->getFieldTable($this->db, "message");
	}
	
	public function getListMessage($arrOrder = array(), $arrWhere = array()){
		return $this->getAllRecord($this->db, "message", $arrOrder, $arrWhere);
	}
	
	public function addMessage($arrData){
		$this->addData($this->db, "message", $arrData);
	}
    
	public function editMessage($arrData, $arrWhere = array()){
		$this->editData($this->db, "message", $arrData, $arrWhere);
	}
	
	public function deleteMessage($arrWhere = array()){
		$this->deleteData($this->db, "message", $arrWhere);
	}

    
    ////////////////////////////////////////Menggunakan Data Tabel Ajax/////////////////////////////////////////////////////////////
    
    public function getLimitMessage ($arrOrder=array(), $arrWhere= array(), $limit=10, $offset=0){
        return $this->getLimitRecord($this->db,"message", $arrOrder, $arrWhere, $limit, $offset);
    }
    
    
	public function getRowsMessage(){
		return $this->db->count_all_results('message');
	}
    
    public function getLimitMessageRow($arrOrder= array(), $arrWhere= array(), $limit=10, $offset=0){
        $this->paramCriteria($this->db,$arrOrder,$arrWhere);
		return $this->db->count_all_results("message");        
    }
	
	
	
	
}
