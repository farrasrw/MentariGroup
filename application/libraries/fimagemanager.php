<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fimagemanager
{   
    public $CI;
    function Fimagemanager(){
        $this->CI = &get_instance();
        $this->CI->load->library('encrypt',TRUE);
    }		
		
	public function getimagenamager( $key='', $typeModule='news' ,$paramid='', $arrDataImage=array() ){
		
		$arrTypeModule  = array(
			'news'=>array('path'=>'style/images/News/', 'controler'=>'berita' ),
			'produk'=>array('path'=>'style/images/inventory/', 'controler'=>'inventory' ),
			'direktoriads'=>array('path'=>'style/images/direktoriads/', 'controler'=>'direktoriads' ),
		);
		
		$path = $arrTypeModule[$typeModule]['path'];
		
		
		$arrData['dropkey'] = $key;
		$imgupload = array();
		$imgdb	   = array();
		
		if($paramid!=''){
			//$objPhotoItem = $this->MBeritaimage->getListBeritaImage(array(), array('berita_id'=>$beritaId));
			$objPhotoItem = $arrDataImage;
			$strNewPath = './'.$path.$paramid."/imagecontent/" ;
			if (Count($objPhotoItem) > 0) {	
				$strItemId = $paramid; 
				foreach ($objPhotoItem as $objPhoto) {
					if (file_exists($strNewPath.$objPhoto->photoname)){
						$imgName =  $objPhoto->photoname;
						if( strlen($imgName) > 20 ){
							$t = strlen($imgName)-20;
							$imgName =  substr($imgName,0,strlen($imgName)-10-$t).'..'.substr($imgName,-8);
						}
						$imgdb[] = array(
									'path'=> $path.$paramid."/imagecontent/".$objPhoto->photoname,
									'fullpath'=>base_url().$path.$paramid."/imagecontent/".$objPhoto->photoname,
									'name'=>$imgName
						);
					}
				}
			}
		}
		if(is_dir('./'.$path.'Temp/'.$key.'/imagecontent/')){
			
			$files = scandir('./'.$path.'Temp/'.$key.'/imagecontent/');                 
			if (false!==$files){
				foreach ( $files as $file ){
					if ( '.'!=$file && '..'!=$file) {       
							$imgName =  str_replace($key,'',$file);	
							if( strlen($imgName) > 20 ){
								$t = strlen($imgName)-20;
								$imgName =  substr($imgName,0,strlen($imgName)-10-$t).'..'.substr($imgName,-8);
							}
							$imgupload[] = array(
								'path'=>$path.'Temp/'.$key.'/imagecontent/'.$file,
								'fullpath'=>base_url().$path.'Temp/'.$key.'/imagecontent/'.$file,
								'name'=>$imgName
							 );
					}
				}
			}
		}
		
		$arrData['imgdb'] = $imgdb;
		$arrData['imgupload'] = $imgupload;
		$arrData['controler'] =$arrTypeModule[$typeModule]['controler']	;
		
		$this->CI->load->view('web/imagemanager', $arrData);

	}
	
	
	
		
}