<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('Account_model');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function signup(){
		$this->load->view('test/signup');
	}
	public function register(){
		$data=$this->input->post();
		unset($data['signup']);
		$result=$this->Account_model->register($data);
		print_r($result);
	}
	
	public function login(){
		$this->load->view('test/login');
	}
	
	public function validatelogin(){
		$data=$this->input->post();
		unset($data['login']);
		$result=$this->Account_model->login($data);
		print_r($result);
	}
}
