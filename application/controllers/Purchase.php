<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('purchase_model');
		$this->load->model('suppliers_model');
		$this->load->model('products_model');
	}
	public function index()
	{
		$data['title']="Purchase Invoice";
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$bottom_script=array("file"=>array("assets/dist/js/pinvoice.js"));
		$data['bottom_script']=$bottom_script;
		
		$data['suppliers']=$this->suppliers_model->active_suppliers(1);
		$data['items']=$this->products_model->productlist();
		//print_r($data);
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Purchase Invoice');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('purchase/purchase_invoice');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function add_purchase_temp(){
	   $this->form_validation->set_rules('barcode','Barcode','required');
	   $this->form_validation->set_rules('items','Select Item','required');
	   $this->form_validation->set_rules('quantity','Quantity','required');
	   $this->form_validation->set_rules('pprice','Purchase Price','required|numeric');
	   $this->form_validation->set_rules('sprice','Sale Price','required|numeric');
	   //$this->form_validation->set_rules('cgst','CGST','required');
	   //$this->form_validation->set_rules('sgst','SGST','required');
	   if ($this->form_validation->run() == FALSE){
            $errors = validation_errors();
			$err_msg=array('error'=>$errors);
            echo json_encode($err_msg);
        }else{
			$user=$this->session->userdata('user');
		    $shop=$this->session->userdata('shop');
			$items=$this->input->post('items');
			$cgst=$this->input->post('cgst');
			$sgst=$this->input->post('sgst');
			$pdata=array(
			   "qty"=>$this->input->post('quantity'),
			   "units"=>$this->input->post('iunit'),
			   "purchase_price"=>$this->input->post('pprice'),
			   "sale_price"=>$this->input->post('sprice'),
			   "user"=>$user,
			   "shop"=>$shop,
			 ); 
			 //echo json_encode($pdata);
			$status=$this->purchase_model->add_purchase_temp($pdata,$items,$cgst,$sgst);
			 if($status===true){
				 $success_msg=array('success'=>'Record added successfully.');
				 echo json_encode($success_msg);
			 }else{
				$errors = $status;
				$err_msg=array('error'=>$errors);
				echo json_encode($err_msg); 
			 }
        }
	}
	public function price_check($val)
    {
        if (!is_int($val) || !is_float($val) ) {
            $this->form_validation->set_message('price_check', 'The {field} field must be number or decimal.');
            return false;
        } else {
            return true;
        }
    }
	public function purchase_temp_list(){
		$user=$this->session->userdata('user');
		$shop=$this->session->userdata('shop');
		$data['ptempdata']=$this->purchase_model->purchase_temp_list(array('user'=>$user,'shop'=>$shop));
		$this->load->view('purchase/temp_item_list',$data);
		
	}
	public function cal_amount_detail(){
		$user=$this->session->userdata('user');
		$shop=$this->session->userdata('shop');
		$data['amountdetail']=$this->purchase_model->cal_amount_detail(array('user'=>$user,'shop'=>$shop));
		$this->load->view('purchase/cal_amount_detail',$data);
		
	}
	public function delete_temp($id){
		$status=$this->purchase_model->delete_temp($id);
		 if($status===true){
			 $success_msg=array('success'=>'Record deleted successfully.');
			 echo json_encode($success_msg);
		 }else{
			$errors = $status;
			$err_msg=array('error'=>$errors);
			echo json_encode($err_msg); 
		 }
	}
	public function add_purchase(){
	   $this->form_validation->set_rules('date','Date','required');
	   //$this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   $this->form_validation->set_rules('billing_mode','Billing Mode','required');
	   $this->form_validation->set_rules('supp_id','Supplier','required');
	   $this->form_validation->set_rules('invoice_no','Invoice No.','required');
	   if($this->form_validation->run()){
		 $purchasedata=array(
		   "date"=> date("Y-m-d",strtotime($this->input->post('date'))),
		   "supp_id"=>$this->input->post('supp_id'),
		   "invoice_no"=>$this->input->post('invoice_no'),
		   "billing_mode"=>$this->input->post('billing_mode'),
		   "total"=>$this->input->post('total_amount'),
		   "disc"=>$this->input->post('dpercent'),
		   "disc_val"=>$this->input->post('dvalue'),
		   "user"=>$this->session->userdata('user'),
		   "shop"=>$this->session->userdata('shop'),
		   "istatus"=>1
		 ); 
		 $paydata=array(
		  "date"=>date("Y-m-d",strtotime($this->input->post('date'))),
		  "supp_id"=>$this->input->post('supp_id'),
		  "paid"=>$this->input->post('paid_amount'),
		  "paymode"=>$this->input->post('paymode'),
		  "refno"=>$this->input->post('refno'),
		  "remarks"=>"Invoice",
	     );
		 
		 $status=$this->purchase_model->add_purchase($purchasedata,$paydata);
		 if($status===true){
			  $msg="Purchase added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('purchase/');
	  }else{
		  $this->index();  
	  }	
	}
	public function invoicelist(){
		$data['title']="Invoice List";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Invoice List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['invoices']=$this->purchase_model->invoicelist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('purchase/invoicelist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function productdetail(){
		 $id=$this->input->post('id');
		 $data['prodetail']=$this->purchase_model->productlist($id);
		 $this->load->view('purchase/viewproducts',$data);
	}
	public function duepayment($invoice_id){
		$data['title']="Due Payment";
		$data['selinvoice']=$this->purchase_model->get_selected_invoice($invoice_id);
		$data['breadcrumb']=array('sale/invoicelist'=>'Invoice List','active'=>'Due Payment');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('purchase/duepayment');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function paydues(){
	   $this->form_validation->set_rules('dop','Date of payment','required');
	   $this->form_validation->set_rules('payable','Payable Amount','required|numeric');
	   $this->form_validation->set_rules('paymode','Payment mode','required');
	   if($this->form_validation->run()){
		 $paydata=array(
		  "date"=>date("Y-m-d",strtotime($this->input->post('dop'))),
		  "supp_id"=>$this->input->post('supp_id'),
		  "invoice_id"=>$this->input->post('invoice_id'),
		  "paid"=>$this->input->post('payable'),
		  "paymode"=>$this->input->post('paymode'),
		  "refno"=>$this->input->post('refno'),
		  "remarks"=>"Invoice",
	     );
		 
		 $status=$this->purchase_model->add_dues($paydata);
		 if($status===true){
			  $msg="Dues added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('purchase/invoicelist');
	  }else{
		 $this->duepayment($paydata['invoice_id']);  
	  }	
	}
	public function cancel_invoice($id){
		 $canceldata=array("cancel_date"=>date('Y-m-d'),"istatus"=>0);
		 $status=$this->purchase_model->cancel_invoice($id,$canceldata);
		 if($status===true){
			  $msg="Invoice cancel successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('purchase/invoicelist/');
		
	}
	
	
}
