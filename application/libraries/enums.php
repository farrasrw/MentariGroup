<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Enums
{
	
   
    public function groupUser($intId=''){
        $arr = array(
            1 => "superAdministrator",
            2 => "administrator",
            );
        if ($intId == '' or $intId==0){
            return $arr[1];		
        }else{
            return $arr[$intId];		
        }
    }
   
    public function enumsHari($intId = 0){
		$arrHari = array(
            1 => "Senin", 
            2 => "Selasa", 
            3 => "Rabu", 
            4 => "Kamis", 
            5 => "Jumat", 
            6 => "Sabtu",
            7 => "Minggu");
		
		if ($intId == 0){
			return $arrHari;		
		}else{
			return $arrHari[$intId];		
		}
	}
    
	public function enumBulan($intId = 0){
		$arrbulan = array(
            1 =>  "Januari", 
            2 =>  "Februari", 
            3 =>  "Maret", 
            4 =>  "April", 
            5 =>  "Mei", 
            6 =>  "Juni",
            7 =>  "Juli",
            8 =>  "Agustus",
            9 =>  "September",
            10 => "Oktober",
            11 => "November",
            12 => "Desember");
		
		if ($intId == 0){
			return $arrbulan;		
		}else{
			return $arrbulan[$intId];		
		}
	}
 
	public function enumSex($Id='all'){
		
		$arrSts = array('L' => "Laki-Laki", 'W' => "Wanita");
		
		if ($Id=='all' ){
			return $arrSts;		
		}else if($Id=='L' || $Id=='W'){
			return $arrSts[$Id];		
		}else{
			return '';
		}
		
	}
	
	public function BeritaType($intId=0){
        $arr = array(
            1 => "Berita",
            2 => "Photo Galery",
            );
        if ((int)$intId==0){
            return $arr;		
        }else{
            return $arr[$intId];		
        }
    }
    
    public function enumsBannerPos($intId = 0){

		$arrBanner = array(
            'home-banner-atas' => array(
									'title'		=>  "Home 3:1 - Banner 990x330 px",
									'keterangan'=>  'Ketentuan Banner: <br>
													<b>Banner Desktop</b> 3:1 dengan ukuran minimal  990x330 px <br> <b>Banner Mobile</b> 1:1 dengan ukuran  400x400 px <br>
													Size gambar tidak lebih dari 100Kb ',
									'size'		=>	array(
														  'desktop'=>array('990','330'),
														  'mobile'=>array('400','400')
														 )
			),
            'home-banner-bawah' => array(
									'title'		=>  "Home 1:1 - Banner 400x400 px",
									'keterangan'=>  'Ketentuan Banner: <br>
													<b>Banner Desktop</b> 1:1 dengan ukuran minimal  400x400 px <br>
													Size gambar tidak lebih dari 100Kb ',
									'size'		=>	array(
														  'desktop'=>array('400','400')
														 ),
			),
            
            'package-banner' => array(
									'title'		=>  "Package - Banner 990x330 px",
									'keterangan'=>  'Ketentuan Banner: <br>
													<b>Banner Desktop</b> 3:1 dengan ukuran minimal  990x330 px <br> <b>Banner Mobile</b> 1:1 dengan ukuran  400x400 px <br>
													Size gambar tidak lebih dari 100Kb ',
									'size'		=>	array(
														  'desktop'=>array('990','330'),
														  'mobile'=>array('400','400')
														 ),
                                    //'addon'		=>	array('tag','kategori')
			),

		);
		if ($intId == 0){
			return $arrBanner;
		}else{
			return $arrBanner[$intId];
		}
	}
   
	
    
 
}

