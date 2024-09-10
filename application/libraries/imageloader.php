<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ImageLoader
{
	public $CI;
	public $values;
	
	public function __construct()
    {
        // get CodeIgniter instance
        $this->CI = &get_instance();
        
        // get config file
        $this->CI->config->load('imageloader', TRUE);
        $this->CI->load->library('enums', TRUE);
		
    }
    
    function fKategoriImage($objKategori, $imgField='kategoribanner1', $defaultImageSize="990x330"){

		$path 	 = './style/images/kategori/';
		$return  = $this->_fLoadImage($objKategori, $strType, $path, 'kategoriid', $imgField, $defaultImageSize);
		return $return ;

	}
    
    private function _fLoadImage($param = array(), $strType= 1, $imgPath='', $imgSubPathField='', $strImgField='', $defaultImageSize="600x300", $debug="fBannerImage"){

		/*
			-Guide
			-default Path is './style/images/';
			-$param is Object / Array / String  Image Name ;
			-if $param is String, $strField ="" &  $imgPath value is full path String example './style/images/News'  or  you only define 'News'
			-if $param is object / Array $imgPathField is Field Name in Param For Path Image
			-if $param is object / Array $strField is Field Name in Param For Image Name

			if($debug!=""){

							$backtrace = debug_backtrace();
							$backtrace = $backtrace[1];
							if($backtrace['function']==$debug){
								die('dd');
								echo 'debug ---- '.$strRootPath.'/'.$strNewPath.$arrParam[$strImgField].'----';
							}
						}
		*/

		$bolValid = true ;
		$arrParam = array();
		$strTinyPngPath = "";
		
		if($strType!=0 && !empty($param)){

			//setting Default Path
			//$defaultPath = './style/images/';
			$defaultPath =  'assets/style/'.$this->CI->config->item('domain').'/images/';
			if(substr($imgPath,0,2)=='./'){

				$defaultPath = $imgPath;
				if(substr($imgPath,-1)!='/') $defaultPath.'/';

			}else{

				$defaultPath = $defaultPath.$imgPath;
			}

			if(substr($imgPath,-1)!='/') $defaultPath.'/';


			//Setting Param Array


			if(is_object($param)){
				$arrParam    = $this->CI->converter->objecttoarray($param);

				if (isset($arrParam[$imgSubPathField])){
					$defaultPath = $defaultPath.$arrParam[$imgSubPathField].'/';
				} else if (isset($arrParam[strtolower($imgSubPathField)])) {
					$defaultPath = $defaultPath.$arrParam[strtolower($imgSubPathField)].'/';
				}
			}else if(is_array($param)) {
				$arrParam    = $param;

				if (isset($arrParam[$imgSubPathField])){
					$defaultPath = $defaultPath.$arrParam[$imgSubPathField].'/';
				} else if (array_key_exists(strtolower($imgSubPathField), $search_array)) {
					$defaultPath = $defaultPath.$arrParam[strtolower($imgSubPathField)].'/';
				}
			}else if(is_string($param)){

				$arrParam 		= array( 'ImageName'    => $param,
										 'SubImagePath' => $imgSubPathField );

				$strImgField 		= 'ImageName';
				$imgSubPathField 	= 'SubImagePath';
				$defaultPath 		= $defaultPath.$arrParam[$imgSubPathField].'/';

			}else{

				$bolValid = false ;

			}
            
            

			if($bolValid){

				$strRootPath = $_SERVER{'DOCUMENT_ROOT'}.$this->CI->config->item('rootPath');
				//$strRootPath = $_SERVER{'DOCUMENT_ROOT'}.'/jagapati';
				$defaultPath = substr_replace($defaultPath,'',0,2);

				//Random String
				$randup = '?o='.substr(md5(date('Y-m-d H')),0,4);
				if(isset($arrParam['updatedate'])) $randup = '?o='.substr(md5($arrParam['updatedate']),0,4);


				//set Path Type Original / lowres / Thumb / Icon

				 if ($strType == 1 ){

					if(is_dir('./'.$defaultPath.'original/')){
						$strNewPath = $defaultPath.'original/';
					}else{
						$strNewPath = $defaultPath;
					}

				}else if ($strType == 2){

					$strNewPath = $defaultPath."thumb/";

				}else if ($strType == 3){

					$strNewPath = $defaultPath."icon/";

				}

				$strImgFieldPath = "";
				if (isset($arrParam[$strImgField])){
					$strImgFieldPath = $arrParam[$strImgField];
				} else if (isset($arrParam[strtolower($strImgField)])) {
					$strImgFieldPath = $arrParam[strtolower($strImgField)];
				}
                
                
                

               
				if (file_exists($strRootPath.'/'.$strNewPath.$strImgFieldPath)){
					if(empty($strImgFieldPath)){
						//get Default Image
						$strImage = $this->getGlobalImage($defaultImageSize);
					}else{
						$strImage = $this->CI->config->item('base_url_media').$strNewPath.$strImgFieldPath.$randup;
						//Image Compress
						/*
						$strTinyPngPath = $strNewPath.$strImgFieldPath;
						$arrWhere = array("imagepath" => $strTinyPngPath);
						$arrTinyPng = $this->CI->MTinypng->getListTinyPng(array(), $arrWhere);
						if (count($arrTinyPng) == 0){
							$arrData = array("imagepath" => $strTinyPngPath, "imagedate" => date('Y-m-d H:i:s'));
							$this->CI->MTinypng->addTinyPng($arrData);
						}
						*/
					}
                    
				}else{
                    
					//cek valid original Image
					if (file_exists($strRootPath.'/'.$defaultPath.$strImgFieldPath)) {

						$originalImage 				= $strRootPath.'/'.$defaultPath.$strImgFieldPath;
						list($picWidth, $picHeight) = getimagesize($originalImage);

						//Create Folder
						if(!is_dir('./'.$strNewPath)){
							mkdir('./'.$strNewPath, 0777, true);
						}

						$this->_createThumbnail($originalImage, './'.$strNewPath,$strType);
						$strImage = $this->CI->config->item('base_url_media').$strNewPath.$strImgFieldPath.$randup;

					}else{

						//get Default Image
						$strImage = $this->getGlobalImage($defaultImageSize);
					}
				}

			}else{
				//get Default Image
				$strImage = $this->getGlobalImage($defaultImageSize);

			}
		}else{

			//get Default Image
			$strImage = $this->getGlobalImage($defaultImageSize);

		}
        
		return $strImage;

	}
    
    /* GENERAL FUNCTION */
    
	function fEncodeUrlLink($strLink,$strSplit="-"){
		$strValue = str_replace(" ", $strSplit, $strLink);
		$strValue = str_replace(",", "", $strValue);
		$strValue = str_replace("!", "", $strValue);
		$strValue = str_replace(".", "", $strValue);
		$strValue = str_replace("?", "", $strValue);
		$strValue = str_replace("%", "", $strValue);
		$strValue = str_replace("$", "", $strValue);
		$strValue = str_replace("#", "", $strValue);
		$strValue = str_replace("&", "", $strValue);
		$strValue = str_replace("(", "", $strValue);
		$strValue = str_replace(")", "", $strValue);
		$strValue = str_replace("\"", "", $strValue);
		$strValue = str_replace("/", "", $strValue);
		$strValue = str_replace("@", "at", $strValue);
		$strValue = str_replace("'", "", $strValue);
		$strValue = str_replace('"', "", $strValue);
        $strValue = str_replace(':', "", $strValue);
		return $strValue;

	}
	
	// MASTER
	
	function FLoadImage($param = array(), $strType= 1, $imgPath='', $imgSubPathField='', $strImgField='', $defaultImageSize="600x300", $debug="fimageberita"){
		
		$bolValid = true ; 
		$arrParam = array();
		
		if($strType!=0 && !empty($param)){
		
			//setting Default Path
			$defaultPath = './media/images/';
			if(substr($imgPath,0,2)=='./'){

				$defaultPath = $imgPath;
				if(substr($imgPath,-1)!='/') $defaultPath.'/';

			}else{

				$defaultPath = $defaultPath.$imgPath;
			}

			if(substr($imgPath,-1)!='/') $defaultPath.'/';
			
			if(is_object($param)){

				$arrParam    = $this->CI->converter->objecttoarray($param);
				
			}else if(is_string($param)){

				$arrParam 		= array( 'ImageName'    => $param, 
										 'SubImagePath' => $imgSubPathField );	

				$strImgField 		= 'ImageName';
				$imgSubPathField 	= 'SubImagePath';
				
			}else if(is_array($param)){
				
				$arrParam  = $param;
			}else{
				$bolValid = false ; 
			}
			
			
	
			//Setting Param Array 
			if ( DateTime::createFromFormat('Y-m-d G:i:s', $arrParam[$imgSubPathField] ) !== FALSE) {
				
			
				$strDate = $arrParam[$imgSubPathField];
				
				$datePath = date('Y/m/d', strtotime($strDate));
				$defaultPath = $defaultPath.$datePath.'/' ;
				
			}else{
				$defaultPath = $defaultPath.$arrParam[$imgSubPathField].'/';

			}
			
			

			if($bolValid){
				
				//$strRootPath = $_SERVER{'DOCUMENT_ROOT'}.$this->CI->config->item('rootPath');
				$strRootPath = $_SERVER{'DOCUMENT_ROOT'}.'/mentarigroup';
				$defaultPath = substr_replace($defaultPath,'',0,2);

				//Random String 
				$randup = '?o='.substr(md5(date('Y-m-d H')),0,4);
				if(isset($arrParam['updatedate'])) $randup = '?o='.substr(md5($arrParam['updatedate']),0,4);


				//set Path Type Original / lowres / Thumb / Icon

				 if ($strType == 1 ){

					if(is_dir('./'.$defaultPath.'original/')){
						$strNewPath = $defaultPath.'original/';
					}else{
						$strNewPath = $defaultPath;
					}

				}else if ($strType == 2){

					$strNewPath = $defaultPath."thumb/";

				}else if ($strType == 3){

					$strNewPath = $defaultPath."icon/"; 

				}
				
				if (file_exists($strRootPath.'/'.$strNewPath.$arrParam[$strImgField])){
					
					if(empty($arrParam[$strImgField])){
						
							//get Default Image 
							$strImage = $this->getGlobalImage($defaultImageSize);
					}else{

							$strImage = base_url().$strNewPath.$arrParam[$strImgField].$randup;
					}

				}else{
					
					//cek valid original Image 
					if (file_exists($strRootPath.'/'.$defaultPath.$arrParam[$strImgField])) {

						$originalImage 				= $strRootPath.'/'.$defaultPath.$arrParam[$strImgField];
						list($picWidth, $picHeight) = getimagesize($originalImage);

						//Create Folder 
						if(!is_dir('./'.$strNewPath)){
							mkdir('./'.$strNewPath, 0777, true); 
						}	

						$this->createThumbnail($originalImage, './'.$strNewPath,$strType);					
						$strImage = base_url().$strNewPath.$arrParam[$strImgField].$randup;

					}else{
						
						//get Default Image 
						$strImage = $this->getGlobalImage($defaultImageSize);
					}				
				}

			}else{
				
				//get Default Image 
				$strImage = $this->getGlobalImage($defaultImageSize);

			}
		}else{
			
			//get Default Image 
			$strImage = $this->getGlobalImage($defaultImageSize);
			
		}
		
		return $strImage;
	
	}
	
	
	function FUpload($strImagePath, $strObjectFile, $type=1, $fileName=null, $arrConfig=array()){
		//type 1 = images 
		//type 2 = file
		
		$arrResult = array();
		
		$arrValidminSize=array('width'=>true, 'height'=>true);
		
		// Generate Pathing for Image
		if(substr($strImagePath,0,2)=='./'){
			
			//use Costum Path
			$strImagePath = str_replace('./','',$strImagePath);
			$strFilePath  = $strImagePath;
			
		}else{
			
			//use Default Path 
			$strImagePath = 'media/'.($type==1?'images/':'file/').$strImagePath;
			$strFilePath  = './'.$strImagePath;
		}
		
		if(!is_dir($strFilePath)){
			mkdir($strFilePath, 0777, true); 
		}
			
		//Upload Image
		$img_cfg['image_library'] = 'gd2';
		if($type ==1 ){
			
			$config['upload_path']   = $strFilePath;                 
			$config['allowed_types'] = 'jpg|jpeg|png|bmp|gif';
			$config['max_size'] 	 = '7024';
			$config['max_width']     = '5000';
			$config['max_height']    = '5000';
			
		}else{
			
			$config['upload_path']   = $strFilePath;                 
			$config['allowed_types'] = "pdf|xls|xlsx";
			
		}
			
		if($fileName != null){
			$config['file_name'] = $fileName;
		}
		
		//replace config 
		if(count($arrConfig)>0){
			foreach($arrConfig as $field=>$value){
				$config[$field] = $value;
			}
		}
		
		$this->CI->load->library('upload', $config);
		$this->CI->upload->initialize($config);
		
		//cek Valid is Config Use Min width and height
		$upload_data = $this->CI->upload->data(); 
		if(isset($config['min_width'])){
			if($config['min_width'] < $upload_data['image_width']){
				$arrValidminSize['width']=false;
			}
			unset($config['min_width']);
		}
		
		if(isset($config['min_height'])){
			if($config['min_height'] < $upload_data['image_height']){
				$arrValidminSize['height']=false;
			}
			unset($config['min_height']);
		}
		
		
		if( !in_array(false,$arrValidminSize) ){
			//Load Library
			//$this->CI->load->library('upload', $config);
			$this->CI->upload->initialize($config);
			$this->CI->upload->overwrite = true;

			//Check Upload
			if (!$this->CI->upload->do_upload($strObjectFile)){
				$arrResult["Valid"] 	= false;
				$arrResult["Message"] 	= strip_tags($this->CI->upload->display_errors());
			}else{
				$upload_data = $this->CI->upload->data(); 
				$arrResult["Valid"] 	= true;
				$arrResult["FileName"] 	= $upload_data['file_name'];
				$arrResult["FilePath"] 	= $strImagePath;
			}
			
		}else{
			
			$arrResult["Valid"]   = false;
			$arrResult["Message"] = 'image Height or Width  not valid ';
			
		}
		
		return $arrResult;
	}
	
	function imageManipulation($sourceOriginalFile="", $desPath, $arrConfig ){
		
        $this->CI->load->library('image_lib', array());
		$this->CI->image_lib->clear();
		
		
		$defaultPath = "./media/images/";
		
		$arrDesPath = explode('/', $desPath);
		$lastElement = end($arrDesPath);
		$fileName = empty($lastElement) ? $arrDesPath[count($arrDesPath) - 2] : $lastElement;
		if(strpos($fileName,'.')!==false){
			$desFileName = $fileName;
			$desPath = str_replace($desFileName,'',$desPath);
		}
		
		if(substr($desPath,0,2) != './' && !empty($desPath)) $desPath  = $defaultPath.$desPath ;
		
		$bolValid 		= false;
		$strNewPathName = "";
		$strTempPath 	= "";
		$message 		= "";
		
		if ($sourceOriginalFile != "" && file_exists($sourceOriginalFile)){
			
			list($picWidth, $picHeight) = getimagesize($sourceOriginalFile);
			
			
			/*
			//cek proportional Image 
			$proportional = strtolower($proportional);
			if($proportional!='none' && $proportional !=''){
				if($proportional=='width'){
					if($picWidth > $width ){
						$res 	= $picWidth/$width;
						$height = $picHeight/$res;
						$bolValid = true; 
					}else{
						$message  = 'Error Proporsional Width'
					}					
				}else{
					if($picHeight > $height ){
						$res 	= $picHeight/$height;
						$width  = $picWidth/$res;
						$bolValid = true;
					}else{
						$message  = 'Error Proporsional height'
					}
				}
			}
			*/
			
			//Get Image Path & Image Name

			$arrTemp 	 	  = explode("/", $sourceOriginalFile);
			$fullImgName 	  = end($arrTemp);
			$arrImgName  	  = explode(".", $fullImgName);
			$strImgName  	  = $arrImgName[0];
			$strImgExtention  = $arrImgName[1];

			$strTempPath = str_replace($fullImgName,'', $sourceOriginalFile);
			
			if(isset($desFileName)) $fullImgName =  $desFileName;
			
			if ($desPath == ""){
				$strNewPathName = $strTempPath.$strImgName.'-thumb.'.$strImgExtention;
			}else{
				$strNewPathName = $desPath.$fullImgName;
			}

			//Create Dir Desctination 
			if(!is_dir($desPath) && $desPath!=''){
				mkdir($desPath, 0777, true); 
			}

			//Set Default Config
			$config['image_library'] = 'gd2';
			$config['source_image']  = $sourceOriginalFile;
			$config['new_image'] 	 = $strNewPathName;
			
			if(!isset($arrConfig['quality'])){
				
				$config['quality'] 	 = '70';
			}
			
			//Marge Config 
			$config = array_merge($config, $arrConfig);

			/* crop Config 
			$config['width'] 		 = $width;
			$config['height']	     = $height;
			$config['x_axis']	     = "";
			$config['y_axis']	     = "";
			$config['maintain_ratio']= true;
			*/

			$this->CI->image_lib->initialize($config);

			$arrRes= array(
				'valid'		=>true,
				'strNewPath'=>$strNewPathName 
			);
			return $arrRes;
			
		}else{
			
			return array(
				'valid'=>false,
				'message'=>'Original File Not Exist'
			);
			
		}
       
    }
	
	function resize_images($sourceOriginalFile="", $desPath, $width="300", $height="300", $quality='100%', $proportional='width', $bolGreaterOnly=true  ){
		//echo $sourceOriginalFile;die();
		if ($sourceOriginalFile != "" && file_exists($sourceOriginalFile)){

			list($picWidth, $picHeight) = getimagesize($sourceOriginalFile);
			
			if($width =='auto' || $width=="") $width  = $picWidth;
			if($height=='auto' || $height=="") $height = $picHeight;
			
			$message  = '';
			$bolValid = false ; 

			//Cek bolGreaterOnly
			if ($bolGreaterOnly  ){

				if ($picWidth >= $width && $picHeight >= $height){
					$bolValid = true;
				}else{
					$message = 'bolGreaterOnly Error Not Valid ';
				}

			}else{

				$bolValid = true;
			}

			if($bolValid){

				$arrMasterDim = array('auto','height','width'); 

				//Resize Config 
				$config['create_thumb']  = false;
				$config['width'] 		 = $width;
				$config['height']	     = $height;
				$config['quality']	     = $quality;

				if(in_array( strtolower($proportional),$arrMasterDim)){
					$config['master_dim']	 = strtolower($proportional);
				}

				$config['maintain_ratio'] = (!in_array( strtolower($proportional),$arrMasterDim)?false:true);
				$result = $this->imageManipulation($sourceOriginalFile, $desPath, $config);
				if($result['valid']){
					
					if ($this->CI->image_lib->resize()){
					
						if ($desPath == ""){
							
							unlink($sourceOriginalFile);
							rename($result['strNewPath'], $sourceOriginalFile);
							return true;
							
						}else{

							return true;
						}
						
					}else{
						return 'Resize Error '; 
					}
					
				}else{
					
					return $result['message'];
				}

			}else{
				
				return $message;
			}
			
		}else{
			return 'Source Original Image Not Falid ';
			
		}
		
	}
	
	function watermark($sourceOriginalFile="", $desPath, $type='overlay', $strWaterMark = "",  $vrt_alignment='middle', $wm_hor_alignment='center'){
		
		$bolValid = true;
		$config['wm_type'] = $type;
		$config['wm_vrt_alignment'] = $vrt_alignment;
		$config['wm_hor_alignment'] = $wm_hor_alignment;

		if($type=='text'){
			
			if(empty($strWaterMark)) $strWaterMark = 'Berita Bengkel';
			
			// Watermark Text
			$config['wm_text'] 		= $strWaterMark;
			$config['wm_font_path'] = './system/fonts/texb.ttf';
			$config['wm_font_size'] = '26';
			$config['wm_padding'] 	= '20';
			
		}elseif($type=='overlay'){
			
			// Waterm' Image 
			$config['wm_overlay_path'] 	= $strWaterMark;
			$config['wm_opacity'] 		= '100';
			
			if ($strWaterMark == "" || !file_exists($strWaterMark)){
				$bolValid = false; 
				$message  = 'File Watermark not Exist';
			}
			
		}else{
			
			$bolValid = false ; 
			$message  = 'Type Watermark Not Falid';
			
		}
		
		if($bolValid){
			
			$result = $this->imageManipulation($sourceOriginalFile, $desPath, $config);
			if($result['valid']){
				
				if($this->CI->image_lib->watermark()){
					
					if ($desPath == ""){
							
						unlink($sourceOriginalFile);
						rename($result['strNewPath'], $sourceOriginalFile);
						return true;

					}else{

						return true;
					}
					
				}else{
					
				   return 'Error Create Watermark';
				}
			}else{
				
				return $result['message'];
			}
		
		}else{
			
			return $message;
		}			
	}
	
	
	// UPLOAD FILE And IMAGES
	
	function UploadImage($strImagePath, $strObjectFile, $fileName = null, $arrConfig=array()){
		//call fupload 
		return $this->FUpload($strImagePath, $strObjectFile,1,$fileName,$arrConfig);
	}
	function UploadFile($strImagePath, $strObjectFile,  $fileName = null, $arrConfig=array()){
		//call fupload
		return $this->FUpload($strImagePath, $strObjectFile,2,$fileName,$arrConfig);
	}	
	
	
	
	// GLOBAL
	
	function createThumbnail($originalImage, $desPath,$strType=1){
							
		list($picWidth, $picHeight) = getimagesize($originalImage);

		if($strType==1){

			$picWidth  = $picWidth * 0.999;
			$picHeight = $picHeight * 0.999;
			$quality   = 70;	

		}elseif($strType==2){

			$picWidth  = $picWidth * 0.50;
			$picHeight = $picHeight * 0.50;
			$quality   = 90;

		}else{

			$picWidth  = $picWidth * 0.25;
			$picHeight = $picHeight * 0.25;
			$quality   = 90;

		}
		
		$this->resize_images($originalImage, $desPath, $picWidth, $picWidth, $quality, 'width', true);
	}
	
	function getGlobalImage($defaultImageSize='600x300', $watermark = true, $imgColor="white" ){
		
		$arrImgColor = array('white', 'blue', 'grey', 'green', 'black','transparent');
		
		$label = ''; 
		if($watermark) $label='butuhdesain-';
		
		if(!in_array($imgColor, $arrImgColor)) $imgColor = 'white';
		
		$desPath    	= 'media/images/noimage/allnoimage/';
		$mainImage  	= './media/images/noimage/'.$imgColor.'_noimage.jpg';
		$overlayImg 	= './media/images/noimage/butuhdesain.png';
		
		$arrimg 		= explode('x',strtolower(str_replace('blank-','',$defaultImageSize)));
		
		
		$defaultImageSize = $imgColor.'-'.$defaultImageSize;
		$defaultImageSize = $label.$defaultImageSize;
		
		//set  Temp Image 
		$tempImg  		= './media/images/noimage/temp/'.$defaultImageSize.'.jpg';
		$tempWatermark  = './media/images/noimage/temp/watermark-'.$defaultImageSize.'.jpg';
		
		
		//cek valid path
		if(!is_dir('./'.$desPath)){
            mkdir('./'.$desPath, 0777, true); 
        }
		
		if(!is_dir('./media/images/noimage/temp/')){
            mkdir('./media/images/noimage/temp/', 0777, true); 
        }
		
		
		if(!file_exists('./'.$desPath.$defaultImageSize.'.jpg')){
			
			if($watermark){
				
				$this->resize_images($mainImage, $tempImg, $arrimg[0], $arrimg[1], '1', 'none', false);
				$this->resize_images($overlayImg, $tempWatermark, $arrimg[0]*0.7, $arrimg[1]*0.5, '100', 'width', false);
				
				$this->watermark($tempImg ,'./'.$desPath, $type='overlay', $tempWatermark,  $vrt_alignment='middle', $wm_hor_alignment='center');
				
				if(file_exists($tempImg)!==FALSE) unlink($tempImg);
				if(file_exists($tempWatermark)!==FALSE) unlink($tempWatermark);
				
			}else{
				$this->resize_images($mainImage, './'.$desPath.$defaultImageSize.'.jpg', $arrimg[0], $arrimg[1], '1', 'none', false);
			}
			
			
		}
		
		return base_url().$desPath.$defaultImageSize.'.jpg';
		
		
	}
	
	function fFileDownload($objFile){
		$strImage = "";
		$strImagePath = "";
		$strRootPath = $_SERVER{'DOCUMENT_ROOT'}.$this->CI->config->item('rootPath');
		
		if (file_exists($strRootPath."/".$objFile->file) && $objFile->file != "") {
			$strImage = $strRootPath.$objFile->file;
		}else{
			$dtNewsEntry = strtotime($objFile->date_created);
			$strTopPath = "/media/file/".date("Y",$dtNewsEntry)."/".date("m",$dtNewsEntry)."/".date("d",$dtNewsEntry)."/".$objFile->file;
			
			$strFirstPath = "/media/images/media/i/w/f/".$objFile->id;
			$strSecondPath = "/media/images/media/f/".$objFile->id;
			
			if (file_exists($strRootPath.$strTopPath)) {
				$strImage = $strRootPath.$strTopPath;
			}elseif (file_exists($strRootPath.$strFirstPath."/".$objFile->file)) {
				$strImage = $strRootPath.$strFirstPath."/".$objFile->file;
			}elseif (file_exists($strRootPath.$strSecondPath."/".$objFile->file)) {
				$strImage = $strRootPath.$strSecondPath."/".$objFile->file;
			}
		}
	
		return $strImage;
	}
	
	
	//Please Dont Change This Key Image Loader => 	/*~~IMAGELOADER~~*/
	function fcontoh($param, $strType, $imgSubPathField, $strImgField){
		
		$path = './media/images/';
		$return = $this->FLoadImage($param , $strType, $path, $imgSubPathField,  $strImgField,'100x100' );
		return $return;
		
	}
	
	
	
	
	function fimageberita($param,$strType,$strImgField='berita_image'){
		
		$param = json_decode(json_encode($param),true);
		
		$path = './media/images/berita/';
		
		//Image Galery 
		if($strImgField=='image_name'){
			$param['berita_id'] = $param['berita_id'].'/galery';
		}
	
		$return = $this->FLoadImage($param ,$strType, $path, 'berita_id' , $strImgField ,'640x320' );
		return $return;
		
	}
    
    function fimagekategori($param,$strType,$strImgField='kategori_image'){
		
		$param = json_decode(json_encode($param),true);
		
		$path = './media/images/kategori/';
		
		//Image Galery 
		if($strImgField=='image_name'){
			$param['kategori_id'] = $param['kategori_id'].'/galery';
		}
	
		$return = $this->FLoadImage($param ,$strType, $path, 'kategori_id' , $strImgField ,'400x400' );
		return $return;
		
	}
	
	/*function fBannerImage($param,$imgSubPathField, $size="640x320"){
		$path = './media/images/banner/';
		$return = $this->FLoadImage($param ,1, $path, 'banner_id' , $imgSubPathField , $size );
		return $return;
		
	}*/
    
    function fBannerImage($objbanner, $imgField='image_desktop', $defaultImageSize="300x300", $strType= 1){
        
		if($strType>1) $strType = 4;
		if(strtolower($imgField)=='desktop') $imgField = 'image_desktop';
		if(strtolower($imgField)=='mobile') $imgField = 'image_mobile';

		$path 	 = './media/images/banner/';
		$return  = $this->FLoadImage($objbanner, $strType, $path, 'banner_id', $imgField, $defaultImageSize);
		return $return ;

	}
    
    function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
    
    function fUploadImage($strImagePath, $strObjectFile, $fileName=null, $arrConfig=array()){
		//call fupload
		return $this->pUpload($strImagePath, $strObjectFile,1,$fileName,$arrConfig);
	}

	function fUploadFile($strImagePath, $strObjectFile, $fileName=null, $arrConfig=array()){
		//call fupload
		return $this->pUpload($strImagePath, $strObjectFile,2,$fileName,$arrConfig);
	}

	function pUpload($strImagePath, $strObjectFile, $type=1, $fileName=null, $arrConfig=array()){
		//type 1 = images
		//type 2 = file
		$arrResult = array();
		$arrValidminSize=array('width'=>true, 'height'=>true);

		// Generate Pathing untuk Picture
		if(substr($strImagePath,0,2)=='./'){
			$strImagePath = str_replace('./','',$strImagePath);
			$strFilePath  = './'.$strImagePath;
		}else{

			$strImagePath = 'media/'.($type==1?'images/':'file/').$strImagePath;
			$strFilePath  = './'.$strImagePath;
		}

		if(!is_dir($strFilePath)){
			mkdir($strFilePath, 0777, true);
		}

		//Upload Image
		$img_cfg['image_library'] = 'gd2';
		if($type ==1 ){
			$config['upload_path']   = $strFilePath;
			$config['allowed_types'] = str_replace(",", "|", str_replace(".", "", $this->CI->config->item('allowedImage')));
			$config['max_size'] 	 = '7024';
			$config['max_width']     = '5000';
			$config['max_height']    = '5000';
		}else{
			$config['upload_path'] = $strFilePath;
			$config['allowed_types'] = str_replace(",", "|", str_replace(".", "", $this->CI->config->item('allowedFile')));
		}

		if($fileName != null){
			$config['file_name'] = $fileName;
		}


		//replace config
		if(count($arrConfig)>0){
			foreach($arrConfig as $field=>$value){
				$config[$field] = $value;
			}
		}

		$this->CI->load->library('upload', $config);
		$this->CI->upload->initialize($config);

		//cek Valid is Config Use Min width and height
		$upload_data = $this->CI->upload->data();
		if(isset($config['min_width'])){
			if($config['min_width'] < $upload_data['image_width']){
				$arrValidminSize['width']=false;
			}
			unset($config['min_width']);
		}

		if(isset($config['min_height'])){
			if($config['min_height'] < $upload_data['image_height']){
				$arrValidminSize['height']=false;
			}
			unset($config['min_height']);
		}




		if( !in_array(false,$arrValidminSize) ){
			//Load Library
			//$this->CI->load->library('upload', $config);
			$this->CI->upload->initialize($config);
			$this->CI->upload->overwrite = true;

			//Check Upload
			if (!$this->CI->upload->do_upload($strObjectFile)){
				$arrResult["Valid"] 	= false;
				$arrResult["Message"] 	= strip_tags($this->CI->upload->display_errors());
			}else{
				$upload_data = $this->CI->upload->data();

				if(isset($config['maxwidth']) || isset($config['maxheight']) ){

					$width  = "";
					$height = "";

					if(isset($config['maxwidth']))  $width  = $config['maxwidth'];
					if(isset($config['maxheight'])) $height = $config['maxheight'];

					$this->resize_images($upload_data['full_path'],"", $width, $height, '100%',($width==""?'height':'width'), true  );

				}



				$arrResult["Valid"] 	= true;
				$arrResult["FileName"] 	= $upload_data['file_name'];
				$arrResult["FilePath"] 	= $strImagePath;



			}
		}else{
			$arrResult["Valid"] = false;
			$arrResult["Message"] = 'image Height or Width  not valid ';
		}


		return $arrResult;
	}
    
    public function formatTanggalIndo($date){
                
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl   = substr($date, 8, 2);

        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
        return($result);
    }
   
}