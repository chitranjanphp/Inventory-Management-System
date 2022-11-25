<?php
class Shops_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug=false;
	}
	public function addshopdata($shopdata){
	   $status=$this->db->insert("inv_shops",$shopdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function getshops(){
		$query=$this->db->get_where("inv_shops");
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
	public function getsingleshop($id){
	   $query=$this->db->get_where("inv_shops",array("id"=>$id));	
	   $array=$query->row_array();
	   return $array;
	}
	public function updateshopdata($id,$shopdata){
	   $this->db->where('id',$id);
	   $status=$this->db->update("inv_shops",$shopdata);	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function deleteshop($id){
	   $this->db->where('id',$id);
	   $status=$this->db->delete("inv_shops");	
	   if($status===true){
		   return true;   
	   }else{
		   return $this->db->error();
	   }
	}
	public function activeshops($where=array('status'=>1)){
		$query=$this->db->get_where("inv_shops",$where);
		//echo $this->db->last_query();
		$array=$query->result_array();
		return $array;
	}
		
}