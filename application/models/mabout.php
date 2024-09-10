<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MAbout extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function getListAbout($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0 ){
		
		
		if($limit==0) $result =  $this->getAllRecord($this->db, 'about', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'about', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowAbout($arrOrder=array(), $arrWhere = array()){
		
		$result = $this->getRecordRow($this->db, 'about', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addAbout($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'about' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'about' , $arrData);
	}
	
	public function editAbout($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'about', $arrData, $arrWhere);
	}
	
	public function deleteAbout($arrWhere = array()){
		
		$this->deleteData($this->db, 'about', $arrWhere);
	}
	
	
	
	
}
