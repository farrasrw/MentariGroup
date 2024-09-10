<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MProject extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function getListproject($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0 ){
		
		
		if($limit==0) $result =  $this->getAllRecord($this->db, 'project', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'project', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowproject($arrOrder=array(), $arrWhere = array()){
		
		$result = $this->getRecordRow($this->db, 'project', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addproject($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'project' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'project' , $arrData);
	}
	
	public function editproject($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'project', $arrData, $arrWhere);
	}
	
	public function deleteproject($arrWhere = array()){
		
		$this->deleteData($this->db, 'project', $arrWhere);
	}
	
	
	
	
}
