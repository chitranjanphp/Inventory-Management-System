<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('expense_model');
	}
	public function index()
	{
		$data['title']="Add Expense";
		$data['breadcrumb']=array('expense/expenselist'=>'Expense List','active'=>'Add Expense');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('expense/addexpense');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function addexpense(){
	   $this->form_validation->set_rules('date','Date','required');
	   $this->form_validation->set_rules('amount','Amount','required|numeric');
	   $this->form_validation->set_rules('particular','Particulars','required');
	   if($this->form_validation->run()){
		 $expensedata=array(
		   "date"=> date("Y-m-d",strtotime($this->input->post('date'))),
		   "billno"=>$this->input->post('billno'),
		   "amount"=>$this->input->post('amount'),
		   "particular"=>$this->input->post('particular'),
		   "user"=> $this->session->userdata('user'),
		   "shop"=> $this->session->userdata('shop'),
		 ); 
		 $status=$this->expense_model->addexpense($expensedata);
		 if($status===true){
			  $msg="Expense added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('expense/');
	  }else{
		  $this->index();  
	  }	 
	}
	public function expenselist(){
		$data['title']="Expense List";
		$data['breadcrumb']=array('expense'=>'Add Expense','active'=>'Expense List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['expenses']=$this->expense_model->expenselist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('expense/expenselist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_expense(){
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['expenses']=$this->expense_model->expenselist($from,$to);	
	   $this->load->view('expense/search_expense',$data);
	}
	public function editexpense($id)
	{
		$data['title']="Edit Expense";
		$data['editexpense']=$this->expense_model->getsingleexpense($id);
		$data['breadcrumb']=array('expense/expenselist/'=>'Expense List','active'=>'Edit Expense');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('expense/editexpense');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function updateexpense(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('date','Date','required');
	   $this->form_validation->set_rules('amount','Amount','required|numeric');
	   $this->form_validation->set_rules('particular','Particulars','required');
	   if($this->form_validation->run()){
		 $expensedata=array(
		   "date"=> date("Y-m-d",strtotime($this->input->post('date'))),
		   "billno"=>$this->input->post('billno'),
		   "amount"=>$this->input->post('amount'),
		   "particular"=>$this->input->post('particular'),
		   "user"=> $this->session->userdata('user'),
		   "shop"=> $this->session->userdata('shop'),
		 ); 
		 $status=$this->expense_model->updateexpense($id,$expensedata);
		 if($status===true){
			  $msg="Expense updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('expense/expenselist/');
	  }else{
		  $this->editexpense($id);  
	  }	
	}
	public function deleteexpense($id){
		 $status=$this->expense_model->deleteexpense($id);
		 if($status===true){
			  $msg="Expense deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('expense/expenselist/');
		
	}
	
}
