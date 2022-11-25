<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesReturn extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('salesreturn_model');
		$this->load->model('shops_model');
		$this->load->model('customers_model');
		$this->load->model('products_model');
		$this->load->model('stock_in_model');
	}
	public function index()
	{
		$data['title']="Sales Return";
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$bottom_script=array("file"=>array("assets/dist/js/srinvoice.js"));
		$data['bottom_script']=$bottom_script;
		$data['froms']=$this->shops_model->getsingleshop($this->session->userdata('shop'));
		//$data['customers']=$this->customers_model->customerlist();
		$data['items']=$this->stock_in_model->my_products();
		//print_r($data);
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Sales Return');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('salesreturn/return_invoice');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
/*********AutoComplete*************/	
	public function custList(){
		// POST data
		$postData = $this->input->post();
		// get data
		$data = $this->salesreturn_model->getCust($postData);
	
		echo json_encode($data);
    }
/*********AutoComplete*************/	

    public function getCustDetail($custid){
	  $data = $this->customers_model->getsinglecustomer($custid); 
	  //$addr = $data['company_name'].",\n".$data['cust_name'].",\n".$data['mobile'].",\n".$data['address'].",\n GST No.: ".$data['gstin'];
	  $custdata=array("to"=>$data['address'],"mobile"=>$data['mobile']);
	  echo json_encode($custdata);
   }
   
   public function SaleInvoiceIdByInvoiceNo(){
	 $invoice_no = $this->input->post('invoice_no');
	 $getinvoice = $this->salesreturn_model->SaleInvoiceIdByInvoiceNo($invoice_no);
	 echo json_encode($getinvoice); 
   }
   
	public function SaleProductDetail(){
		$barcode=$this->input->post('barcode');
		$invoice_id=$this->input->post('invoice_id');
		$getId=$this->products_model->getProductIdByBarcode($barcode);
		//echo $getId['product_id'];
	     $array = $this->salesreturn_model->SaleProductDetail($getId['product_id'],$invoice_id);
		 echo json_encode($array);
	}
	
	public function sales_return_temp($invoice_id){
	   $this->form_validation->set_rules('barcode','Barcode','required');
	   $this->form_validation->set_rules('items','Select Item','required');
	   $this->form_validation->set_rules('rqty','Return Quantity','required|numeric');
	   //$this->form_validation->set_rules('price','Price','required|numeric');
	   //$this->form_validation->set_rules('cgst','CGST','required');
	   //$this->form_validation->set_rules('sgst','SGST','required');
	   if ($this->form_validation->run() == FALSE){
            $errors = validation_errors();
			$err_msg=array('error'=>$errors);
            echo json_encode($err_msg);
        }else{
			$user = $this->session->userdata('user');
		    $shop = $this->session->userdata('shop');
			$items = $this->input->post('items');
			$srdata = array(
			   "rqty"=>$this->input->post('rqty'),
			   "user"=>$user,
			   "shop"=>$shop,
			 ); 
			// echo json_encode($sdata);
			$status=$this->salesreturn_model->sales_return_temp($srdata,$items,$invoice_id);
			 if($status===true){
				 $success_msg=array('success'=>'Record added successfully.');
				 echo json_encode($success_msg);
			 }else{
				$errors = $status['message'];
				$err_msg=array('error'=>$errors);
				echo json_encode($err_msg); 
			 }
        }
	}
	
	public function return_temp_list(){
		$user=$this->session->userdata('user');
		$shop=$this->session->userdata('shop');
		$data['srtempdata']=$this->salesreturn_model->sales_return_temp_list(array('user'=>$user,'shop'=>$shop));
		$this->load->view('salesreturn/rtemp_item_list',$data);
		
	}
	
	public function cal_amount_detail(){
		$user=$this->session->userdata('user');
		$shop=$this->session->userdata('shop');
		$data['amountdetail']=$this->salesreturn_model->cal_amount_detail(array('user'=>$user,'shop'=>$shop));
		$this->load->view('salesreturn/cal_amount_detail',$data);
		
	}
	
	public function delete_temp($id){
		$status=$this->salesreturn_model->delete_temp($id);
		 if($status===true){
			 $success_msg=array('success'=>'Record deleted successfully.');
			 echo json_encode($success_msg);
		 }else{
			$errors = $status['message'];
			$err_msg=array('error'=>$errors);
			echo json_encode($err_msg); 
		 }
	}
	
	public function add_sales_return(){
	   $this->form_validation->set_rules('date','Date','required');
	   $this->form_validation->set_rules('billing_mode','Billing Mode','required');
	   $this->form_validation->set_rules('autocust','Customer Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   $this->form_validation->set_rules('to','Customer Address','required');
	   $this->form_validation->set_rules('invoice_no','Invoice No.','required');
	   if($this->form_validation->run()){
		 $year = date('Y');
		 $sreturndata=array(
		   "invoice_id"=>$this->input->post('invoice_id'),
		   "date"=> date("Y-m-d",strtotime($this->input->post('date'))),
		   "cust_id"=>$this->input->post('custid'),
		   "billing_mode"=>$this->input->post('billing_mode'),
		   "customer_name"=>$this->input->post('autocust'),
		   "mobile"=>$this->input->post('mobile'),
		   "address"=>$this->input->post('to'),
		   "total"=>$this->input->post('total_amount'),
		   "user"=>$this->session->userdata('user'),
		   "shop"=>$this->session->userdata('shop'),
		 ); 
		
		 $status=$this->salesreturn_model->add_sales_return($sreturndata);
		 if($status===true){
			  $msg="Sales return successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('salesreturn/');
	  }else{
		 $this->index();  
	  }	
	}
	
	public function returnlist(){
		$data['title']="Sales Return List";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Sales Return List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['invoices']=$this->salesreturn_model->returnlist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('salesreturn/return_list');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_return(){
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['invoices']=$this->salesreturn_model->returnlist($from,$to);	
	   $this->load->view('salesreturn/search_return',$data);
	}
	public function productdetail($id){
		 $data['prodetail']=$this->salesreturn_model->productlist($id);
		 $this->load->view('salesreturn/viewproducts',$data);
	}
	
	
}
