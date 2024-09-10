<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MBeritaimage extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function getListBeritaImage($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0 ){
		
		
		if($limit==0) $result =  $this->getAllRecord($this->db, 'berita_image', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'berita_image', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowBeritaImage($arrOrder=array(), $arrWhere = array()){
		
		$result = $this->getRecordRow($this->db, 'berita_image', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addBeritaImage($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'berita_image' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'berita_image' , $arrData);
	}
	
	public function editBeritaImage($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'berita_image', $arrData, $arrWhere);
	}
	
	public function deleteBeritaImage($arrWhere = array()){
		
		$this->deleteData($this->db, 'berita_image', $arrWhere);
	}
	
	
	
	
}
