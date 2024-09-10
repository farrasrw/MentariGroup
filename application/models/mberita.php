<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MBerita extends MY_Models {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function getListBerita($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0){
		
		$this->db->select('berita.*, kategori.kategori_url, kategori.kategori_name');
		
		//if use Filter Tag
		if(isset($arrWhere['tag_url'])){
			$arrWhere["{ _sql_ } berita_id"] = " berita.berita_id in ( select berita_id from berita_tag inner join  master_tag on master_tag.tag_id = berita_tag.tag_id where master_tag.tag_url ='".$arrWhere['tag_url']."')"; 
			unset($arrWhere['tag_url']);
		
		}

		
		$this->db->join('kategori', 'kategori.kategori_id = berita.kategori_id', 'left');
		if($limit==0) $result =  $this->getAllRecord($this->db, 'berita', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'berita', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getListBeritaJoinTag($arrOrder=array(), $arrWhere = array() , $limit = 0,$offset =0){
		
		$this->db->select('berita.*, kategori.kategori_url');
		
		if(isset($arrWhere['tag_url'])){
			$this->db->where( "berita_id in ( select berita_id from berita_tag left join master_tag on master_tag.tag_id = berita_tag.tag_id where master_tag.tag_url ='".$arrWhere['tag_url']."'", false); 
			unset($arrWhere['tag_url']);
		}
		
		$this->db->join('kategori', 'kategori.kategori_id = berita.kategori_id', 'left');
		if($limit==0) $result =  $this->getAllRecord($this->db, 'berita', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'berita', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
		
	}
	
	public function getRowBerita($arrOrder=array(), $arrWhere = array()){
		
		//if use Filter Tag
		if(isset($arrWhere['tag_url'])){
			$arrWhere["{ _sql_ } berita_id"] = " berita.berita_id in ( select berita_id from berita_tag inner join  master_tag on master_tag.tag_id = berita_tag.tag_id where master_tag.tag_url ='".$arrWhere['tag_url']."')"; 
			unset($arrWhere['tag_url']);
		}
		$this->db->join('kategori', 'kategori.kategori_id = berita.kategori_id', 'left');
		$result = $this->getRecordRow($this->db, 'berita', $arrOrder, $arrWhere);
		return $result;
		
	}
	
	public function addBerita($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'berita' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'berita' , $arrData);
	}
	
	public function editBerita($arrData=array(), $arrWhere= array()){
		
		$this->editData($this->db, 'berita', $arrData, $arrWhere);
	}
	
	public function deleteBerita($arrWhere = array()){
		
		$this->deleteData($this->db, 'berita', $arrWhere);
	}
	
	
	
	public function getListBeritaTag($arrOrder=array(), $arrWhere = array(), $limit = 0,$offset =0){
		$this->db->select('barita_tag.*, master_tag.tag_url, master_tag.tag_name');
		$this->db->join('master_tag', 'master_tag.tag_id = berita_tag.tag_id', 'left');
		if($limit==0) $result =  $this->getAllRecord($this->db, 'berita_tag', $arrOrder, $arrWhere);
		if($limit>0)  $result =  $this->getLimitRecord($this->db, 'berita_tag', $arrOrder, $arrWhere,$limit,$offset);
		return $result;
	}
	
	public function addBeritaTag($arrData=array(), $batchInsert = false ){
		
		if(!$batchInsert) $this->addData($this->db, 'berita_tag' , $arrData);
		if($batchInsert)  $this->addBatchData($this->db, 'berita_tag' , $arrData);
	}
	
	public function deleteBeritaTag($arrWhere = array()){
		
		$this->deleteData($this->db, 'berita_tag', $arrWhere);
		
	}
	
	 public function editHeadlineOrder($strberita_id, $intOrder = 1){
		$sql = "";
		$intHeadlineOrder = 1;
		
		if ($intOrder == 0){
			
			$sql = "update berita set berita_headline_order= berita_headline_order+1 where berita_headline= '1' ";
			$this->db->query($sql);
			
			$intHeadlineOrder=1;
			$sql = "update berita Set berita_headline_order = ".$intHeadlineOrder."
					Where berita_headline = '1' And berita_id = '".$strberita_id."'";
		}elseif ($intOrder == 1){
			$sql = "UPDATE berita Set berita_headline_order = berita_headline_order - 1
					Where berita_headline = '1' And berita_id = '".$strberita_id."'";
		}elseif ($intOrder == 2){
			$sql = "UPDATE berita Set berita_headline_order = berita_headline_order + 1
					Where berita_headline = '1' And berita_id = '".$strberita_id."'";
		}
		$this->db->query($sql);
		
		if ($intOrder > 0){
			$sql = "select berita_headline_order 
					from berita 
					where berita_headline = '1' And berita_id = '".$strberita_id."'";
			$objberitaHeadLine = $this->db->query($sql)->result();
			if (count($objberitaHeadLine) > 0){
				$intHeadlineOrder = (int)$objberitaHeadLine[0]->berita_headline_order ;
			}
			
			if ($intOrder == 1){
				$sql = "UPDATE berita Set 
							berita_headline_order = berita_headline_order + 1 ";
			}elseif ($intOrder == 2){
				$sql = "UPDATE berita Set 
							berita_headline_order = berita_headline_order - 1 ";
			}
			$sql .= "Where berita_headline = '1'
						 And berita_id <> '".$strberita_id."'
						And berita_headline_order = ".$intHeadlineOrder." ";
			$this->db->query($sql);
		}
	}
    
	
	
	
	
}