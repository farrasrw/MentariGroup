<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Banner extends MY_ThemeController {

	function __construct(){
		parent::__construct();

		$this->load->model('MBanner','MBanner');
		$this->load->model('MKategori','MKategori');
		
		$this->load->model('MTag','MTagmaster');
        $this->tempAdmin();
	}

	public function index(){
		$this->load->view('admin/banner/listbanner');
	}
	
	public function uploadimage(){
        
        $this->output->unset_template();
		 
        $key = $this->input->post('uploadkey');
		$pathimg= $this->input->post('imgbannername');
		
		if(!empty($key)){
			$strImagePath = 'banner/Temp/'.$key.'/';
			$arrResult = $this->imageloader->fUploadImage($strImagePath,"imgdata",$pathimg,array('max_size'=>'300'));

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
    
	public function addBanner(){
		
		$FieldBanner = $this->MBanner->getFieldBanner();
        $arrData=$this->converter->objectToArray($FieldBanner);
                
		$arrData["Key"] 			= "Banner";
		$arrData["uploadKey"] 		= $this->imageloader->generateRandomString();
		$arrData["TagList"] 	 	= $this->MTagmaster->getListTag(array('tag_name'=>'asc'),array());
		$arrData["KategoriList"] 	= $this->MKategori->getListKategori(array(),array());
		
        //echo var_dump($arrData["KategoriList"]);die();
		//echo var_dump($arrData);die();
        
		$this->load->view('admin/banner/addbanner', $arrData);
		
	}
	
	function edit($strBannerId){
        $arrWhere = array('banner_id' => $strBannerId);
		$arrBanner = $this->MBanner->getListBanner(array(), $arrWhere);

		if (Count($arrBanner) > 0){	
			//Set Data for view
			$arrData = $this->converter->objectToArray($arrBanner[0]);
			$arrData["Banner"] = $arrBanner[0];
			$arrData["TagList"] 	 	= $this->MTagmaster->getListTag(array('tag_name'=>'asc'),array());
			$arrData["KategoriList"] 	= $this->MKategori->getListKategori(array(),array());
			$arrData["Key"] = $strBannerId;
			$arrData["uploadKey"] = $this->imageloader->generateRandomString();
		
			$this->load->view('admin/banner/addbanner', $arrData);
		}
	}
	
	public function _getBannerId(){
        $objBanner = $this->MBanner->getLimitBanner(array('banner_id'=>'desc'),array(),1,0);
        if(count($objBanner)>0){
            $BannerId = $objBanner[0]->banner_id;
            $BannerId = (int)substr($BannerId,-3);
            $BannerId++;
            $BannerId = str_pad($BannerId,3,"0",STR_PAD_LEFT);
        }else{
            $BannerId = 1;
            $BannerId = str_pad($BannerId,3,"0",STR_PAD_LEFT);
        }
        
        $prefix = "B".date('Ym');
        $BannerId = $prefix.$BannerId;
        return $BannerId;
    }
	
	public function saveBanner(){
		$strKey = $this->encrypt->decode($this->input->post('hdnKey'));
		$bolValid = false;
		$errMessage = '';
		
        $strBannerId 			= $this->input->post('txtBannerId');
		$strBannerTitle 		= $this->input->post('txtBannerTitle');
        $strBannerSchedule 		= $this->input->post('dtBannerSchedule');
        $strBannerScheduleOff 	= $this->input->post('dtBannerScheduleOff');
        $strBannerUrl 			= $this->input->post('txtBannerUrl');
        $strBannerPos 			= $this->input->post('txtBannerPos');
        $strBannerStyle 		= $this->input->post('txtbannermenuposition');
        $strBannerTag 			= $this->fcommerce->decode($this->input->post('tagselect'));
        $strBannerKategori		= $this->fcommerce->decode($this->input->post('kategoriselect'));
		$uploadKey 				= $this->input->post('uploadkey');
		$TargetId 				= $this->input->post('txtTargetId');
        $strBannerDesc          = $this->input->post('txtBannerDesc');
        $strMenuType            = $this->input->post('txtMenuType');
        $strColor               = $this->input->post('txtColor');
		//$newsId 				= $this->input->post('newsid');
		
		$arrBannerImg  			= array();
		
        $data = array(
			'banner_url' 		=> $strBannerUrl,
			'banner_title'		=> $strBannerTitle,
			'target_id'			=> $TargetId,
			'banner_style'		=> $strBannerStyle,
			'banner_schedule'	=> $strBannerSchedule,
			'banner_scheduleoff' => !empty($strBannerScheduleOff)?$strBannerScheduleOff.':00':'',
			'banner_scheduleoff' => $strBannerScheduleOff,
			'tag_name' 			=> empty($strBannerTag)?"":$strBannerTag,
			'kategori_id' 		=> empty($strBannerKategori)?0:$strBannerKategori,
			//'news_id' 			=> empty($newsId)?0:$newsId,
            'banner_desc'       => $strBannerDesc,
            'banner_typemenu'   => $strMenuType,
            'banner_color'      => $strColor,
        );
		
		
		$strImageSize	= $this->input->post('sizeinfo');
		$arrImageSize	= json_decode($strImageSize,true);

		foreach($arrImageSize as $field=>$value){

			$imgpost = $this->input->post('imgbanner'.$value[0].'x'.$value[1]);
			if(!empty($imgpost)){

				array_push($arrBannerImg, $imgpost);
				if(strpos($imgpost,'desktop')!=FALSE) $data['image_desktop']	 = $imgpost;
				if(strpos($imgpost,'mobile')!=FALSE)  $data['image_mobile']	 = $imgpost;
			}				
		}
		
		
		if($strKey == "Banner"){
			$validimg =true;
			if(count($arrBannerImg) != count($arrImageSize)  ) $validimg = false;
			
			if($validimg){
				
				$strBannerId 			 = $this->_getBannerId();
				$data['banner_id']		 = $strBannerId;
				$data['banner_imagesize'] = $strImageSize;
				$data['banner_pos']		 = $strBannerPos;
                $data['banner_status']    = 0;
				
				$this->MBanner->addBanner($data);			
				$bolValid = true;
				
			}else{
				$bolValid=false;
				$errMessage = 'Maaf Gambar Belum di Pilih';
			}
			
            //$strImagePath = 'Banner/'.$strBannerId.'/';				
			
		}elseif(!empty($strKey)){
			
			$arrWhere = array('banner_id' => $strKey);
			$arrBanner = $this->MBanner->getListBanner(array(), $arrWhere);
			if (count($arrBanner) > 0){	
				
				$bolValid = true;
				$data['banner_status']    = $arrBanner[0]->banner_status;
				//Path For Image
                $strBannerId= $arrBanner[0]->banner_id;
				$arrWhereEdit['banner_id'] = $strBannerId;
				$this->MBanner->editBanner($data, $arrWhereEdit);
				
			}else{
				$bolValid = false;
				$errMessage = 'Maaf Banner Tidak Dapat di Edit, Karna Banner Sudah Tidak Ada' ;

			}
			
		}else{
				$bolValid = false;
				$errMessage = 'Maaf Form Tidak Valid, Silahkan Muat Ulang Halaman Banner' ;
		}
		
		if ($bolValid){
			
			
			if(count($arrBannerImg)>0){
				
				$strTempFilePath = 'banner/Temp/'.$uploadKey.'/';
				$strFilePath  = 'banner/'.$strBannerId.'/';
				
			    //create Directory 
                if(!is_dir('./media/images/'.$strFilePath)){
					mkdir('./media/images/'.$strFilePath, 0777, true); 
				}
				
                if(is_dir('./media/images/'.$strTempFilePath)){
                    
                    $files = scandir('./media/images/'.$strTempFilePath);                 
                    if (false!==$files){
                        foreach ( $files as $file ){
                            if ( '.'!=$file && '..'!=$file) { 
								rename('./media/images/'.$strTempFilePath.$file,'./media/images/'.$strFilePath.$file);
							}
						}
					}
					rmdir('./media/images/'.$strTempFilePath);
				}
			}
			
			$resultData=array(
				'valid'		=>true,
				'message'	=>"Banner  Berhasil di Simpan",
				'alert'		=>true,
				'redirect'	=>base_url().'admin/banner/edit/'.$strBannerId
			);
			
			echo json_encode($resultData);die();
			
		}else{
			
			$resultData=array(
					'valid'		=>true,
					'message'	=>$errMessage,
			);
			echo json_encode($resultData);die();
		}
	}
	
	public function activateBanner($strBannerId){
		
		//Update Data
		$arrData = array('banner_status' => 2);
		$arrWhere = array('banner_id' => $strBannerId);
		$this->MBanner->editBanner($arrData, $arrWhere);
		
		//Redirect
		redirect('banner');
	}

	public function delete(){
		
		$this->load->helper('file');
		
		//Delete Data
		$strBannerId = $this->input->post('KeyId');
		$arrResponse = array(
			"Valid" => false
		);
		
		$arrWhere = array('banner_id' => $strBannerId);
		$arrBanner = $this->MBanner->getListBanner(array(), $arrWhere);
		if(count($arrBanner)>0){
			//Delete Data
			$this->MBanner->deleteBanner($arrWhere);
			
			$strRootPath = $_SERVER{'DOCUMENT_ROOT'}.$this->config->item('rootPath');
			$bannerPath = '/media/images/banner/'.$strBannerId;
			
			if(is_dir('.'.$bannerPath)){
				delete_files('.'.$bannerPath,true);
				rmdir($strRootPath.$bannerPath);
			}
			$arrResponse["Valid"] = true;
		}
		
		echo json_encode($arrResponse);
		die();
	}
	
	public function active(){
		$this->load->helper('file');
		
		//Delete Data
		$strBannerId = $this->input->post('KeyId');
		$strBannerStatus = $this->input->post('Status');
		
		$arrResponse = array(
			"Valid" => false
		);
		
		$arrWhere = array('banner_id' => $strBannerId);
		$arrBanner = $this->MBanner->getListBanner(array(), $arrWhere);
		if(count($arrBanner)>0){
			$arrResponse["Valid"] = true;
			
			//Update Data
			$arrData = array("banner_status" => $strBannerStatus);
			$this->MBanner->editBanner($arrData, $arrWhere);
		}
		
		echo json_encode($arrResponse);
		die();
	}	
	
	public function listBanner(){
		
		$arrWhere =array();
		$arrField = array("banner_title","banner_schedule","banner_scheduleoff", "banner_pos", "banner_status");

		//search
        if($this->input->post('bannerStatus') != '' && $this->input->post('bannerStatus') != "All") {
			$arrWhere['banner_status'] = $this->input->post('bannerStatus');
		}
		
		if($this->input->post('bannerpos') != '' && $this->input->post('bannerpos') != "ALL") {
			$arrWhere['banner_pos'] = $this->input->post('bannerpos');
		}
		if($this->input->post('bannertitle') != '') {
			$arrWhere['banner_title'] = '%'.$this->input->post('bannertitle').'%';
		}

		//Order
		$strField = $arrField[(int)$this->input->post('iSortCol_0')];
		$arrOrder[$strField] = $this->input->post('sSortDir_0');

		//Limit & offset
		$intLimit = $_POST['iDisplayLength'];
		$intOffset = $_POST['iDisplayStart'];
		
		//Get Data From database
        $arrOrder=array('banner_id' => 'ASC');
        $arrData = $this->MBanner->getLimitBanner($arrOrder, $arrWhere, $intLimit, $intOffset);
        $intRows = $this->MBanner->getLimitBannerRow(array(), $arrWhere);
		$iTotal  = $this->MBanner->getRowsBanner();
        
		$arrValue = array();
		$arrAll = array();
        
		$iFilteredTotal = $intRows;
		foreach($arrData as $objBanner){
			
			$arrValue = array();
			$arrBanner = $this->converter->objectToArray($objBanner);
            $strStatusButton = "";
            
            //echo var_dump($objBanner);die();
			
			
			array_push($arrValue, "<center><a href=\"#\" title=\"Show Image\" onclick=\"lightbox('".$this->imageloader->fBannerImage($objBanner)."', 1);return false; \">Show Image</a></center>");
			
            foreach($arrField as $strValue){
				switch ($strValue) {

					case "banner_status":
						if($arrBanner[$strValue] == 1){
                            array_push($arrValue,"ON");
							$strStatusButton = "<a href=\"#\" title=\"Deactive\"><img src=\"".$this->config->item('base_url_media')."style/admin/images/panah_bawah.png\" onclick=\"fActive('".$objBanner->banner_id."', 0);\" /></a>";
                        }else{
                            array_push($arrValue,"OFF");
							$strStatusButton = "<a href=\"#\" title=\"Active\"><img src=\"".$this->config->item('base_url_media')."style/admin/images/panah_atas.png\" onclick=\"fActive('".$objBanner->banner_id."', 1);\" /></a>";
                        }
						break;
					case "banner_schedule" :
						if ($arrBanner[$strValue] == "0001-01-01 00:00:00"){
							array_push($arrValue, "-");
						}else{
							$date = date_create($arrBanner[$strValue]);
							array_push($arrValue, date_format($date,"d M Y"));
						}
						break;
					case "banner_scheduleoff" :
						if ($arrBanner[$strValue] == "0001-01-01 00:00:00"){
							array_push($arrValue, "-");
						}else{
							$date = date_create($arrBanner[$strValue]);
							array_push($arrValue, date_format($date,"d M Y"));
						}
						break;
					default : array_push($arrValue, $arrBanner[$strValue]);
				}
			}
            
			array_push($arrValue, 
					   "<center>
					   ".$strStatusButton." &nbsp;
                       <a href=\"".base_url()."admin/banner/edit/".$objBanner->banner_id."\" title=\"Edit\"><img src=\"".$this->config->item('base_url_media')."style/admin/images/edit.png\" /></a> &nbsp;
                       <a href=\"#\" title=\"Delete\"><img src=\"".$this->config->item('base_url_media')."style/admin/images/delete.png\" onclick=\"fDelete('".$objBanner->banner_id."');\" /></a>

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