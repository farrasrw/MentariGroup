<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Dashboard extends CI_Controller {
		
	public function __construct(){
		parent::__construct();
    
        $this->load->model('madmin', 'MAdmin');
		$this->load->helper('url');	
	}

	public function index(){	
		$this->load->view('admin/vloginadmin');
	}
	
    public function cekLogin(){
		if($this->input->post('btn_login') == "Login"){
			$username = $this->input->post('user');
			$password = $this->input->post('pass');

			$arrWhere['AdminEmail']=$username;
			$arrWhere['AdminPass']= $password;
            $objAdmin = $this->MAdmin->getListAdmin(array(), $arrWhere);
            
            
            
			if (count($objAdmin) > 0 ){
                $strAdminId		= $objAdmin[0]->AdminId;
				$strUsername 	= $objAdmin[0]->AdminEmail;
				$strStatus 		= $objAdmin[0]->AdminSts;
                $strNamaAdmin 	= $objAdmin[0]->AdminName;
                $strGroupId 	= $objAdmin[0]->AdminGroupId;
                
                //delete Session Merchant
                if($this->session->userdata('isLoginMerchant')) $this->session->unset_userdata('isLoginMerchant');
                
				//Set Session
                $this->session->set_userdata('UserId', $strAdminId);
                $this->session->set_userdata('AdminName', $strNamaAdmin);
                $this->session->set_userdata('UserInitial', $strNamaAdmin);
                $this->session->set_userdata('Email', $strUsername);
                $this->session->set_userdata('AdminGroupId', $strGroupId);
                $this->session->set_userdata('isLogin', $strStatus);
                $this->session->set_userdata('tempView','admin');
                //Set Session
                $this->session->set_userdata('UserFullName', $strNamaAdmin);
                $this->session->set_userdata('GroupLevel', $strGroupId);
                //$this->session->set_userdata('isLogin', $objUser[0]->user_status);
                
                
                if ($strStatus == '1')
				{
					redirect('admin/menu');
                     $this->strLoginAs = 'admin';
				}
                
				else if ($strStatus == '2')
				{
					echo '<script> alert("Sorry, you were disable");
						location = "'.site_url('dashboard').'";
				  	</script>';
				}
			}else{
				echo '<script> alert("Wrong Username and Password Combination. Please Try Again");
      			location = "'.site_url('dashboard').'";
      			</script>';  
			}
		}
	}
}