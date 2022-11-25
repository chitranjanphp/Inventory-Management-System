<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		 $this->load->model('Account_model');
		}
	public function index()
	{	
		if($this->session->userdata('user')!==NULL){
			redirect('welcome/');
		}
			$data['title'] = "Login";
			$this->load->view('top_section',$data);
			$this->load->view('login');
			$this->load->view('bottom_section');
	}
	public function validatelogin(){
		$data=$this->input->post();
		unset($data['login']);
		$result=$this->Account_model->login($data);
		if($result['verify']===true){
			$this->startsession($result);
			redirect('welcome/');
			//$this->startsession($result);
		}
		else{ 
			$this->session->set_flashdata('msg',$result['verify']);
			redirect('/');
		}
	}
	
	public function startsession($result){
		$data['user']=md5($result['id']);
		$data['name']=$result['username'];
		$data['role']='admin';
		$this->session->set_userdata($data);
	}
	
	public function logout(){
		if($this->session->userdata('user')!==NULL){
			$data=array("user","name","role");
			$this->session->unset_userdata($data);
		}
		redirect('/');
	}
	
}
