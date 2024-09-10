<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MKategoriInventory extends MY_Models {

	public function __construct(){
		parent::__construct();
	}
	
    public function getFieldKategoriInvent(){
        
		return $this->getFieldTable($this->db,  "inventtablekategori");
	}
	
    public function getParent(){
        $this->db->select('parentid');
        $this->db->group_by("parentid"); 
        return $this->getAllRecord($this->db,  "inventtablekategori", array(), array());
    }
    
	public function getListKategoriInvent($arrOrder = array(), $arrWhere = array()){
        $this->db->select('inventtablekategori.*, inventtableparent.kategoriname as parentname, inventtableparent.kategorinameurl as parentnameurl');
        $this->db->join('inventtablekategori inventtableparent','inventtableparent.kategoriid=inventtablekategori.parentid','left');
		return $this->getAllRecord($this->db,  "inventtablekategori", $arrOrder, $arrWhere);
	}
    
    public function getLimitKategoriInvent ($arrOrder=array(), $arrWhere= array(), $limit=10, $offset=0){
        $this->db->select('inventtablekategori.*,inventtableparent.kategoriname as parentname');
        $this->db->join('inventtablekategori inventtableparent','inventtableparent.kategoriid=inventtablekategori.parentid','left');
        return $this->getLimitRecord($this->db, "inventtablekategori", $arrOrder, $arrWhere, $limit, $offset);
    }
	
	public function addKategoriInvent($arrData){
		$this->addData($this->db,  "inventtablekategori", $arrData);
	}
    
	public function editKategoriInvent($arrData, $arrWhere = array()){
		$this->editData($this->db,  "inventtablekategori", $arrData, $arrWhere);
	}
	
	public function deleteKategoriInvent($arrWhere = array()){
		$this->deleteData($this->db,  "inventtablekategori", $arrWhere);
	}
    
    
	public function getRowsKategoriInvent(){
		return $this->db->count_all_results("inventtablekategori");
	}
    
    public function getLimitKategoriInventRow($arrOrder= array(), $arrWhere= array(), $limit=10, $offset=0){
        $this->paramCriteria($this->db, $arrOrder,$arrWhere);
		return $this->db->count_all_results("inventtablekategori");        
    }
}