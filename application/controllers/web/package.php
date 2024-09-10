<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); 
class Package extends MY_ThemeController {
	
	function __construct(){
		parent::__construct();
		$this->load->library('underscore');
        $this->load->model('MBanner','MBanner');
        $this->load->model('Mberita','MBerita');
		$this->load->model('Mtag','MTag');
		$this->load->model('Mkategori','MKategori');
		$this->load->model('Mberitaimage','MBeritaimage');
        
        $this->load->model('Mproject','MProject');
        
        $this->tempHome();        
    }
    
    
    function index(){
        
        //Banner Home
		$arrOrder = array("banner_id" => "ASC");
		$arrWhere = array("banner_status" => 0, "banner_schedule <=" => date("Y-m-d H:i:s"),"banner_scheduleoff >" => date("Y-m-d H:i:s"));
		$objDataBanner = $this->MBanner->getListBanner($arrOrder, $arrWhere);
                
        $arrData['banner'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'package-banner'; }));
        
        $objproject = $this->MProject->getListproject(array(),array());
        
        $arrData['package']=$objproject;
                
                
        $this->load->view('web/package', $arrData);
    }
}