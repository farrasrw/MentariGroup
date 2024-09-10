<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FCommerce
{
    public $CI;
    function FCommerce(){
        $this->CI = &get_instance();
        $this->CI->load->library('encrypt',TRUE);
    }
    
    function getFilter($arrData){
        $strPage='0';
        $arrWhere=array();
        $arrOrder=array();
        $extendUrl='';
        
        
        //filter Brand 
        $fBrand= (isset($arrData['brand'])?$arrData['brand']:'');
        if(!empty($fBrand)){
            
            if(is_array($fBrand)) $fBrand = implode(',',$fBrand);
            
            $filterBrand=str_replace('[','',$fBrand);
            $filterBrand=str_replace(']','',$filterBrand);
            $filterBrand=urldecode($filterBrand);  
            
            $arrBrand= explode(',',$filterBrand);
            
            //set POst Back
            $arrData['brand']=$arrBrand;
            if(count($arrBrand)>0){
               $arrWhere['BrandNameUrl']=$arrBrand;
            }else{
               $arrWhere['BrandNameUrl']=$filterBrand; 
                //$arrData['brand']=array($filterBrand);
            }
            
            
            $extendUrl.= (empty($extendUrl)?'?brand='.$fBrand:'&brand='.$fBrand);    
        }

        //filter Kategori
        $fKategori = (isset($arrData['fkat'])?$arrData['fkat']:'');
        if(!empty($fKategori )){
            $KategoriId = explode('-',$fKategori);
            if(count($KategoriId)>0) $arrWhere['ItemKategoriId']=(int)$KategoriId[0];
            $extendUrl.= (empty($extendUrl)?'?fkat='.$fKategori:'&fkat='.$fKategori);    
        }

        //filter Harga 
        $fHarga= (isset($arrData['fprice'])?$arrData['fprice']:'');
        if(!empty($fHarga)){
            
            if(is_array($fHarga)) $fHarga= implode('-', $fHarga);
            
            // remove decimal coma from post Price
            $fHarga=str_replace(',','',$fHarga);
            $fHarga=str_replace('.','',$fHarga);
            
            
            
            $filterHarga=urldecode($fHarga);
            
            
            $filterHarga=str_replace('[','',$fHarga);
            $filterHarga=str_replace(']','',$filterHarga);
            
            
            $filterHarga = explode('-',$filterHarga);
            
            //set postback
            $arrData['fprice']=$filterHarga;
            
            if(count($filterHarga)==2){
                $arrWhere['ItemHargaJual >=']=(int)$filterHarga[0];
                $arrWhere['ItemHargaJual <=']=(int)$filterHarga[1];
                $extendUrl.=(empty($extendUrl)?'?fprice='.$fHarga:'&fprice='.$fHarga);    
            }  
            
        }

        //soting 
        $arrSorting=array(
            'lowerprice'=>array('ItemHargaJual'=>'asc'),
            'hightprice'=>array('ItemHargaJual'=>'desc'),
            'popular'=>array('ItemHits'=>'desc'),
            'discount'=>array('ItemDiskon'=>'desc'),
            'new'=>array('createdate'=>'desc')
        );

        $sort= (isset($arrData['sort'])?$arrData['sort']:'');
        if(!empty($sort)){
            if(array_key_exists($sort,$arrSorting)){
                $arrOrder = $arrSorting[$sort]; 
                $extendUrl.= (empty($extendUrl)?'?sort='.$sort:'&sort='.$sort);  
            }
        }


        //paging 
        $page = (isset($arrData['page'])?$arrData['page']:'');
        if(!empty($page) && is_numeric($page)){
            $strPage=(int)$page;
            $extendUrl.=(empty($extendUrl)?'?page='.$page:'&page='.$page);    
        }
        $data['postBack']=$arrData;
        $data['where']=$arrWhere;
        $data['order']=$arrOrder;
        $data['offset']=$strPage;
        $data['extendUrl']=$extendUrl;
        return $data;
        
    }
    
    function cleanString($str){
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        return $t;
    }
    
    public function encode($str){
		 $value = $this->CI->encrypt->encode($str);
	     $value =  $this->CI->encrypt->encode('nn'.$value.'cc');
		 $value = urlencode($value);
		 return $value;
	}
	
	public function decode($str){
		
		$value=urldecode($str);
        $value =  $this->CI->encrypt->decode($value);
        
        if(substr($value,0,2)=='nn' and substr($value,-2)=='cc'){
            $value = substr_replace($value,'',0,2);
            $value = substr_replace($value,'',-2);
			$value =  $this->CI->encrypt->decode($value);
        }else{
            $value = '';
        }
		
        return $value;
    }
	
	public function TimeAgo($stime)
    {
        $time=strtotime($stime);
        $periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $now = time();

        $difference     = $now - $time;
        $tense         = "yg lalu";

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "";
        }
        if($j > 4){
            return date("d F Y",$time);
        }else{
            return "$difference $periods[$j] $tense ";
        }
    }
	
	public function Urlencode(){
		$strValue = str_replace("_", "+", $strLink);
		$strValue = str_replace(" ", "_", $strLink);
		
		return $strValue;
	}
	
	public function Urldecode(){
		
	}
}

