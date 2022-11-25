<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('profile_model');
		$this->load->library('image_lib');
	}
	public function index()
	{
		$data['title']="User profile";
		$loguser=$this->session->userdata('user');
		$data['profile']=$this->profile_model->get_user_profile($loguser);
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Profile');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('profile/profile');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function userdetail($id){
	   $data=$this->profile_model->get_user_profile($id);
	   echo json_encode($data); 
	}
	public function updateprofile(){
	  $user=$this->session->userdata('user');
	  $this->form_validation->set_rules('name','Name','required');
	  $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));	
	   if($this->form_validation->run()){
		 $userdata=array(
		   "name"=>$this->input->post('name'),
		   "mobile"=>$this->input->post('mobile'),
		   "email"=>$this->input->post('email'),
		   "password"=>$this->input->post('password'),
		 ); 
		//print_r($userdata);
		$image=$user;
		//gif|jpg|jpeg|png
		$file="";
			$config['upload_path'] = './assets/users/';
			$config['allowed_types'] = 'jpg|jpeg';
			$config['file_name'] = $image;
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('photo'))
			{
				  $image_data =   $this->upload->data();
				 // print_r($image_data);
				  $config =  array(
					'image_library'   => 'gd2',
					'source_image'    =>  $image_data['full_path'],
					'maintain_ratio'  =>  TRUE,
					'width'           =>  160,
					'height'          =>  160,
				  );
				  $this->image_lib->clear();
				  $this->image_lib->initialize($config);
				  $this->image_lib->resize();
				  $file=$image_data['file_name'];
			}
		
		if($file!=''){ $userdata['photo']=$file;}
		 $status=$this->profile_model->update_profile_data($user,$userdata);
		 if($status===true){
			  $msg="Profile updated successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('profile/');
	  }else{
		  $this->index();  
	  }	
	}
}
