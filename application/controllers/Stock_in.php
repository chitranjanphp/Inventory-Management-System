<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_in extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('stock_in_model');
	}
	public function index()
	{
		$data['title']="Stock In";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Stock In');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['products']=$this->stock_in_model->productlist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('stockin/productlist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function editprice(){
		$id=$this->input->post('id');
		$data['products']=$this->stock_in_model->get_product_sprice($id);
		$this->load->view('stockin/edit_view',$data);
	}
	public function updateprice(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('sale_price','Sale Price','required|numeric');
	   if($this->form_validation->run()){
		 $pricedata=array(
		   "sale_price"=>$this->input->post('sale_price')
		 );
		// print_r($categorydata);  
		 $status=$this->stock_in_model->updateprice($id,$pricedata);
		 if($status===true){
			  $msg="Price updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
	  }
	   redirect('stock_in/');
	}
	
}
