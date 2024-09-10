<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kategori extends MY_ThemeController {

	function __construct()	{
		parent::__construct();
		
		
		/* 	Set Private Method	*/
		$this->privateMethod = array(
			'index',
			'saveaddkategori',
			'saveeditkategori',
			'deletekategori',
		);
		
		/* Permission Admin Check */
		//$this->PermissionAdmin();
		$this->tempAdmin();
		$this->load->model('Mkategori','MKategori');
	}
	
	
	
	public function index(){
		//echo $userd = $this->userData['UserId'].'-'.$this->userData['UserInitial'];;die();
		$arrData['hdnkey']= date('Y-m-d').'-tambahkategori'; 
		$arrData['viewstate']='add';
		$this->load->view('admin/kategori/add_kategori',$arrData);
		
	}
	
	public function saveaddkategori(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		
		if($key=='' || $key!=date('Y-m-d').'-tambahkategori' ) $valid = false;
		$this->_savekategori($valid);
		
	}
	
	public function saveeditkategori(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		
		if($key=='' || $key==date('Y-m-d').'-tambahkategori' ) $valid = false;
		$this->_savekategori($valid);
		
	}
	
	public function deletekategori(){
		
		$kategoriId=urlencode(($this->input->get('kategori')));
		$kategoriId  = $this->ffunction->decode($kategoriId);
		if(!empty($kategoriId)){
			$objkategori = $this->MKategori->getListKategori(array(),array('kategori_id'=>(int)$kategoriId));
			if(count($objkategori)==1){
				$this->MKategori->deleteKategori(array('kategori_id'=>$kategoriId));
				echo '<script>alert(" Kategori Berhasil di Hapus");window.location.href = "'.base_url().'admin/kategori/index.html";</script>';
			}else{
				echo '<script>alert("Maaf Kategori Tidak di Temukan");window.location.href = "'.base_url().'admin/kategori/index.html";</script>';

			}
		}
		
	}
	
	function _savekategori($valid=false){
		
		$this->output->unset_template();
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		if($key!= '' && $valid){
			
			$kategoriName 	= $this->input->post('kategoriname');
			$kategoriUrl 	= $this->input->post('kategoriurl');
			$kategoriUrl 	= $this->ffunction->fUrlEncoder((!empty($kategoriUrl )?$kategoriUrl:$kategoriName));

			$this->form_validation->set_rules('kategoriname', 'Nama kategori', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				
				$arrRes = array(
					'valid'=>false, 
					'message'=>"Inputan Belum Benar, Silahkan Periksa Kembali Inputan Anda", 
				);
				echo json_encode($arrRes);
				
			}else{
				
				$arrData = array(
					'kategori_name'=>$kategoriName,
				);
				$arrData['kategori_url'] = $kategoriUrl;

				if($key==date('Y-m-d').'-tambahkategori'){
					
					
					$userd = $this->userData['UserId'].'-'.$this->userData['UserInitial'];
					$this->MKategori->addKategori($arrData);
					$objkategori = $this->MKategori->getListKategori(array(),array('kategori.kategori_name'=>$kategoriName, 'kategori.createby'=>$userd));
                    
                    //echo var_dump($objkategori);die();
                    
					if(count($objkategori)==1){

						$kategoriId = $objkategori[0]->kategori_id;
						$bolvalid 	 = true;
						$Message  	 = "kategori Baru Berhasil di Tambah " ; 
						
					}else{

						$bolvalid =false;
						$Message ="Maaf Terjadi Kesalahan Saat Menambah kategori Baru.. ";
						
					}
					
					
				}else{
					
					$kategoriId  = (int)$key ; 
					$objkategori = $this->MKategori->getListKategori(array(),array('kategori_id'=>$kategoriId));
					if(count($objkategori)==1){
						
						$this->MKategori->editKategori($arrData,array('kategori_id'=>$kategoriId));
						$bolvalid = true; 
						$Message  = "Kategori Berhasil di Update";
						
					}else{
						
						$bolvalid = false ; 
						$Message  = "Maaf Kategori Tidak Valid, Silahkan Muat Ulang Halamana Anda ";
					}
					
				}
				
				$arrRes = array(
					'valid'=>$bolvalid, 
					'message'=>$Message, 
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
	
	public function listkategoridata(){
		
		$arrWhere =array();
		$arrField = array("kategori_id","kategori_name");
		
		//search
        if($this->input->post('LabelName')!='') $arrhere['LabelName'] = '%'.$this->input->post('LabelName');
		
		//Order
		$strField = $arrField[(int)$this->input->post('iSortCol_0')];
		$arrOrder[$strField] = $this->input->post('sSortDir_0');
		
		//Limit & offset
		$intLimit  = $_POST['iDisplayLength'];
		$intOffset = $_POST['iDisplayStart'];
		
		//Get Data From database
        $arrData = $this->MKategori->getListKategori($arrOrder, $arrWhere, $intLimit, $intOffset);
        //echo var_dump($arrData);die();
        $intRows = $this->MKategori->getRowKategori($arrOrder, $arrWhere);
		$iTotal  = $this->MKategori->getRowKategori();
        
		$arrValue = array();
		$arrAll   = array();
        
		$iFilteredTotal = $intRows;
		foreach($arrData as $objkategori){
			$arrValue = array();
			$arrData  = $this->converter->objectToArray($objkategori);
            
            foreach($arrField as $strValue){
				switch ($strValue) {
					
					default : array_push($arrValue, $arrData[$strValue]);
				}
			}
			
			array_push($arrValue, 
					   "<center>
                       <a href=\"#\" onclick=\"editkategori('".$this->ffunction->encode($objkategori->kategori_id)."','".$objkategori->kategori_name."')\" title=\"Edit\"><img src=\"".base_url()."style/admin/images/edit.png\" /></a> &nbsp;
                       <a href=\"".base_url()."admin/kategori/deletekategori.html?kategori=".$this->ffunction->encode($objkategori->kategori_id)."\" title=\"Delete\"><img src=\"".base_url()."style/admin/images/delete.png\" onclick=\"return confirm('Anda ingin menghapus data tersebut?')\" /></a>
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