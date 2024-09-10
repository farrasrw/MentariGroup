<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends MY_ThemeController {
	
    public $TempImagePath;
	public $permission = array();
	function __construct(){
		
		parent::__construct();
		
		
		/* 	Set Private Method	*/
		$this->privateMethod = array(
			'index',
			'viewberita',
			'addberita',
			'saveedituser',
			'saveeditberita',
			'saveaddberita',
			'listuserdata',
			'deleteheadline',
			'addheadline',
			'changeorder',
			'headline',
			'approveberita',
		);
		
		/* Permission Admin Check */
		//$this->permission = $this->PermissionAdmin();
		$this->tempAdmin();
		$this->load->model('Mberita','MBerita');
		$this->load->model('Mtag','MTag');
		$this->load->model('Mkategori','MKategori');
		$this->load->model('Mberitaimage','MBeritaimage');
		
		$this->TempImagePath='berita/Temp/';
		
	}
	
	public function index(){
		
		$this->load->view('admin/berita/list_berita');		
		
	}
	
	public function headline(){
		
		$this->load->view('admin/berita/list_headline');			
	}
	
	public function uploadimage(){
		
		$this->output->unset_template();
        $key = $this->input->post('uploadkey');		
        $typeupload = $this->input->post('uploadtype');	
		
		if(!empty($key)){
		
			
			$strImagePath = 'berita/Temp/'.$key.'/';
			
			if($typeupload=="contentimage") $strImagePath = 'user/'.$this->userData['UserInitial'].'/upload/';
			
			
			$arrResult = $this->imageloader->UploadImage($strImagePath,"fileimg",$key.$_FILES['fileimg']['name']);

			//Check Upload
			if (!$arrResult['Valid']){
				$arrData=array(
					'valid'=>false,
					'message'=>$arrResult["Message"]
				);
				echo json_encode($arrData);
			}else{  
				$arrData=array(
					'valid'=>true,
					'filename'=>$arrResult['FileName'],
					'path'=>base_url().$arrResult['FilePath'].$arrResult['FileName'],
					'shortpath'=>$arrResult['FilePath'].$arrResult['FileName']
				);
				echo json_encode($arrData);
			}
		}else{
			
			$arrData=array(
					'valid'=>false,
					'message'=>'Upload Gagal'
				);
				echo json_encode($arrData);
		}
		
		
	}
	
	public function addBerita(){
		
		$objKategori = $this->MKategori->getListKategori(array(), array());
		$objTag = $this->MTag->getListTag(array(),array());
		$arrTag = json_decode(json_encode($objTag),true);
		$arrData['hdnkey']= 'tambahberita';
		$arrData['viewstate']= 'add';
		
		$arrData['taglist'] = $this->underscore->map($arrTag, function($num) { return $num['tag_name']; }); 
		$arrData['kategori'] = $objKategori; 
		$arrData['dropkey'] = $this->ffunction->generateRandomString(10);
		$this->load->view('admin/berita/add_berita',$arrData);
		
		
		
		
	}
	
	public function viewBerita(){
		$objKategori = $this->MKategori->getListKategori(array(), array());
		$objTag = $this->MTag->getListTag(array(),array());
		$arrTag = json_decode(json_encode($objTag),true);
		$beritaid = $this->ffunction->decode( urlencode($this->input->get('berita')) );
		$objBerita = $this->MBerita->getListBerita(array(),array('berita_id'=>(int)$beritaid));
		
		if(count($objBerita)==1){
			$arrData['kategori'] = $objKategori; 
			$arrData['hdnkey']= $objBerita[0]->berita_id; 
			$arrData['berita'] = $objBerita[0];
			$arrData['taglist'] = $this->underscore->map($arrTag, function($num) { return $num['tag_name']; }); 
			$arrData['dropkey'] = $this->ffunction->generateRandomString(10);
			$this->load->view('admin/berita/add_berita',$arrData);	
		}
		
	}
	
	public function saveaddberita(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		
		if($key=='' || $key!='tambahberita' ) $valid = false;
		$this->_saveberita($valid);
		
	}
	
	public function saveeditberita(){
		
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		$valid 	= true;
		
		if($key=='' || $key=='tambahberita' ) $valid = false;
		$this->_saveberita($valid);
		
	}
	
	function _saveberita($valid=false){
		
		$this->output->unset_template();
		$key 	= $this->ffunction->decode($this->input->post('hdnkey'));
		if($key!= '' && $valid){
			
			$beritaType			= $this->ffunction->cleanString($this->input->post('beritatype'));
			$ketegoriId 		= (int)$this->input->post('beritakategori');
			$beritaTitle 		= $this->ffunction->cleanString($this->input->post('beritatitle'));
			$beritaPrice 		= $this->ffunction->cleanString($this->input->post('beritaprice'));
			$beritaAuthor 		= $this->ffunction->cleanString($this->input->post('beritaauthor'));
			$beritaSynopsis		= $this->ffunction->cleanString($this->input->post('beritasynopsis'));
			$beritaContent		= $this->input->post('beritacontent');
			//$beritaUrl	 		= $this->input->post('beritaurl');
			$beritaUrl	 		= $this->ffunction->fUrlEncoder($beritaTitle,'-');
			$beritaHeadline		= (int)$this->input->post('beritaheadline');
			$beritaTag	 		= $this->input->post('beritatag');
			$beritaDirectUrl	= $this->input->post('beritadirectlink');
			$beritaDatePublish	= $this->input->post('beritadatepublish');
			$beritaStatus		= (int)$this->input->post('beritastatus');
			
			$dropKey 			= $this->input->post('dropkey');
			$strImageHeader 	=  $this->input->post('imageheader');
			
			$this->form_validation->set_rules('beritatype', 'Type Berita', 'required');
			$this->form_validation->set_rules('beritatitle', 'Title Berita', 'required');
			$this->form_validation->set_rules('beritasynopsis', 'Synopsis Berita', 'required');
			$this->form_validation->set_rules('beritacontent', 'Content Berita', 'required');
		

			if ($this->form_validation->run() == FALSE)
			{
				
				$arrRes = array(
					'valid'=>false, 
					'message'=>"Maaf Terjadi Kesalahan, Silahkan Periksa Kembali Inputan Anda", 
				);
				echo json_encode($arrRes);
				
			}else{
				
				$arrData = array(
					'berita_type'=>$beritaType,
					'kategori_id'=>$ketegoriId, 
					'berita_title'=>$beritaTitle,
					'berita_price'=>$beritaPrice,
					'berita_author'=>$beritaAuthor, 
					'berita_synopsis'=>$beritaSynopsis, 
					'berita_content'=>$beritaContent, 
					//'berita_url'=>($beritaUrl==""? $this->ffunction->fUrlEncoder($beritaTitle,'-'):$beritaUrl),
					'berita_url'=>$this->ffunction->fUrlEncoder($beritaTitle,'-'),
					'berita_headline'=>$beritaHeadline,
					'berita_date_publish'=>$beritaDatePublish,
					'berita_status'=>0,
					'berita_directlink'=>$beritaDirectUrl,
					'berita_hastag'=>$beritaTag,
				);		
				
				
				
				if($strImageHeader!==''){
					$arrData['berita_image']=str_replace($dropKey,'',$strImageHeader);
				}
				
				if($key=='tambahberita'){
					
					//cekberitaURl = 
					$objBerita =$this->MBerita->getListBerita(array(),array('berita_url'=>$beritaUrl));
					if(count($objBerita)==0){
					
						$userd = $this->userData['UserId'].'-'.$this->userData['UserInitial'];

						$this->MBerita->addBerita($arrData);

						$objBerita =$this->MBerita->getListBerita(array(),array('berita_url'=>$beritaUrl));
						if(count($objBerita)==1){

							$beritaid = $objBerita[0]->berita_id;
							$bolvalid =true;
							$Message  ="Berita Baru Berhasil di Tambah " ; 

						}else{

							$bolvalid =false;
							$Message ="Maaf Terjadi Kesalahan Saat Menambah Berita Baru.. ";
						}
						
					}else{
						
						$bolvalid = false ; 
						$Message = "Maaf Berita Url Sudah Pernah Di Gunakan ";
						
					}
					
				}else{
					
					$beritaid  = (int)$key ; 
					$objBerita =$this->MBerita->getListBerita(array(),array('berita_id'=>$beritaid));
					if(count($objBerita)==1){
						
						//unset($arrData['berita_title']);
                        
                        //echo '<pre>';print_r($arrData);echo '</pre>';die();
						
						$this->MBerita->editBerita($arrData,array('berita_id'=>$beritaid));
						$bolvalid = true; 
						$Message  = "Berita Berhasil di Update";
						
					}else{
						
						$bolvalid = false ; 
						$Message  = "Maaf Berita Tidak Valid, Silahkan Muat Ulang Halamana Anda ";
						
					}
					
				}
				
				if($bolvalid){
					
					$arrPhoto=array();
					$strImagePath = 'berita/'.$beritaid.'/';
					
					$arrkey = array(); 
					$arrReplace = array();
					
					//Tag Berita 
					if ($beritaTag != ""){
						$this->MBerita->deleteBeritaTag(array('berita_id'=>$beritaid));
						
						foreach (explode(",", $beritaTag) as $objTag) {
							if ($objTag != ""){
								$arrWhere = array('tag_name' => $objTag);
								$arrTag = $this->MTag->getListTag(array(), $arrWhere);
								if (count($arrTag) > 0){
									
									//Saving Berita Tag
									$arrTag = array(
										'tag_id' => $arrTag[0]->tag_id,
										'berita_id' => $beritaid,
									);
									$this->MBerita->addBeritaTag($arrTag);
								}
								else{

									//Save New Tag Master
									$arrTag = array('tag_name' => $objTag, 'tag_url'=>$this->ffunction->fUrlEncoder($objTag));
									$this->MTag->addTag($arrTag);

									//Saving Berita Tag
									$arrWhere = array('tag_name' => $objTag);
									$arrTag = $this->MTag->getListTag(array(), $arrWhere);
									if (count($arrTag) > 0){	
										$arrTag = array(
												'tag_id' => $arrTag[0]->tag_id,
												'berita_id' => $beritaid,
											);
										$this->MBerita->addBeritaTag($arrTag);
									}
								}
							}
						}
					}
					
					
					//Image Berita
					$strTempImagePath = $this->TempImagePath.$dropKey.'/';
					$strFilePath = 'media/images/'.$strImagePath;
					$strFilePathGalery = 'media/images/'.$strImagePath.'/galery/';
					
					//create Directory 
					if(!is_dir('./'.$strFilePath)){
						mkdir('./'.$strFilePath, 0777, true); 
					}
					
					
					//Move Photo Utama
					if( $strImageHeader != '' ){
						if(file_exists('./media/images/'.$strTempImagePath.$strImageHeader)){
							rename('./media/images/'.$strTempImagePath.$strImageHeader, "./".$strFilePath.str_replace($dropKey,'',$strImageHeader));
							
						}
					}
					
					//Move Foto Galery 
					$strTempFilePath = $strTempImagePath.'/drop/';					
					if(is_dir('./media/images/'.$strTempFilePath)){
						
						$files = scandir('./media/images/'.$strTempFilePath); 
						
						if (false!==$files){
							
							//create Directory Galery 
							if(!is_dir('./'.$strFilePathGalery)){
								mkdir('./'.$strFilePathGalery, 0777, true); 
							}
							
							foreach ( $files as $file ) {
								if ( '.'!=$file && '..'!=$file) {       
										
										//Save To array
										$arrPhotos = array('image_name' => $file,'image_type'=>1, 'berita_id'=>$beritaid );
										array_push($arrPhoto, $arrPhotos);

										//Move Image
										rename('./media/images/'.$strTempFilePath.$file, "./".$strFilePathGalery.$file);
								}
							}

							//remove DropKeyPhotoItem Directory 
							if(!is_dir('./media/images/'.$strTempFilePath)){
							   rmdir('./media/images/'.$strTempImagePath.$dropKey.'/drop/'); 
							}
							
						}
						
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
										
										/* $arrTemp = explode(".", $strNewFile);

										if (count($arrTemp) > 0){
											$strNewFile = rand(1000,9999) .".".$arrTemp[1];
											
										} */

										//Save To array
										array_push($arrkey,$file);
										array_push($arrReplace,$strNewFile);
										
										$arrPhotos = array( 'image_name' => $strNewFile , 'image_type'=>2, 'berita_id'=>$beritaid );
										array_push($arrPhoto, $arrPhotos);

										//Move Image
										rename('./media/images/'.$strTempFilePath.$file, "./".$strPathImageContent.$strNewFile);
									 
									}
								}
							}

							
						 
							//Replace Image Upload Content
							$conten  = $beritaContent;
							$tmpPath= base_url().'media/images/'.$this->TempImagePath.$dropKey.'/content/';
							$conten = str_replace($arrkey,$arrReplace, $conten);                    
							$beritaContent = str_replace($strTempFilePath,$strImagePath.'content/',$conten);
							
							
						}
					}

					//Save Edit Berita
					$arrDataEdit['berita_content'] 	  = $beritaContent;
					$arrDataEdit['berita_status']	  = $beritaStatus;
					/*if($this->permission['GroupLevel'] > 2 ){
						$arrDataEdit['berita_status'] = 0;
					}*/
					
					$arrWhereEdit = array('berita_id' => $beritaid);
					
					$this->MBerita->editBerita($arrDataEdit, $arrWhereEdit);
					if(count($arrPhoto)>0){
						$this->MBeritaimage->addBeritaImage($arrPhoto,true);
					}
					
				}
				
				$arrRes = array(
					'valid'=>$bolvalid, 
					'message'=>$Message, 
				);
				
				if($bolvalid) $arrRes['redirect'] = base_url().'admin/berita/viewBerita.html?berita='.$this->ffunction->encode($beritaid); 
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
	
	public function listberitadata($param = ''){
		$arrWhere = array();
		
			
        $arrField = array("berita_date_publish","berita_title","berita_type", "kategori_name","berita_author","berita_status");

		//Search
        if($this->input->post('beritatitle')!='') $arrWhere['{_like_} berita_title'] = '%'.$this->input->post('beritatitle').'%';

		//Order
		$strField = $arrField[(int)$this->input->post('iSortCol_0')];
		$arrOrder[$strField] = $this->input->post('sSortDir_0');

		//Limit & offset
		$intLimit  =$_POST['iDisplayLength'];
		$intOffset =$_POST['iDisplayStart'];
		
		//Get Data From database
        $arrData = $this->MBerita->getListBerita($arrOrder, $arrWhere, $intLimit, $intOffset);
        $intRows = $this->MBerita->getRowBerita($arrOrder, $arrWhere);
		$iTotal  = $this->MBerita->getRowBerita();
        
		$arrValue = array();
		$arrAll   = array();
        
		$iFilteredTotal = $intRows;
		$i=0;
		foreach($arrData as $objBerita){
			$arrValue = array();
			$arrData  = $this->converter->objectToArray($objBerita);
            $i++;
            foreach($arrField as $strValue){
				switch ($strValue) {
					case"berita_type":
						array_push($arrValue, $this->enums->BeritaType($arrData[$strValue]));
					break;
					case"berita_headline_order":
						array_push($arrValue, '<center>'.$i.'<center>');
					break;
					case"berita_status":
						array_push($arrValue, ($arrData[$strValue]==0?'Tidak Aktif':'Aktif'));
					break;
					case"berita_date_publish":
						array_push($arrValue, date('Y-m-d', strtotime($arrData[$strValue])));
					break;
					case"berita_image":
						array_push($arrValue, '<center><img height="40px" src="'.$this->imageloader->fimageberita($objBerita,2).'" /></center>');
					break;
					default : array_push($arrValue, $arrData[$strValue]);
				}
			}
			

            array_push($arrValue, 
					   "<center>
                       <a href=\"".base_url()."admin/berita/viewberita.html?berita=".$this->ffunction->encode($objBerita->berita_id)."\" title=\"Edit\"><img src=\"".base_url()."style/admin/images/edit.png\" /></a> &nbsp;
                       <a href=\"".base_url()."admin/berita/deleteberita.html?berita=".$this->ffunction->encode($objBerita->berita_id)."\" title=\"Delete\"><img src=\"".base_url()."style/admin/images/delete.png\" onclick=\"return confirm('Anda ingin menghapus data tersebut?')\" /></a>
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
	
	public function approveberita(){
		
		
		$berita = $this->ffunction->decode(urlencode($this->input->get('berita')));
		if(!berita!=""){
			
			$arrData['berita_status'] = 1;
			$this->MBerita->editBerita($arrData,array('berita_id'=>$berita));
			
			
		}
		
		
	}
	
	
	public function deleteBerita(){
		
		$beritaid=urlencode(($this->input->get('berita'))) ;
		$beritaid  = $this->ffunction->decode($beritaid);
		if(!empty($beritaid)){
			$objBerita = $this->MBerita->getListBerita(array(),array('berita_id'=>(int)$beritaid));
			if(count($objBerita)==1){
				$this->MBerita->deleteBerita(array('berita_id'=>$beritaid));
				echo '<script>alert("Berita Berhasil di Hapus");window.location.href = "'.base_url().'admin/berita/index.html";</script>';
			}else{
				echo '<script>alert("Maaf Berita Tidak di Temukan");window.location.href = "'.base_url().'admin/berita/index.html";</script>';

			}
		}
		
	}
	
	public function dropzone($strType = ""){
		if ($strType == "upload"){
			$strDropKey = $this->input->post('dropkey');

			if ($strDropKey != ""){

				$type = $_FILES['file']['type'];   

				// Generate Pathing untuk Picture
				$strTempImagePath = $this->TempImagePath;
				$strTempFilePath = $strTempImagePath.$strDropKey.'/drop/';

				if(!is_dir('./style/images/'.$strTempFilePath)){
					mkdir('./style/images/'.$strTempFilePath, 0777, true); 
				}

				//Count Image
				$intCount = 1;
				if(is_dir('./style/images/'.$strTempFilePath)){
					
					$files = scandir('./style/images/'.$strTempFilePath);                 
					if ( false!==$files ) {
						foreach ( $files as $file ) {
							if ( '.'!=$file && '..'!=$file) {       
								if (strrpos($file, $strDropKey) !== false){
									$intCount++;
								}
							}
						}
					}
					
				}
				
				//Upload Image
				$arrResult = $this->imageloader->UploadImage($strTempFilePath, "file" );
				
				//Check Upload
				if (!$arrResult['Valid']){
					echo "error on upload";
				}else{
					
					$strFileImageName = $arrResult['FilePath'].$arrResult['FileName'];

					//Resize Image Original
					//$this->imageloader->resize_image($strFileImageName, './'.$strTempFilePath, 800, 800);
					
					echo  $strFileImageName;
					
				}

			}
		}
		elseif ($this->input->post('type') == "delete"){

			$strRootPath = $_SERVER{'DOCUMENT_ROOT'};
			$strpath = $this->input->post('path');
			$strItemId = $this->input->post('serverId');

			if ($strItemId != "" && $strpath!=''){
				$strpath = './'.str_replace(base_url(),'',$strpath);
				$arrWhere = array('image_id' => $strItemId);
				$this->MBeritaimage->deleteBeritaImage($arrWhere);
				
				//delete file  
				if (file_exists($strpath)) {
					unlink($strpath);
				}

				if (file_exists(str_replace("galery", "galery/thumb", $strpath))){
					unlink(str_replace("galery", "galery/thumb", $strpath));
				}

				if (file_exists(str_replace("galery", "galery/icon", $strpath))) {
					unlink(str_replace("galery", "galery/icon", $strpath));
				}
			}			
		}
		else{

			$result       = array();
			$strImage 	  = "";
			$strImagePath = "";
			$strRootPath = $_SERVER{'DOCUMENT_ROOT'};
			$strBeritaId = $this->ffunction->decode($this->input->post('serverkey'));


			//Saving data Image galery
			$arrWhere = array('berita_id' => $strBeritaId);
			$arrBerita = $this->MBerita->getListBerita(array(), $arrWhere);
			if (Count($arrBerita) > 0){
				$objBerita = $arrBerita[0];
				$arrOrder = array('image_name' => "asc");
				
				$arrWhere = array('berita_id' => $strBeritaId, 'image_type'=>1);
				$objPhotoItem = $this->MBeritaimage->getListBeritaImage(array(), $arrWhere);
				$strNewPath = 'media/images/berita/'.$strBeritaId."/galery/";
				if (Count($objPhotoItem) > 0){	

					$strItemId = $objBerita->berita_id;
					foreach ($objPhotoItem as $objPhoto) {
						if (file_exists('./'.$strNewPath.$objPhoto->image_name)){
							$obj['name'] = $objPhoto->image_name;
							$obj['path'] = base_url().$strNewPath.$objPhoto->image_name;
							$obj['serverId'] = $objPhoto->image_id;
							$obj['size'] = filesize('./'.$strNewPath.$objPhoto->image_name);
							$result[] = $obj;
						}
					}
				}
			}
			
			header('Content-type: text/json');              
			header('Content-type: application/json');
			echo json_encode($result);
		}
		die();
	}
	
	public function imagemanager($key='', $beritaId=''){
		$this->output->unset_template();
		$arrData['dropkey'] = $key;
		$imgupload = array();
		$imgdb	   = array();
		
		if($beritaId!=''){
			$objPhotoItem = $this->MBeritaimage->getListBeritaImage(array(), array('berita_id'=>$beritaId));
			$strNewPath = './media/images/berita/'.$beritaId."/content/" ;
			if (Count($objPhotoItem) > 0) {	
				$strItemId = $beritaId; 
				foreach ($objPhotoItem as $objPhoto) {
					if (file_exists($strNewPath.$objPhoto->image_name)){
						$imgName =  $objPhoto->image_name;
						if( strlen($imgName) > 20 ){
							$t = strlen($imgName)-20;
							$imgName =  substr($imgName,0,strlen($imgName)-10-$t).'..'.substr($imgName,-8);
						}
						$imgdb[] = array(
									'path'=>'media/images/berita/'.$beritaId."/content/".$objPhoto->image_name,
									'fullpath'=>base_url().'media/images/berita/'.$beritaId."/content/".$objPhoto->image_name,
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
		//echo "<img width='200px' src='http://www.yessport.com/sites/default/files/styles/media_gallery_thumbnail/public/Flexfit%20Garment%20Washed%20Twill%20Cap%206997,%20Stone,%20United%20Tagit%202.jpg?itok=jGOK7Mt9'/>"; 
	}
	
	
	
	//headline
	
	public function changeOrder($strId, $intStatus = 0){
		$this->MBerita->editHeadlineOrder($strId, $intStatus);
		//Redirect To Home
		redirect('admin/berita/headline', 'refresh');
	}
	
	public function deleteheadline(){
		
		$beritaid=urlencode(($this->input->get('berita'))) ;
		$beritaid  = $this->ffunction->decode($beritaid);
		if(!empty($beritaid)){
			$objBerita = $this->MBerita->getListBerita(array(),array('berita_id'=>(int)$beritaid));
			if(count($objBerita)==1){
				$this->MBerita->editBerita(array('berita_headline'=>0),array('berita_id'=>$beritaid));
				echo '<script>alert("Berita Headline di Hapus");window.location.href = "'.base_url().'admin/berita/headline.html";</script>';
			}else{
				echo '<script>alert("Maaf Berita Headline Tidak di Temukan");window.location.href = "'.base_url().'admin/berita/headline.html";</script>';

			}
		}
		
	}
	
	public function addheadline(){
		
		$beritaid=$this->input->post('beritaid') ;
		$beritaid  = $this->ffunction->decode($beritaid);
		if(!empty($beritaid)){
			$objBerita = $this->MBerita->getListBerita(array(),array('berita_id'=>(int)$beritaid,'berita_headline !='=>1));
			if(count($objBerita)==1){
				
				$objselect = $this->MBerita->getListBerita(array('berita_headline_order'=>'desc'),array('berita_headline'=>1),1);
				$this->MBerita->editBerita(array('berita_headline'=>1, 'berita_headline_order'=>(isset($objselect[0]->berita_headline_order)?(int)$objselect[0]->berita_headline_order+1:'1')),array('berita_id'=>$beritaid));
				$arrRes = array(
					'valid'=>'true', 
					'message'=>'Berita Berhasil Di Tambahkan Menjadi Headline'
				);
				echo json_encode($arrRes);
			}else{
				$arrRes = array(
					'valid'=>'false', 
					'message'=>'Maaf Berita Tidak Bisa di Jadikan Headline'
				);
				echo json_encode($arrRes);
			}
		}
		
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
	
}