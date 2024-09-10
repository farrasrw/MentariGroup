<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); 
class Home extends MY_ThemeController {
	
	function __construct(){
		parent::__construct();
		$this->load->library('underscore');
        $this->load->model('MBanner','MBanner');
        $this->load->model('MAbout','MAbout');
        $this->load->model('Mberita','MBerita');
        $this->tempHome();        
    }
    
    
    function index(){
        
        //Banner Home
		$arrOrder = array("banner_id" => "ASC");
		$arrWhere = array("banner_status" => 1, "banner_schedule <=" => date("Y-m-d H:i:s"),"banner_scheduleoff >" => date("Y-m-d H:i:s"));
		$objDataBanner = $this->MBanner->getListBanner($arrOrder, $arrWhere);
        
		$arrData['banner'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'home-banner-atas'; }));
        $arrData['bannercontent'] = array_values(array_filter($objDataBanner, function($v) { return $v->banner_pos == 'home-banner-bawah'; }));
        
        $datePublish= date('Y-m-d H:i:s');
        
        $arrData['berita'] = $this->MBerita->getListBerita(array('berita_date_publish'=>'desc'),array('berita_status'=>1, 'berita_date_publish <' => $datePublish),2,0);
        
        //echo '<pre>';print_r($arrData['berita']);echo '</pre>';die();
        
        $this->load->view('web/home',$arrData);
    }
    
    function sendMessage(){
        
        $this->load->model('Mmessage', 'MMessage');
				
		$nama = $this->input->post('txtNama');
		$email = $this->input->post('txtEmail');
		$pesan = $this->input->post('txtPesan');
		$nohp = $this->input->post('txtHp');
        
		$key   = $this->fcommerce->decode($this->input->post('keyemail'));
		$this->form_validation->set_rules('txtNama', 'Nama', 'required');
		$this->form_validation->set_rules('txtHp', 'Hp', 'required');
		$this->form_validation->set_rules('txtEmail', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('txtPesan', 'Pesan', 'required');

		if ($this->form_validation->run() == FALSE){
			
			$arrRes = array(
					'valid'=>false,
					'message'=>'Maaf silahkan cek form inputan anda'
				);
			echo json_encode($arrRes);die();
			
		}else{
			
            // add Member
            $arrData=array('nama' => $nama,'email' => $email, 'pesan' => $pesan); 
            $this->MMessage->addMessage($arrData);


            $arrRes = array(
                'valid'=>true,
                'message'=>'Terimakasih, pesan anda berhasil di simpan',
                'redirect'=>base_url()
            );
            echo json_encode($arrRes);die();
				
		}    
        
    }
    
    public function aboutus($strType=""){
             
        if($strType == 'latar-belakang'){
            $strAbout=0;
            $strTitle='latar belakang';
            
        }elseif($strType == 'visi-misi'){
            $strAbout=1;
            $strTitle='visi & misi';
            
        }elseif($strType == 'nilai-perusahaan'){
            $strAbout=2;
            $strTitle='nilai perusahaan';
            
        }elseif($strType == 'struktur-organisasi'){
            $strAbout=3;
            $strTitle='struktur organisasi';
            
        }elseif($strType == 'dewan-holding'){
            $strAbout=4;
            $strTitle='dewan holding';
            
        }elseif($strType == 'anak-perusahaan'){
            $strAbout=5;
            $strTitle='anak perusahaan';
        }
                
        $objAbout=$this->MAbout->getListAbout(array('about_type' => 'DESC'),array('about_type' => $strAbout),1,0);
        
        if(count($objAbout)>0){
            $arrData['title']=$strTitle;
            $arrData['data']=$objAbout;
            $this->load->view('web/about', $arrData);
        }else{
            redirect(base_url());
        }
	}
    
    public function visimisi(){
        
        $strTitle='Visi Misi';
        $objVisi=$this->MAbout->getListAbout(array('about_type' => 'DESC'),array('about_type' => 1),1,0);
        $objMisi=$this->MAbout->getListAbout(array('about_type' => 'DESC'),array('about_type' => 6),1,0);
        
        if(count($objVisi)>0){
            //$arrData['title']=$strTitle;
            $arrData['datavisi']=$objVisi;
            $arrData['datamisi']=$objMisi;
            $this->load->view('web/visimisi', $arrData);
        }else{
            redirect(base_url());
        }
        
    }
    
    public function dewanholding(){
        
        $this->load->view('web/dewanholding');
        
    }
    
    public function nopage(){
        
        $this->load->view('web/nopage');
        
    }
}