<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends MY_ThemeController {
	
    public $TempImagePath;
	public $permission = array();
	function __construct(){
		
		parent::__construct();
		
		
		/* 	Set Private Method	*/
		$this->privateMethod = array(
			'index',
			'viewAbout',
		);
		
		/* Permission Admin Check */
		//$this->permission = $this->PermissionAdmin();
		$this->tempAdmin();
        $this->load->model('MAbout','MAbout');
        $this->load->model('MAboutimage','MAboutimage');
		
		$this->TempImagePath='about/Temp/';
		
	}

	
	public function index(){
        
		//$objKategori = $this->MKategori->getListKategori(array(), array());
		//$objTag = $this->MTag->getListTag(array(),array());
		//$arrTag = json_decode(json_encode($objTag),true);
		$arrData['hdnkey']= 'tambahabout';
		$arrData['viewstate']= 'add';
		
		//$arrData['taglist'] = $this->underscore->map($arrTag, function($num) { return $num['tag_name']; }); 
		//$arrData['kategori'] = $objKategori; 
		$arrData['dropkey'] = $this->ffunction->generateRandomString(10);
		$this->load->view('admin/about/add_about',$arrData);	
	}
	
	public function viewAbout(){
		//$objKategori = $this->MKategori->getListKategori(array(), array());
		//$objTag = $this->MTag->getListTag(array(),array());
		//$arrTag = json_decode(json_encode($objTag),true);
		
        $about_id = $this->ffunction->decode( urlencode($this->input->get('about')) );
        
        $objAbout= $this->MAbout->getListAbout(array(),array('about_id' => (int)$about_id));
		
		if(count($objAbout)==1){
			//$arrData['kategori'] = $objKategori; 
			$arrData['hdnkey']= $objAbout[0]->about_id; 
			$arrData['about'] = $objAbout[0];
			//$arrData['taglist'] = $this->underscore->map($arrTag, function($num) { return $num['tag_name']; }); 
			$arrData['dropkey'] = $this->ffunction->generateRandomString(10);
			$this->load->view('admin/about/add_about',$arrData);	
		}
		
	}
	
	public function saveaddabout(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		
		if($key=='' || $key!='tambahabout' ) $valid = false;
        
		$this->_saveabout($valid);
		
	}
	
	public function saveeditabout(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		
		if($key=='' || $key=='tambahabout' ) $valid = false;
        
		$this->_saveabout($valid);
		
	}
	
	function _saveabout($valid=false){
		
		$this->output->unset_template();
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		if($key!= '' && $valid){
            
            $strType= $this->input->post('txtType');
                        
            $strContent= $this->input->post('content_about');
			
			$dropKey 			= $this->input->post('dropkey');
			
			$this->form_validation->set_rules('content_about', 'Content Berita', 'required');
		

			if ($this->form_validation->run() == FALSE)
			{
				
				$arrRes = array(
					'valid'=>false, 
					'message'=>"Maaf Terjadi Kesalahan, Silahkan Periksa Kembali Inputan Anda", 
				);
				echo json_encode($arrRes);
				
			}else{
				
                
                $arrData=array(
                    'about_type' => $strType,
                    'content' => $strContent,
                    
                );
                
				
				if($key=='tambahabout'){
                    
                    $this->MAbout->addAbout($arrData);
                    
                    $objAbout =$this->MAbout->getListAbout(array('about_id' => 'DESC'),array());
                    if(count($objAbout) > 0){
                        
                        $about_id = $objAbout[0]->about_id;
                        $bolvalid =true;
						$Message  ="Data Baru Berhasil di Tambah " ;
                        
                    }else{
						
						$bolvalid = false ; 
						$Message = "Maaf Data Url Sudah Pernah Di Gunakan ";
						
					}
					
				}else{
					
					$about_id  = (int)$key ; 
					$objAbout =$this->MAbout->getListAbout(array(),array('about_id'=>$about_id));
					if(count($objAbout)==1){
				        //echo var_dump($arrData);die();								
						$this->MAbout->editABout($arrData,array('about_id'=>$about_id));
						$bolvalid = true; 
						$Message  = "User Berhasil di Update";
						
					}else{
						
						$bolvalid = false ; 
						$Message  = "Maaf User Tidak Valid, Silahkan Muat Ulang Halamana Anda ";
						
					}
					
				}
				
				if($bolvalid){
					
					$arrPhoto=array();
					$strImagePath = 'about/'.$about_id.'/';
					
					$arrkey = array(); 
					$arrReplace = array();
					
					
					//Image Berita
					$strTempImagePath = $this->TempImagePath.$dropKey.'/';
					$strFilePath = 'media/images/'.$strImagePath;
					$strFilePathGalery = 'media/images/'.$strImagePath.'/galery/';
					
					//create Directory 
					if(!is_dir('./'.$strFilePath)){
						mkdir('./'.$strFilePath, 0777, true); 
					}
					
					//Move Image Content 
					//$strTempFilePath = $strTempImagePath.$dropKey.'/content/';
					$strTempFilePath = 'user/'.$this->userData['UserInitial'].'/upload/';
					$strPathImageContent = $strFilePath.'content/';

					if(is_dir('./media/images/'.$strTempFilePath)){
						$files = scandir('./media/images/'.$strTempFilePath);                 
						if (false!==$files){

							//create Directory 
							if(!is_dir('./'.$strPathImageContent)){
								mkdir('./'.$strPathImageContent, 0777, true); 
							}

							foreach ( $files as $file ){
								if ( '.'!=$file && '..'!=$file) {       
									if (strrpos($file, $dropKey) !== false){
										
										$strNewFile = str_replace($dropKey, "", $file);

										//Save To array
										array_push($arrkey,$file);
										array_push($arrReplace,$strNewFile);
										
										$arrPhotos = array( 'image_name' => $strNewFile , 'image_type'=>2, 'about_id'=>$about_id );
										array_push($arrPhoto, $arrPhotos);

										//Move Image
										rename('./media/images/'.$strTempFilePath.$file, "./".$strPathImageContent.$strNewFile);
									 
									}
								}
							}

							
						 
							//Replace Image Upload Content
							$conten  = $strContent;
							$tmpPath= base_url().'media/images/'.$this->TempImagePath.$dropKey.'/content/';
							$conten = str_replace($arrkey,$arrReplace, $conten);                    
							$strContent = str_replace($strTempFilePath,$strImagePath.'content/',$conten);
							
							
						}
					}

					//Save Edit Berita
					$arrDataEdit['content'] 	  = $strContent;
					
					$arrWhereEdit = array('about_id' => $about_id);
					
					$this->MAbout->editAbout($arrDataEdit, $arrWhereEdit);
					if(count($arrPhoto)>0){
						$this->MAboutimage->addAboutImage($arrPhoto,true);
					}
					
				}
				
				$arrRes = array(
					'valid'=>$bolvalid, 
					'message'=>$Message, 
				);
				
				if($bolvalid) $arrRes['redirect'] = base_url().'admin/about/viewAbout.html?about='.$this->ffunction->encode($about_id); 
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
	
	public function imagemanager($key='', $about_id=''){
		$this->output->unset_template();
		$arrData['dropkey'] = $key;
		$imgupload = array();
		$imgdb	   = array();
		
		if($about_id!=''){
			$objPhotoItem = $this->MAbout->getListAboutImage(array(), array('about_id'=>$about_id));
			$strNewPath = './media/images/about/'.$about_id."/content/" ;
			if (Count($objPhotoItem) > 0) {	
				$strItemId = $about_id; 
				foreach ($objPhotoItem as $objPhoto) {
					if (file_exists($strNewPath.$objPhoto->image_name)){
						$imgName =  $objPhoto->image_name;
						if( strlen($imgName) > 20 ){
							$t = strlen($imgName)-20;
							$imgName =  substr($imgName,0,strlen($imgName)-10-$t).'..'.substr($imgName,-8);
						}
						$imgdb[] = array(
									'path'=>'media/images/about/'.$about_id."/content/".$objPhoto->image_name,
									'fullpath'=>base_url().'media/images/about/'.$about_id."/content/".$objPhoto->image_name,
									'name'=>$imgName
								 );
					}
				}
			}
		}
		
		if(is_dir('./media/images/user/'.$this->userData['UserInitial'].'/upload/')){
			$files = scandir('./media/images/user/'.$this->userData['UserInitial'].'/upload/');                 
			if (false!==$files){
				foreach ( $files as $file ){
					if ( '.'!=$file && '..'!=$file) {       
						if (strrpos($file, $key) !== false){
							
							$imgName =  str_replace($key,'',$file);	
							if( strlen($imgName) > 20 ){
								$t = strlen($imgName)-20;
								$imgName =  substr($imgName,0,strlen($imgName)-10-$t).'..'.substr($imgName,-8);
							}
							$imgupload[] = array(
										'path'=>'media/images/user/'.$this->userData['UserInitial'].'/upload/'.$file,
										'fullpath'=>base_url().'media/images/user/'.$this->userData['UserInitial'].'/upload/'.$file,
										'name'=>$imgName
									 );
						}
					}
				}
			}
		}
		
		$arrData['imgdb'] = $imgdb;
		$arrData['imgupload'] = $imgupload;
				
		
		$this->load->view('web/include/imagemanager', $arrData);
	}

	public function removphotoconten(){
			$this->output->unset_template();
		$imgPath = $this->input->post('path');
		if(file_exists('./'.$imgPath)){
			unlink('./'.$imgPath);
			$res = array(
				'valid'=>true
			);
			echo json_encode($res);
		}else{
			$res = array(
				'valid'=>false,
				'message'=>'Maaf Image Tidak Valid '
			);
			echo json_encode($res);
		}

	}
    
    public function deleteabout(){
		
		$about_id=urlencode(($this->input->get('about')));
		$about_id  = $this->ffunction->decode($about_id);
		if(!empty($about_id)){
			$objAbout = $this->MAbout->getListAbout(array(),array('about_id'=>(int)$about_id));
			if(count($objAbout)==1){
				$this->MAbout->deleteAbout(array('about_id'=>$about_id));
				echo '<script>alert("About Berhasil di Hapus");window.location.href = "'.base_url().'admin/about/index.html";</script>';
			}else{
				echo '<script>alert("Maaf About Tidak di Temukan");window.location.href = "'.base_url().'admin/about/index.html";</script>';

			}
		}
		
	}
    
    public function listaboutdata(){
		$arrWhere =array();
		$arrField = array("about_id","about_type");
		
		//search
        //if($this->input->post('LabelName')!='') $arrhere['LabelName'] = '%'.$this->input->post('LabelName');
		
		//Order
		$strField = $arrField[(int)$this->input->post('iSortCol_0')];
		$arrOrder[$strField] = $this->input->post('sSortDir_0');
		
		//Limit & offset
		$intLimit  = $_POST['iDisplayLength'];
		$intOffset = $_POST['iDisplayStart'];
        
        $arrData = $this->MAbout->getListAbout($arrOrder, $arrWhere, $intLimit, $intOffset);
        $intRows = $this->MAbout->getRowAbout($arrOrder, $arrWhere);
		$iTotal  = $this->MAbout->getRowAbout();
        
		$arrValue = array();
		$arrAll   = array();
        
		$iFilteredTotal = $intRows;
		foreach($arrData as $objkategori){
			$arrValue = array();
			$arrData  = $this->converter->objectToArray($objkategori);
            
            foreach($arrField as $strValue){
				switch ($strValue) {
                        
                    case"about_type":
                        if($arrData[$strValue]==0){
						  array_push($arrValue, ("Latar belakang"));
                        }elseif($arrData[$strValue]==1){
                          array_push($arrValue, ("Visi"));
                        }elseif($arrData[$strValue]==2){
                          array_push($arrValue, ("Nilai perusahaan"));  
                        }elseif($arrData[$strValue]==3){
                          array_push($arrValue, ("Struktur Organisasi"));  
                        }elseif($arrData[$strValue]==4){
                          array_push($arrValue, ("Dewan & Holdin"));  
                        }elseif($arrData[$strValue]==5){
                          array_push($arrValue, ("Anak Perusahaan"));  
                        }elseif($arrData[$strValue]==6){
                          array_push($arrValue, ("Misi"));  
                        }elseif($arrData[$strValue]==7){
                          array_push($arrValue, ("Misi"));  
                        }
                        
					break;
					
					default : array_push($arrValue, $arrData[$strValue]);
				}
			}
			
			array_push($arrValue, 
					   "<center>
                       <a href=\"".base_url()."admin/about/viewAbout.html?about=".$this->ffunction->encode($objkategori->about_id)."\" title=\"Edit\"><img src=\"".base_url()."style/admin/images/edit.png\" /></a> &nbsp;
                       <a href=\"".base_url()."admin/about/deleteabout.html?about=".$this->ffunction->encode($objkategori->about_id)."\" title=\"Delete\"><img src=\"".base_url()."style/admin/images/delete.png\" onclick=\"return confirm('Anda ingin menghapus data tersebut?')\" /></a>
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
    
    /*public function simpleAboutData(){
        $this->load->model('MAbout','MAbout');
        
        $ObjData= $this->MAbout->getListAbout(array(),array());
        
        echo '<pre>'; print_r($ObjData); echo '</pre>';
        die();
    }*/
    
    public function simpleAboutData(){
        $this->load->model('MAbout', 'MAbout');
        
        $ObjData= $this->MAbout->getListAbout(array(),array());
        
        echo '<pre>'; print_r($objData);echo '</pre>';
    }
	
}