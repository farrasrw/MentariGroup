<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class Admin extends MY_ThemeController {

	function __construct(){
		parent::__construct();
		
        $this->load->model('madmin','MAdmin');
        
		$this->tempAdmin();
	}
    
    public function index(){
        $this->load->view('admin/admin/vadminlist');
    }
    
    public function addAdmin(){
        $FieldAdmin = $this->MAdmin->getFieldAdmin();
        $arrData = $this->converter->objectToArray($FieldAdmin);
        
        $arrOrder = array('AdminId'=>'DESC');
        $objAdmin = $this->MAdmin->getListAdmin($arrOrder, array());
        $strKode = (int)substr($objAdmin[0]->AdminId, -5); 
        
        $strTambah = $strKode + 1;
		$strAdminId = "ADM".substr("0000".$strTambah, -5);
		
        $arrData['Kode'] = $strAdminId;
        $arrData["DropKey"] = $this->imageloader->generateRandomString();
		$arrData["Key"] = "Admin";
		
		$this->load->view('admin/admin/vaddadmin',$arrData);    
	}
    
    public function saveAdmin(){
        $strKey = $this->encrypt->decode($this->input->post('hdnKey'));
		$strDropKey = $this->input->post('dropkey');
		$bolValid = false;
        
        $strMessage = "";
        $strAdminId		= $this->input->post('txtAdminID');
        $strNama 		= $this->input->post('txtNama');
        $strUsername	= $this->input->post('txtUsername');
        $strPassword 	= $this->input->post('txtPassword');
        $strStatus 		= $this->input->post('txtStatus');
        $strGroupId 	= $this->input->post('txtGroupId');
        
        $data = array(
				'AdminId' => $strAdminId,
				'AdminEmail' => $strUsername,
				'AdminPass' => $strPassword,
				'AdminName' => $strNama,
				'AdminSts' => $strStatus,
				'AdminGroupId' => $strGroupId,
            );
        
		$arrData["DropKey"] = $strDropKey;
		$arrData["Key"] = $strAdminId;
        
        if($strKey == "Admin"){
			$bolValid = true;
		}else{
			$arrWhere = array('AdminId' => $strKey);
			$arrAdmin = $this->MAdmin->getListAdmin(array(), $arrWhere);
            
			if (count($arrAdmin) > 0){	
				$bolValid = true;
				$strAdminId = $strKey;
				$data['AdminId'] = $strAdminId;
				//Set Data for view
				$arrData["Admin"] = $arrAdmin[0];				
			}
		}
		
		if ($bolValid){
			//Validation
			$this->form_validation->set_rules('txtNama', 'AdminEmail', 'required');

			if ($this->form_validation->run() == FALSE){				
				echo '<script> alert("Please check your form again.");</script>';

				$this->load->view('admin/admin/vadminlist', $data);
			}else{
				//Saving Data
				$data['AdminId'] = $strAdminId;			
				if($strKey == "Admin"){
					$this->MAdmin->addAdmin($data);
					$strMessage = "Data has been add";
				}else{
					$strAdminId = $strKey;
					$arrWhere = array('AdminId' => $strKey);
					$this->MAdmin->editAdmin($data, $arrWhere);
					$strMessage = "Data has been edit";
				}
				
				echo '<script>
						alert("'.$strMessage.'");
						location = "'.site_url('admin/admin').'";
					</script>'; 
			}
		}else{
			//Redirect To Home
            echo '<script>location = "'.site_url('admin/admin').'";</script>'; 
        }
    }

    function editAdmin($admin_id){
		$arrData = $this->MAdmin->getFieldAdmin();
        
		$arrOrder["AdminId"] = "DESC";
		$arrData['data'] = $this->MAdmin->getListAdmin($arrOrder, array());

		if (count($arrData['data']) > 0){
			foreach($arrData['data'] as $arrAdmin){
				if ($arrAdmin->AdminId == $admin_id){
					foreach ($arrAdmin as $strField => $strValue){
						$arrData[$strField] = $strValue;
					}
				}
			}
		}
        
        $objAdmin=$this->MAdmin->getListAdmin(array(), array('AdminId'=>$admin_id));
        $arrData['Kode']= $objAdmin[0]->AdminId;
        $arrData["DropKey"] = $this->imageloader->generateRandomString();
        $arrData["Key"] = $admin_id;
        
		$this->load->view('admin/admin/vaddadmin', $arrData);
	}
    
    
    function deleteAdmin($admin_id){
        $arrWhere=array('AdminId'=>$admin_id);
		$this->MAdmin->deleteAdmin($arrWhere);
		redirect('admin/admin');
     }
    
    public function listAdmin(){
		$arrWhere = array();
		$arrLike = array();
		$arrField = array("AdminName","AdminEmail","AdminSts");

		//search
        if($this->input->post('AdminName')!='') $arrWhere['AdminName'] ='%'.$this->input->post('AdminName');
		
		//Order
		$strField = $arrField[(int)$this->input->post('iSortCol_0')];
		$arrOrder[$strField] = $this->input->post('sSortDir_0');

		//Limit & offset
		$intLimit = $_POST['iDisplayLength'];
		$intOffset = $_POST['iDisplayStart'];
		
		//Get Data From database
        $arrOrder['AdminId'] = "DESC";
		$arrData = $this->MAdmin->getLimitAdmin($arrOrder, $arrWhere,$intLimit, $intOffset, $arrLike);
		$intRows = $this->MAdmin->getLimitAdminRow($arrOrder, $arrWhere, $arrLike);
		$iTotal = $this->MAdmin->getRowsAdmin();
        
		$arrValue = array();
		$arrAll = array();
        
		$iFilteredTotal = $intRows;
		foreach($arrData as $objAdmin){
			$arrValue = array();
			$arrAdmin = $this->converter->objectToArray($objAdmin);
            
            foreach($arrField as $strValue){
				switch ($strValue) {
                    case "AdminSts":
                        if($arrAdmin[$strValue] == 1){
                            array_push($arrValue,"Active");
                        }else{
                            array_push($arrValue,"Non Active");
                        }
                    break;
                    
					default : array_push($arrValue, $arrAdmin[$strValue]);
				}
			}
            
			array_push($arrValue, 
					   "<center>
                       <a href=\"".base_url()."admin/admin/editAdmin/".$objAdmin->AdminId."\" title=\"Edit\"><img src=\"".base_url()."style/admin/images/edit.png\" /></a> &nbsp;
                       <a href=\"".base_url()."admin/admin/deleteAdmin/".$objAdmin->AdminId."\" title=\"Delete\"><img src=\"".base_url()."style/admin/images/delete.png\" onclick=\"return confirm('Anda ingin menghapus data tersebut?')\" /></a>

                       </center>");

			array_push($arrAll, $arrValue);
		}

		//Create Json For DataTables
		$output = array(
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => $arrAll
		);

		echo json_encode($output);
		die();
	}
}