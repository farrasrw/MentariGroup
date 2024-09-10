<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MBanner extends MY_Models {

	public function __construct(){
		parent::__construct();
	}
	
    public function getFieldBanner(){
		return $this->getFieldTable($this->db, "banner");
	}
	
	public function getListBanner($arrOrder = array(), $arrWhere = array()){
		return $this->getAllRecord($this->db, "banner", $arrOrder, $arrWhere);
	}
	
	public function addBanner($arrData){
		$this->addData($this->db, "banner", $arrData);
	}
    
	public function editBanner($arrData, $arrWhere = array()){
		$this->editData($this->db, "banner", $arrData, $arrWhere);
	}
	
	public function deleteBanner($arrWhere = array()){
		$this->deleteData($this->db, "banner", $arrWhere);
	}

    
    ////////////////////////////////////////Menggunakan Data Tabel Ajax/////////////////////////////////////////////////////////////
    
    public function getLimitBanner ($arrOrder=array(), $arrWhere= array(), $limit=10, $offset=0){
        return $this->getLimitRecord($this->db,"banner", $arrOrder, $arrWhere, $limit, $offset);
    }
    
    
	public function getRowsBanner(){
		return $this->db->count_all_results('banner');
	}
    
    public function getLimitBannerRow($arrOrder= array(), $arrWhere= array(), $limit=10, $offset=0){
        $this->paramCriteria($this->db,$arrOrder,$arrWhere);
		return $this->db->count_all_results("banner");        
    }
    
}