<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends CI_Controller {

	function __construct(){
		parent::__construct();
		 $this->load->model('enquiry_model');
	}

	public function index()
	{
		$data['title']="Enquiry";
		$this->load->view('enquiry');
	}

	public function addenquiry(){
	   $this->form_validation->set_rules('client_name','Client Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   //$this->form_validation->set_rules('remarks','Remarks','required');
	   if($this->form_validation->run()){
		 $enquirydata=array(
		   "client_name"=>$this->input->post('client_name'),
		   "mobile"=>$this->input->post('mobile'),
		   "remarks"=>$this->input->post('remarks'),
		 ); 
		// $checkmobile=$this->enquiry_model->fetchmobile($enquirydata['mobile']);
		 //if($checkmobile==false){
		   $status=$this->enquiry_model->add_enquiry_data($enquirydata);
		 //}
		 
		 /*if($status===true){
			  $msg="Client added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }*/
		  redirect('home/');
	  }else{
		  $this->index();  
	  }	
	}


	public function checkmobile()
	{
		$mobile= $this->input->post('mobile');
		$checkmobile=$this->enquiry_model->fetchmobile($mobile);
		if($checkmobile==true){
			echo "true";
		}else{
			echo "false";
		}
	}
	
}
