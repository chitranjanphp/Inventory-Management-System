<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('category_model');
	}
	public function index()
	{
		$data['title']="Category";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Category List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['categories']=$this->category_model->allcategory();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('category/categorylist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function addcategory(){
	   $this->form_validation->set_rules('category','Enter Category','required|is_unique[product_categories.category]',array('is_unique'=> '%s already exists.'));
	   if($this->form_validation->run()){
		 $categorydata=array(
		   "category"=>$this->input->post('category')
		 ); 
		 $status=$this->category_model->addcategorydata($categorydata);
		 if($status===true){
			  $msg="Category added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('category/');
	  }else{
		  $this->index(); 
		  return; 
	  }	
	}
	public function getsinglecategory(){
	   $id=$this->input->post('id');
	   $categories=$this->category_model->getsinglecategory($id);
	   echo json_encode($categories);
	}
	public function updatecategory(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('editcategory','Enter Category','required');
	   if($this->form_validation->run()){
		 $categorydata=array(
		   "category"=>$this->input->post('editcategory')
		 );
		// print_r($categorydata);  
		 $status=$this->category_model->updatecategory($id,$categorydata);
		 if($status===true){
			  $msg="Category updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('category/');
	  }else{
		  $this->index();  
	  }	
	}
	public function deletecategory($id){
		$status=$this->category_model->deletecategory($id);
		 if($status===true){
			  $msg="Category deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('category/');
	}
}
