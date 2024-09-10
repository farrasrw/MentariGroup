<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SendMail
{
	var $CI;
	
	function __construct(){
		$this->CI =& get_instance();
		
		//Load Library
		$this->CI->load->library('loginvalidation');
		$this->CI->load->library('enums');
		$this->CI->load->library('fcommerce');
	}
	
	public function Send($strEmailTo, $strSubject, $strContent){
		/*
		$config = Array(
			  'protocol' => 'smtp',
			  'smtp_host' => 'smtp.zoho.com',
			  'smtp_port' => 465,
			  'smtp_user' => 'IT@jagapati.com',
			  'smtp_pass' => 'IT@garuda34',
			  'smtp_crypto' => 'ssl',
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE,
			  'newline' => "\r\n"
		);
		*/
		$config = Array(
			  'protocol' => 'smtp',
			  'smtp_host' => 'mail.topindo.co.id',
			  'smtp_port' => 465,
			  'smtp_user' => 'info@topindo.co.id',
			  'smtp_pass' => 'jalangaruda123',
			  'smtp_crypto' => 'ssl',
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE,
			  'newline' => "\r\n"
		);
		/*
		$config = Array(
			  'protocol' => 'smtp',
			  'smtp_host' => 'smtp.gmail.com',
			  'smtp_port' => 465,
			  'smtp_user' => 'vip@top1.co.id', // change it to yours
			  'smtp_pass' => 'viptop1duration', // change it to yours
			  'smtp_crypto' => 'ssl',
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE,
			  'newline' => "\r\n"
        );
*/
		
		$this->CI->load->library('email', $config);
		
		//topindo 
		$this->CI->email->from('help@jagapati.com', "Help Jagapati.com");
		$this->CI->email->reply_to('IT@jagapati.com', 'Jagapati');
		
		$this->CI->email->to($strEmailTo);
		$this->CI->email->subject($strSubject);	
				
		//Send Email
		$this->CI->email->message($strContent);
			
		$strMessage = 0;	
		if($this->CI->email->send()){	
			return true;
		}else{
			return false;
		}
	}
	
	//~~~~~~~~~~~~~~~~~~~~//
	
	public function templatecontent($arrEmail, $emailContent=''){
			
		$emailContent = str_replace('{{EMAIL}}',$arrEmail['Email'],$emailContent);
		$emailContent = str_replace('{{MEMBER_NAME}}',$arrEmail['MemberName'],$emailContent);
		$emailContent = str_replace('{{FULL_DATE}}', $this->CI->enums->enumsHari(date('N')).', '.date('d').' '.$this->CI->enums->enumBulan(date('n')).' '.date('Y') ,$emailContent);
		$emailContent = str_replace('{{SHORT_DATE}}',date('d/m/Y'),$emailContent);
		$emailContent = str_replace('{{TIME}}',date('H:i:s'),$emailContent);			

		$unsubscribeid = urlencode($this->CI->fcommerce->encode('unsubscribe-'.$arrEmail['Email']));

		$emailContent = str_replace('{{UNSUBSCRIBE}}',base_url().'unsubscribe/'.$unsubscribeid,$emailContent);
		$emailContent = str_replace('{{LONG_CODE}}',urlencode($this->CI->fcommerce->encode('email-'.$arrEmail['Email'])),$emailContent);
		$emailContent = str_replace('{{SHORT_CODE}}', md5($this->CI->fcommerce->encode($arrEmail['Email'])) ,$emailContent);
			
			return $emailContent;
		
			
	}
	
	public function sendEmailTemplate( $eventid=0, $arrEmail=array(), $strSubject, $paramId=0, $resend =0 ){
		$this->CI->load->model('mnewsletter','MNewsletter');
		if($eventid!=0){
			$arrEvent = $this->CI->enums->EventEmailLog($eventid);
			if(isset($arrEvent['eventname'])){
				$boolvalid =false ;
				$arrData = array();
				$strSubject = $content = $this->templatecontent($arrEmail, $strSubject);

				if($eventid==1){
					$content = $this->CI->load->view('web/newslettertemplate/'.$arrEvent['templatepath'],'',true);
					$content = $this->templatecontent($arrEmail, $content);
					$boolvalid = true;
					
				}else if($eventid==2){
					$this->CI->load->model('admin/mtransaksi','MTransaksi');
					$objTrans = $this->CI->MTransaksi->getListTransDetailTransaksi(array(), array('TransHeader.TransId'=>$paramId));
					
					if(count($objTrans)>0){
						
						$arrData['produk'] = $objTrans;
						$content = $this->CI->load->view('web/newslettertemplate/'.$arrEvent['templatepath'],$arrData,true);
						$content = $this->templatecontent($arrEmail, $content);
						$strSubject = $this->templatecontent($arrEmail, $strSubject);
						$boolvalid = true;
					}					
				}
				
				if($boolvalid){
					
					$stsSend = $this->Send($arrEmail['Email'], $strSubject, $content); 
					
					$arrData = array(
						'EventId'=>$eventid, 
						'EventName'=>$arrEvent['eventname'],
						'ParamId'=>$paramId,
						'SendDate'=>date('Y-m-d H:i:s'),
						'ResendStatus'=>$resend,
						'Email'=>$arrEmail['Email'],
						'MemberName'=>$arrEmail['MemberName'],
					);
					
					if($stsSend){
						$arrData['SendStatus'] = 1;
						//echo 'sukses';
					}else{
						$arrData['SendStatus'] = 2;
						//echo 'gagal';
					}
					
					$this->CI->MNewsletter->addEmailLog($arrData);
					return $arrData['SendStatus'];
					
				}else{
					return 2; 
				}
				
			}
		}
		
	}
	
}