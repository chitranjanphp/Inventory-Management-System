<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('Account_model');
		$this->load->model('shops_model');
	}
	public function index()
	{
		$data['title']="Login";
		//$this->load->view('top-section',$data);
		$this->load->view('login');
		//$this->load->view('bottom-section');
	}
	
	public function validatelogin(){
		$data=$this->input->post();
		unset($data['login']);
		$result=$this->Account_model->login($data);
		if($result['verify']===true){
			$this->startsession($result);
			redirect('dashboard/');
		}
		else{ 
			$this->session->set_flashdata('msg',$result['verify']);
			redirect('/');
		}
	}
	
	public function startsession($result){
		$shopdata=$this->shops_model->getsingleshop($result['shop']);
		$data['user']=$result['id'];
		$data['login_name']=$result['name'];
		$data['login_img']=$result['photo'];
		$data['role']=$result['role'];
		$data['shop']=$result['shop'];
		$data['shop_name']=$shopdata['shop_name'];
		$data['acronym']=$shopdata['acronym'];
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
