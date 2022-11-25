<?php
class Purchase_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function add_purchase_temp($pdata,$items,$cgst,$sgst){
	   $query=$this->db->get_where('inv_products',array('barcode'=>$items));
	  // return $this->db->last_query();
	   $prodata=$query->row_array();
	   $pdata['product_id'] = $prodata['id'];
	   $is_exist = $this->db->get_where('purchase_temp',array('user'=>$pdata['user'],'shop'=>$pdata['shop'],'product_id'=>$pdata['product_id']));
	   if($is_exist->num_rows()==0){
		       $total = $pdata['qty'] * $pdata['purchase_price'];
	           $pdata['total'] = $total;
		       $cgst_val = 0;
			   $sgst_val = 0;
			  if($cgst==true){
				   $cgst_val = $total*($prodata['cgst']/100);
				   $pdata['cgst_per'] = $prodata['cgst'];
				   $pdata['cgst_val'] = $cgst_val;
			   }else{
				   $pdata['cgst_per'] = 0;
				   $pdata['cgst_val'] = 0;
			   }
			   if($sgst==true){
				   $sgst_val = $total*($prodata['sgst']/100);
				   $pdata['sgst_per'] = $prodata['sgst'];
				   $pdata['sgst_val'] = $sgst_val;
			   }else{
				   $pdata['sgst_per'] = 0;
				   $pdata['sgst_val'] = 0;
			   }
			   $taxable = $total + $sgst_val + $cgst_val;
			   $pdata['taxable']=$taxable;
			   
	   		   $status=$this->db->insert("purchase_temp",$pdata);
			
	   }else{
		           $tdata = $is_exist->row_array();
				   $total = $pdata['qty'] * $tdata['purchase_price'];
	               $pdata['total'] = $total;
				   $cgst_val = $total*($tdata['cgst_per']/100);
				   $pdata['cgst_per'] = $tdata['cgst_per'];
				   $pdata['cgst_val'] = $cgst_val;
				   $sgst_val = $total*($tdata['sgst_per']/100);
				   $pdata['sgst_per'] = $tdata['sgst_per'];
				   $pdata['sgst_val'] = $sgst_val;
			  
			       $taxable = $total + $sgst_val + $cgst_val;
			       $pdata['taxable']=$taxable;
		           $status=$this->db->query("UPDATE purchase_temp
		   							         SET qty = qty + $pdata[qty], cgst_val = cgst_val + $pdata[cgst_val], sgst_val = sgst_val + $pdata[sgst_val], total = total + $pdata[total], taxable = taxable + $pdata[taxable]
									         WHERE id = $tdata[id]");
	   }
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function purchase_temp_list($where=array()){
		$this->db->select('t1.*,t2.product_name,t2.hsn_code');
		$this->db->from('purchase_temp as t1');
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
		$this->db->from('purchase_temp');
		$this->db->where('user',$where['user']);
		$this->db->where('shop',$where['shop']);
		$query=$this->db->get();
		//echo $this->db->last_query();
		$array=$query->row_array();
		return $array;
	}
	public function delete_temp($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("purchase_temp");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
	public function add_purchase($purchasedata,$paydata){
	   $status=$this->db->insert("purchase_order",$purchasedata);	
	   if($status===true){
		   $selquery=$this->db->get_where("purchase_order",array("invoice_no"=>$purchasedata['invoice_no'],"supp_id"=>$purchasedata['supp_id'],"date"=>$purchasedata['date'])); 
		   $getinvoice=$selquery->row_array();
		   $invoice_id = $getinvoice['invoice_id'];
		   $query="INSERT INTO `purchase_detail`(`product_id`, `qty`, `units`, `purchase_price`, `sale_price`, `cgst_per`, `sgst_per`, `cgst_val`, `sgst_val`, `total`, `taxable`, `user`, `shop`, `invoice_id`)
				   SELECT `product_id`, `qty`, `units`, `purchase_price`, `sale_price`, `cgst_per`, `sgst_per`, `cgst_val`, `sgst_val`, `total`, `taxable`, `user`, `shop`,'$invoice_id'
                   FROM purchase_temp WHERE purchase_temp.user = $purchasedata[user] and purchase_temp.shop = $purchasedata[shop]";
		   $status1=$this->db->query($query);
		   if($status1===true){
			    $this->db->where("user",$purchasedata["user"]);
			    $this->db->where("shop",$purchasedata["shop"]);
			    $deltemp=$this->db->delete("purchase_temp");
			   /*********Stock In***************/
			      $selproduct=$this->db->get_where("purchase_detail",array("invoice_id"=>$invoice_id));
				  $parray=$selproduct->result_array();
					 if(!empty($parray)){
						foreach($parray as $rows):
						  $bcquery=$this->db->get_where("inv_products",array("id"=>$rows['product_id']));
						  $getbarcode=$bcquery->row_array();
						  $checkpro=$this->db->query("SELECT * FROM `stock_in` WHERE product_id='$rows[product_id]'");
						  if($checkpro->num_rows()==0){
							  $in_sock=$this->db->insert("stock_in",array("product_id"=>$rows['product_id'],"barcode"=>$getbarcode['barcode'],"qty"=>$rows['qty'],"purchase_price"=>$rows['purchase_price'],"sale_price"=>$rows['sale_price']));
						  }else{
							  $up_stock=$this->db->query("update stock_in set qty = qty+$rows[qty], purchase_price=$rows[purchase_price], sale_price=$rows[sale_price] where product_id=$rows[product_id]");  
						  }
						endforeach; 
					 }
				/*********End Stock In***************/	 
			    if($paydata['paid']!=''){
				  $paydata['invoice_id']=$invoice_id;
				  $status2=$this->db->insert("supplier_payment",$paydata);	
				  if($status2===true){
					return true;  
				  }else{
					return $this->db->error();  
				  }
				}else{
				   return true;	
				}
		   }else{
			 return $this->db->error();  
		   }
		  
	   }else{
		   return $this->db->error();
	   }
	}
	public function invoicelist(){
		$sql="SELECT t1.*,t2.supplier_name,t2.mobile,t3.paid
			  FROM purchase_order AS t1
			  LEFT JOIN inv_suppliers AS t2 ON t1.supp_id=t2.supp_id
			  LEFT OUTER JOIN (select invoice_id, SUM(paid) as paid from supplier_payment group by invoice_id) t3 ON t1.invoice_id=t3.invoice_id
			  WHERE t1.istatus=1"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function productlist($id){
		$sql="SELECT t1.*,t2.product_name,t2.hsn_code
			  FROM purchase_detail AS t1
			  LEFT JOIN inv_products AS t2 ON t1.product_id=t2.id
			  WHERE t1.invoice_id=$id"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function get_selected_invoice($invoice_id){
		$query=$this->db->query("CALL purchase_selected_invoice($invoice_id)");
		return $query->row_array();
	}
	public function add_dues($paydata){
	  $status=$this->db->insert('supplier_payment',$paydata);
	  if($status===true){
		return true;  
	  }else{
		return $this->db->error();  
	  }	
	}
	public function cancel_invoice($id,$canceldata){
	   $this->db->where("invoice_id",$id);
	   $status=$this->db->update("purchase_order",$canceldata);	
	   if($status===true){
		 $query=$this->db->get_where("purchase_detail",array('invoice_id'=>$id)); 
		 $array=$query->result_array();
		 foreach($array as $rows):
		   $sin_query=$this->db->query("update stock_in set qty = qty-$rows[qty] where product_id=$rows[product_id]");
		 endforeach;
		 $this->db->where("invoice_id",$id);
	     $delstatus=$this->db->delete("supplier_payment");
		return true;	  
	   }else{
		  return $this->db->error();   
	   }
	}
}