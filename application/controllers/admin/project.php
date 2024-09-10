<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends MY_ThemeController {

	function __construct()	{
		parent::__construct();
		
		
		/* 	Set Private Method	*/
		$this->privateMethod = array(
			'index',
			'saveaddproject',
			'saveeditproject',
			'deleteproject',
		);
		
		/* Permission Admin Check */
		//$this->PermissionAdmin();
		$this->tempAdmin();
		$this->load->model('mproject','MProject');
	}
	
	
	
	public function index(){
		//echo $userd = $this->userData['UserId'].'-'.$this->userData['UserInitial'];;die();
		$arrData['hdnkey']= date('Y-m-d').'-tambahproject'; 
		$arrData['viewstate']='add';
		$this->load->view('admin/project/add_project',$arrData);
		
	}
	
	public function saveaddproject(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		
		if($key=='' || $key!=date('Y-m-d').'-tambahproject' ) $valid = false;
		$this->_saveproject($valid);
		
	}
	
	public function saveeditproject(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		        
		if($key=='' || $key==date('Y-m-d').'-tambahproject' ) $valid = false;
		$this->_saveproject($valid);
		
	}
	
	public function deleteproject(){
		
		$projectId=urlencode(($this->input->get('project')));
		$projectId  = $this->ffunction->decode($projectId);
		if(!empty($projectId)){
			$objproject = $this->MProject->getListproject(array(),array('project_id'=>(int)$projectId));
			if(count($objproject)==1){
				$this->MProject->deleteproject(array('project_id'=>$projectId));
				echo '<script>alert(" project Berhasil di Hapus");window.location.href = "'.base_url().'admin/project/index.html";</script>';
			}else{
				echo '<script>alert("Maaf project Tidak di Temukan");window.location.href = "'.base_url().'admin/project/index.html";</script>';

			}
		}
		
	}
	
	function _saveproject($valid=false){
		
		$this->output->unset_template();
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		if($key!= '' && $valid){
			
			$projectName 	= $this->input->post('projectname');
			$projectUrl 	= $this->input->post('projecturl');
            $projectcontent= $this->input->post('projectcontent');
			$projectUrl 	= $this->ffunction->fUrlEncoder((!empty($projectUrl )?$projectUrl:$projectName));

			$this->form_validation->set_rules('projectname', 'Nama project', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				
				$arrRes = array(
					'valid'=>false, 
					'message'=>"Inputan Belum Benar, Silahkan Periksa Kembali Inputan Anda", 
				);
				echo json_encode($arrRes);
				
			}else{
				
				$arrData = array(
					'project_name'=>$projectName,
                    'project_content' => $projectcontent
				);
				$arrData['project_url'] = $projectUrl;
                

				if($key==date('Y-m-d').'-tambahproject'){
					
					
					$userd = $this->userData['UserId'].'-'.$this->userData['UserInitial'];
					$this->MProject->addproject($arrData);
					$objproject = $this->MProject->getListproject(array(),array('project.project_name'=>$projectName, 'project.createby'=>$userd));
                    
                    //echo var_dump($objproject);die();
                    
					if(count($objproject)==1){

						$projectId = $objproject[0]->project_id;
						$bolvalid 	 = true;
						$Message  	 = "project Baru Berhasil di Tambah " ; 
						
					}else{

						$bolvalid =false;
						$Message ="Maaf Terjadi Kesalahan Saat Menambah project Baru.. ";
						
					}
					
					
				}else{
					
					$projectId  = (int)$key ; 
					$objproject = $this->MProject->getListproject(array(),array('project_id'=>$projectId));
                    
					if(count($objproject)==1){
						
						$this->MProject->editproject($arrData,array('project_id'=>$projectId));
						$bolvalid = true; 
						$Message  = "project Berhasil di Update";
						
					}else{
						
						$bolvalid = false ; 
						$Message  = "Maaf project Tidak Valid, Silahkan Muat Ulang Halamana Anda ";
					}
					
				}
				
				$arrRes = array(
					'valid'=>$bolvalid, 
					'message'=>$Message,
                    'redirect' => base_url().'admin/project/index.html',
				);
				
				echo json_encode($arrRes);die();

			}

		}else{
			$arrRes = array(
					'valid'=>false, 
					'message'=>"Maaf Terjadi Kesalahan, Permintaan Tidak Valid . Silahkan Muat Ulang Halaman ini", 
			);
			echo json_encode($arrRes);
		}
		
	}	
	
	public function listprojectdata(){
		
		$arrWhere =array();
		$arrField = array("project_id","project_name");
		
		//search
        if($this->input->post('LabelName')!='') $arrhere['LabelName'] = '%'.$this->input->post('LabelName');
		
		//Order
		$strField = $arrField[(int)$this->input->post('iSortCol_0')];
		$arrOrder[$strField] = $this->input->post('sSortDir_0');
		
		//Limit & offset
		$intLimit  = $_POST['iDisplayLength'];
		$intOffset = $_POST['iDisplayStart'];
		
		//Get Data From database
        $arrData = $this->MProject->getListproject($arrOrder, $arrWhere, $intLimit, $intOffset);
        //echo var_dump($arrData);die();
        $intRows = $this->MProject->getRowproject($arrOrder, $arrWhere);
		$iTotal  = $this->MProject->getRowproject();
        
		$arrValue = array();
		$arrAll   = array();
        
		$iFilteredTotal = $intRows;
		foreach($arrData as $objproject){
			$arrValue = array();
			$arrData  = $this->converter->objectToArray($objproject);
            
            foreach($arrField as $strValue){
				switch ($strValue) {
					
					default : array_push($arrValue, $arrData[$strValue]);
				}
			}
			
			array_push($arrValue, 
					   "<center>
                       <a href=\"#\" onclick=\"editproject('".$this->ffunction->encode($objproject->project_id)."','".$objproject->project_name."')\" title=\"Edit\"><img src=\"".base_url()."style/admin/images/edit.png\" /></a> &nbsp;
                       <a href=\"".base_url()."admin/project/deleteproject.html?project=".$this->ffunction->encode($objproject->project_id)."\" title=\"Delete\"><img src=\"".base_url()."style/admin/images/delete.png\" onclick=\"return confirm('Anda ingin menghapus data tersebut?')\" /></a>
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