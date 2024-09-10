<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bannerconfig
{
	
   


public function BannerPos($intId = 0){
        
		$arrBanner = array(
			
			//home slide header 
			'Banner-header' => array(
									'title'		=>  "banner Header 728x90 px",
									'keterangan'=>  'Ketentuan Banner: <br>
													<b>Banner Desktop</b> Ukuran  728x90 px, Size gambar tidak lebih dari 100kb',
									'size'		=>	array(
														  'desktop'=>array('728','90'),
													)
			),
			
			//home Promo
			'Banner-right1'  => array(
								'title'		=> "banner right 1 300x250 px",
								'keterangan'=> 'Ketentuan Banner : <br> -Banner Desktop dengan ukuran 300x250 px 
												<br>
												size gambar tidak lebih dari 100Kb',
								'size'		=>	array( 
														'desktop'=>array('300','250'),
												),
			),
			'Banner-right2'  => array(
								'title'		=> "banner right 2 300x250 px",
								'keterangan'=> 'Ketentuan Banner : <br> -Banner Desktop dengan ukuran 300x250 px 
												<br>
												size gambar tidak lebih dari 100Kb',
								'size'		=>	array( 
														'desktop'=>array('300','250'),
												),
			),
			'Banner-right3'  => array(
								'title'		=> "banner right 3 300x250 px",
								'keterangan'=> 'Ketentuan Banner : <br> -Banner Desktop dengan ukuran 300x250 px 
												<br>
												size gambar tidak lebih dari 100Kb',
								'size'		=>	array( 
														'desktop'=>array('300','250'),
												),
			),
		);
		if ($intId == 0){
			return $arrBanner;		
		}else{
			return $arrBanner[$intId];		
		}
	}
}