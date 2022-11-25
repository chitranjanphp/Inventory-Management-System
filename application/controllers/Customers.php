<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('customers_model');
	}
	public function index()
	{
		$data['title']="Add Customer";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Add Customer');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('customers/addcustomer');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function addcustomer(){
	   $this->form_validation->set_rules('cust_name','Customer Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   //$this->form_validation->set_rules('email','Email','required');
	   $this->form_validation->set_rules('address','Address','required');
	   $this->form_validation->set_rules('gstin','GSTIN','required');
	   if($this->form_validation->run()){
		 $custdata=array(
		   "cust_name"=>$this->input->post('cust_name'),
		   "company_name"=>$this->input->post('company_name'),
		   "mobile"=>$this->input->post('mobile'),
		   "alt_mobile"=>$this->input->post('alt_mobile'),
		   "email"=>$this->input->post('email'),
		   "address"=>$this->input->post('address'),
		   "gstin"=>$this->input->post('gstin'),
		   "status"=>1
		 ); 
		 $status=$this->customers_model->addcustomerdata($custdata);
		 if($status===true){
			  $msg="Customer added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('customers/');
	  }else{
		  $this->index();  
	  }	
	}
	public function customerlist(){
		$data['title']="Customer List";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Customer List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['customers']=$this->customers_model->customerlist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('customers/customerlist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function editcustomer($id)
	{
		$data['title']="Edit Customer";
		$data['editcustomer']=$this->customers_model->getsinglecustomer($id);
		$data['breadcrumb']=array('Customers/Customerlist/'=>'Customer List','active'=>'Edit Customer');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('customers/editcustomer');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function updatecustomer(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('cust_name','Customer Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   //$this->form_validation->set_rules('email','Email','required');
	   $this->form_validation->set_rules('address','Address','required');
	   $this->form_validation->set_rules('gstin','GSTIN','required');
	   if($this->form_validation->run()){
		 $custdata=array(
		   "cust_name"=>$this->input->post('cust_name'),
		   "company_name"=>$this->input->post('company_name'),
		   "mobile"=>$this->input->post('mobile'),
		   "alt_mobile"=>$this->input->post('alt_mobile'),
		   "email"=>$this->input->post('email'),
		   "address"=>$this->input->post('address'),
		   "gstin"=>$this->input->post('gstin'),
		   "updated_on"=>date('Y-m-d H:i:s'),
		   "status"=>$this->input->post('status')
		 ); 
		 $status=$this->customers_model->updatecustomerdata($id,$custdata);
		 if($status===true){
			  $msg="Customer updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('customers/customerlist/');
	  }else{
		  $this->editcustomer($id);  
	  }	
	}
	public function deletecustomer($id){
		 $status=$this->customers_model->deletecustomer($id);
		 if($status===true){
			  $msg="Customer deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('customers/customerlist/');
		
	}
	public function customerdetail(){
		 $id=$this->input->post('id');
		 $data['detail']=$this->customers_model->getsinglecustomer($id);
		 $this->load->view('customers/viewcustomer',$data);
	}
   public function getsinglecustomer(){
	     $id=$this->input->post('id');
		 $data=$this->customers_model->getsinglecustomer($id); 
		 echo json_encode($data);
   }
}
