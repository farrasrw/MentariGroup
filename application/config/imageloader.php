<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//get Real Base Url
$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$config['dev-show'] = false;
if($root=='http://localhost/vesta/' || substr($root,0,10)=='http://192' || $root=='http://192.168.101.118/' || $root=='http://139.255.46.230/' ){
	$config['dev-show'] = true;
}


$config['rootPath']		= "/mentarigroup";

$rootPathProfile="/media/images/profile/";

//profile Image path  
$config['user']    = $rootPathProfile."user/";
$config['group']    = $rootPathProfile."group/";

$config['ImgLogo']      = "/style/images/distributor/avatar/original/";
$config['DefLogo']    	= "/style/images/global/distributor.jpg";

$config['ImgBannerProf']= "/style/images/trolo/banner/";
$config['DefBannerProf']= "/style/images/global/banner.jpg";

$config['ImgEvent']= "/style/images/distributor/banner/original/";
$config['DefEvent']= "/style/images/global/profile.jpg";

$config['ImgNews']= "/style/images/news/original/";
$config['DefNews']= "/style/images/global/news.jpg";

$config['ImgProduct']= "/style/images/product/";
$config['DefProduct']= "/style/images/global/product.jpg";

$config['allowedImage']	= ".jpg,.gif,.png,.pdf";

//WebService
$config['VipWebServer']		= "http://localhost/Vip/";
$config['base_url_media']="/mentarigroup/";
//$config['VipWebServer']		= "http://192.168.101.51/";		//VipBeta
//$config['VipWebServer']		= "http://192.168.101.177/";	//AxDev
//$config['VipWebServer']		= "http://192.168.101.189/"; 	//VipLive
//$config['VipWebServer']		= "http://192.168.101.21/"; 	//VipWebservice
