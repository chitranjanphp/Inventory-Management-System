<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategory extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('subcategory_model');
		$this->load->model('category_model');
	}
	public function index()
	{
		$data['title']="Sub-Category";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Sub-Category List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['subcategories']=$this->subcategory_model->allsubcategory();
		$categories=$this->category_model->allcategory();
		$options['']="--Select Category--";
		if(is_array($categories)){
		foreach($categories as $cat):
		 $options[$cat['id']]=$cat['category'];
		endforeach;	
		}
		$data['categories']=$options;
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('subcategory/subcategorylist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function addsubcategory(){
	   $this->form_validation->set_rules('category_id','Category','required');
	   $this->form_validation->set_rules('subcategory','Enter Sub-Category','required|is_unique[product_subcategories.subcategory]',array('is_unique'=> '%s already exists.'));
	   if($this->form_validation->run()){
		 $subcategorydata=array(
		   "subcategory"=>$this->input->post('subcategory'),
		   "category_id"=>$this->input->post('category_id')
		 ); 
		 $status=$this->subcategory_model->addsubcategorydata($subcategorydata);
		 if($status===true){
			  $msg="Sub-Category added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('subcategory/');
	  }else{
		  $this->index(); 
		  return; 
	  }	
	}
	public function getsinglesubcategory(){
	   $id=$this->input->post('id');
	   $subcategories=$this->subcategory_model->getsinglesubcategory($id);
	   echo json_encode($subcategories);
	}
	public function updatesubcategory(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('editcategory_id','Category','required');
	   $this->form_validation->set_rules('editsubcategory','Enter Sub-Category','required');
	   if($this->form_validation->run()){
		 $subcategorydata=array(
		   "subcategory"=>$this->input->post('editsubcategory'),
		   "category_id"=>$this->input->post('editcategory_id')
		 );
		// print_r($categorydata);  
		 $status=$this->subcategory_model->updatesubcategory($id,$subcategorydata);
		 if($status===true){
			  $msg="Sub-Category updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('subcategory/');
	  }else{
		  $this->index();  
	  }	
	}
	public function deletesubcategory($id){
		$status=$this->subcategory_model->deletesubcategory($id);
		 if($status===true){
			  $msg="Sub-Category deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('subcategory/');
	}
	public function subcatbycategory(){
	  $category_id=$this->input->post('category_id');
	  $subcategories=$this->subcategory_model->subcatbycategory($category_id);	
	 // print_r($subcategories);
	  $scoptions = "<option value=''>--Select Sub-Category--</option>";
	  if(!empty($subcategories)){
		foreach($subcategories as $subcat):
		 $scoptions .= "<option value='".$subcat['id']."'>".$subcat['subcategory']."</option>";
		endforeach;	
		}
	  echo $scoptions;	
	}
}
