<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('units_model');
	}
	public function index()
	{
		$data['title']="Units";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Unit List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['units']=$this->units_model->unit_list();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('units/unit_view');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function saveUnit(){
	   $this->form_validation->set_rules('unit_name','Enter Unit','required|is_unique[product_units.unit_name]',array('is_unique'=> '%s already exists.'));
	   if ($this->form_validation->run() == FALSE){
            $errors = validation_errors();
			$err_msg=array('error'=>$errors);
            echo json_encode($err_msg);
        }else{
		 $unitdata=array(
		   "unit_name"=>$this->input->post('unit_name')
		 ); 
		 $status=$this->units_model->saveUnit($unitdata);
		 $success_msg=array('success'=>'Record added successfully.');
         echo json_encode($success_msg);
		 if($status===true){
			  $msg="Unit added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		 // redirect('units/');
	  }	
	}
	/*public function single_unit_by_id(){
	   $id=$this->input->post('id');
	   $units=$this->units_model->single_unit_by_id($id);
	   echo json_encode($units);
	}*/
	public function edit_unit(){
	  $id=$this->input->post('id');	
	  $data['units']=$this->units_model->single_unit_by_id($id);
	  $this->load->view('units/edit_view',$data);
	}
	public function updateUnit(){
	   $id=$this->input->post('edit_unit_id');
	   $this->form_validation->set_rules('edit_unit_name','Enter Unit','required');
	   if ($this->form_validation->run() == FALSE){
           $this->edit_unit();
		    return; 
        }else{
		 $unitdata=array(
		   "unit_name"=>$this->input->post('edit_unit_name')
		 );
		 $status=$this->units_model->updateUnit($id,$unitdata);
		 if($status===true){
			  $msg="Unit updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('units/');
		}
	}
	public function deleteUnit($id){
		$status=$this->units_model->deleteUnit($id);
		 if($status===true){
			  $msg="Unit deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('units/');
	}
}
