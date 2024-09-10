<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MTag extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function getListTag($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0 ){
		
		
		if($limit==0) $result =  $this->getAllRecord($this->db, 'master_tag', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'master_tag', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowTag($arrOrder=array(), $arrWhere = array()){
		
		$result = $this->getRecordRow($this->db, 'master_tag', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addTag($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'master_tag' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'master_tag' , $arrData);
	}
	
	public function editTag($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'master_tag', $arrData, $arrWhere);
	}
	
	public function deleteTag($arrWhere = array()){
		
		$this->deleteData($this->db, 'master_tag', $arrWhere);
	}
	
	
	
	
}