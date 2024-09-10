<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FFunction
{
    public $CI;
	
    function FFunction(){
        $this->CI = &get_instance();
        $this->CI->load->library('encrypt',TRUE);
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
	
	public function TimeAgo($stime){
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
	
	function fUrlEncoder($strLink,$strSplit="-"){
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
		$strValue = str_replace("+", "plus", $strValue);
		$strValue = str_replace("'", "", $strValue);
		$strValue = str_replace('"', "", $strValue);
        $strValue = str_replace(':', "", $strValue);
		return $strValue;
	}
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	function url_exists($url) {
		$hdrs = @get_headers($url);
		return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
	}
	
    function formatTanggal($date=null, $type=0){
		//$type =   0=>full date,  1=>short date
		
	  	//buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
	   	$array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
		
	   	//buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
		$array_bulan = array(1=>'Januari','Februari','Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober', 'November','Desember');
		if($date == null) {
			
			 //echo var_dump($date);die();
			 //jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
			 $hari = $array_hari[date('N')];
			 $tanggal = date ('j');
			 $bulan = $array_bulan[date('n')];
			 $tahun = date('Y');

		}else{

			 //jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
			 $date  = strtotime($date);
			 $hari  = $array_hari[date('N',$date)];
			 $tanggal = date ('j', $date);
			 $bulan = $array_bulan[date('n',$date)];
			 $tahun = date('Y',$date);
		}
		if($type==0){
			$formatTanggal = $hari . " , " . $tanggal ." ". $bulan ." ". $tahun;
		}else{
			$formatTanggal =  $tanggal ." ". $bulan ." ". $tahun;
		}
		return $formatTanggal;
}
    
}

