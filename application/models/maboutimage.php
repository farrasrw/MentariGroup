<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MAboutimage extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function getListAboutImage($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0 ){
		
		
		if($limit==0) $result =  $this->getAllRecord($this->db, 'about_image', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'about_image', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowAboutImage($arrOrder=array(), $arrWhere = array()){
		
		$result = $this->getRecordRow($this->db, 'about_image', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addAboutImage($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'about_image' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'about_image' , $arrData);
	}
	
	public function editAboutImage($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'about_image', $arrData, $arrWhere);
	}
	
	public function deleteAboutImage($arrWhere = array()){
		
		$this->deleteData($this->db, 'about_image', $arrWhere);
	}
	
	
	
	
}
