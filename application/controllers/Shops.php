<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shops extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('shops_model');
	}
	public function index()
	{
		$data['title']="Add Shop";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Add Shop');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('shops/addshop');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function addshop(){
	   $this->form_validation->set_rules('shop_name','Shop Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]|is_unique[inv_shops.mobile]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!','is_unique'=> '%s already exists.'));
	   //$this->form_validation->set_rules('email','Email','required');
	   $this->form_validation->set_rules('address','Address','required');
	   $this->form_validation->set_rules('gstin','GSTIN','required');
	   if($this->form_validation->run()){
		 $shop_name = $this->input->post('shop_name');
		 $words = explode(" ",$shop_name);
		 $acronym = "";
		 foreach ($words as $w) {
			$acronym .= $w[0];
		 }  
		 $shopdata=array(
		   "shop_name"=>$shop_name,
		   "acronym"=>$acronym,
		   "mobile"=>$this->input->post('mobile'),
		   "email"=>$this->input->post('email'),
		   "address"=>$this->input->post('address'),
		   "gstin"=>$this->input->post('gstin')
		 ); 
		 $status=$this->shops_model->addshopdata($shopdata);
		 if($status===true){
			  $msg="Shop added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('shops/');
	  }else{
		  $this->index();  
	  }	
	}
	public function shoplist(){
		$data['title']="Shop List";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Shop List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['shops']=$this->shops_model->getshops();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('shops/shoplist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function editshop($id)
	{
		$data['title']="Edit Shop";
		$data['editshop']=$this->shops_model->getsingleshop($id);
		$data['breadcrumb']=array('shops/shoplist/'=>'Shop List','active'=>'Edit Shop');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('shops/editshop');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function updateshop(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('shop_name','Shop Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   //$this->form_validation->set_rules('email','Email','required');
	   $this->form_validation->set_rules('address','Address','required');
	   $this->form_validation->set_rules('gstin','GSTIN','required');
	   if($this->form_validation->run()){
		 $shop_name = $this->input->post('shop_name');
		 $words = explode(" ",$shop_name);
		 $acronym = "";
		 foreach ($words as $w) {
			$acronym .= $w[0];
		 }  
		 $shopdata=array(
		   "shop_name"=>$shop_name,
		   "acronym"=>$acronym,
		   "mobile"=>$this->input->post('mobile'),
		   "email"=>$this->input->post('email'),
		   "address"=>$this->input->post('address'),
		   "gstin"=>$this->input->post('gstin'),
		   "updated_on"=>date('Y-m-d H:i:s'),
		   "status"=>$this->input->post('status')
		 ); 
		 $status=$this->shops_model->updateshopdata($id,$shopdata);
		 if($status===true){
			  $msg="Shop updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('shops/shoplist/');
	  }else{
		  $this->editshop($id);  
	  }	
	}
	public function deleteshop($id){
		 $status=$this->shops_model->deleteshop($id);
		 if($status===true){
			  $msg="Shop deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('shops/shoplist/');
		
	}
	public function shopdetail(){
		 $id=$this->input->post('id');
		 $data['detail']=$this->shops_model->getsingleshop($id);
		 $this->load->view('shops/viewshop',$data);
	}
}
