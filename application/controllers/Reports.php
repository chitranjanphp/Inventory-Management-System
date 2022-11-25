<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('reports_model');
		$this->load->model('suppliers_model');
		$this->load->model('shops_model');
		$this->load->model('user_model');
		$this->load->model('customers_model');
	}
	public function index()
	{
		$data['title']="Purchase Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Purchase Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['purchase']=$this->reports_model->purchase_list();
		$data['suppliers'] = $this->suppliers_model->allsuppliers();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/purchase_report');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_purchase(){
	   $supp_id=$this->input->post('suppliers');
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['purchase']=$this->reports_model->purchase_list($supp_id,$from,$to);	
	   $this->load->view('reports/search_purchase',$data);
	}
	public function purchase_cancel()
	{
		$data['title']="Purchase Cancel Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Purchase Cancel Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['purchasecancel']=$this->reports_model->purchase_cancel_list();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/purchase_cancel_report');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_purchase_cancel(){
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['purchasecancel']=$this->reports_model->purchase_cancel_list($from,$to);	
	   $this->load->view('reports/search_purchase_cancel',$data);
	}
    public function view_purchase_product(){
		 $id=$this->input->post('id');
		 $data['pproducts']=$this->reports_model->view_purchase_product($id);
		 $this->load->view('reports/view_purchase_product',$data);
	}
	public function shop_sale(){
		$data['title']="Shop Sale Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Shop Sale Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['shopsale']=$this->reports_model->sale_list();
		$data['shops'] = $this->shops_model->getshops();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/shop_sale');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function user_sale(){
		$data['title']="User Sale Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'User Sale Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['shopsale']=$this->reports_model->sale_list();
		$data['users'] = $this->user_model->userlist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/user_sale');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function customer_sale(){
		$data['title']="Customer Sale Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Customer Sale Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['shopsale']=$this->reports_model->sale_list();
		$data['customers'] = $this->customers_model->customerlist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/customer_sale');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_sale(){
	   $shops=$this->input->post('shops');
	   $users=$this->input->post('users');
	   $customers=$this->input->post('customers');
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['shopsale']=$this->reports_model->sale_list($shops,$from,$to,$users,$customers);	
	   $this->load->view('reports/search_sale',$data);
	}
	public function view_sale_product($id){
		 $data['sproducts']=$this->reports_model->view_sale_product($id);
		 $this->load->view('reports/view_sale_product',$data);
	}
	public function sale_cancel(){
		$data['title']="Sale Cancel Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Sale Cancel Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['salecancel']=$this->reports_model->sale_cancel_list();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/sale_cancel');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_sale_cancel(){
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['salecancel']=$this->reports_model->sale_cancel_list($from,$to);	
	   $this->load->view('reports/search_sale_cancel',$data);
	}
	public function sales_return(){
		$data['title']="Sales Return Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Sales Return Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['salesreturn']=$this->reports_model->sales_return();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/sales_return');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_sales_return(){
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['salesreturn']=$this->reports_model->sales_return($from,$to);	
	   $this->load->view('reports/search_sales_return',$data);
	}
	public function sale_return_product($id){
		 $data['return_product']=$this->reports_model->sale_return_product($id);
		 $this->load->view('reports/sales_return_product',$data);
	}
	public function expense(){
		$data['title']="Expense Report";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Expense Report');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['shops'] = $this->shops_model->getshops();
		$data['expenses']=$this->reports_model->expense();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('reports/expense');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_expense(){
	   $shops=$this->input->post('shops');
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['expenses']=$this->reports_model->expense($shops,$from,$to);	
	   $this->load->view('reports/search_expense',$data);
	}
}
