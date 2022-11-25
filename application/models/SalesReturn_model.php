<?php
class SalesReturn_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function SaleInvoiceIdByInvoiceNo($invoice_no){
	  $query = $this->db->query("SELECT invoice_id
								 FROM sales_order
								 WHERE concat(prefix,invoice_no) = '$invoice_no'");
	  $array=$query->row_array();
	  return $array;	
	}
	public function SaleProductDetail($product_id,$invoice_id){
		$query=$this->db->get_where("sales_detail",array("invoice_id"=>$invoice_id,"product_id"=>$product_id));
		if($query->num_rows()>0){
		  return $query->row_array();
		}
		$this->db->free_result();
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
	public function sales_return_temp($srdata,$items,$invoice_id){
	   $query=$this->db->get_where('inv_products',array('barcode'=>$items));
	  // return $this->db->last_query();
	   $getId=$query->row_array();
	   $srdata['product_id'] = $getId['id'];
	   $query1=$this->db->get_where('sales_detail',array('product_id'=>$srdata['product_id'],'invoice_id'=>$invoice_id));
	   $getDetail=$query1->row_array();
	   $total = $srdata['rqty'] * $getDetail['price'];
	   $srdata['total'] = $total;
	   $srdata['pqty'] = $getDetail['qty'];
	   $srdata['units'] = $getDetail['units'];
	   $srdata['price'] = $getDetail['price'];
			    
	   $cgst_val = $total*($getDetail['cgst_per']/100);
	   $srdata['cgst_per'] = $getDetail['cgst_per'];
	   $srdata['cgst_val'] = $cgst_val;
	   $sgst_val = $total*($getDetail['sgst_per']/100);
	   $srdata['sgst_per'] = $getDetail['sgst_per'];
	   $srdata['sgst_val'] = $sgst_val;
	  
		$taxable = $total + $sgst_val + $cgst_val;
		$srdata['taxable']=$taxable;
		$status=$this->db->insert("sales_return_temp",$srdata);
		
	   if($status===true){
		    return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function sales_return_temp_list($where=array()){
		$this->db->select('t1.*,t2.product_name,t2.hsn_code');
		$this->db->from('sales_return_temp as t1');
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
		$this->db->from('sales_return_temp');
		$this->db->where('user',$where['user']);
		$this->db->where('shop',$where['shop']);
		$query=$this->db->get();
		//echo $this->db->last_query();
		$array=$query->row_array();
		return $array;
	}
	public function delete_temp($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("sales_return_temp");
	   if($status===true){
		    return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
	public function add_sales_return($sreturndata){
	   
	   $status=$this->db->insert("sales_return",$sreturndata);	
	   if($status===true){
		   $selquery=$this->db->get_where("sales_return",array("invoice_id"=>$sreturndata['invoice_id'])); 
		   $getinvoice=$selquery->row_array();
		   $return_id = $getinvoice['return_id'];
		   $query="INSERT INTO `sales_return_detail`(`product_id`, `pqty`, `units`, `price`, `rqty`, `cgst_per`, `sgst_per`, `cgst_val`, `sgst_val`, `total`, `taxable`, `user`, `shop`, `return_id`)
				   SELECT `product_id`, `pqty`, `units`, `price`, `rqty`, `cgst_per`, `sgst_per`, `cgst_val`, `sgst_val`, `total`, `taxable`, `user`, `shop`,'$return_id'
				   FROM `sales_return_temp` WHERE sales_return_temp.user = $sreturndata[user] and sales_return_temp.shop = $sreturndata[shop]";
		   $status1=$this->db->query($query);
		   if($status1===true){
			   $selreturn=$this->db->get_where("sales_return_detail",array("return_id"=>$return_id));
			   if($selreturn->num_rows()>0){
				foreach($selreturn->result_array() as $rows):
				   $stock_in = $this->db->query("CALL stock_in($rows[rqty],$rows[product_id])");
				endforeach;   
			   }
			    $this->db->where("user",$sreturndata["user"]);
			    $this->db->where("shop",$sreturndata["shop"]);
			    $deltemp=$this->db->delete("sales_return_temp");
				 return true;	
		   }else{
			 return $this->db->error();  
		   }
		  
	   }else{
		   return $this->db->error();
	   }
	}
	public function returnlist($from="",$to=""){
		$user=$this->session->userdata('user');
		$role=$this->session->userdata('role');
		$sql="SELECT t1.*, t2.invoice_no
			  FROM sales_return AS t1
			  LEFT OUTER JOIN(select invoice_id, concat(prefix,invoice_no) as invoice_no from sales_order) t2 ON t1.invoice_id=t2.invoice_id WHERE 1";
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
		$query=$this->db->query("CALL sale_return_product($id)");
		return $query->result_array();
	}
	
}