<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('products_model');
		$this->load->model('category_model');
		$this->load->model('subcategory_model');
		$this->load->model('units_model');
	}
	public function index()
	{
		$data['title']="Products";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Product List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['products']=$this->products_model->productlist();
		$categories=$this->category_model->allcategory();
		$data['categories']=$categories;
		$units=$this->units_model->unit_list();
		$data['units']=$units;
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('products/product_view');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function addproduct(){
	   $this->form_validation->set_rules('category_id','Category','required');
	   $this->form_validation->set_rules('subcategory_id','Sub-Category','required');
	   $this->form_validation->set_rules('product_name','Enter Product Name','required|is_unique[inv_products.product_name]',array('is_unique'=> '%s already exists.'));
	   $this->form_validation->set_rules('unit_id','Unit','required');
	   $this->form_validation->set_rules('hsn_code','HSN Code','required');
	   $this->form_validation->set_rules('cgst','CGST(%)','required|numeric');
	   $this->form_validation->set_rules('sgst','SGST(%)','required|numeric');
	   if ($this->form_validation->run() == FALSE){
            $errors = validation_errors();
			$err_msg=array('error'=>$errors);
            echo json_encode($err_msg);
        }else{
			if(!empty($this->input->post('barcode')) && $this->input->post('barcode')!=''){
			  $barcode = $this->input->post('barcode');	
			}else{
				$barcode = rand(0000000,9999999);
			}
			$productdata=array(
			   "product_name"=>$this->input->post('product_name'),
			   "category_id"=>$this->input->post('category_id'),
			   "subcategory_id"=>$this->input->post('subcategory_id'),
			   "unit_id"=>$this->input->post('unit_id'),
			   "hsn_code"=>$this->input->post('hsn_code'),
			   "barcode"=>$barcode,
			   "cgst"=>$this->input->post('cgst'),
			   "sgst"=>$this->input->post('sgst'),
			 ); 
			 $status=$this->products_model->saveproduct($productdata);
		   	 $success_msg=array('success'=>'Record added successfully.');
           	 echo json_encode($success_msg);
			 if($status===true){
			  $msg="Product added successfully.";
			  $this->session->set_flashdata("msg",$msg);
			  }else{
				  $err_msg=$status['message'];
				  $this->session->set_flashdata("err_msg",$err_msg);
			  }
			 //redirect('products/');
        }
	}
	public function editproduct(){
		$id=$this->input->post('id');
		$products=$this->products_model->getsingleproduct($id);
		$data['products']=$products;
		$categories=$this->category_model->allcategory();
		$catoptions['']="--Select Category--";
		if(is_array($categories)){
		foreach($categories as $cat):
		 $catoptions[$cat['id']]=$cat['category'];
		endforeach;	
		}
		$data['categories']=$catoptions;
		$category_id = $products['category_id'];
		$subcategories=$this->subcategory_model->subcatbycategory($category_id);	
	  // print_r($subcategories);
	  	$scoptions[''] = "--Select Sub-Category--";
	  	if(!empty($subcategories)){
			foreach($subcategories as $subcat):
			 $scoptions[$subcat['id']]=$subcat['subcategory'];
			endforeach;	
		}
	  	$data['subcategories']=$scoptions;	
		$data['units']=$this->units_model->unit_list();
		//print_r($data);
		$this->load->view('products/edit_view',$data);
	}
	public function getsingleproduct(){
	   $id=$this->input->post('id');
	   $products=$this->products_model->getsingleproduct($id);
	   echo json_encode($products);
	}
	public function updateproduct(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('editcategory_id','Category','required');
	   $this->form_validation->set_rules('editsubcategory_id','Sub-Category','required');
	   $this->form_validation->set_rules('editproduct_name','Enter Product Name','required');
	   $this->form_validation->set_rules('unit_id','Unit','required');
	   $this->form_validation->set_rules('hsn_code','HSN Code','required');
	   $this->form_validation->set_rules('barcode','Barcode','required');
	   $this->form_validation->set_rules('cgst','CGST(%)','required|numeric');
	   $this->form_validation->set_rules('sgst','SGST(%)','required|numeric');
	   if($this->form_validation->run()){
		 $productdata=array(
		   "product_name"=>$this->input->post('editproduct_name'),
		   "category_id"=>$this->input->post('editcategory_id'),
		   "subcategory_id"=>$this->input->post('editsubcategory_id'),
		   "unit_id"=>$this->input->post('unit_id'),
		   "hsn_code"=>$this->input->post('hsn_code'),
		   "barcode"=>$this->input->post('barcode'),
		   "cgst"=>$this->input->post('cgst'),
		   "sgst"=>$this->input->post('sgst'),
		 );
		// print_r($categorydata);  
		 $status=$this->products_model->updateproduct($id,$productdata);
		 if($status===true){
			  $msg="Product updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
	  }
	   redirect('products/');
	}
	public function deleteproduct($id){
		$status=$this->products_model->deleteproduct($id);
		 if($status===true){
			  $msg="Product deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('products/');
	}
	public function UOM(){
		$barcode=$this->input->post('barcode');	
		$array=$this->products_model->UOM($barcode);
		echo json_encode($array);
	}
}
