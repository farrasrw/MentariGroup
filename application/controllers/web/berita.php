<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); 
class Berita extends MY_ThemeController {
	
	function __construct(){
		parent::__construct();
		$this->load->library('underscore');
        $this->load->model('MBanner','MBanner');
        $this->load->model('Mberita','MBerita');
		$this->load->model('Mtag','MTag');
		$this->load->model('Mkategori','MKategori');
		$this->load->model('Mberitaimage','MBeritaimage');
        $this->tempHome();        
    }
    
    
    /*function index(){
        
        //Banner Home
		$arrOrder = array("banner_id" => "ASC");
		$arrWhere = array("banner_status" => 0, "banner_schedule <=" => date("Y-m-d H:i:s"),"banner_scheduleoff >" => date("Y-m-d H:i:s"));
		$objDataBanner = $this->MBanner->getListBanner($arrOrder, $arrWhere);
        
		$objDlog= $this->MBerita->getListBerita(array(),array());
        
        $arrData['banner'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'package-banner'; }));
        $arrData['dlog']=$objDlog;
        
                
        $this->load->view('web/dlog', $arrData);
    }*/
    
    public function beritaDetail(){
		
		$this->load->view('web/berita_detail');
		
	}
	
	public function beritaPhoto(){
		
		$this->load->view('web/berita_detail');
		
	}
	
	
	function routeDlogFuc(){
			$this->load->model('Mkategori','MKategori');
			$objKategori = $this->MKategori->getListKategori(array(),array());
		    $arrKategori = json_decode(json_encode($objKategori),true);
			$arrKategoriBerita = $this->underscore->map($arrKategori, function($num) { return $num['kategori_url']; });
			$arrBeritaPuclicFunction  = array('dlog');
        		
			if(in_array(strtolower($this->uri->segment(1)),$arrKategoriBerita)){
				
				$intTarger = 1;

				$strTarget = $this->uri->segment($intTarger);
				$strParam1 = $this->uri->segment($intTarger+1);
				$strParam2 = $this->uri->segment($intTarger+2);
				$strParam3 = $this->uri->segment($intTarger+3);
				
				$bolDirectRoute =true ; 
				
			}else{
				
				$strTarget = $this->uri->segment(2);
				
				$strParam1 = $this->uri->segment(3);
				$strParam2 = $this->uri->segment(4);
				$strParam3 = $this->uri->segment(5);
				$bolDirectRoute =false;

				if(in_array(strtolower($this->uri->segment(2)),$arrKategoriBerita)) $bolDirectRoute = true;
				
				
			}
        
        	//grup function with single param 
            if(method_exists($this,$strTarget) && !$bolDirectRoute){
                
				 if(!empty($strParam1) && !empty($strParam2) && !empty($strParam3)){
					return $this->$strTarget($strParam1,$strParam2,$strParam3);
					 
				 }else if(!empty($strParam1) && !empty($strParam2) && empty($strParam3)){
					return $this->$strTarget($strParam1,$strParam2); 
					 
				 }else if(!empty($strParam1) && empty($strParam2)){
					return $this->$strTarget($strParam1); 
					 
				 }else{
					return $this->$strTarget(); 
				 }
				
            }else{
                
                //echo var_dump($param);die();
                
				if( ($bolDirectRoute && empty($strParam1) || (!$bolDirectRoute && empty($strTarget) && in_array(strtolower($this->uri->segment(1)),$arrBeritaPuclicFunction) ))) {
                    
					if($bolDirectRoute){
                                                
						$segmentTarget = $this->uri->segment(1);
                        
						if(in_array(strtolower($this->uri->segment(2)),$arrKategoriBerita)) $segmentTarget = $this->uri->segment(2);                        
						return $this->_all($segmentTarget, 'kategori' );
					}else{
						return $this->_all($this->uri->segment(1));
					}
				}else{
                                        
				   $param = (!$bolDirectRoute?$strTarget:$strParam1);
                   return $this->_detail($param);
                }
            }
        
    }
    
    
    
    function detail($param=""){
                
        $this->tempHome();
        
        return $this->_detail($param);
    }
	
	function _detail($param){
                
		$strPram = $this->ffunction->cleanString($param);
		$strPram = $this->ffunction->fUrlEncoder($param);
		
		$objBerita = $this->MBerita->getListBerita(array(),array('berita_url'=>$param),1);
                        
		if(count($objBerita)==1){
			
			$arrData['data']  = $objBerita;
            
            $arrOrder = array("banner_id" => "ASC");
            $arrWhere = array("banner_status" => 0, "banner_schedule <=" => date("Y-m-d H:i:s"),"banner_scheduleoff >" => date("Y-m-d H:i:s"));
            $objDataBanner = $this->MBanner->getListBanner($arrOrder, $arrWhere);

            $arrData['banner'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'home-banner-atas'; }));
            $arrData['bannercontent'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'home-banner-bawah'; }));
            
            $this->load->model('Mkategori','MKategori');
        
            $arrDataSection['kategori']=$this->MKategori->getListKategori(array(),array());

            $this->load->section('menuleft', 'web/include/navleft_home',$arrDataSection);
            
						
			$this->load->view('web/beritadetail',$arrData);
			
		}else{
			
			redirect('home');
		}
		
	}
	
	function _all($strParam='', $viewSet='all' ){
		
		//$strParam is (terbaru/populer) / kategori_name / Tag_name
		//$viewSet is  all / kategori / tag
		
		$this->load->library('Pagination');
		$bolValid = true;
		$strLimit = 9;
		$strOffset = (int)$this->input->get('page');
        
        $datePublish= date('Y-m-d H:i:s');
        //array('news_date_publish <' => date("Y-m-d H:i:s")
        
		if(strtolower($strParam)=='terbaru' || $strParam=='dlog' ){
			//echo 'terbaru';
			$objBerita = $this->MBerita->getListBerita(array('berita_date_publish'=>'desc'),array('berita_status'=>1, 'berita_date_publish <' => $datePublish),$strLimit,$strOffset);
                        
			$rowBerita = $this->MBerita->getRowBerita(array(), array('berita_status'=>1));
			$baseUrl   = base_url().strtolower($strParam).'.html?';
			$beritaCaption = 'dlog terbaru';
			
		}else if(strtolower($strParam)=='populer'){
			//echo 'populer';
			$objBerita = $this->MBerita->getListBerita(array('berita_id'=>'desc'),array('berita_status'=>1,'berita_date_publish <' => $datePublish),$strLimit,$strOffset);
			$rowBerita = $this->MBerita->getRowBerita(array(), array('berita_status'=>1));
			$baseUrl   = base_url().'berita/'.strtolower($strParam).'.html';
			$beritaCaption = 'Berita Populer';
			
		}else if(strtolower($viewSet)=='search'){
            
            $arrWhreSearch = array(
				'{_like_ } berita_title'=> $strParam,
				'{ _orlike_ } berita_synopsis'=>$strParam,
				'berita_status'=>1, 
                'berita_date_publish <' => $datePublish
			);
            
			$objBerita = $this->MBerita->getListBerita(array('createdate'=>'desc'),$arrWhreSearch,$strLimit,$strOffset);
                    
			$rowBerita = $this->MBerita->getRowBerita(array(), $arrWhreSearch);
			$baseUrl   = base_url().'dlog/search.html?q='.strtolower($strParam);
			$beritaCaption = 'Pencarian '.$strParam;
			
		}else if(strtolower($viewSet)=='kategori'){
		
			$objBerita = $this->MBerita->getListBerita(array('berita_title'=>'ASC'),array('berita_status'=>0,'kategori_url'=>$strParam), $strLimit,$strOffset );
            
			$rowBerita = $this->MBerita->getRowBerita(array(),array('berita_status'=>0,'kategori_url'=>$strParam));
			$baseUrl   = base_url().'produk/'.strtolower($strParam).'.html?';
                    
			$beritaCaption = (count($objBerita)>0?ucwords($objBerita[0]->kategori_name):'');
			
		}else if(strtolower($viewSet)=='tag'){
			            
			$objBerita = $this->MBerita->getListBerita(array('berita_date_publish'=>'desc'),array('berita_status'=>1,'tag_url'=>$strParam, 'berita_date_publish <' => $datePublish), $strLimit,$strOffset );
			$rowBerita = $this->MBerita->getRowBerita(array(), array('berita_status'=>1,'tag_url'=>$strParam, 'berita_date_publish <' => $datePublish));
			$baseUrl   = base_url().'tag/'.strtolower($strParam).'.html';
			$beritaCaption = (count($objBerita)>0? ucwords( str_replace('-',' ',$strParam)):'');

			
		}else{
			
			$bolValid = false ;
			
		}
        
        //die();
		
		if($bolValid){
			
			if(count($objBerita)>0){
				
				// Config setup
				$config['total_rows'] 		 = $rowBerita ; 
				$config['num_links']  		 = 3;
				$config['per_page']   		 = $strLimit;
				$config['base_url']    		 = $baseUrl;
				$config['page_query_string'] = TRUE;
				$config['query_string_segment'] = 'page';
				
				$config['next_link'] = false;
				$config['prev_link'] = false;

				$config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] ="</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
                $config['next_tag_open'] = "<li>";
                $config['next_tagl_close'] = "</li>";
                $config['prev_tag_open'] = "<li>";
                $config['prev_tagl_close'] = "</li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                
                //echo '<pre>';print_r($config);echo '</pre>';
                //die();
				
				// Initialize
				$this->pagination->initialize($config);
                
                $arrOrder = array("banner_id" => "ASC");
                $arrWhere = array("banner_status" => 0, "banner_schedule <=" => date("Y-m-d H:i:s"),"banner_scheduleoff >" => date("Y-m-d H:i:s"));
                $objDataBanner = $this->MBanner->getListBanner($arrOrder, $arrWhere);

                $arrData['banner'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'home-banner-atas'; }));
                $arrData['bannercontent'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'home-banner-bawah'; }));
                
                $this->load->model('Mkategori','MKategori');
        
                $arrDataSection['kategori']=$this->MKategori->getListKategori(array(),array());

                $this->load->section('menuleft', 'web/include/navleft_home',$arrDataSection);
				
				$arrData['produk'] = $objBerita;
				$arrData['caption'] = $beritaCaption;
				//$this->load->view('web/dlog',$arrData);
				$this->load->view('web/ceffira/produk',$arrData);

			}else{
				
				//$this->output->unset_template();
				//echo 'page Not Fund';
				
				redirect(base_url());
			}
		}else{
			redirect(base_url());
		}
	}
	
	function tag($strTag=''){
                
		$this->_all($strTag, 'tag' );
	}
	
	function terbaru(){
		
		$this->_all('terbaru');
	}
	function populer(){
		
		$this->_all('populer');
	}
	function search(){
		$q = $this->ffunction->cleanString($this->input->get('q',true));
                
		if(strlen($q)>4){            
			$this->_all($q,'search');
		}else{
			redirect(base_url());
		}
	}
}