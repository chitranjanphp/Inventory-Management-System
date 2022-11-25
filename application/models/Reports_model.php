<?php
class Reports_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function purchase_list($supp_id='',$from='',$to=''){
		$sql="SELECT t1.*,t2.supplier_name,t2.mobile,t3.paid
			  FROM purchase_order AS t1
			  LEFT JOIN inv_suppliers AS t2 ON t1.supp_id=t2.supp_id
			  LEFT OUTER JOIN (select invoice_id, SUM(paid) as paid from supplier_payment group by invoice_id) t3 ON t1.invoice_id=t3.invoice_id
			  WHERE t1.istatus=1"; 
	     if($supp_id!=''){$sql.=" AND t1.supp_id=$supp_id";}
		 if($from!='' && $to==''){ $from=$to=$from;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
		 elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
		 elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function purchase_cancel_list($from='',$to=''){
		$sql="SELECT t1.*,t2.supplier_name,t2.mobile,t3.paid
			  FROM purchase_order AS t1
			  LEFT JOIN inv_suppliers AS t2 ON t1.supp_id=t2.supp_id
			  LEFT OUTER JOIN (select invoice_id, SUM(paid) as paid from supplier_payment group by invoice_id) t3 ON t1.invoice_id=t3.invoice_id
			  WHERE t1.istatus=0"; 
		 if($from!='' && $to==''){ $from=$to=$from;$sql.=" AND t1.cancel_date BETWEEN '$from' AND '$to'";}
		 elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" AND t1.cancel_date BETWEEN '$from' AND '$to'";}
		 elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" AND t1.cancel_date BETWEEN '$from' AND '$to'";}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function view_purchase_product($id){
		$sql="SELECT t1.*,t2.product_name,t2.hsn_code
			  FROM purchase_detail AS t1
			  LEFT JOIN inv_products AS t2 ON t1.product_id=t2.id
			  WHERE t1.invoice_id=$id"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function sale_list($shops='',$from='',$to='',$users='',$customers=''){
		  $sql="SELECT t1.*, t2.paid
			    FROM sales_order AS t1
			    LEFT OUTER JOIN(select invoice_id, SUM(paid) as paid from customer_payment group by invoice_id) t2 ON t1.invoice_id=t2.invoice_id
			    WHERE t1.istatus=1";
				if($shops!=''){$sql.=" AND t1.shop=$shops";}
				if($users!=''){$sql.=" AND t1.user=$users";}
				if($customers!=''){$sql.=" AND t1.cust_id=$customers";}
				if($from!='' && $to==''){ $from=$to=$from;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
				elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
			    elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" AND t1.date BETWEEN '$from' AND '$to'";}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function sale_cancel_list($from='',$to=''){
		  $sql="SELECT t1.*, t2.paid
			    FROM sales_order AS t1
			    LEFT OUTER JOIN(select invoice_id, SUM(paid) as paid from customer_payment group by invoice_id) t2 ON t1.invoice_id=t2.invoice_id
			    WHERE t1.istatus=0";
				if($from!='' && $to==''){ $from=$to=$from;$sql.=" AND t1.cancel_date BETWEEN '$from' AND '$to'";}
				elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" AND t1.cancel_date BETWEEN '$from' AND '$to'";}
			    elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" AND t1.cancel_date BETWEEN '$from' AND '$to'";}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function view_sale_product($id){
		$query=$this->db->query("SELECT t1.*, t2.product_name, t2.hsn_code 
							     FROM sales_detail AS t1
								 LEFT JOIN inv_products AS t2 ON t1.product_id=t2.id
								 WHERE t1.invoice_id = $id;");
		return $query->result_array();
	}
	public function sales_return($from='',$to=''){
		   $sql="SELECT t1.*, t2.invoice_no
			     FROM sales_return AS t1
			     LEFT OUTER JOIN(select invoice_id, concat(prefix,invoice_no) as invoice_no from sales_order) t2 ON t1.invoice_id=t2.invoice_id";
				if($from!='' && $to==''){ $from=$to=$from;$sql.=" WHERE t1.date BETWEEN '$from' AND '$to'";}
				elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" WHERE t1.date BETWEEN '$from' AND '$to'";}
			    elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" WHERE t1.date BETWEEN '$from' AND '$to'";}
		  $query=$this->db->query($sql);
		 
		return $query->result_array();
	}
	public function sale_return_product($id){
		$query=$this->db->query("CALL sale_return_product($id)");
		return $query->result_array();
	}
	public function expense($shops='',$from='',$to=''){
		        $sql="SELECT * FROM expenses WHERE 1";
				if($shops!=''){$sql.=" AND shop=$shops";}
				if($from!='' && $to==''){ $from=$to=$from;$sql.=" AND date BETWEEN '$from' AND '$to'";}
				elseif($from=='' && $to!=''){ $from=$to=$to;$sql.=" AND date BETWEEN '$from' AND '$to'";}
			    elseif($from!='' && $to!=''){ $from=$from;$to=$to;$sql.=" AND date BETWEEN '$from' AND '$to'";}
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
}