<?php
class Sale_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function SelProductDetail($barcode){
		$sql="SELECT t1.*,t3.unit_name
			  FROM stock_in AS t1
			  LEFT JOIN inv_products AS t2 ON t1.product_id=t2.id
			  LEFT JOIN product_units AS t3 ON t2.unit_id=t3.unit_id
			  WHERE t1.barcode=$barcode"; 
		$query=$this->db->query($sql);
		return $query->row_array();
	}
/**AutoComplete Data *************/	
	function getCust($postData){
		$response = array();
		$this->db->select('*');
		if($postData['search'] ){
		  // Select record
		  $this->db->where("cust_name like '%".$postData['search']."%' ");
		  $records = $this->db->get('inv_customers')->result();
		  foreach($records as $row ){
			$response[] = array("value"=>$row->cust_id,"label"=>$row->cust_name);
		  }
	 
		}
		return $response;
  	}
	/**AutoComplete Data *************/	
	public function add_sale_temp($sdata,$items,$cgst,$sgst){
	   $query=$this->db->get_where('inv_products',array('barcode'=>$items));
	  // return $this->db->last_query();
	   $prodata=$query->row_array();
	   $sdata['product_id'] = $prodata['id'];
	   $total = $sdata['qty'] * $sdata['price'];
	   $sdata['total'] = $total;
	   $is_exist = $this->db->get_where('sales_temp',array('user'=>$sdata['user'],'shop'=>$sdata['shop'],'product_id'=>$sdata['product_id'])); //check product exist or not
	   
	   if($is_exist->num_rows()==0){
		      
			   $cgst_val = 0;
			   $sgst_val = 0;
			  if($cgst==true){
				   $cgst_val = $total*($prodata['cgst']/100);
				   $sdata['cgst_per'] = $prodata['cgst'];
				   $sdata['cgst_val'] = $cgst_val;
			   }else{
				   $sdata['cgst_per'] = 0;
				   $sdata['cgst_val'] = 0;
			   }
			   if($sgst==true){
				   $sgst_val = $total*($prodata['sgst']/100);
				   $sdata['sgst_per'] = $prodata['sgst'];
				   $sdata['sgst_val'] = $sgst_val;
			   }else{
				   $sdata['sgst_per'] = 0;
				   $sdata['sgst_val'] = 0;
			   }
			   $taxable = $total + $sgst_val + $cgst_val;
			   $sdata['taxable']=$taxable;
			   
	   		   $status=$this->db->insert("sales_temp",$sdata);
			   //echo $this->db->last_query();
	   }else{
			    
			       $tdata = $is_exist->row_array();
				   $cgst_val = $total*($tdata['cgst_per']/100);
				   $sdata['cgst_per'] = $tdata['cgst_per'];
				   $sdata['cgst_val'] = $cgst_val;
				   $sgst_val = $total*($tdata['sgst_per']/100);
				   $sdata['sgst_per'] = $tdata['sgst_per'];
				   $sdata['sgst_val'] = $sgst_val;
			  
			    $taxable = $total + $sgst_val + $cgst_val;
			    $sdata['taxable']=$taxable;
		  	    $status=$this->db->query("UPDATE sales_temp
										  SET qty = qty + $sdata[qty], cgst_val = cgst_val + $sdata[cgst_val], sgst_val = sgst_val + $sdata[sgst_val], total = total + $sdata[total], taxable = taxable + $sdata[taxable]
										  WHERE id=$tdata[id]");
	   }
	   if($status===true){
		    $stock_out = $this->db->query("CALL stock_out($sdata[qty],$sdata[product_id])");
		    return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function sale_temp_list($where=array()){
		$this->db->select('t1.*,t2.product_name,t2.hsn_code');
		$this->db->from('sales_temp as t1');
		$this->db->join('inv_products as t2','t1.product_id=t2.id','left');
		$this->db->where('t1.user',$where['user']);
		$this->db->where('t1.shop',$where['shop']);
		$query=$this->db->get();
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	public function cal_amount_detail($where=array()){
		$this->db->select('sum(total) as gross_amount, (sum(cgst_val)+sum(sgst_val)) as gstval, sum(taxable) as net_amount');
		$this->db->from('sales_temp');
		$this->db->where('user',$where['user']);
		$this->db->where('shop',$where['shop']);
		$query=$this->db->get();
		//echo $this->db->last_query();
		$array=$query->row_array();
		return $array;
	}
	public function delete_temp($id){
	   $query=$this->db->get_where("sales_temp",array("id"=>$id));
	   $prodata=$query->row_array();
	   $this->db->where('id',$id);
	   $status=$this->db->delete("sales_temp");
	   if($status===true){
		    $stock_in = $this->db->query("CALL stock_in($prodata[qty],$prodata[product_id])");
		    return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function get_adjust_amount($invoice_no){
	   $sql="SELECT total
	   		 FROM Sales_return
			 WHERE invoice_id IN (SELECT invoice_id FROM sales_order WHERE concat(prefix,invoice_no)='$invoice_no') and `rstatus`=0";	
	   $query=$this->db->query($sql);
	   if($query->num_rows()>0){
		  return $query->row_array();   
	   }else{
		   $res=array('total'=>0);
		   return $res;   
	   }
	}
	public function add_sale($saledata,$paydata){
		
	   $this->db->select_max('invoice_no');
	   $result = $this->db->get('sales_order')->row();  
	   //echo $this->db->last_query();
	   if( $result->invoice_no==NULL){
		  $invoice_no = 101;   
	   }else{
		   $invoice_no = $result->invoice_no;
		   $invoice_no++;   
	   }
	   $saledata['invoice_no']=$invoice_no;
	   //print_r($saledata);
	   $status=$this->db->insert("sales_order",$saledata);	
	   if($status===true){
		   $selquery=$this->db->get_where("sales_order",array("concat(prefix,invoice_no)"=>$saledata['prefix'].$saledata['invoice_no'])); 
		   $getinvoice=$selquery->row_array();
		   $invoice_id = $getinvoice['invoice_id'];
		   $query="INSERT INTO `sales_detail`(`product_id`, `qty`, `units`, `price`, `cgst_per`, `sgst_per`, `cgst_val`, `sgst_val`, `total`, `taxable`, `user`, `shop`, `invoice_id`)
				   SELECT `product_id`, `qty`, `units`, `price`, `cgst_per`, `sgst_per`, `cgst_val`, `sgst_val`, `total`, `taxable`, `user`, `shop`, '$invoice_id'
                   FROM sales_temp WHERE sales_temp.user = $saledata[user] and sales_temp.shop = $saledata[shop]";
		   $status1=$this->db->query($query);
		   if($status1===true){
			    $this->db->where("user",$saledata["user"]);
			    $this->db->where("shop",$saledata["shop"]);
			    $deltemp=$this->db->delete("sales_temp");
				if($saledata['adj_amount']!=0){
				  $getinv_id= $this->SaleInvoiceIdByInvoiceNo($saledata['adj_invoice']);
				  $this->db->where("invoice_id",$getinv_id['invoice_id']);
				  $updateadjust=$this->db->update("sales_return",array("rstatus"=>1));
				}
			    if($paydata['paid']!=''){
				  $paydata['invoice_id']=$invoice_id;
				  $addpayment=$this->db->insert("customer_payment",$paydata);	
				}
				$returndata=array('invoice_id'=>$invoice_id);
				return $returndata;  
		   }else{
			 return $this->db->error();  
		   }
		  
	   }else{
		   return $this->db->error();
	   }
	}
	public function SaleInvoiceIdByInvoiceNo($invoice_no){
	  $query = $this->db->query("SELECT invoice_id
								 FROM sales_order
								 WHERE concat(prefix,invoice_no) = '$invoice_no'");
	  $array=$query->row_array();
	  return $array;	
	}
	public function invoicelist($from="",$to=""){
		$user=$this->session->userdata('user');
		$role=$this->session->userdata('role');
		$sql="SELECT t1.*, t2.paid
			  FROM sales_order AS t1
			  LEFT OUTER JOIN(select invoice_id, SUM(paid) as paid from customer_payment group by invoice_id) t2 ON t1.invoice_id=t2.invoice_id
			  WHERE t1.istatus=1";
		if($role!='Admin'){
		    $sql.=" AND t1.user=$user";
		 }
		if($from!='' && $to==''){ $from=$to=$from;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
		elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
		elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	public function productlist($id){
		$query=$this->db->query("SELECT t1.*, t2.product_name, t2.hsn_code 
							     FROM sales_detail AS t1
								 LEFT JOIN inv_products AS t2 ON t1.product_id=t2.id
								 WHERE t1.invoice_id = $id;");
		return $query->result_array();
	}
	
	public function get_selected_invoice($invoice_id){
		$query=$this->db->query("SELECT t1.*, SUM(t2.paid) AS paid, t2.paymode
								FROM sales_order AS t1
								LEFT JOIN customer_payment t2 ON t1.invoice_id=t2.invoice_id
								WHERE t1.invoice_id=$invoice_id;");
		return $query->row_array();
	}
	
	public function add_dues($paydata){
	  $status=$this->db->insert('customer_payment',$paydata);
	  if($status===true){
		return true;  
	  }else{
		return $this->db->error();  
	  }	
	}
	
	public function cancel_invoice($id,$canceldata){
	   $adjquery=$this->db->get_where("sales_order",array("invoice_id"=>$id));
	   $adjdata=$adjquery->row_array();
	   if($adjdata['adj_amount']!=0){
		 $inv_query=$this->db->query("select invoice_id from sales_order where concat(prefix,invoice_no)='$adjdata[adj_invoice]'");
		 $getId=$inv_query->row_array();
		 $this->db->where("invoice_id",$getId['invoice_id']);  
		 $update_return=$this->db->update('sales_return',array("rstatus"=>0));  
	   }
	   $this->db->where("invoice_id",$id);
	   $status=$this->db->update("sales_order",$canceldata);	
	   if($status===true){
		 $query=$this->db->get_where("sales_detail",array('invoice_id'=>$id)); 
		 $array=$query->result_array();
		 foreach($array as $rows):
		   $stock_in_query=$this->db->query("update stock_in set qty = qty + $rows[qty] where product_id=$rows[product_id]");
		 endforeach;
		 $this->db->where("invoice_id",$id);
	     $delstatus=$this->db->delete("customer_payment");
		return true;	  
	   }else{
		  return $this->db->error();   
	   }
	}
}