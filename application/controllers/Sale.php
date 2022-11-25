<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('user')===NULL){
			redirect('/');
		}
		$this->load->model('sale_model');
		$this->load->model('shops_model');
		$this->load->model('customers_model');
		$this->load->model('stock_in_model');
	}
	public function index()
	{
		$data['title']="Sale Invoice";
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$bottom_script=array("file"=>array("assets/dist/js/sinvoice.js"));
		$data['bottom_script']=$bottom_script;
		$data['froms']=$this->shops_model->getsingleshop($this->session->userdata('shop'));
		//$data['customers']=$this->customers_model->customerlist();
		$data['items']=$this->stock_in_model->my_products();
		//print_r($data);
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Sale Invoice');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('sale/sale_invoice');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
/*********AutoComplete*************/	
	public function custList(){
		// POST data
		$postData = $this->input->post();
		// get data
		$data = $this->sale_model->getCust($postData);
	
		echo json_encode($data);
    }
/*********AutoComplete*************/	
    public function getCustDetail($custid){
	  $data = $this->customers_model->getsinglecustomer($custid); 
	  //$addr = $data['company_name'].",\n".$data['cust_name'].",\n".$data['mobile'].",\n".$data['address'].",\n GST No.: ".$data['gstin'];
	  $custdata=array("to"=>$data['address'],"mobile"=>$data['mobile']);
	  echo json_encode($custdata);
   }
	public function SelProductDetail($barcode){
		$array=$this->sale_model->SelProductDetail($barcode);
		echo json_encode($array);
	}
	public function add_sale_temp(){
	   $this->form_validation->set_rules('barcode','Barcode','required');
	   $this->form_validation->set_rules('items','Select Item','required');
	   $this->form_validation->set_rules('qty','Quantity','required');
	   $this->form_validation->set_rules('price','Price','required|numeric');
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
			$cgst = $this->input->post('cgst');
			$sgst = $this->input->post('sgst');
			$sdata = array(
			   "qty"=>$this->input->post('qty'),
			   "units"=>$this->input->post('iunit'),
			   "price"=>$this->input->post('price'),
			   "user"=>$user,
			   "shop"=>$shop,
			 ); 
			// echo json_encode($sdata);
			$status=$this->sale_model->add_sale_temp($sdata,$items,$cgst,$sgst);
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
	
	public function sale_temp_list(){
		$user=$this->session->userdata('user');
		$shop=$this->session->userdata('shop');
		$data['stempdata']=$this->sale_model->sale_temp_list(array('user'=>$user,'shop'=>$shop));
		$this->load->view('sale/temp_item_list',$data);
		
	}
	public function cal_amount_detail(){
		$user=$this->session->userdata('user');
		$shop=$this->session->userdata('shop');
		$data['amountdetail']=$this->sale_model->cal_amount_detail(array('user'=>$user,'shop'=>$shop));
		$this->load->view('sale/cal_amount_detail',$data);
		
	}
	public function delete_temp($id){
		$status=$this->sale_model->delete_temp($id);
		 if($status===true){
			 $success_msg=array('success'=>'Record deleted successfully.');
			 echo json_encode($success_msg);
		 }else{
			$errors = $status['message'];
			$err_msg=array('error'=>$errors);
			echo json_encode($err_msg); 
		 }
	}
	public function get_adjust_amount(){
		$invoice_no=$this->input->post('invoice_no');
		$data =$this->sale_model->get_adjust_amount($invoice_no);
		echo json_encode($data);
	}
	public function add_sale(){
	   $this->form_validation->set_rules('date','Date','required');
	   $this->form_validation->set_rules('billing_mode','Billing Mode','required');
	   $this->form_validation->set_rules('autocust','Customer Name','required');
	   $this->form_validation->set_rules('mobile','Mobile','required|numeric|min_length[10]|max_length[10]',array("min_length"=>'Mobile No. Minimum 10 Digit!',"max_length"=>'Mobile No. Max 10 Digit!'));
	   $this->form_validation->set_rules('to','Customer Address','required');
	   if($this->form_validation->run()){
		 $year = date('Y');
		 $saledata=array(
		   "date"=> date("Y-m-d",strtotime($this->input->post('date'))),
		   "cust_id"=>$this->input->post('custid'),
		   "prefix"=>$this->session->userdata('acronym')."/".$year."/",
		   "billing_mode"=>$this->input->post('billing_mode'),
		   "customer_name"=>$this->input->post('autocust'),
		   "mobile"=>$this->input->post('mobile'),
		   "address"=>$this->input->post('to'),
		   "adj_invoice"=>$this->input->post('adinvoice_no'),
		   "adj_amount"=>$this->input->post('adjust_amount'),
		   "total"=>$this->input->post('total_amount'),
		   "disc"=>$this->input->post('dpercent'),
		   "disc_val"=>$this->input->post('dvalue'),
		   "user"=>$this->session->userdata('user'),
		   "shop"=>$this->session->userdata('shop'),
		   "istatus"=>1
		 ); 
		 $paydata=array(
		  "date"=>date("Y-m-d",strtotime($this->input->post('date'))),
		  "cust_id"=>$this->input->post('custid'),
		  "paid"=>$this->input->post('paid_amount'),
		  "paymode"=>$this->input->post('paymode'),
		  "refno"=>$this->input->post('refno'),
		  "remarks"=>"Invoice",
	     );
		 
		 $status=$this->sale_model->add_sale($saledata,$paydata);
		 if(is_array($status)){
			  $msg="Sale added successfully.";
			  $this->session->set_flashdata("msg",$msg);
			  redirect('sale/print_preview/'.$status['invoice_id']);
			  //$this->print_invoice($status['invoice_id']);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
			  redirect('sale/');
		  }
	  }else{
		 $this->index();  
	  }	
	}
	public function print_preview($invoice_id){
		$data['title']="Invoice";
		$data['breadcrumb']=array('sale/'=>'Sale Invoice','active'=>'Invoice');
		$data['shop_details']=$this->shops_model->getsingleshop($this->session->userdata('shop'));
		$data['invoice']=$this->sale_model->get_selected_invoice($invoice_id);
		$data['invoice']['atowords']=$this->amount->to_words($data['invoice']['total']);
		$data['products']=$this->sale_model->productlist($invoice_id);
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('sale/print_preview');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function print_invoice($invoice_id){
		$data['shop_details']=$this->shops_model->getsingleshop($this->session->userdata('shop'));
		$data['invoice']=$this->sale_model->get_selected_invoice($invoice_id);
		$data['invoice']['atowords']=$this->amount->to_words($data['invoice']['total']);
		$data['products']=$this->sale_model->productlist($invoice_id);
		$this->load->view('sale/print_invoice',$data);
	}
	public function invoicelist(){
		$data['title']="Invoice List";
		$data['breadcrumb']=array('dashboard'=>'Home','active'=>'Invoice List');
		$styles=array("file"=>array("assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css"));
		$top_script=array("file"=>array("assets/plugins/datatables.net/js/jquery.dataTables.min.js",
										"assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"));
		$data['styles']=$styles;
		$data['top_script']=$top_script;
		$data['invoices']=$this->sale_model->invoicelist();
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('sale/invoicelist');
		$this->load->view('template/footer');
		$this->load->view('template/bottom-section');
	}
	public function search_sale(){
	   $from=$this->input->post('from');	
	   $to=$this->input->post('to');
	   $data['invoices']=$this->sale_model->invoicelist($from,$to);	
	   $this->load->view('sale/search_sale',$data);
	}
	public function productdetail($id){
		 $data['prodetail']=$this->sale_model->productlist($id);
		 $this->load->view('sale/viewproducts',$data);
	}
	public function duepayment($invoice_id){
		$data['title']="Due Payment";
		$data['selinvoice']=$this->sale_model->get_selected_invoice($invoice_id);
		$data['breadcrumb']=array('sale/invoicelist'=>'Invoice List','active'=>'Due Payment');
		$this->load->view('template/top-section',$data);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('sale/duepayment');
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
		  "cust_id"=>$this->input->post('cust_id'),
		  "invoice_id"=>$this->input->post('invoice_id'),
		  "paid"=>$this->input->post('payable'),
		  "paymode"=>$this->input->post('paymode'),
		  "refno"=>$this->input->post('refno'),
		  "remarks"=>"Invoice",
	     );
		 
		 $status=$this->sale_model->add_dues($paydata);
		 if($status===true){
			  $msg="Dues added successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('sale/invoicelist');
	  }else{
		 $this->duepayment($paydata['invoice_id']);  
	  }	
	}
	public function cancel_invoice($id){
		 $canceldata=array("cancel_date"=>date('Y-m-d'),"istatus"=>0,"adj_invoice"=>'',"adj_amount"=>0);
		 $status=$this->sale_model->cancel_invoice($id,$canceldata);
		 if($status===true){
			  $msg="Invoice cancel successfully.";
			  $this->session->set_flashdata("msg",$msg);
		  }else{
			  $err_msg=$status['message'];
			  $this->session->set_flashdata("err_msg",$err_msg);
		  }
		  redirect('sale/invoicelist/');
		
	}
	
	
}
