<?php
class Dashboard_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function TotalSupplier(){
		$query=$this->db->query("SELECT COUNT(supp_id) as totalcount
								 FROM inv_suppliers;");
		return $query->row_array();
	}
	public function TotalCustomer(){
		$query=$this->db->query("SELECT COUNT(cust_id) as totalcount
								 FROM inv_customers;");
		return $query->row_array();
	}
	public function TotalPurchase($date){
		$query=$this->db->query("SELECT SUM(total) as total
								 FROM purchase_order
								 WHERE date='$date';");
		return $query->row_array();
	}
	public function TotalSale($date){
	    $user=$this->session->userdata('user');
		$query=$this->db->query("SELECT SUM(total) as total
								 FROM sales_order
								 WHERE date='$date' and user='$user';");
		return $query->row_array();
	}
}