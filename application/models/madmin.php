<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MAdmin extends MY_Models {

	public function __construct(){
		parent::__construct();
	}
	
    public function getFieldAdmin(){
		return $this->getFieldTable($this->db, "UserAdmin");
	}
	
	public function getListAdmin($arrOrder = array(), $arrWhere = array()){
		return $this->getAllRecord($this->db, "UserAdmin", $arrOrder, $arrWhere);
	}
	
	public function addAdmin($arrData){
		$this->addData($this->db, "UserAdmin", $arrData);
	}
    
	public function editAdmin($arrData, $arrWhere = array()){
		$this->editData($this->db, "UserAdmin", $arrData, $arrWhere);
	}
	
	public function deleteAdmin($arrWhere = array()){
		$this->deleteData($this->db, "UserAdmin", $arrWhere);
	}

    
    ////////////////////////////////////////Menggunakan Data Tabel Ajax/////////////////////////////////////////////////////////////
    
    public function getLimitAdmin ($arrOrder=array(), $arrWhere= array(), $limit=10, $offset=0){
        return $this->getLimitRecord($this->db,"UserAdmin", $arrOrder, $arrWhere, $limit, $offset);
    }
    
    
	public function getRowsAdmin(){
		return $this->db->count_all_results('UserAdmin');
	}
    
    public function getLimitAdminRow($arrOrder= array(), $arrWhere= array(), $limit=10, $offset=0){
        $this->paramCriteria($this->db,$arrOrder,$arrWhere);
		return $this->db->count_all_results("UserAdmin");        
    }
    
}