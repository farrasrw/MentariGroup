<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/


//example => $arrRoute["portal"] = "web/portal";

//ADMIN
$arrRoute['dashboard'] 		= "admin/dashboard";

//WEB
$arrRoute['home']           = "web/home";
$arrRoute['sendmessage']="web/home/sendMessage";
$arrRoute['berita']           = "web/berita";
$arrRoute['package']           = "web/package";
$arrRoute['tag'] = "web/dlog/tag";
$arrRoute['search'] = "web/dlog/search";
$arrRoute['jobs']           = "web/home/jobs";
$arrRoute['workwithus']           = "web/home/workwithus";
$arrRoute['cefirra']           = "web/home/ceffira";
$arrRoute['cefirra/detail']           = "web/home/ceffiraDetail";

$arrRoute['aboutus']           = "web/home/aboutus";
$arrRoute['catalogue']           = "web/home/catalogue";
$arrRoute['projects']           = "web/home/projects";
//$arrRoute['produk/detail']           = "web/home/detail";

//Auth
$arrRoute['auth']        = "web/auth";
$arrRoute['joinNewsletter']        = "web/auth/joinNewsletter";

foreach ($arrRoute as $strKey => $strValue) {
    $route[$strKey.'/(:any)'] = $strValue.'/$1';  
	$route[$strKey] = $strValue;
}

/*if (isset($arrRoute)){
	if (count($arrRoute) > 0){
		foreach ($arrRoute as $strKey => $strValue) {
            
			if($strKey=='dlog') {
                
                echo $strKey;
                echo '<hr>';
                
                $route[$strKey.'/(:any)'] = 'dlog/routeDlogFuc'; 
                
                echo $route[$strKey.'/(:any)'];
                echo '<hr>';
                echo '<br>';
                
            }else{
                
                echo $strKey;
                echo '<hr>';
                
              $route[$strKey.'/(:any)'] = $strValue.'/$1';  
            }
			//$route[$strKey] = $strValue;
		}
	}
}*/

if (isset($arrRoute)){
	if (count($arrRoute) > 0){
		foreach ($arrRoute as $strKey => $strValue) {
			if($strKey=='produk'){
				$route[$strKey.'/(:any)'] = 'web/dlog/routeDlogFuc';
				$route[$strKey] = 'web/dlog/routeDlogFuc';
			}else{
				$route[$strKey.'/(:any)'] = $strValue.'/$1';
                $route[$strKey.'/(:any)/(:any)'] = $strValue.'/$1/$2';
				$route[$strKey] = $strValue;	
			}
		}
	}
}

$route['default_controller'] = "web/home";

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */