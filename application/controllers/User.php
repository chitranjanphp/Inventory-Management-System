<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('user_model');
		$this->load->model('shops_model');
	}
	public function index()
	{
		$data['title']="Add User";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Add User');
		$data['shops']=$this->shops_model->activeshops();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('users/adduser');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function adduser(){
	   $this->form_validation->set_rules('name','Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]|is_unique[inv_users.mobile]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!','is_unique'=> '%s already exists.'));
	   //$this->form_validation->set_rules('email','Email','required|valid_email');
	   $this->form_validation->set_rules('username','Username','required|is_unique[inv_users.username]',array('is_unique'=> '%s already exists.'));
	   $this->form_validation->set_rules('password','Password','required');
	   $this->form_validation->set_rules('cpassword','Confirmed Password','required|matches[password]',array('match'=>'Password Misssmatch!'));
	   $this->form_validation->set_rules('shop','Shop','required');
	   if($this->form_validation->run()){
		 $userdata=array(
		   "name"=>$this->input->post('name'),
		   "mobile"=>$this->input->post('mobile'),
		   "email"=>$this->input->post('email'),
		   "username"=>$this->input->post('username'),
		   "password"=>$this->input->post('password'),
		   "role"=>"User",
		   "shop"=>$this->input->post('shop')
		 ); 
		 $status=$this->user_model->adduserdata($userdata);
		 if($status===true){
			  $msg="User added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('user/');
	  }else{
		  $this->index();  
	  }	
	}
	public function userlist(){
		$data['title']="User List";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'User List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['users']=$this->user_model->userlist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('users/userlist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function edituser($id)
	{
		$data['title']="Edit User";
		$data['shops']=$this->shops_model->activeshops();
		$data['edituser']=$this->user_model->getsingleuser($id);
		$data['breadcrumb']=array('user/userlist/'=>'User List','active'=>'Edit User');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('users/edituser');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function updateuser(){
	   $id=$this->input->post('id');
	   $this->form_validation->set_rules('name','Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   //$this->form_validation->set_rules('email','Email','required|valid_email');
	   //$this->form_validation->set_rules('username','Username','required|is_unique[inv_users.username]',array('is_unique'=> '%s already exists.'));
	   $this->form_validation->set_rules('password','Password','required');
	   //$this->form_validation->set_rules('cpassword','Confirmed Password','required|matches[password]',array('match'=>'Password Misssmatch!'));
	   $this->form_validation->set_rules('shop','Shop','required');
	   if($this->form_validation->run()){
		$userdata=array(
		   "name"=>$this->input->post('name'),
		   "mobile"=>$this->input->post('mobile'),
		   "email"=>$this->input->post('email'),
		   "password"=>$this->input->post('password'),
		   "shop"=>$this->input->post('shop')
		 );
		 $status=$this->user_model->updateuserdata($id,$userdata);
		 if($status===true){
			  $msg="User updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('user/userlist/');
	  }else{
		  $this->edituser($id);  
	  }	
	}
	public function deleteuser($id){
		 $status=$this->user_model->deleteuser($id);
		 if($status===true){
			  $msg="User deleted successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('user/userlist/');
		
	}
	public function userdetail($id){
		 $data['detail']=$this->user_model->getsingleuser($id);
		 $this->load->view('users/viewuser',$data);
	}
}
