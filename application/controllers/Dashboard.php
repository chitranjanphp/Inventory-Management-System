<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('dashboard_model');
	}
	public function index()
	{
		$data['title']="Dashboard";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Dashboard');
		$suppliers=$this->dashboard_model->TotalSupplier();
		$data['total_suppliers'] = $suppliers['totalcount'];
		$customers=$this->dashboard_model->TotalCustomer();
		$data['total_customers'] = $customers['totalcount'];
		$today=date('Y-m-d');
		$totpurchase=$this->dashboard_model->TotalPurchase($today);
		$data['total_purchase'] = $totpurchase['total'];
		$totsale=$this->dashboard_model->TotalSale($today);
		$data['total_sale'] = $totsale['total'];
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('dashboard/dashboard');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
}
