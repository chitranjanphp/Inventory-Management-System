<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('suppliers_model');
	}
	public function index()
	{
		$data['title']="Add Supplier";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Add Supplier');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('suppliers/addsupplier');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function addsupplier(){
	   $this->form_validation->set_rules('supplier_name','Supplier Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   //$this->form_validation->set_rules('email','Email','required');
	   $this->form_validation->set_rules('address','Address','required');
	   $this->form_validation->set_rules('gstin','GSTIN','required');
	   if($this->form_validation->run()){
		 $suppdata=array(
		   "supplier_name"=>$this->input->post('supplier_name'),
		   "company_name"=>$this->input->post('company_name'),
		   "mobile"=>$this->input->post('mobile'),
		   "alt_mobile"=>$this->input->post('alt_mobile'),
		   "email"=>$this->input->post('email'),
		   "address"=>$this->input->post('address'),
		   "gstin"=>$this->input->post('gstin'),
		   "status"=>1
		 ); 
		 $status=$this->suppliers_model->addsupplierdata($suppdata);
		 if($status===true){
			  $msg="Supplier added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('suppliers/');
	  }else{
		  $this->index();  
	  }	
	}
	public function supplierlist(){
		$data['title']="Supplier List";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Supplier List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['suppliers']=$this->suppliers_model->allsuppliers();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('suppliers/supplierlist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function editsupplier($id)
	{
		$data['title']="Edit Supplier";
		$data['editsupplier']=$this->suppliers_model->getsinglesupplier($id);
		$data['breadcrumb']=array('suppliers/supplierlist/'=>'Supplier List','active'=>'Edit Supplier');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('suppliers/editsupplier');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function updatesupplier(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('supplier_name','Supplier Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   //$this->form_validation->set_rules('email','Email','required');
	   $this->form_validation->set_rules('address','Address','required');
	   $this->form_validation->set_rules('gstin','GSTIN','required');
	   if($this->form_validation->run()){
		 $suppdata=array(
		   "supplier_name"=>$this->input->post('supplier_name'),
		   "company_name"=>$this->input->post('company_name'),
		   "mobile"=>$this->input->post('mobile'),
		   "alt_mobile"=>$this->input->post('alt_mobile'),
		   "email"=>$this->input->post('email'),
		   "address"=>$this->input->post('address'),
		   "gstin"=>$this->input->post('gstin'),
		   "updated_on"=>date('Y-m-d H:i:s'),
		   "status"=>$this->input->post('status')
		 ); 
		 $status=$this->suppliers_model->updatesupplierdata($id,$suppdata);
		 if($status===true){
			  $msg="Supplier updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('suppliers/supplierlist/');
	  }else{
		  $this->editsupplier($id);  
	  }	
	}
	public function deletesupplier($id){
		 $status=$this->suppliers_model->deletesupplier($id);
		 if($status===true){
			  $msg="supplier deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('suppliers/supplierlist/');
		
	}
	public function supplierdetail(){
		 $id=$this->input->post('id');
		 $data['detail']=$this->suppliers_model->getsinglesupplier($id);
		 $this->load->view('suppliers/viewsupplier',$data);
	}
   public function getsinglesupplier(){
	     $id=$this->input->post('id');
		 $data=$this->suppliers_model->getsinglesupplier($id); 
		 echo json_encode($data);
   }
}
