<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MKategori extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function getListKategori($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0 ){
		
		
		if($limit==0) $result =  $this->getAllRecord($this->db, 'kategori', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'kategori', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowKategori($arrOrder=array(), $arrWhere = array()){
		
		$result = $this->getRecordRow($this->db, 'kategori', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addKategori($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'kategori' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'kategori' , $arrData);
	}
	
	public function editKategori($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'kategori', $arrData, $arrWhere);
	}
	
	public function deleteKategori($arrWhere = array()){
		
		$this->deleteData($this->db, 'kategori', $arrWhere);
	}
	
	
	
	
}
