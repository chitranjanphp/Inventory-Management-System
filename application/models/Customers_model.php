<?php
class Customers_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function addcustomerdata($custdata){
	   $status=$this->db->insert("inv_customers",$custdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function customerlist(){
		$query=$this->db->get_where("inv_customers");
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	public function getsinglecustomer($id){
	   $query=$this->db->get_where("inv_customers",array("cust_id"=>$id));	
	   $array=$query->row_array();
	   if(is_array($array)){
	     return $array;
	   }else{
		  return false;   
	   }
	}
	public function updatecustomerdata($id,$custdata){
	   $this->db->where('cust_id',$id);
	   $status=$this->db->update("inv_customers",$custdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deletecustomer($id){
	   $this->db->where('cust_id',$id);
	   $status=$this->db->delete("inv_customers");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function active_customers($status){
	  $query=$this->db->query("SELECT * 
								FROM inv_customers
								WHERE status=$status");
	  return $query->result_array();	
	}
	
}