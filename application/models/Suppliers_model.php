<?php
class Suppliers_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function addsupplierdata($supppdata){
	   $status=$this->db->insert("inv_suppliers",$supppdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function allsuppliers($where=array()){
		$query=$this->db->get_where("inv_suppliers",$where);
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	public function getsinglesupplier($id){
	   $query=$this->db->get_where("inv_suppliers",array("supp_id"=>$id));	
	   $array=$query->row_array();
	   if(is_array($array)){
	     return $array;
	   }else{
		  return false;   
	   }
	}
	public function updatesupplierdata($id,$supplierdata){
	   $this->db->where('supp_id',$id);
	   $status=$this->db->update("inv_suppliers",$supplierdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deletesupplier($id){
	   $this->db->where('supp_id',$id);
	   $status=$this->db->delete("inv_suppliers");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function active_suppliers($status){
	  $query=$this->db->query("SELECT * 
								FROM inv_suppliers
								WHERE status=$status");
	  return $query->result_array();	
	}
	
}