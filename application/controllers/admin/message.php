<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Message extends MY_ThemeController {

	function __construct()
	{
		parent::__construct();

		$this->load->model('mmessage','mm');
		$this->load->library('session');
		$this->load->helper('url');
		$this->tempAdmin();
		
	}

//--------------------------------------------------------------
//------------------------------------------------------NEW LINE
//--------------------------------------------------------------
	public function logout()
	{
		$this->session->unset_userdata('isLogin');
		$this->session->unset_userdata('username');
		redirect('dashboard');
	}

	public function index()
	{
        $this->load->view('admin/message/vlistmessage');

	}

	

//--------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------- MESSAGE -----------------------------------------------
//--------------------------------------------------------------------------------------------------------------------

	public function viewMessage($id)
	{

		$data['message'] = $this->mm->getListMessage(array(),array('message_id'=> $id));
                
		$this->load->view('admin/message/vviewmessage', $data);

	}

	public function replyMessage($id)
	{

		$data['message'] = $this->mm->get_replymessage($id);
		$this->load->view('admin/message/vreplyMessage', $data);

	}

	public function savereplyMessage()
	{
                
		if($this->input->post('savereplymessage') == "Reply")
		{
			$config['protocol'] = "smtp";
			$config['smtp_host'] = "ssl://smtp.gmail.com";
			$config['smtp_port'] = "465";
			$config['smtp_user'] = "info@butuhdesign.com"; 
			$config['smtp_pass'] = "info@butuhdesign.com";
			$config['charset'] = "utf-8";
			$config['mailtype'] = "html";
			$config['newline'] = "\r\n";

			//load email helper
    		$this->load->helper('email');
    		//load email library
    		$this->load->library('email');
    		$this->email->initialize($config);

			$id = $this->input->post('id');
			$nama = $this->input->post('txtNama');
			$email = $this->input->post('txtEmail');
			$replypesan = $this->input->post('txtReplay');
			$replydate = date('Y-m-d H:i:s');
					
			$this->form_validation->set_rules('txtEmail', 'txtEmail', 'required');
		
			if ($this->form_validation->run() == FALSE)
			{
				$data['message'] = $this->mm->get_replymessage($id);
				$this->load->view('admin/message/vviewmessage', $data);

				echo '<script> alert("Please fill your Reply Message"); </script>'; 

			}
			else
			{
                
				if (valid_email($email)){  
      				// compose email
      				$this->email->from('shendyrobben@gmail.com' , 'Butuh Design');
      				$this->email->to($email); 
      				$this->email->subject('to '.$nama.'From Butuhdesign');
      				$this->email->message($replypesan);  
      
      				// try send mail ant if not able print debug
      				if ( ! $this->email->send())
      				{
        				//$data['message'] = $this->mm->get_replymessage($id);
						//$this->load->view('admin/message/vviewmessage', $data);

						//echo '<script> alert("Email not Send"); </script>';
                        
                        $resultData=array(
                                'valid'		=>false,
                                'message'	=>'Email not Send',
                        );
                        echo json_encode($resultData);die();
      				}
                    
                        
                    $arrData['replypesan']=$replypesan;
                    $arrData['replydate']=$replydate;
		      			
					$this->mm->editMessage($arrData,array('message_id'=>$id));
			
					echo '<script> alert("Message has been Reply and successfully Sent");
						location = "'.site_url('message').'";
					  	</script>';
                    
                    $resultData=array(
                        'valid'		=>true,
                        'message'	=>"Message has been Reply and successfully Sent",
                        'alert'		=>true,
                        'redirect'	=>base_url().'admin/message'
                    );

                    echo json_encode($resultData);die();
				}
				else{
                    
					/*echo '<script> alert("Not Valid Email"); </script>'; 
					redirect('message');*/
                    
                    $resultData=array(
                            'valid'		=>false,
                            'message'	=>'Not Valid Email',
                            'redirect'	=>base_url().'admin/message'
                    );
                    echo json_encode($resultData);die();
				}
			}
		}
	}
	
    
    public function test(){
        
        $arrOrder=array("createdate"=>"desc");
        $arrWhere =array("stype"=>1);
        $data = $this->mm->getAllContactUs($arrOrder,$arrWhere);
        echo var_dump($data);
    
    }    
    
   
    public function listMessage(){
		$this->output->unset_template();
		//$arrOrder["FormId"] = "DESC";
		$arrWhere =array();
		$arrLike=array();
		$arrField = array("createdate","nama","email","pesan");

        
		//------------------- Value From Datatables -------------------//
		//Condition
		//search
        if($this->input->post('email')!='') $arrWhere['email'] ='%'.$this->input->post('email');
		
		//Order
		$strField = $arrField[(int)$this->input->post('iSortCol_0')];
		$arrOrder[$strField] = $this->input->post('sSortDir_0');

		//Limit & offset
		$intLimit = $_POST['iDisplayLength'];
		$intOffset = $_POST['iDisplayStart'];
		
		
		//Get Data From database
		$arrData = $this->mm->getLimitMessage($arrOrder, $arrWhere,$intLimit, $intOffset,$arrLike);
		$intRows = $this->mm->getLimitMessageRow($arrOrder, $arrWhere,$arrLike);
		//$iTotal = $this->mm->getAllMessageRows(array(),array());
        $iTotal = $this->mm->getRowsMessage();
                
		$arrValue = array();
		$arrAll = array();
		
		
		$iFilteredTotal = $intRows;
		foreach($arrData as $objFrm){
			$arrValue = array();
			$arrForm = $this->converter->objectToArray($objFrm);
			foreach($arrField as $strValue){

				switch ($strValue) {
                    case "conten":
                        array_push($arrValue, substr($arrForm[$strValue],0,240));
                    break;
                    
					default : array_push($arrValue, $arrForm[$strValue]);
				}
			}
            
            /*if($objFrm->stype==1){
			     
						 if ($objFrm->favorite == 0) {
						
							array_push($arrValue,
                                       '<a href="'.base_url().'testimoni/favorite/'.$objFrm->id.'" title="Favorite" >
								<img src="'.base_url().'style/admin/image/table/favorite.png" />
							</a>&nbsp
                            <a href="'.base_url().'testimoni/editTestimonial/'.$objFrm->id.'" title="Edit" >
							<img src="'.base_url().'style/admin/image/table/edit.png" />
                            </a>&nbsp
                            <a href="'.base_url().'testimoni/deleteTestimonial/'.$objFrm->id.'" title="Delete" >
                                <img src="'.base_url().'style/admin/image/table/delete.png" onclick="return confirm(\'Anda ingin menghapus testimoni tersebut?\')"/>
                            </a>&nbsp'
                                      
                                      );
						 }elseif ($objFrm->favorite == 1) {
							array_push($arrValue,'<a href="'.base_url().'testimoni/disable/'.$objFrm->id.'" title="Disable" >
								<img src="'.base_url().'style/admin/image/table/cancel.png" />
							</a>&nbsp
                            <a href="'.base_url().'testimoni/editTestimonial/'.$objFrm->id.'" title="Edit" >
							<img src="'.base_url().'style/admin/image/table/edit.png" />
                            </a>&nbsp
                            <a href="'.base_url().'testimoni/deleteTestimonial/'.$objFrm->id.'" title="Delete" >
                                <img src="'.base_url().'style/admin/image/table/delete.png" onclick="return confirm(\'Anda ingin menghapus testimoni tersebut?\')"/>
                            </a>&nbsp');
						} 
                
						

            }elseif($objFrm->stype==2){
                
                				
							if ($objFrm->conten != "") {
								if ($objFrm->favorite == 0) {
						          array_push($arrValue, 
					               '
									<a href="'.base_url().'clinic/favorite/'.$objFrm->id.'" title="Favorite" >
										<img src="'.base_url().'style/admin/image/table/favorite.png" />
									</a>&nbsp
									<a href="'.base_url().'clinic/editClinic/'.$objFrm->id.'" title="View Clinic" >
										<img src="'.base_url().'style/admin/image/table/edit.png" />
									</a>&nbsp<a href="'.base_url().'clinic/viewClinic/'.$objFrm->id.'" title="View Clinic" >
                                        <img src="'.base_url().'style/admin/image/table/preview.png" />
                                    </a>&nbsp
                                    <a href="'.base_url().'clinic/deleteClinic/'.$objFrm->id.'" title="Delete Clinic" >
                                        <img src="'.base_url().'style/admin/image/table/delete.png" onclick="return confirm(\'Anda ingin menghapus Clinic tersebut?\')"/>
                                    </a>
						           ');	
                                    
								}elseif ($objFrm->favorite == 1) {
						           array_push($arrValue, 
					               '
									<a href="'.base_url().'clinic/disable/'.$objFrm->id.'" title="Disable" >
										<img src="'.base_url().'style/admin/image/table/cancel.png" />
									</a>&nbsp
									<a href="'.base_url().'clinic/editClinic/'.$objFrm->id.'" title="View Clinic" >
										<img src="'.base_url().'style/admin/image/table/edit.png" />
									</a>&nbsp
                                    <a href="'.base_url().'clinic/viewClinic/'.$objFrm->id.'" title="View Clinic" >
                                    <img src="'.base_url().'style/admin/image/table/preview.png" />
                                    </a>&nbsp
                                    <a href="'.base_url().'clinic/deleteClinic/'.$objFrm->id.'" title="Delete Clinic" >
                                        <img src="'.base_url().'style/admin/image/table/delete.png" onclick="return confirm(\'Anda ingin menghapus Clinic tersebut?\')"/>
                                    </a>
                                    ');	
						        }
							}else{
						
								array_push($arrValue, 
					               '<a href="'.base_url().'clinic/replyClinic/'.$objFrm->id.'" title="Answer Clinic" >
									<img src="'.base_url().'style/admin/image/table/reply.png" />
								    </a>&nbsp');
						    } 

            
            }elseif($objFrm->stype==3){
            
                
							if ($objFrm->status == 1) {
								array_push($arrValue,
                                           '<a href="'.base_url().'message/replyMessage/'.$objFrm->id.'" title="Reply Message" >
									<img src="'.base_url().'style/admin/image/table/reply.png" />
								</a>&nbsp  

                                <a href="'.base_url().'message/viewMessage/'.$objFrm->id.'" title="View Message" >
                                    <img src="'.base_url().'style/admin/image/table/preview.png" />
                                </a>&nbsp
                                <a href="'.base_url().'message/deleteMessage/'.$objFrm->id.'" title="Delete Message" >
                                    <img src="'.base_url().'style/admin/image/table/delete.png" onclick="return confirm(\'Anda ingin menghapus Message tersebut?\')"/>
                                </a>&nbsp'); 
						
							}else{
                            
                                array_push($arrValue,'<a href="'.base_url().'message/viewMessage/'.$objFrm->id.'" title="View Message" >
                                <img src="'.base_url().'style/admin/image/table/preview.png" />
                                </a>&nbsp
                                <a href="'.base_url().'message/deleteMessage/'.$objFrm->id.'" title="Delete Message" >
                                    <img src="'. base_url().'style/admin/image/table/delete.png" onclick="return confirm(\'Anda ingin menghapus Message tersebut?\')"/>
                                </a>&nbsp');
                            
                            }
						
						
						
            
            }*/
            
            array_push($arrValue,'<a href="'.base_url().'admin/message/viewMessage/'.$objFrm->message_id.'" title="View Message" >
                                <img src="'.base_url().'style/admin/images/table/preview.png" />
                                </a>&nbsp
                                <a href="'.base_url().'admin/message/deleteMessage/'.$objFrm->message_id.'" title="Delete Message" >
                                    <img src="'. base_url().'style/admin/images/table/delete.png" onclick="return confirm(\'Anda ingin menghapus Message tersebut?\')"/>
                                </a>&nbsp');

			array_push($arrAll, $arrValue);
		}

		//Create Json For DataTables
		$output = array(
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => $arrAll
		);
        

		echo json_encode($output);
		die();
	}
    
    function deleteMessage($id){
        $arrWhere=array('message_id'=>$id);
		$this->mm->deleteMessage($arrWhere);
		redirect('admin/message');
     }
    
    public function exel($type=0){
        
        $type = (int)$type; 
        $this->load->library("excel");
        $this->excel->setActiveSheetIndex(0);
        $dataMessage=array();

        $data=$this->mm->getListMessage(array('message_id'=>'asc'), array());
        if(count($data)>0){
            
            foreach($data as $value){
                $tmp = $this->converter->objectToArray($value);                
                array_push($dataMessage, $tmp);
            }
        }
        $date = date('Y-m-d');
        $this->excel->stream($date."-Message.xls", $dataMessage);
    
        
        
    }
    
//--------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------ END MESSAGE ---------------------------------------------
//--------------------------------------------------------------------------------------------------------------------


//--------------------------------------------------------------
//--------------------------------------------------END NEW LINE
//--------------------------------------------------------------

}