<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Menu extends MY_ThemeController {

	function __construct(){
		parent::__construct();
        
        $this->load->model('madmin','MAdmin');
		$this->tempAdmin();
	}

	public function logout(){
		$this->session->unset_userdata('isLogin');
        $this->session->unset_userdata('UserId');
        $this->session->unset_userdata('AdminName');
		$this->session->unset_userdata('Email');
        $this->session->unset_userdata('AdminGroupId');
        
        $this->session->unset_userdata('isLoginMerchant');
		$this->session->unset_userdata('EmailMerchant');
		$this->session->unset_userdata('NamaMerchant');
		$this->session->unset_userdata('isLoginMerchant');
        $this->session->unset_userdata('MerchantId');
    
        //$this->session->unset_userdata('tempView');
		redirect('dashboard');
	}

	public function index(){
		$this->load->view('admin/vcontent');
	}

	public function wrong(){
		$this->load->view('admin/v404');	
	}
    
    public function profile(){
        /*$strUsername=$this->session->userdata('karyawan_nama');
        $arrWhere['karyawan_nama']=$strUsername;*/
        
        $strAdminName= $this->session->userdata('AdminName');
        $arrWhere['AdminName']= $strAdminName;
        //echo var_dump($arrWhere);die();
        $arrData['admin'] = $this->MAdmin->getListAdmin(array(), $arrWhere);
        //echo var_dump($arrData);die();
        
		$this->load->view('admin/vprofile',$arrData);
	}
	
}