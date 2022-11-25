<?php
class Units_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function unit_list($where=array()){
		$query=$this->db->get_where("product_units",$where);
		//echo $this->db->last_query();
		if($query->num_rows()>0){
		  $array=$query->result_array();
		}else{
		   $array=false;	
		}
		return $array;
	}
	public function saveUnit($unitdata){
	   $status=$this->db->insert("product_units",$unitdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
	public function single_unit_by_id($id){
	   $query=$this->db->get_where("product_units",array("unit_id"=>$id));	
	   $array=$query->row_array();
	   return $array;
	}
	public function updateUnit($where,$unitdata){
	   $this->db->where('unit_id',$where);
	   $status=$this->db->update("product_units",$unitdata);
	   //echo $this->db->last_query();	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deleteUnit($id){
	   $this->db->where('unit_id',$id);
	   $status=$this->db->delete("product_units");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	
}